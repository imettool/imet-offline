<?php
/** @var array $timeline */
/** @var string $current_step */
/** @var array $vueData */

use ModularForms\Models\Module;

?>


@extends('layouts.setup')

@section('setup-content')

    <!-- Timeline -->
    @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

    <!-- Instruction -->
    <div class="w-full mt-4">
        @include('offline.settings.modules.wdpas', ['vueData' => $vueData])
    </div>

@endsection
