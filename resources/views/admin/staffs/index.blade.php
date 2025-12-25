@extends('layout.app')

@php $pagename = "Staff" @endphp

@section('title')
    Quản lý nhân viên
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý nhân viên</h1>
                <p class="text-muted mb-0">Quản lý tất cả nhân viên trong hệ thống</p>
            </div>
            <a href="{{ route('admin.staffs.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm nhân viên</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Nhân viên</li>
            </ol>
        </nav>
    </div>

    {{-- Search & Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.staffs.index') }}" class="d-flex flex-column flex-md-row gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Tìm kiếm theo tên, email..." 
                    class="form-control"
                >
                <select name="shift_id" class="form-select" style="max-width: 250px;">
                    <option value="">Tất cả ca làm việc</option>
                    @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}" {{ request('shift_id') == $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }} ({{ date('H:i', strtotime($shift->start_time)) }} - {{ date('H:i', strtotime($shift->end_time)) }})
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                @if(request('search') || request('shift_id'))
                <a href="{{ route('admin.staffs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Xóa
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Staff Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">Họ tên</th>
                        <th class="fw-600">Email</th>
                        <th class="fw-600">Ca làm việc</th>
                        <th class="fw-600">Ngày tạo</th>
                        <th class="text-center fw-600">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staffs as $staff)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                    {{ strtoupper(substr($staff->first_name, 0, 1)) }}{{ strtoupper(substr($staff->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-dark d-block">{{ $staff->first_name .' '. $staff->last_name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $staff->email }}</small>
                        </td>
                        <td class="align-middle">
                            @if($staff->shift)
                                <span class="badge bg-info text-dark">
                                    {{ $staff->shift->name }}<br>
                                    <small>{{ date('H:i', strtotime($staff->shift->start_time)) }} - {{ date('H:i', strtotime($staff->shift->end_time)) }}</small>
                                </span>
                            @else
                                <span class="badge bg-secondary">Chưa phân ca</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $staff->created_at ? $staff->created_at->format('d/m/Y') : 'N/A' }}</small>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.staffs.edit', $staff->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');" class="d-inline">
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
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-person-slash fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Chưa có nhân viên nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($staffs->hasPages())
        <div class="card-footer bg-light">
            {{ $staffs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

