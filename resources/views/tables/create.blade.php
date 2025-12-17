@extends('layout.app')

@php $pagename = "Reservation" @endphp

@section('title')
    Tạo đặt bàn mới
@endsection

@section('content')

    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">Tạo đặt bàn mới</p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('reservations.index') }}" class="font-bold hover:text-blue-800">Danh sách đặt bàn</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>Tạo đặt bàn mới</p>
        </div>

        {{-- Form Description --}}
        <p class="text-gray-500 mb-10">Vui lòng điền thông tin vào form</p>

        <form action="{{ route('reservations.store') }}" method="POST">

            @csrf

            {{-- All Grid --}}
            <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">

                {{-- Table Selection --}}
                <div class="col-span-2">
                    <p class="font-bold">Chọn bàn</p>
                    <select name="table_id" id="table_id" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg capitalize" required>
                        <option disabled selected value class="bg-gray-200">-- Chọn bàn --</option>
                        @foreach ($tables ?? '' as $table)
                            <option value="{{ $table->id }}">Bàn {{ $table->table_number }} (Ghế: {{ $table->seats }})</option>
                        @endforeach
                    </select>

                    @error('table_id')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Reservation Time --}}
                <div class="col-span-2">
                    <p class="font-bold">Thời gian đặt bàn</p>
                    <input type="datetime-local" name="reservation_time" value="{{ old('reservation_time') }}" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>

                    @error('reservation_time')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit and Cancel Buttons --}}
                <button type="submit" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                    Xác nhận đặt bàn
                </button>

                <a href="{{ route('reservations.index') }}" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105">
                    Huỷ
                </a>
            </div>

        </form>

    </div>

@endsection
