<?php
include('../../confi/conexion.php');
session_start();
$correo = $_SESSION['ema'];
$inst = $_SESSION['nam'];
if (!isset($correo)) {
  header("location:../../index.php");
}

$id_amb = $_GET['amb'];
$pedis = $_GET['ped'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Horario Ambiente Imprimir</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      text-align: center;
    }

    th,
    td {
      border: 1px solid black;
      padding: 4px;
    }

    th {
      background-color: #f2f2f2;
    }

    .dias th {
      background-color: #e0e0e0;
      font-weight: bold;
    }

    .ambiente {
      font-size: 11px;
      line-height: 1.3;
      border-radius: 4px;
      padding: 3px;
    }

    .verde {
      background-color: #b7f0b1;
    }

    .naranja {
      background-color: #f8d7a3;
    }

    .cuadro-final th,
    .cuadro-final td {
      border: 1px solid black;
      padding: 6px;
      text-align: center;
    }

    .cuadro-final .titulo {
      font-weight: bold;
      background-color: #f2f2f2;
      text-align: center;
    }

    .cuadro-final .ambiente-nombre {
      font-size: 22px;
      font-weight: bold;
      height: 90px;
      vertical-align: middle;
    }
  </style>
</head>

<body>

  <!-- TABLA PRINCIPAL (HORARIO) -->
  <table style="border-bottom:0; width:100%;">

    <?php
    $camb = mysqli_query($conn, "SELECT * FROM ambiente WHERE id_A=$id_amb");
    $c_amb = mysqli_fetch_assoc($camb);
    ?>

    <tr>
      <td colspan="6" rowspan="2"><img src="../../img/sena_horarios_1.png" style="width:100%; max-width:900px;">
</td>
      <td>Versión: 03</td>
    </tr>
    <tr>
      <td colspan="2">Fecha: <?php echo date('d/m/Y'); ?></td>
    </tr>

    <tr>
      <th colspan="8">Taller: <?php echo $c_amb['Nombre_ambiente'] ?></th>
    </tr>

    <tr class="dias">
      <th class="hora">Hora</th>
      <th class="horario">Lunes</th>
      <th class="horario">Martes</th>
      <th class="horario">Miercoles</th>
      <th class="horario">Jueves</th>
      <th class="horario">Viernes</th>
      <th class="horario">Sabado</th>
    </tr>

    <?php
    $days = array(0, 1, 2, 3, 4, 5, 6);
    $hours = array(1, 2, 3, 4, 5, 6, 7, 8);

    foreach ($hours as $hour) {
      echo "<tr>";
      foreach ($days as $day) {

        echo "<td>";

        $result = mysqli_query($conn, "SELECT * FROM horas WHERE id_h=$hour");
        while ($rcon = mysqli_fetch_assoc($result)) {
          if ($day == 0) {
            echo "<strong>" . $rcon['hora'] . "</strong>";
          }
        }

        $query = mysqli_query($conn, "
          SELECT horarios.*, ficha.`Nº ficha`, programa.Nom_program, ficha.ID_F, horarios.instructor
          FROM horarios
          INNER JOIN ficha ON horarios.ficha = ficha.ID_F
          INNER JOIN programa ON ficha.fc_id_programa = programa.id_program
          WHERE horarios.dia = $day
          AND horarios.hora = $hour
          AND horarios.id_ambiente = $id_amb
          AND horarios.period_fk = $pedis
        ");

        if ($query && mysqli_num_rows($query) > 0) {
          $row = mysqli_fetch_assoc($query);

          $instructorNombre = '';
          if (!empty($row['instructor'])) {
            $qInst = mysqli_query($conn, "
              SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo 
              FROM instructor 
              WHERE id = {$row['instructor']} 
              LIMIT 1
            ");
            if ($qInst && mysqli_num_rows($qInst) > 0) {
              $inst = mysqli_fetch_assoc($qInst);
              $instructorNombre = $inst['nombre_completo'];
            }
          }

          echo "
            <div style='
              background-color:#CCFFCC;
              border:1px solid #009900;
              padding:4px;
              margin-top:4px;
              font-size:11px;
              line-height:1.3;
              border-radius:4px;
              color:#003300;
              text-align:left;
            '>
              <div style='font-weight:bold;'>{$row['Nº ficha']}</div>
              <div style='font-weight:bold; color:#ff0000;'>{$row['Nom_program']}</div>
              <div style='font-style:italic;'>- {$instructorNombre}</div>
            </div>";
        } else {
          echo "&nbsp;";
        }

        echo "</td>";
      }
      echo "</tr>";
    }
    ?>

  </table>   <!-- ← CIERRE CORRECTO DE LA TABLA PRINCIPAL -->

  <!-- CUADRO FINAL (Competencias + Ambiente) -->
  <table style="width:100%; border-collapse:collapse; font-size:12px; margin-top:0;" border="1">

    <tr>
      <th colspan="5" style="text-align:center;">COMPETENCIAS A DESARROLLAR</th>
      <th colspan="3" style="text-align:center;">AMBIENTE</th>
    </tr>

    <tr>
      <th style="width:40%;">NOMBRE DE LA COMPETENCIA</th>
      <th style="width:15%;">FECHA INICIA</th>
      <th style="width:15%;">FECHA TERMINA</th>

      <td colspan="3" rowspan="4" style="width:30%; text-align:center; vertical-align:middle; font-weight:bold; font-size:20px;">
        <?php echo $c_amb['Nombre_ambiente']; ?>
      </td>
    </tr>

    <tr>
      <td style="height:25px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td style="height:25px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td style="height:25px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

  </table>

  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>

</body>
</html>
