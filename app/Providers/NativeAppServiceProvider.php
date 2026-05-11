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

namespace App\Providers;

use App\Events\ZoomInHotKeyPressed;
use App\Events\ZoomOutHotKeyPressed;
use App\Events\ZoomResetHotKeyPressed;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Native\Desktop\Facades\GlobalShortcut;
use Native\Desktop\Facades\Window;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Window::open('splash')
            ->url('file://' . public_path('splash.html'))
            ->width(1200)
            ->height(800)
            ->frameless()
            ->alwaysOnTop()
            ->resizable(false);

        Window::open('root')
            ->width(1200)
            ->height(800)
            ->resizable()
            ->hideMenu()
            ->title(trans('offline.title'));

        // Register global shortcuts
        // Note: electron has actually inconsistent behavior with non US keyboard layouts

        // Zoom in
        $zoomInKeys = [
            'CmdOrCtrl+=',
            'CmdOrCtrl+Plus',
            'CmdOrCtrl+Shift+Plus',
            'CmdOrCtrl+]',  // ITA layout: the + in ITA layout is in the same position of the ] in US layout
        ];
        foreach($zoomInKeys as $key) {
            GlobalShortcut::key($key)
                ->unregister();
            GlobalShortcut::key($key)
                ->event(ZoomInHotKeyPressed::class)
                ->register();
        }

        // Zoom out
        $zoomOutKeys = [
            'CmdOrCtrl+-',
            'CmdOrCtrl+_',
            'CmdOrCtrl+[',
            'CmdOrCtrl+/', // ITA layout: the - in ITA layout is in the same position of the / in US layout
        ];
        foreach ($zoomOutKeys as $key) {
            GlobalShortcut::key($key)
                ->unregister();
            GlobalShortcut::key($key)
                ->event(ZoomOutHotKeyPressed::class)
                ->register();
        }

        // Reset zoom
        $zoomResetKeys = [
            'CmdOrCtrl+0'
        ];
        foreach ($zoomResetKeys as $key) {
            GlobalShortcut::key($key)
                ->unregister();
            GlobalShortcut::key($key)
                ->event(ZoomResetHotKeyPressed::class)
                ->register();
        }

    }

    /**
     * Return an array of php.ini directives to be set.
     *
     * @return array<string, string>
     */
    public function phpIni(): array
    {
        return [
            'upload_max_filesize' => '2048M',
            'post_max_size' => '2048M',
            'display_errors' => '1',
            'error_reporting' => 'E_ALL',
            'max_execution_time' => '0',
            'max_input_time' => '0',
        ];
    }
}
