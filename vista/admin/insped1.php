<link rel="stylesheet" href="horarios/style.css">
<?php
include('../../confi/conexion.php');

session_start();
$correo = $_SESSION['ema'];
$inst = $_SESSION['nam'];
if (!isset($correo)) {
  header("location:../../index.php");
  exit;
}
$rol = $_SESSION['rol'];

$id_ins = isset($_GET['instructor']) ? intval($_GET['instructor']) : 0;
if ($id_ins <= 0) {
  header("location:../horarios.php");
  exit;
}

$pageTitle = 'Horarios instructor';
if ($rol == 1) {
  include("../plantillas/plantilla-horarios.php");
} else {
  include("../plantillas/plantillan.php");
}
?>
<input type="hidden" name="redirect" value="insped1">
<div class="content-wrapper">
  <?php
  $con_ins = mysqli_query($conn, "SELECT * FROM instructor WHERE ID='$id_ins'");
  $rowins = mysqli_fetch_array($con_ins);
  ?>
  <br>
  <div class="container">
    <h2><?php echo "Instructor " . $rowins['Nombre'] . " " . $rowins['Apellido']; ?></h2>
    <br>
    <div class="table-responsive-sm">
      <table class="table table-hover table-sm" id="example">
        
        <thead class="bg-orange">
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
          $days = array(0, 1, 2, 3, 4, 5, 6);
          $hours = array(1, 2, 3, 4, 5, 6, 7, 8);

          foreach ($hours as $hour) {
          ?>
            <tr>
              <?php
              foreach ($days as $day) {
              ?>
                <td>
                  <?php
                  // Imprime la etiqueta de la hora solo en la primera columna (Horas)
                  $querys_horas = "SELECT * FROM horas WHERE id_h=$hour";
                  $result_horas = mysqli_query($conn, $querys_horas);
                  while ($rcon = mysqli_fetch_assoc($result_horas)) {
                    if ($day == 0) { ?>
                      <strong><?php echo $rcon['hora']; ?></strong>
                  <?php }
                  } ?>

                  <?php
                  // Consulta como en horarios_ficha.php, pero filtrada por instructor
                  // y seleccionando los campos que necesita editar-horario.php
                  $querys = "
                    SELECT 
                      horarios.id_hora,
                      horarios.ficha,
                      horarios.dia,
                      horarios.hora,               -- id numérico de la hora
                      horarios.instructor,
                      horarios.id_trim_fch,
                      horarios.descripcion,
                      ficha.`Nº ficha`,
                      programa.Nom_program,
                      ambiente.Nombre_ambiente,
                      tb_trimestre.Trimestre,
                      instructor.Nombre,
                      instructor.Apellido,
                      dias.dia_s,                  -- nombre del día
                      horas.hora AS hora_texto     -- texto de la hora (6:00-7:40)
                    FROM horarios
                    INNER JOIN ficha ON horarios.ficha=ficha.ID_F
                    INNER JOIN programa ON ficha.fc_id_programa=programa.id_program
                    INNER JOIN instructor ON horarios.instructor=instructor.ID
                    INNER JOIN dias ON horarios.dia=dias.id
                    INNER JOIN horas ON horarios.hora=horas.id_h
                    INNER JOIN ambiente ON horarios.id_ambiente=ambiente.id_A
                    INNER JOIN tb_trimestre ON horarios.id_trim_fch=tb_trimestre.id_T
                    WHERE horarios.dia=$day 
                      AND horarios.hora=$hour 
                      AND horarios.instructor=$id_ins 
                      AND horarios.period_fk=1
                    LIMIT 1
                  ";
                  $result = mysqli_query($conn, $querys);
                  $row = mysqli_fetch_assoc($result);

                  if (isset($row) && !empty($row)) {
                    // Contenido de la celda como en horarios_ficha.php
                    echo 
                         $row['descripcion'] . "<br>" .
                         $row['Nombre_ambiente'] . "<br>" .
                         '<li>Ficha: ' . (isset($row['Nº ficha']) ? $row['Nº ficha'] : 'N/A') . '</li>'.
  
                         '<li>Prog: ' . $row['Nom_program'] . '</li>';
                    ?>

                    <!-- Botón Editar (abre el modal del mismo id que en horarios_ficha.php) -->
                    <a href="#edit_<?php echo $row['id_hora']; ?>" 
                       class="btn btn-outline-dark btn-sm" 
                       data-toggle="modal">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- Botón Eliminar (igual que en horarios_ficha.php) -->
                    <form action="../../controlador/HorariosController/delete.php" method="post" style="display:inline;"
                        onsubmit="return confirm('¿Estás seguro de eliminar este horario?');">
                    <input type="hidden" name="eli" value="<?php echo $row['id_hora']; ?>"> <!-- o $id_hora según tu variable -->
                    <input type="hidden" name="instructor" value="<?php echo $id_ins; ?>">
                    <input type="hidden" name="periodo" value="<?php echo $pedis; ?>"> <!-- asegúrate que $pedis tiene el id del periodo -->
                    <button type="submit" class="btn btn-outline-dark btn-sm">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                    </a>
                    <?php
                    $pagina_origen = "insped1.php";
                    // IMPORTANTÍSIMO: incluir el modal justo aquí, como en horarios_ficha.php
                    // para que $row esté definido dentro de editar-horario.php
                    include('editar-horario.php');

                  } else {
                    echo "&nbsp;";
                }
                
              
                                        // ==============================
                          // 🔹 HORAS EXTRA con día y hora
                          // ==============================
                          $queryExtras = "
                    SELECT he.id, he.tipo, he.horas, a.Nombre_ambiente
                    FROM horas_extra he
                    LEFT JOIN ambiente a ON he.id_ambiente = a.id_A
                    WHERE he.instructor_id = $id_ins 
                      AND he.dia = $day 
                      AND he.hora = $hour
                  ";
                  $resultExtras = mysqli_query($conn, $queryExtras);

                  while ($extra = mysqli_fetch_assoc($resultExtras)) {
                    ?>
                    <div style="color:blue; font-size:0.85em; margin-top:4px;">
                        <strong><?php echo htmlspecialchars($extra['tipo']); ?></strong>
                        (<?php echo $extra['horas']; ?>h)
                        <?php if (!empty($extra['Nombre_ambiente'])): ?>
                            <br><span style="color:#444;">AMBIENTE: <?php echo htmlspecialchars($extra['Nombre_ambiente']); ?></span>
                        <?php endif; ?>
                        <br>
                
                        <!-- Botón EDITAR -->
                        <a href="#edit_extra_<?php echo $extra['id']; ?>" 
                           class="btn btn-outline-dark btn-sm" 
                           data-toggle="modal">
                           <i class="bi bi-pencil-square"></i>
                        </a>
                
                        <!-- Botón ELIMINAR -->
                        <form action='../../controlador/HorariosController/eliminar_horas_extra.php'
                              method='POST'
                              style='display:inline;'>
                            <input type='hidden' name='id' value='<?php echo $extra['id']; ?>'>
                            <input type='hidden' name='redirect' value='insped1.php?instructor=<?php echo $id_ins; ?>'>
                            <button type='submit' class='btn btn-outline-dark btn-sm'
                                    onclick="return confirm('¿Seguro que deseas eliminar este registro?');">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                
                        <?php include('editar-horas-extra.php'); ?>
                    </div>
                    <?php
                }
                ?>
                </td>
              <?php } // foreach day ?>
            </tr>
          <?php } // foreach hour ?>

         
          <?php
         // =============================
