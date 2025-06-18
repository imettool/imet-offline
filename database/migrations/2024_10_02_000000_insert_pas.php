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

use ImetCore\Models\ProtectedArea;
use App\Helpers\ProtectedAreaUpdater;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // get contents of a file into a string
        $filename = database_path(ProtectedAreaUpdater::CSV_MIGRATION_PATH);

        // Check if the file exists (only in development environment)
        if (file_exists($filename)) {

            // Open and read the CSV file
            $data = [];
            $handle = fopen($filename, "r");
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = array_combine($header, $row);
            }

            // Split the data into chunks
            $data = array_chunk($data, 100);

            // Upsert data into the database
            foreach ($data as $chunk) {
                ProtectedArea::upsert($chunk, ['global_id'], ProtectedAreaUpdater::MIGRATION_ATTRIBUTES);
            }

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table((new ProtectedArea)->getTable())->truncate();
    }
};
