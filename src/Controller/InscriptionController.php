<?php

namespace App\Controller;

class InscriptionController extends AbstractController
{
  public function show() {
    echo $this->twig->render('inscription.html.twig', []);
  }
}
