<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title') - Admin - Food Ordering System</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo_v3.png') }}">

    {{-- Tailwind CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Local CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}"/>

    {{-- Custom scrollbar hiding for cleaner mobile look --}}
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        body {
            min-height: 100vh;
        }
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 500,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>
				
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
<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden selection:bg-primary selection:text-white">

    {{-- Success and Error Message --}}
    @include('layout.message')
    
    <div class="min-h-screen flex flex-col bg-background-light dark:bg-background-dark">

        {{-- Top App Bar --}}
        <header class="sticky top-0 z-40 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-9 ring-2 ring-gray-100 dark:ring-gray-800" style="background-image: url('{{ asset('img/logo_v3.png') }}');"></div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Bảng điều khiển</p>
                    <h1 class="text-base font-bold leading-tight">
                        @yield('header-title', 'Admin')
                    </h1>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="hidden sm:inline text-xs text-gray-500 dark:text-gray-400">
                    {{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}
                </span>
                <div class="relative">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-9 ring-2 ring-gray-100 dark:ring-gray-800" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}&background=ec7f13&color=fff');"></div>
                    <div class="absolute bottom-0 right-0 size-2.5 bg-green-500 rounded-full border-2 border-white dark:border-background-dark"></div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 pb-24">
            @yield('content')
        </main>

        {{-- Bottom Navigation - Admin --}}
        @if(auth()->check() && auth()->user()->hasRole('admin'))
        <nav class="fixed bottom-0 left-0 right-0 z-40 h-16 bg-white/95 dark:bg-card-dark/95 border-t border-gray-200 dark:border-gray-800 backdrop-blur-sm">
            <div class="flex h-full items-center justify-around px-1 text-xs">
                {{-- Dashboard --}}
                <a href="{{ route('home.admin') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Dashboard' || $pagename == 'Home')
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">home</span>
                    <span class="text-[11px] font-semibold">Trang chủ</span>
                </a>

                {{-- Orders --}}
                <a href="{{ route('orders.admin') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Home' && !isset($filledTables))
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                    <span class="text-[11px] font-semibold">Đơn hàng</span>
                </a>

                {{-- Tables --}}
                <a href="{{ route('tables.index') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Table')
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">grid_view</span>
                    <span class="text-[11px] font-semibold">Sơ đồ bàn</span>
                </a>

                {{-- Menu --}}
                <a href="{{ route('menu.index') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Menu')
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">restaurant_menu</span>
                    <span class="text-[11px] font-semibold">Menu</span>
                </a>

                {{-- Customers --}}
                <a href="{{ route('admin.customers.index') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Customer')
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">person</span>
                    <span class="text-[11px] font-semibold">Khách hàng</span>
                </a>

                {{-- Staffs --}}
                <a href="{{ route('admin.staffs.index') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5 
                    @isset($pagename)
                        @if ($pagename == 'Staff')
                            text-primary
                        @else
                            text-gray-500 dark:text-gray-400
                        @endif
                    @else
                        text-gray-500 dark:text-gray-400
                    @endisset
                ">
                    <span class="material-symbols-outlined text-xl">badge</span>
                    <span class="text-[11px] font-semibold">Nhân viên</span>
                </a>
            </div>
        </nav>
        @endif

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

    {{-- Disable-and-loading state for forms to prevent double submits --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form[data-disable-on-submit="true"]').forEach(form => {
                form.addEventListener('submit', () => {
                    form.querySelectorAll('button[type="submit"]').forEach(button => {
                        const loadingText = button.dataset.loadingText || 'Đang xử lý...';
                        button.dataset.originalText = button.innerHTML;
                        button.innerHTML = loadingText;
                        button.classList.add('opacity-60', 'cursor-not-allowed');
                        button.disabled = true;
                    });
                });
            });
        });
    </script>

</body>
</html>


