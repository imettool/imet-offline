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

    /**
     * Update protected areas and OECMs from CSV files.
     * @throws Exception
     */
    public static function updateProtectedAreasAndOECMs(array $zip_files = [], bool $verbose = false): void
    {

        // If there is the file with both protected areas and OECM, we can skip the others
        $file = preg_grep(self::ALL_REGEX, $zip_files);
        if(!empty($file)){
            if($verbose){
                print("Processing Protected Areas and OECMs dataset..." . PHP_EOL);
            }
            self::parseFile(reset($file), $verbose);
            self::applyOfacGlobalIDs($verbose);
            return;
        }

        // If there is no file with both protected areas and OECMs, we can process the files separately
        foreach ($zip_files as $file) {
            if($verbose){
                if(preg_match(self::WDPA_REGEX, $file)){
                    print("Processing Protected Areas dataset..." . PHP_EOL);
                } elseif(preg_match(self::OECM_REGEX, $file)){
                    print("Processing OECMs dataset..." . PHP_EOL);
                }
            }
            self::parseFile($file, $verbose);
            self::applyOfacGlobalIDs($verbose);
        }
    }

    /**
     * Parse the CSV file extracted from the ZIP archive.
     * @throws Exception
     */
    private static function parseFile(string $file, bool $verbose = false): void
    {
        $base_name = basename($file, '.zip');
        Zip::extract($file, storage_path('app/' . $base_name), false, true);
        $csv_file = storage_path('app/' . $base_name . '/' . $base_name . '.csv');
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
                    ProtectedArea::upsert(
                        $chunk,
                        ['global_id']
                    );

                    if($verbose){
                        print("Upsert executed: chunk " . $idx . PHP_EOL);
                    }

                } catch (Exception $e) {
                     Log::error(
                        'Error while upserting protected areas from CSV file: ' . $csv_file . PHP_EOL .
                        'Chunk index: ' . $idx . PHP_EOL .
                        'Error message: ' . $e->getMessage());
                }
            }
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

        if($verbose){
            print("Applying OFAC global IDs from CSV file: " . $filepath . PHP_EOL);
        }

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

}
