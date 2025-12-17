@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')
    Chỉnh sửa món: {{ $menu->name }}
@endsection

@section('content')
<div class="p-6 lg:p-10 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Chỉnh sửa món: {{ $menu->name }}</h1>
        
        {{-- Bread Crumb --}}
        <div class="flex items-center text-sm text-gray-600 mt-4">
            <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-medium hover:text-green-600 transition-colors">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('menu.index') }}" class="font-medium hover:text-green-600 transition-colors">Menu</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Chỉnh sửa</span>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-4xl">
        <p class="text-gray-600 mb-6">Thay đổi thông tin trong form bên dưới để cập nhật món</p>
        
        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                {{-- Category --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($categories as $category)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input 
                                    type="radio" 
                                    name="category" 
                                    value="{{ $category->id }}" 
                                    class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500"
                                    {{ $menu->category_id == $category->id ? 'checked' : '' }}
                                    required
                                />
                                <span class="text-gray-700 capitalize">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
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
                            value="{{ old('name', $menu->name) }}" 
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
                            @if($menu->thumbnail)
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 mb-2">Hình ảnh hiện tại:</p>
                                    <img src="{{ asset('images/'.$menu->thumbnail) }}" alt="{{ $menu->name }}" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
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
                                class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors"
                            >
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600" id="file-name">Chọn hình ảnh mới (tùy chọn)</p>
                                </div>
                            </label>
                            <div id="image-preview" class="mt-4 hidden">
                                <p class="text-xs text-gray-500 mb-2">Hình ảnh mới:</p>
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
                        <option value="0" {{ old('pre_order', $menu->pre_order) == '0' ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ old('pre_order', $menu->pre_order) == '1' ? 'selected' : '' }}>Có</option>
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
                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors flex items-center space-x-1"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Thêm tùy chọn</span>
                        </button>
                    </div>
                    
                    <div id="options-container" class="space-y-4">
                        @foreach ($menuOptions as $index => $menuOption)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg option-row">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tên tùy chọn</label>
                                    <input 
                                        type="text" 
                                        name="optionName[{{ $index }}]" 
                                        value="{{ old('optionName.'.$index, $menuOption->name) }}"
                                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 transition-colors" 
                                        placeholder="Ví dụ: Size L, Size M..."
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Giá (VNĐ)</label>
                                    <input 
                                        type="number" 
                                        name="optionPrice[{{ $index }}]" 
                                        value="{{ old('optionPrice.'.$index, $menuOption->cost) }}"
                                        min="1" 
                                        step="1000"
                                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 transition-colors" 
                                        placeholder="0"
                                        required
                                    >
                                </div>
                                <div class="flex items-end">
                                    <button 
                                        type="button" 
                                        class="remove-option {{ $loop->first && count($menuOptions) == 1 ? 'hidden' : '' }} bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm"
                                    >
                                        Xóa
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center space-x-4 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Xác nhận cập nhật</span>
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

<script>
    let optionIndex = {{ count($menuOptions) }};
    
    document.getElementById('add-option').addEventListener('click', function() {
        const container = document.getElementById('options-container');
        const newOption = document.createElement('div');
        newOption.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg option-row';
        newOption.innerHTML = `
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tên tùy chọn</label>
                <input 
                    type="text" 
                    name="optionName[${optionIndex}]" 
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 transition-colors" 
                    placeholder="Ví dụ: Size L, Size M..."
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Giá (VNĐ)</label>
                <input 
                    type="number" 
                    name="optionPrice[${optionIndex}]" 
                    min="1" 
                    step="1000"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 transition-colors" 
                    placeholder="0"
                    required
                >
            </div>
            <div class="flex items-end">
                <button 
                    type="button" 
                    class="remove-option bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm"
                >
                    Xóa
                </button>
            </div>
        `;
        container.appendChild(newOption);
        optionIndex++;
        updateRemoveButtons();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.option-row').remove();
            updateRemoveButtons();
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
            fileName.textContent = 'Chọn hình ảnh mới (tùy chọn)';
        }
    }
</script>
@endsection
