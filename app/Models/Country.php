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
