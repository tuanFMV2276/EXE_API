<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'gender',
        'role',
        'is_premium',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function designer()
    {
        return $this->hasOne(Designer::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function premiumFeatures()
    {
        return $this->belongsToMany(PremiumFeature::class, 'user_features', 'user_id', 'feature_id')
            ->withPivot('activated_date')
            ->withTimestamps();
    }

    public function designerProducts()
    {
        return $this->hasOneThrough(Product::class, Designer::class, 'user_id', 'designer_id', 'id', 'id');
    }

    public function model_3ds()
    {
        return $this->hasMany(Model_3d::class);
    }
}