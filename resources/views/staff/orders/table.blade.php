@extends('layout.app')

@php $pagename = "Quản lý đơn - Bàn " . $table->table_number @endphp

@section('title')
    Quản lý đơn - {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('header-title')
    <a href="{{ route('staff.orders.select-table') }}" class="text-decoration-none text-white me-2">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    @if(count($orderGroups) === 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <span class="material-symbols-outlined text-secondary" style="font-size: 64px;">receipt_long</span>
                <h5 class="mt-3 mb-2">Bàn này chưa có đơn hàng nào</h5>
                <a href="{{ route('staff.orders.create', ['table_id' => $table->id]) }}" class="btn btn-primary mt-3">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">add</span>
                    Đặt món mới
                </a>
            </div>
        </div>
    @else
        {{-- Order Groups --}}
        @foreach($orderGroups as $group)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">receipt_long</span>
                            Đơn #{{ substr($group['group_id'], -8) }}
                        </h6>
                        <small class="opacity-75">
                            {{ $group['created_at']->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0">{{ number_format($group['total'], 0) }} VNĐ</h5>
                        <small class="opacity-75">
                            {{ $group['completed_count'] }}/{{ $group['total_count'] }} món đã giao
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Món</th>
                                    <th>Tùy chọn</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group['orders'] as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->menu->name }}</strong>
                                        </td>
                                        <td>
                                            <small class="text-secondary">{{ $order->menuOption->name ?? 'N/A' }}</small>
                                        </td>
                                        <td class="text-center">{{ $order->quantity }}</td>
                                        <td class="text-end">{{ number_format($order->menuOption->cost ?? 0, 0) }} VNĐ</td>
                                        <td class="text-end fw-bold">
                                            {{ number_format(($order->menuOption->cost ?? 0) * $order->quantity, 0) }} VNĐ
                                        </td>
                                        <td class="text-center">
                                            @if($order->completion_status === 'yes')
                                                <span class="badge bg-success">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">check_circle</span>
                                                    Đã giao
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">pending</span>
                                                    Chưa giao
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($group['orders']->first()->remarks)
                        <div class="mt-3 p-2 bg-light rounded">
                            <small class="text-secondary">Ghi chú: </small>
                            <span>{{ $group['orders']->first()->remarks }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Summary & Actions --}}
        <div class="card border-0 shadow-sm sticky-bottom" style="bottom: 80px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <h5 class="mb-1">Tổng cộng:</h5>
                        <h3 class="text-primary mb-0">{{ number_format($grandTotal, 0) }} VNĐ</h3>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('staff.orders.create', ['table_id' => $table->id]) }}" 
                               class="btn btn-outline-primary">
                                <span class="material-symbols-outlined" style="vertical-align: middle;">add</span>
                                Đặt thêm món
                            </a>
                            {{-- Cho phép thanh toán sớm --}}
                            <a href="{{ route('staff.payment.table', $table->id) }}" class="btn btn-primary">
                                <span class="material-symbols-outlined" style="vertical-align: middle;">payments</span>
                                Thanh toán
                                @if(!$allCompleted)
                                    <small class="d-block" style="font-size: 10px;">(Thanh toán sớm)</small>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

