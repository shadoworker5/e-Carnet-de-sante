<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ get_title($title ?? '') }} </title>

        <link rel="stylesheet" href="{{ asset('styles_css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
        
        @yield('head_file')

        @include('layouts.partials.meta')

        @livewireStyles

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <header>
            @include('layouts.partials.menu_top')
        </header>
        
        <div id="error_network"></div>
        
        <div class="container-fluid mt-5">
            @yield('main_content')
        </div>
        
        <div>
            @include('layouts.partials.footer')
        </div>

        @stack('modals')

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/indexdDB.js') }}" async></script>
        <script src="{{ asset('js/Chart.min.js') }}"></script>
        <script src="{{ asset('js/register_sw.js') }}"></script>
        
        @livewireScripts
        @yield('script_js')
    </body>
</html>