// BLOQUE DE CÁLCULOS CORREGIDO
// =============================
          // Totales de horas
          // 1️⃣ Horas formación titulada
$sql_titulada = "SELECT SUM(horas_instructor) AS total 
FROM horarios 
WHERE instructor = $id_ins AND period_fk = 1";
$res_titulada = mysqli_query($conn, $sql_titulada);
$row_titulada = mysqli_fetch_assoc($res_titulada);
$sum = (float)($row_titulada['total'] ?? 0);

// 2️⃣ Horas formación complementaria
$sql_comple = "SELECT COALESCE(SUM(horas),0) AS total 
FROM horas_extra 
WHERE instructor_id = $id_ins 
AND tipo = 'complementaria'";
$res_comple = mysqli_query($conn, $sql_comple);
$row_comple = mysqli_fetch_assoc($res_comple);
$sum_comple = (float)($row_comple['total'] ?? 0);

// 3️⃣ Horas contrato
$sql_contrato = "SELECT c.Numero_h 
FROM instructor i
INNER JOIN contrato c ON i.horas_inst = c.id
WHERE i.ID = $id_ins";
$res_contrato = mysqli_query($conn, $sql_contrato);
$row_contrato = mysqli_fetch_assoc($res_contrato);
$horas_contrato = (float)($row_contrato['Numero_h'] ?? 0);

