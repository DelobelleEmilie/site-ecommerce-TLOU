<?php


namespace App\Controller;


use App\Repository\ProductRepository;

class CartController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct($router)
    {
        parent::__construct($router);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $this->productRepository = new ProductRepository();
    }

    public function show()
    {
        $cart = $_SESSION['cart'];
        $products = $this->productRepository->findAll();

        $data = [];

        foreach ($cart as $id => $quantity) {
            foreach ($products as $product) {
                if ($product['id'] == $id) {
                    $product['quantity'] = $quantity;
                    $product['total'] = $quantity * ($product['price'] ?? 0);
                    $data[] = $product;
                    break;
                }
            }
        }

        $this->render(
            'cart/show.html.twig',
            [
                'products' => $data
            ]
        );
    }

    public function add($id, $quantity = 1) {
        $cart = $_SESSION['cart'];
        if(isset($cart[$id])) {
            $cart[$id] = $cart[$id] + $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        $_SESSION['cart'] = $cart;

        $url = $this->url('cart#show');
        $this->redirect($url);
    }

    public function removeOne($id) {

    }

    public function remove($id) {

    }
}