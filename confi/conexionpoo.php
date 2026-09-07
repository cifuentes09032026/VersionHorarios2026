<?php
require_once 'conexion.php';

// Clase contenedora para compatibilidad
class Conexion {
    public $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getConexion() {
        return $this->conn;
    }
}
?>