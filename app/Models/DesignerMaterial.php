<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'designer_id',
        'material_id',
        'quantity_requested',
        'request_date',
        'status',
    ];

    // Một DesignerMaterial thuộc về một Designer
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    // Một DesignerMaterial thuộc về một Material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
