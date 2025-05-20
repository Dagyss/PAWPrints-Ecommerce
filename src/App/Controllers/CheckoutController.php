<?php
namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\Core\Request;
use Paw\App\Controllers\ErrorController;

class CheckoutController extends AbstractController
{
    private $jsonFile = __DIR__ . '/../../Storage/carrito.json';

    public function showForm()
    {
        // Mas adelante recuperamos de la bd el carrito, por ahora hardcodeamos unos libritos:
        // Leemos el carrito hardcodeado
        $json = file_get_contents($this->jsonFile);
        $cart = json_decode($json, true);

        require $this->viewsDir . 'checkout-form.php';
    }

    public function submit(Request $request)
    {
        //Recuperacion de datos   
        $data = [
            'nombre'   => trim($request->post('nombre')),
            'email'    => trim($request->post('email')),
            'telefono' => trim($request->post('telefono')),
            'entrega'  => $request->post('entrega'),
        ];

        $errors = [];

        if (!$data['nombre']) {
            $errors['nombre'] = 'Debe ingresar un nombre.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalido.';
        }

        if ($data['telefono'] !== '' && !preg_match('/^\+?\d{7,15}$/', $data['telefono'])) {
            $errors['telefono'] = 'Teléfono invalido.';
        }
        
        if (!in_array($data['entrega'], ['domicilio','sucursal'])) {
            $errors['entrega'] = 'Opción de entrega invalida.';
        }

        if (!file_exists($this->jsonFile) || !is_readable($this->jsonFile)) {
            $errors[] = 'No se pudo leer el carrito.';
            $cartItems = [];
        } else {
            $json = file_get_contents($this->jsonFile);
            $cartItems = json_decode($json, true) ?: [];
            if (empty($cartItems)) {
                $errors[] = 'El carrito está vacio.';
            }
        }

        if (count($errors) > 0) {
            $errorController = new ErrorController();
            $errorController->internalError();
            exit;
            
            /*
            //Esto te devuelve un 422 y un json con los errores que fueron saltando con este estilo 
            // {"success":false,"errors":{"nombre":"Debe ingresar un nombre.","email":"Email invalido."}}
            header('Content-Type: application/json', true, 422);
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
            */
        }

        $nombre = $data['nombre'] ?? 'Cliente';

        // Correo
        $to      = "ventas@pawprints.local";
        $subject = "Nueva reserva de $nombre";
        $body    = "Se ha realizado una nueva reserva:\n\n"
                 . "Nombre: $nombre\n"
                 . "Email: {$data['email']}\n"
                 . "Teléfono: {$data['telefono']}\n"
                 . "Entrega: {$data['entrega']}\n\n"
                 . "Detalle de productos:\n";    
        
        foreach ($cartItems as $item) {
            $titulo   = $item['titulo'] ?? '—';
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $formato  = $item['formato'] ?? '—';
            $precio   = number_format((float) ($item['precio'] ?? 0), 2, ',', '.');
            $body    .= "- {$titulo} x{$cantidad} ({$formato}): \${$precio} c/u\n";
        }

        
        $total = array_reduce(
            $cartItems,
            function($sum, $i) {
                $qty   = (int) ($i['cantidad'] ?? 1);
                $price = (float) ($i['precio'] ?? 0);
                return $sum + ($qty * $price);
            },
            0
        );
        $body .= "\nTotal: \$" . number_format($total, 2, ',', '.') . "\n";

        $headers  = "From: no-reply@localhost\r\n"; 
        $headers .= "Reply-To: ventas@pawprints.local\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $ok = mail($to, $subject, $body, $headers);
        if (!$ok) {
            error_log("Falló el envío de mail: " . print_r(error_get_last(), true));
        }

        //Confirmacion
        require $this->viewsDir . 'checkout-success.php';
    }
}