<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userDir = "usuarios/$username";
    
    if (is_dir($userDir)) {
        // Validación de contraseña
        $storedPassword = trim(file_get_contents("$userDir/password.txt"));
        if (password_verify($password, $storedPassword)) {
            $_SESSION['username'] = $username;
            registrarEvento("Usuario $username ha iniciado sesión");
            header('Location: muro.php');
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        header('Location: registrar.php');
    }
}

function registrarEvento($mensaje) {
    $logFile = 'log.txt';
    $fecha = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$fecha] $mensaje\n", FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio de sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="POST" action="index.php">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>

