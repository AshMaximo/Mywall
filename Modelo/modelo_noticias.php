<?php

function crearNoticia($username, $noticia): bool
{
    $userDir = "usuarios/$username";
    $timestamp = time(); // Obtiene el tiempo actual para nombrar el archivo de la noticia
    $noticiaFile = "$userDir/$timestamp.txt"; // Define el nombre del archivo usando el timestamp


    $noticia = "[$username:$noticia]";
    if (file_put_contents($noticiaFile, $noticia)) { // Guarda la noticia en el archivo de texto
        return true;
    };
    return false;
}

function crearNoticiaConImagen($username, $noticia, $imagen): bool
{
    $userDir = "usuarios/$username";
    $timestamp = time(); // Obtiene el tiempo actual para nombrar el archivo de la noticia
    $noticiaFile = "$userDir/noticia_$timestamp.txt"; // Define el nombre del archivo usando el timestamp

    $imagenTmpPath = $imagen['tmp_name']; // Ruta temporal de la imagen subida
    $imagenName = basename($imagen['name']); // Nombre original de la imagen
    $imagenPath = "$userDir/imagenes/$imagenName"; // Ruta donde se guardará la imagen
    $noticia = "[$username:$noticia]";
    // Mueve la imagen subida a la carpeta del usuario
    if (move_uploaded_file($imagenTmpPath, $imagenPath)) {
        $noticia .= PHP_EOL . "[imagen:$imagenPath]"; // Añade la ruta de la imagen al contenido de la noticia
    }

    if (file_put_contents($noticiaFile, $noticia)) { // Guarda la noticia en el archivo de texto
        return true;
    };
    return false;
}
function responderNoticia($username, $noticia, $respuesta)
{
    $respuesta = "[$username:$respuesta]";
    file_put_contents($noticia, $respuesta, FILE_APPEND);
}
