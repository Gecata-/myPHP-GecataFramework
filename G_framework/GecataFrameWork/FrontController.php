<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 ã.
 * Time: 14:37 ÷.
 */

namespace GF;


class FrontController
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public function dispatch(){
        $a = new \GF\Routers\DefaultRouter();
        $a->parse();
    }
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        return self::$_instance;
    }
}