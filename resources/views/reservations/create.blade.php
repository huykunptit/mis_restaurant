@extends('layout.app')

@php $pagename = "Reservation" @endphp

@section('title')
    Tạo đặt bàn mới
@endsection

@section('content')

<div class="p-10">
    <p class="text-3xl font-bold">Tạo đặt bàn mới</p>

    <div class="mt-4">
        <form action="{{ route('reservations.store') }}" method="POST" id="reservation-form">
            @csrf

            <div class="grid grid-cols-2 gap-8">
                {{-- Number of Guests --}}
                <div class="col-span-2">
                    <label for="guests" class="block font-bold mb-2">Số lượng khách</label>
                    <input type="number" name="guests" id="guests" value="1" min="1" class="w-full p-2 border border-green-800 rounded" required>
                </div>

                {{-- Table Selection --}}
                <div class="col-span-2">
                    <label for="table_id" class="block font-bold mb-2">Chọn bàn</label>
                    <select name="table_id" id="table_id" class="w-full p-2 border border-green-800 rounded" required>
                        <option value="">-- Chọn bàn phù hợp --</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->id }}" data-seats="{{ $table->seats }}">
                                Bàn {{ $table->table_number }} (Ghế: {{ $table->seats }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Reservation Time --}}
                <div class="col-span-2">
                    <label for="reservation_time" class="block font-bold mb-2">Thời gian đặt bàn</label>
                    <input type="datetime-local" name="reservation_time" id="reservation_time" class="w-full p-2 border border-green-800 rounded" required>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">Xác nhận</button>
                <a href="{{ route('reservations.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">Hủy</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('guests').addEventListener('input', function() {
        const guestCount = parseInt(this.value);
        const tableOptions = document.querySelectorAll('#table_id option');

        tableOptions.forEach(option => {
            const seats = parseInt(option.getAttribute('data-seats'));
            if (seats >= guestCount || option.value === "") {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    });
</script>
@endsection
