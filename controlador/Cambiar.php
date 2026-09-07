<?php

if(!isset($_POST['editar'])){
  include_once '../vista/olvicontra.php';  
  require ('conexion.php');
  $usser = "beta_horarios";

  $pass1 = $mysqli->real_escape_string($_POST['pass1']); 
  $pass2 = $mysqli->real_escape_string($_POST['pass2']); 
  
  $pass1 = md5($pass1);
  $pass2 = md5($pass2);

  $sqlA = $mysqli->query("SELECT contrasena FROM intructor WHERE ID = '".$_SESSION['ID']."'");


  if ($pass1 == $pass2) {
      $update = $mysqli->query("UPDATE intrusctor SET contrasena = '$pass1' WHERE ID = '".$_SESSION['ID']."'");
      if($update)   {echo "se ha actualizado la contraseña" ;}
  }
  else {
      echo "la contraseña no coinciden";
}
}
?>

