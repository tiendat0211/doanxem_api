<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login_at', 'last_login_ip','api_token', 'avatar', 'status', 'user_uuid', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'create_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const BLOCK_USER = 'user';

    const BLOCK_POST = 'post';

    const NOT_REAL = 0;
    const REAL = 1;

    /**
     * @start Relations
     * @user has many posts,comments,reactions,files,fcmtokens,galleries
     * @user can be blocked by many other users
     * @user can block other users
     * @user can open app many times
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postReactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function commentReactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }

    public function blockedAccounts()
    {
        return $this->belongsToMany(User::class, 'blocker_user', 'user_id', 'blocker_id')->withPivot(['action']);
    }

    public function blockerAccounts()
    {
        return $this->belongsToMany(User::class, 'blocker_user', 'blocker_id', 'user_id')->withPivot(['action']);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function timeOpenApp()
    {
        return $this->hasMany(UserOpenApp::class);
    }

    public function lastOpenApp()
    {
        return $this->hasOne(UserOpenApp::class);
    }

    public function hasSocialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }
    /**
     *
     * @end \Illuminate\Database\Eloquent\Relations\
     *
     */

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @start
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @end JWT
     */

    /**
     * @start FCM
     * @return mixed
     */
    public function routeNotificationForFcm()
    {
        return $this->getDeviceTokens();
    }

    public function getDeviceTokens()
    {
        return $this->fcmTokens->pluck('fcm_token')->toArray();
    }
    /**
     * @end FCM
     */


    /**
     * @start Local Scope
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function scopeSavedPost($query)
    {
        $user = auth()->user()->load(['galleries.posts' => function($query) {
            $query->where('status', Post::APPROVAL);
        }]);

        $posts = collect();
        foreach ($user->galleries as $gallery) {
            $posts->add($gallery->posts);
        }

        $posts = $posts->flatten();
        foreach ($posts as $post) {
            if ($post->thumbnail) {
                $post->image = $post->thumbnail;
            }
        }
        return $posts->flatten();
    }

    public function scopeRealAccount($query)
    {
        return $query->where('type', self::REAL);
    }

    /**
     * @end Scope
     */
}
