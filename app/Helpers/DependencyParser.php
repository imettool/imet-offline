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

use Illuminate\Support\Str;
use ImetCore\Helpers\DependencyParser as BaseDependencyParser;

class DependencyParser extends BaseDependencyParser
{
    protected static function getNpmDirectDependencyList(bool $includeDev): array
    {
        $dependencies = parent::getNpmDirectDependencyList($includeDev);
        return array_filter($dependencies, function ($dependency) {
            return $dependency != 'imet-core';
        });
    }

    /**
     * Override: hardcode license for imet-core
     */
    protected static function retrieveLicense(array $packageInfo): array
    {
        $license = parent::retrieveLicense($packageInfo);

        // Hardcoded licenses
        if(Str::contains($packageInfo['name'],'imet-core')) {
            $license = ['EUPL-1.2'];
        }
        // Set default license if multiple licenses are found
        if(Str::contains($packageInfo['name'],'nette/schema')
            || Str::contains($packageInfo['name'],'nette/utils')) {
            $license = ['BSD-3'];
        }
        if(Str::contains($packageInfo['name'],'nativephp/php-bin')) {
            $license = ['GPL-3.0-or-later'];
        }

        return array_unique($license);
    }

}
