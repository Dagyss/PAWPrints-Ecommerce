<?php
namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\Core\Request;
use Paw\App\Controllers\ErrorController;
use Paw\App\Models\Order;
use Paw\App\Models\OrderItem;
use Paw\App\Services\OrderService;

class CheckoutController extends AbstractController
{
    private string $jsonFile = __DIR__ . '/../../Storage/carrito.json';

    /**
     * Mostrar el formulario de checkout
     */
    public function showForm()
    {
        if (!file_exists($this->jsonFile) || !is_readable($this->jsonFile)) {
            $cart = [];
        } else {
            $json = file_get_contents($this->jsonFile);
            $cart = json_decode($json, true) ?: [];
        }

        $this->render('checkout-form.twig', [
            'cart'       => $cart,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }

    /**
     * Procesar el envío del formulario
     */
    public function submit(Request $request)
    {
        // 1) Recuperar datos del POST
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
            $errors['email'] = 'Email inválido.';
        }

        if ($data['telefono'] !== '' && !preg_match('/^\+?\d{7,15}$/', $data['telefono'])) {
            $errors['telefono'] = 'Teléfono inválido.';
        }

        if (!in_array($data['entrega'], ['domicilio', 'sucursal'])) {
            $errors['entrega'] = 'Opción de entrega inválida.';
        }

        // Leer el carrito actual
        if (!file_exists($this->jsonFile) || !is_readable($this->jsonFile)) {
            $cartItems = [];
        } else {
            $json = file_get_contents($this->jsonFile);
            $cartItems = json_decode($json, true) ?: [];
        }

        if (empty($cartItems)) {
            $errors[] = 'El carrito está vacío.';
        }

        // Si hay errores de validación del formulario o carrito vacío, volvemos a mostrar el formulario
        if (!empty($errors)) {
            $this->render('checkout-form.twig', [
                'errors'     => $errors,
                'cart'       => $cartItems,
                'data'       => $data,
                'loggedUser' => getLoggedUser() ?? null,
                'username'   => getLoggedUsername() ?? null,
            ]);
            return;
        }

        // 2) Verificar stock con el servicio
        $service     = new OrderService();
        $stockErrors = $service->validateStock($cartItems);

        if (!empty($stockErrors)) {
            $this->render('checkout-form.twig', [
                'errors'       => $stockErrors,
                'cart'         => $cartItems,
                'data'         => $data,
                'loggedUser'   => getLoggedUser() ?? null,
                'username'     => getLoggedUsername() ?? null,
            ]);
            return;
        }

        // 3) Crear la orden y sus items
        $order = new Order();
        $order->set([
            'nombre'     => $data['nombre'],
            'email'      => $data['email'],
            'telefono'   => $data['telefono'],
            'entrega'    => $data['entrega'],
            'total'      => array_reduce(
                $cartItems,
                fn($sum, $i) => $sum + ((int)($i['cantidad'] ?? 1) * (float)($i['precio'] ?? 0)),
                0
            ),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $items = [];
        foreach ($cartItems as $ci) {
            $item = new OrderItem();
            $item->set([
                'book_id'       => $ci['id'],
                'formato'       => $ci['formato'],
                'cantidad'      => $ci['cantidad'],
                'precio_unit'   => $ci['precio'],
                'descuento_unit'=> $ci['descuento'],
            ]);
            $this->logger->info('Item descuento ' . $ci['descuento']);
            $items[] = $item;
        }

        $this->logger->info('Items raw del carrito: ' . json_encode($cartItems));
        $this->logger->info('Items instanciados: ' . json_encode($items));

        try {
            $service->createOrderWithItems($order, $items);
        } catch (\Exception $e) {
            (new ErrorController())->internalError();
            $this->logger->error($e->getMessage());
            return;
        }

        // 4) Enviar email de confirmación (opcional, se mantiene igual)
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
            fn($sum, $i) => $sum + ((int)($i['cantidad'] ?? 1) * (float)($i['precio'] ?? 0)),
            0
        );
        $body .= "\nTotal: \$" . number_format($total, 2, ',', '.') . "\n";

        $headers  = "From: no-reply@localhost\r\n";
        $headers .= "Reply-To: ventas@pawprints.local\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $ok = @mail($to, $subject, $body, $headers);
        if (!$ok) {
            error_log("Falló el envío de mail: " . print_r(error_get_last(), true));
        }

        // 5) Mostrar página de éxito
        $this->render('checkout-success.twig', [
            'cart'       => $cartItems,
            'total'      => $total,
            'loggedUser' => getLoggedUser() ?? null,
            'username'   => getLoggedUsername() ?? null,
        ]);
    }
}