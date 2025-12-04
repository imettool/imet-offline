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

namespace Database\Factories;

use App\Models\ProtectedArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProtectedArea>
 */
class ProtectedAreaFactory extends Factory
{
    public function definition(): array
    {
        $country = fake()->countryISOAlpha3();
        $wdpaId = fake()->randomNumber(5, true);

        return [
            'global_id' => $country.'_'.$wdpaId,
            'country' => $country,
            'wdpa_id' => $wdpaId,
            'name' => fake()->firstName().' national park',
        ];
    }
}
