<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 2.10.2015 �.
 * Time: 11:09 �.
 */
$cnf['default_controller']='index';
$cnf['default_method']='index2';
$cnf['namespaces']['Controllers'] = 'C:\wamp\www\G_framework\public\Controllers';

$cnf['session']['autostart'] = true;
$cnf['session']['type']='native';
$cnf['session']['name']='__sess';
$cnf['session']['lifetime']=3600;
$cnf['session']['path']=DIRECTORY_SEPARATOR;
$cnf['session']['domain']='';
$cnf['session']['secure']=false;

return $cnf;