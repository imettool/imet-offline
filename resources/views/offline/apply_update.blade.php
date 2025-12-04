<?php
/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

?>


@extends('layouts.base')

@section('content')

    <div class="text-3xl mb-4 highlight">@lang('offline.actions.applying_updated')</div>
    <div class="text-xl">@lang('offline.actions.please_wait')</div>

@endsection


@push('scripts')
    <style>
        main.one-col{
            display: flex;
            flex-direction: column;
        }
        .content{
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush


