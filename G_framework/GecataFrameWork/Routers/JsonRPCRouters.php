<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonRPCRouters
 *
 * @author gdimitrov
 */

namespace GF\Routers;

class JsonRPCRouters implements iRouter {

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_SERVER['CONTENT_TYPE']) 
                || $_SERVER['CONTENT_TYPE'] != 'application/json') {
            throw new \Exception('Require JSON request', 400);
        }
    }

    public function getURI() {
        
    }

}
