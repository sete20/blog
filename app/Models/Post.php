<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeSearchPosts($query, $q)
    {
        return $query->where('body', $q . '%')
            ->OrWhere('slug', 'like', '%' . $q . '%')
            ->OrWhere('title', 'like', '%' . $q . '%')
            ->OrWhereHas('user', function ($query) use ($q) {
                return $query->where('name', 'like', '%' . $q . '%');
            });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        $comments = $this->hasMany(Comment::class);
        foreach ($comments as $comment) {
            $comment->setAttribute('add_at', $comment->created_at->diffFotHumans());
        }
        return $comments;
    }
    public function photos()
    {
        return $this->morphMany(photo::class, 'photoable');
    }
}
