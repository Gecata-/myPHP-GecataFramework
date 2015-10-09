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

    public function hasGet($id) {
        return array_key_exists($id, $this->get);
    }

    public function hasPost($id) {
        return array_key_exists($id, $this->post);
    }

    public function hasCookies($id) {
        return array_key_exists($id, $this->cookies);
    }

    public function get($id, $normalize = null, $default = null) {
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return \GF\Common::normalize($this->get[$id], $normalize);
            }
            return $this->get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default = null) {
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return \GF\Common::normalize($this->post[$name], $normalize);
            }
            return $this->post[$name];
        }
        return $default;
    }

    public function cookies($name, $normalize = null, $default = null) {
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return \GF\Common::normalize($this->cookies[$name], $normalize);
            }
            return $this->cookies[$name];
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
