<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'material_name',
        'description',
        'price_per_unit',
        'stock_quantity',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function designers()
    {
        return $this->belongsToMany(Designer::class, 'designer_materials')
                    ->withPivot('quantity_requested', 'request_date', 'status')
                    ->withTimestamps();
    }
    public function designerMaterials()
    {
        return $this->hasMany(DesignerMaterial::class);
    }
}