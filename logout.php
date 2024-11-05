<?php 
session_start();
$_SESSION = array();
require 'Modelo/modelo_log.php';
registrarEvento("Usuario $username ha salido.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Has salido de tu sesión</h1>
    
    <h2><a href="index.php">Inicia sesión aquí</a></h2>
</body>
</html>