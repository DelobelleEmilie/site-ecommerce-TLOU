<?php


namespace App\Controller;

use App\Repository\CategoryRepository;

class TypeController extends AbstractResourceController
{
    private $repository;

    #c'est le constructeur, c'est là qu'on récupère le repository
    public function __construct($router)
    {
        parent::__construct($router);
        $this->repository = new TypeRepository();
    }

    #on récupère la catégorie qui correspond à l'id
    #passe a twig l'ID
    public function show($id)
    {
        $type = $this->repository->find($id);
        
        #demander au router de générer une url
        #demandes l'URL pour supprimer la catégorie
        $deleteUrl = $this->router->url('type#delete', [ 'id' => $id ]);

        #afficher du twig
        #on lui envoie la catégorie et l'URL de suppression en paramètre
        echo $this->twig->render(
            'type/detail.html.twig',
            [
                'category' => $type,
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
            function ($type) {
                $category['link'] = $this->router->url('type#show', ['id' => $type['id']]);
                return $type;
            },
            $type
        );

        #envoie toutes les catégories à twig
        echo $this->twig->render(
            'category/list.html.twig',
            [
                'type' => $type 
            ]
        );
    }
    
    public function edit($id = null)
    {
        // On a des données du formulaire, on enregistre en base
        if (isset($_POST['btnAddType'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder à la catégorie créée ou modifiée
            $url = $this->router->url('type#show', ['id' => $resultId]);
            # Redirection vers la page de la catégorie
            header('Location: ' . $url);
            die();
        }
    
        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $category = $this->repository->find($id);
            echo $this->twig->render('type/form.html.twig',[
                'type' => $type
            ]);
        }
        else { // CREATE
            echo $this->twig->render('type/form.html.twig',[]);
        }
    }

    #permet de supprimer une catégorie
    public function delete($id)
    {
        $this->repository->delete($id);

        #sert à rediriger vers /category
        #génère l'URL
        $listUrl = $this->router->url('type#showList');
        #redirige l'url
        header('Location: ' . $listUrl);
        die();
    }
}
