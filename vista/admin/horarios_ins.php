<?php
include('../../confi/conexion.php');
session_start();
$correo = $_SESSION['ema'];
$inst = $_SESSION['nam'];
if (!isset($correo)) {
  header("location:../../index.php");
}
$rol = $_SESSION['rol'];



$id_ins = $_GET['instructor'];


?>
<?php
$pageTitle = 'Horarios instructor';

if ($rol == 1) {
  include("../plantillas/plantilla-horarios.php");
}else{
include("../plantillas/plantillan.php");}
?>

<div class="content-wrapper">

 
  <center>
  <div> <h3 >Periodos del año <?php echo date('Y'); ?><h3><br></div>
<table >
<tr><TH></TH><TH></TH0><th></th></tr>  
<tr><th>
<a href="insped1.php?instructor=<?php echo $id_ins ?>& ped=<?php echo 1?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>I Periodo</p>
                      </a></th>
                      <th>
<a href="insped2.php?instructor=<?php echo $id_ins ?>& ped=<?php echo 2?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color:green;">
                        <i class="fas fa-file-export"></i>
                        <p>II Periodo</p>
                      </a></th>
<th>
                      <a href="insped3.php?instructor=<?php echo $id_ins ?>& ped=<?php echo 3?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>III Periodo</p>
                      </a></th>

<th>
                      <a href="insped4.php?instructor=<?php echo $id_ins ?>& ped=<?php echo 4?>" class="nav-link <?php if (isset($_GET['ped']) == "1") {
                       echo "active";
                     }  ?> " style="color: green;">
                        <i class="fas fa-file-export"></i>
                        <p>IV Periodo</p>
                      </a></th></tr>
                    </table></center>
</div>
                  
      

            

</div>
<div style="height: 0.1px;"></div>
<?php
include("../plantillas/pantilla-footer.php");
?>
</div>
</body>

</html>