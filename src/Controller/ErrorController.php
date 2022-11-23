<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    public function __construct()
    {
        parent::__construct(null);
    }

    // Erreur standard / par défaut
    function show($message = null) {
        $this->render(
            'error/error.html.twig',
            isset($message) ? ['message' => $message] : []
        );
    }

    // Erreur provenant du router (page non trouvée, méthode non autorisée...)
    function router($message = null) {
        $this->render(
            'error/router.html.twig',
            ['message' => isset($message) ? $message : null]
        );
    }
}