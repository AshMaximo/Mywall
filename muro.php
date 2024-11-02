<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
$userDir = "usuarios/$username";

// Publicar una noticia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contenido'])) {
    $contenido = $_POST['contenido'];
    $timestamp = date('YmdHis');
    $filename = "$userDir/noticia_$timestamp.txt";
    
    file_put_contents($filename, $contenido . PHP_EOL, FILE_APPEND);
}

// Listar noticias
$noticias = glob("$userDir/*.txt");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mi Muro</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
    <form method="POST" action="muro.php">
        <textarea name="contenido" placeholder="Escribe tu noticia aquí..." required></textarea>
        <button type="submit">Publicar</button>
    </form>

    <h3>Mis Noticias</h3>
    <?php foreach ($noticias as $noticia): ?>
        <div>
            <?php echo nl2br(file_get_contents($noticia)); ?>
            <form method="POST" action="responder.php">
                <input type="hidden" name="noticia" value="<?php echo basename($noticia); ?>">
                <input type="text" name="respuesta" placeholder="Escribe una respuesta..." required>
                <button type="submit">Responder</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
