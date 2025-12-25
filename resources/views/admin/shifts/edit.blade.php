@extends('layout.app')

@php $pagename = "Shift" @endphp

@section('title')
    Sửa ca làm việc
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark mb-2">Sửa ca làm việc</h1>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.shifts.index') }}" class="text-decoration-none">Ca làm việc</a></li>
                <li class="breadcrumb-item active">Sửa</li>
            </ol>
        </nav>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <p class="text-muted mb-4">Cập nhật thông tin ca làm việc</p>
            
            <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Tên ca làm việc <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $shift->name) }}" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Ví dụ: Ca sáng, Ca chiều, Ca tối..."
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    {{-- Start Time --}}
                    <div class="col-12 col-md-6">
                        <label for="start_time" class="form-label">
                            Giờ bắt đầu <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="time" 
                            id="start_time" 
                            name="start_time" 
                            value="{{ old('start_time', date('H:i', strtotime($shift->start_time))) }}" 
                            class="form-control @error('start_time') is-invalid @enderror" 
                            required
                        >
                        @error('start_time')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div class="col-12 col-md-6">
                        <label for="end_time" class="form-label">
                            Giờ kết thúc <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="time" 
                            id="end_time" 
                            name="end_time" 
                            value="{{ old('end_time', date('H:i', strtotime($shift->end_time))) }}" 
                            class="form-control @error('end_time') is-invalid @enderror" 
                            required
                        >
                        @error('end_time')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">
                        Mô tả
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="form-control @error('description') is-invalid @enderror" 
                        placeholder="Mô tả về ca làm việc..."
                    >{{ old('description', $shift->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Is Active --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="is_active" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $shift->is_active) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Ca làm việc đang hoạt động
                        </label>
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
                        href="{{ route('admin.shifts.index') }}" 
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

