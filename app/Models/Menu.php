<?php

namespace App\Models;

use App\Models\Category;
use App\Models\MenuOption;
use App\Models\Transaction;
use App\Models\TemporaryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'disable',
        'thumbnail',
        'pre_order'
    ];

    public $timestamps = false;

    public function menuOption()
    {
        return $this->hasMany(MenuOption::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
