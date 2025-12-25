<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title') - Food Ordering System</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo_v3.png') }}">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
        
        /* User Dropdown Styles */
        .dropdown-menu {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa !important;
        }
        
        .dropdown-item:active {
            background-color: #ec7f13 !important;
            color: white !important;
        }
        
        .dark .dropdown-menu {
            background-color: #2d231a !important;
            border-color: #4b5563 !important;
        }
        
        .dark .dropdown-item {
            color: #d1d5db !important;
        }
        
        .dark .dropdown-item:hover {
            background-color: #374151 !important;
            color: #fff !important;
        }
        
        .dark .dropdown-item.text-danger {
            color: #ef4444 !important;
        }
        
        .dark .dropdown-item.text-danger:hover {
            background-color: #7f1d1d !important;
            color: #fff !important;
        }
        
        .dark .dropdown-divider {
            border-color: #4b5563 !important;
        }
        
        /* Global Size Reduction */
        h1 { font-size: 1.75rem !important; }
        h2 { font-size: 1.5rem !important; }
        h3 { font-size: 1.25rem !important; }
        h4 { font-size: 1.125rem !important; }
        h5 { font-size: 1rem !important; }
        h6 { font-size: 0.875rem !important; }
        
        /* Reduce button sizes */
        .btn {
            padding: 0.375rem 0.75rem !important;
            font-size: 0.875rem !important;
        }
        .btn-lg {
            padding: 0.5rem 1rem !important;
            font-size: 0.9375rem !important;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.8125rem !important;
        }
        
        /* Reduce input sizes */
        .form-control, .form-select {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
        }
        
        /* Reduce card padding */
        .card-body {
            padding: 1rem !important;
        }
        .card-header {
            padding: 0.75rem !important;
        }
        
        /* Reduce table cell padding */
        .table td, .table th {
            padding: 0.5rem !important;
            font-size: 0.875rem !important;
        }
        
        /* Reduce icon sizes */
        .material-symbols-outlined {
            font-size: 1.25rem !important;
        }
        .material-symbols-outlined.text-xl {
            font-size: 1.125rem !important;
        }
        .material-symbols-outlined.text-2xl {
            font-size: 1.25rem !important;
        }
        .material-symbols-outlined.text-3xl {
            font-size: 1.5rem !important;
        }
        
        /* Reduce spacing */
        .mb-8 { margin-bottom: 1.5rem !important; }
        .mb-6 { margin-bottom: 1.25rem !important; }
        .mb-4 { margin-bottom: 1rem !important; }
        .mb-3 { margin-bottom: 0.75rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .p-8 { padding: 1.5rem !important; }
        .p-6 { padding: 1.25rem !important; }
        .p-4 { padding: 1rem !important; }
        .p-3 { padding: 0.75rem !important; }
        .px-6 { padding-left: 1rem !important; padding-right: 1rem !important; }
        .px-4 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
        .py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        .gap-6 { gap: 1rem !important; }
        .gap-4 { gap: 0.75rem !important; }
        .gap-3 { gap: 0.5rem !important; }
        
        /* Reduce text sizes */
        .text-4xl { font-size: 1.75rem !important; line-height: 2rem !important; }
        .text-3xl { font-size: 1.5rem !important; line-height: 1.75rem !important; }
        .text-2xl { font-size: 1.25rem !important; line-height: 1.5rem !important; }
        .text-xl { font-size: 1.125rem !important; line-height: 1.5rem !important; }
        .text-lg { font-size: 1rem !important; line-height: 1.375rem !important; }
        
        /* Reduce rounded sizes */
        .rounded-2xl { border-radius: 0.75rem !important; }
        .rounded-xl { border-radius: 0.5rem !important; }
        .rounded-lg { border-radius: 0.375rem !important; }
        
        /* Sidebar Styles */
        aside {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 transparent;
        }
        
        aside::-webkit-scrollbar {
            width: 6px;
        }
        
        aside::-webkit-scrollbar-track {
            background: transparent;
        }
        
        aside::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 3px;
        }
        
        aside::-webkit-scrollbar-thumb:hover {
            background-color: #a0aec0;
        }
        
        .dark aside::-webkit-scrollbar-thumb {
            background-color: #4b5563;
        }
        
        .dark aside::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
        
        /* Responsive: Hide sidebar on mobile for admin */
        @media (max-width: 768px) {
            aside {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            aside.show {
                transform: translateX(0);
            }
            
            .flex-grow-1[style*="margin-left: 260px"] {
                margin-left: 0 !important;
            }
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
    
    <div class="min-vh-100 d-flex flex-column" style="background-color: var(--background-light, #f8f7f6);">
        
        @auth
        @if(auth()->user()->hasRole('admin'))
        {{-- Admin Layout with Sidebar --}}
        <div class="d-flex" style="min-height: 100vh;">
            {{-- Sidebar Navigation --}}
            <aside class="position-fixed start-0 top-0 h-100 bg-white dark:bg-background-dark border-end border-gray-200 dark:border-gray-800 shadow-sm" style="width: 260px; z-index: 50; overflow-y: auto;">
                <div class="d-flex flex-column h-100 p-3">
                    {{-- Logo/Brand --}}
                    <div class="mb-4 pb-3 border-bottom border-gray-200 dark:border-gray-800">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle" style="width: 40px; height: 40px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('{{ asset('img/logo_v3.png') }}');"></div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark dark:text-white">Admin Panel</h5>
                                <small class="text-muted">Quản lý hệ thống</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Navigation Items --}}
                    <div class="flex-grow-1">
                        @include('layout.nav')
                    </div>
                </div>
            </aside>
            
            {{-- Main Content Area --}}
            <div class="flex-grow-1" style="margin-left: 260px;">
        @endif
        @endauth

        {{-- Top App Bar --}}
        <header class="sticky top-0 z-40 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-gray-800 px-4 py-3 shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    @auth
                    @if(!auth()->user()->hasRole('admin'))
                    <div class="position-relative">
                        <div class="rounded-circle" style="width: 40px; height: 40px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}&background=ec7f13&color=fff'); border: 2px solid #f3f4f6;"></div>
                        <div class="position-absolute bottom-0 end-0 rounded-circle border border-white border-2" style="width: 12px; height: 12px; background-color: #28a745;"></div>
                    </div>
                    @endif
                    @endauth
                    <div>
                        <h1 class="mb-0 fw-bold" style="font-size: 18px; line-height: 1.2;">
                            @yield('header-title', $pagename ?? 'Trang')
                        </h1>
                        <p class="mb-0 small text-secondary fw-medium">
                            @yield('header-subtitle', 'Chi nhánh 1 - Ca Sáng')
                        </p>
                    </div>
                </div>
                @auth
                <div class="d-flex align-items-center gap-2">
                    @if(auth()->user()->hasRole('customer'))
                        <a href="{{ route('cart.index') }}" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center border shadow-sm position-relative" 
                           style="width: 40px; height: 40px; background-color: white; border-color: #f3f4f6 !important; text-decoration: none;">
                            <span class="material-symbols-outlined text-dark">shopping_cart</span>
                            @php
                                $cartCount = \App\Models\TemporaryOrder::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                    {{-- Notifications Dropdown --}}
                    <div class="dropdown position-relative">
                        <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center border shadow-sm position-relative" 
                                type="button" 
                                id="notificationDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="width: 40px; height: 40px; background-color: white; border-color: #f3f4f6 !important;">
                            <span class="material-symbols-outlined text-dark">notifications</span>
                            <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; display: none;">0</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="notificationDropdown" style="min-width: 350px; max-width: 400px; max-height: 500px; overflow-y: auto; margin-top: 8px; border-radius: 12px; padding: 8px;">
                            <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Thông báo</h6>
                                <button class="btn btn-sm btn-link text-decoration-none p-0" id="markAllReadBtn" style="font-size: 12px;">Đánh dấu tất cả đã đọc</button>
                            </li>
                            <li>
                                <div id="notificationsList" class="px-2">
                                    <div class="text-center py-4 text-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 32px;">notifications_none</span>
                                        <p class="mb-0 mt-2 small">Chưa có thông báo</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    {{-- User Dropdown --}}
                    <div class="dropdown position-relative">
                        <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center border shadow-sm" 
                                type="button" 
                                id="userDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="width: 40px; height: 40px; background-color: white; border-color: #f3f4f6 !important; padding: 0;">
                            <div class="rounded-circle" style="width: 32px; height: 32px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}&background=ec7f13&color=fff');"></div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown" style="min-width: 250px; margin-top: 8px; border-radius: 12px; padding: 8px;">
                            {{-- User Info --}}
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle" style="width: 48px; height: 48px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}&background=ec7f13&color=fff');"></div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-semibold" style="font-size: 14px; color: #1f2937;">
                                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                        </p>
                                        <p class="mb-0 text-muted" style="font-size: 12px;">
                                            {{ auth()->user()->email }}
                                        </p>
                                        <span class="badge bg-primary mt-1" style="font-size: 10px; font-weight: 500;">
                                            {{ auth()->user()->role->name ?? 'User' }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            
                            {{-- Menu Items --}}
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.index') }}" style="font-size: 14px; border-radius: 8px;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">person</span>
                                    <span>Thông tin cá nhân</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('settings.index') }}" style="font-size: 14px; border-radius: 8px;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">settings</span>
                                    <span>Cài đặt</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" style="font-size: 14px; border-radius: 8px; border: none; background: none; width: 100%; text-align: left;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">logout</span>
                                        <span>Đăng xuất</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @endauth
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-grow-1" style="padding-bottom: @auth @if(!auth()->user()->hasRole('admin')) 80px @else 0 @endif @else 0 @endauth;">
            @yield('content')
        </main>

        {{-- Bottom Navigation: role-based (hidden for admin) --}}
        @auth
        @if(!auth()->user()->hasRole('admin'))
        <nav class="position-fixed bottom-0 start-0 end-0" style="height: 64px; background-color: rgba(255, 255, 255, 0.95); border-top: 1px solid #dee2e6; z-index: 40; padding-bottom: 20px;">
            <div class="d-flex h-100 align-items-center justify-content-around px-1" style="font-size: 12px;">
                @if(auth()->user()->hasRole('staff'))
                    {{-- Staff: Home, Đặt món, Menu --}}
                    <a href="{{ route('home.staff') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none
                        @isset($pagename)
                            @if ($pagename == 'Home')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">home</span>
                        <span style="font-size: 11px; font-weight: 600;">Trang chủ</span>
                    </a>

                    <a href="{{ route('staff.orders.select-table') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none
                        @isset($pagename)
                            @if ($pagename == 'Chọn bàn' || $pagename == 'Đặt món')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">table_restaurant</span>
                        <span style="font-size: 11px; font-weight: 600;">Đặt món</span>
                    </a>

                    <a href="{{ route('menu.index') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none
                        @isset($pagename)
                            @if ($pagename == 'Menu')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">restaurant_menu</span>
                        <span style="font-size: 11px; font-weight: 600;">Menu</span>
                    </a>

                @elseif(auth()->user()->hasRole('customer'))
                    {{-- Customer: Home, Menu, Help --}}
                    <a href="{{ route('home.customer') }}" class="flex flex-1 flex-col items-center justify-center gap-0.5
                        @isset($pagename)
                            @if ($pagename == 'Home')
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

                    <a href="{{ route('menu.customer') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none
                        @isset($pagename)
                            @if ($pagename == 'Menu')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">restaurant_menu</span>
                        <span style="font-size: 11px; font-weight: 600;">Menu</span>
                    </a>

                    <a href="{{ route('cart.index') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none position-relative
                        @isset($pagename)
                            @if ($pagename == 'Cart')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">shopping_cart</span>
                        <span style="font-size: 11px; font-weight: 600;">Giỏ hàng</span>
                        @php
                            $cartCount = \App\Models\TemporaryOrder::where('user_id', auth()->id())->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('customer.orders.index') }}" class="d-flex flex-column flex-fill align-items-center justify-content-center text-decoration-none
                        @isset($pagename)
                            @if ($pagename == 'Orders')
                                text-warning
                            @else
                                text-secondary
                            @endif
                        @else
                            text-secondary
                        @endisset
                    " style="gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
                        <span style="font-size: 11px; font-weight: 600;">Đơn hàng</span>
                    </a>
                @endif
            </div>
        </nav>
        @endif
        @endauth

        @auth
        @if(auth()->user()->hasRole('admin'))
            </div>
        </div>
        @endif
        @endauth

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

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

            // Load notifications
            @auth
            loadNotifications();
            loadUnreadCount();

            // Refresh notifications every 10 seconds
            setInterval(() => {
                loadNotifications();
                loadUnreadCount();
            }, 10000);

            // Mark all as read
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    fetch('{{ route("notifications.mark-all-read") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(() => {
                        loadNotifications();
                        loadUnreadCount();
                    });
                });
            }
            @endauth
        });

        @auth
        function loadNotifications() {
            fetch('{{ route("notifications.index") }}')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('notificationsList');
                    if (!container) return;

                    if (data.data && data.data.length > 0) {
                        let html = '';
                        data.data.slice(0, 10).forEach(notif => {
                            const icon = notif.type === 'new_order' ? 'receipt_long' : 
                                        notif.type === 'payment_success' ? 'payments' : 
                                        'notifications';
                            const bgClass = notif.is_read ? 'bg-white' : 'bg-light';
                            html += `
                                <div class="dropdown-item p-3 ${bgClass} border-bottom" style="cursor: pointer; ${!notif.is_read ? 'border-left: 3px solid #ec7f13;' : ''}" onclick="markAsRead(${notif.id})">
                                    <div class="d-flex gap-2">
                                        <span class="material-symbols-outlined text-primary">${icon}</span>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold" style="font-size: 14px;">${notif.title}</h6>
                                            <p class="mb-1 small text-secondary">${notif.message}</p>
                                            <small class="text-muted">${new Date(notif.created_at).toLocaleString('vi-VN')}</small>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `
                            <div class="text-center py-4 text-secondary">
                                <span class="material-symbols-outlined" style="font-size: 32px;">notifications_none</span>
                                <p class="mb-0 mt-2 small">Chưa có thông báo</p>
                            </div>
                        `;
                    }
                })
                .catch(error => console.error('Error loading notifications:', error));
        }

        function loadUnreadCount() {
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                            badge.style.display = 'block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error loading unread count:', error));
        }

        function markAsRead(id) {
            fetch(`{{ route("notifications.mark-read", ":id") }}`.replace(':id', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(() => {
                loadNotifications();
                loadUnreadCount();
            });
        }
        @endauth
    </script>

</body>
</html>