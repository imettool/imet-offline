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

use App\Http\Controllers\AppController;
use App\Http\Controllers\SetupController;
use ModularForms\Controllers\UploadFileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->group(function (): void {

    Route::get('/', [SetupController::class, 'index']);
    Route::view('home', 'offline.home')->name('home');

    // Setup routes
    Route::prefix('setup')->group(function (): void {
        Route::get('/', [SetupController::class, 'info'])->name('setup.info');
        Route::get('user', [SetupController::class, 'user'])->name('setup.user');
        Route::patch('user', [SetupController::class, 'user_save'])->name('setup.user.save');
        Route::get('species', [SetupController::class, 'species'])->name('setup.species');
        Route::patch('species', [SetupController::class, 'species_save'])->name('setup.species.save');
        Route::get('wdpas', [SetupController::class, 'wdpas'])->name('setup.wdpas');
        Route::patch('wdpas', [SetupController::class, 'wdpas_save'])->name('setup.wdpas.save');
        Route::get('done', [SetupController::class, 'done'])->name('setup.done');
    });

    // Settings routes
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('settings/update', [SettingsController::class, 'update'])->name('settings_update');
    Route::patch('update_offline_user', [SettingsController::class, 'user'])->name('update_offline_user');

    // ###### File upload/download ######
    Route::post('file/upload', [UploadFileController::class, 'upload'])->name('upload.file');
    Route::get('file/{hash}', [UploadFileController::class, 'download'])->name('file');

    // Updater
    Route::get('apply_update', [AppController::class, 'apply_update'])->name('apply_update');

    // Debug/dev
    Route::get('info', fn(): true => phpinfo());

});

