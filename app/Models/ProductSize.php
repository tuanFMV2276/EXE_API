<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'size', 'url_3d', 'min_width', 'max_width', 'min_heigh', 'max_heigh'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
