@extends('layout.app')

@php $pagename = "Attendance" @endphp

@section('title')
    Quản lý chấm công
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Quản lý chấm công</h1>
                <p class="text-muted mb-0">Xem và quản lý chấm công của nhân viên</p>
            </div>
            <a href="{{ route('admin.attendances.report') }}" class="btn btn-info d-flex align-items-center gap-2">
                <i class="bi bi-graph-up"></i>
                <span>Báo cáo chấm công</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active">Chấm công</li>
            </ol>
        </nav>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.attendances.index') }}" class="row g-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Nhân viên</label>
                    <select name="staff_id" class="form-select">
                        <option value="">Tất cả nhân viên</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                {{ $staff->first_name }} {{ $staff->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Có mặt</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Đi muộn</option>
                        <option value="early_leave" {{ request('status') == 'early_leave' ? 'selected' : '' }}>Về sớm</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Vắng mặt</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                    @if(request()->anyFilled(['staff_id', 'date_from', 'date_to', 'status']))
                    <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Xóa bộ lọc
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Attendance Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-600">Nhân viên</th>
                        <th class="fw-600">Ngày làm việc</th>
                        <th class="fw-600">Ca làm việc</th>
                        <th class="fw-600">Check-in</th>
                        <th class="fw-600">Check-out</th>
                        <th class="fw-600">Đi muộn/Về sớm</th>
                        <th class="fw-600">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                    <tr>
                        <td class="align-middle">
                            <strong class="text-dark">{{ $attendance->user->first_name }} {{ $attendance->user->last_name }}</strong>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-secondary">{{ $attendance->work_date->format('d/m/Y') }}</span>
                        </td>
                        <td class="align-middle">
                            @if($attendance->shift)
                                <span class="badge bg-info text-dark">
                                    {{ $attendance->shift->name }}<br>
                                    <small>{{ date('H:i', strtotime($attendance->shift->start_time)) }} - {{ date('H:i', strtotime($attendance->shift->end_time)) }}</small>
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($attendance->check_in)
                                <span class="badge bg-success">{{ $attendance->check_in->format('H:i:s') }}</span>
                            @else
                                <span class="badge bg-danger">Chưa check-in</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($attendance->check_out)
                                <span class="badge bg-primary">{{ $attendance->check_out->format('H:i:s') }}</span>
                            @else
                                <span class="badge bg-warning text-dark">Chưa check-out</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($attendance->check_in_late_minutes > 0)
                                <span class="badge bg-warning text-dark">Đi muộn {{ $attendance->check_in_late_minutes }} phút</span>
                            @elseif($attendance->check_in_late_minutes < 0)
                                <span class="badge bg-success">Đi sớm {{ abs($attendance->check_in_late_minutes) }} phút</span>
                            @else
                                <span class="badge bg-success">Đúng giờ</span>
                            @endif
                            @if($attendance->check_out_early_minutes > 0)
                                <br><span class="badge bg-info text-dark mt-1">Về sớm {{ $attendance->check_out_early_minutes }} phút</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-{{ $attendance->status_color }}">
                                @if($attendance->status == 'present')
                                    Có mặt
                                @elseif($attendance->status == 'late')
                                    Đi muộn
                                @elseif($attendance->status == 'early_leave')
                                    Về sớm
                                @else
                                    Vắng mặt
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Chưa có dữ liệu chấm công</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($attendances->hasPages())
        <div class="card-footer bg-light">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

