@php
use \Illuminate\Support\Str;

use Native\Laravel\Facades\AutoUpdater;

AutoUpdater::checkForUpdates();

@endphp

@extends('modular-forms::layouts.forms')

@section('content')

    <div class="flex flex-col items-center">

        <!-- Logo & title -->
        <img src="{{ asset('icon.png') }}" alt="Logo" class="w-32">
        <div class="text-2xl font-bold text-primary-600">@lang('offline.title')</div>

        <!-- Description -->
        <div class="mt-4">@lang('offline.description')</div>

        <!-- Start buttons -->
        <div class="flex flex-row gap-4">

            <!-- IMET -->
            <a href="{{ route('imet-core::index') }}" class="btn-nav big mt-4 !font-bold !px-5">
                {!! Str::upper(trans('imet-core::common.imet_short')) !!}
            </a>

            <!-- OECM -->
            <a href="{{ route('imet-core::oecm.index') }}" class="btn-nav big mt-4 !font-bold !px-5">
                {!! Str::upper(trans('imet-core::oecm_common.oecm_short')) !!}
            </a>

        </div>

    </div>


@endsection
