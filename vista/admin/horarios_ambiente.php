<?php
include('../../confi/conexion.php');
session_start();

$correo = $_SESSION['ema'];
$inst = $_SESSION['nam'];

if (!isset($correo)) {
  header("location:../../index.php");
}
$rol = $_SESSION['rol'];
if ($rol == 2) {
  header('location:../horarios.php');
}
if (isset($_GET['amb'])) {

  $id_ficha = $_GET['amb'];
  $_SESSION['amb'] = $id_ficha; // id ficha para eliminar horario
  $title = mysqli_query($conn, "SELECT * FROM ambiente  WHERE  id_A='$id_ficha'");
  $titles = mysqli_fetch_assoc($title);
}
if (isset($_GET['Periodo'])) {
  $_SESSION['Periodo'] = $pedi;
}
?>

<?php
$pageTitle = 'Horarios ambiente';
include("../plantillas/plantillas-ambiente.php");
?>

<body>
 
<div class="content-wrapper">
<br><br>
 
  <center>
  <div> <h3 >Periodos del año <?php echo date('Y'); ?><h3><br></div>
<table >
<tr><TH></TH><TH></TH0><th></th></tr>  
<tr><th>
<a href="1_periodo_amb.php? amb=<?php echo $id_ficha ?>& ped=<?php echo 1?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>I Periodo</p>
                      </a></th>
                      <th>
<a href="2_periodo_amb.php? amb=<?php echo $id_ficha ?>& ped=<?php echo 2?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color:green;">
                        <i class="fas fa-file-export"></i>
                        <p>II Periodo</p>
                      </a></th>
<th>
                      <a href="3_periodo_amb.php? amb=<?php echo $id_ficha ?>& ped=<?php echo 3?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>III Periodo</p>
                      </a></th>

<th>
                      <a href="4_periodo_amb.php? amb=<?php echo $id_ficha ?>& ped=<?php echo 4?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>IV Periodo</p>
                      </a></th></tr>
                    </table></center>
</div>
<?php
?>
</div>
<?php
include("../plantillas/pantilla-footer.php");
?>
</div>
</body>

</html>