<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'quantity', 'user_id'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
