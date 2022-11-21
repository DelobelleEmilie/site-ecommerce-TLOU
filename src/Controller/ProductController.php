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

    public function edit()
    {
        if (isset($_POST)) {
            var_dump($_POST);
        }
        echo $this->twig->render('product/form.html.twig',[]);
    }
    public function delete($id)
    {
        $this->repository->delete($id);

        $listUrl = $this->router->url('product#showList');

        header('Location: ' . $listUrl);
        die();
    }
}
