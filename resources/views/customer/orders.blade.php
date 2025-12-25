@extends('layout.app')

@php $pagename = "Orders" @endphp

@section('title')
    Lịch sử đơn hàng
@endsection

@section('header-title')
    Lịch sử đơn hàng
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    {{-- Header Section --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-1">
                    <span class="material-symbols-outlined align-middle text-warning me-2">receipt_long</span>
                    Lịch sử đơn hàng
                </h1>
                <p class="text-secondary small mb-0">Quản lý và theo dõi đơn hàng của bạn</p>
            </div>
            @if($orders->count() > 0)
                <a href="{{ route('menu.customer') }}" class="btn btn-warning d-none d-md-inline-flex">
                    <span class="material-symbols-outlined me-2" style="font-size: 20px;">add_shopping_cart</span>
                    Đặt món mới
                </a>
            @endif
        </div>
    </div>

    @if($orders->count() > 0)
        {{-- Statistics Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 32px;">shopping_bag</span>
                            <div>
                                <div class="h5 fw-bold mb-0">{{ $orders->total() }}</div>
                                <small class="text-secondary">Tổng đơn</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <span class="material-symbols-outlined text-success me-2" style="font-size: 32px;">check_circle</span>
                            <div>
                                <div class="h5 fw-bold mb-0">{{ $orders->where('completion_status', 'yes')->count() }}</div>
                                <small class="text-secondary">Đã giao</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <span class="material-symbols-outlined text-warning me-2" style="font-size: 32px;">pending</span>
                            <div>
                                <div class="h5 fw-bold mb-0">{{ $orders->where('completion_status', 'no')->count() }}</div>
                                <small class="text-secondary">Đang xử lý</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <span class="material-symbols-outlined text-info me-2" style="font-size: 32px;">payments</span>
                            <div>
                                <div class="h5 fw-bold mb-0">{{ $orders->where('payment_status', 'yes')->count() }}</div>
                                <small class="text-secondary">Đã thanh toán</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders List --}}
        <div class="row g-3">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card border-0 shadow-sm hover-shadow transition-all" style="transition: all 0.3s ease;">
                        <div class="card-body p-3 p-md-4">
                            <div class="row align-items-center">
                                {{-- Order Info --}}
                                <div class="col-12 col-md-7 mb-3 mb-md-0">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3 d-none d-md-flex">
                                            <span class="material-symbols-outlined text-warning" style="font-size: 32px;">restaurant</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-2">{{ $order->menu->name }}</h5>
                                            
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                <span class="badge bg-light text-dark border">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">label</span>
                                                    {{ $order->menuOption->name ?? 'N/A' }}
                                                </span>
                                                @if($order->table)
                                                    <span class="badge bg-light text-dark border">
                                                        <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">table_restaurant</span>
                                                        Bàn {{ $order->table->table_number }}
                                                    </span>
                                                @endif
                                                <span class="badge bg-light text-dark border">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">counter_1</span>
                                                    SL: {{ $order->quantity }}
                                                </span>
                                            </div>
                                            
                                            <div class="text-secondary small">
                                                <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">schedule</span>
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Order Status & Actions --}}
                                <div class="col-12 col-md-5">
                                    <div class="d-flex flex-column align-items-md-end">
                                        {{-- Price --}}
                                        <div class="mb-2">
                                            <h4 class="fw-bold text-warning mb-0">
                                                {{ number_format(($order->menuOption->cost ?? 0) * $order->quantity, 0) }} ₫
                                            </h4>
                                        </div>
                                        
                                        {{-- Status Badges --}}
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            @if($order->completion_status == 'yes')
                                                <span class="badge bg-success px-3 py-2">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">check_circle</span>
                                                    Đã giao
                                                </span>
                                            @else
                                                <span class="badge bg-warning px-3 py-2">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">pending</span>
                                                    Đang xử lý
                                                </span>
                                            @endif
                                            
                                            @if($order->payment_status == 'yes')
                                                <span class="badge bg-primary px-3 py-2">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">payments</span>
                                                    Đã thanh toán
                                                </span>
                                            @else
                                                <span class="badge bg-secondary px-3 py-2">
                                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">credit_card_off</span>
                                                    Chưa thanh toán
                                                </span>
                                            @endif
                                        </div>
                                        
                                        {{-- Action Button --}}
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-primary w-100 w-md-auto">
                                            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">visibility</span>
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <span class="material-symbols-outlined text-warning" style="font-size: 64px;">receipt_long</span>
                    </div>
                    <h4 class="fw-bold mb-2">Chưa có đơn hàng nào</h4>
                    <p class="text-secondary mb-0">Bạn chưa thực hiện đơn hàng nào. Hãy bắt đầu đặt món ngay!</p>
                </div>
                
                <a href="{{ route('menu.customer') }}" class="btn btn-warning btn-lg px-4">
                    <span class="material-symbols-outlined me-2" style="vertical-align: middle;">restaurant_menu</span>
                    Khám phá menu
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endsection