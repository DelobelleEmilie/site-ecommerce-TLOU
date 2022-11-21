<?php


namespace App\Controller;

use App\Repository\CategoryRepository;

class CategoryController extends AbstractResourceController
{
    private $repository;

    #c'est le constructeur, c'est là qu'on récupère le repository
    public function __construct($router)
    {
        parent::__construct($router);
        $this->repository = new CategoryRepository();
    }

    #on récupère la catégorie qui correspond à l'id
    #passe a twig l'ID
    public function show($id)
    {
        $category = $this->repository->find($id);
        
        #demander au router de générer une url
        #demandes l'URL pour supprimer la catégorie
        $deleteUrl = $this->router->url('category#delete', [ 'id' => $id ]);

        #afficher du twig
        #on lui envoie la catégorie et l'URL de suppression en paramètre
        echo $this->twig->render(
            'category/detail.html.twig',
            [
                'category' => $category,
                'deleteUrl' => $deleteUrl
            ]
        );
    }

 
    public function showList()
    {
        #on récupère toutes les catégories depuis la base de données
        $categories = $this->repository->findAll();

        $categories = array_map(
            function ($category) {
                $category['link'] = $this->router->url('category#show', ['id' => $category['id']]);
                return $category;
            },
            $categories
        );

        echo $this->twig->render(
            'category/list.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    public function edit()
    {
        // TODO: Implement edit() method.
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        $listUrl = $this->router->url('category#showList');

        header('Location: ' . $listUrl);
        die();
    }
}