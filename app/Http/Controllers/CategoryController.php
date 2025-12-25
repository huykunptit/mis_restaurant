<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Count all menus including disabled ones
        $categories = Category::withCount(['menu' => function($query) {
            // Count all menus regardless of disable status
        }])->orderBy('name')->get();
        
        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:200|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('category.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $this->validate($request, [
            'name' => 'required|string|max:200|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('category.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has menus
        if ($category->menu()->count() > 0) {
            return redirect()
                ->route('category.index')
                ->with('error', 'Không thể xóa danh mục này vì đang có món ăn thuộc danh mục này!');
        }

        $category->delete();

        return redirect()
            ->route('category.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }
}

