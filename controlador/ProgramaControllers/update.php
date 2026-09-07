<?php
include("../../confi/conexion.php");
 session_start();

  $correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../../horarios.php');
}
$idpo=$_GET['ubPO'];
$nom_p=$_POST['nomp'];
$nivl_p=$_POST['nivel_prog'];



$query="UPDATE `programa` set `Nom_program`='$nom_p', 
`nivel_form`='$nivl_p' where `id_program`='$idpo'";
 mysqli_query($conn,$query);
 echo "<script>
 window.location= '../../vista/show-programa.php?v=1';
</script>";    





?>