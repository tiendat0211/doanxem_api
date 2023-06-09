<?php

namespace App\Helpers;

class RouteHelper
{
    public static function isActiveRoute($routeGroup){

        if (strpos(request()->route()->getName(), $routeGroup) !== false) {
            return "active";
        }

        return"";
    }
}
