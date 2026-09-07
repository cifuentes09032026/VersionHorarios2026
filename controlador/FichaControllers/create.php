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


$fich=$_POST['fich'];
$cantap=$_POST['can_apren'];
$nivel=$_POST['nivel_prog'];
$instructor=$_POST['instructor'];
$jor=$_POST['jornad'];
$tipf=$_POST['tipof'];
$cod_prog=$_POST['program'];
$dateI=$_POST['date_i'];
$dateF=$_POST['date_f'];
$inicio_prod=$_POST['inicio_prod'];
$fin_prod=$_POST['fin_prod'];





 

$verificarficha= mysqli_query($conn,"SELECT * FROM `ficha` where `Nº ficha`='$fich'");

if (mysqli_num_rows($verificarficha) > 0) {

    //-----------fichaexise
	
    header("location:../../vista/crear/create-ficha.php?vl=2");	
}else{
	 $query = "INSERT INTO `ficha` (`ID_F`, `Nº ficha`,`fc_cant_aprend`,`fc_nivel`,`fc_instructor`,`fc_jornada`,`fc_tipo_formacion`,`fic_date_I`,`fic_date_F`,`inicio_prod`,`fin_prod`,`fc_id_programa`,`estatus_trim`) VALUES (NULL, '$fich', '$cantap', '$nivel','$instructor', '$jor', '$tipf','$dateI','$dateF','$inicio_prod','$fin_prod','$cod_prog','1');";
     mysqli_query($conn, $query); 
	 
   
    header("location:../../vista/crear/create-ficha.php?vl=1"); 
  	
}

	


  ?>