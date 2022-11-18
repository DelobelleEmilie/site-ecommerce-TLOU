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

    public function add($id) {

    }

    public function removeOne($id) {

    }

    public function remove($id) {

    }
}