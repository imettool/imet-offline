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

use App\Models\JobProgress;
use Exception;
use Illuminate\Support\Facades\Log;
use ImetCore\Models\ProtectedArea;
use ModularForms\Helpers\File\Zip;

/**
 * Class ProtectedAreaUpdaterCSV
 * This class is responsible for updating protected areas from CSV files downloaded from ProtectedPlanet website.
 */
class ProtectedAreaUpdaterCSV
{
    const string ALL_REGEX = '/WDPA_WDOECM_([a-zA-Z]{3}[\d]{4})_Public_all_csv/';
    const string WDPA_REGEX = '/WDPA_([a-zA-Z]{3}[\d]{4})_Public_csv/';
    const string OECM_REGEX = '/WDOECM_([a-zA-Z]{3}[\d]{4})_Public_csv/';
    const int CHUNK_SIZE = 300;
    const string OFAC_GLOBAL_IDS_FILE = 'ofac_global_ids.csv';

    const int LOG_TYPE_INFO = 1;
    const int LOG_TYPE_ERROR = 2;
    const int LOG_TYPE_DEBUG = 3;

    /**
     * Update protected areas and OECMs from CSV files.
     * @throws Exception
     */
    public static function updateProtectedAreasAndOECMs(string $zipFilePath, string $originalFilename, string $jobId, bool $verbose = false): void
    {
        if(preg_match(self::ALL_REGEX, $originalFilename)){
            static::log("Processing Protected Areas and OECMs dataset ...", $verbose);
        } elseif(preg_match(self::WDPA_REGEX, $originalFilename)){
            static::log("Processing Protected Areas dataset ...", $verbose);
        } elseif(preg_match(self::OECM_REGEX, $originalFilename)){
            static::log("Processing OECMs dataset ...", $verbose);
        }

        JobProgress::updateJobProgress($jobId);
        self::parseFile($zipFilePath, $originalFilename, $jobId, $verbose);
        self::applyOfacGlobalIDs($verbose);
    }

    /**
     * Parse the CSV file extracted from the ZIP archive.
     * @throws Exception
     */
    private static function parseFile(string $zipFilePath, string $originalFilename,  string $jobId, bool $verbose = false): void
    {
        $base_name = basename($originalFilename, '.zip');
        Zip::extract($zipFilePath, storage_path('app/' . $base_name), false, true);
        $csv_file = storage_path('app/' . $base_name . '/' . basename($originalFilename, '.zip') . '.csv');
        if(file_exists($csv_file)){
            $generator = new CSVReader($csv_file);
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
                    $progress = intval((($idx + 1) * self::CHUNK_SIZE / $generator->num_rows) * 100);
                    JobProgress::updateJobProgress($jobId, $progress);

                } catch (Exception $e) {
                     static::log('Error while upserting protected areas from CSV file', $verbose, self::LOG_TYPE_ERROR);
                }
            }
        } else {
            static::log('CSV file not found in the extracted ZIP archive (' . $csv_file . ')', $verbose, self::LOG_TYPE_ERROR);
            throw new Exception("CSV file not found in the extracted ZIP archive: " . $csv_file);
        }
    }

    /**
     * Apply OFAC global IDs: still needed for import old IMET JSONs (which still using global_id instead of wdpa_id)
     * @param bool $verbose
     * @return void
     */
    private static function applyOfacGlobalIDs(bool $verbose = false): void
    {
        $filepath = database_path(self::OFAC_GLOBAL_IDS_FILE);

        static::log("Applying OFAC global IDs from CSV file: " . $filepath, $verbose);

        $generator = new CSVReader($filepath);
        foreach ($generator->rows(self::CHUNK_SIZE) as $chunk) {
            foreach ($chunk as $row) {
                $pa = ProtectedArea::where('wdpa_id', $row['wdpa_id'])->first();
                if($pa !== null){
                    $pa->global_id = $row['global_id'];
                    $pa->save();
                }
            }
        }

    }

    /**
     * Log messages to both console (if verbose) and log file.
     */
    private static function log(string $message, bool $verbose, int $type = self::LOG_TYPE_INFO): void
    {
        if($verbose){
            print($message . PHP_EOL);
        }
        if($type === self::LOG_TYPE_INFO) {
            Log::info($message);
        } else if($type === self::LOG_TYPE_ERROR) {
            Log::error($message);
        } else if($type === self::LOG_TYPE_DEBUG) {
            Log::debug($message);
        }
    }

}
