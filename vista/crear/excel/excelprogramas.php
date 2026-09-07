<?php
// insertar_programa()
include("../../confi/conexion.php");

function insertar_programa($nombre, $nivelTexto) {
  global $conn;
  
  $nombre = trim($nombre);
  $nivelTexto = mb_strtoupper(trim($nivelTexto),'UTF-8');

  if ($nombre=='' || $nivelTexto=='') {
      return ['ok'=>false,'msg'=>'Nombre o nivel vacío'];
  }

  // Convertir texto a nivel numerico
  if ($nivelTexto == 'TECNICO' || $nivelTexto == 'TÉCNICO') {
      $nivel = 1;
  } elseif ($nivelTexto == 'TECNOLOGO' || $nivelTexto=='TECNÓLOGO') {
      $nivel = 2;
  } else {
      return ['ok'=>false,'msg'=>'Nivel desconocido: '.$nivelTexto];
  }

  $nEsc = mysqli_real_escape_string($conn,$nombre);
  $chk = mysqli_query($conn,"SELECT id_program FROM programa WHERE Nom_program='$nEsc'");
  if ($chk && mysqli_num_rows($chk)>0) {
      return ['ok'=>true,'msg'=>'ya existe'];
  }

  $sql="INSERT INTO programa (Nom_program,nivel_form) VALUES('$nEsc',$nivel)";
  if (!mysqli_query($conn,$sql)) {
     return ['ok'=>false,'msg'=>mysqli_error($conn)];
  }
  return ['ok'=>true,'msg'=>'insertado'];
}