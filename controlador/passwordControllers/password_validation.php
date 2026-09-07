<?php 
include ('../../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];
$instru=$_SESSION['IDins'];//id instructor

if (!isset($correo)) {
    header("location:../index.php");
}

$D_pwds=md5($_POST['D_pwd']);

  $verificar_pwd=mysqli_query($conn,"SELECT * FROM instructor where ID='$instru' and contrasena='$D_pwds'");

  if (mysqli_num_rows($verificar_pwd)>0) {
    header("location:../../vista/editar/update_usu.php?pwd=$D_pwds");

  }else{
    header("location:../../vista/editar/update_usu.php?pwd_x=20123554_d");
  }

 ?>