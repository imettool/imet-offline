<?php

namespace App\Listeners;

use Log;
use Native\Laravel\Events\AutoUpdater\CheckingForUpdate;
use Native\Laravel\Events\AutoUpdater\DownloadProgress;
use Native\Laravel\Events\AutoUpdater\Error;
use Native\Laravel\Events\AutoUpdater\UpdateAvailable;
use Native\Laravel\Events\AutoUpdater\UpdateDownloaded;
use Native\Laravel\Events\AutoUpdater\UpdateNotAvailable;

class UpdaterListener
{
    public function handle(CheckingForUpdate|UpdateAvailable|UpdateNotAvailable|DownloadProgress|UpdateDownloaded|Error $event): void
    {
        if($event instanceof CheckingForUpdate){
            Log::info('Checking for updates...');
        } elseif($event instanceof UpdateAvailable) {
            Log::info('Update available: ' . $event->releaseName . ' (Version: ' . $event->version . ')');
        } elseif($event instanceof UpdateNotAvailable) {
            Log::info('No updates available.');
        } elseif($event instanceof DownloadProgress) {
            Log::info('Download progress: ' . $event->percent . '% (' . $event->transferred . ' of ' . $event->total . ' bytes)');
        } elseif($event instanceof UpdateDownloaded) {
            Log::info('Update downloaded successfully.');
        } elseif($event instanceof Error) {
            Log::error('Error occurred while checking for updates: ' . $event->message);
        }
    }

}
