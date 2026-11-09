<?php
use ModularForms\Helpers\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

$current_route = Route::current()->getName();
$isSetup = Str::contains($current_route, 'setup.');

?>

    <div id="imet_header">

        <!-- left menu -->
        <ul class="menu-header">

            <!-- Home -->
            @if($current_route !== 'home' && !$isSetup)
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

            <!-- User profile -->
            @if(!$isSetup)
                <li>
                    <span class="italic">{{ Auth::user()->getName() }}</span>
                </li>
            @endif

            <!-- Settings -->
            @if(!$isSetup)
                <li>
                    <a href="{{ route('settings') }}" >{!! Template::icon('gear') !!}</a>
                </li>
            @endif

            <!-- Language selector -->
            <li>
                @include('layouts.components.language-selector')
            </li>

        </ul>
    </div>
