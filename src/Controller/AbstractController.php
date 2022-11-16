<?php


namespace App\Controller;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController {

    protected $router;
    protected $twig;

    public function __construct($router)
    {
        // Tous les controllers ont accès au router
        $this->router = $router;

        // Tous les controllers ont accès à twig
        $loader = new FilesystemLoader('../template');
        $this->twig = new Environment($loader, []);
    }
}