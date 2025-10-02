<?php
/** @var array $timeline */
/** @var string $current_step */

?>

@extends('layouts.setup')

@section('setup-content')

    <!-- Timeline -->
    @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

    <!-- Description -->
    <div class="my-4 text-center">@lang('setup.done.description')</div>

    <!-- Proceed buttons -->
    <a class="btn-nav big !px-4 !text-xl !tracking-normal" href="{{ route('home') }}">
        @uclang('offline.actions.proceed')
    </a>

@endsection

