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

use App\Helpers\ImetEnv;
use App\Helpers\ProtectedAreaUpdaterCSV;
use App\Helpers\SpeciesUpdater;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ModularForms\Helpers\File\File;
use ModularForms\Models\Module;
use ModularForms\Models\Traits\Payload;
use Str;

class SetupController extends Controller
{
    const array TIMELINE = [
        'info',
        'user',
        'species',
        'wdpas',
        'done',
    ];

    /**
     * Display the setup page if the application is in its first boot.
     * Redirect to home page if the application is not in its first boot.
     */
    public function index(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        // If first boot, redirect to the setup page
        if (ImetEnv::isFirstBoot()) {
            return to_route('setup.info');
        }

        // If not first boot, redirect to the home page
        return to_route('home');
    }

    /**
     * Display the setup info page.
     */
    public function info(): View
    {
        return view('offline.setup.info', [
            'current_step' => 'info',
            'timeline' => self::TIMELINE,
        ]);
    }

    /**
     * Display the setup user page.
     */
    public function user(): View
    {
        return view('offline.setup.user', [
            'current_step' => 'user',
            'timeline' => self::TIMELINE,
            'user' => [
                'records' => Auth::user()
                    ->toArray(),
                'module_key' => 'offline_user',
                'save_url' => route('setup.user.save'),
            ],
        ]);
    }

    /**
     * Save the user profile information.
     */
    public function user_save(Request $request): RedirectResponse|array
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
            'redirect_to' => route('setup.species'),
        ];
    }

    /**
     * Display the setup species page.
     */
    public function species(): View
    {
        return view('offline.setup.species', [
            'current_step' => 'species',
            'timeline' => self::TIMELINE,
            'vueData' => [
                'save_url' => route('setup.species.save'),
                'job_id' => Str::uuid()->toString(),
            ],
        ]);
    }

    public function species_save(Request $request): JsonResponse
    {
        $jobId = $request->input('job_id');
        SpeciesUpdater::insertSpeciesAndVernacularNames($jobId);

        return new JsonResponse([
            'status' => 'success',
        ]);
    }

    /**
     * Display the setup protected areas page.
     */
    public function wdpas(): View
    {
        return view('offline.setup.wdpas', [
            'current_step' => 'wdpas',
            'timeline' => self::TIMELINE,
            'vueData' => [
                'records' => [
                    'dataset_upload' => Module::$upload_object,
                ],
                'save_url' => route('setup.wdpas.save'),
                'job_id' => Str::uuid()->toString(),
            ],
        ]);
    }

    /**
     * Save the protected areas' dataset.
     *
     * @throws Exception
     */
    public function wdpas_save(Request $request): JsonResponse
    {
        $records = Payload::decode($request->input('records'));
        $zipFilePath = Storage::disk(File::TEMP_STORAGE)->path($records['dataset_upload']['temp_filename']);
        $originalFilename = Storage::disk(File::TEMP_STORAGE)->path($records['dataset_upload']['original_filename']);
        $jobId = $request->input('job_id');

        ProtectedAreaUpdaterCSV::updateProtectedAreasAndOECMs($zipFilePath, basename($originalFilename), $jobId);

        return new JsonResponse([
            'status' => 'success',
        ]);
    }

    /**
     * Display the setup done page.
     */
    public function done(): View
    {
        return view('offline.setup.done', [
            'current_step' => 'done',
            'timeline' => self::TIMELINE,
        ]);
    }
}
