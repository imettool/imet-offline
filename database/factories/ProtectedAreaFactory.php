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

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use ImetCore\Models\ProtectedArea;

class ProtectedAreaFactory extends Factory
{
    protected $model = ProtectedArea::class;

    public function definition(): array
    {
        $country = fake()->countryISOAlpha3();
        $wdpaId = fake()->randomNumber(5, true);
        return [
            'global_id' => $country . '_' . $wdpaId,
            'country' => $country,
            'wdpa_id' => $wdpaId,
            'name' => fake()->firstName . ' national park',
        ];
    }
}