// 4️⃣ Horas extra (seguimiento, red, producción, planeación, etc.)
$sql_extras = "SELECT tipo, COALESCE(SUM(horas),0) AS horas 
FROM horas_extra 
WHERE instructor_id = $id_ins 
AND tipo <> 'complementaria'
GROUP BY tipo";
$res_extras = mysqli_query($conn, $sql_extras);

$total_extras = 0;
$extras_detalle = [];
while ($ex = mysqli_fetch_assoc($res_extras)) {
$extras_detalle[$ex['tipo']] = (float)$ex['horas'];
$total_extras += (float)$ex['horas'];
}

// 5️⃣ Si es planta (32 horas) y no tiene planeación, se agrega automática
$planeacion_auto = 0;
if ($horas_contrato == 32 && !isset($extras_detalle['planeacion'])) {
$planeacion_auto = 10.5;
$extras_detalle['planeacion'] = 10.5;
}

// =============================
// BLOQUE FINAL CORREGIDO
// =============================

// Calcular planeación manual
$planeacion_manual = floatval($extras_detalle['planeacion'] ?? 0.0);

// Planeación automática SOLO si es planta (32 horas) y no existe manual
$planeacion_auto = 0.0;
if ($horas_contrato == 32 && $planeacion_manual == 0.0) {
    $planeacion_auto = 10.5;
}

// Planeación final SOLO para mostrar (NO reduce disponibilidad)
$planeacion_final = ($planeacion_manual > 0 ? $planeacion_manual : $planeacion_auto);

// Horas que SÍ afectan el límite del contrato
$horas_que_cuentan = $sum          // titulada
                   + $sum_comple   // complementaria
                   + $total_extras; // extras (excepto planeación)

// Horas pendientes (las reales)
$pendientes = $horas_contrato - $horas_que_cuentan;

if ($pendientes < 0) { 
    $pendientes = 0;
}

// Este es el valor que muestras en la tabla
$res = $pendientes;

?>
           <tr class="table-bordered table-dark" style="color: black;">
  <td colspan="4">
    <strong>Observaciones:</strong>
    <div style="background-color: #e9f9e9; border: 1px solid #8bc34a; padding: 8px; border-radius: 5px; min-height: 40px; margin-top: 5px;">
      <?php
      include '../../confi/conexion.php';
      $instructor_id = $id_ins ?? null;
      $observacion = null;

      if ($instructor_id) {
          $sql = "SELECT observacion, fecha FROM observaciones WHERE instructor_id = ? ORDER BY fecha DESC LIMIT 1";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $instructor_id);
          $stmt->execute();
          $result = $stmt->get_result();
          $observacion = $result->fetch_assoc();
          $stmt->close();
      }

      if (!empty($observacion)): ?>
        <span style="color: green; font-weight: bold;">
          <?= nl2br(htmlspecialchars($observacion['observacion'])) ?>
        </span>
        <br>
        <small><em>Fecha: <?= htmlspecialchars($observacion['fecha']) ?></em></small>
      <?php else: ?>
        <em>No hay observaciones registradas.</em>
      <?php endif; ?>
    </div>

    <?php if (isset($_GET['mensaje'])): ?>
      <div style="background-color: #c7f9cc; color: #1b4332; padding: 8px; border-radius: 4px; border: 1px solid #2d6a4f; text-align: center; margin-top: 10px;">
        <?= htmlspecialchars($_GET['mensaje']) ?>
        <br>
        <small><i>Fecha: <?= date('Y-m-d H:i:s') ?></i></small>
      </div>
    <?php endif; ?>
  </td>
 <th colspan="3">
    Instructor: <?= $rowins["Nombre"] . " " . $rowins["Apellido"]; ?>
  </th>
