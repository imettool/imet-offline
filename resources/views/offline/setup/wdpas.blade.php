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
                <div class="module-title">{{ ucfirst(trans('setup.timeline.wdpas.title')) }}</div>
            </div>
            <!-- Protected Planet citation -->
            <div class="module-bar info-bar">
                <div class="icon"><span class="fas fa-fw fa-info-circle text-lg"></span></div>
                <div class="message">
                    <div class="font-bold">@lang('setup.citation'):</div>
                    <span class="italic">@lang('setup.protected_planet_citation')</span>
                </div>
            </div>

            <div class="module-body">

                <div class="text-lg font-bold italic mt-2 mb-4">Please follow the instruction below</div>

                <div class="setup_wdpa_instructions" id="protected_planet_upload">

                    <!-- Step 1: Browse -->
                    <div>
                        <div>1</div>
                        <div>{!! trans('setup.protected_planet_instructions.browse') !!}</div>
                    </div>

                    <!-- Step 2: Locate -->
                    <div>
                        <div>2</div>
                        <div>{!! trans('setup.protected_planet_instructions.locate') !!}</div>
                    </div>

                    <!-- Step 3: Download -->
                    <div>
                        <div>3</div>
                        <div>{!! trans('setup.protected_planet_instructions.download') !!}</div>
                    </div>

                    <!-- Step 4: Upload -->
                    <div>
                        <div>4</div>
                        <div>
                            {!! trans('setup.protected_planet_instructions.upload') !!}
                            <upload :disabled="storeStarted || storeCompleted"
                                :max-file-size=40000000
                                upload-url="{{ route('upload.file') }}"
                                {!! DOM::vueAttributes("'dataset_upload'", 'records.dataset_upload') !!}
                            ></upload>
                        </div>
                    </div>

                    <!-- Step 5: Apply -->
                    <div :class="{'opacity-50': !uploaded}">
                        <div>5</div>
                        <div :class="{'blur-xs': !uploaded}">
                            {!! trans('setup.protected_planet_instructions.apply') !!}
                            <div class="flex gap-3">
                                <button v-show="uploaded && !storeStarted" @click=storeDataset
                                        class="btn-nav">@uclang('modular-forms::common.save')</button>
                                <progress-bar v-if="storeStarted" :value="storeProgress" color="#005f5a"></progress-bar>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Completed -->
                    <div :class="{'opacity-50': !storeCompleted}">
                        <div>6</div>
                        <div :class="{'blur-xs': !uploaded}">
                            {!! trans('setup.protected_planet_instructions.completed') !!}
                            <br />
                            <a v-show="storeCompleted" :class="{'disabled pointer-events-none': !storeCompleted}"
                                 href="{{ route('setup.done') }}"
                                class="btn-nav">@uclang('offline.actions.proceed')</a>
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

        (new window.OfflineImet.ProtectedPlanetUploadApp(@json($vueData)))
            .mount('#protected_planet_upload');

    </script>
@endpush
