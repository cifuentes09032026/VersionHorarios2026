<?php
require_once 'conf.php';

// Crear conexión global
$conn = new mysqli(SERVER, USER, PASS, DB);
$conn->set_charset(DB_CHARSET);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
