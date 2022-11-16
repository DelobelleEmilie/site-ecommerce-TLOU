<?php

namespace App\Controller;

class HomeController extends AbstractController
{
  public function show() {
    echo $this->twig->render('home.html.twig', []);
  }
}
