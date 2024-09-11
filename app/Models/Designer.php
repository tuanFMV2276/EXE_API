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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'designer_materials')
            ->withPivot('quantity_requested', 'request_date', 'status')
            ->withTimestamps();
    }

    public function designerMaterials()
    {
        return $this->hasMany(DesignerMaterial::class);
    }
}