<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['usuario'])) {
    $username = $_GET['usuario'];
    $userDir = "usuarios/$username";
    if (!is_dir($userDir)) {
        die("El usuario no existe.");
    }
    $noticias = glob("$userDir/*.txt");
} else {
    die("Usuario no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Muro de <?php echo htmlspecialchars($username); ?></title>
</head>
<body>
    <h2>Muro de <?php echo htmlspecialchars($username); ?></h2>
    
    <h3>Noticias</h3>
    <?php foreach ($noticias as $noticia): ?>
        <div>
            <?php echo nl2br(file_get_contents($noticia)); ?>
            <form method="POST" action="responder.php">
                <input type="hidden" name="noticia" value="<?php echo basename($noticia); ?>">
                <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($username); ?>">
                <input type="text" name="respuesta" placeholder="Escribe una respuesta..." required>
                <button type="submit">Responder</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
