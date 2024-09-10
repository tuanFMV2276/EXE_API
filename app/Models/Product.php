<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'designer_id',
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'is_premium',
        'category'
    ];

    // Một Product thuộc về một Designer
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    // Một Product có thể có trong nhiều OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Quan hệ 1-n với ProductImage (một sản phẩm có nhiều ảnh)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Quan hệ 1-n với ProductSize (một sản phẩm có nhiều kích cỡ)
    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
}
