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
use Override;

class DependencyParser extends BaseDependencyParser
{

    /**
     * Override: exclude imet-core from the list of NPM dependencies
     */
    #[Override]
    protected static function getNpmDirectDependencyList(bool $includeDev): array
    {
        $dependencies = parent::getNpmDirectDependencyList($includeDev);
        return array_filter($dependencies, fn(string $dependency): bool => $dependency !== 'imet-core');
    }

    /**
     * Override: hardcode copyright for specific packages
     */
    #[Override]
    protected static function retrieveCopyright(array $packageInfo, string $mode): ?string
    {
        $copyright = parent::retrieveCopyright($packageInfo, $mode);

        // Hardcode copyright for specific packages
        if(Str::contains($packageInfo['name'], 'imet-core')) {
            return BaseDependencyParser::COPYRIGHT;
        }

        return $copyright;
    }

    /**
     * Override: hardcode license for imet-core
     */
    #[Override]
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

    #[\Override]
    protected static function generateDependenciesOutput(array $dependencies): string
    {
        $parentOutput = parent::generateDependenciesOutput($dependencies);

        // Add "Catalogue of Life" entry
        $colOutput = '__Catalogue of Life, 2025-08-26__' . PHP_EOL;
        $colOutput .= "  * https://www.catalogueoflife.org/" . PHP_EOL;
        $colOutput .= "  * License: CC-BY-4.0" . PHP_EOL;
        $colOutput .= "  * Copyright:" . PHP_EOL;
        $colOutput .= "     * Copyright (c) 2022, Catalogue of Life." . PHP_EOL;
        $colOutput .=
            "  * Citation: Bánki, O., Roskov, Y., Döring, M., Ower, G., Hernández Robles, D. R., Plata Corredor, C. A.,
            Stjernegaard Jeppesen, T., Örn, A., Pape, T., Hobern, D., Garnett, S., Little, H., DeWalt, R. E., Miller, J.,
            Orrell, T., Aalbu, R., Abbott, J., Aedo, C., Aescht, E., et al. (2025). Catalogue of Life (Version 2025-09-11).
            Catalogue of Life Foundation, Amsterdam, Netherlands. https://doi.org/10.48580/dgt98" . PHP_EOL;


        return $parentOutput . $colOutput;
    }

}
