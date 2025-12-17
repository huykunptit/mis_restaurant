@extends('layout.app')

@php $pagename = "Reservation" @endphp

@section('title')
    Quản lý đặt bàn trước
@endsection

@section('content')
<div class="p-10">

    {{-- Page Name --}}
    <p class="text-3xl font-bold mb-6">Quản lý đặt bàn trước</p>

    {{-- Bread Crumb --}}
    <div class="flex items-center text-sm mb-8">
        <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <p>Quản lý đặt bàn trước</p>
    </div>

    {{-- Add New Reservation --}}
    <a href="{{ route('reservations.create') }}" class="inline-block mb-4">
        <button class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
            Thêm mới đặt bàn
        </button>
    </a>

    {{-- Reservation List --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">STT</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Tên người đặt</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Bàn số</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Số ghế</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Thời gian đặt</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Trạng thái</th>
                    <th class="px-6 py-3 text-center text-sm font-medium">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @foreach ($reservations as $key => $reservation)
                <tr>
                    <td class="px-6 py-4">{{ $key + 1 }}</td>
                    <td class="px-6 py-4">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</td>
                    <td class="px-6 py-4">Bàn {{ $reservation->table->table_number }}</td>
                    <td class="px-6 py-4">{{ $reservation->table->seats }}</td>
                    <td class="px-6 py-4">{{ $reservation->reservation_time }}</td>
                    <td class="px-6 py-4 capitalize">{{ $reservation->status }}</td>

                    {{-- Conditional Actions --}}
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            {{-- Accept or Reject Buttons --}}
                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="accept" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">
                                    Chấp nhận
                                </button>
                                <button type="submit" name="action" value="reject" class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-md">
                                    Từ chối
                                </button>
                            </form>
                        @elseif (auth()->user()->role_id == 3)
                            {{-- Edit and Delete Buttons --}}
                            <a href="{{ route('reservations.edit', $reservation->id) }}" 
                               class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">
                                Chỉnh sửa
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đặt bàn này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md">
                                    Xoá
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $reservations->links() }}
    </div>
</div>
@endsection
