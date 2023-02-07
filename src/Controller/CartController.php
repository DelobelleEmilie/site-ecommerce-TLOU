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
//        boucle sur chaque case du tableau, et récupère la clé (key) id et la valeur (value) quantity
    //acces, pour chaque élément de mon panier
        foreach ($cart as $id => $quantity) {
//            Pour chaque élément de mon panier, je vais parcourir tous les produits
//Pour chercher celui qui correspond à l'id
            foreach ($products as $product) {
//                Si l'id de mon produit est égal à l'id de mon élément de panier, alors bingo c'est le bon
                if ($product['id'] == $id) {
                    #quand j'ai trouvé mon produit, je lui affecte la quantité (un peu comme on ajoutait la catégorie dans le cours)
                    #nsert le nouveau produit dans $data
                    $product['quantity'] = $quantity;
//                    ?? si ce qu'il y a avant est null prend ce qu'il y a après
//                    si par malheur l'attribut 'price' de mon produit est manquant, j'utilise 0 en valeur par défaut
                    $product['total'] = $quantity * ($product['price'] ?? 0);
                    #$data est un tableau de produits, qui portent en plus un attribut de quantité
                    $data[] = $product;
                    # stoppe la seconde boucle (celle des produits) parce qu'on a fini de chercher le bon produit
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