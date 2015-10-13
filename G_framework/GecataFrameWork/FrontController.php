<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 г.
 * Time: 14:37 ч.
 */

namespace GF;

class FrontController {

    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    /**
     *
     * @var \GF\Routers\iRouter
     */
    private $method = null;
    private $router = null;

    private function __construct() {
        
    }

    /**
     * @return null
     */
    public function getRouter() {
        return $this->router;
    }

    /**
     * @param null $router
     */
    public function setRouter(\GF\Routers\iRouter $router) {
        $this->router = $router;
    }

    /**
     * @throws \Exception
     */
    public function dispatch() {
        if ($this->router == null) {
            //TODO
            throw new \Exception('No valid router found', 500);
        }
        $_uri = $this->router->getURI();
        $routes = \GF\App::getInstance()->getConfig()->routes;
        $rc = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $key => $val) {
                if (stripos($_uri, $key) === 0 && ($_uri == $key || stripos($_uri, $key . '/') === 0) && $val['namespace']) {
                    $this->namespace = $val['namespace'];
                    $_uri = substr($_uri, strlen($key) + 1);
                    $rc = $val;
                    break;
                }
            }
        } else {
            //TODO
            throw new \Exception('Default route missing', 500);
        }
        if ($this->namespace == null && $routes['*']['namespace']) {
            $this->namespace = $routes['*']['namespace'];
            $rc = $routes['*'];
        } else if ($this->namespace == null && !$routes['*']['namespace']) {
            //TODO
            throw new \Exception('Default router is missing', 500);
        }
        $input = \GF\InputData::getInstance();
        $params = explode('/', $_uri);
        if ($params[0]) {
            $this->controller = strtolower($params[0]);
            if ($params[1]) {
                $this->method = strtolower($params[1]);
                uset($params[0], $params[1]);
                $input->setGet(array_values($params));
            } else {
                $this->method = $this->getDefaultMethod();
            }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }
        if (is_array($rc) && $rc['controllers']) {
            if ($rc['controllers'][$this->controller]['method'][$this->method]) {
                $this->method = strtolower($rc['controllers'][$this->controller]['method'][$this->method]);
            }
            if (isset($rc['controllers'][$this->controller]['to'])) {
                $this->controller = strtolower($rc['controllers'][$this->controller]['to']);
            }
        }
        $input->setPost($this->router->getPost());

        //TODO Fix it
        $f = $this->namespace . '\\' . ucfirst($this->controller);
        $newController = new $f();
        $newController->{$this->method}();
    }

    public function getDefaultController() {
        $controller = \GF\App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }
        return 'index';
    }

    public function getDefaultMethod() {
        $method = \GF\App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }
        return 'index';
    }

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        return self::$_instance;
    }

}
