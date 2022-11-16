<?php


function initRouter($routes)
{
        if (isset($_GET['page']))
        {
                $page = $_GET['page'];
        } else
        {
                $page = 'home';
        }




        if (isset($routes[$page])) 
        {
                $route = $routes[$page];
        } else 
        {
                $route = $routes['error'];
        }
        $controller = ucfirst($route);
        require_once 'controller/' .$controller.'.php';

        return $controller;
}


