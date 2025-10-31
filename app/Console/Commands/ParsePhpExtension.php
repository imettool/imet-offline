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

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ParsePhpExtension extends Command
{
    protected $signature = 'imet:parse_php_extension';

    protected $description = 'Extract the list of PHP extensions required by the application analyzing the composer.lock file';

    public function handle(): int
    {

        $composer_json = json_decode(file_get_contents(base_path('composer.lock')), true);
        $required_extensions = [];

        foreach ($composer_json['packages'] as $package) {
            if (isset($package['require'])) {
                foreach ($package['require'] as $requirement => $version) {
                    if (Str::startsWith($requirement, 'ext-')) {
                        $required_extensions[] = Str::replace('ext-', '', $requirement);
                    }
                }
            }
        }

        $required_extensions = array_unique($required_extensions);
        sort($required_extensions);

        $this->components->info(implode(', ', $required_extensions));

        return 0;
    }
}
