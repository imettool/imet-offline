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


use App\Jobs\DummyJob;
use App\Jobs\UpdateProtectedAreas;
use App\Models\JobProgress;
use App\Models\ProtectedArea;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ModularForms\Helpers\File\File;
use ModularForms\Models\Module;
use ModularForms\Models\Traits\Payload;
use Str;

class SetupController extends Controller
{

    /**
     * Display the setup page if the application is in its first boot.
     * Redirect to home page if the application is not in its first boot.
     */
    public function index()
    {
        // If first boot, redirect to the setup page
        if(ProtectedArea::count()<=50){
            return redirect()->route('setup.info');
        }

        // If not first boot, redirect to the home page
        return redirect()->route('home');
    }

    /**
     * Display the setup info page.
     */
    public function info(): View
    {
        return view('offline.setup.info', [
            'current_step' => 'info',
            'timeline' => trans('setup.timeline')
        ]);
    }

    /**
     * Display the setup user page.
     */
    public function user(): View
    {
        return view('offline.setup.user', [
            'current_step' => 'user',
            'timeline' => trans('setup.timeline'),
            'user' => [
                'records' => Auth::user()
                    ->toArray(),
                'module_key' => 'offline_user',
                'save_url' => route('setup.user.save')
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
        if(!empty($messages)){
            return [
                'status' => 'validation_error',
                'errors' => $messages
            ];
        }

        // Save the user profile
        $user = (new User())->update_offline($records);


        return [
            'id' => 0,
            'status' => 'success',
            'records' => $user->toArray(),
            'redirect_to' => route('setup.wdpas'),
        ];
    }

    /**
     * Display the setup protected areas page.
     */
    public function wdpas(): View
    {
        return view('offline.setup.wdpas', [
            'current_step' => 'wdpas',
            'timeline' => trans('setup.timeline'),
            'vueData' => [
                'records' => [
                    'dataset_upload' => Module::$upload_object
                ],
                'save_url' => route('setup.wdpas.save'),
                'progress_url' => route('setup.wdpas.progress', ['jobId' => 'xxxx']),
            ]
        ]);
    }

    /**
     * Save the protected areas dataset.
     */
    public function wdpas_save(Request $request)
    {
        $records = Payload::decode($request->input('records'));
        $zipFilePath = Storage::disk(File::TEMP_STORAGE)->path($records['dataset_upload']['temp_filename']);
        $originalFilename = Storage::disk(File::TEMP_STORAGE)->path($records['dataset_upload']['original_filename']);

        $jobId = Str::uuid()->toString();
        UpdateProtectedAreas::dispatch( $zipFilePath, basename($originalFilename), $jobId);
        return response()->json([
            'status' => 'success',
            'jobId' => $jobId
        ]);
    }

    /**
     * Get the progress of the protected areas dataset import job.
     */
    public function wdpa_progress(Request $request, string $jobId)
    {
        $progress = JobProgress::find($jobId)?->progress;
        $progress = $progress>=100 ? 100 : $progress;
        return $progress ?? 0;
    }

    /**
     * Display the setup done page.
     */
    public function done(): View
    {
        return view('offline.setup.done', [
            'current_step' => 'done',
            'timeline' => trans('setup.timeline')
        ]);
    }


}
