<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ get_title($title ?? '') }} </title>

        <link rel="stylesheet" href="{{ asset('styles_css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">

        <!-- Section PWA -->
        @include('layouts.partials.meta')

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <header>
            @include('layouts.partials.menu_top')
        </header>
        
        <!-- <div class="mt-5 alert alert-warning alert-dismissible fade show" id="offline_banner" role="alert">
            Vous êtes hors ligne maintenant
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> -->
        
        <div class="mt-5">
            @yield('main_content')
        </div>
        
        <div class="mt-n5">
            @include('layouts.partials.footer')
        </div>

        {{-- @stack('modals') --}}

        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/indexdDB.js') }}"></script>
        <!-- <script src="{{ asset('js/register_sw.js') }}"></script> -->

        @livewireScripts
        @yield('script_js')
    </body>
</html>