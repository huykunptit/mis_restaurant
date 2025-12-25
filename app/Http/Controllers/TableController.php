<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Hiển thị danh sách bàn.
     */
    public function index(Request $request)
    {
        $query = Table::query();

        // Filter by zone
        if ($request->filled('zone')) {
            $query->where('zone', $request->input('zone'));
        }

        if ($request->filled('table_number')) {
            $query->where('table_number', 'like', '%' . $request->input('table_number') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Exclude merged tables by default
        if (!$request->has('include_merged')) {
            $query->where('is_merged', 0);
        }

        $sort = $request->input('sort');
        if ($sort === 'seats_asc') {
            $query->orderBy('seats', 'asc');
        } elseif ($sort === 'seats_desc') {
            $query->orderBy('seats', 'desc');
        } elseif ($sort === 'table_number') {
            $query->orderBy('table_number');
        } else {
            $query->orderBy('zone')->orderBy('table_number');
        }

        $tables = $query->paginate(20)->appends($request->query());

        // Get zones for tabs
        $zones = Table::select('zone')->distinct()->whereNotNull('zone')->pluck('zone');

        return view('tables.index', compact('tables', 'zones'));
    }
    public function list(Request $request)
    {
        $query = Table::query();
    
        // Search by table number
        if ($request->has('table_number') && $request->input('table_number') != '') {
            $query->where('table_number', 'like', '%' . $request->input('table_number') . '%');
        }
    
        // Search by status
        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }
    
        $tables = $query->get();
    
        return view('tables.list', compact('tables'));
    }
    /**
     * Hiển thị form thêm bàn.
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Lưu bàn mới vào database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number',
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,occupied',
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->with('success', 'Table added successfully.');
    }

    /**
     * Hiển thị form sửa bàn.
     */
    public function edit($id)
    {
        $table = Table::findOrFail($id);
        return view('tables.edit', compact('table'));
    }

    /**
     * Cập nhật thông tin bàn.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number,' . $id,
            'seats' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,occupied',
        ]);

        $table = Table::findOrFail($id);
        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', 'Table updated successfully.');
    }

    /**
     * Xóa bàn.
     */
    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted successfully.');
    }
    
    public function show(Table $table)
    {
        return view('tables.show', compact('table'));
    }

    public function merge(Request $request)
    {
        // Convert selected_tables into an array
        $selectedTables = explode(',', $request->input('selected_tables', ''));
    
        if (count($selectedTables) < 2) {
            return redirect()->route('tables.index')->with('error', 'Bạn cần chọn ít nhất 2 bàn để gộp.');
        }
    
        // Check if any table is already merged
        $alreadyMerged = Table::whereIn('id', $selectedTables)->where('is_merged', 1)->exists();
        if ($alreadyMerged) {
            return redirect()->route('tables.index')->with('error', 'Một trong các bàn đã được gộp rồi.');
        }

        // Get table numbers for display
        $tableNumbers = Table::whereIn('id', $selectedTables)->pluck('table_number')->toArray();
        $zone = Table::whereIn('id', $selectedTables)->value('zone');
    
        // Prepare merged table data
        $mergedTable = [
            'table_number' => 'Gộp ' . implode(', ', $tableNumbers),
            'zone' => $zone,
            'seats' => Table::whereIn('id', $selectedTables)->sum('seats'),
            'status' => 'available',
            'is_merged' => 0, // New merged table is active
            'merged_from' => implode(',', $selectedTables), // Track original tables
        ];
        
        // Mark old tables as merged (is_merged = 1)
        Table::whereIn('id', $selectedTables)->update(['is_merged' => 1]);
    
        // Create the new merged table
        Table::create($mergedTable);
    
        return redirect()->route('tables.index')->with('success', 'Đã gộp bàn thành công.');
    }
    

    public function revertMerge($id)
{
    // Find the merged table
    $mergedTable = Table::findOrFail($id);

    // Ensure it's a merged table
    if (!$mergedTable->merged_from) {
        return redirect()->route('tables.list')->with('error', 'This table is not a merged table.');
    }

    // Restore original tables
    $originalTableIds = explode(',', $mergedTable->merged_from);
    Table::whereIn('id', $originalTableIds)->update(['is_merged' => 0]);

    // Delete the merged table
    $mergedTable->delete();

    return redirect()->route('tables.list')->with('success', 'Merged table reverted successfully.');
}

    
}
