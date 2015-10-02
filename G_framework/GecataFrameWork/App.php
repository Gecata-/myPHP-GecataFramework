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

    private function __construct()
    {
        \GF\Loader::registerNamespace('GF', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \GF\Loader::registerAutoload();
        $this->config = \GF\Config::getInstance();
    }

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
    public function getConfig(){
        return $this->config;
    }

    public function run()
    {
        if ($this->config->getConfigFolder() == null) {
            $this->setConfigFolder('../Config');
        }
        $this->frontController = \GF\FrontController::getInstance();

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