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
use ImetCore\Helpers\SpeciesUpdater as CoreSpeciesUpdater;
use ImetCore\Models\Species;

/**
 * Class SpeciesUpdater
 * This class is responsible for updating species and vernacular names from CSV files (expected to be located in the database path).
 * The CSV are generated from panospolis/catalogue-of-life-species-extractor script which extracts species from the Catalogue of Life
 *
 * Override ImetCore\Helpers\SpeciesUpdater
 */
class SpeciesUpdater extends CoreSpeciesUpdater
{

    protected static function logInfo(string $message, bool $verbose = false): void
    {
        OfflineLog::info($message, $verbose);
    }

    protected static function logError(string $message, bool $verbose = false): void
    {
        OfflineLog::error($message, $verbose);
    }

    protected static function dispatchEvent($jobId, int $progress): void
    {
        event(new TaskProgressing($jobId, $progress));
    }

}
