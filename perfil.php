<?php
session_start(); // Inicia la sesión para tener acceso a los datos del usuario actual

// Verifica si el nombre del usuario a visitar está en los parámetros GET de la URL
if (!isset($_GET['usuario'])) {
    die("Usuario no especificado."); // Si no hay un usuario especificado, detiene la ejecución con un mensaje de error
}

$usuario = $_GET['usuario']; // Almacena el nombre del usuario en una variable
$userDir = "usuarios/$usuario"; // Establece la ruta al directorio del usuario seleccionado

// Verifica si el directorio del usuario existe
if (!is_dir($userDir)) {
    die("El perfil de usuario no existe."); // Si el directorio no existe, muestra un mensaje de error y termina
}

// Incrementa el contador de visitas al perfil del usuario
$contadorFile = "$userDir/visitas.txt"; // Archivo donde se almacena el contador de visitas
$visitas = file_exists($contadorFile) ? (int)file_get_contents($contadorFile) : 0; // Lee el número de visitas si el archivo existe; si no, lo inicializa en 0
$visitas++; // Aumenta el contador de visitas en 1
file_put_contents($contadorFile, $visitas); // Guarda el nuevo valor en el archivo de visitas
registrarEvento("El perfil de $usuario ha sido visitado."); // Registra la visita en el archivo de log

// Obtiene todos los archivos de noticias del usuario
$noticias = glob("$userDir/*.txt"); // Busca todos los archivos .txt en el directorio del usuario, donde cada uno representa una noticia
?>

<!-- Muestra el nombre del perfil visitado y el número de visitas al perfil -->
<h1>Perfil de <?php echo htmlspecialchars($usuario); ?></h1>
<p>Visitas al perfil: <?php echo $visitas; ?></p>

<!-- Muestra cada noticia del usuario -->
<h2>Publicaciones</h2>
<?php foreach ($noticias as $noticia): ?>
    <div>
        <?php
        // Lee el contenido del archivo de noticia y lo divide en líneas
        $contenido = file_get_contents($noticia);
        $lineas = explode(PHP_EOL, $contenido);

        // Recorre cada línea del contenido de la noticia
        foreach ($lineas as $linea) {
            // Si la línea contiene una imagen, la muestra
            if (strpos($linea, '[imagen:') === 0) {
                $imagenPath = substr($linea, 8, -1); // Extrae la ruta de la imagen del texto
                echo "<img src='$imagenPath' alt='Imagen de la noticia' style='max-width: 100%; height: auto;'><br>"; // Muestra la imagen con un estilo responsivo
            } else {
                echo nl2br($linea) . "<br>"; // Muestra la línea de texto normal, permitiendo saltos de línea
            }
        }
        ?>

        <!-- Formulario para responder a la noticia -->
        <form method="POST" action="responder.php">
            <!-- Envia el nombre del usuario y el archivo de la noticia para identificar la noticia -->
            <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
            <input type="hidden" name="noticia" value="<?php echo basename($noticia); ?>">
            <input type="text" name="respuesta" placeholder="Escribe una respuesta..." required> <!-- Campo de texto para la respuesta -->
            <button type="submit">Responder</button> <!-- Botón para enviar la respuesta -->
        </form>

        <!-- Formulario para dar "me gusta" a la noticia -->
        <form method="POST" action="like.php">
            <!-- Envia el nombre del usuario y el archivo de la noticia para registrar el "me gusta" -->
            <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
            <input type="hidden" name="noticia" value="<?php echo basename($noticia); ?>">
            <button type="submit">Me gusta</button> <!-- Botón para dar "me gusta" -->
        </form>
    </div>
<?php endforeach; ?>
