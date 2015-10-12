<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBSession
 *
 * @author gdimitrov
 */

namespace GF\Sessions;

class DBSession extends \GF\DB\SimpleDB  implements iSession {
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId = null;
    private $sessionData =[];
    

    public function __construct($dbConnection, $name, $tablename='sessions',$lifetime = 3600, $path = null, $domain = null, $secureHTTPS = false) {
        parent::__construct($dbConnection);
        $this->tableName = $tablename;
        $this->sessionName = $name;
        $this->lifetime=$lifetime;
        $this->path=$path;
        $this->domain = $domain;
        $this->secure=$secureHTTPS;
        $this->sessionId = $_COOKIE[$name];
        if(rand(0,50)  == 1){
            $this->gc();
        }
        if(strlen($this->sessionId) < 32){
            $this->startNewSession();
        }else if(!$this->validateSession()){
            $this->startNewSession();
        }
    }
    
    private function startNewSession(){
        $this->sessionId = md5(uniqid('gf',TRUE));
        $this->prepare('INSERT INTO '.$this->tableName.' (sessid,valid_until) VALUES(?,?)',
                array($this->sessionId,(time()+$this->lifetime)))->execute();
        setcookie($this->sessionName,$this->sessionId,(time()+$this->lifetime),
                $this->path,$this->domain,$this->secure,true);
    }

    private function validateSession(){
        if($this->sessionId){
            $d = $this->prepare('SELECT * FROM '.$this->tableName.' WHERE sessid=? AND valid_until <=?',
                    array($this->sessionId,(time() + $this->lifetime)))->execute()->fetchAllAssoc();
            if(is_array($d) && count($d)==1 && $d[0]){
                $this->sessionData = unserialize($d[0]['sess_data']);
                return true;
            }
        }
        return false;
    }
    public function __get($name) {
        return $this->sessionData[$name];
    }

    public function __set($name, $value) {
        $this->sessionData[$name] = $value;
    }

    public function destroySession() {
        if($this->sessionId){
            $this->prepare('DELETE FROM '.$this->tableName. ' WHERE sessid=?', array($this->sessionId))->execute();
        }
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function saveSession() {
        if($this->sessionId){
            $this->prepare('UPDATE '.$this->tableName.' SET sess_data =?, valid_until=? WHERE sessid = ?',
                    array(serialize($this->sessionData),(time()+ $this->lifetime),$this->sessionId))->execute();
            setcookie($this->sessionName, $this->sessionId, (time()+$this->lifetime), $this->path, $this->domain,
                     $this->secure,true);
        }
    }
    
    private function gc(){
        $this->prepare('DELETE FROM '.$this->tableName.' WHERE valid_until < ?',array(time()))->execute();
    }
}
