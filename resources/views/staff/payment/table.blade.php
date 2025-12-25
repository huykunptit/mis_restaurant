@extends('layout.app')

@php $pagename = "Thanh toán" @endphp

@section('title')
    Thanh toán - {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('header-title')
    <a href="{{ route('staff.orders.table', $table->id) }}" class="text-decoration-none text-white me-2">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    Thanh toán - {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            {{-- Payment Early Warning --}}
            @if(isset($completedCount) && $completedCount < $totalCount)
                <div class="alert alert-warning mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined">info</span>
                        <div>
                            <strong>Thanh toán sớm:</strong> Bạn đang thanh toán trước khi tất cả món được giao.
                            <br>
                            <small>Đã giao: {{ $completedCount }}/{{ $totalCount }} món</small>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Order Summary with Remove Items --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    <small class="opacity-75">Bỏ chọn món không dùng để trừ tiền</small>
                </div>
                <div class="card-body">
                    @foreach($orderGroups as $group)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Đơn #{{ substr($group['group_id'], -8) }}</h6>
                                    <small class="text-secondary">{{ $group['orders']->first()->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <strong class="text-primary" id="group-total-{{ $loop->index }}">{{ number_format($group['total'], 0) }} VNĐ</strong>
                            </div>
                            <div class="small">
                                @foreach($group['orders'] as $order)
                                    @php
                                        $itemPrice = ($order->menuOption->cost ?? 0) * $order->quantity;
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: #f8f9fa;">
                                        <div class="form-check flex-grow-1">
                                            <input class="form-check-input order-item-checkbox" 
                                                   type="checkbox" 
                                                   value="{{ $order->id }}" 
                                                   id="item-{{ $order->id }}"
                                                   data-price="{{ $itemPrice }}"
                                                   data-group-index="{{ $loop->parent->index }}"
                                                   checked
                                                   onchange="updateTotal()">
                                            <label class="form-check-label" for="item-{{ $order->id }}">
                                                <strong>{{ $order->menu->name }}</strong>
                                                @if($order->menuOption->name)
                                                    <small class="text-secondary">({{ $order->menuOption->name }})</small>
                                                @endif
                                                <br>
                                                <small class="text-secondary">x{{ $order->quantity }} = {{ number_format($itemPrice, 0) }} VNĐ</small>
                                            </label>
                                        </div>
                                        <div class="text-end">
                                            @if($order->completion_status === 'yes')
                                                <span class="badge bg-success">Đã giao</span>
                                            @else
                                                <span class="badge bg-warning">Chưa giao</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <h5 class="mb-0">Tổng cộng:</h5>
                        <h3 class="text-primary mb-0" id="finalTotal">{{ number_format($total, 0) }} VNĐ</h3>
                    </div>
                    <div class="mt-2">
                        <small class="text-secondary">
                            <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">info</span>
                            Bỏ chọn món không dùng để tự động trừ tiền
                        </small>
                    </div>
                </div>
            </div>

            {{-- Payment Method Selection --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Chọn phương thức thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="sepay_qr" value="sepay_qr" checked>
                            <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="sepay_qr">
                                <span class="material-symbols-outlined mb-2" style="font-size: 32px;">qr_code</span>
                                <span class="fw-bold">Sepay QR</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="vnpay_qr" value="vnpay_qr">
                            <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="vnpay_qr">
                                <span class="material-symbols-outlined mb-2" style="font-size: 32px;">qr_code</span>
                                <span class="fw-bold">VNPay QR</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="bank_transfer">
                            <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="bank_transfer">
                                <span class="material-symbols-outlined mb-2" style="font-size: 32px;">account_balance</span>
                                <span class="fw-bold">Chuyển khoản</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="cash" value="cash">
                            <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="cash">
                                <span class="material-symbols-outlined mb-2" style="font-size: 32px;">payments</span>
                                <span class="fw-bold">Tiền mặt</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QR Code Display (chỉ hiện khi chọn QR methods) --}}
            <div class="card border-0 shadow-sm mb-4" id="qrCodeCard" style="display: none;">
                <div class="card-header bg-white text-center">
                    <h5 class="mb-0">Quét mã QR để thanh toán</h5>
                </div>
                <div class="card-body text-center">
                    <div id="qrCodeContainer" class="mb-3">
                        <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                    </div>
                    <div class="mb-3">
                        <p class="text-secondary mb-1">Số tiền: <strong class="text-primary" id="qrAmount">{{ number_format($total, 0) }} VNĐ</strong></p>
                        <p class="text-secondary mb-0">Mã đơn: <strong id="paymentId"></strong></p>
                    </div>
                    <div class="alert alert-warning mb-3">
                        <span class="material-symbols-outlined" style="vertical-align: middle;">schedule</span>
                        Mã QR có hiệu lực trong <strong id="countdown">5:00</strong> phút
                    </div>
                    <form id="confirmPaymentForm" action="" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">check_circle</span>
                            Xác nhận thanh toán thành công
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cash Payment Confirmation (chỉ hiện khi chọn cash) --}}
            <div class="card border-0 shadow-sm mb-4" id="cashPaymentCard" style="display: none;">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Xác nhận thanh toán tiền mặt</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <span class="material-symbols-outlined text-success" style="font-size: 64px;">payments</span>
                    </div>
                    <div class="mb-3">
                        <p class="text-secondary mb-1">Số tiền cần thu:</p>
                        <h2 class="text-primary mb-0" id="cashAmount">{{ number_format($total, 0) }} VNĐ</h2>
                    </div>
                    <form id="confirmCashPaymentForm" action="" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">check_circle</span>
                            Xác nhận đã nhận tiền mặt
                        </button>
                    </form>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary btn-lg" id="continueBtn">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span>
                    <span id="continueBtnText">Tiếp tục</span>
                </button>
                <a href="{{ route('staff.orders.table', $table->id) }}" class="btn btn-outline-secondary">
                    <span class="material-symbols-outlined" style="vertical-align: middle;">arrow_back</span>
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const continueBtn = document.getElementById('continueBtn');
    const continueBtnText = document.getElementById('continueBtnText');
    const qrCodeCard = document.getElementById('qrCodeCard');
    const cashPaymentCard = document.getElementById('cashPaymentCard');
    const qrCodeImage = document.getElementById('qrCodeImage');
    const paymentIdElement = document.getElementById('paymentId');
    const confirmPaymentForm = document.getElementById('confirmPaymentForm');
    const confirmCashPaymentForm = document.getElementById('confirmCashPaymentForm');
    const countdownElement = document.getElementById('countdown');
    const cashAmountElement = document.getElementById('cashAmount');
    let countdownInterval = null;
    let expiresAt = null;
    let finalAmount = {{ $total }};
    let currentPaymentId = null;

    // Listen to payment method changes
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset UI
            qrCodeCard.style.display = 'none';
            cashPaymentCard.style.display = 'none';
            continueBtn.style.display = 'block';
            continueBtn.disabled = false;
            
            if (this.value === 'cash') {
                continueBtnText.textContent = 'Tiếp tục';
            } else {
                continueBtnText.textContent = 'Tạo mã QR thanh toán';
            }
        });
    });

    // Update total when items are unchecked
    function updateTotal() {
        const checkboxes = document.querySelectorAll('.order-item-checkbox:checked');
        let newTotal = 0;
        
        checkboxes.forEach(checkbox => {
            newTotal += parseFloat(checkbox.dataset.price);
        });
        
        finalAmount = newTotal;
        document.getElementById('finalTotal').textContent = newTotal.toLocaleString('vi-VN') + ' VNĐ';
        if (cashAmountElement) {
            cashAmountElement.textContent = newTotal.toLocaleString('vi-VN') + ' VNĐ';
        }
        
        // Update group totals
        const groups = {};
        checkboxes.forEach(checkbox => {
            const groupIndex = checkbox.dataset.groupIndex;
            if (!groups[groupIndex]) {
                groups[groupIndex] = 0;
            }
            groups[groupIndex] += parseFloat(checkbox.dataset.price);
        });
        
        Object.keys(groups).forEach(groupIndex => {
            const groupTotalEl = document.getElementById('group-total-' + groupIndex);
            if (groupTotalEl) {
                groupTotalEl.textContent = groups[groupIndex].toLocaleString('vi-VN') + ' VNĐ';
            }
        });
    }

    continueBtn.addEventListener('click', function() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const tableId = {{ $table->id }};
        
        // Get checked items
        const checkedItems = Array.from(document.querySelectorAll('.order-item-checkbox:checked')).map(cb => parseInt(cb.value));
        const uncheckedItems = Array.from(document.querySelectorAll('.order-item-checkbox:not(:checked)')).map(cb => parseInt(cb.value));
        
        // Calculate final amount
        finalAmount = 0;
        checkedItems.forEach(itemId => {
            const checkbox = document.getElementById('item-' + itemId);
            if (checkbox) {
                finalAmount += parseFloat(checkbox.dataset.price);
            }
        });

        if (finalAmount < 1000) {
            alert('Số tiền thanh toán phải tối thiểu 1.000 VNĐ');
            return;
        }

        // Nếu là tiền mặt, tạo payment và hiển thị form xác nhận
        if (paymentMethod === 'cash') {
            // Disable button
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

            // Tạo payment trực tiếp (không cần QR)
            fetch('{{ route("staff.payment.create-qr") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table_id: tableId,
                    payment_method: paymentMethod,
                    amount: finalAmount,
                    removed_items: uncheckedItems
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPaymentId = data.payment_id;
                    // Hiển thị form xác nhận tiền mặt
                    cashPaymentCard.style.display = 'block';
                    confirmCashPaymentForm.action = '{{ route("staff.payment.confirm", ":id") }}'.replace(':id', data.payment_id);
                    // Ẩn button tiếp tục
                    continueBtn.style.display = 'none';
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                    this.disabled = false;
                    const btnText = paymentMethod === 'cash' ? 'Tiếp tục' : 'Tạo mã QR thanh toán';
                    this.innerHTML = '<span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span><span>' + btnText + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra');
                this.disabled = false;
                const btnText = paymentMethod === 'cash' ? 'Tiếp tục' : 'Tạo mã QR thanh toán';
                this.innerHTML = '<span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span><span>' + btnText + '</span>';
            });
        } else {
            // Nếu là QR methods, tạo QR code
            // Disable button
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang tạo mã QR...';

            // Call API to generate QR code
            fetch('{{ route("staff.payment.create-qr") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table_id: tableId,
                    payment_method: paymentMethod,
                    amount: finalAmount,
                    removed_items: uncheckedItems
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPaymentId = data.payment_id;
                    // Show QR code
                    qrCodeImage.src = data.qr_code_url;
                    paymentIdElement.textContent = 'PAY-' + data.payment_id;
                    document.getElementById('qrAmount').textContent = finalAmount.toLocaleString('vi-VN') + ' VNĐ';
                    qrCodeCard.style.display = 'block';
                    confirmPaymentForm.action = '{{ route("staff.payment.confirm", ":id") }}'.replace(':id', data.payment_id);

                    // Start countdown
                    expiresAt = new Date(data.expires_at);
                    startCountdown();

                    // Hide continue button
                    continueBtn.style.display = 'none';
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                    this.disabled = false;
                    this.innerHTML = '<span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span><span>Tạo mã QR thanh toán</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tạo mã QR');
                this.disabled = false;
                this.innerHTML = '<span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span><span>Tạo mã QR thanh toán</span>';
            });
        }
    });

    // Set initial button text based on default payment method
    const defaultMethod = document.querySelector('input[name="payment_method"]:checked').value;
    if (defaultMethod === 'cash') {
        continueBtnText.textContent = 'Tiếp tục';
    } else {
        continueBtnText.textContent = 'Tạo mã QR thanh toán';
    }

    function startCountdown() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        countdownInterval = setInterval(function() {
            const now = new Date();
            const diff = expiresAt - now;

            if (diff <= 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = '0:00';
                alert('Mã QR đã hết hạn. Vui lòng tạo lại.');
                qrCodeCard.style.display = 'none';
                continueBtn.style.display = 'block';
                continueBtn.disabled = false;
                continueBtn.innerHTML = '<span class="material-symbols-outlined" style="vertical-align: middle;">arrow_forward</span><span>Tạo mã QR thanh toán</span>';
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            countdownElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }, 1000);
    }
});
</script>
@endsection

