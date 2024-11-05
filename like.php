<?php
session_start(); // Inicia la sesión para acceder al nombre del usuario actual

// Verifica si los datos necesarios (usuario y noticia) fueron enviados mediante el método POST
if (isset($_POST['usuario'], $_POST['noticia'])) {
    $usuario = $_POST['usuario']; // Nombre del usuario propietario de la noticia
    $noticia = $_POST['noticia']; // Nombre del archivo de la noticia (incluyendo su timestamp)

    // Define la ruta al archivo de la noticia dentro del directorio del usuario
    $noticiaPath = "usuarios/$usuario/$noticia";

    // Verifica que el archivo de la noticia existe
    if (file_exists($noticiaPath)) {
        // Define la ruta para el archivo que almacena los "me gusta" para esta noticia
        $likeFile = $noticiaPath . "_likes.txt";

        // Obtiene el nombre del usuario actual desde la sesión
        $currentUser = $_SESSION['username'];

        // Crea el archivo de "me gusta" si no existe
        if (!file_exists($likeFile)) {
            file_put_contents($likeFile, ""); // Crea un archivo vacío para almacenar los "me gusta"
        }

        // Lee el contenido actual del archivo de "me gusta" y lo convierte en un array de usuarios
        $likes = file($likeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Verifica si el usuario actual ya ha dado "me gusta" a esta noticia
        if (!in_array($currentUser, $likes)) {
            // Si el usuario no ha dado "me gusta", lo agrega al archivo
            file_put_contents($likeFile, $currentUser . PHP_EOL, FILE_APPEND); // Agrega el nombre de usuario al archivo
            registrarEvento("Usuario $currentUser dio 'me gusta' a una noticia de $usuario."); // Registra el evento en el archivo de log
            echo "¡Has dado 'me gusta' a esta noticia!";
        } else {
            echo "Ya has dado 'me gusta' a esta noticia."; // Mensaje si el usuario ya dio "me gusta"
        }
    } else {
        // Si el archivo de la noticia no existe, muestra un mensaje de error
        echo "La noticia no existe.";
    }
} else {
    // Si no se proporcionaron los datos necesarios, muestra un mensaje de error
    echo "Datos incompletos.";
}

// Función para registrar eventos en el archivo de log
function registrarEvento($evento) {
    $logFile = "log.txt"; // Define la ruta al archivo de log
    $fecha = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual
    $mensaje = "[$fecha] $evento" . PHP_EOL; // Formatea el mensaje del evento con la fecha
    file_put_contents($logFile, $mensaje, FILE_APPEND); // Agrega el mensaje al archivo de log
}
?>
