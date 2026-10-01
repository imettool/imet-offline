<?php

use App\Models\User;

return [

    // Models class references: allow overriding default models
    'user' => User::class,

    // Routes' prefixes
    'web_routes_prefix' => null,
    'api_routes_prefix' => null,

    // CSV sample files: populate protected areas and species tables with data from CSVs if provided
    'csv_sample_files' => [
        'protected_areas' => env('CSV_PROTECTED_AREAS_SAMPLE_FILE'),
        'species' => env('CSV_SPECIES_SAMPLE_FILE'),
        'vernacular_names' => env('CSV_VERNACULAR_NAMES_SAMPLE_FILE'),
    ],

];
