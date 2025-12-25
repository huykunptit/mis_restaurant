@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')

    @isset($pagename) {{ $pagename }} @endisset

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="w-100 bg-light" style="background-color: #f8f9fa;">
        
        {{-- Header Section --}}
        <div class="px-3 px-sm-4 px-lg-5 py-5">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-4 mb-4">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-2">Quản lý Menu</h1>
                    <p class="text-muted">Quản lý các món ăn và đồ uống trong menu của nhà hàng</p>
                </div>
                <a href="{{ route('menu.create') }}" class="btn btn-warning btn-lg d-inline-flex align-items-center justify-content-center gap-2 shadow-sm" style="width: fit-content;">
                    <i class="bi bi-plus-lg"></i>
                    <span>Thêm món mới</span>
                </a>
            </div>

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name ) }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Menu</li>
                </ol>
            </nav>
        </div>
        
        {{-- Search & Sort Controls --}}
        <div class="px-3 px-sm-4 px-lg-5 pb-5">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <div class="position-relative flex-grow-1">
                        <i class="bi bi-search position-absolute start-3 top-50 translate-middle-y text-muted"></i>
                        <input id="searchInput" type="text" placeholder="Tìm kiếm món, mô tả..." class="form-control ps-4" />
                    </div>
                    <select id="sortSelect" class="form-select" style="max-width: fit-content;">
                        <option value="new">Mới nhất</option>
                        <option value="popular">Phổ biến</option>
                        <option value="price_asc">Giá: Thấp → Cao</option>
                        <option value="price_desc">Giá: Cao → Thấp</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="w-100 px-3 px-sm-4 px-lg-5">

            {{-- Group by categories: landing page style per category --}}
            @if(isset($categories) && $categories->count())
                @foreach($categories as $category)
                    <section id="category-{{ $category->id }}" class="mb-5">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h2 class="h3 fw-bold text-dark">{{ $category->name }}</h2>
                                <p class="small text-muted mt-1">
                                    @if(isset($category->total_menu_count))
                                        {{ $category->total_menu_count }} món ăn
                                        @if($category->menu->count() < $category->total_menu_count)
                                            (hiển thị {{ $category->menu->count() }})
                                        @endif
                                    @else
                                        {{ $category->menu->count() }} món ăn
                                    @endif
                                </p>
                            </div>
                            @if(isset($category->total_menu_count) && $category->total_menu_count > $category->menu->count())
                            <div>
                                @php $morePer = ($perPage ?? 12) * 2; @endphp
                                <a href="{{ route('menu.index', array_merge(request()->query(), ['per_page' => $morePer])) }}#category-{{ $category->id }}" class="text-warning fw-semibold text-decoration-none small">Xem tất cả →</a>
                            </div>
                            @endif
                        </div>

                        <div class="row g-3">
                            @foreach($category->menu as $item)
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                    <div class="card h-100 shadow-sm border-light" style="transition: box-shadow 0.2s;">
                                        <div class="position-relative overflow-hidden" style="height: 12rem;">
                                            @if($item->thumbnail)
                                                <img class="card-img-top w-100 h-100 object-fit-cover" src="{{ asset('images/'.$item->thumbnail) }}" alt="{{ $item->name }}" style="object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                                    <i class="bi bi-image" style="font-size: 3rem; opacity: 0.3;"></i>
                                                </div>
                                            @endif

                                            <div class="position-absolute top-0 end-0 p-2">
                                                @if($item->disable == 'yes')
                                                    <span class="badge bg-danger">Vô hiệu</span>
                                                @else
                                                    <span class="badge bg-success">Đang bán</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-bold text-dark" style="font-size: 1rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $item->name }}</h5>
                                            
                                            {{-- Display all menu options with prices --}}
                                            @if($item->menuOption && $item->menuOption->count() > 0)
                                                <div class="mb-2">
                                                    @if($item->menuOption->count() == 1)
                                                        <p class="h5 fw-bold text-warning mb-0">{{ number_format($item->menuOption->first()->cost ?? 0,0) }}₫</p>
                                                    @else
                                                        <div class="small">
                                                            @foreach($item->menuOption as $option)
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span class="text-muted">{{ $option->name }}:</span>
                                                                    <span class="fw-semibold text-warning">{{ number_format($option->cost,0) }}₫</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <p class="text-muted small mb-2">Chưa có giá</p>
                                            @endif
                                            
                                            <p class="card-text text-muted small" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $item->description ?? 'Không có mô tả' }}</p>

                                            <div class="d-flex gap-2 mt-auto">
                                                <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-sm btn-primary flex-grow-1 d-inline-flex align-items-center justify-content-center gap-1">
                                                    <i class="bi bi-pencil"></i>
                                                    <span>Sửa</span>
                                                </a>

                                                <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xoá món này?')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xoá">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi bi-image" style="font-size: 5rem; opacity: 0.2;"></i>
                    <p class="fw-bold h5 text-dark mt-3">Chưa có món ăn nào</p>
                    <p class="text-muted mb-4">Thêm những món ăn đầu tiên cho menu của bạn</p>
                    <a href="{{ route('menu.create') }}" class="btn btn-warning">
                        Thêm món mới
                    </a>
                </div>
            @endif

        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/menu_index.js') }}" ></script>

@endsection