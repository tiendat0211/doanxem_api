<?php


namespace App\Helpers;


class Device
{
    const iosLink = 'https://apps.apple.com/app/id1574153933';
    const androidLink = 'https://play.google.com/store/apps/details?id=com.sphoton.doanxem';

    public static function detectDevice()
    {
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

        if( $iPod || $iPhone || $iPad){
            return self::iosLink;
        }else if($Android || $webOS){
            return self::androidLink;
        }
        return self::androidLink;
    }
}
