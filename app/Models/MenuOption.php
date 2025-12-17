<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'name',
        'cost',
    ];

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function order()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tempOrder()
    {
        return $this->hasMany(TemporaryOrder::class);
    }

}
