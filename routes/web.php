<?php

use ModularForms\Controllers\UploadFileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->group(function () {

    Route::get('/', function () { return Redirect::to('confirm_user'); });
    Route::view('home', 'offline.home')->name('home');

    // Settings routes
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('settings/update', [SettingsController::class, 'update'])->name('settings_update');

    // User routes
    Route::get('confirm_user', [UserController::class, 'confirm_offline_user'])->name('confirm_user');
    Route::patch('confirm_user', [UserController::class, 'update_offline_user'])->name('update_offline_user');

    // ###### File upload/download ######
    Route::post('file/upload', [UploadFileController::class, 'upload'])->name('upload.file');
    Route::get('file/{hash}', [UploadFileController::class, 'download'])->name('file');

    // Debug/dev
    Route::get('info', function (){ return phpinfo(); });

});

