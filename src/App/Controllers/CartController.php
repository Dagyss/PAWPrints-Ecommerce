<?php
namespace Paw\App\Controllers;

use Paw\Core\AbstractController;

class CartController extends AbstractController
{
    private string $jsonFile = __DIR__ . '/../../Storage/carrito.json';

    public function show()
    {
        // Leer el carrito (hardcodeado por ahora)
        if (!file_exists($this->jsonFile) || !is_readable($this->jsonFile)) {
            $cart = [];
        } else {
            $json = file_get_contents($this->jsonFile);
            $cart = json_decode($json, true) ?: [];
        }

        // Renderizamos la plantilla Twig y le pasamos $cart
        $this->render('shopping-cart.twig', [
            'cart'       => $cart,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }
}