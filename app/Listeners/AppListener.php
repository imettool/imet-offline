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

namespace App\Listeners;

use App\Helpers\ImetEnv;
use App\Jobs\InitializeOfflineTool;
use Illuminate\Support\Facades\App;
use Log;
use Native\Desktop\Events\App\ApplicationBooted;
use Native\Desktop\Facades\AutoUpdater;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        // Log the application booted event
        Log::info('Booting application...');
        Log::info('Current version: '.ImetEnv::getVersion());

        // First boot: onetime modifications
        if (App::environment('production')) {
            Log::info('Checking if one-time configurations are needed...');
            dispatch_sync(new InitializeOfflineTool);
        }

        Log::info('Application booted successfully.');

        // Check for updates
        if (App::environment('production')) {
            AutoUpdater::checkForUpdates();
        }

    }
}
