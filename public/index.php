<?php

require_once '../vendor/autoload.php';

use App\Controller\ErrorController;
use App\Core\Router\RouterException;
use App\Core\Router\Router;

//session_start();

$router = new Router(isset($_GET['url']) ? $_GET['url'] : '');

var_dump($_GET['url']);

$router->get('/', function () { echo "<h1>Home</h1>"; });
//$router->get('/', 'home#show');

// Category
$router->get('/category', function () { echo "<h1>Liste des catégories</h1>"; });
//$router->get('/category', 'category#showList');
$router->get('/category/:id', function ($id) { echo "<h1>Catégorie : $id</h1>"; })->with('id', '[1-9][0-9]*');
//$router->get('/category/:id', 'category#show')->with('id', '[1-9][0-9]*');
$router->get('/category/:id/delete', function ($id) { echo "<h1>Supprime la catégorie : $id</h1>"; })->with('id', '[1-9][0-9]*');
//$router->get('/category/:id/delete', 'category#delete')->with('id', '[1-9][0-9]*');

// Product
$router->get('/product', function () { echo "<h1>Liste des produits</h1>"; });
//$router->get('/product', 'product#showList');
$router->get('/product/:id', function ($id) { echo "<h1>Produit : $id</h1>"; })->with('id', '[1-9][0-9]*');
//$router->get('/product/:id', 'product#show')->with('id', '[1-9][0-9]*');
$router->get('/product/:id/delete', function ($id) { echo "<h1>Supprime le produit : $id</h1>"; })->with('id', '[1-9][0-9]*');
//$router->get('/product/:id/delete', 'product#delete')->with('id', '[1-9][0-9]*');


try {
    $router->run();
}
catch (RouterException $e) {
    $controller = new ErrorController();
    $controller->router($e->getMessage());
}
catch (Exception $e) {
    $controller = new ErrorController();
    $controller->show($e->getMessage());
}

