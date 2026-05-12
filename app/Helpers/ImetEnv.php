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

namespace App\Helpers;

use ImetCore\Models\Species;

class ImetEnv extends \ImetCore\Helpers\ImetEnv
{
    /**
     * Check if the application is in its first boot and the setup process should be run.
     */
    public static function isFirstBoot(): bool
    {
        return Species::query()->count() < 10;
    }

    /**
     * Return the IMET offline tool version
     */
    public static function getVersion(): string
    {
        return static::isDevEnv()
            ? 'DEV ('.config('nativephp.version').')'
            : config('nativephp.version');
    }

    public static function getCoreVersion(): ?string
    {
        $path = base_path('composer.lock');
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        foreach ($data['packages'] as $package) {
            if ($package['name'] == 'imettool/imet-core') {
                return $package['version'];
            }
        }

        return null;
    }
}
