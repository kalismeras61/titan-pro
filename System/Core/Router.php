<?php
namespace Titan\Core;

class Router extends App
{
    protected $routes;
    protected $controller;
    protected $action;
    protected $params = [];

    public function __construct()
    {
        parent::__construct();

        $this->controller   = $this->config['default_controller'];
        $this->action       = $this->config['default_action'];
        $this->routes       = Import::Config('routes');

        $this->setController($this->url);

        $this->setAction($this->url);

        $this->setParams($this->url);

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    /**
     * Setting Controller
     * @param 	array $url
     * @return 	void
     */
    public function setController($url)
    {
        if(isset($url[0])) {
            $controller = $this->makeURL($url[0]);
            if(class_exists('\Titan\Controllers\\' . $controller)) {
                $this->controller = '\Titan\Controllers\\' . $controller;
                $this->controller = new $this->controller;
            } else {
                if(array_key_exists($controller, $this->routes)) {
                    $route = explode('/', $this->routes[$controller]);
                    $this->controller = '\Titan\Controllers\\' . $route[0];
                    $this->controller = new $this->controller;
                } else {
                    $data['code'] = 404;
                    $data['text'] = lang('Errors', 'missing_controller') . ': { ' . $controller . ' }';
                    Import::View('Errors/Error_404', $data);
                    die();
                }
            }
        } else {
            $this->controller = '\Titan\Controllers\\' . $this->controller;
            $this->controller = new $this->controller;
        }
    }

    /**
     * Setting Action
     * @param 	array $url
     * @return 	void
     */
    public function setAction($url)
    {
        if(isset($url[1])) {
            if($url[1] != 'index') {
                if(method_exists($this->controller, $url[1])) {
                    $this->action = $url[1];
                } else {
                    $data['code'] = 404;
                    $data['text'] = lang('Errors', 'missing_action') . ': { ' . $url[1] . ' }';
                    Import::View('Errors/Error_404', $data);
                    die();
                }
            }
            unset($this->url[1]);
        } else {
            if(isset($url[0])) {
                if (array_key_exists($this->makeURL($url[0]), $this->routes)) {
                    $route = explode('/', $this->routes[$this->makeURL($url[0])]);
                    if (isset($route[1])) {
                        if (method_exists($this->controller, $route[1])) {
                            $this->action = $route[1];
                        }
                    }
                }
            }
        }
        unset($this->url[0]);
    }

    /**
     * Setting Parameters
     * @param 	array $url
     * @return 	void
     */
    public function setParams($url)
    {
        $this->params = $url ? array_values($url) : [];
    }
}