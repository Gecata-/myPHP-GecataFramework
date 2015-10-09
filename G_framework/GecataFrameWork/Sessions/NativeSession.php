<?php

/**
 * Description of NativeSession
 *
 * @author gdimitrov
 */

namespace GF\Sessions;

class NativeSession implements GF\Session\iSession {

    public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secureHTTPS = false) {
        if (strlen($name) < 1) {
            $name = '__sess';
        }
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secureHTTPS, true);
        session_start();
    }

    public function __get($name) {
        return $_SESSION[$name];
    }

    public function __set($name, $value) {
        $_SESSION[$name]=$value;
    }

    public function destroySession() {
        session_destroy();
    }

    public function getSessionId() {
        return session_id();
    }

    public function saveSession() {
        session_write_close();
    }

}
