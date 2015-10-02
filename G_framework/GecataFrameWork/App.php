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

    private function __construct(){
        \GF\Loader::registerNamespace('GF',dirname(__FILE__).DIRECTORY_SEPARATOR);
        \GF\Loader::registerAutoload();
    }

    public function run(){

    }

    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new App();
        }
        return self::$instance;
    }
}