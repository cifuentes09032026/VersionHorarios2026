<?php 
include ('../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../vista/horarios.php');
}

$ficha=$_GET['fich'];
$estado=$_GET['est'];
$trim_f=$_SESSION['trim'];

$verificarEstadoFicha=mysqli_query($conn,"SELECT * FROM tb_trimestre where id_fch=$ficha and estatus_trim_H=0");



	if ($estado==1) {
		if (mysqli_num_rows($verificarEstadoFicha)>0) {
		echo "<script>
	          alert('La ficha ya tiene un horario activo.');
	          window.location= '../vista/admin/horarios_ficha.php?ficha=$ficha'
	        </script>";
	  }else{
		 mysqli_query($conn,"UPDATE tb_trimestre set estatus_trim_H=0 where id_fch=$ficha and Trimestre='$trim_f'");
		 header("location:../vista/admin/horarios_ficha.php?ficha=$ficha");			
	  }
	}elseif ($estado==2) {
		mysqli_query($conn,"UPDATE tb_trimestre set estatus_trim_H=1 where id_fch=$ficha and Trimestre='$trim_f'");
		header("location:../vista/admin/horarios_ficha.php?ficha=$ficha");
	}



 ?>