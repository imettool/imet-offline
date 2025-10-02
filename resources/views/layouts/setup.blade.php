@extends('modular-forms::layouts.forms')

@section('content')

    <div class="flex flex-col items-center">

        @yield('setup-content')

    </div>

@endsection

@push('scripts')
    <style>
        .content{
            min-width: 850px !important;
            max-width: 1050px !important;
            padding: 30px 0 0 0 !important;
        }
    </style>
@endpush
