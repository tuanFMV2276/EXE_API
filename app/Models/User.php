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


    // Một User có thể là một Designer
    public function designer()
    {
        return $this->hasOne(Designer::class);
    }

    // Một User có thể là một Supplier
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    // Một User (Customer) có thể có nhiều Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // Một User có thể viết nhiều News
    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    // Một User có thể có nhiều Subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Một User có thể có nhiều PremiumFeatures thông qua UserFeatures
    public function premiumFeatures()
    {
        return $this->belongsToMany(PremiumFeature::class, 'user_features')
            ->withPivot('activated_date')
            ->withTimestamps();
    }
}
