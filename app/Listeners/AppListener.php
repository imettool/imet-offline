<?php

namespace App\Listeners;

use App\Jobs\InitializeOfflineTool;
use Illuminate\Support\Facades\App;
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

        // Check for updates
        if(App::environment('production')) {
            AutoUpdater::checkForUpdates();
        }

    }

}
