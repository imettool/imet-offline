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

namespace Database\Seeders;

use App\Helpers\SpeciesUpdater;
use App\Models\ProtectedArea;
use Auth;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use ImetCore\Models\Imet;
use ImetCore\Models\Species;
use ModularForms\Helpers\Input\SelectionList;
use ModularForms\Models\Module;
use Random\RandomException;
use Throwable;

class DatabaseSeeder extends Seeder
{
    const int NUM_FORMS = 5;

    /**
     * Generate fake data for a given field
     *
     * @param array<string, string> $field
     * @return mixed
     * @throws RandomException
     * @throws Throwable
     */
    public static function getFake(array $field): mixed
    {
        $type = $field['type'];

        // CUSTOM
        if (Str::contains($type, '_EcosystemServicesImportance')) {
            return collect([0, 1])->random();
        }

        // Standard
        if ($type === 'text') {
            return fake()->words(3);
        }

        if ($type === 'textarea' || $type === 'text-area') {
            return fake()->words(4, true);
        }

        if ($type === 'url') {
            return fake()->url();
        }

        if ($type === 'email') {
            return fake()->email();
        }

        if ($type === 'password') {
            return fake()->password();
        }

        if (in_array($type, ['integer', 'code', 'numeric'], true)) {
            return fake()->randomNumber(4);
        }

        if ($type === 'float'
            || $type === 'currency') {
            return fake()->randomFloat(2);
        }

        if ($type === 'date') {
            return fake()->date();
        }

        if ($type === 'dateMaxToday') {
            return fake()->dateTimeBetween('-4 years', 'now');
        }

        if ($type === 'year') {
            return fake()->year();
        }

        if ($type === 'yearMaxCurrent'
            || $type === 'yearMaxPrev') {
            return fake()->dateTimeBetween('-4 years', '-1 year')->format('Y');
        }

        if (Str::contains($type, '-boolean')) {
            $values = Str::contains($type, 'numeric')
                ? [0, 1]
                : ['0', '1'];

            return collect($values)->random();
        }

        if (Str::contains($type, 'yes_no')) {
            return collect(['true', 'false'])->random();
        }

        if (Str::contains($type, 'dropdown')
            || Str::contains($type, 'suggestion')
            || Str::contains($type, 'toggle')
            || Str::contains($type, 'checkbox')
            || Str::contains($type, 'currency-unit')) {
            $list_type = SelectionList::getListType($type);
            $cached_list = SelectionList::CacheListInSession($list_type);

            return collect($cached_list)
                ->keys()
                ->random(Str::contains($type, 'multiple') ? random_int(2, 4) : null);
        }

        if (Str::contains($type, 'rating')) {
            $values = [];
            $rating_type = (string) last(explode('-', (string) $type));
            if (Str::contains($rating_type, 'WithNA')) {
                $values[] = '-99';
                $rating_type = Str::replace('WithNA', '', $rating_type);
            }

            [$min, $max] = explode('to', (string) $rating_type);
            if (Str::contains($min, 'Minus')) {
                $min = Str::replace('Minus', '-', $min);
            }

            $min = intval($min);
            $max = intval($max);
            $values = array_merge($values, range($min, $max));

            return collect($values)->random();
        }

        if (Str::contains($type, 'selector-species')) {
            $species = Species::query()->inRandomOrder()->first();

            return $species->phylum
                .'|'.$species->class
                .'|'.$species->order
                .'|'.$species->family
                .'|'.$species->genus
                .'|'.$species->species;
        }

        // Standard
        if (Str::contains($type, 'selector-wdpa')) {
            if (Str::contains($type, 'multiple')) {
                return implode(',', ProtectedArea::query()->inRandomOrder()->limit(random_int(2, 5))->get()->pluck('wdpa_id')->toArray());
            }

            return ProtectedArea::query()->inRandomOrder()->first()->wdpa_id;
        }

        return null;
    }

    /**
     * Insert multiple records for a given module and form_id
     *
     * @param class-string<Module> $module
     * @throws Throwable
     */
    private function insertRecords(string $module, int $form_id, int $num_records = 1, ?string $group_key = null): void
    {
        for ($y = 1; $y <= $num_records; $y++) {
            $this->insertRecord($module, $form_id, $group_key);
        }
    }

    /**
     * Insert a single record for a given module and form_id
     *
     * @param class-string<Module> $module
     * @throws Exception
     * @throws Throwable
     */
    private function insertRecord(string $module, int $form_id, ?string $group_key = null): void
    {
        $values = [
            'FormID' => $form_id,
            'UpdateDate' => now(),
            'UpdateBy' => 0,
        ];

        // Inject predefined values
        $predefined = $module::getPredefined($form_id);
        if ($predefined !== null) {
            $values[$predefined['field']] = null;
            if($predefined['values'] !== null && count($predefined['values']) > 0){
                if(Str::contains((new $module)->module_type, 'GROUP')){
                    $random_group = fake()->randomElement(array_keys($predefined['values']));
                    $values[$predefined['field']] = fake()->randomElement($predefined['values'][$random_group]);
                } else {
                    $values[$predefined['field']] = fake()->randomElement($predefined['values']);
                }
            }
        }

        // Generate fake values (fields)
        foreach ((new $module)->module_fields as $field) {
            if (! array_key_exists($field['name'], $values)) {
                $values[$field['name']] = self::getFake($field);
            }
        }

        // Generate fake values (common_fields)
        if ((new $module)->module_common_fields !== []) {
            foreach ((new $module)->module_common_fields as $field) {
                if (! array_key_exists($field['name'], $values)) {
                    $values[$field['name']] = self::getFake($field);
                }
            }
        }

        // Add $group_key if required
        if ($group_key !== null) {
            $values[$module::$group_key_field] = $group_key;
        }

        // IMET: force IncludeInStatistics to true
        if (array_key_exists('IncludeInStatistics', $values)) {
            $values['IncludeInStatistics'] = '1';
        }

        $module::insert($values);
    }

    /**
     * Seed the application's database.
     *
     * @throws Throwable
     */
    public function run(): void
    {
        // Add protected areas
        ProtectedArea::factory()->count(50)->create();

        // Add species from CSV
        SpeciesUpdater::insertSpeciesAndVernacularNames(Str::uuid()->toString());

        $pas = ProtectedArea::all()->random(10);
        $modules = array_merge(Imet\v2\Imet::allModules(), Imet\v2\Imet_Eval::allModules());

        Auth::loginUsingId(0);

        for ($i = 1; $i <= self::NUM_FORMS; $i++) {

            $pa = $pas->random();

            $form_id = Imet\v2\Imet::query()->insertGetId([
                'Country' => $pa->country,
                'Year' => fake()->dateTimeBetween('-4 years', 'now')->format('Y'),
                'version' => Imet\v2\Imet::$version,
                'language' => collect(['en', 'fr', 'sp', 'pt'])->random(),
                'wdpa_id' => $pa->wdpa_id,
                'name' => $pa->name,
                'UpdateDate' => now(),
                'UpdateBy' => 0,
            ]);

            foreach ($modules as $module) {
                $module_type = (new $module)->module_type;
                $num_records = (Str::contains($module_type, 'TABLE') || Str::contains($module_type, 'ACCORDION'))
                    ? 4
                    : 1;

                if (Str::contains($module_type, 'GROUP')) {
                    foreach (array_keys((new $module)->module_groups) as $group_key) {
                        $this->insertRecords($module, $form_id, $num_records, $group_key);
                    }
                } else {
                    $this->insertRecords($module, $form_id, $num_records);
                }

            }

        }

    }
}
