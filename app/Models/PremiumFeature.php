<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_name',
        'description',
        'price',
        'duration_days',
        'is_feature',

    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_features')
            ->withPivot('activated_date')
            ->withTimestamps();
    }
}
