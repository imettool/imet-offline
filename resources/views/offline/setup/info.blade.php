<?php
/** @var array $timeline */
/** @var string $current_step */

?>

@extends('modular-forms::layouts.forms')

@section('content')

    <div class="flex flex-col items-center">

        <!-- Logo & title -->
        <img src="{{ asset('icon.png') }}" alt="Logo" class="w-32">
        <div class="text-2xl font-bold text-primary-600">@lang('offline.title')</div>

        <!-- Description -->
        <div class="my-4 text-center">@lang('offline.setup.description')</div>

        <!-- Offline Warning -->
        <div class="my-4 mx-10 rounded border border-amber-600 bg-amber-100 text-sm p-4 flex items-center gap-3">
            <i class="fa-solid fa-wifi text-3xl"></i>
            <span>@lang('offline.setup.offline_warning')</span>
        </div>

        <!-- Start buttons -->
        <a class="btn-nav big !px-4 !text-xl !tracking-normal" href="{{ route('setup.user') }}">
            Start&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

    <style>
        .content{
            min-width: 850px !important;
            max-width: 1050px !important;
        }
    </style>


@endsection

