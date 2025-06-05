<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;

class ErrorController extends AbstractController
{
    public function notFound()
    {
        http_response_code(404);

        $this->render('errors/not-found.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
            // Podrías incluir datos específicos del error si quieres
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