<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use App\Models\Table;
use App\Models\MenuOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'table_id',
        'order_group_id',
        'menu_id',
        'menu_option_id',
        'quantity',
        'remarks',
        'completion_status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuOption()
    {
        return $this->belongsTo(MenuOption::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
 