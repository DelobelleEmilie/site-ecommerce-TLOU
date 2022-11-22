<?php


namespace App\Controller;

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
        $product = $this->repository->find($id);

        $deleteUrl = $this->router->url('product#delete', [ 'id' => $id ]);

        echo $this->twig->render(
            'product/detail.html.twig',
            [
                'product' => $product,
                'deleteUrl' => $deleteUrl
            ]
        );
    }

    public function showList()
    {
        $products = $this->repository->findAll();

        $products = array_map(
            function ($product) {
                $product['link'] = $this->router->url('product#show', ['id' => $product['id']]);
                return $product;
            },
            $products
        );

        echo $this->twig->render(
            'product/list.html.twig',
            [
                'products' => $products
            ]
        );
    }

    #on a des données de formulaire, on demande au repository de sauvegarder l'objet
    #Je récupère l'id à part, si j'ai pas d'ID je suis dans le cas d'une création, sinon dans le cas d'une mise à jour
    #on récupère le produit créé, pour après
    public function edit($id = null)
    {
    // On a des données du formulaire, on enregistre en base
        if (isset($_POST['btnAddProduct'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder au produit créé ou modifié
            $url = $this->router->url('product#show', ['id' => $resultId]);
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
    public function delete($id)
    {
        $this->repository->delete($id);

        $listUrl = $this->router->url('product#showList');

        header('Location: ' . $listUrl);
        die();
    }
}

