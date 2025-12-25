
{{-- If user is logged-in --}}
@auth
        
    {{-- Admin --}}
    @if(auth()->user()->hasRole('admin'))

        <a href="{{ route('home.admin') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Dashboard" || $pagename == "Home") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">home</span>
                <p>Dashboard</p>
            </div>
        </a>
        <a href="{{ route('orders.admin') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Home" && !isset($filledTables)) bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">receipt_long</span>
                <p>Đơn hàng</p>
            </div>
        </a>

        <a href="{{ route('tables.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Table") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">grid_view</span>
                <p>Sơ đồ bàn</p>
            </div>
        </a>

        <a href="{{ route('category.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Category") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">category</span>
                <p>Danh mục</p>
            </div>
        </a>

        <a href="{{ route('menu.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Menu") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">restaurant_menu</span>
                <p>Menu</p>
            </div>
        </a>

        <a href="{{ route('admin.customers.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Customer") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">person</span>
                <p>Khách hàng</p>
            </div>
        </a>

        <a href="{{ route('admin.staffs.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Staff") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">badge</span>
                <p>Nhân viên</p>
            </div>
        </a>

        <a href="{{ route('admin.shifts.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Shift") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">schedule</span>
                <p>Ca làm việc</p>
            </div>
        </a>

        <a href="{{ route('admin.attendances.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-semibold hover:bg-primary-light dark:hover:bg-primary/20 hover:text-primary rounded-r-lg @isset($pagename) @if ($pagename == "Attendance") bg-primary-light dark:bg-primary/20 text-primary @else text-gray-600 dark:text-gray-400 @endif @else text-gray-600 dark:text-gray-400 @endisset transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">event_available</span>
                <p>Chấm công</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-400 rounded-r-lg transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">logout</span>
                <p>Đăng xuất</p>
            </button>
        </form>

    {{-- Staff --}}
    @elseif(auth()->user()->hasRole('staff'))

        <a href="{{ route('home.staff') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-primary border-r-0 hover:border-r-4 hover:border-primary @isset($pagename) @if ($pagename == "Home") text-primary border-r-4 border-primary @endif @endisset text-gray-400 dark:text-gray-500 transition-all duration-400">
                <span class="material-symbols-outlined ml-2 text-3xl">home</span>
                <p class="opacity-0 group-hover:opacity-100">Trang chủ</p>
            </div>
        </a>

        <a href="{{ route('menu.index') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-primary border-r-0 hover:border-r-4 hover:border-primary @isset($pagename) @if ($pagename == "Menu") text-primary border-r-4 border-primary @endif @endisset text-gray-400 dark:text-gray-500 transition-all duration-400">
                <span class="material-symbols-outlined ml-2 text-3xl">restaurant_menu</span>
                <p class="opacity-0 group-hover:opacity-100">Menu</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-400 rounded-r-lg transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">logout</span>
                <p>Đăng xuất</p>
            </button>
        </form>

    {{-- Customer --}}
    @elseif(auth()->user()->hasRole('customer'))

        <a href="{{ route('home.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-primary border-r-0 hover:border-r-4 hover:border-primary @isset($pagename) @if ($pagename == "Home") text-primary border-r-4 border-primary @endif @endisset text-gray-400 dark:text-gray-500 transition-all duration-400">
                <span class="material-symbols-outlined ml-2 text-3xl">home</span>
                <p class="opacity-0 group-hover:opacity-100">Trang chủ</p>
            </div>
        </a>

        <a href="{{ route('menu.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-primary border-r-0 hover:border-r-4 hover:border-primary @isset($pagename) @if ($pagename == "Menu") text-primary border-r-4 border-primary @endif @endisset text-gray-400 dark:text-gray-500 transition-all duration-400">
                <span class="material-symbols-outlined ml-2 text-3xl">restaurant_menu</span>
                <p class="opacity-0 group-hover:opacity-100">Menu</p>
            </div>
        </a>

        <a href="{{ route('help.customer') }}">
            <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-primary border-r-0 hover:border-r-4 hover:border-primary @isset($pagename) @if ($pagename == "Help") text-primary border-r-4 border-primary @endif @endisset text-gray-400 dark:text-gray-500 transition-all duration-400">
                <span class="material-symbols-outlined ml-2 text-3xl">help</span>
                <p class="opacity-0 group-hover:opacity-100">Hỗ trợ</p>
            </div>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex flex-row items-center space-x-4 py-3 pl-2 font-semibold text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-400 rounded-r-lg transition-all duration-300">
                <span class="material-symbols-outlined ml-2 text-2xl">logout</span>
                <p>Đăng xuất</p>
            </button>
        </form>

    @endif
    
@endauth