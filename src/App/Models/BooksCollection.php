<?php

namespace Paw\App\Models;

use Paw\Core\AbstractModel;

use Paw\App\Models\Book;

use Exception;

class BooksCollection extends AbstractModel{

    public $table = "book";

    public function getAll(){
        $filePath = __DIR__ . '/../../Storage/books.json';
        if (file_exists($filePath)) {
            $booksJson = file_get_contents($filePath);
            $booksData = json_decode($booksJson, true);
            $booksCollection = [];
    
            foreach ($booksData as $bookData) {
                $book = new Book($bookData);
                $book->set($bookData);
                $booksCollection[] = $book;
            }
    
            return $booksCollection;
        } else {
            throw new Exception("Books JSON file not found.");
        }
    }
}



?>