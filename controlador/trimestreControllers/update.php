<?php 
include ('../../confi/conexion.php');
 session_start();

  $correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../horarios.php');
}
$id_ficha=$_GET['id_F'];
$id_fech=$_POST['id_fech'];
$date_Iup=$_POST['date_Iup'];
$date_Fup=$_POST['date_Fup'];
$instructor=$_POST['instructor_update'];
$año = $_POST['año_1'];
$periodo = $_POST['periodo_1'];

mysqli_query($conn,"UPDATE tb_trimestre set Trim_date_Inc='$date_Iup', 
Trim_date_fin='$date_Fup', instructor_id='$instructor', año_trim='$año',
  periodo_trim='$periodo' where id_T='$id_fech'");

//actualizar fechas de inicio y fin de la ficha
$consulta1=mysqli_query($conn,"SELECT * FROM tb_trimestre where id_T='$id_fech' and Trimestre='I Trimestre'");
$consulta2=mysqli_query($conn,"SELECT * FROM tb_trimestre where id_T='$id_fech' and Trimestre='VI Trimestre'");

if (mysqli_num_rows($consulta1)>0) {
  mysqli_query($conn,"UPDATE ficha set fic_date_I='$date_Iup' where ID_F=$id_ficha ");
}
if (mysqli_num_rows($consulta2)>0) {
  mysqli_query($conn,"UPDATE ficha set fic_date_F='$date_Fup' where ID_F=$id_ficha ");
}

  
header("location:../../vista/editar/update_trimestre.php?upfech=$id_ficha&v=1"); ?>