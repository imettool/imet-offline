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
use Illuminate\Support\Facades\Validator;
use ImetCore\Models\User\Role;
use ImetCore\Models\User\User as ImetUser;
use ModularForms\Exceptions\ValidationException;
use ModularForms\Models\Module;

/**
 * @property string first_name
 * @property string last_name
 * @property string organisation
 * @property string function
 */
class User extends ImetUser
{
    public static array $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'organisation' => 'required|string|max:255',
        'function' => 'required|string|max:255',
        'country' => 'required|string|max:3',
    ];

    public function update_offline(array $attributes): Model|array
    {
        $item = (new User)->find($attributes['id']);
        $item->fill($attributes);
        if ($item->imet_role == null) {
            $item->imet_role = Role::ROLE_ADMINISTRATOR;
        }
        if ($item->isDirty()) {
            $item->touch();
            $item->save();
        }

        return $item;
    }

    public function validate(array $attributes): array
    {
        $validator = Validator::make($attributes, static::$rules);
        return $validator->fails()
            ? $validator->errors()->messages()
            : [];
    }

}
