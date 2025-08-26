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
            $license[] = 'EUPL-1.2';
        }
        // Set default license if multiple licenses are found
        if(Str::contains($packageInfo['name'],'nette/schema')
            || Str::contains($packageInfo['name'],'nette/utils')) {
            $license[] = 'BSD-3';
        }

        return $license;
    }

}
