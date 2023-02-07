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


    function show() {
        $cart = $_SESSION['cart']; // tableau 'id' => 'quantity'
        $product = $this->productRepository->findAll();


        $data =
            foreach ($cart as $id => $quantity) {
                foreach ($product as $product) {
                    if ($product['id'] == $id) {
                        $product['quantity'] = $quantity;
                        $product['total'] = $quantity * ($product['price'] ?? 0);
                        $data[] = $product;
                        break;
                    }
                }
            }

  $this->render(
      'cart/show.html.twig'
      [
      'data' => $data;
    ]
  )
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