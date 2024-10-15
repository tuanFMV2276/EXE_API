<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_Is_Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'news_id',
        'is_like',
    ];


    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}