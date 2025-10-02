<?php
/** @var array $timeline */
/** @var string $current_step */

?>

@extends('layouts.setup')

@section('setup-content')

    <!-- Logo & title -->
    <img src="{{ asset('icon.png') }}" alt="Logo" class="w-32">
    <div class="text-2xl font-bold text-primary-600">@lang('offline.title')</div>

    <!-- Description -->
    <div class="my-4 text-center">@lang('setup.info.description')</div>

    <!-- Offline Warning -->
    <div class="my-4 mx-10 rounded border border-amber-600 bg-amber-100 text-sm p-4 flex items-center gap-3">
        <i class="fa-solid fa-wifi text-3xl"></i>
        <span>@lang('setup.info.offline_warning')</span>
    </div>

    <!-- Start buttons -->
    <a class="btn-nav big !px-4 !text-xl !tracking-normal" href="{{ route('setup.user') }}">
        Start&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
    </a>

@endsection

