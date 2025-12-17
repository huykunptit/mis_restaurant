<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title') - Food Ordering System</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Poppins Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    {{-- Nunito Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    {{-- Lobster Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo_v3.png') }}">

    {{-- Tailwind CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Local CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}"/>
				
    {{-- Livewire Styles --}}
    <livewire:styles />

    {{-- Slick CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}"/>
    
    {{-- SweetAlert V2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- iCheck Material --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/icheck-material/icheck-material.min.css') }}"/>
    
    {{-- Animate CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>
<body>

    {{-- Success and Error Message --}}
    @include('layout.message')
    
    <div class="h-full flex flex-row bg-white overflow-x-auto">

        {{-- Side Navigation Bar --}}
        <div class="group bg-white border-r border-gray-200 h-full w-64 pt-6 fixed z-30 top-0 left-0 overflow-y-auto overflow-x-hidden transition-all duration-300 shadow-lg flex flex-col">

            @include('layout.nav')

        </div>

        {{-- Content --}}
        <div class="ml-64 w-full min-h-screen overflow-hidden">

            @yield('content')

        </div>

    </div>
    
    
    {{-- Livewire Scripts --}}
    <livewire:scripts />

    {{-- JQuery --}}
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    
    {{-- Slick JS --}}
    <script type="text/javascript" src="{{ asset('slick/slick.min.js') }}"></script>

    {{-- Slick Initiator --}}
    <script type="text/javascript" src="{{ asset('js/slick.js') }}"></script>

</body>
</html>