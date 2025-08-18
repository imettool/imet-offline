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

    /**
     * Update species and vernacular names from CSV files.
     *
     * @param bool $verbose
     */
    public static function updateSpeciesAndVernacularNames(bool $verbose = false): void
    {
        // Upsert species data from CSV
        static::upsertSpeciesFromCSV($verbose);

        // Update vernacular names from CSV
        static::updateVernacularNamesFromCSV($verbose);

        // Remove all records where species and genus and family are null
        Species::whereNull('species')
            ->whereNull('genus')
            ->whereNull('family')
            ->delete();

        if($verbose) {
            print("Species and vernacular names updated successfully.\n");
        }
    }

    private static function upsertSpeciesFromCSV(bool $verbose = false): void
    {
        $filepath = database_path(static::CSV_SPECIES_PATH);
        if(file_exists($filepath)) {

            if($verbose) {
                print("\nUpserting species from CSV file: " . $filepath . "\n");
            }

            // Upsert species data in chucks using a generator
            $generator = new CSVReader($filepath);
            foreach ($generator->rows(self::CHUNK_SIZE) as $chunk) {

                Species::upsert(
                    values: $chunk,
                    uniqueBy: ['col_id'],
                    update: static::CSV_SPECIES_ATTRIBUTES);

                if($verbose) {
                    print("Parsed " . $generator->row_index . "/" . $generator->num_rows . " species.\n");
                }

            }

        } else {
            if($verbose) {
                print("\nCSV file for species not found: " . $filepath . "\n");
            }
        }

    }

    private static function updateVernacularNamesFromCSV(bool $verbose = false): void
    {
        $filepath = database_path(static::CSV_NAMES_PATH);
        if(file_exists($filepath)) {

            if($verbose) {
                print("\nUpdating vernacular names from CSV file: " . $filepath . "\n");
            }

            // Update vernacular names using a generator
            $generator = new CSVReader($filepath);
            foreach ($generator->rows(self::CHUNK_SIZE) as $idx => $chunk) {

                Species::upsert(
                    values: $chunk,
                    uniqueBy: ['col_id'],
                    update: static::CSV_NAMES_ATTRIBUTES);

                if($verbose) {
                    print("Parsed " . $generator->row_index . "/" . $generator->num_rows . " vernacular names.\n");
                }

            }

        } else {
            if($verbose) {
                print("\nCSV file for vernacular names not found: " . $filepath . "\n");
            }
        }

    }

}
