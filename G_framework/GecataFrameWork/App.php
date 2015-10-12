<?php

/**
 * Created by PhpStorm.
 * User: gdimitrov
 * Date: 1.10.2015 г.
 * Time: 13:04 ч.
 */

namespace GF;

include 'Loader.php';

class App {

    private static $instance = null;
    private $config = null;
    private $frontController = null;
    private $router = null;
    private $dbConnections = [];
    private $session = null;

    private function __construct() {
        \GF\Loader::registerNamespace('GF', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \GF\Loader::registerAutoload();
        $this->config = \GF\Config::getInstance();
        if ($this->config->getConfigFolder() == null) {
            $this->setConfigFolder('../Config');
        }
    }

    /**
     * @return null
     */
    public function getRouter() {
        return $this->router;
    }

    /**
     * @param null $router
     */
    public function setRouter($router = null) {
        $this->router = $router;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function setConfigFolder($path) {
        $this->config->setConfigFolder($path);
    }

    /**
     * @return GF\config folder
     */
    public function getConfigFolder() {
        return $this->config->_configFolder;
    }

    /**
     * @return \GF\Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * @throws \Exception
     */
    public function run() {

        $this->frontController = \GF\FrontController::getInstance();
        if ($this->router instanceof \GF\Routers\iRouter) {
            $this->frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            //TODO fix it when RPC is done
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            //TODO fix it when CLI is done
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        } else {
            $this->frontController->setRouter(new \GF\Routers\DefaultRouter());
        }

        $_sess = $this->config->app['session'];
        if ($_sess['autostart']) {
            if ($_sess['type'] == 'native') {
                $_s = new \GF\Sessions\NativeSession($_sess['name'], $_sess['lifetime'],
                        $_sess['path'], $_sess['domain'], $_sess['secure']);
            } else if ($_sess['type'] == 'database') {
                $_s = new \GF\Sessions\DBSession($_sess['dbConnection'], $_sess['name'],
                        $_sess['dbTable'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
            }
            else{
                //TODO
                throw new Exception('No valid session',500);
            }
            $this->setSession($_s);
        }

        $this->frontController->dispatch();
    }

    public function setSession(\GF\Sessions\iSession $session) {
        $this->session = $session;
    }

    /**
     * 
     * @return \GF\Session\iSession
     */
    public function getSession() {
        return $this->session;
    }

    /**
     * 
     * @param type $connection
     * @return \PDO
     * @throws \Exception
     */
    public function getDBConnection($connection = 'default') {
        if (!$connection) {
            //TODO
            throw new \Exception('No connection identifier provided', 500);
        }
        if ($this->dbConnections[$connection]) {
            return $this->dbConnections[$connection];
        }
        $cnf = $this->getConfig()->database;
        if (!$cnf[$connection]) {
            //TODO
            throw new \Exception('No valid connection identificator is provided', 500);
        }
        $dbh = new \PDO($cnf[$connection]['connection_uri'], $cnf[$connection]['username'], $cnf[$connection]['pass'], $cnf[$connection]['pdo_options']);
        $this->dbConnections[$connection] = $dbh;
        return $dbh;
    }

    /**
     * @return App|null
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new App();
        }
        return self::$instance;
    }
    
    public function __destruct() {
        if($this->session !=null){
            $this->session->saveSession();
        }
    }

}
