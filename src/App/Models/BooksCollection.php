<?php

namespace Paw\App\Models;

use Paw\Core\AbstractModel;

use Paw\App\Models\Book;

use Exception;

class BooksCollection extends AbstractModel{

    public $table = "book";

    public function getAll(): array{
        $filePath = __DIR__ . '/../../Storage/books.json';
        if (file_exists($filePath)) {
            $booksJson = file_get_contents($filePath);
            $booksData = json_decode($booksJson, true);
            $booksCollection = [];
    
            foreach ($booksData as $bookData) {
                $book = new Book();
                $book->set($bookData);
                $booksCollection[] = $book;
            }
    
            return $booksCollection;
        } else {
            throw new Exception("Books JSON file not found.");
        }
    }
    
    public function getPaginated(int $limit, int $offset): array {
        $allBooks = $this->getAll();
        return array_slice($allBooks, $offset, $limit);
    }
    
    public function count(): int {
        return count($this->getAll());
    }
}



?>