<?php

namespace Cloudstorage\Security;

use MyFramework\ORM\Model;

class Auth
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new Model('users');
    }

    public function login($username, $password)
    {
        $user = $this->userModel->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    public function check()
    {
        return isset($_SESSION['user_id']);
    }
}
