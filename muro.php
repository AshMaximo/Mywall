<?php
session_start();
function registrarEvento($mensaje) {
    $logFile = 'log.txt';
    $fecha = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$fecha] $mensaje\n", FILE_APPEND);
}
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
$userDir = "usuarios/$username";

// Publicar noticia e imagen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contenido'])) {
    $contenido = $_POST['contenido'];
    $timestamp = date('YmdHis');
    $filename = "$userDir/noticia_$timestamp.txt";
    
    file_put_contents($filename, $contenido . PHP_EOL, FILE_APPEND);
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imgDir = "$userDir/imagenes";
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true);
        }
        $imagenPath = "$imgDir/" . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenPath);
        file_put_contents($filename, "[imagen:$imagenPath]" . PHP_EOL, FILE_APPEND);
    }
    registrarEvento("Usuario $username publicó una noticia con imagen.");
}

$noticias = glob("$userDir/*.txt");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mi Muro</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
    <form method="POST" action="muro.php" enctype="multipart/form-data">
        <textarea name="contenido" placeholder="Escribe tu noticia aquí..." required></textarea>
        <input type="file" name="imagen" accept="image/*">
        <button type="submit">Publicar</button>
    </form>

    <h3>Mis Noticias</h3>
    <?php foreach ($noticias as $noticia): ?>
    <div>
        <?php
        $contenido = file_get_contents($noticia);
        $lineas = explode(PHP_EOL, $contenido);
        foreach ($lineas as $linea) {
            // Verificar si la línea contiene una imagen
            if (strpos($linea, '[imagen:') === 0) {
                $imagenPath = substr($linea, 8, -1); // Extrae la ruta de la imagen
                echo "<img src='$imagenPath' alt='Imagen de la noticia' style='max-width: 100%; height: auto;'><br>";
            } else {
                echo nl2br($linea) . "<br>";
            }
        }
        ?>
        <form method="POST" action="responder.php">
            <input type="hidden" name="noticia" value="<?php echo basename($noticia); ?>">
            <input type="text" name="respuesta" placeholder="Escribe una respuesta..." required>
            <button type="submit">Responder</button>
        </form>
    </div>
<?php endforeach; ?>
</body>
</html>
