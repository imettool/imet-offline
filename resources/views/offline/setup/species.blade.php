<?php
/** @var array $timeline */
/** @var string $current_step */
/** @var array $vueData */

use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;

?>

@extends('modular-forms::layouts.forms')

@section('content')

    <div class="flex flex-col items-center">

        <!-- Logo & title -->
        <img src="{{ asset('icon.png') }}" alt="Logo" class="w-32">
        <div class="text-2xl font-bold text-primary-600">@lang('offline.title')</div>

        <!-- Timeline -->
        @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

        <!-- Instruction -->
        <div class="w-full mt-4 module-container" id="module_setting_offline_user">
            <div class="module-header">
                <div class="module-title">{{ ucfirst(trans('setup.timeline.species.title')) }}</div>
            </div>

            <!-- Dataset info -->
            <div class="module-bar info-bar">
                <div class="icon"><span class="fas fa-fw fa-info-circle text-lg"></span></div>
                <div class="message">
                    <span>@lang('setup.species_info')</span>
                </div>
            </div>

            <div class="module-body">

                <div class="text-lg font-bold italic mt-2 mb-4">@lang('setup.please_follow_instructions')</div>

                <div class="setup_instructions" id="species_setup">

                    <div>
                        <div class=""><i class="fa-solid fa-play"></i></div>
                        <div>
                            {!! trans('setup.species_instruction') !!}
                            <div class="text-center">
                                <button v-show="!taskStarted" @click=storeDataset class="btn-nav big my-4 cursor-pointer uppercase">
                                    @uclang('modular-forms::common.save')
                                </button>
                                <progress-bar class="my-4" v-if="taskStarted" :value="taskProgress" color="#005f5a"></progress-bar>
                                <a v-show="taskCompleted" href="{{ route('setup.wdpas') }}"
                                   class="btn-nav big my-4 cursor-pointer uppercase">@uclang('setup.next')</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>

    <style>
        .content {
            min-width: 850px !important;
            max-width: 1050px !important;
        }
        .progress-bar{
            color: oklch(0.777 0.152 181.912) !important;
            height: 24px;
        }
        .progress-bar .label{
            top: 5% !important;
        }
    </style>

@endsection



@push('scripts')
    <script type="module">

        (new window.OfflineImet.SpeciesSetupApp(@json($vueData)))
            .mount('#species_setup');

    </script>
@endpush
