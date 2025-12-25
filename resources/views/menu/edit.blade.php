@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')
    Chỉnh sửa món: {{ $menu->name }}
@endsection

@section('content')
<div class="w-100 bg-light" style="background-color: #f8f9fa;">
    
    {{-- Header Section --}}
    <div class="px-3 px-sm-4 px-lg-5 py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Chỉnh sửa: {{ $menu->name }}</h1>
                <p class="text-muted">Cập nhật thông tin và giá cả cho món này</p>
            </div>
            <a href="{{ route('menu.index') }}" class="btn-close" aria-label="Close"></a>
        </div>
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.' . auth()->user()->role->name) }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menu.index') }}" class="text-decoration-none">Menu</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </nav>
    </div>

    {{-- Form Section --}}
    <div class="px-3 px-sm-4 px-lg-5 pb-5">
        <div class="card shadow-sm border-light mx-auto" style="max-width: 48rem;">
            <div class="card-body p-4 p-sm-5">
                
                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" data-disable-on-submit="true">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        {{-- Category Selection --}}
                        <label for="category" class="form-label fw-bold mb-2">
                            Danh mục <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="category" 
                            name="category" 
                            class="form-select @error('category') is-invalid @enderror" 
                            required
                        >
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Basic Info --}}
                    <div class="row g-3 mb-5">
                        {{-- Name --}}
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-bold">
                                Tên món <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $menu->name) }}" 
                                maxlength="200"
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Ví dụ: Phở bò, Gỏi cuốn..."
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pre-order --}}
                        <div class="col-12 col-md-6">
                            <label for="pre_order" class="form-label fw-bold">
                                Cần đặt trước <span class="text-danger">*</span>
                            </label>
                            <select 
                                id="pre_order" 
                                name="pre_order" 
                                class="form-select @error('pre_order') is-invalid @enderror" 
                                required
                            >
                                <option value="0" {{ old('pre_order', $menu->pre_order) == '0' ? 'selected' : '' }}>Không</option>
                                <option value="1" {{ old('pre_order', $menu->pre_order) == '1' ? 'selected' : '' }}>Có</option>
                            </select>
                            @error('pre_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description & Image --}}
                    <div class="row g-3 mb-5">
                        {{-- Description --}}
                        <div class="col-12 col-md-6">
                            <label for="description" class="form-label fw-bold">
                                Mô tả
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="5"
                                class="form-control" 
                                placeholder="Mô tả về món ăn..."
                            >{{ old('description', $menu->description) }}</textarea>
                        </div>

                        {{-- Image Upload --}}
                        <div class="col-12 col-md-6">
                            <label for="image" class="form-label fw-bold">
                                Hình ảnh
                            </label>
                            @if($menu->thumbnail)
                                <div class="mb-3">
                                    <p class="small fw-semibold text-muted mb-2">Hình ảnh hiện tại:</p>
                                    <img src="{{ asset('images/'.$menu->thumbnail) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 100%; height: auto;">
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                                onchange="previewImage(this)"
                                class="d-none"
                            >
                            <label 
                                for="image" 
                                class="d-flex flex-column align-items-center justify-content-center p-4 border-2 border-dashed rounded cursor-pointer" 
                                style="cursor: pointer; background-color: #f8f9fa; border-color: #dee2e6; transition: all 0.2s;"
                            >
                                <i class="bi bi-cloud-arrow-up text-muted" style="font-size: 2.5rem;"></i>
                                <p class="small fw-medium text-muted mt-2 mb-0" id="file-name">Chọn hoặc kéo hình ảnh mới</p>
                            </label>
                            <div id="image-preview" class="mt-3 d-none">
                                <p class="small fw-semibold text-muted mb-2">Hình ảnh mới:</p>
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                    {{-- Menu Options (Sizes/Prices) --}}
                    <div class="mb-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <label class="form-label fw-bold mb-0">
                                Tùy chọn giá <span class="text-danger">*</span>
                            </label>
                            <button 
                                type="button" 
                                id="add-option" 
                                class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1"
                            >
                                <i class="bi bi-plus-lg"></i>
                                <span>Thêm tùy chọn</span>
                            </button>
                        </div>
                        
                        {{-- Table for Options --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">STT</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Tên tùy chọn</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Giá (VNĐ)</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="options-container" class="bg-white divide-y divide-gray-200">
                                    @foreach ($menuOptions as $index => $menuOption)
                                    <tr class="option-row hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <input 
                                                type="text" 
                                                name="optionName[{{ $index }}]" 
                                                value="{{ old('optionName.'.$index, $menuOption->name) }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                                                placeholder="Ví dụ: Size L, Size M..."
                                                required
                                            >
                                        </td>
                                        <td class="px-4 py-3">
                                            <input 
                                                type="number" 
                                                name="optionPrice[{{ $index }}]" 
                                                value="{{ old('optionPrice.'.$index, $menuOption->cost) }}"
                                                min="1" 
                                                step="1"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                                                placeholder="0"
                                                required
                                            >
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button 
                                                type="button" 
                                                class="remove-option {{ $loop->first && count($menuOptions) == 1 ? 'hidden' : '' }} bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition-colors text-sm"
                                            >
                                                Xóa
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2 pt-4 border-top">
                        <button 
                            type="submit" 
                            data-loading-text="Đang xử lý..."
                            class="btn btn-warning fw-bold d-inline-flex align-items-center gap-2"
                        >
                            <i class="bi bi-check-lg"></i>
                            <span>Cập nhật</span>
                        </button>
                        <a 
                            href="{{ route('menu.index') }}" 
                            class="btn btn-secondary fw-semibold"
                        >
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Initialize Select2
    $(document).ready(function() {
        $('#category').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Chọn danh mục --',
            allowClear: false,
            width: '100%'
        });
    });

    let optionIndex = {{ count($menuOptions) }};
    
    document.getElementById('add-option').addEventListener('click', function() {
        const container = document.getElementById('options-container');
        const rowCount = container.querySelectorAll('tr').length + 1;
        const newRow = document.createElement('tr');
        newRow.className = 'option-row hover:bg-gray-50';
        newRow.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${rowCount}</td>
            <td class="px-4 py-3">
                <input 
                    type="text" 
                    name="optionName[${optionIndex}]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                    placeholder="Ví dụ: Size L, Size M..."
                    required
                >
            </td>
            <td class="px-4 py-3">
                <input 
                    type="number" 
                    name="optionPrice[${optionIndex}]" 
                    min="1" 
                    step="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                    placeholder="0"
                    required
                >
            </td>
            <td class="px-4 py-3 text-center">
                <button 
                    type="button" 
                    class="remove-option bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition-colors text-sm"
                >
                    Xóa
                </button>
            </td>
        `;
        container.appendChild(newRow);
        optionIndex++;
        updateRemoveButtons();
        updateRowNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.option-row').remove();
            updateRemoveButtons();
            updateRowNumbers();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.option-row');
        rows.forEach((row) => {
            const removeBtn = row.querySelector('.remove-option');
            if (rows.length > 1) {
                removeBtn.classList.remove('hidden', 'd-none');
            } else {
                removeBtn.classList.add('hidden');
            }
        });
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('.option-row');
        rows.forEach((row, index) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
        });
    }

    function previewImage(input) {
        const file = input.files[0];
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const fileName = document.getElementById('file-name');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
                fileName.textContent = file.name;
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
            fileName.textContent = 'Chọn hoặc kéo hình ảnh mới';
        }
    }

    // Initialize remove buttons state
    updateRemoveButtons();
</script>
@endsection
    
    {{-- Header Section --}}
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-2">Chỉnh sửa: {{ $menu->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Cập nhật thông tin và giá cả cho món này</p>
            </div>
            <a href="{{ route('menu.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
        
        {{-- Breadcrumb --}}
        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('menu.index') }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors">Menu</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Chỉnh sửa</span>
        </div>
    </div>

    {{-- Form Section --}}
    <div class="px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 max-w-3xl mx-auto">
            
            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" data-disable-on-submit="true">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    {{-- Category Selection --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-4">
                            Danh mục <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($categories as $category)
                                <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-orange-300 dark:hover:border-orange-600 transition-colors group {{ $menu->category_id == $category->id ? 'border-orange-500 dark:border-orange-500 bg-orange-50 dark:bg-orange-500/10' : '' }}">
                                    <input 
                                        type="radio" 
                                        name="category" 
                                        value="{{ $category->id }}" 
                                        class="w-4 h-4"
                                        {{ $menu->category_id == $category->id ? 'checked' : '' }}
                                        required
                                    />
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Basic Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                Tên món <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $menu->name) }}" 
                                maxlength="200"
                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400 @error('name') border-red-500 @enderror" 
                                placeholder="Ví dụ: Phở bò, Gỏi cuốn..."
                                required
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pre-order --}}
                        <div>
                            <label for="pre_order" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                Cần đặt trước <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="pre_order" 
                                name="pre_order" 
                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400 @error('pre_order') border-red-500 @enderror" 
                                required
                            >
                                <option value="0" {{ old('pre_order', $menu->pre_order) == '0' ? 'selected' : '' }}>Không</option>
                                <option value="1" {{ old('pre_order', $menu->pre_order) == '1' ? 'selected' : '' }}>Có</option>
                            </select>
                            @error('pre_order')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Description & Image --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                Mô tả
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="5"
                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400" 
                                placeholder="Mô tả về món ăn..."
                            >{{ old('description', $menu->description) }}</textarea>
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                Hình ảnh
                            </label>
                            @if($menu->thumbnail)
                                <div class="mb-4">
                                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Hình ảnh hiện tại:</p>
                                    <img src="{{ asset('images/'.$menu->thumbnail) }}" alt="{{ $menu->name }}" class="w-full h-40 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                                onchange="previewImage(this)"
                                class="hidden"
                            >
                            <label 
                                for="image" 
                                class="flex flex-col items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-orange-400 dark:hover:border-orange-500 hover:bg-orange-50 dark:hover:bg-orange-500/10 transition-colors group"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-500 group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300" id="file-name">Chọn hoặc kéo hình ảnh mới</p>
                            </label>
                            <div id="image-preview" class="mt-4 hidden">
                                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Hình ảnh mới:</p>
                                <img id="preview-img" src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            </div>
                        </div>
                    </div>

                    {{-- Menu Options (Sizes/Prices) --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-bold text-gray-900 dark:text-white">
                                Tùy chọn giá <span class="text-red-500">*</span>
                            </label>
                            <button 
                                type="button" 
                                id="add-option" 
                                class="bg-orange-500 hover:bg-orange-600 active:bg-orange-700 dark:bg-orange-600 dark:hover:bg-orange-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Thêm tùy chọn</span>
                            </button>
                        </div>
                        
                        <div id="options-container" class="space-y-3">
                            @foreach ($menuOptions as $index => $menuOption)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg option-row border border-gray-200 dark:border-gray-600">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Tên tùy chọn</label>
                                        <input 
                                            type="text" 
                                            name="optionName[{{ $index }}]" 
                                            value="{{ old('optionName.'.$index, $menuOption->name) }}"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400" 
                                            placeholder="Ví dụ: Size L, Size M..."
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Giá (₫)</label>
                                        <input 
                                            type="number" 
                                            name="optionPrice[{{ $index }}]" 
                                            value="{{ old('optionPrice.'.$index, $menuOption->cost) }}"
                                            min="1" 
                                            step="1"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400" 
                                            placeholder="0"
                                            required
                                        >
                                    </div>
                                    <div class="flex items-end">
                                        <button 
                                            type="button" 
                                            class="remove-option {{ $loop->first && count($menuOptions) == 1 ? 'hidden' : '' }} w-full bg-red-600 hover:bg-red-700 active:bg-red-800 dark:bg-red-700 dark:hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium"
                                        >
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button 
                            type="submit" 
                            data-loading-text="Đang xử lý..."
                            class="bg-orange-500 hover:bg-orange-600 active:bg-orange-700 dark:bg-orange-600 dark:hover:bg-orange-700 text-white font-bold px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 min-w-max"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Cập nhật</span>
                        </button>
                        <a 
                            href="{{ route('menu.index') }}" 
                            class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold px-8 py-3 rounded-lg transition-colors duration-200"
                        >
                            Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let optionIndex = {{ count($menuOptions) }};
    
    document.getElementById('add-option').addEventListener('click', function() {
        const container = document.getElementById('options-container');
        const rowCount = container.querySelectorAll('tr').length + 1;
        const newRow = document.createElement('tr');
        newRow.className = 'option-row hover:bg-gray-50';
        newRow.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${rowCount}</td>
            <td class="px-4 py-3">
                <input 
                    type="text" 
                    name="optionName[${optionIndex}]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                    placeholder="Ví dụ: Size L, Size M..."
                    required
                >
            </td>
            <td class="px-4 py-3">
                <input 
                    type="number" 
                    name="optionPrice[${optionIndex}]" 
                    min="1" 
                    step="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                    placeholder="0"
                    required
                >
            </td>
            <td class="px-4 py-3 text-center">
                <button 
                    type="button" 
                    class="remove-option bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition-colors text-sm"
                >
                    Xóa
                </button>
            </td>
        `;
        container.appendChild(newRow);
        optionIndex++;
        updateRemoveButtons();
        updateRowNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.option-row').remove();
            updateRemoveButtons();
            updateRowNumbers();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.option-row');
        rows.forEach((row) => {
            const removeBtn = row.querySelector('.remove-option');
            if (rows.length > 1) {
                removeBtn.classList.remove('hidden', 'd-none');
            } else {
                removeBtn.classList.add('hidden');
            }
        });
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('.option-row');
        rows.forEach((row, index) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
        });
    }

    function previewImage(input) {
        const file = input.files[0];
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const fileName = document.getElementById('file-name');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
                fileName.textContent = file.name;
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            fileName.textContent = 'Chọn hoặc kéo hình ảnh mới';
        }
    }

    // Initialize remove buttons state
    updateRemoveButtons();
</script>
@endsection
