<?php
// Función para registrar eventos en el archivo de log
function registrarEvento(string $evento)
{
    $logFile = "log.txt"; // Define la ruta al archivo de log
    $fecha = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual
    $mensaje = "[$fecha] $evento" . PHP_EOL; // Formatea el mensaje de evento con la fecha
    file_put_contents($logFile, $mensaje, FILE_APPEND); // Agrega el mensaje al archivo de log
}
