@extends('layout.app')

@php $pagename = "User" @endphp

@section('title')
    Chỉnh sửa người dùng: {{ $user->first_name .' '. $user->last_name }}
@endsection

@section('content')
<div class="p-6 lg:p-10 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Chỉnh sửa người dùng: {{ $user->first_name .' '. $user->last_name }}</h1>
        
        {{-- Bread Crumb --}}
        <div class="flex items-center text-sm text-gray-600 mt-4">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-green-600 transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('user.index') }}" class="font-medium hover:text-green-600 transition-colors">Người dùng</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Chỉnh sửa</span>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <p class="text-gray-600 mb-6">Thay đổi thông tin trong form bên dưới để cập nhật tài khoản người dùng</p>
        
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                {{-- Role --}}
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Vai trò <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="role" 
                        name="role" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors capitalize @error('role') border-red-500 @enderror" 
                        required
                    >
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ ($user->role->id) == ($role->id) ? 'selected' : '' }} class="capitalize">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label for="firstName" class="block text-sm font-semibold text-gray-700 mb-2">
                            Họ <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="firstName" 
                            name="firstName" 
                            value="{{ old('firstName', $user->first_name) }}" 
                            maxlength="200"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('firstName') border-red-500 @enderror" 
                            placeholder="Nhập họ..."
                            required
                        >
                        @error('firstName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="lastName" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tên <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="lastName" 
                            name="lastName" 
                            value="{{ old('lastName', $user->last_name) }}" 
                            maxlength="200"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('lastName') border-red-500 @enderror" 
                            placeholder="Nhập tên..."
                            required
                        >
                        @error('lastName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Địa chỉ email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            maxlength="200"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('email') border-red-500 @enderror" 
                            placeholder="example@email.com"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mật khẩu mới <span class="text-gray-400 text-xs">(để trống nếu không đổi)</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            maxlength="200"
                            minlength="6"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('password') border-red-500 @enderror" 
                            placeholder="Tối thiểu 6 ký tự"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center space-x-4 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Xác nhận cập nhật</span>
                    </button>
                    <a 
                        href="{{ route('user.index') }}" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-8 py-3 rounded-lg transition-colors duration-200"
                    >
                        Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
