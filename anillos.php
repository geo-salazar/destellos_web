<?php
// 1. Incluimos el archivo de conexión
include 'conexion.php';

// 2. Consultamos los productos de la categoría 'Anillos'
try {
    // Hacemos un JOIN para filtrar por el nombre de la categoría
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM productos p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE c.nombre = 'Anillos'
        ORDER BY p.id DESC
    ");
    $stmt->execute();
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al cargar productos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Anillos | Destellos</title>
</head>
<body>
    <input type="checkbox" id="menu-toggle">
    <header class="header">
        <div class="header-left">
            <label for="menu-toggle" class="hamburger">☰</label>
            <a href="index.php" class="brand">
                <img src="img/logo.svg" alt="Logo" class="logo">
                <span>Destellos</span>
            </a>
        </div>
        <p class="slogan">Brilla por dentro y por fuera</p>
        <div class="header-actions">
            <a href="ofertas.php" class="offers-button">Ofertas</a>
            <a href="iniciar-sesion.php" class="login-button">Iniciar sesión</a>
            <a href="registro.php" class="register-button">Registrarse</a>
            <button class="cart-button" onclick="toggleCart()">
                🛒 <span id="cart-count">0</span>
            </button>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="index.php">Página principal</a></li>
                    <li><a href="quienes-somos.php">Quiénes somos</a></li>
                    <li class="menu-group">
                        <details open>
                            <summary>Joyería</summary>
                            <ul class="submenu">
                                <li><a href="anillos.php">Anillos</a></li>
                                <li><a href="aretes.php">Aretes</a></li>
                                <li><a href="collares.php">Collares</a></li>
                                <li><a href="pulseras.php">Pulseras</a></li>
                                <li><a href="jueguitos.php">Jueguitos</a></li>
                                <li><a href="cadenas.php">Cadenas</a></li>
                            </ul>
                        </details>
                    </li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <section class="page-banner">
                <div style="display: flex; align-items: baseline; gap: 25px;">
                    <h2 class="section-title">Anillos</h2>
                    <p>Piezas delicadas para manos que cuentan historias.</p>
                </div>
            </section>

            <section class="products-section">
                <div class="cards-container">
                    <?php if (empty($productos)): ?>
                        <p>No se encontraron productos en esta categoría.</p>
                    <?php else: ?>
                        <?php foreach ($productos as $producto): ?>
                            <article class="card">
                                <img src="<?= htmlspecialchars($producto['imagen_url'] ?? 'img/anillo.svg') ?>" 
                                     alt="<?= htmlspecialchars($producto['nombre']) ?>">
                                <div class="card-content">
                                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                                    <p class="description"><?= htmlspecialchars($producto['descripcion']) ?></p>
                                    <p class="price">₡<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                    <button onclick="addToCart('<?= htmlspecialchars($producto['nombre']) ?>', <?= $producto['precio'] ?>, '<?= htmlspecialchars($producto['imagen_url'] ?? 'img/anillo.svg') ?>')">
                                        Agregar al carrito
                                    </button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <a class="whatsapp-float" href="https://wa.me/50688857768" target="_blank">✆</a>
    <div class="cart-overlay" onclick="toggleCart()"></div>
    <section class="cart-panel" id="cart-panel">
        <div class="cart-header">
            <h2>Tu carrito</h2>
            <button onclick="toggleCart()" class="close-cart">×</button>
        </div>
        <div id="cart-items" class="cart-items">
            <p class="empty-cart">Tu carrito está vacío.</p>
        </div>
        <div class="cart-footer">
            <p>Total: <strong id="cart-total">₡0</strong></p>
            <button onclick="clearCart()" class="clear-cart">Vaciar carrito</button>
            <a id="checkout-whatsapp" href="#" target="_blank" class="checkout-button">Comprar por WhatsApp</a>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
