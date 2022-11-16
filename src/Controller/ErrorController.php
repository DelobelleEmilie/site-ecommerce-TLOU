<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    function show($message = null) {
        echo $this->twig->render(
            'error.html.twig',
            isset($message) ? ['message' => $message] : []
        );
    }
}