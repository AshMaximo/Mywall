<?php
function verificarUsuario($usuario, $contraseña): bool
{
    // Carga la lista de usuarios registrados
    $usersFile = "Modelo/usuarios.txt"; // Archivo que almacena los datos de los usuarios

    if (file_exists($usersFile)) { //Comprobamos que el fichero existe
        $usuariosRegistrados = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Leemos el contenido del fichero
    }

    foreach ($usuariosRegistrados as $usuarioData) {
        list($user, $hashedPassword) = explode(":", $usuarioData); // Extrae el nombre de usuario y la contraseña hasheada
        if ($user === $usuario && password_verify($contraseña, $hashedPassword)) { // Verifica la contraseña
            return true;
        }
    }

    return false; // No hemos encontrado nada por eso devuelve false
}

function existeUsuario($username) : bool {
 // Verifica que el nombre de usuario y la contraseña no están vacíos
 if ($username !== '') {
    $usersFile = "Modelo/usuarios.txt"; // Archivo que almacena la lista de usuarios

    if (file_exists($usersFile)) { //Comprobamos que el fichero existe
        $usuariosRegistrados = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Leemos el contenido del fichero
    }
    foreach ($usuariosRegistrados as $usuarioData) {

        list($usuarioRegistrado, $hashedPassword) = explode(":", $usuarioData); // Extrae el nombre de usuario y la contraseña hasheada

        if ($usuarioRegistrado === $username) {
            return true;
        }
    }return false;
}
}

function crearUsuario($username, $password): bool
{

    // Verifica que el nombre de usuario y la contraseña no están vacíos
    if ($username !== '' && $password !== '') {
        $usersFile = "Modelo/usuarios.txt"; // Archivo que almacena la lista de usuarios

        if (file_exists($usersFile)) { //Comprobamos que el fichero existe
            $usuariosRegistrados = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Leemos el contenido del fichero
        }
        foreach ($usuariosRegistrados as $usuarioData) {

            list($usuarioRegistrado, $hashedPassword) = explode(":", $usuarioData); // Extrae el nombre de usuario y la contraseña hasheada

            if ($usuarioRegistrado === $username) {
                return false;
            }
        }
        // Hashea la contraseña para mayor seguridad
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Almacena el usuario y la contraseña hasheada en el archivo de usuarios
        file_put_contents($usersFile, "$username:$passwordHash" . PHP_EOL, FILE_APPEND);

        // Crea un directorio para el usuario registrado
        $userDir = "usuarios/$username";
        if (!is_dir($userDir)) {
            mkdir($userDir, 0777, true); // Crea el directorio del usuario con permisos completos
        }
        return true;
    }
}
