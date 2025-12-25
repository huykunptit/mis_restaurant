@extends('layout.app')

@php $pagename = "Customer" @endphp

@section('title')
    Sửa thông tin khách hàng
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark mb-2">Sửa thông tin khách hàng</h1>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}" class="text-decoration-none">Khách hàng</a></li>
                <li class="breadcrumb-item active">Sửa</li>
            </ol>
        </nav>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <p class="text-muted mb-4">Cập nhật thông tin khách hàng</p>
            
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3 mb-3">
                    {{-- First Name --}}
                    <div class="col-12 col-md-6">
                        <label for="first_name" class="form-label">
                            Họ <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="first_name" 
                            name="first_name" 
                            value="{{ old('first_name', $customer->first_name) }}" 
                            maxlength="200"
                            class="form-control @error('first_name') is-invalid @enderror" 
                            placeholder="Nhập họ..."
                            required
                        >
                        @error('first_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-12 col-md-6">
                        <label for="last_name" class="form-label">
                            Tên <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            value="{{ old('last_name', $customer->last_name) }}" 
                            maxlength="200"
                            class="form-control @error('last_name') is-invalid @enderror" 
                            placeholder="Nhập tên..."
                            required
                        >
                        @error('last_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    {{-- Email --}}
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">
                            Địa chỉ email <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $customer->email) }}" 
                            maxlength="200"
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="example@email.com"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label">
                            Mật khẩu mới <span class="text-muted">(Để trống nếu không đổi)</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            maxlength="200"
                            minlength="6"
                            class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Tối thiểu 6 ký tự"
                        >
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 pt-3 border-top">
                    <button 
                        type="submit" 
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle"></i> Cập nhật
                    </button>
                    <a 
                        href="{{ route('admin.customers.index') }}" 
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

