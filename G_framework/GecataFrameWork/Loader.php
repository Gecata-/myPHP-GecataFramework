<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 1.10.2015 г.
 * Time: 13:11 ч.
 */

namespace GF;


final class Loader
{
    private static $namespaces = array();

    private function __construct()
    {
    }

    public static function registerAutoload()
    {
        spl_autoload_register(array('\GF\Loader', 'autoload'));
    }

    public static function autoload($class)
    {
        self::loadClass($class);
    }

    /**
     * @param $class
     * @throws \Exception
     */
    public static function loadClass($class)
    {
        foreach (self::$namespaces as $k => $v) {
            if (strpos($class, $k) === 0) {
               $classFile = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $v, 0, strlen($k)) . '.php');
                if ($classFile && is_readable($classFile)) {
                    include $classFile;
                } else {
                    //TODO
                    throw new \Exception('classFile cannot be included' . $classFile);
                }
                break;
            }
        }
    }

    /**
     * @param $namespace
     * @param $path
     * @throws \Exception
     */
    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                //TODO
                throw new \Exception('invalid path');
            }
            $_path = realpath($path);
            if ($_path && is_dir($_path) && is_readable($_path)) {
                self::$namespaces[$namespace . '\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                //TODO
                throw new \Exception('Namespace directory read error' . $path);
            }
        } else {
            //TODO
            throw new \Exception('Invalid namespace' . $namespace);
        }
    }

    /**
     * @param $arr
     * @throws \Exception
     */
    public static function registerNamespaces($arr){
        if(is_array($arr)){
            foreach($arr as $key=>$val){
                self::registerNamespace($key,$val);
            }
        }else{
            //TODO
            throw new \Exception('Invalid Namespace');
        }
    }

    /**
     * @return array
     */
    public static function getNamespace()
    {
        return self::$namespaces;
    }

    /**
     * @param $namespace
     */
    public static function removeNamespace($namespace)
    {
        unset(self::$namespaces[$namespace]);
    }

    public static function clearNamespaces()
    {
        self::$namespaces = array();
    }

}