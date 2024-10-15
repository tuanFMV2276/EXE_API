<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_3d extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'bust',
        'waist',
        'hips',
        'weight',
        'height'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
