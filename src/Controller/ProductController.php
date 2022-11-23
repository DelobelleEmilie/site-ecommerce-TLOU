<?php


namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;
use App\Repository\ProductRepository;

class ProductController extends AbstractResourceController
{
    private $repository;

    public function __construct($router)
    {
        parent::__construct($router);
        $this->repository = new ProductRepository();
    }

    public function show($id)
    {
        $entity = $this->repository->find($id);

        $editUrl = $this->router->url('product#edit', [ 'id' => $id ]);
        $deleteUrl = $this->router->url('product#delete', [ 'id' => $id ]);
        $listUrl = $this->router->url('product#showList');

        echo $this->twig->render(
            'product/detail.html.twig',
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
        $entities = $this->repository->findAll();

        $entities = array_map(
            function ($entity) {
                $entity['link'] = $this->router->url('product#show', ['id' => $entity['id']]);
                return $entity;
            },
            $entities
        );

        $addUrl = $this->router->url('product#create');

        echo $this->twig->render(
            'product/list.html.twig',
            [
                'entities' => $entities,
                'addUrl' => $addUrl
            ]
        );
    }

    #on a des données de formulaire, on demande au repository de sauvegarder l'objet
    #Je récupère l'id à part, si j'ai pas d'ID je suis dans le cas d'une création, sinon dans le cas d'une mise à jour
    #on récupère le produit créé, pour après
    public function edit($id = null)
    {
    // On a des données du formulaire, on enregistre en base
        if (isset($_POST['submit'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder au produit créé ou modifié
            $url = $this->router->url('product#show', ['id' => $resultId]);
            # Redirection vers la page du produit
            $this->redirect($url);
        }

        $listUrl = $this->router->url('product#showList');

        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $typeRepository = new TypeRepository();
        $types = $typeRepository->findAll();

        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $entity = $this->repository->find($id);
            echo $this->twig->render('product/form.html.twig',[
                'entity' => $entity,
                'categories' => $categories,
                'types' => $types,
                'listUrl' => $listUrl
            ]);
        }
        else { // CREATE
            echo $this->twig->render('product/form.html.twig',[
                'categories' => $categories,
                'types' => $types,
                'listUrl' => $listUrl
            ]);
        }
    }
    public function delete($id)
    {
        $this->repository->delete($id);

        $listUrl = $this->router->url('product#showList');

        $this->redirect($listUrl);
    }
}

