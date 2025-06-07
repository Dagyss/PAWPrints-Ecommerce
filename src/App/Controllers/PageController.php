<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;

class PageController extends AbstractController
{
    public function index()
    {
        $this->render('home.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    public function aboutUs()
    {
        $this->render('about-us.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    public function login()
    {
        $this->render('login.twig', [
            'errors'     => $_SESSION['errors'] ?? [],
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
        unset($_SESSION['errors']);
    }

    public function createAccount()
    {
        $this->render('create-account.twig', [
            'errors'     => $_SESSION['errors'] ?? [],
            'success'    => $_SESSION['success'] ?? null,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
        unset($_SESSION['errors'], $_SESSION['success']);
    }
}

?>