<?php
include("../../confi/conexion.php");
session_start();

$correo = $_SESSION['ema'] ?? null;
if (!$correo) {
    header("location:../../index.php");
    exit;
}

$rol = $_SESSION['rol'] ?? null;
if ($rol == 2) {
    header('location:../../horarios.php');
    exit;
}

$fch  = $_SESSION['fh'] ?? null;           // ficha activa (para horarios_ficha.php)
$id   = $_GET['id'] ?? null;               // id_hora (registro a editar)
$ins  = $_POST['instructor'] ?? null;      // nuevo instructor
$days = $_POST['days'] ?? null;            // nuevo día
$hours= $_POST['hour'] ?? null;            // nueva hora
$descripcion = $_POST['descrip'] ?? '';    // nueva descripción
$redirect = $_POST['redirect'] ?? '';      // desde dónde se llamó

if (!$id || !$ins || !$days || !$hours) {
    echo "<script>alert('Faltan datos para actualizar el horario.'); window.history.back();</script>";
    exit;
}

// 1) Obtener datos del registro actual (periodo, año, ambiente) para comparar en el mismo contexto
$sqlActual = "SELECT id_ambiente, period_fk, año_fk FROM horarios WHERE id_hora='$id' LIMIT 1";
$rsActual  = mysqli_query($conn, $sqlActual);
$actual    = mysqli_fetch_assoc($rsActual);

if (!$actual) {
    echo "<script>alert('No se encontró el horario que intenta editar.'); window.history.back();</script>";
    exit;
}

$ambienteActual = $actual['id_ambiente'];
$periodoActual  = $actual['period_fk'];
$anioActual     = $actual['año_fk'];

// 2) Validar conflicto por INSTRUCTOR (mismo día, hora, periodo, año)
$sqlConfInstructor = "
    SELECT 1 
    FROM horarios 
    WHERE instructor = '$ins'
      AND dia = '$days'
      AND hora = '$hours'
      AND period_fk = '$periodoActual'
      AND año_fk = '$anioActual'
      AND id_hora <> '$id'
    LIMIT 1
";
$confInst = mysqli_query($conn, $sqlConfInstructor);

// 3) Validar conflicto por AMBIENTE (mismo día, hora, periodo, año)
$sqlConfAmbiente = "
    SELECT 1 
    FROM horarios 
    WHERE id_ambiente = '$ambienteActual'
      AND dia = '$days'
      AND hora = '$hours'
      AND period_fk = '$periodoActual'
      AND año_fk = '$anioActual'
      AND id_hora <> '$id'
    LIMIT 1
";
$confAmb = mysqli_query($conn, $sqlConfAmbiente);

// 4) Si hay conflictos, avisar y no actualizar
if (mysqli_num_rows($confInst) > 0) {
    echo "<script>
            alert('El instructor ya tiene un horario asignado en ese día y hora.');
            window.history.back();
          </script>";
    exit;
}

if (mysqli_num_rows($confAmb) > 0) {
    echo "<script>
            alert('El ambiente ya está ocupado en ese día y hora.');
            window.history.back();
          </script>";
    exit;
}

// 5) Actualizar
$upd = "UPDATE horarios 
        SET instructor='$ins', dia='$days', hora='$hours', descripcion='$descripcion'
        WHERE id_hora='$id'";

if (!mysqli_query($conn, $upd)) {
    echo "Error al actualizar: " . mysqli_error($conn);
    exit;
}

// 6) Redirección según origen
// Acepto 'insped1' o 'insped1.php' para mayor tolerancia
if (stripos($redirect, 'insped1') !== false) {
    // Vuelvo a la página del (nuevo) instructor
    header("Location: ../../vista/admin/insped1.php?instructor=$ins");
    exit;
}

if (stripos($redirect, 'horarios_ficha') !== false && $fch) {
    header("Location: ../../vista/admin/horarios_ficha.php?ficha=$fch");
    exit;
}

// Fallback
header("Location: ../../vista/admin/horarios.php");
exit;