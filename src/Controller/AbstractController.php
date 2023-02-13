<?php


namespace App\Controller;


use App\Core\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Core\Security\AuthenticationManager;

abstract class AbstractController {

    private ?Router $router;
    protected Environment $twig;
    protected AuthenticationManager $authManager;

    public function __construct(?Router $router = null)
    {
        // Tous les controllers ont accès au router
        $this->router = $router;

        // Tous les controllers ont accès à twig
        $loader = new FilesystemLoader('../template');
        $this->twig = new Environment($loader, []);

        $this->authManager = new AuthenticationManager();
    }

    protected function render(string $page, ?array $params) {

        $navigation = [];

        $navigation['Produits'] = $this->url('product#showList');
        $navigation['Goodies'] =
        [
            ['label' => 'Vaiselle', 'url' => $this->url('Goodies#showList', ['category', 'vaiselle'])],
            ['label' => 'Figurine', 'url' => $this->url('Goodies#showList', ['category', 'figurine'])],
            ['label' => 'Accesoires', 'url' => $this->url('Goodies#showList', ['category', 'accesoire'])],
        ];

        $navigation['Jeux'] = [
            ['label' => 'Jeux PS4', 'url' => $this->url('jeux#showList', ['category', 'ps4'])],
            ['label' => 'Jeux PS5', 'url' => $this->url('jeux#showList', ['category', 'ps5'])],
        ];
        $navigation['Contact'] = $this->url('contact#show');

        $user = $this->authManager->getUser();
        $roles = $this->authManager->getRoles();

        if (in_array('ROLE_ADMIN', $roles))
        {
            $navigation['Administration'] = [
                ['label' => 'Produits', 'url' => $this->url('product#adminList')],
                ['label' => 'Catégories', 'url' => $this->url('category#adminList')],
                ['label' => 'Utilisateurs', 'url' => $this->url('user#adminList')],
            ];
        }

        # Ajout de la navigation à tous les pages
        $params = array_merge($params, ['navigation' => $navigation]);
        $params = array_merge($params, ['user' => $user]);
//        ajouter la navigation en plus des parametres twig de base
        $params = array_merge($params, ['cartUrl' => $this->url('cart#show')]);
        $params = array_merge($params, ['logoutUrl' => $this->url('user#logout')]);

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
        if (!isset($this->router)) { return null; }
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