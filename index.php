<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Estilos globales y tipografías -->
<link rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Inicio | Destellos</title>
</head>
<body>
<!-- Control de estado para el menú hamburguesa en móviles -->
<input type="checkbox" id="menu-toggle">

<!-- Encabezado: Contiene el logo, eslogan y botones de acción -->
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
        <a href="admin_login.php" class="login-button" style="background: #7a284c; color: white; border: none;">
            Panel Admin
        </a>

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
    <!-- Navegación lateral para categorías y páginas principales -->
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

    <!-- Área de contenido dinámico -->
    <main class="content">

<!-- Sección de bienvenida (Hero) -->
<section class="page-banner">
    <div style="display: flex; align-items: baseline; gap: 25px;">
        <h2 class="section-title">Inicio</h2>
        <p>Joyas para resaltar tu belleza, iluminar tus momentos y recordarte que mereces brillar todos los días.</p>
    </div>
</section>

<!-- Grid de productos destacados -->
<section class="products-section">
    <div class="cards-container">
        <article class="card">
    <img src="img/anillorose.jpg" alt="Anillo Rose">
    <div class="card-content">
        <h3>Anillo Rose</h3>
        <p class="description">Anillo delicado con acabado brillante. ideal para un estilo romántico.</p>
        <p class="price">₡12.500</p>
        <button onclick="addToCart('Anillo Rose', 12500, 'img/anillo.svg')">Agregar al carrito</button>
    </div>
</article>
<article class="card">
    <img src="img/collar.svg" alt="Collar Destello">
    <div class="card-content">
        <h3>Collar Destello</h3>
        <p class="description">Collar fino y elegante para resaltar tu belleza con sutileza.</p>
        <p class="price">₡18.900</p>
        <button onclick="addToCart('Collar Destello', 18900, 'img/collar.svg')">Agregar al carrito</button>
    </div>
</article>
<article class="card">
    <img src="img/pulsera.svg" alt="Pulsera Aurora">
    <div class="card-content">
        <h3>Pulsera Aurora</h3>
        <p class="description">Pulsera femenina con detalles brillantes y sofisticados.</p>
        <p class="price">₡10.800</p>
        <button onclick="addToCart('Pulsera Aurora', 10800, 'img/pulsera.svg')">Agregar al carrito</button>
    </div>
</article>
<article class="card">
    <img src="img/aretes.svg" alt="Aretes Luna">
    <div class="card-content">
        <h3>Aretes Luna</h3>
        <p class="description">Aretes pequeños y luminosos. perfectos para todos los días.</p>
        <p class="price">₡9.500</p>
        <button onclick="addToCart('Aretes Luna', 9500, 'img/aretes.svg')">Agregar al carrito</button>
    </div>
</article>
<article class="card">
    <img src="img/jueguito.svg" alt="Jueguito Romance">
    <div class="card-content">
        <h3>Jueguito Romance</h3>
        <p class="description">Conjunto especial para lucir radiante en ocasiones únicas.</p>
        <p class="price">₡27.900</p>
        <button onclick="addToCart('Jueguito Romance', 27900, 'img/jueguito.svg')">Agregar al carrito</button>
    </div>
</article>
<article class="card">
    <img src="img/cadena.svg" alt="Cadena Luz">
    <div class="card-content">
        <h3>Cadena Luz</h3>
        <p class="description">Cadena fina con acabado brillante y diseño minimalista.</p>
        <p class="price">₡13.900</p>
        <button onclick="addToCart('Cadena Luz', 13900, 'img/cadena.svg')">Agregar al carrito</button>
    </div>
</article>
    </div>
</section>

    </main>
</div>

<!-- Botón de contacto directo por WhatsApp -->
<a
    class="whatsapp-float"
    href="https://wa.me/50688857768?text=Hola%20Destellos%2C%20quiero%20informaci%C3%B3n%20sobre%20sus%20joyas."
    target="_blank"
    aria-label="Contactar por WhatsApp">
    ✆
</a>

<!-- Panel lateral del carrito de compras -->
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
        <a id="checkout-whatsapp"
           href="https://wa.me/50688857768"
           target="_blank"
           class="checkout-button">
            Comprar por WhatsApp
        </a>
    </div>
</section>

<!-- Lógica de funcionalidad del sitio -->
<script src="script.js"></script>

</body>
</html>
