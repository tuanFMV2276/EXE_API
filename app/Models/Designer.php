<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'contact_info',
        'bio',
    ];

    // Một Designer thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một Designer có thể có nhiều Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Một Designer có thể yêu cầu nhiều Materials thông qua DesignerMaterials
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'designer_materials')
            ->withPivot('quantity_requested', 'request_date', 'status')
            ->withTimestamps();
    }

    // Một Designer có thể có nhiều DesignerMaterials
    public function designerMaterials()
    {
        return $this->hasMany(DesignerMaterial::class);
    }
}
