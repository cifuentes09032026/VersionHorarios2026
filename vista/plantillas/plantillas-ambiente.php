

<!DOCTYPE html>
<html lang="es">


<head>
  <meta charset="utf-8">
  
  <title>Horarios ambiente <?php if (isset($id_ficha)) {
                          echo $titles['Nombre_ambiente'];
                        }  ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../../css/style.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Font Awesome ---->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../css/css/adminlte.min.css">
  <!-- jQuery-->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery UI -->
  <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../css/js/adminlte.min.js"></script>
  <link rel="shortcut icon" href="../../img/logo1.png" type="image/x-icon">
  <!-- AdminLTE for demo purposes -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
<div>
    <aside id="lt_aside" class="main-sidebar sidebar-dark-primary" style="position: fixed;">
    <a href="../horarios.php" style="color: white;">
    <img src="../../img/logo.png" style="width: 50px;height:50px;margin-left: 10px;margin-top: 5px;">
    <span class="brand-text font-weight-bold">CENIGRAF</span>
  </a>
      <div class="sidebar">
        <div class="user-panel mt-4 pb-4" style="color:white;">
            <i class="nav-icon fas fa-solid fa-user ml-3"></i> 
            <span class="brand-text font-weight-bold"> Admin-<?php echo $inst; ?></span>
        </div>
      </div>
      
          <nav class="mt-2">
          <?php
          $id_ficha = $_GET['amb'];
          
      if (isset($_GET['ped'])) {
        $valVari = mysqli_query($conn, "SELECT * FROM ambiente where id_A=$id_ficha");
        if(mysqli_num_rows($valVari) == 0) { 
          echo "seleccione un boton"
        ?>
        <?php }else{
          $id_fk = $_GET['ped'];?>
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
              <li class="nav-item">
              <a href="../imprimir/horarios_Amb_Im.php?amb=<?php echo $id_ficha; ?>&ped=<?php echo $id_fk?>" class="nav-link" style="color:white;">
              <i class="nav-icon fas fa-solid fa-print"></i>
                  <p>
                    Imprimir | Descargar
                  </p>
                </a>
              </li>
             <?php }}?>  
            <nav class="mt-2">
           
          
            </nav></ul></nav>
    </aside>
  </div>
  </body>
  </html>