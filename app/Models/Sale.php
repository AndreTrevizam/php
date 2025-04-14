<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'unit_price'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'float'
    ];
    
    // Acessor para o total
    public function getTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
