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

use Illuminate\Support\Facades\Log;

class OfflineLog
{

    /**
     * Log info message (and print if verbose)
     */
    public static function info(string $message, bool $verbose = false): void
    {
        if($verbose){
            print($message . PHP_EOL);
        }
        Log::info($message);
    }

    /**
     * Log error message (and print if verbose)
     */
    public static function error(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            print($message . PHP_EOL);
        }
        Log::error($message);
    }

    /**
     * Log warning message (and print if verbose)
     */
    public static function warning(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            print($message . PHP_EOL);
        }
        Log::warning($message);
    }

    /**
     * Log debug message (and print if verbose)
     */
    public static function debug(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            print($message . PHP_EOL);
        }
        Log::debug($message);
    }

}
