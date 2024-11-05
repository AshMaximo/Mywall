<?php
session_start(); // Inicia la sesión para acceder al usuario actual

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Si no ha iniciado sesión, redirige a la página de inicio de sesión
    exit();
}

$currentUser = $_SESSION['username']; // Obtiene el nombre del usuario actual para mostrarlo en la página
$usersFile = "usuarios.txt"; // Archivo donde se almacenan los datos de los usuarios

// Verifica que el archivo de usuarios existe antes de cargar los usuarios
$usuariosRegistrados = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($currentUser); ?>.</p> <!-- Muestra el nombre del usuario actual -->

    <h2>Lista de Usuarios</h2>
    <ul>
        <?php
        // Itera sobre cada usuario registrado para mostrarlo en la lista
        foreach ($usuariosRegistrados as $usuarioData) {
            list($username) = explode(":", $usuarioData); // Extrae solo el nombre de usuario, omitiendo la contraseña
            if ($username !== $currentUser) { // No muestra el propio usuario en la lista
                // Enlace al perfil del usuario seleccionado para ver su muro
                echo "<li><a href='ver_muro.php?usuario=" . urlencode($username) . "'>" . htmlspecialchars($username) . "</a></li>";
            }
        }
        ?>
    </ul>

    <!-- Enlace para volver al muro del usuario actual -->
    <p><a href="muro.php">Volver a mi muro</a></p>
</body>
</html>
