<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'ticket_type_id',
        'ticket_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];
}
