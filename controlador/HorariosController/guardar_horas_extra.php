<?php
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

$instructor_id = intval($_POST['instructor_id'] ?? 0);
$tipo          = trim($_POST['tipo'] ?? '');
$horas         = floatval($_POST['horas'] ?? 0);
$ambiente_id   = !empty($_POST['ambiente']) ? intval($_POST['ambiente']) : null;
$redirect = trim($_POST['redirect'] ?? '../../vista/admin/insped1.php?instructor=' . $instructor_id);

$dias      = $_POST['dia']   ?? [];
$horas_sel = $_POST['hora'] ?? [];

if ($instructor_id <= 0 || $tipo === '' || $horas <= 0) {
    echo "<script>alert('Por favor completa los campos obligatorios.'); window.history.back();</script>";
    exit;
}

$h_ins = intval($instructor_id);

// -------------------------------
// 🔹 Definir periodo actual
// -------------------------------
$mesActual = date('n');
$periodo = ($mesActual >= 1 && $mesActual <= 6) ? 1 : 2;

// -------------------------------
// 🔹 Calcular horas contratadas
// -------------------------------
$q = "SELECT c.Numero_h 
      FROM instructor i 
      INNER JOIN contrato c ON i.horas_inst = c.id 
      WHERE i.ID = $h_ins";
$r = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($r);
$horas_contrato = isset($row['Numero_h']) ? floatval($row['Numero_h']) : 0;

// -------------------------------
// 🔹 Horas tituladas ya asignadas
// -------------------------------
$q2 = "SELECT COALESCE(SUM(horas_instructor),0) AS total 
       FROM horarios 
       WHERE instructor = $h_ins";
$r2 = mysqli_query($conn, $q2);
$row2 = mysqli_fetch_assoc($r2);
$horas_titulada = floatval($row2['total']);

// -------------------------------
// 🔹 Horas extra ya registradas
// -------------------------------
$q3 = "SELECT COALESCE(SUM(horas),0) AS total_extras 
       FROM horas_extra 
       WHERE instructor_id = $h_ins";
$r3 = mysqli_query($conn, $q3);
$row3 = mysqli_fetch_assoc($r3);
$horas_extras = floatval($row3['total_extras']);

// -------------------------------
// 🔹 Planeación automática (si aplica)
// -------------------------------
$planeacion_auto = 0;
if ($horas_contrato == 32) {
    $qplane = "SELECT COUNT(*) AS tiene_planeacion 
               FROM horas_extra 
               WHERE instructor_id=$h_ins AND tipo='planeacion'";
    $rplane = mysqli_query($conn, $qplane);
    $rp = mysqli_fetch_assoc($rplane);
    if (empty($rp['tiene_planeacion'])) {
        $planeacion_auto = 10.5;
    }
}

// -------------------------------
// 🔹 Calcular horas disponibles
// -------------------------------
// 🟢 SI ES PLANTA (32h): las extras NO afectan las horas tituladas
if ($horas_contrato == 32) {
    $disponibles = 32 - $horas_titulada; // solo 32 horas cuentan
}
// 🟠 SI ES FIJO (40h): funciona igual que siempre
else {
    $disponibles = $horas_contrato - ($horas_titulada + $horas_extras);
}

if ($disponibles < 0) $disponibles = 0;

// -------------------------------
// 🔹 Validar disponibilidad antes de insertar
// -------------------------------
if ($disponibles <= 0) {
    echo "<script>alert('⚠️ No puedes agregar más horas. El instructor ya completó sus $horas_contrato horas.'); window.history.back();</script>";
    exit;
}
if ($horas > $disponibles) {
    echo "<script>alert('⚠️ No puedes agregar $horas horas. Solo quedan $disponibles disponibles.'); window.history.back();</script>";
    exit;
}

// -------------------------------
// 🔹 Insertar horas extra
// -------------------------------
$ok = false;

if (!empty($dias) && !empty($horas_sel)) {
    foreach ($dias as $dia) {
        foreach ($horas_sel as $hora) {
            $stmt = $conn->prepare("
                INSERT INTO horas_extra (instructor_id, tipo, dia, hora, id_ambiente, horas)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("isidid", $instructor_id, $tipo, $dia, $hora, $ambiente_id, $horas);
            $ok = $stmt->execute();
            $stmt->close();
        }
    }
} else {
    $stmt = $conn->prepare("
        INSERT INTO horas_extra (instructor_id, tipo, id_ambiente, horas)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("isid", $instructor_id, $tipo, $ambiente_id, $horas);
    $ok = $stmt->execute();
    $stmt->close();
}

if (!$ok) {
    die("⚠️ Error al guardar: " . $conn->error);
}

header("Location: " . str_replace(array("\r", "\n"), '', $redirect));
exit;
?>

