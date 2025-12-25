@extends('layout.app')

@php $pagename = "Category" @endphp

@section('title')
    Quản lý danh mục
@endsection

@section('content')
<div class="container-fluid py-4 py-lg-5 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý danh mục</h1>
                <p class="text-muted mb-0">Quản lý các danh mục món ăn và đồ uống</p>
            </div>
            <a href="{{ route('category.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm danh mục</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Danh mục</li>
            </ol>
        </nav>
    </div>

    {{-- Categories Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">ID</th>
                        <th class="fw-600">Tên danh mục</th>
                        <th class="fw-600">Số lượng món</th>
                        <th class="text-center fw-600">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td class="align-middle">
                            <small class="text-muted">#{{ $category->id }}</small>
                        </td>
                        <td class="align-middle">
                            <strong class="text-dark">{{ $category->name }}</strong>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-info">{{ $category->menu_count }} món</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Chưa có danh mục nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

