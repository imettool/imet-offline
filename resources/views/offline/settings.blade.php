<?php
/** @var Array $vueData */
/** @var Array $countries */
/** @var Array $updated_pas_countries */

use AndreaMarelli\ModularForms\Helpers\DOM;
use AndreaMarelli\ModularForms\Helpers\Template;

?>

@extends('layouts.base')

@section('content')

    <h1 class="mb-8">@lang('offline.settings.page_title')</h1>

    <!-- Proxy settings -->
    <div class="module-container" id="module_settings_proxy">
        <div class="module-header">
            <div class="module-title">{{ ucfirst(trans('offline.settings.proxy.title')) }}</div>
        </div>
        <div class="module-bar info-bar">
            <div class="icon">{!! Template::icon('info-circle', '', '1.4em') !!}</div>
            <div class="message">@lang('offline.settings.proxy.description')</div>
        </div>
        <div class="module-body p-2">

            @foreach(['proxy_host', 'proxy_port', 'proxy_user'] as $field)
                @component('modular-forms::module.components.field_container', [
                    'name' => $field,
                    'label' => ucfirst(trans('offline.settings.proxy.fields.'.$field)),
                    'label_width' => 2
                ])
                    <simple-text {!! DOM::vueAttributes("'$field'", 'records.' . $field) !!}></simple-text>
                @endcomponent
            @endforeach

                @component('modular-forms::module.components.field_container', [
                    'name' => 'proxy_password',
                    'label' => ucfirst(trans('offline.settings.proxy.fields.proxy_password')),
                    'label_width' => 2
                ])
                    <simple-password {!! DOM::vueAttributes("'proxy_password'", 'records.proxy_password') !!}></simple-password>
                @endcomponent

        </div>
        @include('modular-forms::module.components.bars.save')
    </div>

    <!-- API keys -->
    <div class="module-container" id="module_settings_api_keys">
        <div class="module-header">
            <div class="module-title">{{ ucfirst(trans('offline.settings.api_keys.title')) }}</div>
        </div>
        <div class="module-body">

            @component('modular-forms::module.components.field_container', [
                'name' => 'protected_planet_api_key',
                'label' => ucfirst(trans('offline.settings.api_keys.fields.protected_planet_api_key')),
                'label_width' => 2
            ])
                <simple-password {!! DOM::vueAttributes("'protected_planet_api_key'", 'records.protected_planet_api_key') !!}></simple-password>
                <span class="italic ml-2">@lang('offline.settings.api_keys.protected_planet_api_key_description')</span>
            @endcomponent

        </div>
        @include('modular-forms::module.components.bars.save')

    </div>

    <!-- Protected areas -->
    <div class="module-container" id="module_settings_protected_areas">
        <div class="module-header">
            <div class="module-title">{{ ucfirst(trans('offline.settings.protected_areas.title')) }}</div>
        </div>
        <div class="module-body">

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
                @foreach($countries as $country)
                    <PasCountryUpdate
                        iso2="{{ $country->iso2 }}"
                        iso3="{{ $country->iso3 }}"
                        name="{{ $country->name }}"
                        :downloaded="{{ in_array($country->iso3, array_keys($updated_pas_countries)) ? 'true': 'false' }}"
                        updated="{{ $updated_pas_countries[$country->iso3] ?? null }}"
                    ></PasCountryUpdate>
                @endforeach
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script type="module">

        (new window.OfflineImet.SettingsApp(@json($vueData + ['module_key' => 'proxy'])))
            .mount('#module_settings_proxy');

        (new window.OfflineImet.SettingsApp(@json($vueData + ['module_key' => 'api_keys'])))
            .mount('#module_settings_api_keys');

        (new window.OfflineImet.PaUpdate())
            .mount('#module_settings_protected_areas');

    </script>
@endpush
