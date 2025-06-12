<?php

namespace App\Listeners;

use App\Jobs\InitializeOfflineTool;
use Illuminate\Support\Facades\App;
use Log;
use Native\Laravel\Events\App\ApplicationBooted;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        if(App::environment('production')) {
            InitializeOfflineTool::dispatch();
        }
        Log::info('Application booted successfully.');
    }

}
