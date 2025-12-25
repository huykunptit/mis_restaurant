@extends('layout.app')

@php $pagename = "Thông tin cá nhân" @endphp

@section('title')
    @isset($pagename) {{ $pagename }} @endisset
@endsection

@section('header-title', 'Thông tin cá nhân')
@section('header-subtitle', 'Quản lý thông tin tài khoản của bạn')

@section('content')
<div class="p-6 lg:p-10 bg-background-light dark:bg-background-dark min-h-screen">
    <div class="max-w-3xl mx-auto">
        {{-- Breadcrumb --}}
        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-primary transition-colors">Trang chủ</a>
            <span class="material-symbols-outlined text-lg mx-2">chevron_right</span>
            <span>Thông tin cá nhân</span>
        </div>

        {{-- Profile Card --}}
        <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Header --}}
            <div class="bg-primary p-6 text-white">
                <div class="flex items-center gap-4">
                    <div class="rounded-full" style="width: 80px; height: 80px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=fff&color=ec7f13&size=160'); border: 3px solid white;"></div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        <p class="text-white/80 mb-2">{{ $user->email }}</p>
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold">
                            {{ $user->role->name ?? 'User' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="p-6">
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

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <p class="text-red-800 dark:text-red-200 flex items-center gap-2">
                            <span class="material-symbols-outlined">error</span>
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <ul class="list-disc list-inside text-red-800 dark:text-red-200">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Personal Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">person</span>
                        Thông tin cá nhân
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Họ
                            </label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                value="{{ old('first_name', $user->first_name) }}"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                                required
                            >
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tên
                            </label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                value="{{ old('last_name', $user->last_name) }}"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                                required
                            >
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                            required
                        >
                    </div>
                </div>

                {{-- Password Change --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">lock</span>
                        Đổi mật khẩu
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Để trống nếu không muốn đổi mật khẩu</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mật khẩu hiện tại
                            </label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                            >
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mật khẩu mới
                            </label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                            >
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Xác nhận mật khẩu mới
                            </label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation"
                                class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:bg-card-dark dark:text-white"
                            >
                        </div>
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
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

