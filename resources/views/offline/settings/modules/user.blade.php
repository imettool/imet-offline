<?php

use App\Models\User;
use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Input\SelectionList;

/** @var User $user */
?>


<div class="module-container" id="module_setting_offline_user">
    <div class="module-header">
        <div class="module-title">{{ ucfirst(trans('offline.settings.user.title')) }}</div>
    </div>

    <div class="module-body">

        {{-- fisrt name --}}
        @component('modular-forms::module.components.field_container', [
                'name' => 'first_name',
                'label' => ucfirst(trans('auth.user.first_name')),
                'label_width' => 2
            ])
            <simple-text {!! DOM::vueAttributes("'first_name'", 'records.first_name') !!}></simple-text>
        @endcomponent

        {{-- last name--}}
        @component('modular-forms::module.components.field_container', [
                'name' => 'last_name',
                'label' => ucfirst(trans('auth.user.last_name')),
                'label_width' => 2
            ])
            <simple-text {!! DOM::vueAttributes("'last_name'", 'records.last_name') !!}></simple-text>
        @endcomponent

        {{-- organisation --}}
        @component('modular-forms::module.components.field_container', [
                'name' => 'organisation',
                'label' => ucfirst(trans('auth.user.organisation')),
                'label_width' => 2
            ])
            <simple-text {!! DOM::vueAttributes("'organisation'", 'records.organisation') !!}></simple-text>
        @endcomponent

        {{-- function --}}
        @component('modular-forms::module.components.field_container', [
                'name' => 'function',
                'label' => ucfirst(trans('auth.user.function')),
                'label_width' => 2
            ])
            <simple-text {!! DOM::vueAttributes("'function'", 'records.function') !!}></simple-text>
        @endcomponent

        {{-- country --}}
        @component('modular-forms::module.components.field_container', [
                'name' => 'function',
                'label' => ucfirst(trans('auth.user.country')),
                'label_width' => 2
            ])
            <dropdown
                data-values='@json(SelectionList::getList('Country'))'
                {!! DOM::vueAttributes("'country'", 'records.country') !!}
            ></dropdown>
        @endcomponent

    </div>
    @include('modular-forms::module.components.bars.save')

</div>


@push('scripts')
    <script type="module">

        (new window.OfflineImet.SettingsApp(@json($user)))
            .mount('#module_setting_offline_user');

    </script>
@endpush

<?php
