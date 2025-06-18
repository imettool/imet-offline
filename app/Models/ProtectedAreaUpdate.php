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

use ImetCore\Models\ProtectedArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


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
            ->map(function ($item) {
                $item->last_update_date = Carbon::parse($item->last_update_date)->format('Y-m');
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
        ProtectedAreaUpdate::updateOrCreate(
            ['country' => $country],
            ['last_update_date' => Carbon::now()]
        );
    }

}
