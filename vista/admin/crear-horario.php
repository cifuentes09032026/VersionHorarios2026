<!-- Modal Crear Horario -->
<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-horizontal" method="POST" id="formu" action="../../controlador/guardar_ficha.php?f_h=<?php echo $id_ficha; ?>">
          <div class="form-group">

            <!-- INSTRUCTOR -->
            <label for="ins">Instructor:</label>   
            <select class="form-control" id="ins" name="ins" required>
              <option value="">Seleccionar instructor</option>
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY Nombre ASC";
              $Resultado = mysqli_query($conn, $sql) or die("Error en la tabla: " . mysqli_error($conn));
              while ($filas = mysqli_fetch_assoc($Resultado)) { ?>        
                <option value="<?php echo $filas["ID"]; ?>">
                  <?php echo $filas["Nombre"] . " " . $filas["Apellido"]; ?>
                </option>
              <?php } ?>
            </select>
            <br>

            <!-- DÍAS -->
            <div class="container form-check"> 
              <label for="hour">Día:</label>
              <div class="row justify-content-around">
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkdia[1]" value="1">Lunes<br>
                  <input class="form-check-input" type="checkbox" name="checkdia[2]" value="2">Martes<br>
                  <input class="form-check-input" type="checkbox" name="checkdia[3]" value="3">Miércoles<br>
                </div>
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkdia[4]" value="4">Jueves<br>
                  <input class="form-check-input" type="checkbox" name="checkdia[5]" value="5">Viernes<br>
                  <input class="form-check-input" type="checkbox" name="checkdia[6]" value="6">Sábado<br>
                </div>
              </div>
            </div>
            <br>

            <!-- HORAS -->
            <div class="container">
              <label for="hour">Hora:</label><br>
              <div class="row justify-content-around">
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkhora[1]" value="1">06:00 - 08:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[2]" value="2">08:00 - 10:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[3]" value="3">10:00 - 12:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[4]" value="4">12:00 - 14:00<br>
                </div>
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkhora[5]" value="5">14:00 - 16:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[6]" value="6">16:00 - 18:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[7]" value="7">18:00 - 20:00<br>
                  <input class="form-check-input" type="checkbox" name="checkhora[8]" value="8">20:00 - 22:00
                </div>
              </div>
            </div>
            <br>

            <!-- AMBIENTE -->
            <label for="ho">Ambiente:</label>
            <?php
              $amb = "SELECT * FROM ambiente WHERE id_A > 1 ORDER BY Nombre_ambiente ASC";
              $consulA = mysqli_query($conn, $amb);
            ?>
            <select class="form-control" id="ho" name="idAB" required>
              <option value="">Seleccionar Ambiente</option>
              <?php while ($ambt = mysqli_fetch_assoc($consulA)) { ?>
                <option value="<?php echo $ambt['id_A'] ?>"><?php echo $ambt['Nombre_ambiente'] ?></option>
              <?php } ?>
            </select>
            <br>

            <!-- DESCRIPCIÓN -->
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" name="descrip" placeholder="Cursos Virtuales" required><br>

            <!-- OBSERVACIONES -->
            <label for="Obse">Observaciones:</label>
            <textarea name="observaciones" cols="3" rows="2" class="form-control"></textarea>
            <br>

            <!-- PERIODO -->
            <label for="cur">Periodo Cursado:</label>
            <select class="form-control" id="cur" name="perd_cur" required>
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id, periodo FROM periodo ORDER BY id ASC";
              $Resultado = mysqli_query($conn, $sql) or die("Error en la tabla: " . mysqli_error($conn));
              while ($filas = mysqli_fetch_assoc($Resultado)) { ?>        
                <option value="<?php echo $filas["id"]; ?>"><?php echo $filas["periodo"]; ?></option>
              <?php } ?>
            </select>
            <br>

            <!-- AÑO -->
            <label for="yea">Año Cursado:</label>
            <select class="form-control" id="yea" name="year_cur" required>
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id, time_tit FROM año ORDER BY id ASC";
              $Resultado = mysqli_query($conn, $sql) or die("Error en la tabla: " . mysqli_error($conn));
              while ($filas = mysqli_fetch_assoc($Resultado)) { ?>        
                <option value="<?php echo $filas["id"]; ?>"><?php echo $filas["time_tit"]; ?></option>
              <?php } ?>
            </select>

          </div>

          <!-- BOTONES -->
          <div class="form-group">
            <div class="modal-footer">
              <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  <i class="bi-arrow-left"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="btnCrearHorario">Crear</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('formu').addEventListener('submit', function(e) {
  e.preventDefault(); // Evita el envío directo

  const instructorId = document.getElementById('ins').value;

  if (!instructorId) {
    Swal.fire({
      icon: 'warning',
      title: 'Selecciona un instructor',
      text: 'Debes elegir un instructor antes de crear un horario.',
    });
    return;
  }

  // Llamada AJAX a PHP para verificar horas disponibles
  fetch(`../../controlador/HorariosController/verificar_horas.php?id=${instructorId}`)
    .then(response => response.json())
    .then(data => {
      console.log('Horas disponibles:', data);

      if (!data.ok) {
        Swal.fire({
          icon: 'error',
          title: 'Error en la verificación',
          text: 'No se pudieron verificar las horas disponibles.',
        });
        return;
      }

      if (data.horas_restantes <= 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Sin horas disponibles',
          text: 'El instructor no tiene horas disponibles para programar.',
        });
      } else {
        Swal.fire({
          title: '¿Deseas crear este horario?',
          text: `El instructor tiene ${data.horas_restantes} horas disponibles.`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, crear'
        }).then((result) => {
          if (result.isConfirmed) {
            e.target.submit(); // envía el formulario
          }
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Error de conexión',
        text: 'No se pudo contactar con el servidor.',
      });
    });
});
</script>

