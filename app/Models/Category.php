<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon_type',
        'icon_value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
