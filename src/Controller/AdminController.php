<?php

namespace App\Controller;
use App\Core\Router\Router;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
class AdminRepository extends AbstractController
{
    private AdminRepository $repository;
    function AdminCategoryAddController($twig, $db)
    {
        $status = null;
        $message = null;

        $form = [
            'label' => ''
        ];

        if (!empty($_POST))
        {
            $label = htmlspecialchars($_POST['label']);

            $form = [
                'label' => $label
            ];

            if (!isset($label) || strlen($label) < 3)
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                saveCategory($db, $label);

                header('location: /?page=adminCategoryList');
                die();
            }
        }

        echo $twig->render('admin/category/form.html.twig', [
            'form' => $form,
            'controller' => 'add',
            'status' => $status,
            'message' => $message
        ]);
    }

    function AdminCategoryDeleteController($twig, $db)
    {
        $id = $_GET['category'] ?? null;

        if (deleteOneCategory($db, $id)) {
            header('location: /?page=adminCategoryList');
            die();
        }

        echo $twig->render('admin/message.html.twig', [
            'status' => 'danger',
            'message' => 'Erreur lors de la suppression de la catégorie.',
        ]);
    }
    function AdminCategoryEditController($twig, $db)
    {
        $id = $_GET['category'] ?? null;

        $product = getOneCategory($db, $id);

        $status = null;
        $message = null;

        $form = [
            'label' => $product['label']
        ];

        if (!empty($_POST))
        {
            $label = htmlspecialchars($_POST['label']);

            $form = [
                'label' => $label
            ];

            if (!isset($label) || strlen($label) < 3)
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                updateOneCategory($db, $id, $label);

                header('location: /?page=adminCategoryList');
                die();
            }
        }

        echo $twig->render('admin/category/form.html.twig', [
            'form' => $form,
            'controller' => 'edit',
            'status' => $status,
            'message' => $message
        ]);
    }
    function AdminCategoryListController($twig, $db)
    {
        $categories = getallCategory($db);

        echo $twig->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
    function AdminPasswordCOntroller($twig)
    {
// Vérification de l'existence de la soumission du formulaire
        if (isset($_POST['newpassword'])) {

            // Récupération des valeurs des champs de mot de passe
            $password1 = $_POST['newpassword'];
            $password2 = $_POST['newpassword2'];

            // Vérification si les champs sont vides
            if (empty($password1) || empty($password2)) {
                echo 'Les champs de mot de passe ne peuvent pas être vides';
            } // Vérification si les mots de passe correspondent
            else if ($password1 !== $password2) {
                echo 'Les mots de passe ne correspondent pas';
            } // Traitement des données du formulaire si les mots de passe sont valides
            else {
                // Code pour traiter les données du formulaire, par exemple:
                // Mise à jour du mot de passe dans la base de données

                // Redirection vers la page principale
                header('Location: mainPage.php');
                // Affichage d'un message de succès
                echo 'Modification effectuée avec succès';
            }
        }
    }

    function AdminProductAddController($twig, $db)
    {
        $categories = getallCategory($db);

        $status = null;
        $message = null;

        $file_path = null;

        $form = [
            'label' => '',
            'description' => '',
            'price' => '',
            'idCategory' => ''
        ];

        if (!empty($_POST))
        {
            $label = htmlspecialchars($_POST['label']);
            $description = htmlspecialchars($_POST['description']);
            $price = htmlspecialchars($_POST['price']);
            $idCategory = htmlspecialchars($_POST['idCategory']);

            $form = [
                'label' => $label,
                'description' => $description,
                'price' => $price,
                'idCategory' => $idCategory
            ];

            if (!isset($label) || strlen($label) < 3
                || !isset($description) || strlen($description) < 3
                || !isset($price) || !isset($idCategory)
            )
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                if (isset($_FILES["image"])) {
                    $file_path = upload($_FILES["image"]);
                }

                saveProduct($db, $label, $description, $price, $idCategory, $file_path);

                header('location: /?page=adminProductList');
                die();
            }
        }

        echo $twig->render('admin/product/form.html.twig', [
            'form' => $form,
            'controller' => 'add',
            'categories' => $categories,
            'status' => $status,
            'message' => $message
        ]);
    }
    function AdminProductDeleteController($twig, $db)
    {
        $id = $_GET['product'] ?? null;

        if (deleteOneProduct($db, $id)) {
            header('location: /?page=adminProductList');
            die();
        }

        echo $twig->render('admin/message.html.twig', [
            'status' => 'danger',
            'message' => 'Erreur lors de la suppression du produit.',
        ]);
    }
    function AdminProductEditController($twig, $db)
    {
        $id = $_GET['product'] ?? null;

        $product = getOneProduct($db, $id);
        $categories = getallCategory($db);

        $status = null;
        $message = null;

        $file_path = null;

        $form = [
            'label' => $product['label'],
            'description' => $product['description'],
            'price' => $product['price'],
            'idCategory' => $product['idCategory']
        ];

        if (!empty($_POST))
        {
            $label = htmlspecialchars($_POST['label']);
            $description = htmlspecialchars($_POST['description']);
            $price = htmlspecialchars($_POST['price']);
            $idCategory = htmlspecialchars($_POST['idCategory']);

            $form = [
                'label' => $label,
                'description' => $description,
                'price' => $price,
                'idCategory' => $idCategory
            ];

            if (!isset($label) || strlen($label) < 3
                || !isset($description) || strlen($description) < 3
                || !isset($price) || !isset($idCategory)
            )
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                if (isset($_FILES["image"])) {
                    $file_path = upload($_FILES["image"]);
                }

                updateOneProduct($db, $id, $label, $description, $price, $idCategory, $file_path);

                header('location: /?page=adminProductList');
                die();
            }
        }

        echo $twig->render('admin/product/form.html.twig', [
            'form' => $form,
            'controller' => 'edit',
            'categories' => $categories,
            'status' => $status,
            'message' => $message
        ]);
    }
    function AdminProductListController($twig, $db)
    {
        $products = getAllProduct($db);
        $categories = getallCategory($db);

        $products = array_map(
            function ($product) use ($categories) {
                #Index du tableau
                $category_key = array_search(
                # permet d'accéder à l'idCategory du produit
                    $product['idCategory'],
                    # fabrique un tableau qui ne contient que les id
                    array_column($categories, 'id')
                );
                #ajouter categorie a produit
                $label = null;
                if ($category_key !== false) {
                    $label = $categories[$category_key]['label'];
                }
                $product['category'] = $label;
                return $product;
            },
            $products);

        echo $twig->render('admin/product/list.html.twig', [
            'products' => $products,
        ]);
    }
    function AdminProductShowController($twig, $db)
    {
        $id = $_GET['product'] ?? null;
        $product = getOneProduct($db, $id);

        $categories = getallCategory($db);

        $category_key = array_search(
        # permet d'accéder à l'idCategory du produit
            $product['idCategory'],
            # fabrique un tableau qui ne contient que les id
            array_column($categories, 'id')
        );

        $label = null;
        if ($category_key !== false) {
            $label = $categories[$category_key]['label'];
        }
        $product['category'] = $label;

        echo $twig->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }
    function AdminUserAddController($twig, $db)
    {
        $roles = getAllRoles($db);

        $status = null;
        $message = null;

        $form = [
            'email' => '',
            'firstname' => '',
            'lastname' => '',
            'idRole' => ''
        ];

        if (!empty($_POST))
        {
            $email = htmlspecialchars($_POST['email']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $idRole = htmlspecialchars($_POST['idRole']);

            $form = [
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'idRole' => $idRole
            ];

            if (!isset($email) || strlen($email) < 3
                || !isset($firstname) || strlen($firstname) < 3
                || !isset($lastname)  || strlen($lastname) < 3
                || !isset($idRole)
            )
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                saveUser($db, $email, '', $lastname, $firstname, $idRole);

                header('location: /?page=adminUserList');
                die();
            }
        }

        echo $twig->render('admin/user/form.html.twig', [
            'form' => $form,
            'controller' => 'add',
            'roles' => $roles,
            'status' => $status,
            'message' => $message
        ]);
    }
    function AdminUserDeleteController($twig, $db)
    {
        $id = $_GET['user'] ?? null;

        if (deleteUser($db, $id)) {
            header('location: /?page=adminUserList');
            die();
        }

        echo $twig->render('admin/message.html.twig', [
            'status' => 'danger',
            'message' => 'Erreur lors de la suppression de l\'utilisateur.',
        ]);
    }
    function AdminUserEditController($twig, $db)
    {
        $id = $_GET['user'] ?? null;

        $user = getOneUser($db, $id);
        $roles = getAllRoles($db);

        $status = null;
        $message = null;

        $form = [
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'idRole' =>$user['idRole']
        ];

        if (!empty($_POST))
        {
            $email = htmlspecialchars($_POST['email']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $idRole = htmlspecialchars($_POST['idRole']);

            $form = [
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'idRole' => $idRole
            ];

            if (!isset($email) || strlen($email) < 3
                || !isset($firstname) || strlen($firstname) < 3
                || !isset($lastname)  || strlen($lastname) < 3
                || !isset($idRole)
            )
            {
                $status = 'danger';
                $message = 'Vous devez renseigner tous les champs.';
            }
            else {
                updateUser($db, $id, $email, $lastname, $firstname, $idRole);

                header('location: /?page=adminUserList');
                die();
            }
        }

        echo $twig->render('admin/user/form.html.twig', [
            'form' => $form,
            'controller' => 'edit',
            'roles' => $roles,
            'status' => $status,
            'message' => $message
        ]);
    }
    function AdminUserListController($twig, $db)
    {
        $users = getAllUsers($db);
        $roles = getAllRoles($db);

        $users = array_map(
            function ($user) use ($roles) {
                #Index du tableau
                $user_key = array_search(
                # permet d'accéder à l'idCategory du produit
                    $user['idRole'],
                    # fabrique un tableau qui ne contient que les id
                    array_column($roles, 'id')
                );
                #ajouter categorie a produit
                $label = null;
                if ($user_key !== false) {
                    $label = $roles[$user_key]['label'];
                }
                $user['role'] = $label;
                return $user;
            },
            $users);

        echo $twig->render('admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }
    function AdminUserShowController($twig, $db)
    {
        $id = $_GET['user'] ?? null;
        $user = getOneUser($db, $id);

        $roles = getAllRoles($db);

        $role_key = array_search(
        # permet d'accéder à l'idCategory du produit
            $user['idRole'],
            # fabrique un tableau qui ne contient que les id
            array_column($roles, 'id')
        );

        $label = null;
        if ($role_key !== false) {
            $label = $roles[$role_key]['label'];
        }
        $user['role'] = $label;

        echo $twig->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }
}