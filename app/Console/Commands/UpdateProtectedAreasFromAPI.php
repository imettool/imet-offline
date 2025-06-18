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
use App\Helpers\ProtectedAreaUpdater;
use App\Models\ProtectedAreaUpdate;
use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class UpdateProtectedAreasFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imet:update_pas_from_api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Protected Areas from Protected Planet API and write CSV file for migration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Update protected areas table from Protected Planet API
        Config::set('PROTECTED_PLANET_API_KEY', Settings::getSetting('protected_planet_api_key'));
        $this->updatePas();

        // Write CSV
        $this->writeCSV();

        $this->info('Done');

        return 0;
    }

    function updatePas(): void
    {
        // Retrieve countries from Protected Areas table
        $pas_countries = ProtectedArea::getCountries(false)
            ->pluck('iso3')
            ->toArray();
        $num_countries = count($pas_countries);

        // Update Protected Areas for each country
        $this->info('Updating Protected Areas for ' . $num_countries . ' countries...');
        $country_idx = 0;
        foreach ($pas_countries as $iso) {
            try {
                $this->info('Updating ' . $iso . ' (' . ++$country_idx . '/' . $num_countries . ')');
                ProtectedAreaUpdater::updateByCountry($iso);     // Update Protected Areas for a country
                ProtectedAreaUpdate::setUpdated($iso);      // Update last update date

            } catch (MissingAPITokenException $e) {
                $this->error('Missing API token for Protected Planet');
            }
        }

    }

    function writeCSV(): void
    {
        // Retrieve all Protected Areas
        $pas = ProtectedArea::all();

        // Write CSV
        $this->info('Writing CSV file...');
        $handler = fopen(database_path(ProtectedAreaUpdater::CSV_MIGRATION_PATH), 'w');
        fputcsv($handler, ProtectedAreaUpdater::MIGRATION_ATTRIBUTES);   // header
        foreach ($pas as $pa) {
            fputcsv($handler, $pa->only(ProtectedAreaUpdater::MIGRATION_ATTRIBUTES));
        }
        fclose($handler);
    }


}
