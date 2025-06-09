<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\OrderCollection;
use Paw\Core\Middelware\AuthMiddelware;

class OrderCollectionController extends AbstractController
{
    public ?string $modelName = OrderCollection::class;
    private int $porPagina = 3;

    public function orderList()
    {
        // 1) Validar acceso
        AuthMiddelware::checkSessionTimeout();
        AuthMiddelware::checkSession();

        if ($_SESSION['user']['role'] === 'cliente') {
            http_response_code(403);
            $this->render('errors/403.twig', [
                'loggedUser' => getLoggedUser() ?? null,
                'username'   => getLoggedUsername() ?? null,
            ]);
            return;
        }

        // 2) Obtener página actual y offset
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageRaw = $_GET['page'] ?? '1';
        $paginaActual = filter_var($pageRaw, FILTER_VALIDATE_INT, [
            'options' => ['default' => 1, 'min_range' => 1]
        ]);
        $offset       = ($paginaActual - 1) * $this->porPagina;

        // 3) Traer todas las órdenes y aplicar paginación
        $orderCollectionModel = $this->getModel(OrderCollection::class);
        $ordersListsAll       = $orderCollectionModel->getAll();

        $totalOrderLists = count($ordersListsAll);
        $totalPaginas    = (int) ceil($totalOrderLists / $this->porPagina);

        // Si la página pedida es inválida, devolvemos 404
        if ($paginaActual > $totalPaginas) {
            http_response_code(404);
            $this->render('errors/not-found.twig', [
                'loggedUser' => getLoggedUser() ?? null,
                'username'   => getLoggedUsername() ?? null,
            ]);
            return;
        }

        $ordersLists = array_slice($ordersListsAll, $offset, $this->porPagina);

        // 4) Renderizar la plantilla con la lista y datos de paginación
        $this->render('order-list.twig', [
            'ordersLists'   => $ordersLists,
            'paginaActual'  => $paginaActual,
            'totalPaginas'  => $totalPaginas,
            'loggedUser'    => getLoggedUser() ?? null,
            'username'      => getLoggedUsername() ?? null,
        ]);
    }
}
