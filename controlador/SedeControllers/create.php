<?php
include ('../../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../../horarios.php');
}

$nombreC=$_POST['nombreC'];
$Direc=$_POST['Direc'];
$phone=$_POST['phone'];

$verificar_nombre_sede_direccion=mysqli_query($conn,"SELECT * FROM sede where nombre_sede='$nombreC' and direccion_sede='$Direc' ");

if (mysqli_num_rows($verificar_nombre_sede_direccion)>0) {
  header("location:../../crear/vista/create-sede.php?vs=2"); 
}else{

$query = "INSERT INTO `sede` (`id`,`nombre_sede`,`direccion_sede`,`telefono_sede`) VALUES (NULL, '$nombreC', '$Direc', '$phone');";
mysqli_query($conn, $query); 

   
header("location:../../vista/crear/create-sede.php?vs=1"); 
      
}


	


?>