<?php 
include ('../../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];
$instru=$_SESSION['IDins'];//id instructor

if (!isset($correo)) {
    header("location:../index.php");
    
}


$pcon=md5($_POST['contra']);
$scon=md5($_POST['contra2']);


if ($pcon==$scon) {
	mysqli_query($conn,"UPDATE instructor set contrasena='$pcon' where ID = '$instru'");
	 echo "<script>
                  alert('La contraseña fue actualizada exitosamente');
                  window.location= '../../vista/editar/update_usu.php'
              </script>";
}else{
	header("location:../../vista/editar/update_usu.php?pwd_x=cons_not");
}

?>