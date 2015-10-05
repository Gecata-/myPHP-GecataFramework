<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 г.
 * Time: 10:50 ч.
 */

namespace GF;


class Config
{
    private static $_instance = null;
    private $_configFolder = null;
    private $_configArray = [];

    private function __construct()
    {

    }

    /**
     * @return ConfigFolder
     */
    public function getConfigFolder()
    {
        return $this->_configFolder;
    }

    /**
     * @param $configFolder
     * @throws \Exception
     */
    public function setConfigFolder($configFolder)
    {
        if (!$configFolder) {
            throw new \Exception('Empty config folder path');
        }
        $_configFolder = realpath($configFolder);
        if ($_configFolder != FALSE && is_dir($_configFolder) && is_readable($_configFolder)) {
            $this->_configArray = [];
            $this->_configFolder = $_configFolder . DIRECTORY_SEPARATOR;
            $ns = $this->app['namespaces'];
            if (is_array($ns)) {
                \GF\Loader::registerNamespaces($ns);
            }
        } else {
            throw new \Exception('Config directory read error:' . $configFolder);
        }
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function includeConfigFile($path)
    {
        if (!$path) {
            //TODO
            throw new \Exception;
        }
        $_file = realpath($path);
        if ($_file != FALSE && is_file($_file) && is_readable($_file)) {
            $_fileName = explode('.php', basename($_file))[0];
            $this->_configArray[$_fileName] = include $_file;
        } else {
            //TODO
            throw new \Exception('Config file read error:' . $path);
        }

    }

    /**
     * @param $name
     * @return null
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!$this->_configArray[$name]) {
            $this->includeConfigFile($this->_configFolder . $name . '.php');
        }
        if (array_key_exists($name, $this->_configArray)) {
            return $this->_configArray[$name];
        }
        return null;
    }

    /**
     * @return Config|null
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }
}