<?php


namespace App\Core\Security;


class AuthenticationManager
{
    private $user;

    public function __construct()
    {
        if (!empty($_SESSION)) {
            $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        }
    }

    /**
     * @return mixed|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed|null $user
     */
    public function setUser(?array $user): void
    {
        if (isset($user))
        {
            $this->user = $user;
            $_SESSION['user'] = $user;
        }
    }




}