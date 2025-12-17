@extends('layout.app')

@php $pagename = "Dine In" @endphp

@section('title')
    Dine In
@endsection

@section('content')
    <div class="p-10">
        <p class="text-3xl font-bold">Dine In</p>

        <div class="flex justify-between items-center mt-4">
            <form action="{{ route('tables.list') }}" method="GET" class="flex space-x-4">
                <div>
                    <label for="table_number" class="font-bold">Table Number</label>
                    <input type="text" name="table_number" id="table_number" value="{{ request('table_number') }}" class="w-full mt-1 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg">
                </div>
                <div>
                    <label for="status" class="font-bold">Status</label>
                    <select name="status" id="status" class="w-full mt-1 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg capitalize">
                        <option value="">All</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }} class="capitalize">Available</option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }} class="capitalize">Reserved</option>
                        <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }} class="capitalize">Occupied</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-md font-bold">
                    Search
                </button>
            </form>
            <a href="{{ route('tables.create') }}" class="bg-green-600 hover:bg-green-500 text-white px-3 py-2 rounded-md font-bold">
                Add New Table
            </a>
        </div>

        <div class="grid grid-cols-5 gap-4 mt-10">
            @foreach ($tables as $table)
            <div class="bg-green-200 p-4 rounded-md shadow-md">
                <p class="font-bold text-lg">{{ $table->table_number }}</p>
                <p class="text-sm">{{ $table->seats }} Seats</p>
                <p class="text-sm capitalize">{{ $table->status }}</p>
                <div class="flex justify-end space-x-2 mt-2">
                    <a href="{{ route('tables.edit', $table->id) }}" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md text-sm">
                        Edit
                    </a>
                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this table?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection