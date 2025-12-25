@extends('layout.app')

@php $pagename = "Checkout" @endphp

@section('title')
    Thanh toán
@endsection

@section('header-title')
    Thanh toán
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Thanh toán</h1>
        <p class="text-secondary small">Xác nhận thông tin đơn hàng của bạn</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        
        <div class="row g-3">
            {{-- Order Items --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                <div class="flex-shrink-0">
                                    @if($item->menu->thumbnail)
                                        <img src="{{ asset('images/' . $item->menu->thumbnail) }}" 
                                             class="rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/noimg.png') }}" 
                                             class="rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $item->menu->name }}</h6>
                                    <small class="text-secondary">{{ $item->menuOption->name ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="small text-secondary">x{{ $item->quantity }}</span>
                                    <p class="mb-0 fw-bold">{{ number_format(($item->menuOption->cost ?? 0) * $item->quantity, 0) }} VNĐ</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Table Selection --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">Chọn bàn (Tùy chọn)</h5>
                    </div>
                    <div class="card-body">
                        <select name="table_id" class="form-select">
                            <option value="">Không chọn bàn</option>
                            @foreach($availableTables as $table)
                                <option value="{{ $table->id }}">Bàn {{ $table->table_number }} ({{ $table->seats }} chỗ)</option>
                            @endforeach
                        </select>
                        <small class="text-secondary">Nếu bạn đang ở nhà hàng, vui lòng chọn bàn của mình</small>
                    </div>
                </div>

                {{-- Remarks --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">Ghi chú</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="remarks" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Ghi chú đặc biệt cho đơn hàng (tùy chọn)"></textarea>
                    </div>
                </div>
            </div>

            {{-- Order Summary & Payment --}}
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

                        {{-- Payment Methods --}}
                        @if($payments->count() > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phương thức thanh toán</label>
                                @foreach($payments as $payment)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="payment_method" 
                                               id="payment_{{ $payment->id }}" 
                                               value="{{ $payment->method }}"
                                               @if($loop->first) checked @endif>
                                        <label class="form-check-label" for="payment_{{ $payment->id }}">
                                            {{ $payment->method }}
                                            @if($payment->bank)
                                                <small class="text-secondary d-block">{{ $payment->bank->name }}</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-warning w-100 fw-bold mb-2">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">check_circle</span>
                            Xác nhận đặt hàng
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

