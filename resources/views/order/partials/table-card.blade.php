{{-- Order Table Card Component --}}
@php
    $total = 0;
    foreach ($filledTable->order as $order) {
        if ($order->payment_status == "no") {
            $total += $order->menuOption->cost * $order->quantity;
        }
    }
@endphp

<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
    {{-- Card Header --}}
    <div class="relative bg-gradient-to-br from-green-500 to-green-700 p-6 text-white">
        {{-- Status Badges --}}
        <div class="absolute top-3 right-3 flex flex-col gap-2">
            @if ($filledTable->order->every('completion_status', 'yes'))
                <span class="px-3 py-1 bg-white bg-opacity-90 text-green-700 text-xs font-semibold rounded-full shadow-lg">Đã giao</span>
            @else
                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full shadow-lg">Chưa giao</span>
            @endif
            
            @if ($filledTable->order->every('payment_status', 'yes'))
                <span class="px-3 py-1 bg-white bg-opacity-90 text-green-700 text-xs font-semibold rounded-full shadow-lg">Đã thanh toán</span>
            @else
                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">Chưa thanh toán</span>
            @endif
        </div>

        {{-- Customer Name --}}
        <div class="mt-8">
            <p class="text-sm text-green-100 mb-1">Khách hàng</p>
            <p class="text-2xl font-bold">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="p-4">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 text-sm">Tổng tiền:</span>
            @if ($filledTable->order->every('payment_status', 'yes'))
                <span class="text-lg font-semibold text-green-600">Đã thanh toán</span>
            @else
                <span class="text-2xl font-bold text-gray-800">{{ number_format($total,0)}} VNĐ</span>
            @endif
        </div>
        
        <a href="{{ route('order.show', $filledTable->id) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center mb-2">
            Xem chi tiết
        </a>
    </div>

    {{-- Action Buttons --}}
    <div class="px-4 pb-4 flex gap-2">
        @if ($filledTable->order->every('completion_status', 'yes'))
            <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 text-center rounded-lg cursor-not-allowed font-medium">Đã giao</button>
        @else
            <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="flex-1">
                @csrf
                @method('put')
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Hoàn thành</button>
            </form>
        @endif

        @if ($filledTable->order->every('payment_status', 'yes'))
            <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 text-center rounded-lg cursor-not-allowed font-medium">Đã thanh toán</button>
        @else
            <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="flex-1">
                @csrf
                @method('put')
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Thanh toán</button>
            </form>
        @endif
    </div>
</div>

