<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Carrito de compras en PAWPrints. Revisa y administra los productos agregados a tu carrito.">
    <meta name="keywords" content="PAWPrints, carrito de compras, libros, ebooks, productos">
    <meta name="author" content="PAWPrints">
    <title>Carrito de Compras - PAWPrints</title>
    <link rel="stylesheet" href="./css/shopping-cart.css">
</head>
<body>
    <?php
    require "parts/header.php";
    ?>

    <main>
        <div class="cart-container">
            <section class="cart">
                <h2>Carrito de compra</h2>
    
                <?php if (empty($cart)): ?>
                    <p>No hay productos en el carrito.</p>
                <?php else: ?>
                    <?php
                        $total = 0;
                        foreach ($cart as $index => $item): 
                        // Datos del ítem
                        $id       = htmlspecialchars($item['id']);
                        $titulo   = htmlspecialchars($item['titulo']);
                        $imagen   = htmlspecialchars($item['imagen'] ?? '../icons/book.png');
                        $cantidad = (int) $item['cantidad'];
                        $precio   = number_format((float)$item['precio'], 2, ',', '.');
                        $subtotal = $cantidad * (float)$item['precio'];
                        $total   += $subtotal;
                    ?>
                        <article class="cart-item">
                            <figure>
                                <a href="./book?id=<?= $id ?>">
                                    <img src="<?= $imagen ?>" alt="Portada de <?= $titulo ?>">
                                </a>
                            </figure>
    
                            <div class="cart-item-content">
                                <div class="cart-item-header">
                                    <h3>
                                        <a href="./book?id=<?= $id ?>"><?= $titulo ?></a>
                                    </h3>
                                    <button 
                                        class="cart-remove-btn" 
                                        aria-label="Eliminar producto"
                                        onclick="location.href='?remove=<?= $id ?>'">
                                        <img src="../icons/trash.png" alt="Eliminar">
                                    </button>
                                </div>
    
                                <div class="cart-controls">
                                    <label for="quantity<?= $index ?>" class="visually-hidden">Cantidad</label>
                                    <input 
                                        type="number" 
                                        id="quantity<?= $index ?>" 
                                        min="1" 
                                        value="<?= $cantidad ?>" 
                                        class="cart-quantity"
                                        disabled
                                    >
                                    <p class="cart-price">$<?= $precio ?> c/u</p>
                                    <p class="subtotal">
                                        Subtotal: $<?= number_format($subtotal, 2, ',', '.') ?>
                                    </p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
    
                    <p class="total">
                        Total: $<?= number_format($total, 2, ',', '.') ?>
                    </p>
    
                    <form action="/checkout-form" method="GET">
                        <button type="submit" class="checkout-button">
                            Finalizar compra
                        </button>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    </main>



    <?php
    require "parts/footer.php";
    ?>

</body>
</html>
