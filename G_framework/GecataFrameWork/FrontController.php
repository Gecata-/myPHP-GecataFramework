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
    private $namespace = null;
    private $controller = null;
    private $method = null;

    private function __construct()
    {
    }

    public function dispatch()
    {
        $a = new \GF\Routers\DefaultRouter();
        $_uri = $a->getURI();
        $routes = \GF\App::getInstance()->getConfig()->routes;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $key => $val) {
                if (stripos($_uri, $key) === 0 && $val['namespace']) {
                    $this->namespace = $val['namespace'];
                    break;
                }
            }
        } else {
            //TODO
            throw new \Exception('Default route missing', 500);
        }
        if ($this->namespace == null && $routes['*']['namespace']) {
            $this->namespace = $routes['*']['namespace'];
        } else if ($this->namespace == null && !$routes['*']['namespace']) {
            //TODO
            throw new \Exception('Default router is missing',500);
        }
        echo $this->namespace;
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