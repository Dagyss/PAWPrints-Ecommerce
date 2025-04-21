<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;

class BooksController extends AbstractController{

    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index() {
        
        list($paginaActual, $librosPorPagina) = $this->getPaginationData();
    
        if ($librosPorPagina <= 0) {
            $librosPorPagina = $this->sizePage;
        }       
    
        $filtros = $this->getFilters();

        $totalLibros = $this->model->count($filtros);
        $totalPaginas = ceil($totalLibros / $librosPorPagina);
        $offset = ($paginaActual - 1) * $librosPorPagina;
    
        $books = $this->model->getPaginated($librosPorPagina, $offset, $filtros);
    
        $maxPagesToShow = 5;
        $startPage = max(1, $paginaActual - floor($maxPagesToShow / 2));
        $endPage = min($totalPaginas, $startPage + $maxPagesToShow - 1);
    
        if ($endPage - $startPage < $maxPagesToShow - 1) {
            $startPage = max(1, $endPage - $maxPagesToShow + 1);
        }
    
        require $this->viewsDir . 'books.php';
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
}

?>