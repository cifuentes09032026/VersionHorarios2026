<?php
session_start();
include "../../confi/conexion.php";

$correo = $_SESSION['ema'] ?? null;
if (!$correo) {
    header("Location: ../../index.php");
    exit;
}

$rol = $_SESSION['rol'] ?? null;
if ($rol == 2) {
    header("Location: ../horarios.php");
    exit;
}

$fch = $_SESSION['fh'] ?? null;

// Obtener id (preferible via POST, respaldo GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eliminar = isset($_POST['eli']) ? intval($_POST['eli']) : 0;
} else {
    $eliminar = isset($_GET['eli']) ? intval($_GET['eli']) : 0;
}

if (!$eliminar) {
    echo "<script>alert('No se especificó el registro a eliminar.'); window.history.back();</script>";
    exit;
}

// Ejecutar eliminación (usar prepared statement)
$stmt = $conn->prepare("DELETE FROM horarios WHERE id_hora = ?");
if ($stmt === false) {
    echo "<script>alert('Error prepare: " . htmlspecialchars($conn->error) . "'); window.history.back();</script>";
    exit;
}
$stmt->bind_param("i", $eliminar);
$ok = $stmt->execute();
$err = $stmt->error;
$stmt->close();

if (!$ok) {
    echo "<script>alert('Error al eliminar: " . addslashes($err) . "'); window.history.back();</script>";
    exit;
}

// Determinar redirect (POST tiene prioridad)
$redirect = '';
$instructor = $_POST['instructor'] ?? $_GET['instructor'] ?? null;
$periodo    = $_POST['periodo']    ?? $_GET['periodo']    ?? null;
$redirect_param = $_POST['redirect'] ?? $_GET['redirect'] ?? null;

// Si me pasaron instructor+periodo, volver a insped1 con esos parámetros
if (!empty($instructor) && !empty($periodo)) {
    $id_ins = intval($instructor);
    $periodo = intval($periodo);
    header("Location: ../../vista/admin/insped1.php?instructor={$id_ins}&ped={$periodo}");
    exit;
}

// Si se pasó un redirect personalizado
if (!empty($redirect_param)) {
    header("Location: ../../vista/admin/" . $redirect_param);
    exit;
}

// Por defecto volver a la vista de la ficha (antiguo comportamiento)
header("Location: ../../vista/admin/horarios_ficha.php?ficha={$fch}");
exit;
