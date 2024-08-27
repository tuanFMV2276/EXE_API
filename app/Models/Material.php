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

    // Một Material thuộc về một Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Một Material có thể được yêu cầu bởi nhiều Designers thông qua DesignerMaterials
    public function designers()
    {
        return $this->belongsToMany(Designer::class, 'designer_materials')
                    ->withPivot('quantity_requested', 'request_date', 'status')
                    ->withTimestamps();
    }

    // Một Material có thể có nhiều DesignerMaterials
    public function designerMaterials()
    {
        return $this->hasMany(DesignerMaterial::class);
    }
}