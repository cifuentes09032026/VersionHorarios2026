<?php
$pageTitle = 'Horario';
include("parte_superior.php")
?>


<div class="content-wrapper">
  <div class="container">
    <div class="container">
      <?php
      if ($rol == 1) {
        echo "<br><h3>Bienvenido " . $inst . "</h3>";
      } elseif ($rol == 2) {
        echo "<br><h3>Bienvenido Instructor " . $inst . "</h3>";
      }

      ?>
    </div>
    <br>
        
    </div>
  </div>
</div>
<?php
include("parte_inferior.php")
?>