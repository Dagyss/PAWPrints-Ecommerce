<?php
namespace Paw\App\Controllers;

use Paw\Core\AbstractController;

class CartController extends AbstractController
{

    private $jsonFile = __DIR__ . '/../../Storage/carrito.json';

    public function show()
    {
        // Mas adelante recuperamos de la bd el carrito, por ahora hardcodeamos unos libritos:
        // Leemos el carrito hardcodeado
        $json = file_get_contents($this->jsonFile);
        $cart = json_decode($json, true);

        require $this->viewsDir . 'shopping-cart.php';
    }
}