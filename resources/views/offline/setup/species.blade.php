<?php
/** @var array<string> $timeline */
/** @var string $current_step */
/** @var array $vueData */

use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;

?>


@extends('layouts.setup')

@section('setup-content')

    <!-- Timeline -->
    @include('offline.setup.components.timeline', ['timeline' => $timeline, 'current_step' => $current_step])

    <!-- Instruction -->
    <div class="w-full mt-4 module-container" id="module_setting_offline_user">
        <div class="module-header">
            <div class="module-title">{{ ucfirst(trans('setup.species.timeline')) }}</div>
        </div>

        <div class="module-bar info-bar">
            <div class="icon"><span class="fas fa-fw fa-info-circle text-lg"></span></div>
            <div class="message">
                <span>@lang('setup.species.info')</span>
            </div>
        </div>
        <div class="module-bar info-bar">
            <div class="icon"><span class="fas fa-fw fa-at text-lg"></span></div>
            <div class="message">
                <div class="font-bold">@lang('setup.citation'):</div>
                <span class="italic">@lang('setup.species.citation')</span>
            </div>
        </div>

        <div class="module-body">

            <div class="text-lg font-bold italic mt-2 mb-4">@lang('setup.please_follow_instructions')</div>

            <div class="setup_instructions" id="species_setup">

                <div>
                    <div class=""><i class="fa-solid fa-play"></i></div>
                    <div>
                        {!! trans('setup.species.instructions') !!}
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

@endsection

@push('scripts')

    <style>
        .progress-bar{
            color: oklch(0.777 0.152 181.912) !important;
            height: 24px;
        }
        .progress-bar .label{
            top: 5% !important;
        }
    </style>

    <script type="module">

        (new window.OfflineImet.SpeciesSetupApp(@json($vueData)))
            .mount('#species_setup');

    </script>

@endpush
