<?php
/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 5.10.2015 ã.
 * Time: 14:41 ÷.
 */
$cnf['admin']['namespace']= 'Controllers';

$cnf['administration']['namespace']= 'Controllers\Admin';
$cnf['administration']['controllers']['testindex']['to']='index';
$cnf['administration']['controllers']['testindex']['method']['echo'] ='index2';

$cnf['administration']['controllers']['new']['to']='create';

$cnf['*']['namespace']='Controllers';

return $cnf;