@extends('layout.app')

@php $pagename = "Table" @endphp

@section('title')
    Chỉnh sửa bàn
@endsection

@section('content')
 
    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">Chỉnh sửa bàn</p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('tables.index') }}" class="font-bold hover:text-blue-800">Danh sách bàn</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>Chỉnh sửa bàn</p>
        </div>

        {{-- Form Description --}}
        <p class="text-gray-500 mb-10">Vui lòng điều chỉnh thông tin bàn</p>
        
        <form action="{{ route('tables.update', $table->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- All Grid --}}
            <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">

                {{-- Table Number --}}
                <div class="col-span-1">
                    <p class="font-bold">Số bàn</p>

                    <input type="text" name="table_number" value="{{ $table->table_number }}" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
        
                    @error('table_number')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Seats --}}
                <div class="col-span-1">
                    <p class="font-bold">Số chỗ ngồi</p>

                    <input type="number" name="seats" value="{{ $table->seats }}" min="1" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
        
                    @error('seats')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-span-2 grid grid-cols-2 gap-x-5">
                    <p class="col-span-2 font-bold">Trạng thái</p>
                    
                    <div class="col-span-1 mt-3">
                        <select name="status" id="status" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg capitalize" required>
                            <option value="available" {{ $table->status == 'available' ? 'selected' : '' }} class="capitalize">Trống</option>
                            <option value="reserved" {{ $table->status == 'reserved' ? 'selected' : '' }} class="capitalize">Đã đặt</option>
                            <option value="occupied" {{ $table->status == 'occupied' ? 'selected' : '' }} class="capitalize">Đang sử dụng</option>
                        </select>
                    </div>
        
                    @error('status')
                        {{ $message }}
                    @enderror
                </div>

                <button type="submit" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                    <p>Xác nhận cập nhật</p>
                </button>

                <a href="{{ route('tables.index') }}" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105">
                    Huỷ
                </a>

            </div>

        </form>

    </div>

@endsection