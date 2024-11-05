<?php   include 'Controlador/controlador_index.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h1>Inicio de Sesión</h1>

    <!-- Formulario de inicio de sesión -->
    <form method="POST" action="index.php">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required> <!-- Campo de nombre de usuario -->

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required> <!-- Campo de contraseña -->

        <button type="submit">Iniciar Sesión</button> <!-- Botón para enviar el formulario -->
    </form>

    <p>¿No tienes una cuenta? <a href="registrar.php">Regístrate aquí</a></p> <!-- Enlace para ir a la página de registro -->
</body>
</html>
