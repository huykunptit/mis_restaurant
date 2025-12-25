@extends('layout.app')

@php $pagename = "Order Detail" @endphp

@section('title')
    Chi tiết đơn hàng
@endsection

@section('header-title')
    Chi tiết đơn hàng
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    <div class="mb-4">
        <a href="{{ route('customer.orders.index') }}" class="text-decoration-none">
            <span class="material-symbols-outlined" style="vertical-align: middle;">arrow_back</span>
            Quay lại
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Chi tiết đơn hàng #{{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    {{-- Order Info --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Thông tin đơn hàng</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-secondary">Món ăn:</small>
                                <p class="fw-bold mb-0">{{ $order->menu->name }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-secondary">Tùy chọn:</small>
                                <p class="fw-bold mb-0">{{ $order->menuOption->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-secondary">Số lượng:</small>
                                <p class="fw-bold mb-0">{{ $order->quantity }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-secondary">Đơn giá:</small>
                                <p class="fw-bold mb-0">{{ number_format($order->menuOption->cost ?? 0, 0) }} VNĐ</p>
                            </div>
                            @if($order->table)
                            <div class="col-6">
                                <small class="text-secondary">Bàn:</small>
                                <p class="fw-bold mb-0">Bàn {{ $order->table->table_number }}</p>
                            </div>
                            @endif
                            <div class="col-6">
                                <small class="text-secondary">Ngày đặt:</small>
                                <p class="fw-bold mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Status --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Trạng thái</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            @if($order->completion_status == 'yes')
                                <span class="badge bg-success fs-6">Đã giao</span>
                            @else
                                <span class="badge bg-warning fs-6">Đang xử lý</span>
                            @endif
                            
                            @if($order->payment_status == 'yes')
                                <span class="badge bg-primary fs-6">Đã thanh toán</span>
                            @else
                                <span class="badge bg-secondary fs-6">Chưa thanh toán</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Total --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Tổng cộng:</span>
                        <span class="fw-bold text-warning fs-4">
                            {{ number_format(($order->menuOption->cost ?? 0) * $order->quantity, 0) }} VNĐ
                        </span>
                    </div>

                    @if($order->remarks)
                        <div class="mt-3">
                            <small class="text-secondary">Ghi chú:</small>
                            <p class="mb-0">{{ $order->remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

