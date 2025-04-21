<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;

class BooksController extends AbstractController{

    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index() {
        $paginaActual = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $librosPorPagina = isset($_GET['size']) ? (int) $_GET['size'] : $this->sizePage;
    
        if ($librosPorPagina <= 0) {
            $librosPorPagina = 6;
        }
    
        $totalLibros = $this->model->count();
        $totalPaginas = ceil($totalLibros / $librosPorPagina);
    
        $offset = ($paginaActual - 1) * $librosPorPagina;
        $books = $this->model->getPaginated($librosPorPagina, $offset);

        // Configuración de la cantidad de páginas a mostrar
        $maxPagesToShow = 5;
        $startPage = max(1, $paginaActual - floor($maxPagesToShow / 2));
        $endPage = min($totalPaginas, $startPage + $maxPagesToShow - 1);
    
        // Ajustar el rango de páginas si es menor que el número máximo de páginas a mostrar
        if ($endPage - $startPage < $maxPagesToShow - 1) {
            $startPage = max(1, $endPage - $maxPagesToShow + 1);
        }
    
        require $this->viewsDir . 'books.php';
    }
    

}

?>