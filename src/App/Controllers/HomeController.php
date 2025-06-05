<?php
namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;
use Paw\Core\Middelware\AuthMiddelware;

class HomeController extends AbstractController
{
    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index()
    {
        AuthMiddelware::checkSessionTimeout();

        $booksModel = $this->getModel(BooksCollection::class);
        $books = $booksModel->getAll();

        // En lugar de require + PHP puro, llamamos a render()
        // Pasamos la lista de libros a la plantilla 'home.twig'
        $this->render('home.twig', [
            'books' => $books,
            // Si necesitas pasar el usuario autenticado, 
            // podrías usar getLoggedUser() y pasarlo aquí.
            // 'loggedUser' => getLoggedUser(),
        ]);
    }
}