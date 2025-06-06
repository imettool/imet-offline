<?php

namespace App\Listeners;

use App\Events\BootEvent;
use Log;
use Native\Laravel\Events\App\ApplicationBooted;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        Log::info('Application booted successfully.');

        event(new BootEvent());
    }

}
