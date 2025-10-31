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

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ProtectedAreaUpdate;
use App\Models\Settings;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use ModularForms\Models\Traits\Payload;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('offline.settings.index', [
            'vueData' => [
                'records' => Settings::get(),
                'save_url' => route('settings_update'),
            ],
            'user' => [
                'records' => Auth::user()
                    ->toArray(),
                'module_key' => 'offline_user',
                'save_url' => route('update_offline_user'),
            ],
            'countries' => Country::getAll(),
            'updated_pas_countries' => ProtectedAreaUpdate::getUpdated(),
        ]);
    }

    public function update(Request $request): array
    {
        $records = Payload::decode($request->input('records_json'));
        $module_key = $request->input('module_key');

        if ($module_key === 'proxy' || $module_key === 'api_keys') {
            Settings::updateSettings($records);
        }

        return [
            'records' => $records,
            'status' => 'success',
        ];
    }

    /**
     * Manage "update" OFFLINE user
     */
    public function user(Request $request): array
    {
        $records = Payload::decode($request->input('records_json'));

        // Validate the records
        $messages = (new User)->validate($records);
        if ($messages !== []) {
            return [
                'status' => 'validation_error',
                'errors' => $messages,
            ];
        }

        // Save the user profile
        $user = new User()->update_offline($records);

        return [
            'id' => 0,
            'status' => 'success',
            'records' => $user->toArray(),
        ];
    }
}
