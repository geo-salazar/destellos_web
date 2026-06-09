<?php
/* =========================================================
   PÁGINA: admin_categorias.php
   PROYECTO: Destellos
   TEMA: Mantenedor de Categorías
   ---------------------------------------------------------
   Esta página permite al administrador realizar un CRUD.

   CRUD significa:
   C = Create  -> Crear o guardar una categoría nueva.
   R = Read    -> Leer o listar las categorías guardadas.
   U = Update  -> Editar o actualizar una categoría existente.
   D = Delete  -> Eliminar una categoría.

   IMPORTANTE PARA ESTUDIANTES:
   Esta página mezcla PHP y HTML.
   - La parte PHP está al inicio y procesa la información.
   - La parte HTML está abajo y muestra el formulario y la tabla.
   ========================================================= */

// Inicia o reanuda una sesión en PHP.
// La sesión permite saber si el administrador ya inició sesión.
session_start();

// Incluye el archivo de conexión a la base de datos.
// Normalmente este archivo contiene la variable $pdo.
// $pdo es el objeto que permite hacer consultas SQL usando PDO.
include 'conexion.php';

// Seguridad básica de la página administrativa.
// Si no existe la variable de sesión admin_id, significa que el usuario
// no ha iniciado sesión como administrador.
if (!isset($_SESSION['admin_id'])) {
    // Redirige al formulario de login del administrador.
    header("Location: admin_login.php");

    // Detiene la ejecución del archivo para que no se muestre el contenido.
    exit;
}

/* =========================================================
   1. LÓGICA PARA AGREGAR UNA CATEGORÍA
   ---------------------------------------------------------
   Esta sección se ejecuta cuando el administrador presiona
   el botón Guardar del formulario.

   El formulario usa method="POST", por eso los datos llegan
   en el arreglo $_POST.
   ========================================================= */

// isset($_POST['agregar']) revisa si se presionó un botón llamado "agregar".
// Ese nombre viene del atributo name del botón del formulario.
if (isset($_POST['agregar'])) {

    // prepare() crea una consulta SQL preparada.
    // Los signos ? son marcadores de posición.
    // Luego se reemplazan de forma segura con los datos del formulario.
    $stmt = $pdo->prepare("INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)");

    // execute() ejecuta la consulta preparada.
    // El primer ? se reemplaza por $_POST['nombre'].
    // El segundo ? se reemplaza por $_POST['descripcion'].
    $stmt->execute([
        $_POST['nombre'],
        $_POST['descripcion']
    ]);
}

/* =========================================================
   2. LÓGICA PARA ACTUALIZAR UNA CATEGORÍA
   ---------------------------------------------------------
   Esta sección se ejecuta cuando el administrador está editando
   una categoría y presiona el botón Actualizar.
   ========================================================= */

// Revisa si el botón enviado se llama "actualizar".
if (isset($_POST['actualizar'])) {

    // UPDATE modifica un registro existente de la tabla categorias.
    // WHERE id = ? es muy importante porque indica cuál categoría se actualizará.
    // Sin WHERE se podrían modificar todos los registros de la tabla.
    $stmt = $pdo->prepare("UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?");

    // Se envían los nuevos datos al SQL:
    // 1. nombre nuevo
    // 2. descripción nueva
    // 3. id de la categoría que se va a actualizar
    $stmt->execute([
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['id']
    ]);

    // Después de actualizar, se redirige nuevamente a la misma página.
    // Esto evita que al refrescar el navegador se vuelva a enviar el formulario.
    header("Location: admin_categorias.php");
    exit;
}

/* =========================================================
   3. LÓGICA PARA ELIMINAR UNA CATEGORÍA
   ---------------------------------------------------------
   Esta sección se ejecuta cuando el administrador presiona
   el enlace Eliminar de la tabla.

   En este caso se usa $_GET porque el id viaja por la URL.
   Ejemplo:
   admin_categorias.php?eliminar=5
   ========================================================= */

// Revisa si en la URL viene un dato llamado "eliminar".
if (isset($_GET['eliminar'])) {

    // DELETE elimina un registro de la tabla categorias.
    // WHERE id = ? indica cuál categoría se debe eliminar.
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");

    // Ejecuta el DELETE usando el id recibido por la URL.
    $stmt->execute([
        $_GET['eliminar']
    ]);
}

/* =========================================================
   4. CARGAR DATOS PARA EDITAR
   ---------------------------------------------------------
   Antes de actualizar una categoría, primero hay que buscarla
   en la base de datos para mostrar sus datos en el formulario.
   ========================================================= */

// Al inicio, no hay ninguna categoría seleccionada para editar.
$cat_editar = null;

// Si en la URL viene el dato "editar", significa que el usuario
// presionó el enlace Editar en alguna fila de la tabla.
// Ejemplo:
// admin_categorias.php?editar=3
if (isset($_GET['editar'])) {

    // Busca en la base de datos la categoría que tiene ese id.
    $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");

    // Ejecuta el SELECT usando el id recibido por la URL.
    $stmt->execute([
        $_GET['editar']
    ]);

    // fetch() obtiene un solo registro.
    // El resultado se guarda en $cat_editar.
    // Esa variable se usará abajo para llenar el formulario automáticamente.
    $cat_editar = $stmt->fetch();
}

