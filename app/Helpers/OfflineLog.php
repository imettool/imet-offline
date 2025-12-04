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

use Illuminate\Support\Facades\Log;

class OfflineLog
{
    /**
     * Log info message (and print if verbose)
     */
    public static function info(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            echo $message.PHP_EOL;
        }

        Log::info($message);
    }

    /**
     * Log error message (and print if verbose)
     */
    public static function error(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            echo $message.PHP_EOL;
        }

        Log::error($message);
    }

    /**
     * Log warning message (and print if verbose)
     */
    public static function warning(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            echo $message.PHP_EOL;
        }

        Log::warning($message);
    }

    /**
     * Log debug message (and print if verbose)
     */
    public static function debug(string $message, bool $verbose = false): void
    {
        if ($verbose) {
            echo $message.PHP_EOL;
        }

        Log::debug($message);
    }
}
