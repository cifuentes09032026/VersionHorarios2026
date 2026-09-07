<?php
include('../../confi/conexion.php');
session_start();

// ✅ Verificamos sesión de usuario
$correo = $_SESSION['ema'] ?? null;
$inst = $_SESSION['nam'] ?? null;

if (!$correo) {
  header("Location: ../../index.php");
  exit;
}

// ✅ Obtenemos los parámetros del instructor y el período
$id_ins = $_GET['ins'] ?? null;
$pedis_get = $_GET['ped'] ?? null;

// ✅ Guardamos o recuperamos el período (para evitar perderlo)
if ($pedis_get) {
  $_SESSION['pedis'] = $pedis_get;
}

$pedis = $_SESSION['pedis'] ?? null;


// ✅ Cargamos los datos del instructor
$query_ins = mysqli_query($conn, "SELECT * FROM instructor WHERE ID = $id_ins");
$c_ins = mysqli_fetch_assoc($query_ins);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Horario Instructor Imprimir </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="instructorstyle.css">
  <link rel="stylesheet" type="text/css" href="styles.css">  
</head>

<body>
  
  <table>
    <?php
    $query_ins = mysqli_query($conn, "SELECT * FROM instructor where ID= $id_ins");
    $c_ins = mysqli_fetch_assoc($query_ins);
    ?>
    <tr>
      <th colspan="4" rowspan="3"><img src="../../img/sena_horarios_1.png" style="width: 500px;"></th>
      <th colspan="3">Versión: 03</th>
    </tr>
    <tr>
      <th colspan="3">Año: <?php echo date('Y'); ?></th>
    </tr>
    <tr>
      <th colspan="8"><?php echo "Instructor: " . $c_ins['Nombre'] . " " . $c_ins['Apellido'] ?></th>
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
    $days = array(0, 1, 2, 3, 4, 5, 6,);
    $hours = array(1,9,2,10,3,11,4,12,5,13,6,14,7,15,8);
    foreach ($hours as $hour) {
    ?>
      <tr>
        <?php
        foreach ($days as $day) {
        ?>
          <td>
            <?php
            $query_horas = mysqli_query($conn, "SELECT * FROM horas WHERE id_h=$hour");
            while ($rcon = mysqli_fetch_assoc($query_horas)) {
              if ($day == 0) { ?> <strong><?php echo $rcon['hora']; ?></strong>
              <?php } ?>
            <?php } ?>
            <?php
            $query = "SELECT * FROM horarios,ficha,dias,horas,ambiente,tb_trimestre, programa, instructor 
                WHERE horarios.dia=$day AND horarios.hora=$hour
                AND horarios.instructor=$id_ins
                and horarios.id_ambiente=ambiente.id_A
                AND horarios.ficha=ficha.ID_F
                AND ficha.ID_F = tb_trimestre.id_fch 
                AND horarios.id_trim_fch=tb_trimestre.id_T
                AND horarios.hora = horas.id_h 
                and horarios.period_fk=$pedis
                AND ficha.fc_id_programa=programa.id_program"
                ;
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if (isset($row)) { ?>
              <div style="
                background-color:#CCFFCC;   /* verde suave */
                border:1px solid #009900;   /* borde verde */
                padding:4px;
                margin-top:4px;
                font-size:11px;
                border-radius:4px;
                font-weight:bold;
                color:#003300;              /* texto verde oscuro */
              ">
                <div style="color:red;"><?php echo $row['Nº ficha']; ?></div>
                <div>TRIMESTRE:<?php echo $row['Trimestre']; ?></div>
                <div><?php echo $row['Nom_program']; ?></div>
                <div>DESCRIPCIÓN:<?php echo $row['descripcion']; ?></div>
                
              </div>
            <?php
            } elseif ($hour > 8) {
              echo "Descanso";
            }
            // 🔹 Agregar horas extra aquí
            $queryExtras = "
              SELECT he.tipo, he.horas, a.Nombre_ambiente
              FROM horas_extra he
              LEFT JOIN ambiente a ON he.id_ambiente = a.id_A
              WHERE he.instructor_id = $id_ins
                AND he.dia = $day
                AND he.hora = $hour
            ";
            $resultExtras = mysqli_query($conn, $queryExtras);

            while ($extra = mysqli_fetch_assoc($resultExtras)) { ?>
              <div style="
                background-color:#FFD9B3;  /* naranja suave */
                border:1px solid #FF9900;  /* borde naranja */
                padding:4px;
                margin-top:4px;
                font-size:11px;
                border-radius:4px;
                font-weight:bold;
                color:#663300; /* texto marrón oscuro */
              ">
                <?php echo htmlspecialchars($extra['tipo']) . " (" . $extra['horas'] . "h)"; ?>
                <?php if (!empty($extra['Nombre_ambiente'])) { ?>
                  <br><small>AMBIENTE: <?php echo $extra['Nombre_ambiente']; ?></small>
                <?php } ?>
              </div>
            <?php }
            
              }
              echo "</tr>";
            }
                ?>

                
<?php
// =============================
// BLOQUE DE CÁLCULOS AJUSTADO
// =============================

// 🔹 1️⃣ Horas formación complementaria
$sql_comple = "SELECT COALESCE(SUM(horas),0) AS total 
               FROM horas_extra 
               WHERE instructor_id = $id_ins 
                 AND tipo = 'complementaria'";
$res_comple = mysqli_query($conn, $sql_comple);
$row_comple = mysqli_fetch_assoc($res_comple);
$sum_comple = $row_comple['total'] ?? 0;

// 🔹 2️⃣ Horas formación titulada (del horario normal)
$sumas = "SELECT SUM(horas_instructor) as total 
          FROM horarios 
          WHERE instructor = $id_ins 
            AND period_fk = $pedis";
