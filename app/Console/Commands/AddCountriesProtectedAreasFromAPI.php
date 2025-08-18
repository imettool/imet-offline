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

namespace App\Console\Commands;

use ImetCore\Models\ProtectedArea;
use ModularForms\Exceptions\MissingAPITokenException;
use App\Helpers\ProtectedAreaUpdaterAPI;
use App\Models\ProtectedAreaUpdate;
use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class AddCountriesProtectedAreasFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'imet:add_countries_pas_from_api {country}';

    /**
     * The console command description.
     */
    protected $description = 'Add the given countries\' Protected Areas from Protected Planet API and append to CSV file for migration';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Config::set('PROTECTED_PLANET_API_KEY', Settings::getSetting('protected_planet_api_key'));

        $countries = $this->argument('country');
        $countries = explode(',', $countries);

        // Retrieve given countries Protected Areas
        foreach ($countries as $country) {
            $this->retrieveCountryPas($country);
        }

        // Write CSV
        $this->writeCSV();

        $this->info('Done');

        return 0;
    }

    function retrieveCountryPas($country): void
    {
        try {
            $this->info('Retrieving Protected Areas for ' . $country . '...');
            ProtectedAreaUpdaterAPI::updateByCountry($country);     // Update Protected Areas for a country
            ProtectedAreaUpdate::setUpdated($country);      // Update last update date

        } catch (MissingAPITokenException $e) {
            $this->error('Missing API token for Protected Planet');
        }


    }

    function writeCSV(): void
    {
        // Retrieve all Protected Areas
        $pas = ProtectedArea::all();

        // Write CSV
        $this->info('Writing CSV file...');
        $handler = fopen(database_path(ProtectedAreaUpdaterAPI::CSV_MIGRATION_PATH), 'w');
        fputcsv($handler, ProtectedAreaUpdaterAPI::MIGRATION_ATTRIBUTES);   // header
        foreach ($pas as $pa) {
            fputcsv($handler, $pa->only(ProtectedAreaUpdaterAPI::MIGRATION_ATTRIBUTES));
        }
        fclose($handler);
    }


}
