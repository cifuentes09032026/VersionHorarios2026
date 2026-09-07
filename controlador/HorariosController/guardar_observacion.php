<?php
// guardar_observacion.php
session_start();
include '../../confi/conexion.php'; // ajustar si tu ruta es otra

// seguridad básica
$observacion   = isset($_POST['observacion']) ? trim($_POST['observacion']) : '';
$instructor_id = isset($_POST['instructor_id']) ? intval($_POST['instructor_id']) : 0;

if ($instructor_id <= 0 || $observacion === '') {
    // debug rápido: mostrar qué llegó (usar solo mientras depuras)
    // header('Content-Type: application/json'); echo json_encode($_POST); exit;
    echo "Faltan datos obligatorios.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO observaciones (instructor_id, observacion, fecha) VALUES (?, ?, NOW())");
if (!$stmt) {
    die("Error prepare: " . $conn->error);
}
$stmt->bind_param("is", $instructor_id, $observacion);
if ($stmt->execute()) {
    // si quieres redirigir al mismo instructor:
    header("Location: ../../vista/admin/insped3.php?instructor=".$instructor_id);
    exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}
?>
