@extends('layout.app')

@php $pagename = "Attendance" @endphp

@section('title')
    Báo cáo chấm công
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Báo cáo chấm công</h1>
                <p class="text-muted mb-0">Thống kê và báo cáo chấm công của nhân viên</p>
            </div>
            <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Quay lại</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.attendances.index') }}" class="text-decoration-none">Chấm công</a></li>
                <li class="breadcrumb-item active">Báo cáo</li>
            </ol>
        </nav>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.attendances.report') }}" class="row g-3">
                <div class="col-12 col-md-4">
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
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Xem báo cáo
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Report Cards --}}
    @if(count($reportData) > 0)
    <div class="row g-4 mb-4">
        @foreach($reportData as $report)
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle"></i> 
                        {{ $report['user']->first_name }} {{ $report['user']->last_name }}
                        @if($report['user']->shift)
                            <span class="badge bg-light text-dark ms-2">
                                {{ $report['user']->shift->name }} ({{ date('H:i', strtotime($report['user']->shift->start_time)) }} - {{ date('H:i', strtotime($report['user']->shift->end_time)) }})
                            </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h3 class="text-primary mb-1">{{ $report['total_days'] }}</h3>
                                <small class="text-muted">Tổng ngày làm</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                <h3 class="text-success mb-1">{{ $report['present_days'] }}</h3>
                                <small class="text-muted">Có mặt</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                <h3 class="text-warning mb-1">{{ $report['late_days'] }}</h3>
                                <small class="text-muted">Đi muộn</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                <h3 class="text-info mb-1">{{ $report['early_leave_days'] }}</h3>
                                <small class="text-muted">Về sớm</small>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-danger bg-opacity-10 rounded">
                                <h3 class="text-danger mb-1">{{ $report['absent_days'] }}</h3>
                                <small class="text-muted">Vắng mặt</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-secondary bg-opacity-10 rounded">
                                <h3 class="text-secondary mb-1">
                                    @if($report['avg_check_in_late'] > 0)
                                        +{{ number_format($report['avg_check_in_late'], 1) }}
                                    @elseif($report['avg_check_in_late'] < 0)
                                        {{ number_format($report['avg_check_in_late'], 1) }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <small class="text-muted">TB đi muộn (phút)</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-secondary bg-opacity-10 rounded">
                                <h3 class="text-secondary mb-1">
                                    @if($report['avg_check_out_early'] > 0)
                                        +{{ number_format($report['avg_check_out_early'], 1) }}
                                    @elseif($report['avg_check_out_early'] < 0)
                                        {{ number_format($report['avg_check_out_early'], 1) }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <small class="text-muted">TB về sớm (phút)</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                <h3 class="text-primary mb-1">
                                    {{ $report['total_days'] > 0 ? number_format(($report['present_days'] / $report['total_days']) * 100, 1) : 0 }}%
                                </h3>
                                <small class="text-muted">Tỷ lệ có mặt</small>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Table --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Ca</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Đi muộn</th>
                                    <th>Về sớm</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['attendances'] as $attendance)
                                <tr>
                                    <td>{{ $attendance->work_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($attendance->shift)
                                            <small>{{ $attendance->shift->name }}</small>
                                        @else
                                            <small class="text-muted">N/A</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_in)
                                            <span class="badge bg-success">{{ $attendance->check_in->format('H:i') }}</span>
                                        @else
                                            <span class="badge bg-danger">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_out)
                                            <span class="badge bg-primary">{{ $attendance->check_out->format('H:i') }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_in_late_minutes > 0)
                                            <span class="badge bg-warning text-dark">+{{ $attendance->check_in_late_minutes }}p</span>
                                        @elseif($attendance->check_in_late_minutes < 0)
                                            <span class="badge bg-success">{{ $attendance->check_in_late_minutes }}p</span>
                                        @else
                                            <span class="badge bg-secondary">0p</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_out_early_minutes > 0)
                                            <span class="badge bg-info text-dark">+{{ $attendance->check_out_early_minutes }}p</span>
                                        @else
                                            <span class="badge bg-secondary">0p</span>
                                        @endif
                                    </td>
                                    <td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
            <p class="text-muted mb-0">Không có dữ liệu chấm công trong khoảng thời gian này</p>
        </div>
    </div>
    @endif
</div>
@endsection

