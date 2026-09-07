<?php
include('../../confi/conexion.php');
session_start();
$correo = $_SESSION['ema'];
$inst = $_SESSION['nam'];
if (!isset($correo)) {
  header("location:../../index.php");
}

$trim_f = $_SESSION['trim'];
$id_f = $_GET['fich'];
?>

<!DOCTYPE html>
<html lang="es">
  <style>
  /* CUADROS VERDES COMO EN LA VISTA NORMAL */
  td ul {
    background: #CCFFCC;         /* verde suave */
    border: 2px solid #009900;   /* borde verde */
    padding: 5px;
    border-radius: 6px;
    list-style: none;
    margin: 0;
  }
</style>

<head>
  <meta charset="utf-8">
  <title>Horario Ficha Imprimir</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <table border="1" style="border-collapse: collapse; width: 100%;" class="tabla-horario">

    <?php
    $fcht = mysqli_query($conn, "SELECT * FROM ficha
      INNER JOIN programa ON ficha.fc_id_programa = programa.id_program
      INNER JOIN tb_trimestre ON tb_trimestre.id_fch = ficha.ID_F
      WHERE ficha.ID_F = $id_f AND tb_trimestre.Trimestre = '$trim_f'");
    $fchT = mysqli_fetch_assoc($fcht);
    ?>

    <!-- === ENCABEZADO === -->
    <tr>
      <td colspan="4" rowspan="3" style="text-align:center; vertical-align:middle;">
        <img src='../../img/sena_horarios_1.png' style='width:500px;'>
      </td>
      <td colspan="3" style="border:1px solid #000; vertical-align:middle; padding:6px; text-align:left;">
        <strong>Versión:</strong> 03
      </td>
    </tr>

    <tr>
      <td colspan="3" style="border:1px solid #000; vertical-align:middle; padding:6px; text-align:left;">
        <strong>Año:</strong> <?php echo date('Y'); ?>
      </td>
    </tr>

    <tr>
      <td colspan="3" style="border:1px solid #000; vertical-align:middle; padding:6px; text-align:left;">
        <strong>Trimestre:</strong> <?php echo isset($fchT['Trimestre']) ? $fchT['Trimestre'] . " - " . date('Y') : "N/A"; ?>
      </td>
    </tr>
    <!-- === FIN ENCABEZADO === -->

    <!-- GRUPO, TALLER Y FECHAS -->
    <tr>
      <th colspan="3" style="text-align:left;">
        GRUPO: <?php echo $fchT['Nº ficha'] . " - " . strtoupper($fchT['Nom_program']); ?>
      </th>
      <th colspan="2" style="text-align:left;">
        TALLER:
        <?php
        $amb_q = mysqli_query($conn, "SELECT DISTINCT ambiente.Nombre_ambiente
          FROM horarios
          INNER JOIN ambiente ON horarios.id_ambiente = ambiente.id_A
          WHERE horarios.ficha = $id_f LIMIT 1");
        $amb = mysqli_fetch_assoc($amb_q);
        echo isset($amb['Nombre_ambiente']) ? strtoupper($amb['Nombre_ambiente']) : "N/A";
        ?>
      </th>
      <th colspan="2" style="text-align:left;">
        FECHA: <?php echo date('d/m/y', strtotime($fchT['Trim_date_Inc'])) . " - " . date('d/m/y', strtotime($fchT['Trim_date_fin'])); ?>
      </th>
    </tr>

    <!-- CABECERA DE HORARIO -->
    <tr class="dias">
      <th class="hora">Hora</th>
      <th class="horario">Lunes</th>
      <th class="horario">Martes</th>
      <th class="horario">Miércoles</th>
      <th class="horario">Jueves</th>
      <th class="horario">Viernes</th>
      <th class="horario">Sábado</th>
    </tr>

    <?php
    $days = array(0, 1, 2, 3, 4, 5, 6);
    $hours = array(1,9,2,10,3,11,4,12,5,13,6,14,7,15,8);

    foreach ($hours as $hour) {
      echo "<tr>";
      foreach ($days as $day) {
        echo "<td>";
        $querys_horas = "SELECT * FROM horas WHERE id_h=$hour";
        $result_horas = mysqli_query($conn, $querys_horas);
        while ($rcon = mysqli_fetch_assoc($result_horas)) {
          if ($day == 0) echo "<strong>{$rcon['hora']}</strong>";
        }

        $query = "SELECT * FROM horarios
          INNER JOIN ficha ON horarios.ficha = ficha.ID_F
          INNER JOIN dias ON horarios.dia = dias.id
          INNER JOIN horas ON horarios.hora = horas.id_h
          INNER JOIN ambiente ON horarios.id_ambiente = ambiente.id_A
          INNER JOIN tb_trimestre ON horarios.id_trim_fch = tb_trimestre.id_T
          INNER JOIN programa ON ficha.fc_id_programa = programa.id_program
          INNER JOIN instructor ON horarios.instructor = instructor.ID
          WHERE horarios.dia=$day AND horarios.hora=$hour AND horarios.ficha=$id_f";

        $result = mysqli_query($conn, $query);
        if (!$result) {
          die("❌ Error en la consulta SQL (horarios): " . mysqli_error($conn) . "<br><pre>$query</pre>");
        }
        $row = mysqli_fetch_assoc($result);

        if ($row) {
          echo "<ul>
            <li>{$row['descripcion']}</li>
            <li style='color:red;'>{$row['Nombre']} {$row['Apellido']}</li>
            <li>{$row['Nombre_ambiente']}</li>
          </ul>";
        } elseif ($hour == 12) {
          //echo "Almuerzo";
        } elseif ($hour > 8) {
         // echo "Descanso";
        } else {
          echo "&nbsp;";
        }

        echo "</td>";
      }
      echo "</tr>";
    }
    ?>

   <?php
// helper para formatear fechas sin caer en 1970
function fmtDate($raw, $out = 'd/m/Y') {
    if (empty($raw)) return '----';
    // tratar valores comunes inválidos
    $rawTrim = trim($raw);
    if ($rawTrim === '0000-00-00' || $rawTrim === '0000-00-00 00:00:00') return '----';
    $ts = strtotime($rawTrim);
    if ($ts === false || $ts === 0) return '----';
    return date($out, $ts);
}

// CONSULTA JEFE (ya existía arriba, se asume $ins disponible)
// --------------------------------------------
?>
<table class="tabla-competencias" border="1" style="border-collapse: collapse; width: 100%;">

<!-- FILA PRINCIPAL DE COMPETENCIAS + JEFE DE TALLER -->
<tr>
  <th colspan="5">COMPETENCIAS A DESARROLLAR</th>

  <?php
    if (!isset($ins)) {
      $instructor = mysqli_query($conn, "SELECT * FROM instructor
        INNER JOIN tb_trimestre ON tb_trimestre.instructor_id = instructor.ID
        INNER JOIN ficha ON tb_trimestre.id_fch = ficha.ID_F
        WHERE tb_trimestre.Trimestre = '$trim_f' AND ficha.ID_F = $id_f");
      $ins = mysqli_fetch_assoc($instructor);
    }
  ?>

  <th colspan="3">
      JEFE DE TALLER
      <p style="color:red; margin:0;">
        <?php echo isset($ins['Nombre']) ? $ins['Nombre'] . " " . $ins['Apellido'] : '----'; ?>
      </p>
  </th>
</tr>

<!-- ENCABEZADOS INTERNOS -->
<tr>
  <th style="border:1px solid #000; width:40%;">NOMBRE DE LA COMPETENCIA</th>
  <th style="border:1px solid #000; width:15%;">FECHA</th>
  <th style="border:1px solid #000; width:15%;">INSTRUCTOR</th>
  <th colspan="5" style="border:1px solid #000; width:30%;"></th>
</tr>

<?php
// Traer competencias
$competencias_query = mysqli_query($conn, "SELECT * FROM competencias WHERE Ficha_id = $id_f");

if ($competencias_query && mysqli_num_rows($competencias_query) > 0) {
  while ($comp = mysqli_fetch_assoc($competencias_query)) {

    $raw_ini = $comp['fecha_ini'] ?? $comp['fecha_inicio'] ?? $comp['inicio'] ?? null;
    $raw_fin = $comp['fecha_fin'] ?? $comp['fecha_final'] ?? $comp['fin'] ?? null;

$fecha_ini_fmt = ($raw_ini && trim($raw_ini) != '') ? $raw_ini : '----';
$fecha_fin_fmt = ($raw_fin && trim($raw_fin) != '') ? $raw_fin : '----';

    $comp_instructor = $comp['instructor'] ?? '----';

    echo "
    <tr>
      <td style='border:1px solid #000; padding:4px;'>{$comp['competencias']}</td>
      <td style='border:1px solid #000; padding:4px;'>{$fecha_ini_fmt} - {$fecha_fin_fmt}</td>
      <td style='border:1px solid #000; padding:4px;'>{$comp_instructor}</td>
      <td colspan='5' style='border:1px solid #000; height:35px;'></td>
    </tr>";
  }
} else {
  echo "
  <tr>
    <td colspan='8' style='border:1px solid #000; padding:6px; text-align:center;'>
      No hay competencias registradas para esta ficha.
    </td>
  </tr>";
}

$ini_lect = fmtDate($fchT['fic_date_I'] ?? null, 'd/m/Y');
$fin_lect = fmtDate($fchT['fic_date_F'] ?? null, 'd/m/Y');
$fin_prod = fmtDate($fchT['fin_prod'] ?? null, 'd/m/Y');
?>

<!-- CUADRO VACÍO DE RESULTADOS (debajo del jefe de taller) -->
<td colspan="5" style="border:1px solid #000; padding:4px;">
    <textarea name="resultado[]" style="width:100%; height:60px; border:none; resize:none; outline:none;"></textarea>
</td>

<!-- FECHAS -->
<tr>
  <td colspan="3" style="border:1px solid #000; padding:4px;"><strong>Fecha Inicio Lectiva</strong></td>
  <td colspan="5" style="border:1px solid #000; padding:4px;"><?php echo $ini_lect; ?></td>
</tr>

<tr>
  <td colspan="3" style="border:1px solid #000; padding:4px;"><strong>Fecha Fin Lectiva</strong></td>
  <td colspan="5" style="border:1px solid #000; padding:4px;"><?php echo $fin_lect; ?></td>
</tr>

<tr>
  <td colspan="3" style="border:1px solid #000; padding:4px;"><strong>Fecha Fin Productiva</strong></td>
  <td colspan="5" style="border:1px solid #000; padding:4px;"><?php echo $fin_prod; ?></td>
</tr>

</table>


  <script>
    window.addEventListener("load", window.print());
  </script>
</body>
</html>
