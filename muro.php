<?php
include 'Controlador/controlador_muro.php'
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mi Muro</title>
</head>

<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
    <form method="POST" action="muro.php" enctype="multipart/form-data">
        <textarea name="noticia" placeholder="Escribe tu noticia aquí..." required></textarea>
        <input type="hidden" name="action" value="publicar">
        <input type="file" name="imagen" accept="image/*">
        <button type="submit">Publicar</button>
    </form>
    <h3>Log out</h3>
    
    <form method="POST" action="logout.php">
        <button type="submit">Log out</button>
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
            <form method="POST" action="muro.php">
                <input type="hidden" name="noticia" value="<?php echo $noticia; ?>">
                <input type="hidden" name="action" value="responder">
                <input type="text" name="respuesta" placeholder="Escribe una respuesta..." required>
                <button type="submit">Responder</button>
            </form>
            <form method="POST" action="muro.php">
                <input type="hidden" name="noticia" value="<?php echo $noticia; ?>">
                <input type="hidden" name="action" value="meGusta">
                <button type="submit">Like</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>

</html>