/* =========================================================
   5. LISTAR TODAS LAS CATEGORÍAS
   ---------------------------------------------------------
   Esta consulta trae todas las categorías para mostrarlas
   en la tabla HTML.
   ========================================================= */

// SELECT * trae todos los campos de la tabla categorias.
// ORDER BY id DESC ordena los registros desde el más reciente hasta el más antiguo.
// fetchAll() obtiene todos los registros y los guarda en un arreglo.
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- Permite que la página se adapte a celulares, tablets y computadoras. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Archivo CSS con el diseño visual de la página. -->
    <link rel="stylesheet" href="styles.css">

    <!-- Fuentes externas de Google Fonts. -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Mantenedor de Categorías | Destellos</title>
</head>
<body>

    <!-- Contenedor principal de la página administrativa. -->
    <main class="content admin-container">

        <!-- Enlace para regresar al panel principal de administración. -->
        <a href="admin_dashboard.php">← Volver al Panel</a>

        <!-- Título principal de la página. -->
        <h2 class="section-title">Mantenimiento de Categorías</h2>

        <!-- Sección que contiene el formulario para guardar o editar categorías. -->
        <section class="contact-form admin-section-spacing">

            <!--
                method="POST" significa que los datos del formulario
                se enviarán de forma interna y no aparecerán directamente en la URL.
            -->
            <form method="POST">

                <!--
                    Operador ternario:
                    Si $cat_editar tiene datos, se muestra "Editar Categoría".
                    Si no tiene datos, se muestra "Nueva Categoría".
                -->
                <h3><?= $cat_editar ? 'Editar Categoría' : 'Nueva Categoría' ?></h3>

                <!--
                    Si se está editando una categoría, se agrega un input oculto
                    con el id de esa categoría.

                    Este id es necesario para saber cuál registro actualizar.
                -->
                <?php if($cat_editar): ?>
                    <input type="hidden" name="id" value="<?= $cat_editar['id'] ?>">
                <?php endif; ?>

                <!--
                    Campo para escribir el nombre de la categoría.

                    Si se está editando, el value se llena con el nombre actual.
                    htmlspecialchars() ayuda a mostrar texto de forma segura.
                -->
                <input
                    type="text"
                    name="nombre"
                    placeholder="Nombre de la categoría"
                    value="<?= $cat_editar ? htmlspecialchars($cat_editar['nombre']) : '' ?>"
                    required
                >

                <!--
                    Campo para escribir la descripción.
                    Si se está editando, se muestra la descripción actual.
                -->
                <textarea name="descripcion" placeholder="Descripción (opcional)"><?= $cat_editar ? htmlspecialchars($cat_editar['descripcion']) : '' ?></textarea>

                <!--
                    El botón cambia según el modo del formulario:
                    - Si se está editando, el botón se llama actualizar.
                    - Si se está creando una categoría nueva, el botón se llama agregar.

                    El PHP de arriba revisa el name del botón para saber qué acción ejecutar.
                -->
                <button type="submit" name="<?= $cat_editar ? 'actualizar' : 'agregar' ?>">
                    <?= $cat_editar ? 'Actualizar' : 'Guardar' ?>
                </button>

                <!--
                    Si se está editando, aparece un enlace para cancelar la edición
                    y volver al formulario limpio.
                -->
                <?php if($cat_editar): ?>
                    <a href="admin_categorias.php" class="admin-cancel-link">Cancelar edición</a>
                <?php endif; ?>

            </form>
        </section>

        <!-- Tabla donde se muestran las categorías guardadas en la base de datos. -->
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

                <!--
                    foreach recorre el arreglo $categorias.
                    Cada categoría encontrada se guarda temporalmente en $cat.
                    Por cada categoría se crea una fila <tr> en la tabla.
                -->
                <?php foreach($categorias as $cat): ?>
                <tr>

                    <!-- Muestra el id de la categoría. -->
                    <td><?= $cat['id'] ?></td>

                    <!-- Muestra el nombre de la categoría de forma segura. -->
                    <td><?= htmlspecialchars($cat['nombre']) ?></td>

                    <!-- Muestra la descripción de la categoría de forma segura. -->
                    <td><?= htmlspecialchars($cat['descripcion']) ?></td>

                    <td>
                        <!--
                            Enlace para editar.
                            Envía el id por la URL usando $_GET.
                            Ejemplo: admin_categorias.php?editar=2
                        -->
                        <a href="?editar=<?= $cat['id'] ?>" class="admin-edit-link">Editar</a>

                        <!--
                            Enlace para eliminar.
                            También envía el id por la URL usando $_GET.
                            Ejemplo: admin_categorias.php?eliminar=2

                            onclick="return confirm('¿Seguro?')" muestra una alerta
                            para confirmar antes de eliminar.
                        -->
                        <a
                            href="?eliminar=<?= $cat['id'] ?>"
                            class="admin-delete-link"
                            onclick="return confirm('¿Seguro?')"
                        >Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </main>
</body>
</html>
