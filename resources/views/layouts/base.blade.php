<?php
use Illuminate\Support\Facades\Session;

if (Session::has('lists')) {
    Session::forget('lists');
}

?>

@extends('modular-forms::layouts.base')

@section('body')

    <body class="flex flex-col">

        <header>
            @include('offline.header')
        </header>

        <main class="one-col">
            <section class="content">

                @yield('content')

            </section>
        </main>

        <footer>
            @include('offline.footer')
        </footer>

    </body>

@endsection
