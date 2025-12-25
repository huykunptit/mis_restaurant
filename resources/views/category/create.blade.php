@extends('layout.app')

@php $pagename = "Category" @endphp

@section('title')
    Thêm danh mục mới
@endsection

@section('content')
<div class="container-fluid px-3 px-sm-4 px-lg-5 py-4 py-sm-5 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Thêm danh mục mới</h1>
        
        {{-- Bread Crumb --}}
        <div class="flex items-center text-sm text-gray-600 mt-4">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-primary transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('category.index') }}" class="font-medium hover:text-primary transition-colors">Danh mục</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Thêm mới</span>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        <p class="text-gray-600 mb-6">Vui lòng điền thông tin vào form bên dưới</p>
        
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                {{-- Category Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tên danh mục <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        maxlength="200"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('name') border-red-500 @enderror" 
                        placeholder="Ví dụ: Món chính, Đồ uống, Tráng miệng..."
                        required
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center space-x-4 pt-4">
                    <button 
                        type="submit" 
                        class="bg-primary hover:hover:bg-primary/90 text-white font-semibold px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Xác nhận tạo</span>
                    </button>
                    <a 
                        href="{{ route('category.index') }}" 
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

