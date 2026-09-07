<?php
include('../../confi/conexion.php');
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
  echo json_encode(['ok' => false, 'error' => 'Falta el ID del instructor']);
  exit;
}

$id_instructor = intval($_GET['id']);

// Obtener horas contrato reales
$query_contrato = "
  SELECT c.Numero_h
  FROM instructor i
  JOIN contrato c ON i.horas_inst = c.id
  WHERE i.ID = $id_instructor
";
$res_contrato = mysqli_query($conn, $query_contrato);
$row_contrato = mysqli_fetch_assoc($res_contrato);
$horas_contrato = intval($row_contrato['Numero_h'] ?? 0);

// 1) Horas normales (horarios) -> cada bloque ya debe estar guardado como "horas_instructor" o calcular bloques*2
$query_normales = "
  SELECT COALESCE(SUM(horas_instructor), 0) AS horas_normales
  FROM horarios
  WHERE instructor = $id_instructor
";
$res_normales = mysqli_query($conn, $query_normales);
$horas_normales = floatval(mysqli_fetch_assoc($res_normales)['horas_normales'] ?? 0);

// 2) Horas extras SUM (por tipo)
$query_extras = "
  SELECT COALESCE(SUM(horas),0) AS horas_extras
  FROM horas_extra
  WHERE instructor_id = $id_instructor
    AND tipo <> 'planeacion'   -- no contar planeacion aquí
";
$res_extras = mysqli_query($conn, $query_extras);
$horas_extras = floatval(mysqli_fetch_assoc($res_extras)['horas_extras'] ?? 0);

// 3) Planeacion (separada)
$query_plane = "
  SELECT COALESCE(SUM(horas),0) AS horas_planeacion
  FROM horas_extra
  WHERE instructor_id = $id_instructor
    AND tipo = 'planeacion'
";
$res_plane = mysqli_query($conn, $query_plane);
$horas_planeacion_db = floatval(mysqli_fetch_assoc($res_plane)['horas_planeacion'] ?? 0);

// 4) Planeacion automática: solo si contrato == 32 (planta) y no existe planeacion manual
$planeacion_auto = 0.0;
if ($horas_contrato == 32 && $horas_planeacion_db == 0.0) {
  $planeacion_auto = 10.5;
}

// 5) Cálculo final
// Horas que cuentan contra el límite del contrato:
$horas_que_cuentan = $horas_normales + $horas_extras; // NO sumamos planeacion_auto ni planeacion_db aquí

// Horas restantes (solo contrato)
$horas_restantes = max($horas_contrato - $horas_que_cuentan, 0);

// Respuesta JSON (incluimos planeación por separado para mostrar)
echo json_encode([
  'ok' => true,
  'horas_contrato' => $horas_contrato,
  'horas_normales' => $horas_normales,
  'horas_extras' => $horas_extras,
  'horas_planeacion_db' => $horas_planeacion_db,
  'planeacion_auto' => $planeacion_auto,
  'horas_que_cuentan' => $horas_que_cuentan,
  'horas_restantes' => $horas_restantes
]);
