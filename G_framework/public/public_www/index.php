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



$db=new \GF\DB\SimpleDB();


$a=$db->prepare('SELECT * FROM users WHERE user_ID = ?',array(3))->execute()->fetchAllAssoc();
print_r($a);

$app->run();
$app->getSession()->counter+=1;
echo $app->getSession()->counter;


