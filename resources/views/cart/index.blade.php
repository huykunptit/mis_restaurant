@extends('layout.app')

@php $pagename = "Cart" @endphp

@section('title')
    Giỏ hàng
@endsection

@section('header-title')
    Giỏ hàng
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Giỏ hàng của tôi</h1>
        <p class="text-secondary small">Kiểm tra và chỉnh sửa đơn hàng của bạn</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="row g-3">
            {{-- Cart Items --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                                {{-- Image --}}
                                <div class="flex-shrink-0">
                                    @if($item->menu->thumbnail)
                                        <img src="{{ asset('images/' . $item->menu->thumbnail) }}" 
                                             alt="{{ $item->menu->name }}" 
                                             class="rounded" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/noimg.png') }}" 
                                             alt="{{ $item->menu->name }}" 
                                             class="rounded" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $item->menu->name }}</h6>
                                    <p class="text-secondary small mb-1">
                                        {{ $item->menuOption->name ?? 'N/A' }}
                                    </p>
                                    <p class="text-warning fw-bold mb-0">
                                        {{ number_format($item->menuOption->cost ?? 0, 0) }} VNĐ
                                    </p>
                                </div>

                                {{-- Quantity --}}
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               class="form-control form-control-sm" 
                                               style="width: 60px;"
                                               onchange="this.form.submit()">
                                    </form>
                                </div>

                                {{-- Price --}}
                                <div class="text-end">
                                    <p class="fw-bold mb-0">
                                        {{ number_format(($item->menuOption->cost ?? 0) * $item->quantity, 0) }} VNĐ
                                    </p>
                                </div>

                                {{-- Remove --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Clear Cart --}}
                <div class="mt-3">
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">delete_sweep</span>
                            Xóa toàn bộ giỏ hàng
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-4">Tóm tắt đơn hàng</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Số lượng món:</span>
                            <span class="fw-medium">{{ $cartItems->sum('quantity') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Tạm tính:</span>
                            <span class="fw-bold">{{ number_format($total, 0) }} VNĐ</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span class="fw-bold text-warning fs-5">{{ number_format($total, 0) }} VNĐ</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-warning w-100 fw-bold">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">shopping_cart_checkout</span>
                            Thanh toán
                        </a>

                        <a href="{{ route('menu.customer') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <span class="material-symbols-outlined text-secondary mb-3" style="font-size: 64px;">shopping_cart</span>
                <h5 class="fw-bold mb-2">Giỏ hàng trống</h5>
                <p class="text-secondary mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="{{ route('menu.customer') }}" class="btn btn-warning">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">restaurant_menu</span>
                    Xem menu
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

