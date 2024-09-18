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

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}