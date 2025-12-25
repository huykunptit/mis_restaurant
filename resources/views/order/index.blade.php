@extends('layout.app')

@php $pagename = "Home" @endphp

@section('title')

    @isset($pagename) {{ $pagename }} @endisset

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="p-6 lg:p-10 bg-background-light dark:bg-background-dark min-h-screen">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Quản lý đơn hàng</h1>
            <p class="text-gray-600 dark:text-gray-400">Xem và quản lý tất cả đơn hàng trong hệ thống</p>
            
            {{-- Bread Crumb --}}
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-medium hover:text-primary transition-colors">Trang chủ</a>
                <span class="material-symbols-outlined text-lg mx-2">chevron_right</span>
                <span>Đơn hàng</span>
            </div>
        </div>
        
        {{-- Filter Section --}}
        <div class="mb-8">
            {{-- Search Bar --}}
            <div class="mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Tìm kiếm theo tên khách hàng..."
                            class="w-full px-4 py-3 pl-12 bg-white dark:bg-card-dark border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary dark:text-white text-gray-900 shadow-md transition-all"
                        >
                        <span class="material-symbols-outlined absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                            search
                        </span>
                        <button 
                            type="button"
                            id="clearSearchBtn"
                            onclick="clearSearch()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        >
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>
                    <div id="searchResultsCount" class="text-sm text-gray-600 dark:text-gray-400 font-medium hidden">
                        <span id="searchCount">0</span> kết quả
                    </div>
                </div>
            </div>

            {{-- Filter Buttons --}}
            <div class="mb-4 flex flex-wrap gap-3">
                <button id="allButton" class="flex items-center justify-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-primary/90 transition-all duration-300 cursor-pointer">
                    <span class="material-symbols-outlined text-xl">apps</span>
                    <span>Tất cả (chưa thanh toán)</span>
                </button>

                <button id="uncompletedButton" class="flex items-center justify-center gap-2 bg-white dark:bg-card-dark text-orange-600 dark:text-orange-400 border-2 border-orange-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-300 cursor-pointer">
                    <span class="material-symbols-outlined text-xl">pending</span>
                    <span>Chưa giao món</span>
                </button>

                <button id="completedButton" class="flex items-center justify-center gap-2 bg-white dark:bg-card-dark text-blue-600 dark:text-blue-400 border-2 border-blue-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300 cursor-pointer">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    <span>Đã giao món và chưa thanh toán</span>
                </button>

                <button id="finishedButton" class="flex items-center justify-center gap-2 bg-white dark:bg-card-dark text-green-600 dark:text-green-400 border-2 border-green-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-all duration-300 cursor-pointer">
                    <span class="material-symbols-outlined text-xl">check_circle</span>
                    <span>Đã hoàn thành</span>
                </button>
            </div>

            {{-- Date Filter --}}
            <div class="flex items-center gap-3 flex-wrap">
                <div class="relative flex items-center gap-2 bg-white dark:bg-card-dark rounded-lg shadow-md px-4 py-2 border-2 border-gray-200 dark:border-gray-700 hover:border-primary dark:hover:border-primary transition-colors">
                    <span class="material-symbols-outlined text-primary text-xl">calendar_today</span>
                    <label for="dateFilter" class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        Lọc theo ngày:
                    </label>
                    <input 
                        type="date" 
                        id="dateFilter" 
                        name="date"
                        value="{{ $dateFilter ?? '' }}"
                        class="ml-2 px-3 py-1.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white font-medium cursor-pointer date-picker-custom"
                        onchange="applyDateFilter()"
                    >
                </div>
                @if($dateFilter)
                    <button 
                        onclick="clearDateFilter()" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 text-sm font-medium"
                    >
                        <span class="material-symbols-outlined text-base">close</span>
                        Xóa lọc
                    </button>
                @endif
            </div>
        </div>
        
        
        <div class="w-full my-10">
            
            {{-- All Tables --}}
            <div id="allContent">

                @isset($filledTables)

                    {{-- All Content Grids --}}
                    <div id="allGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

                        @foreach ($filledTables as $filledTable)

                            @include('order.partials.table-card', ['filledTable' => $filledTable, 'cardColor' => 'primary'])

                        @endforeach

                    </div>

                    {{-- Pagination --}}
                    @if($filledTables->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $filledTables->withQueryString()->links() }}
                        </div>
                    @endif

                @else

                    <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mx-auto mb-4 block">receipt_long</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Không có đơn hàng nào</p>
                        <p class="text-gray-600 dark:text-gray-400">Hiện tại chưa có đơn hàng nào trong hệ thống.</p>
                    </div>
                    
                @endisset

            </div>
            
            {{-- Table with Uncompleted Orders --}}
            <div id="uncompletedContent" class="hidden">
                @php
                    $hasUncompleted = false;
                @endphp
                
                {{-- Uncompleted Order Grids --}}
                <div id="uncompletedGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

                    @foreach ($filledTables as $filledTable)

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())

                            {{-- Uncompleted Orders --}}
                            @if (!$filledTable->order->every('completion_status', 'yes'))
                                
                                @php
                                    $hasUncompleted = true;
                                @endphp
                                
                                @include('order.partials.table-card', ['filledTable' => $filledTable, 'cardColor' => 'orange'])
                                
                            @endif
                            
                        @endif
                        
                    @endforeach
                   
                </div>

                {{-- Pagination --}}
                @if($filledTables->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $filledTables->withQueryString()->links() }}
                    </div>
                @endif

                @if (!$hasUncompleted)
                    <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mx-auto mb-4 block">check_circle</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Tất cả đơn đã được giao</p>
                        <p class="text-gray-600 dark:text-gray-400">Tuyệt vời! Tất cả đơn hàng đã được xử lý.</p>
                    </div>
                @endif

            </div>

            {{-- Table with Completed Orders --}}
            <div id="completedContent" class="hidden">
                @php
                    $hasCompletedUnpaid = false;
                @endphp
                
                {{-- Completed Order Grids --}}
                <div id="completedGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

                    @foreach ($filledTables as $filledTable )

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())
                            
                            {{-- Completed Orders --}}
                            @if ($filledTable->order->every('completion_status', 'yes'))

                                {{-- Unpaid Orders --}}
                                @if (!$filledTable->order->every('payment_status', 'yes'))

                                    @php
                                        $hasCompletedUnpaid = true;
                                    @endphp

                                    @include('order.partials.table-card', ['filledTable' => $filledTable, 'cardColor' => 'blue'])

                                @endif

                            @endif
                            
                        @endif
                    
                    @endforeach

                </div>

                {{-- Pagination --}}
                @if($filledTables->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $filledTables->withQueryString()->links() }}
                    </div>
                @endif

                @if (!$hasCompletedUnpaid)
                    <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mx-auto mb-4 block">payments</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Không có đơn nào đã giao và chưa thanh toán</p>
                        <p class="text-gray-600 dark:text-gray-400">Hãy đợi khách hàng hoàn thành bữa ăn.</p>
                    </div>
                @endif

            </div>

            {{-- Finished Orders (Completed & Paid) --}}
            <div id="finishedContent" class="hidden">
                @php
                    // Query finished orders by Table (new system)
                    $finishedQuery = \App\Models\Table::select('id', 'table_number', 'zone', 'status')
                        ->with([
                            'transactions' => function($q) use ($dateFilter) {
                                $q->select('id', 'user_id', 'staff_id', 'table_id', 'menu_id', 'menu_option_id', 'quantity', 'payment_status', 'completion_status', 'created_at', 'updated_at', 'order_group_id')
                                      ->where('payment_status', 'yes')
                                      ->where('completion_status', 'yes');
                                if ($dateFilter) {
                                    $q->whereDate('updated_at', $dateFilter);
                                }
                            },
                            'transactions.menuOption:id,cost',
                            'transactions.menu:id,name,category_id',
                            'transactions.menu.category:id,name',
                            'transactions.staff:id,first_name,last_name',
                            'transactions.user:id,first_name,last_name',
                        ])
                        ->whereHas('transactions', function($q) use ($dateFilter) {
                            $q->where('payment_status', 'yes')
                                  ->where('completion_status', 'yes');
                            if ($dateFilter) {
                                $q->whereDate('updated_at', $dateFilter);
                            }
                        });
                    
                    // Add search if exists
                    if (!empty($search)) {
                        $finishedQuery->where(function($q) use ($search) {
                            $q->where('table_number', 'like', '%' . $search . '%')
                              ->orWhere('zone', 'like', '%' . $search . '%')
                              ->orWhereRaw("CONCAT(COALESCE(zone, ''), ' - Bàn ', table_number) LIKE ?", ['%' . $search . '%']);
                        });
                    }
                    
                    $finishedTables = $finishedQuery->paginate(15)->appends(request()->query());
                    
                    // Transform to match view expectations
                    $finishedTables->getCollection()->transform(function($table) {
                        $table->order = $table->transactions;
                        $firstTransaction = $table->transactions->first();
                        if ($firstTransaction && $firstTransaction->user) {
                            $table->first_name = $firstTransaction->user->first_name;
                            $table->last_name = $firstTransaction->user->last_name;
                        } else {
                            $table->first_name = 'Khách';
                            $table->last_name = 'vãng lai';
                        }
                        return $table;
                    });
                @endphp

                @if($finishedTables->count() > 0)
                    <div id="finishedGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                        @foreach($finishedTables as $finishedTable)
                            @include('order.partials.table-card', ['filledTable' => $finishedTable, 'cardColor' => 'green'])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($finishedTables->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $finishedTables->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mx-auto mb-4 block">check_circle</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Không có đơn đã hoàn thành</p>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if(isset($dateFilter) && $dateFilter)
                                Không có đơn nào hoàn thành vào ngày {{ \Carbon\Carbon::parse($dateFilter)->format('d/m/Y') }}
                            @else
                                Chưa có đơn hàng nào đã hoàn thành (giao xong và thanh toán xong).
                            @endif
                        </p>
                    </div>
                @endif
            </div>
            
        </div>

    </div>

    {{-- Custom Styles for Date Picker --}}
    <style>
        .date-picker-custom {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: transparent;
            cursor: pointer;
            min-width: 150px;
        }
        
        .date-picker-custom::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: invert(0.5) sepia(1) saturate(5) hue-rotate(175deg);
            opacity: 0.7;
            transition: opacity 0.2s;
            padding: 4px;
        }
        
        .date-picker-custom::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
        
        .date-picker-custom::-webkit-datetime-edit-text {
            color: inherit;
            padding: 0 2px;
        }
        
        .date-picker-custom::-webkit-datetime-edit-month-field,
        .date-picker-custom::-webkit-datetime-edit-day-field,
        .date-picker-custom::-webkit-datetime-edit-year-field {
            color: inherit;
            padding: 0.2em 0.3em;
        }
        
        .dark .date-picker-custom::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>

    {{-- JavaScript --}}
    <script src="{{ asset('js/order_index.js') }}"></script>
    <script>
        // Date filter functions
        function applyDateFilter() {
            const date = document.getElementById('dateFilter').value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('date', date);
            // Preserve filter and search parameters if exists
            const activeFilter = document.querySelector('.bg-primary, .bg-orange-600, .bg-blue-600, .bg-green-600')?.id;
            if (activeFilter === 'finishedButton') {
                currentUrl.searchParams.set('filter', 'completed');
            }
            const searchValue = document.getElementById('searchInput')?.value;
            if (searchValue) {
                currentUrl.searchParams.set('search', searchValue);
            }
            window.location.href = currentUrl.toString();
        }

        function clearDateFilter() {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('date');
            window.location.href = currentUrl.toString();
        }

        // Realtime Search Functions
        function performSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            const resultsCount = document.getElementById('searchResultsCount');
            const searchCount = document.getElementById('searchCount');
            
            // Show/hide clear button
            if (searchTerm.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
                resultsCount.classList.add('hidden');
            }
            
            // Get current active tab
            let activeGrid = null;
            if (!document.getElementById('allContent').classList.contains('hidden')) {
                activeGrid = document.getElementById('allGrid');
            } else if (!document.getElementById('uncompletedContent').classList.contains('hidden')) {
                activeGrid = document.getElementById('uncompletedGrid');
            } else if (!document.getElementById('completedContent').classList.contains('hidden')) {
                activeGrid = document.getElementById('completedGrid');
            } else if (!document.getElementById('finishedContent').classList.contains('hidden')) {
                activeGrid = document.getElementById('finishedGrid');
            }
            
            if (!activeGrid) return;
            
            // Get all order cards in active tab
            const cards = activeGrid.querySelectorAll('.order-item, .order-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const customerName = card.getAttribute('data-customer-name') || '';
                
                if (searchTerm === '' || customerName.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update results count
            if (searchTerm.length > 0) {
                resultsCount.classList.remove('hidden');
                searchCount.textContent = visibleCount;
            }
            
            // Show empty state if no results
            const existingEmptyState = activeGrid.querySelector('.empty-state');
            if (visibleCount === 0 && searchTerm.length > 0) {
                if (!existingEmptyState) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'empty-state order-card bg-white dark:bg-card-dark rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700';
                    emptyDiv.style.gridColumn = '1 / -1';
                    emptyDiv.innerHTML = `
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mx-auto mb-4 block">search_off</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Không tìm thấy kết quả</p>
                        <p class="text-gray-600 dark:text-gray-400">Không có đơn hàng nào phù hợp với từ khóa "<strong>${searchTerm}</strong>"</p>
                    `;
                    activeGrid.appendChild(emptyDiv);
                }
            } else {
                if (existingEmptyState) {
                    existingEmptyState.remove();
                }
            }
        }
        
        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';
            performSearch();
        }
        
        // Initialize search on page load
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                // Real-time search on input
                searchInput.addEventListener('input', performSearch);
                
                // Also search when switching tabs
                const tabButtons = ['allButton', 'uncompletedButton', 'completedButton', 'finishedButton'];
                tabButtons.forEach(btnId => {
                    const btn = document.getElementById(btnId);
                    if (btn) {
                        btn.addEventListener('click', function() {
                            setTimeout(performSearch, 300); // Delay to ensure tab switch completes
                        });
                    }
                });
                
                // Initial search to set up state
                performSearch();
            }
        });

        // Initialize active tab based on filter parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const filter = urlParams.get('filter');
            if (filter === 'completed') {
                const finishedButton = document.getElementById('finishedButton');
                const finishedContent = document.getElementById('finishedContent');
                if (finishedButton && finishedContent) {
                    // Hide all other content
                    document.getElementById('allContent').classList.add('hidden');
                    document.getElementById('uncompletedContent').classList.add('hidden');
                    document.getElementById('completedContent').classList.add('hidden');
                    finishedContent.classList.remove('hidden');
                    
                    // Update button styles
                    document.querySelectorAll('[id$="Button"]').forEach(btn => {
                        if (btn.id === 'allButton') {
                            btn.classList.remove('bg-primary', 'text-white');
                            btn.classList.add('bg-white', 'dark:bg-card-dark', 'text-primary', 'border-2', 'border-primary');
                        } else if (btn.id === 'uncompletedButton') {
                            btn.classList.remove('bg-orange-600', 'text-white');
                            btn.classList.add('bg-white', 'dark:bg-card-dark', 'text-orange-600', 'dark:text-orange-400', 'border-2', 'border-orange-500');
                        } else if (btn.id === 'completedButton') {
                            btn.classList.remove('bg-blue-600', 'text-white');
                            btn.classList.add('bg-white', 'dark:bg-card-dark', 'text-blue-600', 'dark:text-blue-400', 'border-2', 'border-blue-500');
                        } else if (btn.id === 'finishedButton') {
                            btn.classList.remove('bg-white', 'dark:bg-card-dark', 'text-green-600', 'dark:text-green-400', 'border-2', 'border-green-500');
                            btn.classList.add('bg-green-600', 'text-white');
                        }
                    });
                }
            }
        });
    </script>

@endsection
