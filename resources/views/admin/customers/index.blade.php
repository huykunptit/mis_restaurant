@extends('layout.app')

@php $pagename = "Customer" @endphp

@section('title')
    Quản lý khách hàng
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý khách hàng</h1>
                <p class="text-muted mb-0">Quản lý tất cả khách hàng trong hệ thống</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm khách hàng</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Khách hàng</li>
            </ol>
        </nav>
    </div>

    {{-- Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Tìm kiếm theo tên, email..." 
                    class="form-control"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Xóa
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Customer Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">Họ tên</th>
                        <th class="fw-600">Email</th>
                        <th class="fw-600">Ngày tạo</th>
                        <th class="text-center fw-600">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                    {{ strtoupper(substr($customer->first_name, 0, 1)) }}{{ strtoupper(substr($customer->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-dark d-block">{{ $customer->first_name .' '. $customer->last_name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $customer->email }}</small>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $customer->created_at ? $customer->created_at->format('d/m/Y') : 'N/A' }}</small>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');" class="d-inline">
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
                            <p class="text-muted mb-0">Chưa có khách hàng nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
        <div class="card-footer bg-light">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

