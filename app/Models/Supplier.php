<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_info',
        'address',
    ];

    // Một Supplier thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một Supplier có thể cung cấp nhiều Materials
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
