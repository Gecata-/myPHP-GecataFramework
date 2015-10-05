<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 г.
 * Time: 15:05 ч.
 */
namespace GF\Routers;
class DefaultRouter implements iRouter
{
    public function getURI()
    {
        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }

}