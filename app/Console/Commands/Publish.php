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

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Native\Desktop\Drivers\Electron\Commands\PublishCommand;

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
