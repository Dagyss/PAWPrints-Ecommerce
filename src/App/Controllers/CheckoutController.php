<?php
namespace Paw\App\Controllers;

use Monolog\Logger;
use Paw\Core\AbstractController;
use Paw\Core\Request;
use Paw\App\Controllers\ErrorController;
use Paw\App\Models\Order;
use Paw\App\Models\OrderItem;
use Paw\App\Services\OrderService;   // ← añadido

class CheckoutController extends AbstractController
{
    private $jsonFile = __DIR__ . '/../../Storage/carrito.json';

    public function showForm()
    {
        $json = file_get_contents($this->jsonFile);
        $cart = json_decode($json, true);

        require $this->viewsDir . 'checkout-form.php';
    }

    public function submit(Request $request)
    {
        // Recuperación de datos
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
        }

        $order = new Order();
        $order->set([
            'nombre'   => $data['nombre'],
            'email'    => $data['email'],
            'telefono' => $data['telefono'],
            'entrega'  => $data['entrega'],
            'total'    => array_reduce(
                $cartItems,
                function($sum, $i) {
                    $qty   = (int) ($i['cantidad'] ?? 1);
                    $price = (float) ($i['precio'] ?? 0);
                    return $sum + ($qty * $price);
                },
                0
            ),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $items = [];
        foreach ($cartItems as $ci) {
            $item = new OrderItem();
            $item->set([
                'book_id'    => $ci['id'],
                'formato'    => $ci['formato'],
                'cantidad'   => $ci['cantidad'],
                'precio_unit'=> $ci['precio'],
                'descuento_unit' => $ci['descuento']
            ]);
            $this->logger->info('Item descuento '.$ci['descuento']);
            $items[] = $item;
        }

        $this->logger->info('Items: '.json_encode($cartItems));
        $this->logger->info('Items: '.json_encode($items));

        $service = new OrderService();
        try {
            $service->createOrderWithItems($order, $items);
        } catch (\Exception $e) {
            (new ErrorController())->internalError();
            $this->logger->error($e->getMessage());
            exit;
        }

        $to      = "ventas@pawprints.local";
        $subject = "Nueva reserva de {$data['nombre']}";
        $body    = "Se ha realizado una nueva reserva:\n\n"
                 . "Nombre: {$data['nombre']}\n"
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

        // Confirmación
        require $this->viewsDir . 'checkout-success.php';
    }
}
