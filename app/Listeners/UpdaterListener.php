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

use Log;
use Native\Laravel\Events\AutoUpdater\CheckingForUpdate;
use Native\Laravel\Events\AutoUpdater\DownloadProgress;
use Native\Laravel\Events\AutoUpdater\Error;
use Native\Laravel\Events\AutoUpdater\UpdateAvailable;
use Native\Laravel\Events\AutoUpdater\UpdateCancelled;
use Native\Laravel\Events\AutoUpdater\UpdateDownloaded;
use Native\Laravel\Events\AutoUpdater\UpdateNotAvailable;

class UpdaterListener
{
    public function handle(CheckingForUpdate|UpdateAvailable|UpdateNotAvailable|DownloadProgress|UpdateDownloaded|UpdateCancelled|Error $event): void
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
        } elseif($event instanceof UpdateCancelled) {
            Log::info('Update cancelled.');
        } elseif($event instanceof Error) {
            Log::error('Error occurred while checking for updates: ' . $event->message);
        }
    }

}
