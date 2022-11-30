<?php

#tout les élements se  connait ducoup pas besoin d'importer les fichiers
namespace App\Controller;

class LostpasswordController extends AbstractController
{
  #show() qui est publique = n'importe qui peut l'appeler
  # la fonction, elle affiche la page twig home.html.twig
  public function show() {
      $this->render('Lostpassword.html.twig', []);
  }
}
