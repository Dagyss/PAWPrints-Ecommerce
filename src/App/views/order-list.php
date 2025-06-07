<?php
    $queryParams = $_GET;
    unset($queryParams['page']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Lista de pedidos realizadas en PAWPrints. Consulta la lista de pedidos realizados en PAWPrints." />
    <meta name="keywords" content="PAWPrints, orden, pedidos, ebooks" />
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/order-list.css" />
    <link rel="stylesheet" href="./css/parts/pagination.css" />
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
                <article itemscope itemtype="https://schema.org/Order">
                    <p><strong>Nº de orden:</strong> <span itemprop="orderNumber"><?= htmlspecialchars($order->order_id) ?></span></p>
                    <p><strong>Solicitado por:</strong> <span itemprop="customer" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?= htmlspecialchars($order->nombre) ?></span>
                    </span></p>
                    <p><strong>Solicitado el día:</strong> <time itemprop="orderDate" datetime="<?= htmlspecialchars($order->created_at) ?>">
                        <?= htmlspecialchars($order->getCreatedAt($order->created_at)) ?>
                    </time></p>
                    <p><strong>Tipo de entrega:</strong> <span itemprop="deliveryMethod"><?= htmlspecialchars($order->entrega) ?></span></p>
                    <p><strong>Email:</strong> <span itemprop="customer" itemscope itemtype="https://schema.org/Person">
                        <meta itemprop="email" content="<?= htmlspecialchars($order->email) ?>"><?= htmlspecialchars($order->email) ?>
                    </span></p>
                    <p><strong>Teléfono:</strong> <span itemprop="customer" itemscope itemtype="https://schema.org/Person">
                        <meta itemprop="telephone" content="<?= htmlspecialchars($order->telefono) ?>"><?= htmlspecialchars($order->telefono) ?>
                    </span></p>
                </article>
            <?php endforeach; ?>
        </section>

        <?php require "parts/pagination.php"; ?>
    </main>

    <?php require "parts/footer.php"; ?>
</body>
</html>