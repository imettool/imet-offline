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

namespace App\Listeners;

use App\Jobs\InitializeOfflineTool;
use App\Models\JobProgress;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Log;
use Native\Laravel\Events\App\ApplicationBooted;
use Native\Laravel\Facades\AutoUpdater;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        // Log the application booted event
        Log::info('Application booted successfully.');

        // First boot: onetime modifications
        if(App::environment('production')) {
            InitializeOfflineTool::dispatchSync();
        }

        // Perform some cleaning
        JobProgress::truncate();
        DB::table('failed_jobs')->delete();
        DB::table('job_batches')->delete();
        DB::table('jobs')->delete();

        // Check for updates
        if(App::environment('production')) {
            AutoUpdater::checkForUpdates();
        }

    }

}
