<?php
session_start();
include('../confi/conexion.php');
$correo = $_SESSION['ema']; //email usuario
$rol = $_SESSION['rol']; //rol usuario
$inst = $_SESSION['nam']; //nombre instructor (usuario)
$instru = $_SESSION['IDins']; //id instructor
if (!isset($correo)) {
  header("location:../index.php");
}

if (isset($_GET['Trimestres'])) {
  $tm_fch = $_GET['Trimestres'];
  $_SESSION['trim'] = $tm_fch;
}

if (isset($_GET['ficha'])) {
  $fch = $_GET['ficha'];
  $_SESSION['fch_cons'] = $fch;
  //validar datos en horario
  $validacion_horario = mysqli_query($conn, "SELECT * FROM horarios where ficha=$fch");
  $ValH = mysqli_fetch_array($validacion_horario);
  if (!isset($ValH['ficha'])) {
    echo "<script>
    window.location= 'show-ficha.php?v=2' 
     </script>";
  }
}
$id_fch_cons = $_SESSION['fch_cons'];

$fh = mysqli_query($conn, "SELECT * FROM ficha WHERE ID_F = '$id_fch_cons'");
$rwfh = mysqli_fetch_array($fh);

$programa = $_GET['pro'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Horario Ficha <?php echo $rwfh['Nº ficha']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../css/css/adminlte.min.css">
  <link rel="shortcut icon" href="../img/logo1.png" type="image/x-icon">
</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
  <!--divnav-->
  <div>
    <nav id="lt_nav" class="main-header navbar navbar-expand-md navbar-orange navbar-light sticky-top">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <a class="navbar-brand" onclick="window.open('horarios.php','_Self')" style="cursor: pointer; font-weight: bold; color:white;">Cenigraf</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
              Perfil
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="update_usu.php">Cambiar contraseña</a></li>
              <li><a class="dropdown-item" onclick="window.open('../controlador/exit.php','_Self')" style="cursor: pointer"> Cerrar sesión</a></li>
              
            </ul>
          </li>
    </nav>
  </div>
  <!--/divnav-->
  <!--lateral-->
  <div>
    <aside id="lt_aside" class="main-sidebar sidebar-dark-primary" style="position: fixed;">
    <a href="horarios.php" style="color: white;">
    <img src="../img/logo.png" style="width: 50px;height:50px;margin-left: 10px;margin-top: 5px;">
    <span class="brand-text font-weight-bold">CENIGRAF</span>
  </a>
      <div class="sidebar">
        <div class="user-panel mt-4 pb-4" style="color:white;">
            <i class="nav-icon fas fa-solid fa-user ml-3"></i> 
            <span class="brand-text font-weight-bold"> Admin-<?php echo $inst; ?></span>
        </div>
      </div>
        <?php
        if (isset($_GET['Trimestres'])) {
        ?>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
              <li class="nav-item">
                <a href="imprimir/horarios_ficha_Im.php?fich=<?php echo $id_fch_cons; ?>&pro=<?php echo $programa; ?>" class="nav-link" style="color:white;">
                  <i class="nav-icon fas fa-solid fa-print"></i>
                  <p>
                    Imprimir | Descargar
                  </p>
                </a>
              </li>
            <?php
            
          }
            ?>
            <nav class="mt-2">
            <nav class="mt-2"><?php if (isset($_GET['ficha'])) {
        $valVari = mysqli_query($conn, "SELECT * FROM ficha where ID_F=$fch and fc_nivel='2'");
        if(mysqli_num_rows($valVari) == 1) {?>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link" style="color:white;">
                    <i class=" far fa-calendar-alt fa-lg"></i>
                    <p>
                      Trimestres
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=1 Trimestre&IT=1&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IT']) == "1") {
                                                                                                                      echo "active";
                                                                                                                    }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>I Trimestre</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=2 Trimestre&IIT=2&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IIT']) == "2") {
                                                                                                                        echo "active";
                                                                                                                      }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>II Trimestre</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=3 Trimestre&IIIT=3&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IIIT']) == "3") {
                                                                                                                          echo "active";
                                                                                                                        }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>III Trimestre</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=4 Trimestre&IVT=4&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IVT']) == "4") {
                                                                                                                        echo "active";
                                                                                                                      }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>IV Trimestre</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=5 Trimestre&VT=5&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['VT']) == "5") {
                                                                                                                      echo "active";
                                                                                                                    }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>V Trimestre</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=6 Trimestre&VIT=6&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['VIT']) == "6") {
                                                                                                                        echo "active";
                                                                                                                      }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>VI Trimestre</p>
                        
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="horarios_ficha.php?Trimestres=7 Trimestre&VIIT=6&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['VIIT']) == "7") {
                                                                                                                        echo "active";
                                                                                                                      }  ?> ">
                        <i class="fas fa-file-export"></i>
                        <p>VII Trimestre</p>
                        
                      </a>
                    </li>
                   

                  </ul>
                </li>
              </ul>
              <?php 
            }else { 
              ?> <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link" style="color:white;">
                  <i class=" far fa-calendar-alt fa-lg"></i>
                  <p>
                    Trimestres
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="horarios_ficha.php?Trimestres=1 Trimestre&IT=1&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IT']) == "1") {
                                                                                                                    echo "active";
                                                                                                                  }  ?> ">
                      <i class="fas fa-file-export"></i>
                      <p>I Trimestre</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="horarios_ficha.php?Trimestres=2 Trimestre&IIT=2&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IIT']) == "2") {
                                                                                                                      echo "active";
                                                                                                                    }  ?> ">
                      <i class="fas fa-file-export"></i>
                      <p>II Trimestre</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="horarios_ficha.php?Trimestres=3 Trimestre&IIIT=3&pro=<?php echo $programa; ?>" style="color:white;" class="nav-link <?php if (isset($_GET['IIIT']) == "3") {
                                                                                                                        echo "active";
                                                                                                                      }  ?> ">
                      <i class="fas fa-file-export"></i>
                      <p>III Trimestre</p>
                    </a>

                  </li>
                </ul>
              </li>
            </ul>
            </nav>
    </aside>
    <?php }}?>
  </div>
  <!--/lateral-->

  <div class="content-wrapper">
    <div class="container">
      <br><?php
          $est_fch = mysqli_query($conn, "SELECT * FROM ficha,tb_trimestre WHERE ficha.ID_F=tb_trimestre.id_fch and ficha.ID_F=$id_fch_cons and tb_trimestre.estatus_trim_H=0");
          $row_estfch = mysqli_fetch_assoc($est_fch);

          if (isset($row_estfch['Trimestre'])) { ?><h5>El Trimestre activo de la ficha es <?php echo $row_estfch['Trimestre']; ?></h5>
        <?php
          } else {
            echo "<h2><center>La ficha no tiene un horario activo</center></h2>";
          }


          if (isset($_GET['Trimestres'])) {

            $tm_c = $_GET['Trimestres'];

            $tm_cons = mysqli_query($conn, "SELECT * FROM ficha,tb_trimestre WHERE ficha.ID_F=tb_trimestre.id_fch and tb_trimestre.Trimestre='$tm_c' and ficha.ID_F='$id_fch_cons'");
            $cons_row = mysqli_fetch_assoc($tm_cons);
            $tm_hrs = $cons_row['id_T'];

            $queryf = "SELECT * FROM ficha,programa,tb_trimestre WHERE ficha.ID_F='$id_fch_cons' and tb_trimestre.id_T='$tm_hrs' and ficha.fc_id_programa=programa.id_program AND tb_trimestre.id_fch=ficha.ID_F";
            $fchc = mysqli_query($conn, $queryf);
            $rows = mysqli_fetch_assoc($fchc);

            $prueVar = mysqli_query($conn, "SELECT * FROM tb_trimestre WHERE id_fch=$id_fch_cons and Trimestre='$tm_c'");
            $rowVar = mysqli_fetch_assoc($prueVar);


            if ($rowVar['estatus_trim_H'] == 1) {
        ?>
          <style type="text/css">
            #uso_des {
              background-color: red;
            }
          </style>
        <?php
            } elseif ($rowVar['estatus_trim_H'] == 0) {
              //echo "fechas no iguales";
        ?>
          <style type="text/css">
            #uso_des {
              background-color: #5cdc3e;
            }
          </style>
        <?php
            }


        ?>

        <!--/tabla_ficha-->
        <div class="container">
          <div class="table-responsive-sm">
            <!--div1tabla -->
            <table class="table table-hover table-sm" id="example">
              <thead class="bg-orange">
              
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
                <tr class="text-white bg-secondary">
                  <td colspan="2"><?php echo "Grupo: " . $rows['Nº ficha']; ?> </td>
                  <td colspan="2"><?php echo "Trimestre:" .  $rows['Trimestre']; ?> </td>
                  <td id="uso_des" colspan="1">Estado</td>
                  <td colspan="2">
                    <?php echo "Fecha: " . $rows['Trim_date_Inc'] . " a " . $rows['Trim_date_fin'] ?></td>
                </tr>
                <tr class="text-white">
                  <th>Horas</th>
                  <th>Lunes</th>
                  <th>Martes</th>
                  <th>Miercoles</th>
                  <th>Jueves</th>
                  <th>Viernes</th>
                  <th>Sabado</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $days = array(0, 1, 2, 3, 4, 5, 6,);
                $hours = array(1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 7, 0, 8);
                foreach ($hours as $hour) {
                ?>
                  <tr>
                    <?php
                    foreach ($days as $day) {
                    ?>
                      <td>
                        <?php
                        $querys_horas = "SELECT * FROM horas WHERE id_h=$hour";
                        $result_horas = mysqli_query($conn, $querys_horas);
                        while ($rcon = mysqli_fetch_assoc($result_horas)) {
                          if ($day == 0) { ?> <strong><?php echo $rcon['hora']; ?></strong>
                          <?php } ?>

                        <?php } ?>

                        <?php

                        $querys_horas = "SELECT * FROM horas";
                        $result_horas = mysqli_query($conn, $querys_horas);
                        $row_horas = mysqli_fetch_assoc($result_horas);

                        $query = "SELECT * FROM horarios,ficha,instructor,dias,horas,ambiente,tb_trimestre WHERE horarios.dia=$day AND horarios.hora=$hour AND horarios.dia=dias.id AND horarios.ficha=ficha.ID_F AND horarios.instructor = instructor.ID AND horarios.id_ambiente=ambiente.id_A AND ficha.ID_F = tb_trimestre.id_fch and horarios.id_trim_fch='$tm_hrs' and tb_trimestre.Trimestre='$tm_c' and horarios.hora = horas.id_h and horarios.ficha=$id_fch_cons";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        if (isset($row)) { ?>
                          <ul class="list-unstyled">
                            <li><?php echo $row['Nombre'] . " " . $row['Apellido']; ?></li>
                            <li><?php echo $row['Trimestre']; ?></li>
                            <li><?php echo "Amb: " . $row['Nombre_ambiente']; ?></li>
                            <li><?php echo "Descripción: " . $row['descripcion']; ?></li>
                          </ul>

                          <a href="#edit_<?php echo $row['id_hora']; ?>" 
                              class="btn btn-outline-dark btn-sm" 
                              data-toggle="modal">
                              <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="../controlador/HorariosController/delete.php?eli=<?php echo $row['id_hora']; ?>&redirect=horarios_ficha.php?ficha=<?php echo $id_fch_cons; ?>&Trimestres=<?php echo $tm_c; ?>&pro=<?php echo $programa; ?>" 
                              onclick="return confirm('¿Estás seguro de eliminar este horario?');">
                              <button type="button" class="btn btn-outline-dark btn-sm">
                                  <i class="bi bi-trash"></i>
                              </button>
                            </a>


                            <?php    include(__DIR__ .  '../admin/editar-horario.php'); ?>                            
                        <?php

                        

                        } elseif (!isset($row)) {
                          echo "&nbsp";
                        }
                        ?>
                      </td>
                  <?php
                    }
                    echo "</tr>";
                  }


                  ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
<?php
          }
?>
</div>
</div>
</div>
</body>
<?php
include("parte_inferior.php");
?>