$resulsuma = mysqli_query($conn, $sumas);
$rowsum = mysqli_fetch_array($resulsuma);
$sum = $rowsum['total'] ?? 0;

// 🔹 3️⃣ Horas del contrato
$hins = "SELECT c.Numero_h 
         FROM instructor i
         INNER JOIN contrato c ON i.horas_inst = c.id
         WHERE i.ID = $id_ins";
$resulinstructores = mysqli_query($conn, $hins);
$rowin = mysqli_fetch_assoc($resulinstructores);
$horas_contrato = $rowin['Numero_h'] ?? 0;

// Asignar directamente las horas del contrato al total de referencia
$sumin = $horas_contrato;


// 🔹 4️⃣ Detalle de horas extra (todas menos complementaria)
$sql_extras_detalle = "SELECT tipo, COALESCE(SUM(horas),0) AS horas 
                       FROM horas_extra 
                       WHERE instructor_id = $id_ins 
                         AND tipo <> 'complementaria'
                       GROUP BY tipo";
$res_extras = mysqli_query($conn, $sql_extras_detalle);

$extras_detalle = [];
$total_extras = 0;
while ($ex = mysqli_fetch_assoc($res_extras)) {
    $extras_detalle[$ex['tipo']] = $ex['horas'];
    $total_extras += $ex['horas'];
}

// =============================
// BLOQUE FINAL CORREGIDO
// =============================

// Horas de planeación manual (si el usuario la agregó)
$planeacion_manual = floatval($extras_detalle['planeacion'] ?? 0.0);

// Planeación automática si es planta (32h) y no hay planeación en BD
$planeacion_auto = 0.0;
if ($horas_contrato == 32 && $planeacion_manual == 0.0) {
    $planeacion_auto = 10.5;
}

// Planeación final para mostrar (NO se resta de las 32)
$planeacion_final = ($planeacion_manual > 0 ? $planeacion_manual : $planeacion_auto);
$extras_detalle['planeacion'] = $planeacion_final;

// Horas que SÍ afectan disponibilidad del contrato
$horas_programadas_reales = 
      floatval($sum)          // titulada
    + floatval($sum_comple)   // complementaria
    + floatval($total_extras) // extras que sí cuentan
;

// Horas pendientes reales
$pendientes = $horas_contrato - $horas_programadas_reales;
if ($pendientes < 0) $pendientes = 0;


// 🔹 8️⃣ Nombres bonitos para los tipos
$nombres_tipo = [
  'seguimiento'     => 'Horas seguimiento etapa productiva',
  'red'             => 'Horas red de medios',
  'produccion'      => 'Horas producción de centro',
  'planeacion'      => 'Horas de planeación',
  'sindical'        => 'Horas permiso sindical',
  'complementaria'  => 'Horas formación complementaria',
];
?>


<tr>
  <td colspan="4" style="border:none !important; vertical-align:top; padding:8px;">
    <strong>Observaciones:</strong>
    <?php
    // 🔹 Obtener la última observación del instructor
    $sql_obs = "SELECT observacion, fecha 
                FROM observaciones 
                WHERE instructor_id = ? 
                ORDER BY fecha DESC 
                LIMIT 1";
    $stmt = $conn->prepare($sql_obs);
    $stmt->bind_param("i", $id_ins);
    $stmt->execute();
    $res_obs = $stmt->get_result();
    $observacion = $res_obs->fetch_assoc();
    $stmt->close();
    ?>

    <?php if (!empty($observacion)): ?>
      <div style="
        background-color:#e9f9e9;
        border:1px solid #8bc34a;
        padding:8px;
        border-radius:5px;
        margin-top:6px;
        font-size:13px;
      ">
        <span style="color:#2e7d32; font-weight:bold;">
          <?= nl2br(htmlspecialchars($observacion['observacion'])) ?>
        </span>
        <br>
        <small><em>Fecha: <?= htmlspecialchars($observacion['fecha']) ?></em></small>
      </div>
    <?php else: ?>
      <div style="margin-top:10px; height:25px; border-bottom:1px solid #000;"></div>
      <div style="height:25px; border-bottom:1px solid #000;"></div>
      <div style="height:25px; border-bottom:1px solid #000;"></div>
      <div style="height:25px; border-bottom:1px solid #000;"></div>
    <?php endif; ?>
  </td>

  <td colspan="3" style="padding:0;">
    <table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:12px;">
      <tr>
        <th style="text-align:left; padding:6px; border-bottom:1px solid #000;">
          Instructor: <?php echo $c_ins['Nombre'] . " " . $c_ins['Apellido']; ?>
        </th>
      </tr>

      <tr><td style="padding:6px; border-bottom:1px solid #000;">
        Horas de formación titulada
        <span style="float:right;"><?php echo $sum; ?></span>
      </td></tr>

      <tr><td style="padding:6px; border-bottom:1px solid #000;">
        Horas formación complementaria
        <span style="float:right;"><?php echo $sum_comple; ?></span>
      </td></tr>

      <?php foreach ($extras_detalle as $tipo => $horas) { ?>
  <tr>
    <td style="padding:6px; border-bottom:1px solid #000;">
      <?php echo $nombres_tipo[$tipo] ?? ucfirst($tipo); ?>
      <span style="float:right;"><?php echo $horas; ?></span>
    </td>
  </tr>
<?php } ?>



      <tr>
        <td style="padding:6px; border-bottom:1px solid #000;">
          Horas pendientes de programar
          <span style="float:right; color:red;"><?php echo $pendientes; ?></span>
        </td>
      </tr>

      
    </table>
  </td>
</tr>

    </table>
  </td>
</tr>
      
      
  </table>
</body>
<script>
  window.addEventListener("load", window.print());
</script>
</html>