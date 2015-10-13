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

    private $map = [];
    private $requestId;
    private $post = [];

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] != 'application/json') {
            throw new \Exception('Require JSON request', 400);
        }
    }

    /**
     * 
     * @param type $arr
     */
    public function setMethodMaps($arr) {
        if (is_array($arr)) {
            $this->map = $arr;
        }
    }

    /**
     * @throws Exception
     */
    public function getURI() {
        if (!is_array($this->map) || count($this->map) == 0) {
            $ar = \GF\App::getInstance()->getConfig()->rpcRoutes;
            if (is_array($ar) && count($ar) > 0) {
                $this->map = $ar;
            } else {
                //TODO
                throw new \Exception('Router require method map', 500);
            }
        }
        $request = json_decode(file_get_contents('php://input'), true);
        if (is_array($request) || !isset($request['methid'])) {
            throw new Exception('Requieres json requiest', 400);
        } else {
            if ($this->map[$request['method']]) {
                $this->requestId = $request['id'];
                $this->post = $request['params'];
                return $this->map[$request['method']];
            } else {
                throw new Exception('Method not found', 501);
            }
        }
    }

    public function getRequestId() {
        return $this->requestId;
    }

    public function getPost() {
        return $this->post;
    }

}
