<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Đăng nhập - Bear 1997 </title>

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
				
    {{-- Livewire Styles --}}
    <livewire:styles />

    {{-- Slick CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}"/>
    
    {{-- SweetAlert V2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="font-display" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- Success and Error Message --}}
    @include('layout.message')

    <div class="grid grid-cols-3 h-screen bg-gradient-to-br from-primary via-orange-600 to-amber-600">

        <div class="col-span-3 lg:col-span-1 shadow-2xl w-full flex flex-col items-center justify-center p-5 bg-white rounded-none lg:rounded-r-3xl">

            {{-- Logo --}}
            <div class="mb-10 flex flex-col items-center">
                <div class="w-32 h-32 rounded-full bg-primary flex items-center justify-center shadow-lg mb-4">
                    <span class="material-symbols-outlined text-white text-6xl">restaurant</span>
                </div>
                <h1 class="text-3xl font-bold text-primary" style="font-family: 'Plus Jakarta Sans', sans-serif;">Bear 1997</h1>
                <p class="text-gray-600 text-sm mt-1">Quán bia hơi</p>
            </div>
            
            <form autocomplete="off" action="{{ route('login') }}" method="post" class="w-full flex flex-col items-center">

                @csrf

                <div class="space-y-3 w-3/5 mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Địa chỉ email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">email</span>
                        <input type="text" placeholder="Vui lòng nhập địa chỉ email" name="email" value="{{ old('email') }}" class="focus:outline-none border-2 border-gray-300 dark:border-gray-600 focus:border-primary rounded-lg pl-10 pr-4 py-3 w-full bg-white dark:bg-gray-800 dark:text-white @error('email') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror" required>
                    </div>
                    
                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-3 w-3/5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Mật khẩu</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">lock</span>
                        <input type="password" placeholder="Vui lòng nhập mật khẩu" name="password" class="focus:outline-none border-2 border-gray-300 dark:border-gray-600 focus:border-primary rounded-lg pl-10 pr-4 py-3 w-full bg-white dark:bg-gray-800 dark:text-white @error('password') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror" required>
                    </div>

                    @error('password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="rounded-xl flex flex-row items-center justify-center gap-2 py-3.5 w-3/5 bg-primary hover:bg-primary/90 text-white font-bold mt-10 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <span class="material-symbols-outlined">login</span>
                    <span>Đăng nhập</span>
                </button>


            </form>

        </div>

        <div class="relative lg:col-span-2 h-full bg-gradient-to-br from-primary via-orange-600 to-amber-600 hidden lg:flex flex-col items-center justify-center">

            <div class="text-center px-10">
                <h2 class="text-white font-bold text-5xl mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">Chào mừng đến với</h2>
                <h1 class="text-white font-bold text-6xl mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Bear 1997</h1>
                <p class="text-white/90 text-xl">Quán bia hơi & Ẩm thực</p>
            </div>

            <div class="w-0 lg:w-2/3 autoplay text-white text-lg font-semibold text-center mt-8">
                <div>
                    <p class="flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">bolt</span>
                        Nhanh chóng
                    </p>
                </div>
                <div>
                    <p class="flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">check_circle</span>
                        Tiện lợi
                    </p>
                </div>
                <div>
                    <p class="flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">restaurant_menu</span>
                        Đa dạng
                    </p>
                </div>
            </div>

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