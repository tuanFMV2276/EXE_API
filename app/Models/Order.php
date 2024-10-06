<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'full_name',
        'shipping_address',
        'phone',
        'payment_method',
        'status',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    //     $orders = Order::with('orderDetails.product')->get();

    // foreach ($orders as $order) {
    //     foreach ($order->orderDetails as $detail) {
    //         echo $detail->product->product_name;
    //     }
    // }

}