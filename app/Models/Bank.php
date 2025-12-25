<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'account_name',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

