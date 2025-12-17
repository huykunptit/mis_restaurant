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

    {{-- Poppins Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    {{-- Nunito --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    {{-- Lobster --}}
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

</head>
<body>

    {{-- Success and Error Message --}}
    @include('layout.message')

    <div class="grid grid-cols-3 h-screen bg-gradient-to-b from-green-900 via-green-900 to-green-700">

        <div class="col-span-3 lg:col-span-1 shadow-2xl w-full flex flex-col items-center justify-center p-5 bg-white rounded-none lg:rounded-r-3xl">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-40 text-green-900 mb-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
            </svg>
            
            <form autocomplete="off" action="{{ route('login') }}" method="post" class="w-full flex flex-col items-center">

                @csrf

                <div class="space-y-3 w-3/5 mb-4">
                    <p class="font-semibold">Địa chỉ email</p>
                    <input type="text" placeholder="Vui lòng nhập địa chỉ email" name="email" value="{{ old('email') }}" class="focus:outline-none border-3 border-gray-400 focus:border-green-500 rounded-lg p-2 w-full @error('email') border-red-500 bg-red-200 @enderror" required>
                    
                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-3 w-3/5">
                    <p class="font-semibold">Mật khẩu</p>
                    <input type="password" placeholder="Vui lòng nhập mật khẩu" name="password" class="focus:outline-none border-3 border-gray-400 focus:border-green-500 rounded-lg p-2 w-full @error('email') border-red-500 bg-red-200 @enderror" required>

                    @error('password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="rounded-2xl flex flex-row items-center justify-center space-x-2 py-3 w-3/5 bg-green-800 hover:bg-green-600 text-white font-bold mt-10 transform hover:scale-105 transition duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <p>Đăng nhập</p>
                </button>

                <div class="visible lg:hidden text-xs mb-5 text-green-800 font-bold absolute bottom-0 p-4 flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    
                </div>

            </form>

        </div>

        <div class="relative lg:col-span-2 h-full bg-gradient-to-b from-green-900 via-green-900 to-green-700 hidden lg:flex flex-col items-center justify-center">

            <p class="text-white font-bold text-4xl p-10 text-center">Chào mừng đến với ứng dụng đặt đồ ăn tại Bear 1997</p>

            <div class="w-0 lg:w-2/3 autoplay text-white text-sm text-center">
                <div>
                    <p class="">Nhanh chóng.</p>
                </div>
                <div>
                    <p class="">Tiện lợi.</p>
                </div>
                <div>
                    <p class="">Đa dạng</p>
                </div>
            </div>

            <div class="text-xs text-white absolute bottom-0 p-4 flex flex-row items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                
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