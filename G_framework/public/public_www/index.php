<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 1.10.2015 �.
 * Time: 13:02 �.
 */
error_reporting(E_ALL ^ E_NOTICE);
include '../../GecataFrameWork/App.php';

$app = GF\App::getInstance();

var_dump($app->getConnection());

$app->run();


