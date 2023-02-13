<?php

require_once '../vendor/autoload.php';

#importe les fichiers
use App\Controller\ErrorController;
use App\Core\Router\RouterException;
use App\Core\Router\Router;

session_start();

#crée un nouveau Router avec en paramètre la variable url
$router = new Router(isset($_GET['url']) ? $_GET['url'] : '');

#fonction router recuper l'url qui affiche la page twig
$router->get('/', 'home#show' ) ->roles(['ROLE_ADMIN', 'ROLE_USER']);;


//page de contact
$router->get('/contact', 'contact#show') ->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/contact', 'contact#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);;

$router->get('/messageenvoie', 'messageenvoie#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);;

//panier
$router->get('/cart', 'cart#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/cart', 'cart#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);

//créer la route.
//Id doit être un entier, et quantity aussi
$router->post('/cart/:id/:quantity', 'cart#add')->with('id', '[1-9][0-9]*')->with('quantity', '[1-9][0-9]*') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

#region user
$router->get('/connexion','user#login') ->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/connexion','user#login') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

//page deconnexion
$router->get('/logout','user#logout')->roles(['ROLE_ADMIN', 'ROLE_USER']) ;

//page d'inscription
$router->get('/inscription','user#register') ->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/inscription','user#register') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

//page de profil
$router->get('/profile', 'user#profile') ->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/profile', 'user#profile') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

//page password lost
$router->get('/lostpassword', 'user#lostpassword') ->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/lostpassword', 'user#lostpassword') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

# Affiche la liste des utilisateurs
$router->get('/user', 'user#showList') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

# Affiche le category :id
$router->get('/user/:id', 'user#show')->with('id', '[1-9][0-9]*') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

# Affiche un formulaire vide
$router->get('/user/create', 'user#edit', 'user#create') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

# Enregistre le nouveau category
$router->post('/user/create', 'user#edit');
$router->get('/user/:id/edit', 'user#edit')->with('id', '[1-9][0-9]*') ->roles(['ROLE_ADMIN']);
$router->post('/user/:id/edit', 'user#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/user/:id/delete', 'user#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

#region category
# Affiche la liste des category
$router->get('/category', 'category#showList')->roles(['ROLE_ADMIN']);

# Affiche le category :id
$router->get('/category/:id', 'category#show')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);

# Affiche un formulaire vide
$router->get('/category/create', 'category#edit', 'category#create')->roles(['ROLE_ADMIN']);

# Enregistre le nouveau category
$router->post('/category/create', 'category#edit');
$router->get('/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->post('/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/category/:id/delete', 'category#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

#region product
# Affiche la liste des produits
$router->get('/product', 'product#showList')->roles(['ROLE_ADMIN']);
# Affiche le produit :id
$router->get('/product/:id', 'product#show')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
# Affiche un formulaire vide
$router->get('/product/create', 'product#edit', 'product#create')->roles(['ROLE_ADMIN']);
# Enregistre le nouveau produit
$router->post('/product/create', 'product#edit')->roles(['ROLE_ADMIN']);
# Affiche un formulaire avec les données du produit :id à modifier
$router->get('/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
# Enregistre les modifications sur le produit
$router->post('/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
# Supprime le produit :id
$router->get('/product/:id/delete', 'product#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);;
#endregion

#region type
$router->get('/type', 'type#showList');
$router->get('/type/:id', 'type#show')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/type/create', 'type#edit', 'type#create')->roles(['ROLE_ADMIN']);
$router->post('/type/create', 'type#edit')->roles(['ROLE_ADMIN']);
$router->get('/type/:id/edit', 'type#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->post('/type/:id/edit', 'type#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/type/:id/delete', 'type#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

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

