<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Section PWA -->
        @include('layouts.partials.meta')

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('styles_css/bootstrap.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <header>
            @include('layouts.partials.menu_top')
        </header>
        <!-- <div class="container-fluid">
            <div class="row col-md-3 offset-md-4"> -->
                {{ $slot }}
            <!-- </div>
        </div> -->
        <div>
            @include('layouts.partials.footer')
        </div>

        <script src="{{ asset('js/bootstrap.js') }}"></script>
    </body>
</html>
