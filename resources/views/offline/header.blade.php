<?php
use ModularForms\Helpers\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Helpers\SoftwareUpdater;

$current_route = Route::current()->getName();

?>


@if($current_route == 'confirm_user')
    <div id="imet_header" class="!justify-center !py-3">
        <div class="font-bold !text-primary-600 !text-xl">@lang('offline.title')</div>
    </div>
@else

    <div id="imet_header">

        <!-- left menu -->
        <ul class="menu-header">

            <!-- Home -->
            @if($current_route !== 'home')
                <li>
                    <a href="{{ route('home') }}" class="!text-primary-600">
                        {!! Template::icon('home') !!}
                    </a>
                </li>
            @endif

            <!-- Breadcrumbs -->
            @if(Str::contains($current_route, 'imet-core::'))
                <span>/</span>
                @if(Str::contains($current_route, 'oecm'))
                    <li>
                        <a href="{{ route('imet-core::oecm.index') }}">
                            @lang('imet-core::oecm_common.oecm_short')
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('imet-core::index') }}">
                            @lang('imet-core::common.imet_short')
                        </a>
                    </li>
                @endif
            @endif

        </ul>

        <!-- right menu -->
        <ul class="menu-header">

            <!-- Settings -->
            <li>
                <a href="{{ route('settings') }}" >{!! Template::icon('gear') !!}</a>
            </li>

            <!-- Language selector -->
            <li>
                <a>{!! Template::flag(strtolower(App::getLocale()), '') !!}</a>
                <ul class="language_selector">
                    <li>@lang('imet-core::common.switch_language'):</li>
                    @foreach(trans('imet-core::common.languages') as $lang=>$label)
                        <li>
                            <a href="{{ url()->current() }}?lang={{ $lang }}">
                                {!! Template::flag($lang, '') !!}
                                {{ ucfirst($label) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

        </ul>
    </div>

@endif
