<?php


namespace App\Controller;


class CategoryController extends ResourceController
{
    public function show()
    {
        echo $this->twig->render('category.html.twig', []);
    }
}