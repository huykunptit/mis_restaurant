@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')
    Thêm món mới
@endsection

@section('content')
<div class="container-fluid px-3 px-sm-4 px-lg-5 py-4 py-sm-5 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Thêm món mới</h1>
        
        {{-- Bread Crumb --}}
        <div class="flex items-center text-sm text-gray-600 mt-4">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-primary transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('menu.index') }}" class="font-medium hover:text-primary transition-colors">Menu</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Thêm mới</span>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-4xl mx-auto">
        <p class="text-gray-600 mb-6">Vui lòng điền thông tin vào form bên dưới để thêm món mới</p>
        
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors @error('category') border-red-500 @enderror" 
                        required
                    >
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tên món <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            maxlength="200"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('name') border-red-500 @enderror" 
                            placeholder="Nhập tên món..."
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Hình ảnh
                        </label>
                        <div class="relative">
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
                                class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-primary hover:bg-primary-light dark:hover:bg-primary/10 transition-colors"
                            >
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600" id="file-name">Chọn hình ảnh</p>
                                </div>
                            </label>
                            <div id="image-preview" class="mt-4 hidden">
                                <img id="preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Pre-order --}}
                <div>
                    <label for="pre_order" class="block text-sm font-semibold text-gray-700 mb-2">
                        Cần đặt trước <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="pre_order" 
                        name="pre_order" 
                        class="w-full md:w-1/2 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors @error('pre_order') border-red-500 @enderror" 
                        required
                    >
                        <option value="0" {{ old('pre_order') == '0' ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ old('pre_order') == '1' ? 'selected' : '' }}>Có</option>
                    </select>
                    @error('pre_order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Menu Options --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            Tùy chọn giá <span class="text-red-500">*</span>
                        </label>
                        <button 
                            type="button" 
                            id="add-option" 
                            class="bg-primary hover:hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors flex items-center space-x-1"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
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
                                {{-- First Option --}}
                                <tr class="option-row hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                                    <td class="px-4 py-3">
                                        <input 
                                            type="text" 
                                            name="optionName[0]" 
                                            value="{{ old('optionName.0') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors" 
                                            placeholder="Ví dụ: Size L, Size M..."
                                            required
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <input 
                                            type="number" 
                                            name="optionPrice[0]" 
                                            value="{{ old('optionPrice.0') }}"
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
                                            class="remove-option hidden bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition-colors text-sm"
                                        >
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center space-x-4 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="bg-primary hover:bg-primary/90 text-white font-semibold px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2"
                    >
                        <span class="material-symbols-outlined text-lg">check</span>
                        <span>Xác nhận tạo</span>
                    </button>
                    <a 
                        href="{{ route('menu.index') }}" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-8 py-3 rounded-lg transition-colors duration-200"
                    >
                        Hủy
                    </a>
                </div>
            </div>
        </form>
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

    let optionIndex = 1;
    
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
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-option');
            if (rows.length > 1) {
                removeBtn.classList.remove('hidden');
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
            fileName.textContent = 'Chọn hình ảnh';
        }
    }
</script>
@endsection
