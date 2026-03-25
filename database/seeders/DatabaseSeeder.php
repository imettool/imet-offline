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

namespace Database\Seeders;

use Auth;
use Illuminate\Database\Seeder;
use ImetCore\Helpers\Seeders\FormSeeder;
use ImetCore\Helpers\Seeders\ProtectedAreaSeeder;
use ImetCore\Helpers\Seeders\SpeciesSeeder;
use ImetCore\Models\Imet\Imet;
use Throwable;

class DatabaseSeeder extends Seeder
{
    const int NUM_FORMS = 2;

    /**
     * Seed the application's database.
     *
     * @throws Throwable
     */
    public function run(): void
    {
        Auth::loginUsingId(0);

        // Seed ProtectedArea
        (new ProtectedAreaSeeder)->runWithSample(false);

        // Seed Species
        (new SpeciesSeeder)->runWithSample(true);

        // Seed forms with modules
        (new FormSeeder)->run(Imet::IMET_V1, self::NUM_FORMS);
        (new FormSeeder)->run(Imet::IMET_V2, self::NUM_FORMS);
        (new FormSeeder)->run(Imet::IMET_OECM, self::NUM_FORMS);

    }
}
