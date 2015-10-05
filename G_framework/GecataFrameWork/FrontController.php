<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 г.
 * Time: 14:37 ч.
 */

namespace GF;


class FrontController
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public function dispatch()
    {
        $a = new \GF\Routers\DefaultRouter();
        $_uri = $a->getURI();
        $routes = \GF\App::getInstance()->getConfig()->routes;
    }

    public function getDefaultController()
    {
        $controller = \GF\App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return $controller;
        }
        return 'index';
    }

    public function getDefaultMethod()
    {
        $method = \GF\App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return $method;
        }
        return 'index';
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        return self::$_instance;
    }
}