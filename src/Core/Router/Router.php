<?php

#on déclares toutes les routes que tu veux, et il les enregistre
#Ensuite, il compare avec l'url demandée, et si il trouve une correspondance, il execute l'action




#tout les élements se  connait ducoup pas besoin d'importer les fichiers
namespace App\Core\Router;

class Router
{
    #attributs privés, on va y stocker l'url
    private $url;
        #attributs privés, on va y stocker les routes
    private $routes = [];
        #attributs privés, on va y stocker les noms de routes
    private $nameRoutes = [];

    #fonction public qui permet de construit le router
    public function __construct($url)
    {
        #met l'adresse demandée par le navigateur en paramètre
        $this->url = $url;
    }

    
    #fonction public qui permet de construit le router
    public function get($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'POST');
    }

    #La fonction add est privée (il n'y a que router qui peut l'utiliser lui-même)
    #Elle prend le chemin, l'action, un nom et une méthode (POST ou GET)
    private function add($path, $callable, $name, $method) {
        #elle crée une nouvelle Route, pour l'ajouter au routes connues par Router
        #$path: L'adresse, $callable: l'action
        $route = new Route($path, $callable);
        #enregistre la route
        #$this->routes, c'est l'attribut $routes qu'on a déclaré
        $this->routes[$method][] = $route;
       
        if ($name) {
             # si on a mis un nom à la route, on l'enregistre aussi dans les routes nommées $nameRoutes
            $this->nameRoutes[$name] = $route;
        }
        #is_string(variable) renvoit true si variable est du texte
        elseif (is_string($callable)) {
            #nameRoutes, c'est un tableau
            $this->nameRoutes[$callable] = $route;
        }
        # renvoit la route
        return $route;
    }

    public function run() {
        #vérifie si on a des routes qui correspondent à la méthode (POST ou GET) de la demande
         #Si on ne définit aucune route en POST, et que la demande est en POST,  on lève une routerexception direct
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('No route matches this method.');

        #Si on trouve, alors on déclenche l'action
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
        }
        #Si on a une demande en GET, on parcours toutes les routes en GET, et on cherche une correspondance dans l'url.
            if ($route->match($this->url)) {
                
        #on déclenche l'action
                return $route->call($this);
            }
        }
        #Si même en cherchant bien, on ne trouve pas de correspondance, on lève une routerexception
        throw new RouterException('No matching route.');
    }

    #s'il n'y a rien à l'index $name
    #
    public function url($name, $params = []) {
        if (!isset($this->nameRoutes[$name])) {
            #Alors on lève une routerexception
            throw new RouterException('No route matches this name.');
        }
        #Mais si on trouve, avec on renvoie l'url générée avec les paramètres
        return $this->nameRoutes[$name]->getUrl($params);
    }
}