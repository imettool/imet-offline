<?php
/** @var Array $vueData */
/** @var Array $user */
/** @var Array $countries */
/** @var Array $updated_pas_countries */

use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;

?>

@extends('layouts.base')

@section('content')

    <h1 class="mb-8">@lang('settings.page_title')</h1>

{{--    <!-- Proxy settings -->--}}
{{--    TODO: Work in progress--}}
{{--    @include('offline.settings.modules.proxy', compact('vueData'))--}}

    <!-- User settings -->
    @include('offline.settings.modules.user', compact('user'))

@endsection
