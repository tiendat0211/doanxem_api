<?php


use App\Helpers\Constant;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('createUseruuid')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */
    function createUseruuid()
    {
        return Str::random(30);
    }
}

if (!function_exists('getRandomUser')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */
    function getRandomUser()
    {
        $users = User::where('type', User::NOT_REAL)->pluck('id')->toArray();

        return $users[array_rand($users)];
    }
}

if (!function_exists('getRandomReaction')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */
    function getRandomReaction()
    {
        $reactions = Post::REACT;

        $rand = rand(0, count($reactions) -1);
        return $reactions[$rand];
    }
}
if (!function_exists('detect_extension_post')) {
    function detect_extension_post($post)
    {
        $imgTail = explode('.', $post);

        $extension = $imgTail[count($imgTail) - 1];
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif") {
            return 'image';
        }
        return 'video';
    }
}


if (!function_exists('getTotalReaction')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */

    function getTotalReaction($post = null, $amount = true)
    {
        if (!$post) {
            return 0;
        }

        if (is_bool($amount)) {
            return $post->like + $post->haha + $post->heart + $post->wow + $post->sad + $post->angry;
        }

        if (is_array($amount)) {
            $totalReaction = 0;
            foreach ($amount as $reaction) {
                $totalReaction += $post->{$reaction};
            }
            return $totalReaction;
        }
        return 0;
    }
}

if (!function_exists('getThreeMostReaction')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */
    function getThreeMostReaction($post = null)
    {
        $reaction = [
            'like' => $post->like,
            'heart' => $post->heart,
            'haha' => $post->haha,
            'wow' => $post->wow,
            'sad' => $post->sad,
            'angry' => $post->angry
        ];
        return getTotalReaction($post) ? @array_slice($reaction,count($reaction)-3) : [ 'like' => 0, 'heart' => 0, 'haha' => 0 ];
    }
}

if (!function_exists('detectExtensionPost')) {
    /**
     * Detect post extension
     * @param $post
     * @return mixed
     */
    function detectExtensionPost($post)
    {
        $imgTail = explode('.', $post);

        $extension = $imgTail[count($imgTail) - 1];
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif") {
            return 'image';
        }
        return 'video';
    }
}
