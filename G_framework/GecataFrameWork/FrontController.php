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
        $a->parse();
        $controller = $a->getController();
        $method = $a->getMethod();
        if ($controller == null) {
            $controller = $this->getDefaultController();
        }
        if($method==null){
            $method = $this->getDefaultMethod();
        }
        echo $controller.'<br>'.$method;

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