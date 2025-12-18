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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */


namespace App\Listeners;

use App\Events\ZoomInHotKeyPressed;
use App\Events\ZoomOutHotKeyPressed;
use App\Events\ZoomResetHotKeyPressed;
use Illuminate\Support\Facades\Log;


class HotKeysListeners
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ZoomInHotKeyPressed|ZoomOutHotKeyPressed|ZoomResetHotKeyPressed $event): void
    {
        if ($event instanceof ZoomInHotKeyPressed) {
            Log::debug('zoom-in hotkey pressed');
        } else if( $event instanceof ZoomOutHotKeyPressed) {
            Log::debug('zoom-out hotkey pressed');
        } else if($event instanceof ZoomResetHotKeyPressed) {
            Log::debug('zoom-reset hotkey pressed');
        }

    }
}
