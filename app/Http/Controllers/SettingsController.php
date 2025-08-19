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

use Auth;
use ModularForms\Exceptions\MissingAPITokenException;
use ModularForms\Models\Traits\Payload;
use App\Helpers\ProtectedAreaUpdaterAPI;
use App\Models\Country;
use App\Models\ProtectedAreaUpdate;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;


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
                'save_url' => route('update_offline_user')
            ],
            'countries' => Country::getAll(),
            'updated_pas_countries' => ProtectedAreaUpdate::getUpdated()
        ]);
    }

    public function update(Request $request): array
    {
        $records = Payload::decode($request->input('records_json'));
        $module_key = $request->input('module_key');

        if($module_key === 'proxy' || $module_key === 'api_keys'){
            Settings::updateSettings($records);
        }

        return [
            'records' => $records,
            'status' => 'success',
        ];
    }

    public function update_pas(Request $request): JsonResponse
    {
        $country = $request->input('iso3');

        Config::set('PROTECTED_PLANET_API_KEY', Settings::getSetting('protected_planet_api_key'));

        try{
            ProtectedAreaUpdaterAPI::updateByCountry($country);
            ProtectedAreaUpdate::setUpdated($country);

        } catch (MissingAPITokenException $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Protected Planet API key not found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'updated' => Carbon::now()->format('Y-m')
        ]);
    }

}
