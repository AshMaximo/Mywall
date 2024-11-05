<?php
session_start(); // Inicia la sesión
 require 'Modelo/modelo_usuarios.php'; // con esto requerimos que se incluya la libreria de modelo usuario
 require 'Modelo/modelo_log.php';
// Verifica si el formulario de inicio de sesión ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que se haya ingresado un nombre de usuario y una contraseña
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']); // Obtiene el nombre de usuario
        $password = trim($_POST['password']); // Obtiene la contraseña



        $usuarioEncontrado = verificarUsuario($username, $password); // Bandera para verificar si el usuario existe

        if ($usuarioEncontrado == true) {
            $_SESSION['username'] = $username; // Guarda el nombre de usuario en la sesión
            registrarEvento("El usuario $username ha iniciado sesion");
            header("Location: muro.php"); // Redirige al usuario a su muro
            exit();
        }

        // Si el usuario no fue encontrado o la contraseña es incorrecta
        echo "Nombre de usuario o contraseña incorrectos."; // Muestra un mensaje de error
    }
}
