<?php

namespace App\Listeners;

use App\Jobs\InitializeOfflineTool;
use Log;
use Native\Laravel\Events\App\ApplicationBooted;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        InitializeOfflineTool::dispatch();
        Log::info('Application booted successfully.');
    }

}
