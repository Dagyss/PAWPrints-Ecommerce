<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;

class BooksController extends AbstractController{

    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index() {
        
        require $this->viewsDir . 'books.php';
    }

    public function indexJson() {
        $books = $this->model->getAll();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function show() {
        $id = $_GET['id'];
        $book = $this->model->getById($id);
        if(is_null($book)){
            require $this->viewsDir . 'errors/not-found.php';
            exit;
        }
        require $this->viewsDir . 'book.php';
    }

    private function getFilters(): array {
        return[
            'categorias' => $_GET['categorias'] ?? [],
            'precio_min' => $_GET['precio_min'] ?? null,
            'precio_max' => $_GET['precio_max'] ?? null,
            'autor' => $_GET['autor'] ?? null,
            'coincidencias_autor' => $_GET['coincidencias_autor'] ?? [],
            'idiomas' => $_GET['idiomas'] ?? [],
            'formatos' => $_GET['formatos'] ?? [],
            'orden' => $_GET['orden'] ?? null,
        ]; 
    }

    private function getPaginationData(): array{
        return [
            isset($_GET['page']) ? (int) $_GET['page'] : 1 ,
            isset($_GET['size']) ? (int) $_GET['size'] : $this->sizePage
        ];
    }

    private function exportCsv($books) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=catalogo.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['ID', 'Título', 'Autor', 'Editorial', 'Precio']);

        foreach ($books as $book) {
            fputcsv($output, [
                $book->__get('id'),
                $book->__get('titulo'),
                $book->__get('autor'),
                $book->__get('editorial'),
                number_format($book->__get('precio'), 2, ',', '')
            ]);
        }

        fclose($output);
        exit;
    }
}

?>