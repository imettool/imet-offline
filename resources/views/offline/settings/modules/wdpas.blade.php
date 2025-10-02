<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;

$isSetup = Str::contains(Route::current()->getName(), 'setup');

?>

<div class="module-container" id="module_setting_offline_user">

    <div class="module-header">
        <div class="module-title">{{ ucfirst(trans('setup.wdpas.timeline')) }}</div>
    </div>

    <div class="module-bar info-bar">
        <div class="icon"><span class="fas fa-fw fa-info-circle text-lg"></span></div>
        <div class="message">
            @if($isSetup)
                <div>@lang('setup.wdpas.info')</div>
            @else
                <div>@lang('settings.wdpas.info')</div>
            @endif
        </div>
    </div>
    <div class="module-bar info-bar">
        <div class="icon"><span class="fas fa-fw fa-at text-lg"></span></div>
        <div class="message">
            <div class="font-bold">@lang('setup.citation'):</div>
            <span class="italic">@lang('setup.wdpas.citation')</span>
        </div>
    </div>
    <div class="module-bar bg-amber-100">
        <div class="icon"><span class="fas fa-fw fa-wifi text-lg"></span></div>
        <div class="message">
            <span class="italic">@lang('setup.wdpas.warning')</span>
        </div>
    </div>

    <div class="module-body">

        <div class="text-lg font-bold italic mt-2 mb-4">@lang('setup.please_follow_instructions')</div>

        <div class="setup_instructions" id="protected_planet_upload">

            <!-- Browse -->
            <div>
                <div>1</div>
                <div>{!! trans('setup.wdpas.instructions.browse') !!}</div>
            </div>

            <!-- Navigate -->
            <div>
                <div>2</div>
                <div>{!! trans('setup.wdpas.instructions.navigate') !!}</div>
            </div>

            <!-- Download -->
            <div>
                <div>3</div>
                <div>{!! trans('setup.wdpas.instructions.download') !!}</div>
            </div>

            <!-- Upload -->
            <div>
                <div>4</div>
                <div>
                    {!! trans('setup.wdpas.instructions.upload') !!}
                    <upload :disabled="storeStarted || storeCompleted"
                            :max-file-size=40000000
                            upload-url="{{ route('upload.file') }}"
                            :allowed-formats="['zip']"
                        {!! DOM::vueAttributes("'dataset_upload'", 'records.dataset_upload') !!}
                    ></upload>
                </div>
            </div>

            <!-- Apply -->
            <div :class="{'opacity-50': !uploaded}">
                <div>5</div>
                <div :class="{'blur-xs': !uploaded}">
                    {!! trans('setup.wdpas.instructions.apply') !!}
                    <div class="flex gap-3">
                        <button v-show="uploaded && !storeStarted" @click=storeDataset
                                class="btn-nav">@uclang('modular-forms::common.save')</button>
                        <progress-bar v-if="storeStarted" :value="storeProgress" color="#005f5a"></progress-bar>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div :class="{'opacity-50': !storeCompleted}">
                <div>6</div>
                <div :class="{'blur-xs': !storeCompleted}">
                    <div>{!! trans('setup.wdpas.instructions.completed') !!}</div>
                    @if($isSetup)
                        <div>{!! trans('setup.wdpas.instructions.update') !!}</div>
                    @endif
                </div>
            </div>

            <!-- Next -->
            @if($isSetup)
                <div :class="{'opacity-50': !storeCompleted}">
                    <div>7</div>
                    <div :class="{'blur-xs': !storeCompleted}">
                        {!! trans('setup.wdpas.instructions.next') !!}
                        <br />
                        <a v-show="storeCompleted" :class="{'disabled pointer-events-none': !storeCompleted}"
                           href="{{ route('setup.done') }}"
                           class="btn-nav">@uclang('offline.actions.proceed')</a>
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>



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

        (new window.OfflineImet.ProtectedPlanetUploadApp(@json($vueData)))
            .mount('#protected_planet_upload');

    </script>

@endpush
