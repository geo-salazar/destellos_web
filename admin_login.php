<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //metodo de solicitud del metodo post
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?"); //objeto pdo viene de conexion.php
    $stmt->execute([$email]);
    $user = $stmt->fetch();//fetch solicitud al servidor para obtenr los datos que guarda en la variable user

    // Nota: En producción usa password_verify($password, $user['password_hash'])
    // Para esta prueba validamos que el usuario exista
    if ($user && ($password === $user['password_hash'] || password_verify($password, $user['password_hash']))) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_nombre'] = $user['nombre'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Admin Login | Destellos</title>
</head>
<body class="admin-login-body">
    <section class="auth-card admin-login-card">
        <h2>Admin Destellos</h2>
        
        <?php if(isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        
        <form class="auth-form" method="POST">
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" required placeholder="admin@destellos.com">
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="auth-button">Ingresar al Panel</button>
            <a href="index.php" class="forgot-link">Volver al sitio</a>
        </form>

    </section>
</body>
</html>