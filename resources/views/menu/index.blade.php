@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')

    @isset($pagename) {{ $pagename }} @endisset

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="p-6 lg:p-10 bg-gray-50 min-h-screen">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Quản lý Menu</h1>
                    <p class="text-gray-600">Quản lý các món ăn và đồ uống trong menu</p>
                </div>
                <a href="{{ route('menu.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Thêm món mới</span>
                </a>
            </div>

            {{-- Bread Crumb --}}
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-medium hover:text-green-600 transition-colors">Trang chủ</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Menu</span>
            </div>
        </div>
        
        {{-- Filter Buttons --}}
        <div class="mb-8 flex flex-wrap gap-3">
            <button id="foodsButton" class="flex items-center justify-center space-x-2 bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                </svg>
                <span>Đồ ăn</span>
            </button>

            <button id="drinksButton" class="flex items-center justify-center space-x-2 bg-white text-green-600 border-2 border-green-600 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-green-50 transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <span>Đồ uống</span>
            </button>
        </div>
        
        <div class="w-full my-10">
            
            {{-- Foods Content --}}
            <div id="foodsContent">

                @isset($foods)
                
                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            
                        @foreach ($foods as $food)
                            
                            {{-- One Menu Item Card --}}
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">

                                {{-- Menu Item Image --}}
                                <div class="relative w-full aspect-square overflow-hidden bg-gray-200">
                                    @if ($food->thumbnail == null)
                                        <img class="w-full h-full object-cover" src="{{ asset('img/noimg.png') }}" alt="{{ $food->name }}">
                                    @else
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="{{ asset('images/'.$food->thumbnail) }}" alt="{{ $food->name }}">
                                    @endif
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-3 right-3">
                                        @if ($food->disable == "yes")
                                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">Đã vô hiệu</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">Đang bán</span>
                                        @endif
                                    </div>
                                    
                                    @if ($food->pre_order)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full shadow-lg">Đặt trước</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Menu Item Info --}}
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $food->name }}</h3>
                                    <p class="text-2xl font-bold text-green-600 mb-4">{{ number_format($food->menuOption->first()->cost ?? 0, 0) }} VNĐ</p>
                    
                                    {{-- Action Buttons --}}
                                    <div class="flex gap-2">

                                        {{-- Edit Button --}}
                                        <a href="{{ route('menu.edit', $food->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Sửa</span>
                                        </a>

                                        @if ($food->disable == 'no')
                                            <form action="{{ route('menu.disable', $food->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                    <span>Vô hiệu</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('menu.enable', $food->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Kích hoạt</span>
                                                </button>
                                            </form>
                                        @endif

                                        <button onclick="delete{{ $food->id }}()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                    
                                    {{-- Modal --}}
                                    <div id="modal{{ $food->id }}" class="hidden fixed z-10 inset-0 w-full h-full overflow-auto pt-20" style="background: rgba(0,0,0,0.5);">
                                            
                                        <div id="modalBox{{ $food->id }}" class="bg-white w-3/4 lg:w-1/3 mx-auto p-10 rounded-lg text-center animate__animated animate__bounceInDown shadow-2xl">

                                            {{-- Title --}}
                                            <p class="text-3xl font-bold">Xác nhận Deletion</p>

                                            {{-- Text --}}
                                            <p class="my-10">Are you sure you want to delete this menu item?</p>

                                            {{-- Button --}}
                                            <div class="flex flex-row items-center justify-center gap-5">

                                                <form action="{{ route('menu.destroy', $food->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
        
                                                    {{-- Disable --}}
                                                    <button type="submit" class="bg-green-800 text-white px-10 py-3 rounded-md">Yes</button>

                                                </form>

                                                <div href="" onclick="cancel{{ $food->id }}()" class="bg-red-800 text-white px-10 py-3 rounded-md cursor-pointer">Huỷ</div>
                                            </div>
                                        </div>  

                                    </div>
                                    
                                    {{-- Modal Script (NOTE: Don't Move) --}}
                                    <script>

                                        // Xoá Button
                                        function delete{{ $food->id }}(){

                                            const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                            const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');

                                            if (modal{{ $food->id }}.classList.contains('hidden')){
                                                
                                                modal{{ $food->id }}.classList.remove('hidden');

                                            }

                                            if (modalBox{{ $food->id }}.classList.contains('animate__bounceOutUp')){
                                                
                                                modalBox{{ $food->id }}.classList.remove('animate__bounceOutUp');
                                                modalBox{{ $food->id }}.classList.add('animate__bounceInDown');

                                            }
                                        }

                                        // Cancel Button
                                        function cancel{{ $food->id }}(){

                                            const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                            const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');

                                            if (modalBox{{ $food->id }}.classList.contains('animate__bounceInDown')){
                                                
                                                modalBox{{ $food->id }}.classList.remove('animate__bounceInDown');
                                                modalBox{{ $food->id }}.classList.add('animate__bounceOutUp');

                                            }
                                            
                                            setTimeout(function () {
                                                modal{{ $food->id }}.classList.add('hidden');
                                            }, 800);

                                        }

                                        const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                        const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');
                                        
                                        window.addEventListener("click", function(event) {

                                            if (event.target == modal{{ $food->id }}) {

                                                if (modalBox{{ $food->id }}.classList.contains('animate__bounceInDown')){
                                                
                                                    modalBox{{ $food->id }}.classList.remove('animate__bounceInDown');
                                                    modalBox{{ $food->id }}.classList.add('animate__bounceOutUp');

                                                }
                                                
                                                setTimeout(function () {
                                                    modal{{ $food->id }}.classList.add('hidden');
                                                }, 800);

                                            }
                                        });

                                    </script>

                                </div>
                    
                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="sm:w-1/2 mx-auto -mt-14">
                        <img src="{{ asset('img/no_food.svg') }}" class="sm:w-2/3 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">Chưa có món ăn nào</p>
                        <p class="font-extrabold text-sm text-center mt-2">Nếu bạn là Admin hoặc Nhân viên bếp, vui lòng thêm món ăn mới.</p>
                    </div>

                @endisset

            </div>

            <div id="drinksContent" class="hidden">

                @isset($drinks)
                    
                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                        @foreach ($drinks as $drink)

                            {{-- One Menu Item Card --}}
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">

                                {{-- Menu Item Image --}}
                                <div class="relative w-full aspect-square overflow-hidden bg-gray-200">
                                    @if ($drink->thumbnail == null)
                                        <img class="w-full h-full object-cover" src="{{ asset('img/noimg.png') }}" alt="{{ $drink->name }}">
                                    @else
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="{{ asset('images/'.$drink->thumbnail) }}" alt="{{ $drink->name }}">
                                    @endif
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-3 right-3">
                                        @if ($drink->disable == "yes")
                                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">Đã vô hiệu</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">Đang bán</span>
                                        @endif
                                    </div>
                                    
                                    @if ($drink->pre_order)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full shadow-lg">Đặt trước</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Menu Item Info --}}
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $drink->name }}</h3>
                                    <p class="text-2xl font-bold text-green-600 mb-4">{{ number_format($drink->menuOption->first()->cost ?? 0, 0) }} VNĐ</p>
                    
                                    {{-- Action Buttons --}}
                                    <div class="flex gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('menu.edit', $drink->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Sửa</span>
                                        </a>

                                        @if ($drink->disable == 'no')
                                            <form action="{{ route('menu.disable', $drink->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                    <span>Vô hiệu</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('menu.enable', $drink->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Kích hoạt</span>
                                                </button>
                                            </form>
                                        @endif

                                        <button onclick="delete{{ $drink->id }}()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                    
                            </div>
                        
                        @endforeach

                    </div>

                @else

                    <div class="sm:w-1/2 mx-auto -mt-24">
                        <img src="{{ asset('img/no_drink.svg') }}" class="sm:w-2/3 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">Chưa có đồ uống nào</p>
                        <p class="font-extrabold text-sm text-center mt-2">Nếu bạn là Admin hoặc Nhân viên bếp, vui lòng thêm đồ uống mới.</p>
                    </div>

                @endisset

            </div>
            
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/menu_index.js') }}" ></script>

@endsection