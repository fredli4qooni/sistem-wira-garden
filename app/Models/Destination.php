<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'total_stock',
        'pricing_type',
        'price_adult',
        'price_child',
        'address',
        'maps_url',
        'open_hours',
        'image_path',
        'category_id',
        'facilities',
        'gallery_images',
    ];

    protected $casts = [
        'facilities' => 'array',
        'gallery_images' => 'array',
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getAvailableStock($date)
    {
        if (is_null($this->total_stock)) {
            return null; // Unlimited
        }
        
        $bookedQuantity = OrderItem::whereHas('order', function ($query) use ($date) {
            $query->where('destination_id', $this->id)
                  ->whereDate('visit_date', $date)
                  ->where('status', '!=', 'CANCELLED');
        })->sum('quantity');
        
        return max(0, $this->total_stock - $bookedQuantity);
    }
}
