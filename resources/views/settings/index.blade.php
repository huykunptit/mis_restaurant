@extends('layout.app')

@php $pagename = "Cài đặt" @endphp

@section('title')
    @isset($pagename) {{ $pagename }} @endisset
@endsection

@section('header-title', 'Cài đặt')
@section('header-subtitle', 'Tùy chỉnh cài đặt hệ thống')

@section('content')
<div class="p-6 lg:p-10 bg-background-light dark:bg-background-dark min-h-screen">
    <div class="max-w-3xl mx-auto">
        {{-- Breadcrumb --}}
        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-primary transition-colors">Trang chủ</a>
            <span class="material-symbols-outlined text-lg mx-2">chevron_right</span>
            <span>Cài đặt</span>
        </div>

        {{-- Settings Card --}}
        <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Header --}}
            <div class="bg-primary p-6 text-white">
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined">settings</span>
                    Cài đặt hệ thống
                </h2>
                <p class="text-white/80 mt-2">Tùy chỉnh các cài đặt theo sở thích của bạn</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('settings.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <p class="text-green-800 dark:text-green-200 flex items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                {{-- Notification Settings --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">notifications</span>
                        Thông báo
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Thông báo đơn hàng</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nhận thông báo khi có đơn hàng mới</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Thông báo thanh toán</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nhận thông báo khi có thanh toán mới</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">palette</span>
                        Hiển thị
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Chế độ hiển thị
                            </label>
                            <select 
                                id="theme" 
                                name="theme"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                            >
                                <option value="light">Sáng</option>
                                <option value="dark">Tối</option>
                                <option value="auto">Tự động</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Language Settings --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">language</span>
                        Ngôn ngữ
                    </h3>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ngôn ngữ hiển thị
                        </label>
                        <select 
                            id="language" 
                            name="language"
                            class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                        >
                            <option value="vi" selected>Tiếng Việt</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('home.' . auth()->user()->role->name) }}" 
                       class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors font-medium">
                        Hủy
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors font-medium flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Lưu cài đặt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

