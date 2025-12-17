<?php

namespace App\Http\Livewire;

use App\Models\Menu;
use Livewire\Component;
use App\Models\TemporaryOrder;

class CustomerMenu extends Component
{
    public $foods;
    public $drinks;

    public $section;

    public $optionId;
    public $myOrders;

    public array $name = [];
    public array $quantity = [];
    
    protected $listeners = ['flashMessage', 'flashError'];

    public $loading = false;

    public function mount()
    {
        $this->loadMenus();
    }

    public function loadMenus()
    {
        $this->foods = Menu::with(['menuOption', 'category'])
            ->where([
                ['category_id', '1'],
                ['disable', 'no'],
            ])
            ->orderBy('name')
            ->get();

        $this->drinks = Menu::with(['menuOption', 'category'])
            ->where([
                ['category_id', '2'],
                ['disable', 'no'],
            ])
            ->orderBy('name')
            ->get();
    }

    public function loadSection()
    {   
        $this->section = "food";
    }

    public function food()
    {   
        $this->section = "food";
    }

    public function drink()
    {
        $this->section = "drink";
    }

    public function addOrder($menu_id)
    {   

        $this->emit('prependOrder', $menu_id, $this->optionId);
        
    }

    public function flashMessage($message){
        session()->flash('success', $message);
    }

    public function flashError($message){
        session()->flash('error', $message);
    }

    public function render()
    {
        return view('livewire.customer-menu');
    }
}
