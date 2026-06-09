<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Importación de Estilos y Fuentes -->
<link rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Registro | Destellos</title>
</head>
<body>
<!-- Control del Menú Hamburguesa para Móviles -->
<input type="checkbox" id="menu-toggle">

<!-- ENCABEZADO: Branding y Acciones de Usuario -->
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
    <!-- NAVEGACIÓN LATERAL -->
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

<!-- CONTENIDO PRINCIPAL: Formulario de Registro -->
<main class="content">

    <section class="page-banner">
        <p>
            Forma parte de Destellos y guarda tus datos para futuras compras.
        </p>
    </section>

    <section class="auth-page single-auth-page">
        <div class="auth-card">
            <h2>Crear cuenta</h2>
            <p class="auth-text">
                Inscríbete y comienza a disfrutar una experiencia más personalizada.
            </p>

            <form class="auth-form" action="#" method="post">

                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="8888-8888">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Provincia, cantón, distrito">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Crea una contraseña" required>
                </div>

                <div class="form-group">
                    <label for="confirmar">Confirmar contraseña</label>
                    <input type="password" id="confirmar" name="confirmar" placeholder="Repite tu contraseña" required>
                </div>

                <div class="check-group">
                    <input type="checkbox" id="terminos" required>
                    <label for="terminos">
                        Acepto recibir información y promociones de Destellos.
                    </label>
                </div>

                <button type="submit" class="auth-button">
                    Crear cuenta
                </button>

                <p class="auth-link-text">
                    ¿Ya tienes cuenta?
                    <a href="iniciar-sesion.php">Inicia sesión aquí</a>
                </p>

            </form>
        </div>
    </section>

</main>