<?php
/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

namespace App\Helpers;

use App\Events\TaskProgressing;
use Exception;
use ImetCore\Models\ProtectedArea;
use ZipArchive;

/**
 * Class ProtectedAreaUpdaterCSV
 * This class is responsible for updating protected areas from CSV files downloaded from ProtectedPlanet website.
 */
class ProtectedAreaUpdaterCSV
{
    const string ALL_REGEX = '/WDPA_WDOECM_([a-zA-Z]{3}[\d]{4})_Public_all_csv/';
    const string WDPA_REGEX = '/WDPA_([a-zA-Z]{3}[\d]{4})_Public_csv/';
    const string OECM_REGEX = '/WDOECM_([a-zA-Z]{3}[\d]{4})_Public_csv/';
    const int CHUNK_SIZE = 200;
    const string OFAC_GLOBAL_IDS_FILE = 'ofac_global_ids.csv';

    const string LOG_PREFIX = '## ProtectedAreaUpdaterCSV ## : ';

    /**
     * Update protected areas and OECMs from CSV files.
     * @throws Exception
     */
    public static function updateProtectedAreasAndOECMs(string $zipFilePath, string $originalFilename, string $jobId, bool $verbose = false): void
    {
        if(preg_match(self::ALL_REGEX, $originalFilename)){
            OfflineLog::info( self::LOG_PREFIX . "Processing Protected Areas and OECMs dataset ...", $verbose);
        } elseif(preg_match(self::WDPA_REGEX, $originalFilename)){
            OfflineLog::info(self::LOG_PREFIX . "Processing Protected Areas dataset ...", $verbose);
        } elseif(preg_match(self::OECM_REGEX, $originalFilename)){
            OfflineLog::info(self::LOG_PREFIX . "Processing OECMs dataset ...", $verbose);
        } else {
            OfflineLog::error(self::LOG_PREFIX . "Filename does not match expected patterns: " . $originalFilename, $verbose);
            throw new Exception("Filename does not match expected patterns: " . $originalFilename);
        }

        // Extract the CSV file from the ZIP archive
        TaskProgressing::dispatch($jobId, 2);
        $csvFilePath = self::extractCSVfromZIP($zipFilePath, $originalFilename, $verbose);
        TaskProgressing::dispatch($jobId, 10);     // Update progress after extraction (takes 10% of the job progress)

        // Parse the CSV file and update the database
        self::parseFile($csvFilePath, $jobId, $verbose);

        // Apply OFAC global IDs
        self::applyOfacGlobalIDs($jobId, $verbose);
        TaskProgressing::dispatch($jobId, 100);    // Force progress to 100% at the end of the job
    }

    /**
     * Extract the CSV file from the ZIP archive.
     * @throws Exception
     */
    private static function extractCSVfromZIP(string $zipFilePath, string $originalFilename, bool $verbose = false): string
    {
        $base_name = basename($originalFilename, '.zip');
        $destination_path = storage_path('app/temp/');
        $destination_file = $destination_path . $base_name . '.csv';

        // Unzip the file
        $zip = new ZipArchive();
        $zipStatus = $zip->open($zipFilePath, ZipArchive::RDONLY);
        if ($zipStatus !== true) {
            throw new Exception(self::LOG_PREFIX . 'Unable to open the archive: ' . $zipFilePath);
        }
        $zip->extractTo($destination_path, [$base_name . '.csv']);
        $zip->close();

        // Check if the CSV file was extracted successfully
        if(!file_exists($destination_file)){
            $message = self::LOG_PREFIX . 'Unable to extract the CSV file from the archive: ' . $zipFilePath;
            OfflineLog::error($message, $verbose);
            throw new Exception($message);
        }

        return $destination_file;
    }

    /**
     * Parse the CSV file extracted from the ZIP archive.
     * @throws Exception
     */
    private static function parseFile(string $csvFilePath, string $jobId, bool $verbose = false): void
    {
        $generator = new CSVReader($csvFilePath);
        foreach ($generator->rows(self::CHUNK_SIZE) as $idx => $chunk) {

            // Prepare the chunk for upsert
            $chunk = collect($chunk)->map(function ($item) {
                return [
                    'global_id' => $item['ISO3'] !== null && $item['WDPAID'] !== null
                        ? $item['ISO3'] . '_' . $item['WDPAID']
                        : null,
                    'country' => $item['ISO3'] ?? null,
                    'wdpa_id' => $item['WDPAID'] ?? null,
                    'name' => $item['NAME'] ?? null,
                    'iucn_category' => $item['IUCN_CAT'] ?? null,
                    'creation_date' => $item['STATUS_YR'] ?? null,
                    'perimeter' => $item['REP_AREA'] ?? null,
                    'area' => $item['GIS_AREA'] ?? null,
                    'shape_index' => $item['GIS_M_AREA'] ?? null,
                ];
            })->toArray();

            try{
                // Upsert the current chunk into the database
                ProtectedArea::upsert(
                    $chunk,
                    ['global_id']
                );

                // Update job progress
                $partial_progress = intval((($idx + 1) * self::CHUNK_SIZE / $generator->num_rows) * 100);
                $total_progress = ($partial_progress/100*80) + 10; // CSV parsing takes 80% of the job progress, starting from 10%
                TaskProgressing::dispatch($jobId, $total_progress);

            } catch (Exception $e) {
                OfflineLog::error(self::LOG_PREFIX . 'Error while upserting protected areas from CSV file', $verbose);
            }
        }

    }

    /**
     * Apply OFAC global IDs: still needed for import old IMET JSONs (which still using global_id instead of wdpa_id)
     */
    private static function applyOfacGlobalIDs(string $jobId, bool $verbose = false): void
    {
        $filepath = database_path(self::OFAC_GLOBAL_IDS_FILE);

        OfflineLog::info(self::LOG_PREFIX . "Applying OFAC global IDs from CSV file: " . $filepath, $verbose);

        $generator = new CSVReader($filepath);
        foreach ($generator->rows(self::CHUNK_SIZE) as $idx => $chunk) {
            foreach ($chunk as $row) {

                // Overwrite the global_id
                $pa = ProtectedArea::where('wdpa_id', $row['wdpa_id'])->first();
                if($pa !== null){
                    $pa->global_id = $row['global_id'];
                    $pa->save();
                }

                // Update job progress
                $partial_progress = intval((($idx + 1) * self::CHUNK_SIZE / $generator->num_rows) * 100);
                $total_progress = ($partial_progress/100*10) + 90; // OFAC application takes 10% of the job progress, starting from 90%
                TaskProgressing::dispatch($jobId, $total_progress);
            }
        }

    }

}
