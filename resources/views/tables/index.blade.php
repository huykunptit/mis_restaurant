@extends('layout.app')

@php $pagename = "Table" @endphp

@section('title')
    Quản lý bàn
@endsection

@section('header-title')
    Sơ đồ bàn
@endsection

@section('header-subtitle')
    Chi nhánh 1 - Ca Sáng
@endsection

@section('content')
<style>
    :root {
        --primary: #ec7f13;
        --primary-light: #fdf1e3;
        --background-light: #f8f7f6;
        --background-dark: #221910;
        --card-dark: #2d231a;
    }
    
    body {
        min-height: max(884px, 100dvh);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .table-card {
        border-radius: 0.75rem;
        transition: transform 0.2s;
    }
    .table-card:active {
        transform: scale(0.98);
    }
    
    .status-badge {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .zone-tab {
        min-width: 60px;
        border-bottom: 3px solid transparent;
        padding-bottom: 0.75rem;
        padding-top: 0.5rem;
    }
    .zone-tab.active {
        border-bottom-color: var(--primary);
    }
    
    .filter-chip {
        height: 36px;
        border-radius: 9999px;
        transition: transform 0.2s;
    }
    .filter-chip:active {
        transform: scale(0.95);
    }
</style>

<div class="bg-light" style="background-color: var(--background-light); min-height: calc(100vh - 80px); padding-bottom: 100px;">
    
    {{-- Zone Tabs --}}
    <nav class="pt-2" style="background-color: var(--background-light);">
        <div class="d-flex overflow-auto no-scrollbar px-3 gap-4 border-bottom border-secondary border-opacity-25">
            <button class="zone-tab {{ !request('zone') ? 'active' : '' }} d-flex flex-column align-items-center justify-content-center border-0 bg-transparent" data-zone="">
                <span class="{{ !request('zone') ? 'text-primary fw-bold' : 'text-secondary' }}" style="font-size: 14px; white-space: nowrap;">Tất cả</span>
            </button>
            @foreach($zones ?? [] as $zone)
                <button class="zone-tab {{ request('zone') === $zone ? 'active' : '' }} d-flex flex-column align-items-center justify-content-center border-0 bg-transparent" data-zone="{{ $zone }}">
                    <span class="{{ request('zone') === $zone ? 'text-primary fw-bold' : 'text-secondary' }}" style="font-size: 14px; white-space: nowrap;">{{ $zone }}</span>
                </button>
            @endforeach
        </div>
    </nav>

    {{-- Action Bar --}}
    <section class="py-2 px-3 d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-25">
        <div class="d-flex gap-2 overflow-auto no-scrollbar flex-grow-1">
            <button class="filter-chip d-flex align-items-center justify-content-center gap-2 px-3 border-0 {{ !request('status') ? 'active-filter' : '' }}" 
                    style="background-color: {{ !request('status') ? '#212529' : 'white' }}; color: {{ !request('status') ? 'white' : '#212529' }}; border: 1px solid #dee2e6;" data-filter="all">
                <span class="small fw-semibold">Tất cả</span>
            </button>
            @php
                $allTables = \App\Models\Table::where('is_merged', 0);
                if (request('zone')) {
                    $allTables->where('zone', request('zone'));
                }
                $allTables = $allTables->get();
                $emptyCount = $allTables->where('status', 'available')->count();
                $servingCount = $allTables->where('status', 'occupied')->count();
                $reservedCount = $allTables->where('status', 'reserved')->count();
            @endphp
            <button class="filter-chip d-flex align-items-center justify-content-center gap-2 px-3 border {{ request('status') === 'available' ? 'active-filter' : '' }}" 
                    style="background-color: {{ request('status') === 'available' ? '#212529' : 'white' }}; color: {{ request('status') === 'available' ? 'white' : '#212529' }}; border-color: #dee2e6;" data-filter="available">
                <div class="rounded-circle" style="width: 8px; height: 8px; background-color: #28a745;"></div>
                <span class="small fw-medium">Trống ({{ $emptyCount }})</span>
            </button>
            <button class="filter-chip d-flex align-items-center justify-content-center gap-2 px-3 border {{ request('status') === 'occupied' ? 'active-filter' : '' }}" 
                    style="background-color: {{ request('status') === 'occupied' ? '#212529' : 'white' }}; color: {{ request('status') === 'occupied' ? 'white' : '#212529' }}; border-color: #dee2e6;" data-filter="occupied">
                <div class="rounded-circle" style="width: 8px; height: 8px; background-color: var(--primary);"></div>
                <span class="small fw-medium">Đang phục vụ ({{ $servingCount }})</span>
            </button>
            <button class="filter-chip d-flex align-items-center justify-content-center gap-2 px-3 border {{ request('status') === 'reserved' ? 'active-filter' : '' }}" 
                    style="background-color: {{ request('status') === 'reserved' ? '#212529' : 'white' }}; color: {{ request('status') === 'reserved' ? 'white' : '#212529' }}; border-color: #dee2e6;" data-filter="reserved">
                <div class="rounded-circle" style="width: 8px; height: 8px; background-color: #6c757d;"></div>
                <span class="small fw-medium">Đã đặt ({{ $reservedCount }})</span>
            </button>
        </div>
        <div class="d-flex gap-2 ms-3">
            <button id="mergeBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-1" style="display: none;">
                <span class="material-symbols-outlined" style="font-size: 18px;">merge</span>
                <span>Gộp bàn</span>
            </button>
        </div>
    </section>

    {{-- Table Grid --}}
    <main class="px-3 pb-4">
        <div class="row g-3">
            @forelse ($tables as $table)
                @php
                    $isServing = $table->status === 'occupied';
                    $isEmpty = $table->status === 'available';
                    $isReserved = $table->status === 'reserved';
                    $isOvertime = $isServing && false; // TODO: Calculate overtime based on order time
                @endphp
                
                <div class="col-6 col-sm-4 col-md-3 table-item" 
                     data-zone="{{ $table->zone ?? '' }}" 
                     data-status="{{ $table->status }}"
                     style="display: block;">
                    <div class="table-card p-3 border rounded-3 position-relative
                        @if($isServing && !$isOvertime)
                            border-warning border-opacity-30 bg-white shadow-sm
                        @elseif($isOvertime)
                            border-danger border-opacity-30 bg-white shadow-sm
                        @elseif($isReserved)
                            border-secondary border-opacity-25 bg-light bg-opacity-50
                        @else
                            border-secondary border-opacity-25 bg-white
                        @endif">
                        
                        {{-- Checkbox for merge --}}
                        <div class="position-absolute top-0 start-0 m-2">
                            <input type="checkbox" class="table-checkbox form-check-input" 
                                   data-table-id="{{ $table->id }}" 
                                   data-table-number="{{ $table->table_number }}"
                                   style="width: 20px; height: 20px; cursor: pointer;">
                        </div>
                        
                        {{-- Status Badge --}}
                        @if($isServing)
                            <div class="position-absolute top-0 end-0 rounded-bottom-start rounded-top-end px-2 py-1" 
                                 style="background-color: {{ $isOvertime ? '#dc3545' : 'var(--primary)' }};">
                                <span class="status-badge text-white">
                                    {{ $isOvertime ? 'Overtime' : 'Serving' }}
                                </span>
                            </div>
                        @elseif($isEmpty)
                            <div class="position-absolute top-0 end-0">
                                <div class="rounded-circle" style="width: 10px; height: 10px; background-color: #28a745;"></div>
                            </div>
                        @elseif($isReserved)
                            <div class="position-absolute top-0 end-0">
                                <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">lock</span>
                            </div>
                        @endif

                        {{-- Table Number --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold fs-5 text-dark">{{ $table->table_number }}</span>
                        </div>

                        {{-- Status Icon & Time --}}
                        <div class="d-flex align-items-center gap-2 mb-2 
                            @if($isServing) text-warning @elseif($isEmpty) text-secondary @else text-secondary @endif">
                            <span class="material-symbols-outlined" style="font-size: 24px;">
                                @if($isServing)
                                    @if($isOvertime) hourglass_bottom @else soup_kitchen @endif
                                @elseif($isReserved)
                                    event_seat
                                @else
                                    table_restaurant
                                @endif
                            </span>
                            <span class="small fw-bold">
                                @if($isServing)
                                    {{-- TODO: Calculate and display duration --}}
                                    45'
                                @elseif($isReserved)
                                    {{-- TODO: Display reservation time --}}
                                    19:30
                                @else
                                    Trống
                                @endif
                            </span>
                        </div>

                        {{-- Footer Info --}}
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary border-opacity-25 pt-2 mt-1">
                            <div class="d-flex align-items-center gap-1 text-secondary">
                                <span class="material-symbols-outlined" style="font-size: 16px;">person</span>
                                <span class="small fw-medium">
                                    @if($isServing)
                                        {{-- TODO: Get current guests / capacity --}}
                                        4/4
                                    @else
                                        {{ $table->seats }} pax
                                    @endif
                                </span>
                            </div>
                            @if($isServing)
                                <span class="small fw-bold" style="color: var(--primary);">
                                    {{-- TODO: Display bill amount --}}
                                    1.250k
                                </span>
                            @elseif($isReserved)
                                <span class="small fw-medium text-secondary">
                                    {{-- TODO: Display customer name --}}
                                    Mr. Tuan
                                </span>
                            @else
                                <span class="material-symbols-outlined text-secondary" style="font-size: 18px;">add_circle</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <span class="material-symbols-outlined text-secondary mb-3" style="font-size: 64px;">table_restaurant</span>
                        <p class="text-secondary fw-medium">Chưa có bàn nào phù hợp với bộ lọc hiện tại.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Merge Form --}}
    <form id="merge-form" action="{{ route('tables.merge') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="selected_tables" id="selected-tables" value="">
    </form>

    {{-- Floating Action Button --}}
    <div class="position-fixed bottom-0 end-0 m-4" style="bottom: 100px; z-index: 40;">
        <a href="{{ route('tables.create') }}" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" 
           style="width: 56px; height: 56px; box-shadow: 0 4px 12px rgba(236, 127, 19, 0.4);">
            <span class="material-symbols-outlined" style="font-size: 28px;">add</span>
        </a>
    </div>

    {{-- Pagination --}}
    @if($tables->hasPages())
        <div class="px-3 mt-4">
            {{ $tables->withQueryString()->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentZone = '{{ request("zone") ?? "" }}';
    let currentStatus = '{{ request("status") ?? "" }}';

    // Zone tabs - Filter dynamically
    document.querySelectorAll('.zone-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const zone = this.dataset.zone || '';
            currentZone = zone;
            
            // Update active state
            document.querySelectorAll('.zone-tab').forEach(t => {
                t.classList.remove('active');
                const span = t.querySelector('span');
                span.classList.remove('text-primary', 'fw-bold');
                span.classList.add('text-secondary');
            });
            this.classList.add('active');
            const span = this.querySelector('span');
            span.classList.add('text-primary', 'fw-bold');
            span.classList.remove('text-secondary');
            
            // Filter tables
            filterTables();
        });
    });

    // Filter chips - Filter dynamically
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const filter = this.dataset.filter;
            currentStatus = filter === 'all' ? '' : filter;
            
            // Update active state
            document.querySelectorAll('.filter-chip').forEach(c => {
                c.classList.remove('active-filter');
                if (c.dataset.filter === filter) {
                    c.classList.add('active-filter');
                    c.style.backgroundColor = filter === 'all' || filter === currentStatus ? '#212529' : 'white';
                    c.style.color = filter === 'all' || filter === currentStatus ? 'white' : '#212529';
                } else {
                    c.style.backgroundColor = 'white';
                    c.style.color = '#212529';
                }
            });
            
            // Filter tables
            filterTables();
        });
    });

    // Filter tables function
    function filterTables() {
        const tableItems = document.querySelectorAll('.table-item');
        let visibleCount = 0;
        
        tableItems.forEach(item => {
            const itemZone = item.dataset.zone || '';
            const itemStatus = item.dataset.status || '';
            
            const zoneMatch = !currentZone || itemZone === currentZone;
            const statusMatch = !currentStatus || itemStatus === currentStatus;
            
            if (zoneMatch && statusMatch) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Update URL without reload
        const url = new URL(window.location);
        if (currentZone) {
            url.searchParams.set('zone', currentZone);
        } else {
            url.searchParams.delete('zone');
        }
        if (currentStatus) {
            url.searchParams.set('status', currentStatus);
        } else {
            url.searchParams.delete('status');
        }
        window.history.pushState({}, '', url);
    }

    // Merge tables functionality
    const mergeBtn = document.getElementById('mergeBtn');
    const checkboxes = document.querySelectorAll('.table-checkbox');
    
    function updateMergeButton() {
        const selected = document.querySelectorAll('.table-checkbox:checked');
        if (selected.length >= 2) {
            mergeBtn.style.display = 'flex';
        } else {
            mergeBtn.style.display = 'none';
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateMergeButton);
    });
    
    mergeBtn.addEventListener('click', function() {
        const selected = Array.from(document.querySelectorAll('.table-checkbox:checked'))
            .map(cb => cb.dataset.tableId);
        
        if (selected.length < 2) {
            alert('Bạn cần chọn ít nhất 2 bàn để gộp.');
            return;
        }
        
        if (confirm(`Bạn có chắc muốn gộp ${selected.length} bàn này không?`)) {
            document.getElementById('selected-tables').value = selected.join(',');
            document.getElementById('merge-form').submit();
        }
    });
});
</script>
@endsection
