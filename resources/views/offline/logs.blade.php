<?php
/** @var array $log_files */
use ModularForms\Helpers\DOM;
use ModularForms\Helpers\Template;
use ModularForms\Models\Module;

?>

@extends('layouts.base')

@section('content')

    <h1 class="mb-8">@lang('offline.logs.logs-title')</h1>

    <div class="mt-4 mb-6 rounded border border-amber-600 bg-amber-100 p-4 flex items-center gap-3">
        <i class="fa-solid fa-circle-info text-3xl"></i>
        @lang('offline.logs.logs-info')
    </div>

    @if(count($log_files)>0)

        @foreach($log_files as $file)
            <div class="my-2 rounded bg-gray-100 p-4">
                <a href="{{ route('log-download', ['log' => $file]) }}">
                    <i class="fa-solid fa-download pr-2"></i> {{ $file }}
                </a>
            </div>
        @endforeach

    @else
        <div class="text-gray-600 font italic">
            @lang('offline.logs.no_logs')
        </div>

    @endif

@endsection
