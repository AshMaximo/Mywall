<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $userDir = "usuarios/$username";
    
    if (!is_dir($userDir)) {
        mkdir($userDir, 0777, true); // Crear el directorio del usuario si no existe
    }
    
    $_SESSION['username'] = $username;
    header('Location: muro.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio de sesión</title>
</head>
<body>
    <h2>Inicio de sesión / Registro</h2>
    <form method="POST" action="index.php">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
