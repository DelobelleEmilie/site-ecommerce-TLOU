<?php


namespace App\Controller;



use App\Core\Router\Router;
use App\Repository\UserRepository;
use App\Service\MailerService;

class UserController extends AbstractResourceController
{
    #c'est le constructeur, c'est là qu'on récupère le repository
    private UserRepository $repository;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->repository = new UserRepository();
    }

    public function login()
    {
        if (!empty($_POST))
        {
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;

            $user = $this->repository->verify($email, $password);

            if (isset($user)) {
                $this->authManager->setUser($user);
                $url = $this->url('home#show');
                $this->redirect($url);
            }

            $error = "Combinaison email / mot de passe erronée.";
        }
    
        $this->render('user/connexion.html.twig', [
            'email' => isset($email) ? $email : null,
            'error' => isset($error) ? $error : null,
        ]);
    }

    public function register()
    {
        $mailerService = new MailerService();
        $mailerService->sendRegisterSuccess("$mail");
    }

    public function logout()
    {
        $this->authManager->logout();
        $url = $this->url('home#show');
        $this->redirect($url);
    }

    public function profile()
    {
        # Récupère l'utilisateur connecté
        $user = $this->authManager->getUser();

        # Si le formulaire est soumis
        if (!empty($_POST))
        {
            $data = $_POST;
            $data['role'] = $user['role'];

            # L'utilisateur est mis à jour
            $userId = $this->repository->update($user['id'], $data);

            # On enregistre les nouvelles données dans le manager
            $user = $this->repository->find($userId);
            $this->authManager->setUser($user);

            # Redirection vers la page d'accueil
            $url = $this->url('home#show');
            $this->redirect($url);
        }

        # Affiche le formulaire avec les infos actuelles
        $this->render('user/profile.html.twig', [
            'entity' => isset($user) ? $user : null
        ]);
    }

    public function lostpassword()
    {
        # Si le formulaire est soumis
        if (!empty($_POST))
        {
            $mail = isset($_POST['mail']) ? $_POST['mail'] : null;
            $mot_passe = isset($_POST['password']) ? $_POST['password'] : null;

            if (isset($mail) && strlen($mail) > 0 && isset($mot_passe) && strlen($mot_passe) > 0) {
                $user = $this->repository->findOneBy(['mail' => $mail]);

                if (isset($user)) {
                    $user['mot_passe'] = $mot_passe;
                    $this->repository->update($user['id'], $user);

                    $url = $this->url('user#login');
                    $this->redirect($url);
                }
                else {
                    $error = "Cette adresse e-mail ne correspond à aucun compte.";
                }
            }
            else {
                $error = "Vous devez saisir une adresse e-mail et un nouveau mot de passe.";
            }

        }

        # Affiche le formulaire de réinitialisation
        $this->render('user/Lostpassword.html.twig', [
            'error' => isset($error) ? $error : null
        ]);
    }

    #on récupère le type qui correspond à l'id
    #passe a twig l'ID
    public function show($id)
    {
        $entity = $this->repository->find($id);

        #demander au router de générer une url
        #demandes l'URL pour modifier et supprimer le type
        $editUrl = $this->url('user#edit', [ 'id' => $id ]);
        $deleteUrl = $this->url('user#delete', [ 'id' => $id ]);
        $listUrl = $this->url('user#showList');

        #afficher du twig
        #on lui envoie le type et les URL de modification et suppression en paramètre
        $this->render(
            'user/detail.html.twig',
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
        #on récupère toutes les catégories depuis la base de données
        $entities = $this->repository->findAll();

        #array_map, c'est une function qui prend 2 paramètres
        $entities = array_map(
        #tableau qui ajouter un lien (link) à ma catégorie
            function ($entity) {
                $entity['link'] = $this->url('user#show', ['id' => $entity['id']]);
                return $entity;
            },
            $entities
        );

        $addUrl = $this->url('user#create');

        #envoie toutes les catégories à twig
        $this->render(
            'user/list.html.twig',
            [
                'entities' => $entities,
                'addUrl' => $addUrl
            ]
        );
    }

    public function edit($id = null)
    {
        // On a des données du formulaire, on enregistre en base
        if (isset($_POST['submit'])) {
            # Enregistrement des données en base
            $resultId = $this->repository->update(isset($id) ? $id : null, $_POST);
            # Génération de l'URL pour accéder à la catégorie créée ou modifiée
            $url = $this->url('user#show', ['id' => $resultId]);
            # Redirection vers la page de la catégorie
            $this->redirect($url);
        }

        $listUrl = $this->url('user#showList');

        // Si pas de données du formulaire, on affiche le formulaire
        if(isset($id)) { // UPDATE
            $entity = $this->repository->find($id);
            $this->render('user/form.html.twig',[
                'entity' => $entity,
                'listUrl' => $listUrl
            ]);
        }
        else { // CREATE
            $this->render('user/form.html.twig',[
                'listUrl' => $listUrl
            ]);
        }
    }

    #permet de supprimer une catégorie
    public function delete($id)
    {
        $this->repository->delete($id);

        #sert à rediriger vers /category
        #génère l'URL
        $listUrl = $this->url('user#showList');
        #redirige l'url
        $this->redirect($listUrl);
    }
}