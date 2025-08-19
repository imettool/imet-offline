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

use ModularForms\Controllers\UploadFileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->group(function () {

    Route::get('/', function () { return Redirect::to('home'); });
    Route::view('home', 'offline.home')->name('home');

    // Settings routes
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('settings/update', [SettingsController::class, 'update'])->name('settings_update');

    // User routes
    Route::patch('update_offline_user', [UserController::class, 'update_offline_user'])->name('update_offline_user');

    // ###### File upload/download ######
    Route::post('file/upload', [UploadFileController::class, 'upload'])->name('upload.file');
    Route::get('file/{hash}', [UploadFileController::class, 'download'])->name('file');

    // Debug/dev
    Route::get('info', function (){ return phpinfo(); });

});

