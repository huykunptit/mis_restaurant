@extends('layout.app')

@php $pagename = "User" @endphp

@section('title')
    Tất cả người dùng
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý người dùng</h1>
                <p class="text-muted mb-0">Quản lý tất cả người dùng trong hệ thống</p>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm người dùng</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Người dùng</li>
            </ol>
        </nav>
    </div>

    {{-- User Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">Họ tên</th>
                        <th class="fw-600">Email</th>
                        <th class="fw-600">Vai trò</th>
                        <th class="text-center fw-600">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-dark d-block">{{ $user->first_name .' '. $user->last_name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>
                        <td class="align-middle">
                            @if($user->role->name == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role->name == 'staff')
                                <span class="badge bg-info text-dark">Nhân viên</span>
                            @else
                                <span class="badge bg-success">Khách hàng</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" class="d-inline">
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
                            <i class="bi bi-person-slash fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Chưa có người dùng nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="card-footer bg-light">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
