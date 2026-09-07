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

$ficha_fechas=$_POST['ficha_fecha'];

// ✅ Validación: que no esté vacío
if (empty($ficha_fechas)) {
  echo '
  <script>
      alert("⚠️ Debes seleccionar una ficha antes de continuar.");
      window.location = "../../vista/crear/tecnologo_crear_trim.php";
  </script>';
  exit();
}

// 🚨 VERIFICACIÓN: ¿Ya existen trimestres para esta ficha?
$verificar = mysqli_query($conn, "SELECT * FROM tb_trimestre WHERE id_fch = '$ficha_fechas'");
if (mysqli_num_rows($verificar) > 0) {
    echo '
    <script>
        alert("⚠️ Esta ficha ya tiene trimestres registrados.");
        window.location = "../../vista/show-ficha.php";
    </script>';
    exit();
}


$date_i_I=$_POST['date_i_I'];      $date_f_I=$_POST['date_f_I']; $instructor_1=$_POST['instructor_1']; $periodo_1=$_POST['periodo_1'];  $año_1=$_POST['año_1'];
$date_i_II=$_POST['date_i_II'];    $date_f_II=$_POST['date_f_II']; $instructor_2=$_POST['instructor_2'];$periodo_2=$_POST['periodo_2'];  $año_2=$_POST['año_2'];
$date_i_III=$_POST['date_i_III'];  $date_f_III=$_POST['date_f_III']; $instructor_3=$_POST['instructor_3'];$periodo_3=$_POST['periodo_3'];  $año_3=$_POST['año_3'];
$date_i_IV=$_POST['date_i_IV'];    $date_f_IV=$_POST['date_f_IV']; $instructor_4=$_POST['instructor_4'];$periodo_4=$_POST['periodo_4'];  $año_4=$_POST['año_4'];
$date_i_V=$_POST['date_i_V'];      $date_f_V=$_POST['date_f_V']; $instructor_5=$_POST['instructor_5'];$periodo_5=$_POST['periodo_5'];   $año_5=$_POST['año_5'];
$date_i_VI=$_POST['date_i_VI'];    $date_f_VI=$_POST['date_f_VI']; $instructor_6=$_POST['instructor_6'];$periodo_6=$_POST['periodo_6'];  $año_6=$_POST['año_6'];
$date_i_VII=$_POST['date_i_VII'];  $date_f_VII=$_POST['date_f_VII']; $instructor_7=$_POST['instructor_7'];$periodo_7=$_POST['periodo_7'];  $año_7=$_POST['año_7'];

$trim_I="1";
$trim_II=" 2";
$trim_III="3 ";
$trim_IV="4 ";
$trim_V="5 ";
$trim_VI=" 6";
$trim_VII="7";


 $query = "INSERT INTO `tb_trimestre` (`id_T`,`Trim_date_Inc`,`Trim_date_fin`,`Trimestre`,`id_fch`, `instructor_id`,`estatus_trim_H`,`año_trim`,`periodo_trim`) VALUES 
     (NULL, '$date_i_I', '$date_f_I','$trim_I','$ficha_fechas','$instructor_1','1','$año_1','$periodo_1'),
     (NULL,'$date_i_II', '$date_f_II','$trim_II','$ficha_fechas','$instructor_2','0','$año_2','$periodo_2'),
     (NULL,'$date_i_III', '$date_f_III','$trim_III','$ficha_fechas','$instructor_3','0','$año_3','$periodo_3'),
     (NULL,'$date_i_IV', '$date_f_IV','$trim_IV','$ficha_fechas','$instructor_4','0','$año_4','$periodo_4'),
     (NULL,'$date_i_V', '$date_f_V','$trim_V','$ficha_fechas','$instructor_5','0','$año_5','$periodo_5'),
     (NULL,'$date_i_VI','$date_f_VI','$trim_VI','$ficha_fechas','$instructor_6','0','$año_6','$periodo_6'),
     (NULL,'$date_i_VII','$date_f_VII','$trim_VII','$ficha_fechas','$instructor_7','0','$año_7','$periodo_7')";
 $querys=mysqli_query($conn,"UPDATE ficha set `estatus_trim`=1 where ID_F='$ficha_fechas'");
 
  
	mysqli_query($conn, $query); 
	 
  echo'
  <script>
     alert("Fechas registradas");
     window.location = "../../vista/show-ficha.php";
  </script>';
  
  ?>