<?php

namespace Paw\App\Controllers;
use Paw\Core\AbstractController;

use Paw\App\Models\BooksCollection;
use Paw\Core\Middelware\AuthMiddelware;
class HomeController extends AbstractController {
    
    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index(){
        AuthMiddelware::checkSessionTimeout();
        $booksModel = $this->getModel(BooksCollection::class);
        $books = $booksModel->getAll();
        require $this->viewsDir . "home.php";
    }
}