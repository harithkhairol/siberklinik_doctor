<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title> 

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>

    <div class="relative bg-white">
        <!-- <div class="max-w-7xl mx-auto px-4 sm:px-6"> -->
        <div class="max-w-full mx-auto px-4 sm:px-6">

            @include('layouts.header')
            
        </div>
    </div>

        @include('layouts.header-mobile')
        
    <body>
    

        <div class="bg-gray-50 md:flex min-h-screen w-full">

            @include('layouts.sidebar')

            <div class="w-full">

                @include('layouts.notification')

                @yield('content')   
            
            </div>

                         


        </div>

    </body>
    
</html>

<script src="{{ asset('js/footer.js') }}"></script>

