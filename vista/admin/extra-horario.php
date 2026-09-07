<!-- Modal Horas Extra -->
<div class="modal" id="myModalExtra" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="../../controlador/HorariosController/guardar_horas_extra.php">
          
          <input type="hidden" name="instructor_id" value="<?php echo $id_ins; ?>">

          <!-- Tipo de hora extra -->
          <label for="tipo">Tipo de hora extra:</label>   
          <select class="form-control" id="tipo" name="tipo" required>
            <option value="">Seleccionar</option>
            <option value="planeacion">Planeación</option>
            <option value="red">Red de medios</option>
            <option value="produccion">Producción de centro</option>
            <option value="seguimiento">Seguimiento etapa productiva</option>
            <option value="sindical">Permiso sindical</option>
            <option value="complementaria">Formación complementaria</option>
            <option value="worldskills - red">WorldSkills - Red de Medios</option>
            <option value="equipo pedagogico">Equipo Pedagógico</option>
              <option value="investigacion autoevaluacion">Investigación - Autoevaluación</option>
              <option value="investigacion">Investigación</option>
              <option value="worldskills - senasoft">WorldSkills - Senasoft</option>
              <option value="tiempo_suplementario">Tiempo Suplementario</option>
              <option value="talleres de la paz">Talleres de Paz</option>
              <option value="Formación titulada">Formación Técnica - Integración con la Media</option>
              <option value="Diseño curricular">Diseño curricular</option>
              <option value="Proyecto dirección general">Proyecto dirección general</option>
          </select>
          <br>

          <!-- Número de horas -->
          <label for="horas">Cantidad de horas:</label>
          <input type="number" class="form-control" id="horas" name="horas" min="1" max="8" required>
          <br>

          <!-- Seleccionar ambiente -->
          <div class="form-group mt-2">
            <label for="ambiente">Ambiente (opcional)</label>
            <select name="ambiente" id="ambiente" class="form-control">
              <option value="">-- Seleccione un ambiente --</option>
              <?php
                $queryAmb = "SELECT id_A, Nombre_ambiente FROM ambiente ORDER BY Nombre_ambiente ASC";
                $resultAmb = mysqli_query($conn, $queryAmb);
                while ($amb = mysqli_fetch_assoc($resultAmb)) {
                    echo "<option value='{$amb['id_A']}'>{$amb['Nombre_ambiente']}</option>";
                }
              ?>
            </select>
          </div>

          <!-- Selección de días -->
          <div class="container form-check"> 
            <label>Día:</label>
            <div class="row justify-content-around">
              <div class="col-4">
                <input class="form-check-input" type="checkbox" name="dia[]" value="1"> Lunes<br>
                <input class="form-check-input" type="checkbox" name="dia[]" value="2"> Martes<br>
                <input class="form-check-input" type="checkbox" name="dia[]" value="3"> Miércoles<br>
              </div>
              <div class="col-4">
                <input class="form-check-input" type="checkbox" name="dia[]" value="4"> Jueves<br>
                <input class="form-check-input" type="checkbox" name="dia[]" value="5"> Viernes<br>
                <input class="form-check-input" type="checkbox" name="dia[]" value="6"> Sábado<br>
              </div>
            </div>
          </div>
          <br>

          <!-- Selección de horas -->
          <div class="container">
            <label>Hora:</label><br>
            <div class="row justify-content-around">
              <div class="col-4">
                <input class="form-check-input" type="checkbox" name="hora[]" value="1"> 06:00 - 07:40<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="2"> 08:00 - 09:40<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="3"> 10:00 - 11:40<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="4"> 12:00 - 13:40<br>
              </div>
              <div class="col-4">
                <input class="form-check-input" type="checkbox" name="hora[]" value="5"> 14:20 - 16:00<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="6"> 16:20 - 18:00<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="7"> 18:15 - 19:45<br>
                <input class="form-check-input" type="checkbox" name="hora[]" value="8"> 20:00 - 21:40
              </div>
            </div>
          </div>
          <br>

          <!-- Observaciones -->
          <label for="observaciones">Observaciones:</label>
          <textarea name="observaciones" cols="3" rows="2" class="form-control"></textarea>
          <br>

          <div class="form-group">
            <div class="modal-footer">
              <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  <i class="bi-arrow-left"></i> Cancelar
                </button>
                <?php
// Detectar automáticamente en qué archivo se está usando el modal
$paginaActual = basename($_SERVER['PHP_SELF']); // ejemplo: insped1.php, insped2.php, etc.

// Asignar la redirección correcta según la página
$redirectPage = "../../vista/admin/" . $paginaActual . "?instructor=" . $id_ins;
?>
<input type="hidden" name="redirect" value="<?php echo $redirectPage; ?>">


                <button type="submit" class="btn btn-success">Guardar</button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>