<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Panel de Administración | Destellos</title>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="index.php" class="brand"><span>Destellos Admin</span></a>
        </div>
        <div class="header-actions">
            <span>Bienvenido, <?= $_SESSION['admin_nombre'] ?></span>
            <a href="index.php" class="offers-button">Cerrar Sesión</a>
        </div>
    </header>
    
    <main class="content admin-dashboard-main">
        <h2 class="section-title">Gestión de Inventario</h2>
        <div class="values-grid">
            <article onclick="location.href='admin_categorias.php'" style="cursor:pointer; text-align:center;">
                <h3>Categorías</h3>
                <p>Gestionar las familias de productos (Anillos, Aretes, etc.)</p>
                <button class="btn">Entrar</button>
            </article>
            <article onclick="location.href='admin_productos.php'" style="cursor:pointer; text-align:center;">
                <h3>Productos</h3>
                <p>Control de existencias, precios y fotos del catálogo.</p>
                <button class="btn">Entrar</button>
            </article>
        </div>
        <br>
        <a href="index.php" class="forgot-link">← Volver a la tienda</a>
    </main>
</body>
</html>