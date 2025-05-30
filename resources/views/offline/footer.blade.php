<?php
use App\Helpers\SoftwareUpdater;
use ModularForms\Helpers\Template;

?>
<section id="imet_footer">

    <!-- Logs -->
    <div>
        <a href="/logs" target="_blank" class="!text-gray-600">
            {!! Template::icon('rectangle-list') !!}
        </a>
        <a href="https://github.com/andreamarelli/imet/releases/latest" target="_blank" class="!text-gray-600">
            <span class="fa-brands fa-fw fa-github"></span>
        </a>
    </div>

    <!-- Version -->
    <div>
        @lang('offline.version'): <span class="font-bold text-primary-600">{{ config('nativephp.version')  }}</span>
    </div>

    <!-- Copyright -->
    <div class="font-bold">{{ config('nativephp.copyright') }}</div>

</section>
