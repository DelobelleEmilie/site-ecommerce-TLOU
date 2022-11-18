<?php


namespace App\Controller;

use App\Repository\CategoryRepository;

class CategoryController extends AbstractResourceController
{
    private $repository;

    public function __construct($router)
    {
        parent::__construct($router);
        $this->repository = new CategoryRepository();
    }

    public function show($id)
    {
        $category = $this->repository->find($id);

        $deleteUrl = $this->router->url('category#delete', [ 'id' => $id ]);

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