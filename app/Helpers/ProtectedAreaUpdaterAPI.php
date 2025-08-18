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

namespace App\Helpers;

use App\Models\Country;
use ImetCore\Models\ProtectedArea;
use ModularForms\Helpers\API\ProtectedPlanet\ProtectedPlanet as ProtectedPlanetAPI;
use ModularForms\Helpers\File\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class ProtectedAreaUpdaterAPI
 * This class is responsible for updating protected areas from the ProtectedPlanet API.
 */
class ProtectedAreaUpdaterAPI
{
    const CHUNK_SIZE = 50;
    public const MIGRATION_ATTRIBUTES = ['global_id','country','wdpa_id','name','iucn_category','creation_date','perimeter','area','shape_index'];
    public const CSV_MIGRATION_PATH = 'protected_areas.csv';

    public static function updateByCountry(Country|string $country): void
    {
        $country = is_string($country) ? Country::find($country) : $country;

        $count_updated = 0;
        $count_added = 0;
        $count_no_change = 0;
        $count_retrieved_from_api = 0;

        // Retrieve country's protected areas from database
        $pas_DB = ProtectedArea
            ::where('country', 'LIKE', '%'.$country->iso3.'%')
            ->get()
            ->keyBy('wdpa_id');

        // Retrieve country's protected areas from API (in chunks)
        Log::info('Retrieving PAs from ProtectedPlanet API (' . $country->iso3 . ')...');
        $retrieved_in_chunk_count = self::CHUNK_SIZE;
        $chunk_idx = 1;
        while($retrieved_in_chunk_count === self::CHUNK_SIZE){

            // Retrieve from API
            $pas_API = static::getChunk($country->iso3, $chunk_idx);
            $retrieved_in_chunk_count = count($pas_API);
            $count_retrieved_from_api += $retrieved_in_chunk_count;
            $chunk_idx++;

            // Compare API protected areas to DB
            foreach ($pas_API as $pa_API){

                // Get API attributes
                $pa = $pas_DB[$pa_API->wdpa_id] ?? null;
                $attributes = static::getAPIAttributes($pa_API);

                // Set global_id: still needed for import old IMET JSONs (which still using global_id instead of wdpa_id)
                $attributes['global_id'] = $country->region_id!==null
                    ? $country->region_id . '_' . $pa_API->wdpa_id
                    : $country->iso3 . '_' . $pa_API->wdpa_id;
                $attributes['global_id'] = Str::upper($attributes['global_id']);

                // Not found in DB: INSERT
                if($pa===null){
                    ProtectedArea::create($attributes);
                    $count_added++;

                // Found in DB
                } else {
                    $pa->fill($attributes);

                    // Is different: UPDATE
                    if($pa->isDirty()){
                        $pa->save();
                        $count_updated++;
                    }

                    // No differences: nothing to do
                    else {
                        $count_no_change++;
                    }
                }

            }

        }

        // Update completed
        Log::info('------------------------------------------------------------');
        Log::info('Total protected areas retrieved from API: ' . $count_retrieved_from_api);
        Log::info('Total protected areas UPDATED: ' .$count_updated);
        Log::info('Total protected areas ADDED: ' . $count_added);
        Log::info('Total protected areas with NO CHANGES: ' . $count_no_change);
        Log::info('------------------------------------------------------------');

    }

    /**
     * Retrieve protected areas from ProtectedPlanet API
     */
    private static function getChunk($country, $chunk_idx): array
    {
        $cache_msg = '';
        $chunk_msg = $chunk_idx===1 ? '' : ' (chunk ' . $chunk_idx . ')';
        $cache_file = date("Y-m-d"). '_update_pas-' . $country . '-' . $chunk_idx . '.json';

        // Retrieve from API
        if(!Storage::disk(File::TEMP_STORAGE)->exists($cache_file)){
            $api_result = ProtectedPlanetAPI::getByCountry($country, $chunk_idx, self::CHUNK_SIZE);
            Storage::disk(File::TEMP_STORAGE)->put($cache_file, json_encode($api_result));
        }
        // Retrieve from cache
        else {
            $api_result = json_decode(Storage::disk(File::TEMP_STORAGE)->get($cache_file));
            $cache_msg = '(from cache) ';
        }

        Log::info('  - ' . $cache_msg . count($api_result->protected_areas). ' protected areas (' . $country . ') found.' . $chunk_msg);
        return $api_result->protected_areas;
    }

    /**
     * Prepare attributes for INSERT/UPDATE
     */
    private static function getAPIAttributes($api): array
    {
        // Manage multiple countries
        $countries = count($api->countries) > 1
            ? implode(';', collect($api->countries)->pluck('iso_3')->toArray())
            : $api->countries[0]->iso_3;

        return [
            'country' => $countries,
            'wdpa_id' => $api->wdpa_id,
            'name' => str_replace("'", "''", $api->original_name),
            'iucn_category' => $api->iucn_category->name,
            'area' => (float) $api->reported_area
        ];
    }

}
