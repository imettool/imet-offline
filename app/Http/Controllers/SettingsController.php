<?php

namespace App\Http\Controllers;

use ModularForms\Exceptions\MissingAPITokenException;
use ModularForms\Models\Traits\Payload;
use App\Helpers\ProtectedAreaUpdater;
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
            ProtectedAreaUpdater::updateByCountry($country);
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
