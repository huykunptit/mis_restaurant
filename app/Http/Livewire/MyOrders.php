<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MenuOption;
use App\Models\Transaction;
use App\Models\Table;
use App\Models\TemporaryOrder;
use App\Models\Reservation;
use Illuminate\Support\Facades\Session;

class MyOrders extends Component
{   
    public $myOrders;
    public $submittedOrders;
    public $part;
    public $optionId;
    public $remark;
    public $total;
    public $loading = false;
    public $submitting = false;

    protected $listeners = ['prependOrder'];

    public function mount()
    {
        $this->myOrders = TemporaryOrder::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->get();

        $this->submittedOrders = Transaction::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->where('payment_status', 'no')->orderBy('id', 'DESC')->get();

    }   

    public function render()
    {   
        return view('livewire.my-orders');
    }

    public function prependOrder($menu_id, $optionId)
    {
        $selectedMenu = MenuOption::with('menu')->findOrFail($optionId);
    
        if (!$selectedMenu || !$selectedMenu->menu) {
            $this->emit('flashError', 'Menu item not found.');
            return;
        }
    
        // Find table_id from reservations based on the user's ID
        $reservation = Reservation::where('user_id', auth()->user()->id)->first();
        $table_id = $reservation ? $reservation->table_id : null;
    
        if (!$table_id) {
            $this->emit('flashError', 'No table associated with this user.');
            return;
        }
    
        $existing = TemporaryOrder::where('user_id', auth()->user()->id)
            ->where('menu_option_id', $optionId)
            ->first();
    
        if ($existing == null) {
            $create = TemporaryOrder::create([
                'user_id' => auth()->user()->id,
                'menu_id' => $selectedMenu->menu->id,
                'menu_option_id' => $selectedMenu->id,
                'quantity' => 1,
                'remarks' => "",
                'table_id' => $table_id,
            ]);
    
            $this->myOrders = TemporaryOrder::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->get();
        } else {
            $existing->quantity = $existing->quantity + 1;
            $existing->save();
            $this->myOrders = TemporaryOrder::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->get();
        }
    }

    public function increment($id)
    {   
        $this->loading = true;
        
        try {
            $tempOrder = TemporaryOrder::findOrFail($id);

            if ($tempOrder && $tempOrder->user_id === auth()->user()->id) {
                $tempOrder->quantity = $tempOrder->quantity + 1;
                $tempOrder->save();
                $this->refreshOrders();
            }
        } finally {
            $this->loading = false;
        }
    }

    public function decrement($id)
    {
        $this->loading = true;
        
        try {
            $tempOrder = TemporaryOrder::findOrFail($id);

            if ($tempOrder && $tempOrder->user_id === auth()->user()->id) {
                if ($tempOrder->quantity > 1) {
                    $tempOrder->quantity = $tempOrder->quantity - 1;
                    $tempOrder->save();
                    $this->refreshOrders();
                } else {
                    // If quantity is 1, remove the item instead
                    $this->remove($id);
                    return;
                }
            }
        } finally {
            $this->loading = false;
        }
    }

    public function remove($id)
    {   
        $this->loading = true;
        
        try {
            $tempOrder = TemporaryOrder::findOrFail($id);
            
            if ($tempOrder && $tempOrder->user_id === auth()->user()->id) {
                $tempOrder->delete();
                $this->refreshOrders();
            }
        } finally {
            $this->loading = false;
        }
    }

    public function submitOrder()
    {   
        $this->submitting = true;

        try {
            $check = TemporaryOrder::where('user_id', auth()->user()->id)->get();

            if($check->isEmpty()){
                $this->remark = "";
                $message = 'Please add an order before submitting!';
                $this->emit('flashError', $message);
                return;
            }

            TemporaryOrder::query()
                ->where('user_id', auth()->user()->id)
                ->each(function ($oldRecord) {
                    $newRecord = $oldRecord->replicate();
                    $newRecord->completion_status = 'no';
                    $newRecord->payment_status = 'no';
                    if (!$newRecord->table_id) {
                        $reservation = Reservation::where('user_id', auth()->user()->id)->first();
                        $newRecord->table_id = $reservation ? $reservation->table_id : null;
                    }
                    if($this->remark !== null && $this->remark !== ''){
                        $newRecord->remarks = $this->remark;
                    }
        
                    $newRecord->setTable('transactions');
                    $newRecord->save();
                    $oldRecord->delete();
                });
        
            // Refresh orders after submission
            $this->refreshOrders();
            $this->remark = "";
    
            $message = 'Your order has successfully been submitted!';
            $this->emit('flashMessage', $message);
        } finally {
            $this->submitting = false;
        }
    }

    private function refreshOrders()
    {
        $this->myOrders = TemporaryOrder::with('menu', 'menuOption')
            ->where('user_id', auth()->user()->id)
            ->get();
            
        $this->submittedOrders = Transaction::with('menu', 'menuOption')
            ->where('user_id', auth()->user()->id)
            ->where('payment_status', 'no')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function loadPart()
    {   
        $this->part = "new";
    }

    public function new()
    {   
        $this->part = "new";
    }

    public function submitted()
    {
        $this->part = "submitted";
    }
}
