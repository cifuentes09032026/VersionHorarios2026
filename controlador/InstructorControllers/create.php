<?php
include ('../../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../../index.php");
}
$rols=$_SESSION['rol'];
 if ($rols==2) {
   header('location:../../horarios.php');
}

$email=$conn->real_escape_string($_POST['correo']);
$nom=$conn->real_escape_string($_POST['nombre']);
$ape=$conn->real_escape_string($_POST['apellido']);
$horasi=$conn->real_escape_string($_POST['horas_inst']);
$rol=$conn->real_escape_string($_POST['rol']);
$pcon=md5($_POST['contra']);
$scon=md5($_POST['contra2']);



$verificarcorreo= mysqli_query($conn,"SELECT * FROM instructor where email='$email' LIMIT 1");


if (mysqli_num_rows($verificarcorreo) > 0) {

    //------------------
    header("location:../../vista/crear/create-instructor.php?v=2");	
}
elseif($pcon==$scon) {
	$query = "INSERT INTO `instructor` (`ID`, `Nombre`, `Apellido`, `horas_inst`, `email`, `contrasena`, `rol`) VALUES (NULL,'$nom','$ape','$horasi', '$email','$pcon','$rol')";
  
    mysqli_query($conn, $query);
    header("location:../../vista/crear/create-instructor.php?v=1"); 
  	
	 
	 
}else {
    
    header("location:../../vista/crear/create-instructor.php?v=3"); 
}
  ?>

  