<?php


namespace App\Controller;

use App\Repository\TypeRepository;

class TypeController extends AbstractResourceController
{
    private TypeRepository $repository;

    #c'est le constructeur, c'est là qu'on récupère le repository
    public function __construct($router)
    {
        parent::__construct($router);
        $this->repository = new TypeRepository();
    }

    #on récupère le type qui correspond à l'id
    #passe a twig l'ID
    public function show($id)
    {
        $entity = $this->repository->find($id);
        
        #demander au router de générer une url
        #demandes l'URL pour modifier et supprimer le type
        $editUrl = $this->url('type#edit', [ 'id' => $id ]);
        $deleteUrl = $this->url('type#delete', [ 'id' => $id ]);
        $listUrl = $this->url('type#showList');

        #afficher du twig
        #on lui envoie le type et les URL de modification et suppression en paramètre
        $this->render(
            'type/detail.html.twig',
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
                $entity['link'] = $this->url('type#show', ['id' => $entity['id']]);
                return $entity;
            },
            $entities
        );

        $addUrl = $this->url('type#create');

        #envoie toutes les catégories à twig
        $this->render(
            'type/list.html.twig',
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
            $url = $this->url('type#show', ['id' => $resultId]);
            # Redirection vers la page de la catégorie
            $this->redirect($url);
        }

        $listUrl = $this->url('type#showList');
    
        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $entity = $this->repository->find($id);
            $this->render('type/form.html.twig',[
                'entity' => $entity,
                'listUrl' => $listUrl
            ]);
        }
        else { // CREATE
            $this->render('type/form.html.twig',[
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
        $listUrl = $this->url('type#showList');
        #redirige l'url
        $this->redirect($listUrl);
    }
}
