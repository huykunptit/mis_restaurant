<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'table_id', 'menu_id', 'menu_option_id', 'reservation_time', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuOption()
    {
        return $this->belongsTo(MenuOption::class);
    }
}
