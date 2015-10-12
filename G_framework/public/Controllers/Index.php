<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 5.10.2015 г.
 * Time: 14:44 ч.
 */

namespace Controllers;

class Index {

    public function index2() {
        
        $val = new \GF\Validation();
        $val->setRule('url','http://az.c@/','','wrong url')->setRule('minlength','http://az.c/',50);
        $val->setRule('custom',4,function($a){
            return $a%2;
        });
        var_dump($val->validate());
        print_r($val->getErrors());
        
        $view = \GF\View::getInstance();
        $view->appendToLayout('body','product.index');
        $view->appendToLayout('test','index');
        $view->display('layouts.default2', array('test'=>array(1,2,3,4,5,6)),false);
    }

}
