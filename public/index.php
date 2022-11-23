<?php

require_once '../vendor/autoload.php';

#importe les fichiers
use App\Controller\ErrorController;
use App\Core\Router\RouterException;
use App\Core\Router\Router;

//session_start();

#crée un nouveau Router avec en paramètre la variable url
$router = new Router(isset($_GET['url']) ? $_GET['url'] : '');



#fonction router recuper l'url qui affiche la page twig
$router->get('/', 'home#show');

$router->get('/contact', 'contact#show');

$router->get('/connexion','connexion#show');
$router->post('/connexion','connexion#show');

$router->get('/inscription','inscription#show');
$router->post('/inscription','inscription#show');



// Category
# Affiche la liste des category
$router->get('/category', 'category#showList');

# Affiche le category :id
$router->get('/category/:id', 'category#show')->with('id', '[1-9][0-9]*');

# Affiche un formulaire vide
$router->get('/category/create', 'category#edit', 'category#create');
# Enregistre le nouveau category
$router->post('/category/create', 'category#edit');

$router->get('/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*');

$router->post('/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*');

$router->get('/category/:id/delete', 'category#delete')->with('id', '[1-9][0-9]*');

# Affiche la liste des produits
$router->get('/product', 'product#showList');

# Affiche le produit :id
$router->get('/product/:id', 'product#show')->with('id', '[1-9][0-9]*');

# Affiche un formulaire vide
$router->get('/product/create', 'product#edit', 'product#create');
# Enregistre le nouveau produit
$router->post('/product/create', 'product#edit');

# Affiche un formulaire avec les données du produit :id à modifier
$router->get('/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*');
# Enregistre les modifications sur le produit
$router->post('/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*');

# Supprime le produit :id
$router->get('/product/:id/delete', 'product#delete')->with('id', '[1-9][0-9]*');

// Type
$router->get('/type', 'type#showList');
$router->get('/type/:id', 'type#show')->with('id', '[1-9][0-9]*');
$router->get('/type/create', 'type#edit', 'type#create');
$router->post('/type/create', 'type#edit');
$router->get('/type/:id/edit', 'type#edit')->with('id', '[1-9][0-9]*');
$router->post('/type/:id/edit', 'type#edit')->with('id', '[1-9][0-9]*');
$router->get('/type/:id/delete', 'type#delete')->with('id', '[1-9][0-9]*');

    # fonction qui va comparer l'url demandée, et toutes les adresses enregistrées
    #Pour appeler la bonne action, ou générer une Exception
try {
  
    $router->run();
}

#gérer les exception du router
catch (RouterException $e) {
    $controller = new ErrorController();
    $controller->router($e->getMessage());
}
# gérer le reste
catch (Exception $e) {
    $controller = new ErrorController();
    $controller->show($e->getMessage());
}

