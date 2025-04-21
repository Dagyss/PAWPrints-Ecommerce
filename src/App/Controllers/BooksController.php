<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;

class BooksController extends AbstractController{

    public ?string $modelName = BooksCollection::class;
    public function index(){
        $books = $this->model->getAll();
        require $this->viewsDir . 'books.php';
    }

}

?>