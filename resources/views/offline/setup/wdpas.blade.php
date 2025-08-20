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

        @if($current_step === 'wdpas')

        @endif

        <!-- Timeline -->
        @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

    </div>

    <style>
        .content{
            min-width: 850px !important;
            max-width: 1050px !important;
        }
    </style>


@endsection

