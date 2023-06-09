<?php


namespace App\Helpers;


class Emoji
{
    private static $list = ['😁','😂','😃','😄','😅','😆','😉','😊','😋','😌','😍','😏','😒','😓','😔','😖','😘','😚','😜','😝','😞','😠','😡','😢','😣','😤','😥','😨','😩','😪','😫','😭','😰','😱','😲','😳','😵','😷','😸','😹','😺','😻','😼','😽','😾','😿','🙀','🙅','🙆','🙇','🙈','🙉','🙊','🙋','🙌','🙍','🙎','🙏','🚀'];

    public static function getRandom()
    {
        return static::$list[array_rand(static::$list)];
    }
}
