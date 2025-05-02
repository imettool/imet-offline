<?php
use App\Helpers\SoftwareUpdater;
?>
<section id="imet_footer">

    <!-- Logs -->
    @if(Route::current()->getName() !== 'confirm_user')
        <div>
            <a href="/logs" class="!text-gray-600">
                {!! \ModularForms\Helpers\Template::icon('rectangle-list') !!}
            </a>
        </div>
    @endif

    <!-- Version -->
    <div>
        @lang('offline.version'): <span class="font-bold text-primary-600">{{ config('nativephp.version')  }}</span>
    </div>

    <!-- Copyright -->
    <div class="font-bold">{{ config('nativephp.copyright') }}</div>

</section>
