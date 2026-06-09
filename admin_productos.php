<?php
session_start();
include 'conexion.php';
if (!isset($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }

if (isset($_POST['agregar'])) {
    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['categoria_id'], $_POST['imagen_url']]);
}

// Lógica para Actualizar
if (isset($_POST['actualizar'])) {
    $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen_url = ? WHERE id = ?");
    $stmt->execute([$_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['categoria_id'], $_POST['imagen_url'], $_POST['id']]);
    header("Location: admin_productos.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
}

// Cargar datos para editar
$prod_editar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $prod_editar = $stmt->fetch();
}

$productos = $pdo->query("SELECT p.*, c.nombre as cat_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC")->fetchAll();
$categorias = $pdo->query("SELECT id, nombre FROM categorias")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Mantenedor de Productos | Destellos</title>
</head>
<body>
    <main class="content admin-container">
        <a href="admin_dashboard.php">← Volver al Panel</a>
        <h2 class="section-title">Mantenimiento de Productos</h2>

        <section class="contact-form admin-section-spacing">
            <form method="POST">
                <h3><?= $prod_editar ? 'Editar Producto' : 'Nuevo Producto' ?></h3>
                <?php if($prod_editar): ?>
                    <input type="hidden" name="id" value="<?= $prod_editar['id'] ?>">
                <?php endif; ?>
                <div class="admin-form-grid ">
                    <input type="text" name="nombre" placeholder="Nombre" value="<?= $prod_editar ? htmlspecialchars($prod_editar['nombre']) : '' ?>" required>
                    <select name="categoria_id" class="admin-select" required>
                        <option value="">Seleccionar Categoría</option>
                        <?php foreach($categorias as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= ($prod_editar && $prod_editar['categoria_id'] == $c['id']) ? 'selected' : '' ?>><?= $c['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="precio" placeholder="Precio (₡)" value="<?= $prod_editar ? $prod_editar['precio'] : '' ?>" required>
                    <input type="number" name="stock" placeholder="Existencias" value="<?= $prod_editar ? $prod_editar['stock'] : '' ?>" required>
                    <input type="text" name="imagen_url" placeholder="Ruta de imagen (ej: img/anillo.svg)" value="<?= $prod_editar ? htmlspecialchars($prod_editar['imagen_url']) : '' ?>">
                </div>
                <textarea name="descripcion" placeholder="Descripción detallada"><?= $prod_editar ? htmlspecialchars($prod_editar['descripcion']) : '' ?></textarea>
                <button type="submit" name="<?= $prod_editar ? 'actualizar' : 'agregar' ?>"><?= $prod_editar ? 'Actualizar Producto' : 'Registrar Producto' ?></button>
                <?php if($prod_editar): ?>
                    <a href="admin_productos.php" class="admin-cancel-link">Cancelar edición</a>
                <?php endif; ?>
            </form>
        </section>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $p): ?>
                <tr>
                    <td><img src="<?= $p['imagen_url'] ?>" class="admin-table-img"></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['cat_nombre']) ?></td>
                    <td>₡<?= number_format($p['precio'], 0) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <a href="?editar=<?= $p['id'] ?>" class="admin-edit-link">Editar</a>
                        <a href="?eliminar=<?= $p['id'] ?>" class="admin-delete-link" onclick="return confirm('¿Eliminar?')">Borrar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>