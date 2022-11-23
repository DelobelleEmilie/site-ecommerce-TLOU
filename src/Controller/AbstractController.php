<?php


namespace App\Controller;


use App\Core\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController {

    private Router $router;
    private Environment $twig;

    public function __construct(Router $router)
    {
        // Tous les controllers ont accès au router
        $this->router = $router;

        // Tous les controllers ont accès à twig
        $loader = new FilesystemLoader('../template');
        $this->twig = new Environment($loader, []);
    }

    protected function render(string $page, ?array $params) {

        $navigation = [];

        $navigation['Catégories'] = $this->url('category#showList');
        $navigation['Produits'] = $this->url('product#showList');
        $navigation['Goodies'] = $this->url('goodies#showList');
        $navigation['Jeux'] = $this->url('jeux#showList');
        $navigation['Contact'] = $this->url('contact#show');
        # Ajout de la navigation à tous les pages
        $params = array_merge($params, ['navigation' => $navigation]);

        try {
            echo $this->twig->render(
                $page,
                $params
            );
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function url(string $name, array $params = []) {
        try {
            return $this->router->url($name, $params);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    protected function redirect($to) {
        header('Location: ' . $to);
        die();
    }
}