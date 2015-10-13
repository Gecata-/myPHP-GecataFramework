<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author gdimitrov
 */

namespace GF;

class View {

    private $___viewPath = null;
    private static $instance = null;
    private $___viewDir = null;
    private $___data = [];
    private $___layoutParts =[];
    private $___layoutData = [];
    private $___extension = '.php';

    private function __construct() {

        $this->___viewPath = \GF\App::getInstance()->getConfig()->app['viewDirectory'];
        if ($this->___viewPath == null) {
            $this->___viewPath = realpath('../Views');
        }
    }

    public function setViewDirectory($path) {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->___viewDir = $path;
            } else {
                //TODO
                throw new \Exception('view path '.$path, 500);
            }
        } else {
            //TODO
            throw new \Exception('view path '.$path, 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false) {
        if (is_array($data)) {
            $this->___data = array_merge($this->___data, $data);
        }
        
        if(count($this->___layoutParts)>0){
            foreach ($this->___layoutParts as $k=>$v){
                $r=$this->includeFile($v);
                if($r){
                    $this->___layoutData[$k] = $r;
                }
            }
        }
        if ($returnAsString) {
            return $this->includeFile($name);
        } else {
            echo $this->includeFile($name);
        }
    }
    
    public function getLayoutData($name){
        return $this->___layoutData[$name];
    }
    
    public function appendToLayout($key,$template){
        if($key && $template){
            $this->___layoutParts[$key] = $template;
        }else{
            //TODO
            throw new Exception('Layout require valid key and template', 500);
        }
    }
    
    private function includeFile($file) {
        if ($this->___viewDir == null) {
            $this->setViewDirectory($this->___viewPath);
        }
        $___fl = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if (file_exists($___fl) && is_readable($___fl)) {
            ob_start();
            include $___fl;
            return ob_get_clean();
        } else {
            throw new \Exception('View ' . $file . ' cannot be included. File searched at: '.$___fl.' !', 500);
        }
    }

    public function __set($name, $value) {
        $this->___data[$name] = $value;
    }

    public function __get($name) {
        return $this->___data[$name];
    }

    /**
     * 
     * @return \GF\View
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new \GF\View();
        }
        return self::$instance;
    }

}
