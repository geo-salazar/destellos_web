<?php
session_start();
include 'conexion.php';
if (!isset($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }

// Lógica para Agregar
if (isset($_POST['agregar'])) {//si el boton de agregar fue presionado
    $stmt = $pdo->prepare("INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)");
    $stmt->execute([$_POST['nombre'], $_POST['descripcion']]);
}

// Lógica para Actualizar
if (isset($_POST['actualizar'])) {
    $stmt = $pdo->prepare("UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?");
    $stmt->execute([$_POST['nombre'], $_POST['descripcion'], $_POST['id']]);
    header("Location: admin_categorias.php");
    exit;
}

// Lógica para Eliminar
if (isset($_GET['eliminar'])) {//si el boton de eliminar fue presionado
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
}
//kwrnkwejfhkewjfnklwenfkwlfnlw
// Cargar datos para editar
$cat_editar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $cat_editar = $stmt->fetch();
}

$categorias = $pdo->query("SELECT * FROM categorias ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Mantenedor de Categorías | Destellos</title>
</head>
<body>
    <main class="content admin-container">
        <a href="admin_dashboard.php">← Volver al Panel</a>
        <h2 class="section-title">Mantenimiento de Categorías</h2>

        <section class="contact-form admin-section-spacing">
            <form method="POST">
                <h3><?= $cat_editar ? 'Editar Categoría' : 'Nueva Categoría' ?></h3>
                <?php if($cat_editar): ?>
                    <input type="hidden" name="id" value="<?= $cat_editar['id'] ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre de la categoría" value="<?= $cat_editar ? htmlspecialchars($cat_editar['nombre']) : '' ?>" required>
                <textarea name="descripcion" placeholder="Descripción (opcional)"><?= $cat_editar ? htmlspecialchars($cat_editar['descripcion']) : '' ?></textarea>
                <button type="submit" name="<?= $cat_editar ? 'actualizar' : 'agregar' ?>"><?= $cat_editar ? 'Actualizar' : 'Guardar' ?></button>
                <?php if($cat_editar): ?>
                    <a href="admin_categorias.php" class="admin-cancel-link">Cancelar edición</a>
                <?php endif; ?>
            </form>
        </section>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach($categorias as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['nombre']) ?></td>
                    <td><?= htmlspecialchars($cat['descripcion']) ?></td>
                    <td>
                        <a href="?editar=<?= $cat['id'] ?>" class="admin-edit-link">Editar</a>
                        <a href="?eliminar=<?= $cat['id'] ?>" class="admin-delete-link" onclick="return confirm('¿Seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
        
    </main>
</body>
</html>