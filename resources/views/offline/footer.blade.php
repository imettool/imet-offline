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

    <div class="flex gap-1">

        <!-- Logs -->
        <a href="{{ route('log-list') }}" class="!text-gray-600">
            {!! Template::icon('bug') !!}
        </a>

        <!-- Logs Viewer (only DEV) -->
        @if(ImetEnv::isDevEnv())
            <a href="/logs" target="_blank" class="!text-gray-600">
                {!! Template::icon('rectangle-list') !!}
            </a>
        @endif

        <!-- GitHub -->
        <a href="https://github.com/imettool/imet/" target="_blank" class="!text-gray-600">
            <span class="fa-brands fa-fw fa-github"></span>
        </a>

    </div>

    <!-- Version -->
    <div class="flex gap-3">
        <div class="font-bold">@lang('offline.version')</div>
        <div><span class="italic">IMET Offline Tool </span>: <span class="font-bold text-primary-600">{{ ImetEnv::getVersion() }}</span></div>
        <div><span class="italic">imet-core </span>: <span class="font-bold text-primary-600">{{ ImetEnv::getCoreVersion() }}</span></div>
    </div>

</section>


@push('scripts')
    <script type="module">
        (new window.OfflineImet.CheckUpdatesApp())
            .mount('#update_footer');
    </script>
@endpush
