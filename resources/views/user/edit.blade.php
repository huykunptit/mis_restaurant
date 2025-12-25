@extends('layout.app')

@php $pagename = "User" @endphp

@section('title')
    Chỉnh sửa người dùng: {{ $user->first_name .' '. $user->last_name }}
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark mb-2">Chỉnh sửa người dùng: {{ $user->first_name .' '. $user->last_name }}</h1>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none">Người dùng</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </nav>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <p class="text-muted mb-4">Thay đổi thông tin trong form bên dưới để cập nhật tài khoản người dùng</p>
            
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Role --}}
                <div class="mb-3">
                    <label for="role" class="form-label">
                        Vai trò <span class="text-danger">*</span>
                    </label>
                    <select 
                        id="role" 
                        name="role" 
                        class="form-select @error('role') is-invalid @enderror" 
                        required
                    >
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ ($user->role->id) == ($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    {{-- First Name --}}
                    <div class="col-12 col-md-6">
                        <label for="firstName" class="form-label">
                            Họ <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="firstName" 
                            name="firstName" 
                            value="{{ old('firstName', $user->first_name) }}" 
                            maxlength="200"
                            class="form-control @error('firstName') is-invalid @enderror" 
                            placeholder="Nhập họ..."
                            required
                        >
                        @error('firstName')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-12 col-md-6">
                        <label for="lastName" class="form-label">
                            Tên <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="lastName" 
                            name="lastName" 
                            value="{{ old('lastName', $user->last_name) }}" 
                            maxlength="200"
                            class="form-control @error('lastName') is-invalid @enderror" 
                            placeholder="Nhập tên..."
                            required
                        >
                        @error('lastName')
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
                            value="{{ old('email', $user->email) }}" 
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
                            Mật khẩu mới <small class="text-muted">(để trống nếu không đổi)</small>
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
                        <i class="bi bi-check-circle"></i> Xác nhận cập nhật
                    </button>
                    <a 
                        href="{{ route('user.index') }}" 
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
