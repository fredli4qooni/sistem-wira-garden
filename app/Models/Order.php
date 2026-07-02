<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'destination_id',
        'order_code',
        'visitor_name',
        'phone',
        'email',
        'visit_date',
        'total_amount',
        'status',
        'snap_token',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
