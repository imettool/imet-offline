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

namespace App\Http\Controllers;

use ModularForms\Controllers\FormController;
use App\Models\User;
use Illuminate\Http\Request;
use ModularForms\Models\Traits\Payload;


class UserController extends FormController
{

    /**
     * Manage "update" OFFLINE user
     */
    public function update_offline_user(Request $request): array
    {
        $records = Payload::decode($request->input('records_json'));

        $item = (new User)->find($records['id']);
        $item->fill($records);
        if ($item->isDirty()) {
            $item->touch();
            $item->save();
        }

        return [
            'id' => 0,
            'status' => 'success',
            'records' => $item->toArray(),
        ];
    }

}
