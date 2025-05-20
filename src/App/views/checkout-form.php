<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de compra en PAWPrints. Ingresa tus datos para completar la compra de tus productos.">
    <meta name="keywords" content="PAWPrints, compra, libros, checkout, formulario">
    <meta name="author" content="PAWPrints">
    <title>Finalizar Compra - PAWPrints</title>
    <link rel="stylesheet" href="./css/checkout-form.css">
</head>
<body>
    <?php
        require "parts/header.php";
    ?>

    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="./checkout-form">Finalizar compra</a></li>
            </ul>
        </nav>
        <div class="checkout-container">
        <section class="order-summary">
                <h2>Detalle de tu pedido</h2>

                <?php if (!empty($cart)): ?>
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $item): ?>
                        <article class="order-summary-item">
                            <figure>
                                <a href="/book?id=<?= htmlspecialchars($item['id']); ?>">
                                    <img src="<?= htmlspecialchars($item['imagen']); ?>" alt="Portada de <?= htmlspecialchars($item['titulo']); ?>">
                                </a>
                            </figure>
                            <div>
                                <h3>
                                    <a href="/book?id=<?= htmlspecialchars($item['id']); ?>"><?= htmlspecialchars($item['titulo']); ?></a>
                                </h3>
                                <div class="order-summary-details">
                                    <p>Cantidad: <?= (int) $item['cantidad']; ?></p>
                                    <p>Formato: <?= htmlspecialchars($item['formato']); ?></p>
                                </div>
                                <div class="order-summary-price">
                                    <p>$<?= number_format($item['precio'], 2, ',', '.'); ?></p>
                                </div>
                            </div>
                        </article>
                        <?php $total += $item['precio'] * $item['cantidad']; ?>
                    <?php endforeach; ?>

                    <p class="total">Total: $<?= number_format($total, 2, ',', '.'); ?></p>
                <?php else: ?>
                    <p>No hay productos en tu carrito.</p>
                <?php endif; ?>
            </section>

            <section class="checkout-form">
                <h2>Formulario de compra</h2>

                <?php if (!empty($errors)): ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form action="/checkout-form" method="POST" novalidate>
                    <div class="form-section">
                        <label for="nombre">Nombre y apellido</label>
                        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($data['nombre'] ?? ''); ?>" placeholder="Cosme Fulanito" required>
                    </div>

                    <div class="form-section">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email'] ?? ''); ?>" placeholder="email@gmail.com" required>
                    </div>

                    <div class="form-section">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?= htmlspecialchars($data['telefono'] ?? ''); ?>" placeholder="+54 xxxxxxxxxx">
                    </div>

                    <fieldset class="form-section">
                        <legend>Tipo de entrega</legend>
                        <label>
                            <input type="radio" name="entrega" value="domicilio" <?= (!isset($data['entrega']) || $data['entrega'] === 'domicilio') ? 'checked' : ''; ?>> Entrega a domicilio
                        </label>
                        <label>
                            <input type="radio" name="entrega" value="sucursal" <?= (isset($data['entrega']) && $data['entrega'] === 'sucursal') ? 'checked' : ''; ?>> Retiro en sucursal
                        </label>
                    </fieldset>

                    <div class="form-actions">
                        <button type="submit">Realizar compra</button>
                        <p>¿Ya tenés una cuenta? <a href="/login"><u>Iniciar sesión</u></a></p>
                    </div>
                </form>
            </section>
      
          
        </div>
      </main>

    <?php
    require "parts/footer.php";
    ?>

    
</body>
</html>
