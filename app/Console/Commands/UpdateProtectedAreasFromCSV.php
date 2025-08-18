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

namespace App\Console\Commands;

use App\Jobs\UpdateProtectedAreas;
use Illuminate\Console\Command;

class UpdateProtectedAreasFromCSV extends Command
{

    protected $signature = 'imet:update_protected_areas_from_csv';

    protected $description = 'Update protected areas and OECMs from CSV files downloaded from ProtectedPlanet website';

    public function handle(): int
    {
        $verbose = $this->option('verbose'); // Check if the verbose option is set (already available in Laravel's Command class)
        UpdateProtectedAreas::dispatchSync($verbose);
        return 0;
    }
}
