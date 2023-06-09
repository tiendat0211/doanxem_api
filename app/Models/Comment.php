<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'content', 'upvote', 'downvote'];

//    protected $appends = ['comment_time'];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies() {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }
}
