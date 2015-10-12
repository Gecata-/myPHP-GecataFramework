<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 1.10.2015 г.
 * Time: 13:04 ч.
 */
namespace GF;
include 'Loader.php';

class App
{
    private static $instance = null;
    private $config = null;
    private $frontController = null;
    private $router = null;


    private function __construct()
    {
        \GF\Loader::registerNamespace('GF', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \GF\Loader::registerAutoload();
        $this->config = \GF\Config::getInstance();
    }

    /**
     * @return null
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param null $router
     */
    public function setRouter($router=null)
    {
        $this->router = $router;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function setConfigFolder($path)
    {
        $this->config->setConfigFolder($path);
    }

    /**
     * @return GF\config folder
     */
    public function getConfigFolder()
    {
        return $this->config->_configFolder;
    }

    /**
     * @return \GF\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->config->getConfigFolder() == null) {
            $this->setConfigFolder('../Config');
        }
        $this->frontController = \GF\FrontController::getInstance();
        if ($this->router instanceof \GF\Routers\iRouter) {
            $this->frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            //TODO fix it when RPC is done
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            //TODO fix it when CLI is done
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        } else {
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        }
        $this->frontController->dispatch();
    }

    /**
     * @return App|null
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }
        return self::$instance;
    }
}