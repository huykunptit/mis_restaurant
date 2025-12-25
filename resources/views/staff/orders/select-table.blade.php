@extends('layout.app')

@php $pagename = "Chọn bàn" @endphp

@section('title')
    Chọn bàn
@endsection

@section('header-title')
    Chọn bàn
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    {{-- Search & Filter --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('staff.orders.select-table') }}" class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <span class="material-symbols-outlined text-secondary">search</span>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control border-start-0" 
                               placeholder="Tìm bàn theo số..." 
                               value="{{ $search }}">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <select name="zone" class="form-select">
                        <option value="">Tất cả khu vực</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone }}" {{ $zoneFilter === $zone ? 'selected' : '' }}>
                                {{ $zone }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="material-symbols-outlined" style="vertical-align: middle;">search</span>
                        Tìm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tables by Zone --}}
    @if($tablesByZone->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <span class="material-symbols-outlined text-secondary" style="font-size: 64px;">table_restaurant</span>
                <h5 class="mt-3 mb-2">Không tìm thấy bàn nào</h5>
                <p class="text-secondary mb-0">Vui lòng thử lại với từ khóa khác</p>
            </div>
        </div>
    @else
        @foreach($tablesByZone as $zone => $tables)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined">location_on</span>
                        {{ $zone ?? 'Chưa phân khu' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($tables as $table)
                            <div class="col-6 col-md-3 col-lg-2">
                                <a href="{{ route('staff.orders.create', ['table_id' => $table->id]) }}" 
                                   class="text-decoration-none">
                                    <div class="card border-2 h-100 transition-all hover-shadow" 
                                         style="border-color: 
                                            @if($table->status_color === 'success') #28a745
                                            @elseif($table->status_color === 'danger') #dc3545
                                            @elseif($table->status_color === 'warning') #ffc107
                                            @else #6c757d
                                            @endif !important;
                                            cursor: pointer;">
                                        <div class="card-body text-center p-3">
                                            <div class="mb-2">
                                                <span class="material-symbols-outlined" style="font-size: 32px;
                                                    color: @if($table->status_color === 'success') #28a745
                                                    @elseif($table->status_color === 'danger') #dc3545
                                                    @elseif($table->status_color === 'warning') #ffc107
                                                    @else #6c757d
                                                    @endif;">
                                                    table_restaurant
                                                </span>
                                            </div>
                                            <h6 class="mb-1 fw-bold">{{ $table->table_number }}</h6>
                                            <small class="text-secondary d-block mb-2">
                                                {{ $table->seats }} chỗ
                                            </small>
                                            @if($table->unpaid_orders_count > 0)
                                                <span class="badge bg-danger">
                                                    {{ $table->unpaid_orders_count }} đơn
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Legend --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Chú thích:</h6>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 20px; border: 2px solid #28a745; border-radius: 4px;"></div>
                        <small>Trống</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 20px; border: 2px solid #ffc107; border-radius: 4px;"></div>
                        <small>Có khách</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 20px; border: 2px solid #dc3545; border-radius: 4px;"></div>
                        <small>Có đơn chưa thanh toán</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection

