<?php

#tout les élements se  connait ducoup pas besoin d'importer les fichiers
namespace App\Controller;

class ContactController extends AbstractController
{
  #show() qui est publique = n'importe qui peut l'appeler
  # la fonction, elle affiche la page twig home.html.twig
  public function show() {
    echo $this->twig->render('contact.html.twig', []);
  }
}
