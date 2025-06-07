<?php

namespace Paw\App\Models;

use Paw\Core\AbstractModel;

use Paw\App\Models\Book;

use Exception;

class BooksCollection extends AbstractModel{

    public $table = "Books";

    public function getAll(): array{
        $booksData = $this->getQueryBuilder()->select($this->table);
        $booksCollection = [];
    
        foreach ($booksData as $bookData) {
            $book = new Book();
            $book->set($bookData);
            $booksCollection[] = $book;
        }
    
        return $booksCollection;
    }
    
    public function getById(int $id): ?Book {
        $bookData = $this->getQueryBuilder()->select($this->table, ["id" => $id]);
        $book = new Book();
        $book->set($bookData[0]);
        return $book;
    }

    public function getPaginated(int $limit, int $offset): array {
        $allBooks = $this->getAll();
        return array_slice($allBooks, $offset, $limit);
    }
    
    public function count(): int {
        return count($this->getAll());
    }

    public function updateBook(Book $book){
        $this->getQueryBuilder()->update($this->table, $book->fields, ["id" => $book->id]);
    }
    public function insertBook(Book $book): ?string
    {
        return $this->getQueryBuilder()->insert($this->table, $book->fields);
    }
}



?>