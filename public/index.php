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
$router->get('/', 'home#show');


//page de contact
$router->get('/contact', 'contact#show');
$router->post('/contact', 'contact#show');

$router->get('/messageenvoie', 'messageenvoie#show');

//panier
$router->get('/cart', 'cart#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);
$router->post('/cart', 'cart#show')->roles(['ROLE_ADMIN', 'ROLE_USER']);

//créer la route.
//Id doit être un entier, et quantity aussi
$router->post('/cart/:id/:quantity', 'cart#add')->with('id', '[1-9][0-9]*')->with('quantity', '[1-9][0-9]*') ->roles(['ROLE_ADMIN', 'ROLE_USER']);

#region user
$router->get('/connexion','user#login');
$router->post('/connexion','user#login');

//page deconnexion
$router->get('/logout','user#logout');

//page d'inscription
$router->get('/inscription','user#register');
$router->post('/inscription','user#register');

//page de profil
$router->get('/profile', 'user#profile')->roles(['ROLE_USER']);
$router->post('/profile', 'user#profile')->roles(['ROLE_USER']);

//page password lost
$router->get('/lostpassword', 'user#lostpassword');
$router->post('/lostpassword', 'user#lostpassword');

# Affiche la liste des utilisateurs
$router->get('/user', 'user#showList')->roles(['ROLE_ADMIN']);
$router->get('/admin/user', 'user#adminList')->roles(['ROLE_ADMIN']);

# Affiche le category :id
$router->get('/admin/user/:id', 'user#show')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/admin/user/:id', 'user#adminShow')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);

# Affiche un formulaire vide
$router->get('/admin/user/create', 'user#edit', 'user#create')->roles(['ROLE_ADMIN']);

# Enregistre le nouveau category
$router->post('/admin/user/create', 'user#edit')->roles(['ROLE_ADMIN']);
$router->get('/admin/user/:id/edit', 'user#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->post('/admin/user/:id/edit', 'user#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/admin/user/:id/delete', 'user#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/admin/user/:id/toggleActive', 'user#toggleActive')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

#region category
# Affiche la liste des category
$router->get('/admin/category', 'category#adminList')->roles(['ROLE_ADMIN']);

# Affiche le category :id
$router->get('/admin/category/:id', 'category#adminShow')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);

# Affiche un formulaire vide
$router->get('/admin/category/create', 'category#edit', 'category#create')->roles(['ROLE_ADMIN']);

# Enregistre le nouveau category
$router->post('/admin/category/create', 'category#edit');
$router->get('/admin/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->post('/admin/category/:id/edit', 'category#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/admin/category/:id/delete', 'category#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

#region product
# Affiche la liste des produits
$router->get('/product', 'product#showList');
# Affiche le produit :id
$router->get('/product/:id', 'product#show')->with('id', '[1-9][0-9]*');
$router->get('/admin/product/:id', 'product#adminShow')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
$router->get('/admin/product', 'product#adminList')->roles(['ROLE_ADMIN']);
# Affiche un formulaire vide
$router->get('/admin/product/create', 'product#edit', 'product#create')->roles(['ROLE_ADMIN']);
# Enregistre le nouveau produit
$router->post('/admin/product/create', 'product#edit')->roles(['ROLE_ADMIN']);
# Affiche un formulaire avec les données du produit :id à modifier
$router->get('/admin/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
# Enregistre les modifications sur le produit
$router->post('/admin/product/:id/edit', 'product#edit')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
# Supprime le produit :id
$router->get('/admin/product/:id/delete', 'product#delete')->with('id', '[1-9][0-9]*')->roles(['ROLE_ADMIN']);
#endregion

#region type
$router->get('/type', 'type#showList')->roles(['ROLE_ADMIN']);
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

