{{-- Order Table Card Component - List Style Design --}}
@php
    $total = 0;
    foreach ($filledTable->order as $order) {
        if ($order->payment_status == "no") {
            $total += $order->menuOption->cost * $order->quantity;
        }
    }
    
    // Determine card color based on tab
    $cardColor = $cardColor ?? 'primary';
    $colorClasses = [
        'primary' => [
            'bg' => 'bg-blue-500',
            'light' => 'bg-blue-50',
            'text' => 'text-blue-600',
            'border' => 'border-blue-500',
            'dark-bg' => 'dark:bg-blue-900/20'
        ],
        'orange' => [
            'bg' => 'bg-orange-500',
            'light' => 'bg-orange-50',
            'text' => 'text-orange-600',
            'border' => 'border-orange-500',
            'dark-bg' => 'dark:bg-orange-900/20'
        ],
        'blue' => [
            'bg' => 'bg-cyan-500',
            'light' => 'bg-cyan-50',
            'text' => 'text-cyan-600',
            'border' => 'border-cyan-500',
            'dark-bg' => 'dark:bg-cyan-900/20'
        ],
        'green' => [
            'bg' => 'bg-green-500',
            'light' => 'bg-green-50',
            'text' => 'text-green-600',
            'border' => 'border-green-500',
            'dark-bg' => 'dark:bg-green-900/20'
        ],
    ];
    $colorConfig = $colorClasses[$cardColor] ?? $colorClasses['primary'];
    
    $totalOrders = $filledTable->order->count();
    $completedOrders = $filledTable->order->where('completion_status', 'yes')->count();
    $allCompleted = $totalOrders > 0 && $completedOrders == $totalOrders;
    $allPaid = $filledTable->order->every('payment_status', 'yes');
    
    // Get table info - $filledTable is already a Table object in new system
    $tableInfo = null;
    if (isset($filledTable->id) && isset($filledTable->table_number)) {
        // New system: $filledTable is Table object
        $tableInfo = $filledTable;
    } else {
        // Old system: get from first order
        $firstOrder = $filledTable->order->first();
        $tableInfo = $firstOrder && $firstOrder->table ? $firstOrder->table : null;
    }
@endphp

