<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'buffet');

// Función para obtener conexión a la base de datos
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        return false; // Retornar false en lugar de die()
    }
    
    $conn->set_charset("utf8");
    return $conn;
}

// Función para cerrar conexión
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>
