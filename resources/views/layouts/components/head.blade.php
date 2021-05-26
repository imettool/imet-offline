<title>IMET v{{ imet_offline_version() }}</title>

{{-- lang --}}
<script src="{{ asset(mix('lang.js', 'assets')) }}"></script>
{{-- vendors --}}
<link rel="stylesheet" href="{{ asset(mix('vendor.css', 'assets')) }}">
<script src="{{ asset(mix('vendor.js', 'assets')) }}"></script>
{{-- packages --}}
<script src="{{ asset(mix('modular-forms.js', 'assets')) }}"></script>
<script src="{{ asset(mix('imet-core.js', 'assets')) }}"></script>
{{-- custom --}}
<link rel="stylesheet" href="{{ asset(mix('app.css', 'assets')) }}">
<script src="{{ asset(mix('app.js', 'assets')) }}"></script>

@if(Route::getCurrentRequest()
    && \Str::contains(Route::getCurrentRequest()->url(), 'admin/imet/')
    && \Str::contains(Route::getCurrentRequest()->url(), 'report'))
    <script src="{{ asset(mix('vendor_mapping_leaflet.js', 'assets')) }}"></script>
@endif
