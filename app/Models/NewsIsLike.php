<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsIsLike extends Model
{
    use HasFactory;

    protected $table = 'news_is_like';

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
