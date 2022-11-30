<?php


namespace App\Controller;


class ContactController extends AbstractController
{
    #show() qui est publique = n'importe qui peut l'appeler
    # la fonction, elle affiche la page twig home.html.twig
    #Si confirm vaut vrai, alors la page twig affiche le message de confirmation
    public function show() {

        if (!empty($_POST))
        {
            $confirm = true;
        }

        $this->render('contact.html.twig', [
            'confirm' => isset($confirm) ? $confirm : false
        ]);
    }
}