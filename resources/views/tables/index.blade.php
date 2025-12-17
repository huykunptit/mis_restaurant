@extends('layout.app')

@php $pagename = "Table" @endphp

@section('title')
    Quản lý bàn
@endsection

@section('content')
<div class="p-10">

    {{-- Page Name --}}
    <p class="text-3xl font-bold mb-6">Quản lý bàn</p>

    {{-- Bread Crumb --}}
    <div class="flex items-center text-sm mb-8">
        <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <p>Quản lý bàn</p>
    </div>

    {{-- Thêm mới Button --}}
    <a href="{{ route('tables.create') }}" class="inline-block mb-4">
        <button class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
            Thêm mới bàn
        </button>
    </a>
    <a href="{{ route('tables.list') }}" class="inline-block mb-4">
        <button class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
            Thêm mới bàn
        </button>
    </a>
    {{-- Table List --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">STT</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Bàn số</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Số ghế</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Trạng thái</th>
                    <th class="px-6 py-3 text-center text-sm font-medium">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @foreach ($tables as $key=>$table)
                <tr>
                    <td class="px-6 py-4">{{$key + 1 }}</td>
                    <td class="px-6 py-4">{{ $table->table_number }}</td>
                    <td class="px-6 py-4">{{ $table->seats }}</td>
                    <td class="px-6 py-4 capitalize">{{ ucfirst($table->status) }}</td>
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        <a href="{{ route('tables.edit', $table->id) }}" 
                           class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">
                            Chỉnh sửa
                        </a>
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bàn này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md">
                                Xoá
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $tables->links() }}
    </div>
</div>
@endsection
