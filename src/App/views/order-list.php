<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Lista de pedidos realizadas en PAWPrints. Consulta la lista de pedidos realizados en PAWPrints." />
    <meta name="keywords" content="PAWPrints, orden, pedidos, ebooks" />
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/order-list.css" />
    <script src="./js/pages/accountMenu.js"></script>
    <title>Lista de Pedidos - PAWPrints</title>
</head>

<body>
    <?php require "parts/header.php"; ?>

    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><span>Pedidos</span></li>
            </ul>
        </nav>

        <h2>Listado de pedidos</h2>
        <section class="content">
            <?php foreach ($ordersLists as $order): ?>
                <article>
                    <p><strong>Nº de orden:</strong> <?= htmlspecialchars($order->order_id) ?></p>    
                    <p><strong>Solicitado por:</strong> <?= htmlspecialchars($order->nombre) ?></p>
                    <p><strong>Solicitado el día:</strong> <?= htmlspecialchars($order->getCreatedAt($order->created_at)) ?></p>
                    <p><strong>Tipo de entrega:</strong> <?= htmlspecialchars($order->entrega) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order->email) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($order->telefono) ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <?php require "parts/footer.php"; ?>
</body>
</html>