<?php

use AndreaMarelli\ImetCore\Models\ProtectedArea;
use App\Models\ProtectedAreaUpdate;
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
        $filename = database_path(ProtectedAreaUpdate::CSV_MIGRATION_PATH);

        // Open and read the CSV file
        $data = [];
        $handle = fopen($filename, "r");
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = array_combine($header, $row);
        }

        // Upsert data into the database
        ProtectedArea::upsert($data, ['global_id'], ProtectedAreaUpdate::MIGRATION_ATTRIBUTES);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('imet_pas')->truncate();
    }
};
