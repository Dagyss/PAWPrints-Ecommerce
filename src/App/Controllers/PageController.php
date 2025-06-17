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
        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? null;

        $this->render('login.twig', [
            'errors'     => $errors,
            'success'    => $success,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
        unset($_SESSION['errors']);
    }

    public function createAccount()
    {
        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? null;
        $old = $_SESSION['old'] ?? [];

        unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

        $this->render('create-account.twig', [
            'errors'     => $errors,
            'success'    => $success,
            'old'        => $old,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

}

?>