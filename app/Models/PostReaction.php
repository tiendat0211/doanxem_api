<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    use HasFactory;
    protected $table = 'post_users';

    protected $fillable = [
        'user_id',
        'post_id',
        'react',
        'share'
    ];

     const STATUS = [
        'LIKE' => 'upvote',
        'DISLIKE' => 'downvote'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
