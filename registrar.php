<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userDir = "usuarios/$username";

    if (!is_dir($userDir)) {
        mkdir($userDir, 0777, true);
        file_put_contents("$userDir/password.txt", $password);
        $_SESSION['username'] = $username;
        registrarEvento("Usuario $username se ha registrado");
        header('Location: muro.php');
    } else {
        echo "El usuario ya existe.";
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
    <title>Registro de usuario</title>
</head>
<body>
    <h2>Registrarse</h2>
    <form method="POST" action="registrar.php">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
