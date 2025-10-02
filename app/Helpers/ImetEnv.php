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
            ? 'DEV (' . config('nativephp.version') . ')'
            : config('nativephp.version');
    }

}
