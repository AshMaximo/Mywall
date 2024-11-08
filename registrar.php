<?php
include "Controlador/controlador_registrar.php"; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>

    <!-- Formulario de registro de usuario -->
    <form method="POST" action="registrar.php">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required> <!-- Campo de nombre de usuario -->

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required> <!-- Campo de contraseña -->

        <button type="submit">Registrarse</button> <!-- Botón para enviar el formulario -->
    </form>

    <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p> <!-- Enlace para ir a la página de inicio de sesión -->
</body>
</html>
