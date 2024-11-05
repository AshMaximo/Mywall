<?php
session_start(); // Inicia la sesión para poder acceder al nombre del usuario actual
require "Modelo/modelo_noticias.php";
require 'Modelo/modelo_log.php';
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Si no ha iniciado sesión, redirige a la página de inicio de sesión
    exit();
}
$username = $_SESSION['username']; // Guarda el nombre del usuario de la sesión en una variable 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'publicar':
            if (isset($_POST['noticia'])) {

                $noticia = $_POST['noticia']; // Contenido de la noticia proporcionado por el usuario

                // Comprueba si el usuario ha subido una imagen junto con la noticia
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

                    $imagen = $_FILES['imagen'];

                    crearNoticiaConImagen($username, $noticia, $imagen);
                    registrarEvento("Usuario $username ha publicado una noticia."); // Registra el evento de publicación en el archivo de log
                } else {
                    crearNoticia($username, $noticia);
                    registrarEvento("Usuario $username ha publicado una noticia."); // Registra el evento de publicación en el archivo de log
                }
            }
            break;
        case 'responder':
            if (isset($_POST['respuesta'])) {
                $noticia = $_POST['noticia'];
                $respuesta = $_POST['respuesta'];
                responderNoticia($username, $noticia, $respuesta);
                registrarEvento("Usuario $username ha respondido una noticia."); // Registra el evento de publicación en el archivo de log
            }
            break;

        case 'meGusta':
            # code...
            break;
    }
}
// Obtiene todas las noticias del usuario
$noticias = glob("usuarios/*/*.txt"); // Busca todos los archivos .txt en el directorio del usuario (cada uno es una noticia)
