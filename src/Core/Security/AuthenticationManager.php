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

    public function getRoles()
    {
        if (!isset($this->user)) { return []; }
        $userRoles = $this->user['role'];
        if ($userRoles[0] === '[') {
            $userRoles = json_decode($userRoles);
        }
        else {
            $userRoles = [$userRoles];
        }
        $userRoles[] = 'ROLE_USER';
        return $userRoles;
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

    public function logout()
    {
        $this->user = null;
        $_SESSION['user'] = null;
    }

    public function hasPermission(array $roles) {
        if (!isset($roles)) { return true; }
        if (count($roles) === 0) { return true; }
        if (!isset($this->user)) { return false; }

        $userRoles = $this->getRoles();

        foreach ($userRoles as $userRole) {
            if (in_array($userRole, $roles)){
                return true;
            }
        }

        return false;
    }
}