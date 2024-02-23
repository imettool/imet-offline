{{-- hardcoded accessToken (not possible to push it into .env.imetoffline through updates --}}
@include('imet-core::layouts.components.assets', [
    'mapbox_token' => 'pk.eyJ1IjoiYmxpc2h0ZW4iLCJhIjoiMEZrNzFqRSJ9.0QBRA2HxTb8YHErUFRMPZg'
])

{{-- local assets --}}
<script src="{{ asset(mix('index.js', 'assets')) }}"></script>
<link rel="stylesheet" href="{{ asset(mix('index.css', 'assets')) }}">
