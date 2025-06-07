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
        $uploadDir = __DIR__ . '/../../public/uploads/books/';
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
            header('Location: /create-book');
            exit;
        } else {
            $_SESSION['error'] = "Error al guardar el libro en la base de datos.";
            header('Location: /books');
            exit;
        }
    }

    public function fetchIsbn(Request $request)
    {
        $isbn = $_GET['isbn'] ?? null;

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

?>
