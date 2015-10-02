<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 1.10.2015 ã.
 * Time: 13:02 ÷.
 */
error_reporting(E_ALL ^ E_NOTICE);
include '../../GecataFrameWork/App.php';
$app = GF\App::getInstance();

$config = GF\Config::getInstance();
$config->setConfigFolder('../Config');
echo $config->app['test'];
echo $config->db['name'];
$app->run();