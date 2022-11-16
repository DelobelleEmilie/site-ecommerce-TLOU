<?php


namespace App\Core\Router;


use Exception;

class Router
{
    const ROUTES =  [
        'home' => "homeController",
        'about'=> "aboutController",
        'contact' => "contactController",
        'error'=> "errorController",
        'mentionslegales' => "mentionslegalesController",
        'pageconnexion'=> "pageconnexionController"
    ];

    private $url;
    private $routes = [];
    private $nameRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method) {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        if ($name) {
            $this->nameRoutes[$name] = $route;
        }
        elseif (is_string($callable)) {
            $this->nameRoutes[$callable] = $route;
        }

        return $route;
    }

    public function run() {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new Exception('No route matches this method.');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call($this);
            }
        }

        throw new Exception('No matching route.');
    }

    public function url($name, $params = []) {
        if (!isset($this->nameRoutes[$name])) {
            throw new Exception('No route matches this name.');
        }
        return $this->nameRoutes[$name]->getUrl($params);
    }
}