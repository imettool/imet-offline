<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Input\SelectionList;

/** @var array<string, string|array<string, scalar>> $user */

?>


<div class="module-container" id="module_setting_offline_user">

    <div class="module-header">
        <div class="module-title">{{ ucfirst(trans('settings.user.title')) }}</div>
    </div>

    <div class="module-bar info-bar">
        <div class="icon"><span class="fas fa-fw fa-info-circle text-lg"></span></div>
        <div class="message">
            <span>@lang('setup.user.info')</span>
        </div>
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

    @if(Str::contains(Route::current()->getName(), 'setup'))
        <div class="module-bar save-bar" v-if="status === 'complete'">
            <div class="message"></div>
            <div class="buttons">
                <a href="{{ route('setup.species') }}" class="btn-nav big">@uclang('setup.next')</a>
            </div>
        </div>
    @endif

</div>


@push('scripts')
    <script type="module">
        (new window.OfflineImet.UserProfileApp(@json($user)))
            .mount('#module_setting_offline_user');
    </script>
@endpush
