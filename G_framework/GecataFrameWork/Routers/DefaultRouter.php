<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 ã.
 * Time: 15:05 ÷.
 */
namespace GF\Routers;
class DefaultRouter
{
    public function parse()
    {
        echo '<pre>' . print_r($_SERVER, true) . '</pre>';
        $uri = substr(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']),1);
        echo $uri.'<br>';
        $controller = null;
        $method = null;
        $params = explode('/',$uri);
        if($params[0]){
            $controller = ucfirst($params[0]);

            if($params[1]) {
                $method = $params[1];
                unset($params[0], $params[1]);
            }else{
                $method = 'index';
            }
        }else{
            $controller = 'index';
            $method = 'index';
        }
        echo $controller.'<br>'.$method;
    }
}