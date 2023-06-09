<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    const NEW = 'new';
    const PENDING = 'pending';
    const APPROVAL = 'approval';
    const REJECT = 'reject';
    const REPORT = 'report';
    const HIDE = 'hide';

    const STATUS = [
        'pending' => 'Đợi duyệt',
        'approval' => 'Đã duyệt',
        'reject' => 'Bị từ chối',
        'report' => 'Bị báo cáo',
    ];
    const REACT = [
        'like',
        'heart',
        'haha',
        'wow',
        'sad',
        'angry'
    ];

//    protected $appends = ['share_link', 'reaction', 'saved', 'time', 'image_size', 'image_size'];

    protected $hidden = [];
    protected $appends = ['total_interactive'];

    /**
     * @start Relations
     * @Post belongs to an user
     * @Post can have many comments
     * @Post can be liked
     * @Post have only one file
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function postReactions()
    {
        return $this->hasMany(PostReaction::Class);
    }
    public function file()
    {
        return $this->morphOne(File::class,'fileable');
    }
    /**
     * @end \Illuminate\Database\Eloquent\Relations\
     */


    /**
     * @param $post
     * @return string
     * chưa biết
     */
    public static function detectExtensionPost($post)
    {
        $imgTail = explode('.', $post);

        $extension = $imgTail[count($imgTail) - 1];
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif") {
            return 'image';
        }
        return 'video';
    }

    /**
     * @return mixed
     * chưa biết
     */
    public function getTotalInteractiveAttribute()
    {
        return ($this->heart + $this->haha  + $this->sad + $this->angry + $this->wow + $this->like);
    }

    /**
     * @param $query
     * @return mixed
     *
     */
    public function scopeApproval($query)
    {
        return $query->where('status', self::APPROVAL);
    }

    /**
     * @param $query
     * @return mixed
     * Query builder
     */
    public function scopePending($query)
    {
        return $query->where('status', self::PENDING);
    }

    /**
     * @param $query
     * @param $blocked
     * @param $blocker
     * @return mixed
     * Query builder
     */
    public function scopeUnblock($query, $blocked = [], $blocker = [])
    {
        $listBlock = array_merge($blocked, $blocker);
        return $query->whereNotIn('user_id', $listBlock);
    }

    /**
     * @param $query
     * @param array $savedPost
     * @return mixed
     */
    public function scopeGetTopPost($query, array $savedPost)
    {
        Carbon::setLocale('vi');
        $user = auth()->user();
        $defaultGalleries = $user ? @$user->galleries()->default()->first() : '';
        $posts = $query->approval()->select('id', 'title', 'image', 'share', 'user_id', 'post_uuid', 'created_at', 'like', 'heart', 'wow', 'haha', 'sad', 'angry','thumbnail')
            ->withoutGlobalScope('newest_post')
            ->with(['user:id,name,avatar,email,user_uuid'])
            ->with('postReactions')
            ->withCount('comments as total_comments')
//            ->where("approved_at", ">=", now()->subDays(30))
            ->paginate()->through(function ($post) use ($user, $savedPost, $defaultGalleries) {
                $post->total_reactions = getTotalReaction($post);
                $post->pointOfPost = $post->comments_count * 2 + $post->share * 5 + $post->total_reactions;
                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
                $post['time'] = $post->created_at->diffForHumans();
                $post['isSaved'] = ($defaultGalleries ? $defaultGalleries->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false;
                return $post;
            })
            ->filter(function ($post) {
                return $post->pointOfPost > config('notification.top_post');
            })
            ->sortByDesc('pointOfPost')
            ->flatten();
        return $posts;
    }

    public static function booted()
    {
        static::addGlobalScope('newest_post', function (Builder $builder) {
            $builder->orderBy('approved_at', 'desc');
        });
    }

    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getImageSizeAttribute()
    {
        preg_match_all("/^width=\"([0-9]*)\" height=\"([0-9]*)\"$/", getimagesize('https://doanxem.s3.ap-southeast-1.amazonaws.com/image/DAb7ydGJxQA9mASaKtkZXHcCsUHwLdlB9OQ5NEIX.jpg')[3], $matched);

        $width = $matched[1][0];
        $height = $matched[2][0];

        return [
            'width' => $width,
            'height' => $height
        ];
    }

    public function currentReaction($user)
    {
        if (!$user) {
            return 'none';
        }
        $reaction = $user->postReactions->where('post_id', $this->id)->first();
        if ($reaction == null) {
            return 'none';
        } else {
            return $reaction->react;
        }
    }

    public function getRanking()
    {
        $ranking = DB::table('posts')->orderBy('upvote', 'desc')->get();
        $userRank = DB::table('posts')->where('user_id', $this->user_id)->first();
        return $ranking;
    }

    public function getShareLinkAttribute()
    {
        return config('app.url') . "/posts/" . $this->post_uuid;
    }
}
