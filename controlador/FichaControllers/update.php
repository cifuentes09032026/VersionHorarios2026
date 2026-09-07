<?php
include("../../confi/conexion.php");
 session_start();

  $correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../horarios.php');
} 
$idfc=$_GET['ubf'];
$fea=$_POST['fich'];
$cantap=$_POST['can_apren'];
$instructor=$_POST['instructor'];
$jor=$_POST['jornad'];
$tipf=$_POST['tipof'];
$cod_prog=$_POST['program'];
$dateI=$_POST['date_i'];
$dateF=$_POST['date_f'];
$inicio_prod=$_POST['inicio_prod'];
$fin_prod=$_POST['fin_prod'];


 $query="UPDATE ficha set `Nº ficha`='$fea',`fc_cant_aprend`='$cantap', `fc_instructor`='$instructor',`fc_jornada`='$jor',`fc_tipo_formacion` ='$tipf',`fic_date_I` ='$dateI', `fic_date_F`='$dateF',`inicio_prod`='$inicio_prod',`fin_prod`='$fin_prod', `fc_id_programa`='$cod_prog' where `ID_F`='$idfc'";
 mysqli_query($conn,$query);
 echo "<script>
     window.location= '../../vista/show-ficha.php?v=1';
      </script>";    
?>