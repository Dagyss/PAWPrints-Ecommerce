<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;

class ErrorController extends AbstractController
{
    
    public function notPermission()
    {
        http_response_code(403);

        $this->render('errors/403.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    public function notFound()
    {
        http_response_code(404);

        $this->render('errors/not-found.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    public function internalError()
    {
        http_response_code(500);

        $this->render('errors/internal-error.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }
}