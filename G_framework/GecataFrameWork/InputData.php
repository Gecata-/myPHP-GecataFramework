<?php

/**
 * Description of InputData
 *
 * @author gdimitrov
 */

namespace GF;

class InputData {

    private static $instance = null;
    private $get = [];
    private $post = [];
    private $cookies = [];

    private function __construct() {
        $this->cookies = $_COOKIE;
    }
/**
 * 
 * @param type $arr
 */
    public function setPost($arr) {
        if (is_array($arr)) {
            $this->post = $arr;
        }
    }
/**
 * 
 * @param type $arr
 */
    public function setGet($arr) {
        if (is_array($arr)) {
            $this->get = $arr;
        }
    }
    public function hasGet($id){
        return array_key_exists($id, $this->get);
    }
    
    public function hasPost($id){
        return array_key_exists($id,$this->post);
    }
    
    public function get($id,$normalize=null,$default=null){
        if($this->hasGet($id)){
            if($normalize!=null){
                
            }
            return $this->get[$id];
        }
        return $default;
    }

    /**
     * 
     * @return type
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new InputData();
        }
        return self::$instance;
    }

}
