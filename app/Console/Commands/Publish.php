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

use Illuminate\Console\Command;
use Native\Electron\Commands\PublishCommand;


class Publish extends Command
{

    protected $signature = 'imet:publish';

    protected $description = 'Publish a new release of the IMET offline application to GitHub';

    public function handle(): int
    {
        // Ensure a clean development environment
        $this->call(ResetDevEnv::class);

        // Publish a new release to GitHub using NativePHP
        $this->call(PublishCommand::class, [
            'os' => 'win',
            'arch' => 'x64'
        ]);
        return 0;
    }

}
