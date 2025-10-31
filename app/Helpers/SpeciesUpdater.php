<?php
/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Helpers;

use App\Events\TaskProgressing;
use ImetCore\Models\Species;

/**
 * Class SpeciesUpdater
 * This class is responsible for updating species and vernacular names from CSV files (expected to be located in the database path).
 * The CSV are generated from panospolis/catalogue-of-life-species-extractor script which extracts species from the Catalogue of Life
 */
class SpeciesUpdater
{
    private const string CSV_SPECIES_PATH = 'species.csv';

    private const string CSV_NAMES_PATH = 'vernacular_names.csv';

    private const array CSV_SPECIES_ATTRIBUTES = [
        'col_id',
        'species',
        'genus',
        'family',
        'order',
        'class',
        'phylum',
        'kingdom',
        'authorship',
        'environment'
    ];

    private const array CSV_NAMES_ATTRIBUTES = [
        'vernacular_names_eng',
        'vernacular_names_spa',
        'vernacular_names_por',
        'vernacular_names_fra',
        'vernacular_names_rus',
        'vernacular_names_deu',
        'vernacular_names_ita',
        'vernacular_names_jpn',
        'vernacular_names_zho',
        'vernacular_names_kor'
    ];

    const int CHUNK_SIZE = 300;

    const string JOB_LOG_PREFIX = '## SpeciesUpdater ## : ';

    /**
     * Update species and vernacular names from CSV files.
     */
    public static function insertSpeciesAndVernacularNames(string $jobId, bool $verbose = false): void
    {
        event(new TaskProgressing($jobId, 1));

        // Upsert species data from CSV
        self::upsertSpeciesFromCSV($jobId, $verbose);

        // Update vernacular names from CSV
        self::updateVernacularNamesFromCSV($jobId, $verbose);

        // Remove all records where species and genus and family are null
        OfflineLog::info("Removing records with null species, genus and family", $verbose);
        Species::query()->whereNull('species')
            ->whereNull('genus')
            ->whereNull('family')
            ->delete();

        OfflineLog::info("Species and vernacular names updated successfully.", $verbose);
    }

    private static function upsertSpeciesFromCSV(string $jobId, bool $verbose = false): void
    {
        $filepath = database_path(self::CSV_SPECIES_PATH);
        if(file_exists($filepath)) {

            OfflineLog::info("Upserting species from CSV file: " . $filepath, $verbose);

            // Upsert species data in chucks using a generator
            $generator = new CSVReader($filepath);
            foreach ($generator->rows(self::CHUNK_SIZE) as $idx => $chunk) {

                // Upsert the current chunk into the database
                Species::query()->upsert(
                    values: $chunk,
                    uniqueBy: ['col_id'],
                    update: self::CSV_SPECIES_ATTRIBUTES);

                // Update job progress
                $partial_progress = intval((($idx + 1) * self::CHUNK_SIZE / $generator->num_rows) * 100);
                $total_progress = ($partial_progress/100*50); // CSV parsing takes 50% of the job progress
                event(new TaskProgressing($jobId, $total_progress));
            }

        } else {
            OfflineLog::error("CSV file for species not found: " . $filepath, $verbose);
        }

    }

    private static function updateVernacularNamesFromCSV(string $jobId, bool $verbose = false): void
    {
        $filepath = database_path(self::CSV_NAMES_PATH);
        if(file_exists($filepath)) {

            OfflineLog::info("Updating vernacular names from CSV file: " . $filepath, $verbose);

            // Update vernacular names using a generator
            $generator = new CSVReader($filepath);
            foreach ($generator->rows(self::CHUNK_SIZE) as $idx => $chunk) {

                // Upsert the current chunk into the database
                Species::query()->upsert(
                    values: $chunk,
                    uniqueBy: ['col_id'],
                    update: self::CSV_NAMES_ATTRIBUTES);

                // Update job progress
                $partial_progress = intval((($idx + 1) * self::CHUNK_SIZE / $generator->num_rows) * 100);
                $total_progress = ($partial_progress/100*50) + 50; // CSV parsing takes 50% of the job progress, starting from 50%
                event(new TaskProgressing($jobId, $total_progress));
            }

        } else {
            OfflineLog::info("CSV file for vernacular names not found: " . $filepath, $verbose);
        }

    }

}
