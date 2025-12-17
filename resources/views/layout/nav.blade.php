
{{-- If user is logged-in --}}
@auth
        
    {{-- Admin --}}
    @if(auth()->user()->hasRole('admin'))

        <a href="{{ route('home.admin') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "Dashboard" || $pagename == "Home") bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p>Dashboard</p>
            </div>
        </a>
        <a href="{{ route('orders.admin') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "Home" && !isset($filledTables)) bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p>Đơn hàng</p>
            </div>
        </a>

        <a href="{{ route('tables.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "Table") bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v3c0 .5523.44772 1 1 1h10.5M3 15v-4m0 4h11M3 11V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v5M3 11h18m0 0v1M8 11v8m4-8v8m4-8v2m1 4h2m0 0h2m-2 0v2m0-2v-2"/>
                </svg>
                <p>Bàn</p>
            </div>
        </a>

        <a href="{{ route('category.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "Category") bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <p>Danh mục</p>
            </div>
        </a>

        <a href="{{ route('menu.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "Menu") bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <p>Menu</p>
            </div>
        </a>

        <a href="{{ route('user.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-green-50 hover:text-green-700 rounded-r-lg @isset($pagename) @if ($pagename == "User") bg-green-50 text-green-700 @else text-gray-600 @endif @else text-gray-600 @endisset transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <p>Người dùng</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700 rounded-r-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <p>Đăng xuất</p>
            </button>
        </form>

    {{-- Staff --}}
    @elseif(auth()->user()->hasRole('staff'))

        <a href="{{ route('home.staff') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 @isset($pagename) @if ($pagename == "Home") text-green-800 border-r-4 border-green-800 @endif @endisset text-gray-400 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Trang chủ</p>
            </div>
        </a>

        <a href="{{ route('menu.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 @isset($pagename) @if ($pagename == "Menu") text-green-800 border-r-4 border-green-800 @endif @endisset text-gray-400 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Menu</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700 rounded-r-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <p>Đăng xuất</p>
            </button>
        </form>

    {{-- Customer --}}
    @elseif(auth()->user()->hasRole('customer'))

        <a href="{{ route('home.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 @isset($pagename) @if ($pagename == "Home") text-green-800 border-r-4 border-green-800 @endif @endisset text-gray-400 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Trang chủ</p>
            </div>
        </a>

        <a href="{{ route('menu.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 @isset($pagename) @if ($pagename == "Menu") text-green-800 border-r-4 border-green-800 @endif @endisset text-gray-400 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Menu</p>
            </div>
        </a>

        <a href="{{ route('help.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 @isset($pagename) @if ($pagename == "Help") text-green-800 border-r-4 border-green-800 @endif @endisset text-gray-400 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Hỗ trợ</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700 rounded-r-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <p>Đăng xuất</p>
            </button>
        </form>

    @endif
    
@endauth