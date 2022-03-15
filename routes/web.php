<?php

use AndreaMarelli\ImetCore\Controllers\ProtectedAreaController;
use AndreaMarelli\ImetCore\Controllers\SpeciesController;
use AndreaMarelli\ModularForms\Controllers\UploadFileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/', function () { return Redirect::to('confirm_user'); });

    // User routes
    Route::get('confirm_user', [UserController::class, 'confirm_offline_user']);
    Route::patch('confirm_user', [UserController::class, 'update_offline_user'])->name('update_offline_user');


    Route::get('file/{hash}',      [UploadFileController::class, 'download']);

    Route::prefix('ajax')->group(function () {
        Route::post('upload', [UploadFileController::class, 'upload']);
        Route::get('download', [UploadFileController::class, 'download']);
        Route::group(['prefix' => 'search'], function () {
            Route::post('protected_areas', [ProtectedAreaController::class, 'search']);
            Route::post('species', [SpeciesController::class, 'search']);
        });
    });

});

