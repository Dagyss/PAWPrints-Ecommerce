<?php
namespace Paw\App\Controllers;

use DateTime;
use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;
use Paw\App\Models\Book;

class BooksController extends AbstractController
{
    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index()
    {


        $this->render('books.twig', [
            
        ]);
    }

    public function indexJson()
    {
        $books = $this->model->getAll();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function show()
    {
        $id = $_GET['id'];
        $book = $this->model->getById($id);

        if (is_null($book)) {
            // Renderizamos plantilla de error en lugar de incluir PHP crudo
            $this->render('errors/not-found.twig', []);
            return;
        }

        $this->render('book.twig', [
            'book' => $book,
        ]);
    }

    public function createBook(): void
    {
        $this->render('create-book.twig', []);
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


    public function save(): void
    {
        // 1) Leer datos del formulario ($_POST)
        $titulo            = $_POST['titulo'] ?? '';
        $autor             = $_POST['autor'] ?? '';
        $editorial         = $_POST['editorial'] ?? '';
        $isbn              = $_POST['isbn'] ?? '';
        $idioma            = $_POST['idioma'] ?? '';
        $fecha_publicacion = $_POST['fecha_publicacion'] ?? null; // “YYYY-MM-DD”
        $numero_paginas    = $_POST['numero_paginas'] ?? 0;
        $formato           = $_POST['formato'] ?? '';
        $categoria         = $_POST['categoria'] ?? '';
        $precio            = $_POST['precio'] ?? 0.0;
        $sinopsis          = $_POST['sinopsis'] ?? '';
        // El formulario no envía stock, cantidad_ventas ni descuento: 
        // podemos inicializarlos en cero o un valor por defecto.
        $stock             = 0;
        $cantidad_ventas   = 0;
        $descuento         = 0.0;

        $book = new Book();
        try {
            $book->setTitulo($titulo);
            $book->setAutor($autor);
            $book->setEditorial($editorial);
            $book->setPrecio((float) $precio);
            $book->setStock((int) $stock);
            $book->setDescripcion($sinopsis);
            $book->setCategoria($categoria);
            $book->setIdioma($idioma);
            $book->setFormato($formato);
            $book->setCantidadVentas((int) $cantidad_ventas);
            $book->setDescuento((float) $descuento);

            $now = new DateTime();
            $book->setCreatedAt($now);
            $book->setUpdatedAt($now);
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /books');
            exit;
        }

        // 3) Manejo de archivo “portada” (imagen)
        if (
            isset($_FILES['portada']) &&
            $_FILES['portada']['error'] === UPLOAD_ERR_OK
        ) {
            $tmpPath  = $_FILES['portada']['tmp_name'];
            $origName = basename($_FILES['portada']['name']);
            // Generar un nombre unico, por ejemplo:
            $ext      = pathinfo($origName, PATHINFO_EXTENSION);
            $newName  = uniqid('book_') . '.' . $ext;
            // Directorio donde se guardan las portadas:
            $uploadDir = __DIR__ . '/../../public/uploads/books/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $destPath = $uploadDir . $newName;

            if (move_uploaded_file($tmpPath, $destPath)) {
                $book->setImagen('uploads/books/' . $newName);
            } else {
                $book->setImagen('uploads/books/default_cover.png'); //api
            }
        } else {
            $book->setImagen('uploads/books/default_cover.png'); //api
        }

        $newId = $this->model->insertBook($book);

        if ($newId) {
            $_SESSION['success'] = "Libro creado correctamente (ID: $newId).";
            header('Location: /create-books');
            exit;
        } else {
            $_SESSION['error'] = "Error al guardar el libro en la base de datos.";
            header('Location: /books');
            exit;
        }
    }
}

?>
