<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use Log;
use Native\Laravel\Events\App\ApplicationBooted;

class AppListener
{
    public function handle(ApplicationBooted $event): void
    {
        // Force debug mode in the .env file
        $env_path = app_path() . '/../.env';
        $env_content = file_get_contents($env_path);
        $env_content = Str::replace('LOG_LEVEL=warning', 'LOG_LEVEL=debug', $env_content);
        file_put_contents($env_path, $env_content);

        Log::warning('Application booted successfully.');
    }

}
