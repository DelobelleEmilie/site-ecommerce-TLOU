<?php


namespace App\Core\Router;


class Route {

    private $callable;
    private $path;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match($url) {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    private function paramMatch($match) {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }

        return '([^/]+)';
    }

    public function with($param, $regex) {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function call($router) {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);

            $controllerName = 'App\\Controller\\' . ucfirst($params[0]) . 'Controller';

            $controller = new $controllerName($router);

            $action = $params[1];

            return call_user_func_array([$controller, $action], $this->matches);
        }
        else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    #On prend le chemin de la route

    public function getUrl($params) {
        $path = '/' . $this->path;
        foreach ($params as $k => $v) {
            #on remplace les paramètres par des vraies valeurs"
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}