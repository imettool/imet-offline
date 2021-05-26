<?php

use AndreaMarelli\ImetCore\Controllers\ProtectedAreaController;
use AndreaMarelli\ImetCore\Controllers\SpeciesController;
use AndreaMarelli\ImetCore\Controllers\StaffController;
use AndreaMarelli\ModularForms\Controllers\UploadFileController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { return Redirect::to('admin/confirm_user'); });
Route::get('welcome', function () { return Redirect::to('admin/confirm_user'); });
Route::get('admin', function () { return Redirect::to('admin/confirm_user'); });

Route::get('file/{hash}',      [UploadFileController::class, 'download']);

Route::get('admin/confirm_user', function () { return view('imet-core::offline.confirm_user'); });
Route::get('admin/offline_user', function () { return view('imet-core::offline.edit_user'); });
Route::patch('admin/staff/{item}', [StaffController::class, 'update_offline']);

Route::group(['prefix' => 'ajax'], function () {
    Route::post('upload', [UploadFileController::class, 'upload']);
    Route::get('download', [UploadFileController::class, 'download']);
    Route::group(['prefix' => 'search'], function () {
        Route::post('protected_areas', [ProtectedAreaController::class, 'search']);
        Route::post('species', [SpeciesController::class, 'search']);
    });
});
