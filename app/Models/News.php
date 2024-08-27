<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author_id',
    ];

    // Một News thuộc về một User (Author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
