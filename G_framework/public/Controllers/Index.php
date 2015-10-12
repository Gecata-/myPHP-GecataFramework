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
        $view = \GF\View::getInstance();
        $view->appendToLayout('body','product.index');
        $view->appendToLayout('test','index');
        $view->display('layouts.default2', array('test'=>array(1,2,3,4,5,6)),false);
    }

}
