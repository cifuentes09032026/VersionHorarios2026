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

$nom_p=$_POST['nomp'];
$nivl_p=$_POST['nivel_prog'];


$verificar_nombre_programa=mysqli_query($conn,"SELECT * FROM `programa` where `Nom_program`='$nom_p'");

if (mysqli_num_rows($verificar_nombre_programa)>0) {

header("location:../../vista/crear/create-programa.php?vp=2"); 
  
}else{

$query = "INSERT INTO `programa` (`id_program`,`Nom_program`,`nivel_form`) VALUES (null,'$nom_p','$nivl_p');";
mysqli_query($conn, $query);  

   
header("location:../../vista/crear/create-programa.php?vp=1"); 

}
