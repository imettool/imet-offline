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

use Illuminate\Database\Eloquent\Model;


class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'proxy_host',
        'proxy_port',
        'proxy_user',
        'proxy_password',
    ];

    public static function get(): array
    {
        return static::find(0)->toArray();
    }

    public static function updateSettings(array $data): array
    {
        $data = collect($data)->filter(function($value, $key){
            return $value!==null && $value!=='';
        })->toArray();

        $settings = static::find(0);
        $settings->update($data);
        return $settings->toArray();
    }

    public static function getSetting($key): ?string
    {
        return static::first()?->$key;
    }

}
