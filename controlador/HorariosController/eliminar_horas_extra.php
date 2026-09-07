
<?php
// controlador/HorariosController/eliminar_horas_extra.php
include '../../confi/conexion.php';
session_start();

$correo = $_SESSION['ema'] ?? null;
if (!$correo) {
    header("Location: ../../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../vista/admin/horarios.php");
    exit;
}

$id       = isset($_POST['id']) ? intval($_POST['id']) : 0;
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM horas_extra WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// redirigir de vuelta
if (!empty($redirect)) {
    header("Location: ../../vista/admin/" . $redirect);
} else {
    header("Location: ../../vista/admin/insped1.php");
}
exit;
?>