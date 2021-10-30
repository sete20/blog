<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $guarded = [''];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replays()
    {
        return $this->hasMany(CommentReplay::class, 'comment_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
