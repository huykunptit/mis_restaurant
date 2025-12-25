<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $sort = $request->get('sort', 'new');
        $perPage = intval($request->get('per_page', 12));

        // Load categories and menus (limited per category). We'll apply simple server-side filtering.
        $categories = Category::with(['menu' => function($q) use ($search, $sort, $perPage) {
            $q->with('menuOption');

            if ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // If sorting by price we'll sort in-memory after loading because price is in related table
            if (!in_array($sort, ['price_asc', 'price_desc'])) {
                $q->orderBy('name');
            }

            $q->take($perPage);
        }])->get();

        // Filter out categories that have no menus after filtering
        $categories = $categories->filter(function($category) {
            return $category->menu->count() > 0;
        });

        // If price sort requested, sort menus collection by first option cost
        if (in_array($sort, ['price_asc', 'price_desc'])) {
            $categories->transform(function($cat) use ($sort) {
                $cat->menu = $cat->menu->sortBy(function($m) {
                    return optional($m->menuOption->first())->cost ?? 0;
                }, SORT_REGULAR, $sort === 'price_desc');
                return $cat;
            });
        }

        // Load total count for each category (for display) - count all menus matching search if any
        $categories->transform(function($category) use ($search) {
            $totalQuery = $category->menu();
            if ($search) {
                $totalQuery->where(function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }
            $category->total_menu_count = $totalQuery->count();
            return $category;
        });

        return view('menu.index', [
            'categories' => $categories,
            'search' => $search,
            'sort' => $sort,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {   
        $categories = Category::all();
        return view('menu.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {   

        // For 'Menu' table
        $this->validate($request, [
            'category' => 'required',
            'name' => 'required|max:200',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pre_order' => 'required|boolean',
        ]);

        // For 'MenuOption' table
        // For the first 'Add More' fields
        $request->validate([
            'optionName.0' => 'required',
            'optionPrice.0' => 'required',
        ]);

        // For the second and following 'Add More' fields
        $request->validate([
            'optionName.*' => 'required',
            'optionPrice.*' => 'required',
        ]);

        if($request->image != null){

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $menu = Menu::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'disable' => "no",
                'thumbnail' => $imageName,
                'pre_order' => $request->pre_order,
            ]);

        } else{

            $menu = Menu::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'disable' => "no",
                'pre_order' => $request->pre_order,
            ]);
        }

        $optionName = $request->optionName;
        $optionPrice = $request->optionPrice;

        for($count = 0; $count < count($optionName); $count++){

            $data = array(
                'menu_id' => $menu->id,
                'name' => $optionName[$count],
                'cost' => $optionPrice[$count],
            );

            $insert_data[] = $data; 
            
            MenuOption::insert($data);
        }

        // Clear cache after creating new menu
        Cache::forget('menu_foods');
        Cache::forget('menu_drinks');

        return redirect()
            ->route('menu.index')
            ->with('success', 'New menu item successfully added!');
    }

    public function edit($id)
    {   
        $menu = Menu::findOrFail($id);
        $menuOptions = MenuOption::where('menu_id', $id)->get();
        $categories = Category::all();
        
        return view('menu.edit', [
            'menu' => $menu,
            'menuOptions' => $menuOptions,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {      

        // For 'Menu' table
        $this->validate($request, [
            'category' => 'required',
            'name' => 'required|max:200',
            'pre_order' => 'required|boolean',
        ]);

        // For 'MenuOption' table
        // For the first 'Add More' fields
        $request->validate([
            'optionName.0' => 'required',
            'optionPrice.0' => 'required',
        ]);

        // For the second and following 'Add More' fields
        $request->validate([
            'optionName.*' => 'required',
            'optionPrice.*' => 'required',
        ]);

        $menu = Menu::findOrFail($id);
        
        $menu->category_id = $request->category;
        $menu->name = $request->name;
        $menu->pre_order = $request->pre_order;

        if($request->hasFile('image')){

            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Delete old image if exists
            if($menu->thumbnail && file_exists(public_path('images/' . $menu->thumbnail))){
                File::delete(public_path('images/' . $menu->thumbnail));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $menu->thumbnail = $imageName;
        }

        $menu->save();


        
        $menuOption = MenuOption::where('menu_id', $id);
        $menuOption->delete();

        $optionName = $request->optionName;
        $optionPrice = $request->optionPrice;

        for($count = 0; $count < count($optionName); $count++){

            $data = array(
                'menu_id' => $menu->id,
                'name' => $optionName[$count],
                'cost' => $optionPrice[$count],
            );

            $insert_data[] = $data; 
            
            MenuOption::insert($data);
        }

        // Clear cache after updating menu
        Cache::forget('menu_foods');
        Cache::forget('menu_drinks');

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu item successfully edited!');

    }

    public function disable($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->disable = "yes";
        $menu->save();

        // Clear cache after disabling menu
        Cache::forget('menu_foods');
        Cache::forget('menu_drinks');

        return redirect()
            ->route('menu.index')
            ->with('error','Menu item successfully disabled');
    }

    public function enable($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->disable = "no";
        $menu->save();

        // Clear cache after enabling menu
        Cache::forget('menu_foods');
        Cache::forget('menu_drinks');

        return redirect()
            ->route('menu.index')
            ->with('success','Menu item successfully enabled');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Delete associated menu options
        MenuOption::where('menu_id', $id)->delete();

        // Delete image if exists
        if($menu->thumbnail) {
            $image_path = public_path('images/'.$menu->thumbnail);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $menu->delete();

        // Clear cache after deleting menu
        Cache::forget('menu_foods');
        Cache::forget('menu_drinks');

        return redirect()
            ->route('menu.index')
            ->with('success','Menu item deleted successfully');
    }

    public function customer()
    {   
        return view('customer.menu');  
    }
}
