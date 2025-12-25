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
        <button class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary transition duration-300">
            Thêm mới đặt bàn
        </button>
    </a>

    {{-- Filters --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div>
            <label for="table_number" class="block text-sm font-semibold text-gray-700 mb-1">Tìm theo số bàn</label>
            <input id="table_number" name="table_number" value="{{ request('table_number') }}" placeholder="VD: B2" class="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-green-700 focus:outline-none">
        </div>
        <div>
            <label for="customer" class="block text-sm font-semibold text-gray-700 mb-1">Tên khách hàng</label>
            <input id="customer" name="customer" value="{{ request('customer') }}" placeholder="Tên hoặc họ" class="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-green-700 focus:outline-none">
        </div>
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Trạng thái</label>
            <select id="status" name="status" class="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-green-700 focus:outline-none">
                <option value="">Tất cả</option>
                <option value="Chờ xác nhận" @selected(request('status') === 'Chờ xác nhận')>Chờ xác nhận</option>
                <option value="Xác nhận" @selected(request('status') === 'Xác nhận')>Đã xác nhận</option>
                <option value="Huỷ" @selected(request('status') === 'Huỷ')>Đã huỷ</option>
            </select>
        </div>
        <div>
            <label for="sort" class="block text-sm font-semibold text-gray-700 mb-1">Sắp xếp</label>
            <select id="sort" name="sort" class="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-green-700 focus:outline-none">
                <option value="">Mới nhất</option>
                <option value="time_asc" @selected(request('sort') === 'time_asc')>Thời gian sớm nhất</option>
                <option value="time_desc" @selected(request('sort') === 'time_desc')>Thời gian muộn nhất</option>
            </select>
        </div>
        <div class="md:col-span-4 flex items-end space-x-3">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary transition duration-300">Lọc</button>
            <a href="{{ route('reservations.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 text-center">Xoá lọc</a>
        </div>
    </form>

    {{-- Reservation List --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-primary text-white">
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
                @forelse ($reservations as $key => $reservation)
                <tr>
                    <td class="px-6 py-4">{{ $key + 1 }}</td>
                    <td class="px-6 py-4">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</td>
                    <td class="px-6 py-4">Bàn {{ $reservation->table->table_number }}</td>
                    <td class="px-6 py-4">{{ $reservation->table->seats }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 capitalize">{{ $reservation->status }}</td>

                    {{-- Conditional Actions --}}
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            {{-- Accept or Reject Buttons --}}
                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" data-disable-on-submit="true">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="accept" data-loading-text="Đang cập nhật..." class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">
                                    Chấp nhận
                                </button>
                                <button type="submit" name="action" value="reject" data-loading-text="Đang cập nhật..." class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-md">
                                    Từ chối
                                </button>
                            </form>
                        @elseif (auth()->user()->role_id == 3)
                            {{-- Edit and Delete Buttons --}}
                            <a href="{{ route('reservations.edit', $reservation->id) }}" 
                               class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">
                                Chỉnh sửa
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" data-disable-on-submit="true" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đặt bàn này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-loading-text="Đang xoá..." class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md">
                                    Xoá
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                        Không có đặt bàn phù hợp với bộ lọc hiện tại.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $reservations->withQueryString()->links() }}
    </div>
</div>
@endsection
