<?php


namespace App\Controller;

use App\Repository\CategoryRepository;

class CategoryController extends AbstractResourceController
{
    private CategoryRepository $repository;

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
        $entity = $this->repository->find($id);
        
        #demander au router de générer une url
        #demandes l'URL pour supprimer la catégorie
        $editUrl = $this->url('category#edit', [ 'id' => $id ]);
        $deleteUrl = $this->url('category#delete', [ 'id' => $id ]);
        $listUrl = $this->url('category#showList');

        #afficher du twig
        #on lui envoie la catégorie et l'URL de suppression en paramètre
        $this->render(
            'category/detail.html.twig',
            [
                'entity' => $entity,
                'listUrl' => $listUrl,
                'editUrl' => $editUrl,
                'deleteUrl' => $deleteUrl
            ]
        );
    }

 
    public function showList()
    {
        #on récupère toutes les catégories depuis la base de données
        $entities = $this->repository->findAll();

        #array_map, c'est une function qui prend 2 paramètres
        $entities = array_map(
            #tableau qui ajouter un lien (link) à ma catégorie
            function ($entity) {
                $entity['link'] = $this->url('category#show', ['id' => $entity['id']]);
                return $entity;
            },
            $entities
        );

        $addUrl = $this->url('category#create');

        #envoie toutes les catégories à twig
        $this->render(
            'category/list.html.twig',
            [
                'entities' => $entities,
                'addUrl' => $addUrl
            ]
        );
    }

    public function adminList()
    {
        #on récupère toutes les catégories depuis la base de données
        $entities = $this->repository->findAll();

        #array_map, c'est une function qui prend 2 paramètres
        $entities = array_map(
        #tableau qui ajouter un lien (link) à ma catégorie
            function ($entity) {
                $entity['show'] = $this->url('category#adminShow', ['id' => $entity['id']]);
                $entity['edit'] = $this->url('category#edit', ['id' => $entity['id']]);
                $entity['delete'] = $this->url('category#delete', ['id' => $entity['id']]);
                return $entity;
            },
            $entities
        );

        $addUrl = $this->url('category#create');

        #envoie toutes les catégories à twig
        $this->render(
            'admin/category/list.html.twig',
            [
                'entities' => $entities,
                'addUrl' => $addUrl
            ]
        );
    }

    public function edit($id = null)
    {
        // On a des données du formulaire, on enregistre en base
        if (isset($_POST['submit'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder à la catégorie créée ou modifiée
            $url = $this->url('category#show', ['id' => $resultId]);
            # Redirection vers la page de la catégorie
            $this->redirect($url);
        }

        $listUrl = $this->url('category#adminList');

        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $entity = $this->repository->find($id);
            $this->render('admin/category/form.html.twig',[
                'entity' => $entity,
                'listUrl' => $listUrl
            ]);
        }
        else { // CREATE
            $this->render('category/form.html.twig',[
                'listUrl' => $listUrl
            ]);
        }
    }

    #permet de supprimer une catégorie
    public function delete($id)
    {
        $this->repository->delete($id);

        #sert à rediriger vers /category
        #génère l'URL
        $listUrl = $this->url('category#showList');
        #redirige l'url
        $this->redirect($listUrl);
    }
}