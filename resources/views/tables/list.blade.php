@extends('layout.app')

@php $pagename = "Dine In" @endphp

@section('title')
    Dine In
@endsection


@section('content')
    <div class="p-10">
        <p class="text-3xl font-bold">Dine In</p>

        <div class="flex justify-between items-center mt-4">
            <div class="flex space-x-4">
                <button type="button" onclick="mergeTables()" class="bg-green-600 hover:bg-green-500 text-white px-3 py-2 rounded-md font-bold">
                    Merge Tables
                </button>
                <a href="{{ route('tables.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-md font-bold">
                    Add New Table
                </a>
            </div>
        </div>

        <form id="merge-form" action="{{ route('tables.merge') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="selected_tables" id="selected-tables" value="">
        </form>

        <div class="grid grid-cols-5 gap-4 mt-10">
    @foreach ($tables as $table)
    @if($table->is_merged != 1)
    <div class="bg-green-200 p-4 rounded-md shadow-md">
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">{{ $table->table_number }}</p>
            <input type="checkbox" class="table-checkbox" data-id="{{ $table->id }}">
        </div>
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
            @if($table->merged_from)
            <form action="{{ route('tables.revert', $table->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to revert this table?');">
                @csrf
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm">
                    Revert
                </button>
            </form>
            @endif
            @if($table->status == 'occupied')
            <a href="{{ route('order.show', ['id' => $table->id]) }}" class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm">
                Show Order
            </a>
            @endif
        </div>
    </div>
    @endif
    @endforeach
</div>
    </div>

    <!-- Inline Script -->
    <script>
        function mergeTables() {
            let selectedTables = [];
            document.querySelectorAll('.table-checkbox:checked').forEach(function(checkbox) {
                selectedTables.push(checkbox.dataset.id);
            });

            if (selectedTables.length < 2) {
                alert('You need to select at least two tables to merge.');
                return;
            }

            document.getElementById('selected-tables').value = selectedTables.join(',');
            document.getElementById('merge-form').submit();
        }
    </script>
@endsection