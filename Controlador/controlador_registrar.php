<?php 
require 'Modelo/modelo_usuarios.php';
require 'Modelo/modelo_log.php';
// Verifica si el formulario de registro ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que el formulario contiene un nombre de usuario y una contraseña
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']); // Obtiene el nombre de usuario ingresado y elimina espacios en blanco
        $password = trim($_POST['password']); // Obtiene la contraseña ingresada y elimina espacios en blanco
        $existeUsuario = existeUsuario($username);
        if ($existeUsuario == true) {
            echo ("El usuario ya existe");
        } else {
            $usuarioCreado = crearUsuario($username, $password);
            if ($usuarioCreado == true) {
                // Redirige al usuario a la página de inicio de sesión
                registrarEvento("El usuario $username se ha registrado");
                header("Location: index.php");
                exit();
            } else {
                echo "Por favor, ingresa un nombre de usuario y una contraseña válidos."; // Mensaje de error si faltan datos
            }
        }
    }
}
