<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'bank_id',
        'table_id',
        'order_group_id',
        'payment_method',
        'qr_code_url',
        'amount',
        'status',
        'payment_gateway_response',
        'transaction_id',
        'paid_at',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}