<div class="order-item group bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border-l-4 {{ $colorConfig['border'] }} overflow-hidden" 
     data-customer-name="{{ strtolower(isset($filledTable->first_name) ? $filledTable->first_name . ' ' . $filledTable->last_name : '') }}">
    
    <div class="p-3">
        {{-- Top Row: Customer Info & Status --}}
        <div class="flex items-start justify-between gap-2 mb-3">
            {{-- Left: Customer Info --}}
            <div class="flex items-center gap-2 flex-1 min-w-0">
                {{-- Avatar --}}
                <div class="flex-shrink-0 w-10 h-10 {{ $colorConfig['bg'] }} rounded-lg flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-white text-lg">person</span>
                </div>
                
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-0.5 truncate">
                        @if(isset($filledTable->first_name))
                            {{ $filledTable->first_name . " " . $filledTable->last_name }}
                        @elseif(isset($filledTable->zone))
                            {{ $filledTable->zone }} - Bàn {{ $filledTable->table_number }}
                        @else
                            Bàn {{ $filledTable->table_number }}
                        @endif
                    </h3>
                    <div class="flex flex-wrap items-center gap-1.5">
                        @if($tableInfo)
                            <span class="inline-flex items-center gap-0.5 text-xs {{ $colorConfig['text'] }} font-medium">
                                <span class="material-symbols-outlined text-xs">table_restaurant</span>
                                @if($tableInfo->zone)
                                    {{ $tableInfo->zone }} - Bàn {{ $tableInfo->table_number }}
                                @else
                                    Bàn {{ $tableInfo->table_number }}
                                @endif
                            </span>
                        @elseif(isset($filledTable->zone))
                            <span class="inline-flex items-center gap-0.5 text-xs {{ $colorConfig['text'] }} font-medium">
                                <span class="material-symbols-outlined text-xs">table_restaurant</span>
                                @if($filledTable->zone)
                                    {{ $filledTable->zone }} - Bàn {{ $filledTable->table_number }}
                                @else
                                    Bàn {{ $filledTable->table_number }}
                                @endif
                            </span>
                        @endif
                        @if($tableInfo || isset($filledTable->zone))
                            <span class="text-gray-400 text-xs">•</span>
                        @endif
                        <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">
                            {{ $totalOrders }} món
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- Right: Status Badges --}}
            <div class="flex flex-col gap-1 items-end flex-shrink-0">
                @if ($allCompleted)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded">
                        <span class="material-symbols-outlined text-xs">check_circle</span>
                        Đã giao
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded">
                        <span class="material-symbols-outlined text-xs">pending</span>
                        {{ $completedOrders }}/{{ $totalOrders }}
                    </span>
                @endif
                
                @if ($allPaid)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded">
                        <span class="material-symbols-outlined text-xs">payments</span>
                        Đã TT
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-semibold rounded">
                        <span class="material-symbols-outlined text-xs">payment</span>
                        Chưa TT
                    </span>
                @endif
            </div>
        </div>

        {{-- Progress Bar (if not completed) --}}
        @if($totalOrders > 0 && !$allCompleted)
            <div class="mb-2">
                <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                    <span class="font-medium">Tiến độ</span>
                    <span class="font-semibold {{ $colorConfig['text'] }}">{{ round(($completedOrders / $totalOrders) * 100) }}%</span>
                </div>
                <div class="relative w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                    <div class="{{ $colorConfig['bg'] }} h-full rounded-full transition-all duration-500" 
                         style="width: {{ ($completedOrders / $totalOrders) * 100 }}%">
                    </div>
                </div>
            </div>
        @endif

        {{-- Amount & Actions Row --}}
        <div class="flex items-center justify-between gap-2 p-2 {{ $colorConfig['light'] }} {{ $colorConfig['dark-bg'] }} rounded-lg mb-2">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 {{ $colorConfig['bg'] }} rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-sm">account_balance_wallet</span>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mb-0">Tổng tiền</p>
                    @if ($allPaid)
                        <p class="text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-xs">check_circle</span>
                            Đã TT
                        </p>
                    @else
                        <p class="text-base font-bold {{ $colorConfig['text'] }} dark:text-white">
                            {{ number_format($total, 0) }} ₫
                        </p>
                    @endif
                </div>
            </div>
            
            <a href="{{ route('order.show', $filledTable->id) }}" 
               class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-1.5 {{ $colorConfig['bg'] }} hover:opacity-90 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-xs">
                <span class="material-symbols-outlined text-sm">visibility</span>
                <span class="hidden sm:inline">Chi tiết</span>
            </a>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-2 gap-2">
            {{-- Complete Button --}}
            @if ($allCompleted)
                <button disabled class="flex items-center justify-center gap-1 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 py-1.5 rounded-lg cursor-not-allowed font-semibold text-xs">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>Đã giao</span>
                </button>
            @else
                <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('put')
                    <button type="submit" class="w-full flex items-center justify-center gap-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-1.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-xs">
                        <span class="material-symbols-outlined text-sm">restaurant_menu</span>
                        <span>Giao món</span>
                    </button>
                </form>
            @endif

            {{-- Payment Button --}}
            @if ($allPaid)
                <button disabled class="flex items-center justify-center gap-1 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 py-1.5 rounded-lg cursor-not-allowed font-semibold text-xs">
                    <span class="material-symbols-outlined text-sm">task_alt</span>
                    <span>Đã TT</span>
                </button>
            @else
                <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('put')
                    <button type="submit" class="w-full flex items-center justify-center gap-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-xs">
                        <span class="material-symbols-outlined text-sm">payments</span>
                        <span>Thanh toán</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
    .order-item {
        transform: translateZ(0);
        will-change: transform, box-shadow;
    }
    
    .order-item:hover {
        transform: translateX(4px) translateZ(0);
    }
</style>