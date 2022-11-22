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

        #array_map, c'est une function qui prend 2 paramètres
        $categories = array_map(
            #tableau qui ajouter un lien (link) à ma catégorie
            function ($category) {
                $category['link'] = $this->router->url('category#show', ['id' => $category['id']]);
                return $category;
            },
            $categories
        );

        #envoie toutes les catégories à twig
        echo $this->twig->render(
            'category/list.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    public function edit($id)
    {
        // On a des données du formulaire, on enregistre en base
        if (isset($_POST['btnAddCategory'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder au produit créé ou modifié
            $url = $this->router->url('category#show', ['id' => $resultId]);
            # Redirection vers la page du produit
            header('Location: ' . $url);
            die();
        }
    
        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $product = $this->repository->find($id);
            echo $this->twig->render('product/form.html.twig',[
                'product' => $product
            ]);
        }
        else { // CREATE
            echo $this->twig->render('product/form.html.twig',[]);
        }
    }

    #spermet de supprimer une catégorie
    public function delete($id)
    {
        $this->repository->delete($id);

        #sert à rediriger vers /category
        #génère l'URL
        $listUrl = $this->router->url('category#showList');
        #redirige l'url
        header('Location: ' . $listUrl);
        die();
    }
}