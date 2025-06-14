<?php

namespace Paw\App\Controllers;

use DateTime;
use Paw\Core\AbstractController;
use Paw\App\Models\BooksCollection;
use Paw\App\Models\Book;
use Paw\Core\Request;

class BooksController extends AbstractController
{
    public ?string $modelName = BooksCollection::class;
    private int $sizePage = 6;

    public function index()
    {
        $this->render('books.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
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
        $id = isset($_GET['id']) ? (int) $_GET['id'] : -1;
        $book = $this->model->getById($id);

        if (is_null($book)) {
            // Renderizamos plantilla de error en lugar de incluir PHP crudo
            $this->render('errors/not-found.twig', []);
            return;
        }

        $this->render('book.twig', [
            'book' => $book,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    public function createBook(): void
    {
        $this->render('create-book.twig', [
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    private function exportCsv($books)
    {
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
        $titulo = filter_var(trim($_POST['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $autor = filter_var(trim($_POST['autor'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $editorial = $_POST['editorial'] ?? '';
        $isbn = $_POST['isbn'] ?? '';
        $idioma = $_POST['idioma'] ?? '';
        $fecha_publicacion = $_POST['fecha_publicacion'] ?? null;
        $numero_paginas = $_POST['numero_paginas'] ?? 0;
        $formato = $_POST['formato'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $precio = $_POST['precio'] ?? 0.0;
        $sinopsis = $_POST['sinopsis'] ?? '';
        $sinopsis = $_POST['sinopsis'] ?? '';
        $stock = 0;
        $cantidad_ventas = 0;
        $descuento = 0.0;

        if (!$titulo) {
            $_SESSION['error'] = 'El título es obligatorio';
            header('Location: /books');
            exit;
        }
        
        if ($fecha_publicacion && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_publicacion)) {
            $_SESSION['error'] = 'Formato de fecha inválido';
            header('Location: /books');
            exit;
        }

        $book = new Book();
        try {
            $book->setTitulo($titulo);
            $book->setAutor($autor);
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
        $uploadDir = __DIR__ . '/../../../public/uploads/books/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
            // El usuario subió manualmente la portada
            $tmpPath  = $_FILES['portada']['tmp_name'];
            $origName = basename($_FILES['portada']['name']);
            $ext      = pathinfo($origName, PATHINFO_EXTENSION);
            $newName  = uniqid('book_') . '.' . $ext;
            $destPath = $uploadDir . $newName;

            if (move_uploaded_file($tmpPath, $destPath)) {
                $book->setImagen('uploads/books/' . $newName);
            }
        } else if (!empty($isbn)) {
            // No subió imagen: tratamos de descargarla de Open Library
            // Usamos ISBN y tamaño "L"; agregamos default=false para 404 si no hay cover
            $coverUrl = "https://covers.openlibrary.org/b/isbn/{$isbn}-L.jpg?default=false";
            $coverData = @file_get_contents($coverUrl);
            if ($coverData !== false) {
                // Creamos un archivo con extensión jpg
                $newName  = "cover_{$isbn}_" . time() . ".jpg";
                $destPath = $uploadDir . $newName;
                file_put_contents($destPath, $coverData);
                $book->setImagen('uploads/books/' . $newName);
            }
        }

        // Si por alguna razón no quedo imagen, podemos asignar una por defecto
        if (!$book->__get('imagen')) {
            $book->setImagen('uploads/books/default_cover.png');
        }

        $newId = $this->model->insertBook($book);

        if ($newId) {
            $_SESSION['success'] = "Libro creado correctamente (ID: $newId).";
            $this->render('new-book.twig', [
                'loggedUser' => getLoggedUser() ?? null,
                'username'   => getLoggedUsername() ?? null,
            ]);
            exit;
        } else {
            $_SESSION['error'] = "Error al guardar el libro en la base de datos.";
            $this->render('errors/internal-error.twig', [
                'loggedUser' => getLoggedUser() ?? null,
                'username'   => getLoggedUsername() ?? null,
            ]);
            exit;
        }
    }

    public function fetchIsbn(Request $request)
    {
        $isbn = isset($_GET['isbn']) ? preg_replace('/[^0-9Xx-]/', '', $_GET['isbn']) : null;

        if (!$isbn) {
            http_response_code(400);
            echo json_encode(['error' => 'ISBN faltante']);
            return;
        }

        $url = "https://openlibrary.org/isbn/{$isbn}.json";
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept: application/json\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            http_response_code(502);
            echo json_encode(['error' => 'No se pudo obtener datos de Open Library']);
            return;
        }

        $data = json_decode($response, true);

        // Obtener nombres de autores
        if (isset($data['authors']) && is_array($data['authors'])) {
            foreach ($data['authors'] as &$author) {
                $authorKey = $author['key'];
                $authorUrl = "https://openlibrary.org{$authorKey}.json";
                $authorResponse = @file_get_contents($authorUrl, false, $context);
                if ($authorResponse !== false) {
                    $authorData = json_decode($authorResponse, true);
                    $author['name'] = $authorData['name'] ?? 'Desconocido';
                } else {
                    $author['name'] = 'Desconocido';
                }
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
