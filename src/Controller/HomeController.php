<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $authed = $_SESSION['authed'] ?? false;
        if ($authed) {
            return $this->twig->render('Home/index.html.twig');
        } else {
            \header('Location: /login');
            return '';
        }
    }
}
