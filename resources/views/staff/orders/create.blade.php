@extends('layout.app')

@php $pagename = "Đặt món" @endphp

@section('title')
    Đặt món - {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('header-title')
    <a href="{{ route('staff.orders.select-table') }}" class="text-decoration-none text-white me-2">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    {{ $table->zone }} - Bàn {{ $table->table_number }}
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    {{-- Current Orders Summary --}}
    @if($currentOrders->count() > 0)
        <div class="card border-0 shadow-sm mb-4 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold">Đơn hiện tại: {{ $currentOrders->count() }} món</h6>
                        <p class="mb-0 text-secondary">Tổng: <strong class="text-primary">{{ number_format($currentTotal, 0) }} VNĐ</strong></p>
                    </div>
                    <a href="{{ route('staff.orders.table', $table->id) }}" class="btn btn-primary">
                        <span class="material-symbols-outlined" style="vertical-align: middle;">receipt_long</span>
                        Xem đơn
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Menu Selection --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="categoryTabs" role="tablist">
                        @foreach($categories as $index => $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                        id="tab-{{ $category->id }}" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#category-{{ $category->id }}" 
                                        type="button" 
                                        role="tab">
                                    {{ $category->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body" style="max-height: 60vh; overflow-y: auto;">
                    <div class="tab-content" id="categoryTabContent">
                        @foreach($categories as $index => $category)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                 id="category-{{ $category->id }}" 
                                 role="tabpanel">
                                <div class="row g-3">
                                    @php
                                        $categoryMenus = $menusByCategory->get($category->id, collect());
                                    @endphp
                                    @forelse($categoryMenus as $menu)
                                        @foreach($menu->menuOption as $option)
                                            <div class="col-6 col-md-4">
                                                <div class="card border h-100 menu-item-card" 
                                                     data-menu-id="{{ $menu->id }}"
                                                     data-option-id="{{ $option->id }}"
                                                     data-menu-name="{{ $menu->name }}"
                                                     data-option-name="{{ $option->name }}"
                                                     data-price="{{ $option->cost }}">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title mb-2 fw-bold" style="font-size: 14px;">
                                                            {{ $menu->name }}
                                                        </h6>
                                                        @if($option->name)
                                                            <p class="text-secondary small mb-2">{{ $option->name }}</p>
                                                        @endif
                                                        <p class="text-primary fw-bold mb-2">
                                                            {{ number_format($option->cost, 0) }} VNĐ
                                                        </p>
                                                        <button class="btn btn-sm btn-primary w-100 add-to-cart-btn">
                                                            <span class="material-symbols-outlined" style="font-size: 16px; vertical-align: middle;">add</span>
                                                            Thêm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @empty
                                        <div class="col-12 text-center py-4">
                                            <span class="material-symbols-outlined text-secondary" style="font-size: 48px;">restaurant_menu</span>
                                            <p class="text-secondary mt-2">Chưa có món nào trong danh mục này</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Cart Sidebar --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        Đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <form id="orderForm" action="{{ route('staff.orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="table_id" value="{{ $table->id }}">
                        
                        <div id="cartItems" class="mb-3" style="max-height: 40vh; overflow-y: auto;">
                            <p class="text-center text-secondary py-4">Chưa có món nào</p>
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold">Tổng tiền:</span>
                                <span class="fw-bold text-primary fs-5" id="totalAmount">0 VNĐ</span>
                            </div>
                            
                            <div class="mb-3">
                                <label for="remarks" class="form-label small">Ghi chú (tùy chọn)</label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Ghi chú cho đơn hàng..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                                <span class="material-symbols-outlined" style="vertical-align: middle;">check</span>
                                Xác nhận đặt món
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = [];
    const cartItemsContainer = document.getElementById('cartItems');
    const totalAmountElement = document.getElementById('totalAmount');
    const submitBtn = document.getElementById('submitBtn');
    const orderForm = document.getElementById('orderForm');

    // Add to cart
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.menu-item-card');
            const menuId = card.dataset.menuId;
            const optionId = card.dataset.optionId;
            const menuName = card.dataset.menuName;
            const optionName = card.dataset.optionName;
            const price = parseFloat(card.dataset.price);

            // Tìm item trong cart
            const existingItem = cart.find(item => item.menu_id === menuId && item.menu_option_id === optionId);

            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    menu_id: menuId,
                    menu_option_id: optionId,
                    menu_name: menuName,
                    option_name: optionName,
                    price: price,
                    quantity: 1
                });
            }

            renderCart();
        });
    });

    function renderCart() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center text-secondary py-4">Chưa có món nào</p>';
            submitBtn.disabled = true;
            totalAmountElement.textContent = '0 VNĐ';
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            html += `
                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold" style="font-size: 14px;">${item.menu_name}</h6>
                        ${item.option_name ? `<small class="text-secondary">${item.option_name}</small><br>` : ''}
                        <small class="text-primary fw-bold">${item.price.toLocaleString('vi-VN')} VNĐ</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-index="${index}" data-action="decrease">
                            <span class="material-symbols-outlined" style="font-size: 16px;">remove</span>
                        </button>
                        <span class="fw-bold" style="min-width: 30px; text-align: center;">${item.quantity}</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-index="${index}" data-action="increase">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn" data-index="${index}">
                            <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                        </button>
                    </div>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = html;
        totalAmountElement.textContent = total.toLocaleString('vi-VN') + ' VNĐ';
        submitBtn.disabled = false;

        // Quantity buttons
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const action = this.dataset.action;

                if (action === 'increase') {
                    cart[index].quantity++;
                } else if (action === 'decrease') {
                    if (cart[index].quantity > 1) {
                        cart[index].quantity--;
                    } else {
                        cart.splice(index, 1);
                    }
                }

                renderCart();
            });
        });

        // Remove buttons
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                cart.splice(index, 1);
                renderCart();
            });
        });
    }

    // Form submit
    orderForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (cart.length === 0) {
            alert('Vui lòng chọn ít nhất một món');
            return;
        }

        // Tạo hidden inputs cho items
        cart.forEach((item, index) => {
            const menuInput = document.createElement('input');
            menuInput.type = 'hidden';
            menuInput.name = `items[${index}][menu_id]`;
            menuInput.value = item.menu_id;
            orderForm.appendChild(menuInput);

            const optionInput = document.createElement('input');
            optionInput.type = 'hidden';
            optionInput.name = `items[${index}][menu_option_id]`;
            optionInput.value = item.menu_option_id;
            orderForm.appendChild(optionInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = `items[${index}][quantity]`;
            quantityInput.value = item.quantity;
            orderForm.appendChild(quantityInput);
        });

        // Submit form
        this.submit();
    });
});
</script>
@endsection

