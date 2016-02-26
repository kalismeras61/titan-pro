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

        if($this->run() === false) {
            $this->setController($this->url);

            $this->setAction($this->url);

            $this->setParams($this->url);
        }

        // Composer Autoload
        if($this->config['composer'] === true) {
            Import::File('vendor/autoload.php');
        }

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    /**
     * Execute the Router
     * @return boolean
     */
    private function run()
    {
        $matched = 0;
        $url = ltrim(str_replace(BASE_DIR,'',$_SERVER['REQUEST_URI']), '/');

        foreach($this->routes as $key => $value) {
            $key = '/^' . str_replace('/', '\/', $key) . '$/';

            if(preg_match($key, $url)) {
                $matched++;
                preg_match_all($key, $url, $matches);
                array_shift($matches);
                $target = explode('/', $value);

                if(class_exists('\Titan\Controllers\\' . ucfirst($target[0]))) {
                    $this->controller = '\Titan\Controllers\\' . ucfirst($target[0]);
                    $this->controller = new $this->controller;
                } else {
                    $data['code'] = 404;
                    $data['text'] = lang('Errors', 'missing_controller') . ': { ' . $target[0] . ' }';
                    Import::View('Errors/Error_404', $data);
                    die();
                }

                $this->action = $target[1];

                unset($target[0]);
                unset($target[1]);
                sort($target);

                foreach($matches as $indis => $match) {
                    $target[$indis] = $match[0];
                }

                $this->params = $target ? array_values($target) : [];
            }
        }

        if($matched > 0)
            return true;
        else
            return false;
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
                $data['code'] = 404;
                $data['text'] = lang('Errors', 'missing_controller') . ': { ' . $controller . ' }';
                Import::View('Errors/Error_404', $data);
                die();
            }
            unset($this->url[0]);
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
        }
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