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

use App\Jobs\UpdateSpecies as UpdateSpeciesJob;
use Illuminate\Console\Command;

class UpdateSpecies extends Command
{

    protected $signature = 'imet:update_species';

    protected $description = 'Update species from Catalogue of Life CSV file';

    public function handle(): int
    {
        $verbose = $this->option('verbose'); // Check if the verbose option is set (already available in Laravel's Command class)
        UpdateSpeciesJob::dispatchSync($verbose);
        return 0;
    }
}
