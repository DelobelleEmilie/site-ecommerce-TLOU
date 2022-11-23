<?php


namespace App\Controller;


class UserController extends AbstractResourceController
{
    public function login()
    {
        $this->render('user/connexion.html.twig', []);
    }

    public function register()
    {
        $this->render('user/inscription.html.twig', []);
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function showList()
    {
        // TODO: Implement showList() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function edit($id = null)
    {
        // TODO: Implement edit() method.
    }
}