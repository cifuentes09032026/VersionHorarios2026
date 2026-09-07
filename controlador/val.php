<?php
include('../confi/conexion.php');
session_start();
$email=$_POST['correo'];
$con=md5($_POST['contra']);




$consulta="SELECT * FROM instructor where email='$email' and contrasena='$con'";
$resultado=mysqli_query($conn,$consulta);

$filas=mysqli_fetch_array($resultado);


$_SESSION['rol']=$filas['rol'];
$_SESSION['nam']=$filas['Nombre'];
$_SESSION['IDins']=$filas['ID'];
$_SESSION['ema']=$filas['email'];

if($filas['rol']==1){

    header("location:../vista/horarios.php");

}elseif($filas['rol']==2) {

    header("location:../vista/horarios.php");
}
else{

    
    header("location:../index.php?x=x");


}

mysqli_free_result($resultado);
mysqli_close($conn);

?>