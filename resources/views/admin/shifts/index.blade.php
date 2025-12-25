@extends('layout.app')

@php $pagename = "Shift" @endphp

@section('title')
    Quản lý ca làm việc
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý ca làm việc</h1>
                <p class="text-muted mb-0">Quản lý các ca làm việc của nhân viên</p>
            </div>
            <a href="{{ route('admin.shifts.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm ca làm việc</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Ca làm việc</li>
            </ol>
        </nav>
    </div>

    {{-- Shifts Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">Tên ca</th>
                        <th class="fw-600">Giờ bắt đầu</th>
                        <th class="fw-600">Giờ kết thúc</th>
                        <th class="fw-600">Mô tả</th>
                        <th class="fw-600">Trạng thái</th>
                        <th class="fw-600">Số nhân viên</th>
                        <th class="text-center fw-600">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shifts as $shift)
                    <tr>
                        <td class="align-middle">
                            <strong class="text-dark">{{ $shift->name }}</strong>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-primary">{{ date('H:i', strtotime($shift->start_time)) }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-danger">{{ date('H:i', strtotime($shift->end_time)) }}</span>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $shift->description ?? 'N/A' }}</small>
                        </td>
                        <td class="align-middle">
                            @if($shift->is_active)
                                <span class="badge bg-success">Đang hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Đã vô hiệu</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-info text-dark">{{ $shift->users()->count() }} nhân viên</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.shifts.edit', $shift->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('admin.shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ca làm việc này?');" class="d-inline">
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
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-clock-history fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Chưa có ca làm việc nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($shifts->hasPages())
        <div class="card-footer bg-light">
            {{ $shifts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

