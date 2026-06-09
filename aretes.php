<?php
// 1. Incluimos el archivo de conexión
include 'conexion.php';

// 2. Consultamos los productos de la categoría 'Aretes'
try {
    // Hacemos un JOIN para filtrar por el nombre de la categoría
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM productos p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE c.nombre = 'Aretes'
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
<!-- Importación de estilos y fuentes tipográficas -->
<link rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Aretes | Destellos</title>
</head>
<body>
<!-- Elemento técnico para manejar el menú lateral en dispositivos móviles -->
<input type="checkbox" id="menu-toggle">

<!-- ENCABEZADO: Logo, Slogan y botones de usuario -->
<header class="header">
    <div class="header-left">
        <label for="menu-toggle" class="hamburger" aria-label="Abrir menú">☰</label>

        <a href="index.php" class="brand">
            <img src="img/logo.svg" alt="Logo Destellos" class="logo">
            <span>Destellos</span>
        </a>
    </div>

    <p class="slogan">Brilla por dentro y por fuera</p>

    <div class="header-actions">
        <a href="ofertas.php" class="offers-button">
            Ofertas
        </a>

        <a href="iniciar-sesion.php" class="login-button">
            Iniciar sesión
        </a>

        <a href="registro.php" class="register-button">
            Registrarse
        </a>

        <button class="cart-button" onclick="toggleCart()">
            🛒 <span id="cart-count">0</span>
        </button>
    </div>
</header>

<div class="layout">
    <!-- SIDEBAR: Navegación por categorías de joyería -->
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

    <!-- CONTENIDO: Vista de productos de la categoría Aretes -->
    <main class="content">

<!-- Cabecera de la página de categoría -->
<section class="page-banner">
    <div>
        <nav aria-label="Breadcrumb">
            <ul class="breadcrumbs">
                <li><a href="index.php">Inicio</a></li>
                <li>Joyería</li>
                <li>Aretes</li>
            </ul>
        </nav>
        <div style="display: flex; align-items: baseline; gap: 25px;">
            <h2 class="section-title">Aretes</h2>
            <p>Brillo romántico para iluminar tu rostro.</p>
        </div>
    </div>
</section>

<!-- Cuadrícula de productos (Aretes) -->
<section class="products-section">
    <div class="cards-container">
        
        <?php if (empty($productos)): ?>
            <p>No se encontraron productos en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
                <article class="card">
                    <!-- Se usa la imagen de la BD o un fallback específico de Aretes -->
                    <img src="<?= htmlspecialchars($producto['imagen_url'] ?? 'img/aretes.svg') ?>" 
                         alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <p class="description"><?= htmlspecialchars($producto['descripcion']) ?></p>
                        <p class="price">₡<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                        <button onclick="addToCart('<?= htmlspecialchars($producto['nombre']) ?>', <?= $producto['precio'] ?>, '<?= htmlspecialchars($producto['imagen_url'] ?? 'img/aretes.svg') ?>')">
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

<!-- Comunicación rápida vía WhatsApp -->
<a
    class="whatsapp-float"
    href="https://wa.me/50688857768?text=Hola%20Destellos%2C%20quiero%20informaci%C3%B3n%20sobre%20sus%20joyas."
    target="_blank"
    aria-label="Contactar por WhatsApp">
    ✆
</a>

<!-- Estructura del Carrito de Compras (oculto por defecto) -->
<div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>

<section class="cart-panel" id="cart-panel" aria-label="Carrito de compras">
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
        <a
            id="checkout-whatsapp"
            href="https://wa.me/50688857768"
            target="_blank"
            class="checkout-button">
            Comprar por WhatsApp
        </a>
    </div>
</section>

<!-- Archivo JavaScript principal -->
<script src="script.js"></script>

</body>
</html>
