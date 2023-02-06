<?php


namespace App\Controller;


class CartController extends AbstractController
{
    public function __construct($router)
    {
        parent::__construct($router);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function show()
    {
        $this->render(
            'cart/show.html.twig',
            [
                'data' => json_encode($_SESSION['cart'])
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