@extends('layout.app')

@php $pagename = "Order Detail" @endphp

@section('title')
    Chi tiết đơn hàng - {{ $user->first_name }} {{ $user->last_name }}
@endsection

@section('content')
<div class="container-fluid px-3 px-sm-4 px-lg-5 py-4 py-sm-5 bg-background-light dark:bg-background-dark min-h-screen">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h2 fw-bold text-dark dark:text-white mb-2">Chi tiết đơn hàng</h1>
                <p class="text-muted dark:text-gray-400 mb-0">Khách hàng: <strong>{{ $user->first_name }} {{ $user->last_name }}</strong></p>
            </div>
            <a href="{{ route('orders.admin') }}" class="btn btn-outline-secondary">
                <span class="material-symbols-outlined" style="vertical-align: middle;">arrow_back</span>
                Quay lại
            </a>
        </div>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.admin') }}" class="text-decoration-none">Đơn hàng</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </nav>
    </div>

    {{-- Completion Status --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-1">Trạng thái đơn hàng</h5>
                    <p class="text-muted mb-0 small">Tổng số món: <strong>{{ $totalOrders }}</strong> | Đã giao: <strong>{{ $completedOrders }}</strong></p>
                </div>
                <div class="text-end">
                    @if($allCompleted)
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px;">check_circle</span>
                            Tất cả đã giao
                        </span>
                    @else
                        <span class="badge bg-warning fs-6 px-3 py-2">
                            <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px;">pending</span>
                            {{ $completedOrders }}/{{ $totalOrders }} đã giao
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <span class="material-symbols-outlined text-muted mb-3" style="font-size: 64px;">receipt_long</span>
                <h5 class="fw-bold mb-2">Không có đơn hàng nào</h5>
                <p class="text-muted">Khách hàng này chưa có đơn hàng nào.</p>
            </div>
        </div>
    @else
        {{-- Remarks --}}
        @if($remark)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-2">
                    <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 20px;">note</span>
                    Yêu cầu đặc biệt
                </h6>
                <p class="mb-0">{{ $remark->remarks }}</p>
            </div>
        </div>
        @endif

        {{-- Orders List --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="fw-bold mb-0">Danh sách món</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="width: 5%;">#</th>
                                <th class="px-4 py-3" style="width: 35%;">Món</th>
                                <th class="px-4 py-3" style="width: 20%;">Danh mục</th>
                                <th class="px-4 py-3" style="width: 15%;">Số lượng</th>
                                <th class="px-4 py-3" style="width: 15%;">Giá</th>
                                <th class="px-4 py-3 text-center" style="width: 10%;">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($order->menu->thumbnail)
                                                <img src="{{ asset('images/' . $order->menu->thumbnail) }}" 
                                                     alt="{{ $order->menu->name }}" 
                                                     class="rounded" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('img/noimg.png') }}" 
                                                     alt="{{ $order->menu->name }}" 
                                                     class="rounded" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong class="d-block">{{ $order->menu->name }}</strong>
                                                <small class="text-muted">{{ $order->menuOption->name ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary">{{ $order->menu->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $order->quantity }}</td>
                                    <td class="px-4 py-3">
                                        <strong>{{ number_format(($order->menuOption->cost ?? 0) * $order->quantity, 0) }} VNĐ</strong>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($order->completion_status == 'yes')
                                            <span class="badge bg-success">
                                                <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 16px;">check</span>
                                                Đã giao
                                            </span>
                                        @else
                                            <form action="{{ route('order.show.complete', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Đánh dấu đã giao">
                                                    <span class="material-symbols-outlined" style="font-size: 18px;">check</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('order.show.cancel', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy món" onclick="return confirm('Bạn có chắc muốn hủy món này?')">
                                                    <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-end fw-bold">Tổng cộng:</td>
                                <td class="px-4 py-3">
                                    <strong class="text-primary fs-5">
                                        {{ number_format($orders->sum(function($order) { 
                                            return ($order->menuOption->cost ?? 0) * $order->quantity; 
                                        }), 0) }} VNĐ
                                    </strong>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-2 mt-4">
            @if(!$allCompleted)
                <button type="button" class="btn btn-secondary w-100 fw-bold" disabled>
                    <span class="material-symbols-outlined" style="vertical-align: middle;">pending</span>
                    Hoàn thành ({{ $completedOrders }}/{{ $totalOrders }})
                </button>
            @else
                <form action="{{ route('order.complete', $user->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <span class="material-symbols-outlined" style="vertical-align: middle;">check_circle</span>
                        Hoàn thành tất cả
                    </button>
                </form>
            @endif

            @if(!$orders->every('payment_status', 'yes'))
                <form action="{{ route('order.paid', $user->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-primary w-100 fw-bold" {{ !$allCompleted ? 'disabled' : '' }}>
                        <span class="material-symbols-outlined" style="vertical-align: middle;">payments</span>
                        Thanh toán
                    </button>
                </form>
            @else
                <button disabled class="btn btn-secondary w-100 fw-bold">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">check_circle</span>
                    Đã thanh toán
                </button>
            @endif
        </div>
    @endif
</div>
@endsection
