<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index()
    {   
        $foods = Menu::with(['menuOption', 'category'])->where('category_id', '1')->get();
        $drinks = Menu::with(['menuOption', 'category'])->where('category_id', '2')->get();

        return view('menu.index', [
            'foods' => $foods,
            'drinks' => $drinks,
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
            // $path = 'images/';
            $request->image->move('images/', $imageName);

            $menu = Menu::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'disable' => "no",
                'thumbnail' => $imageName,
            ]);

        } else{

            $menu = Menu::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'disable' => "no",
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

        return redirect()
            ->route('menu.index')
            ->with('success', 'New menu item successfully added!');
    }

    public function edit($id)
    {   
        $menu = Menu::find($id);
        $menuOptions = MenuOption::where('menu_id', $id)->get();

        // dd($menuOption);
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

        $menu = Menu::find($id);
        
        $menu->category_id = $request->category;
        $menu->name = $request->name;

        if($request->image !== null){

            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->image->extension();
            // $request->image->move(public_path('images'), $imageName);
            $request->image->move('images/', $imageName);
            $menu->thumbnail = $imageName;
        }

        $menu->save();


        // Xoá all 'Menu Option'
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

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu item successfully edited!');

    }

    public function disable($id)
    {
        $menu = Menu::find($id);

        $menu->disable = "yes";

        $menu->save();

        return redirect()
            ->route('menu.index')
            ->with('error','Menu item successfully disabled');
    }

    public function enable($id)
    {
        $menu = Menu::find($id);

        $menu->disable = "no";

        $menu->save();

        return redirect()
            ->route('menu.index')
            ->with('success','Menu item successfully enabled');
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();

        $menuOption = MenuOption::where('menu_id', $id);
        $menuOption->delete();

        $image_path = 'images/'.$menu->thumbnail;

        if(File::exists($image_path)) {
            File::delete($image_path);
        }

        return redirect()
            ->route('menu.index')
            ->with('success','Menu item deleted successfully');
    }

    public function customer()
    {   
        return view('customer.menu');  
    }
}
