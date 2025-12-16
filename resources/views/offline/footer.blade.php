<?php

use App\Helpers\ImetEnv;
use ModularForms\Helpers\Template;

?>

<section id="update_footer">

    <!-- Check for updates -->
    <div>
        <span v-if="status === STATUSES['CHECKING']">@lang('offline.update.checking')</span>
        <span v-else-if="status === STATUSES['NOT_AVAILABLE']">@lang('offline.update.not_available')</span>
        <span v-else-if="status === STATUSES['AVAILABLE']" class="highlight font-bold">
            @lang('offline.update.available'): <span v-html="newVersion"></span>
        </span>
        <span v-else-if="status === STATUSES['DOWNLOADING']">
            @lang('offline.update.downloading'): <span v-html="downloadProgress"></span>
        </span>
        <span v-else-if="status === STATUSES['DOWNLOADED']" class="highlight flex items-center gap-2">
            @lang('offline.update.downloaded')
        </span>
        <span v-else-if="status === STATUSES['ERROR']" class="error">@lang('offline.update.error')</span>

    </div>

</section>


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
        @lang('offline.version'): <span class="font-bold text-primary-600">{{ ImetEnv::getVersion() }}</span>
    </div>

    <!-- Copyright -->
    <div class="font-bold">{{ config('nativephp.copyright') }}</div>

</section>


@push('scripts')
    <script type="module">
        (new window.OfflineImet.CheckUpdatesApp())
            .mount('#update_footer');
    </script>
@endpush
