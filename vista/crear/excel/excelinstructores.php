<?php
include("../../confi/conexion.php");


function insertar_instructor($nombre, $apellido, $email, $rol, $horas_inst_id) {
  global $conn;

  // Limpieza básica
  $nombre = trim($nombre);
  $apellido = trim($apellido);
  $email = trim($email);
  $rol = (int)$rol;
  $horas_inst_id = (int)$horas_inst_id;

  if ($nombre === '' || $email === '') {
    echo "<p style='color:#c00'>❌ Fila omitida: nombre y correo son obligatorios.</p>";
    return false;
  }

  // 1) Validar contrato
  $qContrato = mysqli_query($conn, "SELECT id FROM contrato WHERE id = $horas_inst_id");
  if (!$qContrato || mysqli_num_rows($qContrato) === 0) {
    echo "<p style='color:#c00'>❌ No existe contrato con ID $horas_inst_id para $nombre $apellido.</p>";
    return false;
  }

  // 2) Evitar duplicados por correo
  $emailEsc = mysqli_real_escape_string($conn, $email);
  $dup = mysqli_query($conn, "SELECT ID FROM instructor WHERE email = '$emailEsc' LIMIT 1");
  if ($dup && mysqli_num_rows($dup) > 0) {
    echo "<p style='color:#a60'>⚠️ Ya existía: $email ($nombre $apellido). Omitido.</p>";
    return false;
  }

  // 3) Insertar
  $nombreEsc = mysqli_real_escape_string($conn, $nombre);
  $apellidoEsc = mysqli_real_escape_string($conn, $apellido);

  $sql = "INSERT INTO instructor (Nombre, Apellido, email, rol, horas_inst)
          VALUES ('$nombreEsc', '$apellidoEsc', '$emailEsc', $rol, $horas_inst_id)";
  $ok = mysqli_query($conn, $sql);

  if (!$ok) {
    echo "<p style='color:#c00'>❌ Error insertando $nombre $apellido: " . mysqli_error($conn) . "</p>";
    return false;
  }

  return true;
}