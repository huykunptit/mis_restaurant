@extends('layout.app')

@php $pagename = "Category" @endphp

@section('title')
    Chỉnh sửa danh mục
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark mb-2">Chỉnh sửa danh mục: {{ $category->name }}</h1>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category.index') }}" class="text-decoration-none">Danh mục</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </nav>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <p class="text-muted mb-4">Thay đổi thông tin trong form bên dưới để cập nhật danh mục</p>
            
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Category Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Tên danh mục <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $category->name) }}" 
                        maxlength="200"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Ví dụ: Món chính, Đồ uống, Tráng miệng..."
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 pt-2">
                    <button 
                        type="submit" 
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle"></i> Cập nhật
                    </button>
                    <a 
                        href="{{ route('category.index') }}" 
                        class="btn btn-secondary"
                    >
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

