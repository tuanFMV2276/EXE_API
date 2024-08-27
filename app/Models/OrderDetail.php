<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Một OrderDetail thuộc về một Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Một OrderDetail thuộc về một Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