</tr>
            <tr class="table-bordered table-dark" style="color: black;">
              <td colspan="4" rowspan="2"></td>
              <td colspan="2">Horas de formación titulada</td>
              <td colspan="1"><?php echo $sum; ?></td>
            </tr>
            <tr class="table-bordered table-dark" style="color: black;">
                <td colspan="2">Horas de formación complementaria</td>
                <td colspan="1"><?php echo $sum_comple; ?></td>
              </tr>

            <?php
// ===========================
// Agregar horas automáticas de planeación para instructores de Planta
// ===========================
if (isset($id_ins)) {
    $query_info = mysqli_query($conn, "SELECT horas_inst FROM instructor WHERE ID = $id_ins");
    if ($query_info && $row_info = mysqli_fetch_assoc($query_info)) {
        $horas_inst = trim($row_info['horas_inst']);

        // Si el instructor tiene contrato de planta (por valor 2 o 32)
        if ($horas_inst == 2 || $horas_inst == 32) {
            ?>
            <tr class="table-bordered table-dark" style="color: black;">
                <td colspan="4"></td>
                <td colspan="2">Horas de planeación</td>
                <td colspan="1">10.5</td>
            </tr>
            <?php
        }
    }
}
?>
            <tr class="table-bordered table-dark" style="color: black;">  
              <td colspan="4"></td>
              <td colspan="2">Horas pendientes de programar</td>
              <td colspan="1"><?php echo $res; ?></td>
            </tr>
            
            <?php
// Traer todas las horas extra asignadas manualmente
$extras = mysqli_query(
  $conn,
  "SELECT tipo, SUM(horas) as total 
   FROM horas_extra 
   WHERE instructor_id = $id_ins
   GROUP BY tipo"
);

// Traducciones legibles
$nombres_tipo = [
  'seguimiento' => 'Horas de seguimiento etapa productiva',
  'red'         => 'Horas red de medios',
  'produccion'  => 'Horas de producción de centro',
  'planeacion'  => 'Horas de planeación',
  'sindical'    => 'Horas permiso sindical',
  'complementaria' => 'Horas de formación complementaria',
  // 🔹 Nuevas equivalencias
  'worldskills_red' => 'Horas WorldSkills - Red de Medios',
  'equipo pedagogico' => 'Horas Equipo Pedagógico',
  'investigacion - autoevaluacion' => 'Horas Investigación - Autoevaluación',
  'investigacion' => 'Horas Investigación',
  'worldskills - senasoft' => 'Horas WorldSkills - Senasoft',
  'tiempo suplementario' => 'Horas Tiempo Suplementario',
  'talleres de la paz' => 'Horas Talleres de Paz',
];
?>

<?php while ($ex = mysqli_fetch_assoc($extras)) { 
    // Omitir complementaria porque ya la mostramos arriba
    if ($ex['tipo'] === 'complementaria') continue; 
?>
<tr class="table-bordered table-dark" style="color: black;">
  <td colspan="4"></td>
  <td colspan="2"><?php echo $nombres_tipo[$ex['tipo']] ?? $ex['tipo']; ?></td>
  <td colspan="1"><?php echo $ex['total']; ?></td>
</tr>
<?php } ?>
<?php  ?>
        </tbody>
      </table>
      
    </div>
  </div>
</div>
   
<?php
include("../plantillas/pantilla-footer.php");
?>
</body>
</html>