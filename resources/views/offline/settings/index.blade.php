<?php
/** @var Array $vueData */
/** @var Array $user */
/** @var Array $countries */
/** @var Array $updated_pas_countries */

use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;
use ModularForms\Models\Module;

?>

@extends('layouts.base')

@section('content')

    <h1 class="mb-8">@lang('settings.page_title')</h1>

    <!-- User settings -->
    @include('offline.settings.modules.user', compact('user'))

    <!-- WDPA settings -->
    @include('offline.settings.modules.wdpas', ['vueData' => [
        'records' => [
            'dataset_upload' => Module::$upload_object
        ],
        'save_url' => route('setup.wdpas.save'),
        'job_id' => Str::uuid()->toString()
    ]])

@endsection
