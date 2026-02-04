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
use Exception;
use ImetCore\Helpers\ProtectedPlanetCSV;
use ImetCore\Models\ProtectedArea;
use Throwable;
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
     *
     * @throws Throwable
     */
    public static function updateProtectedAreasAndOECMs(string $zipFilePath, string $originalFilename, string $jobId, bool $verbose = false): void
    {
        OfflineLog::info(self::LOG_PREFIX.'Processing Protected Areas and OECMs dataset ...', $verbose);

        // Extract the CSV file from the ZIP archive
        event(new TaskProgressing($jobId, 2));
        $csvFilePath = ProtectedPlanetCSV::extractZip($zipFilePath);
        event(new TaskProgressing($jobId, 10));     // Update progress after extraction (takes 10% of the job progress)

        // Parse the CSV file and update the database
        ProtectedPlanetCSV::parseCSVFile($csvFilePath, function($progress_status) use ($jobId){
            event(new TaskProgressing($jobId, $progress_status));
        });

        event(new TaskProgressing($jobId, 100));    // Force progress to 100% at the end of the job
    }

}
