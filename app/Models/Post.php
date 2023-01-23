<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function scopeWithLikes($query)
    {
        $query->withCount(['likes as likes_count1' => function ($query) {
            $query->where('user_id', auth()->id());
        }]);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
