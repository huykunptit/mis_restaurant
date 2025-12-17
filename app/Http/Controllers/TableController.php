<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Hiển thị danh sách bàn.
     */
    public function index()
    {
        // $tables = Table::all();
        $tables = Table::paginate(10);
        return view('tables.index', compact('tables'));
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
            return redirect()->route('tables.list')->with('error', 'You need to select at least two tables to merge.');
        }
    
        // Prepare merged table data
        $mergedTable = [
            'table_number' => 'Merged ' . implode(', ', $selectedTables),
            'seats' => Table::whereIn('id', $selectedTables)->sum('seats'),
            'status' => 'available',
            'is_merged' => 0, // New merged table is active
            'merged_from' => implode(',', $selectedTables), // Track original tables
        ];
        
        // Mark old tables as merged (is_merged = 1)
        Table::whereIn('id', $selectedTables)->update(['is_merged' => 1]);
    
        // Create the new merged table
        Table::create($mergedTable);
    
        return redirect()->route('tables.list')->with('success', 'Tables merged successfully.');
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
