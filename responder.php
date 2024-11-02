<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['respuesta'])) {
    $respuesta = $_POST['respuesta'];
    $noticia = $_POST['noticia'];
    $usuario = $_POST['usuario'] ?? $_SESSION['username'];
    $filePath = "usuarios/$usuario/$noticia";
    
    if (file_exists($filePath)) {
        $contenido = "\nRespuesta de " . $_SESSION['username'] . ": $respuesta\n";
        file_put_contents($filePath, $contenido, FILE_APPEND);
    }
    header("Location: usuario.php?usuario=$usuario");
}
?>
