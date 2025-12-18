
{!! Vite::useBuildDirectory('build')->withEntryPoints(['resources/index.js'])->toHtml() !!}


@push('scripts')

    <script type="module">
        (new window.OfflineImet.HotKeysApp())
            .mount('#imet_footer');
    </script>

@endpush
