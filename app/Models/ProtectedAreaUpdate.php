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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use ImetCore\Models\ProtectedArea;

class ProtectedAreaUpdate extends Model
{
    protected $table = 'protected_area_updates';

    const CREATED_AT = null;

    const UPDATED_AT = null;

    protected $fillable = ['country', 'last_update_date'];

    /**
     * Get last update date for each country
     */
    public static function getUpdated(): array
    {
        $pas_iso = array_combine(ProtectedArea::getCountriesISO(), array_fill(0, count(ProtectedArea::getCountriesISO()), null));
        $updates = ProtectedAreaUpdate::all()
            ->map(function ($item): ProtectedAreaUpdate {
                $item->last_update_date = Date::parse($item->last_update_date)->format('Y-m');

                return $item;
            })
            ->pluck('last_update_date', 'country')
            ->toArray();

        return array_merge($pas_iso, $updates);
    }

    /**
     * Set last update date for a country
     */
    public static function setUpdated(string $country): void
    {
        ProtectedAreaUpdate::query()->updateOrCreate(
            ['country' => $country],
            ['last_update_date' => Date::now()]
        );
    }
}
