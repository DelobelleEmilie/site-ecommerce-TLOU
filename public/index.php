<?php

require_once '../vendor/autoload.php';

$router = new App\Core\Router\Router($_GET['url']);

$router->get('/', 'home#show');
$router->get('/category', 'category#show');

$database = new App\Core\Database();
$DBConnexion = $database->getConnection();

//if (gettype($DBConnexion) == "string") {
//    $controller = new \App\Controller\ErrorController($router);
//    $controller->show($DBConnexion);
//
//    /* stop l'exécution du programme */
//    die();
//}

$router->run();
