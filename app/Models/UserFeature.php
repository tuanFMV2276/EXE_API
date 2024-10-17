<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feature_id',
        'activated_date',
        'expiry_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function premiumFeature()
    {
        return $this->belongsTo(PremiumFeature::class, 'feature_id');
    }
}
