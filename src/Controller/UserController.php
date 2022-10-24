<?php

namespace App\Controller;

use App\Model\UserManager;

final class UserController extends AbstractController
{
    public function signup(): string
    {
        if (!empty($_POST["submit"])) {
            // TODO validation (code injection, empty values, string patterns, etc.)
            // TODO feedback to the user is something wrong

            // TODO create user
            $user = new UserManager();
            $user->insert([
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ]);

            // TODO redirect
            \header('Location: /');
        }
        return $this->twig->render('Auth/signup.html.twig');
    }

    public function login(): string
    {
        // TODO get sent username and password from form
        if (!empty($_POST["submit"])) {
            // TODO validation (code injection, empty values, string patterns, etc.)
            $user = new UserManager();
            $user = $user->selectOneByUsername($_POST['username']);
            if (password_verify($_POST['password'], $user["password"])) {
                $_SESSION['authed'] = true;
                $_SESSION['username'] =  $user["username"];
                \header('Location: /');
            } else {
                // TODO feedback to the user
                session_destroy();
                \header('Location: /login');
            }
        }
        return $this->twig->render('Auth/login.html.twig');
    }

    public function logout(): void
    {
        session_destroy();
        \header('Location: /login');
    }
}
