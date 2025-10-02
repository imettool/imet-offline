<?php
/** @var array $timeline */
/** @var string $current_step */
/** @var array $user */

?>


@extends('layouts.setup')

@section('setup-content')

    <!-- Timeline -->
    @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

    <!-- User -->
    <div class="mt-4 w-full">
        @include('offline.settings.modules.user', ['user' => $user])
    </div>

@endsection

