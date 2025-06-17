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

namespace App\Models;

use ImetCore\Models\Country as BaseCountry;
use ModularForms\Helpers\Locale;
use Illuminate\Database\Eloquent\Collection;

class Country extends BaseCountry
{

    /**
     * Override: get only allowed countries
     */
    public static function selectionList($type = 'PAIRS', Collection $collection = null, $fields = []): array
    {
        $label_attribute = 'name_'.Locale::lower();
        return static
            ::select(['iso3', $label_attribute])
            ->get()
            ->sortBy($label_attribute, SORT_NATURAL|SORT_FLAG_CASE)
            ->pluck($label_attribute, ('iso3'))
            ->toArray();
    }

    /**
     * Get all countries
     */
    public static function getAll(): Collection
    {
        return static::select(['name_'.Locale::lower(), 'iso3', 'iso2'])
            ->orderBy('name_'.Locale::lower())
            ->get();
    }

}
