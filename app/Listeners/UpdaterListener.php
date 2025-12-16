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

use Log;
use Native\Desktop\Events\AutoUpdater\CheckingForUpdate;
use Native\Desktop\Events\AutoUpdater\DownloadProgress;
use Native\Desktop\Events\AutoUpdater\Error;
use Native\Desktop\Events\AutoUpdater\UpdateAvailable;
use Native\Desktop\Events\AutoUpdater\UpdateCancelled;
use Native\Desktop\Events\AutoUpdater\UpdateDownloaded;
use Native\Desktop\Events\AutoUpdater\UpdateNotAvailable;

class UpdaterListener
{
    public function handle(CheckingForUpdate|
                           UpdateAvailable|
                           UpdateNotAvailable|
                           DownloadProgress|
                           UpdateDownloaded|
                           UpdateCancelled|
                           Error $event): void
    {
        if ($event instanceof CheckingForUpdate) {
            Log::info(trans('offline.update.checking'));
        } elseif ($event instanceof UpdateAvailable) {
            Log::info(trans('offline.update.available').':'.$event->version);
        } elseif ($event instanceof UpdateNotAvailable) {
            Log::info(trans('offline.update.not_available'));
        } elseif ($event instanceof DownloadProgress) {
            Log::info(trans('offline.update.downloading').':'.$event->percent);
        } elseif ($event instanceof UpdateDownloaded) {
            Log::info(trans('offline.update.downloaded'));
        } elseif ($event instanceof UpdateCancelled) {
            Log::info(trans('offline.update.cancelled'));
        } elseif ($event instanceof Error) {
            Log::info(trans('offline.update.error').':'.$event->message);
        }
    }
}
