<div class="modal fade" id="edit_<?php echo $row['id_hora']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" action="/horarios/controlador/HorariosController/edit.php?id=<?php echo $row['id_hora']; ?>">
        
      <input type="hidden" name="redirect" value="<?php echo $pagina_origen; ?>">
      <div class="modal-body">
          <div class="form-group">
            <label class="control-label"><?php echo "Instructor:" . " " . $row['Nombre'] . " " . $row['Apellido'] ?></label>
            <select class="form-control col-sm-10" id="instructor" name="instructor" required >
              <option value=""> Selecciona el instructor</option>
              <?php
              $inst = "SELECT * FROM instructor";
              $contI = mysqli_query($conn, $inst);
              while ($ins = mysqli_fetch_array($contI)) { ?>
                <option value="<?php echo $ins["ID"] ?>"><?php echo $ins["Nombre"] . " " . $ins['Apellido'] ?></option><?php
                                                                                                                      } ?>
            </select>
            <br>
            <label class="control-label"><?php echo "Dia:" . " " . $row['dia_s']; ?></label>
            <select class="form-control col-sm-10" id="days" name="days" required>
              <option value=""> Selecciona el día</option>
              <option value="1">Lunes</option>
              <option value="2">Martes</option>
              <option value="3">Miercoles</option>
              <option value="4">Jueves</option>
              <option value="5">Viernes</option>
              <option value="6">Sabado</option>
            </select>
            <br>
            <label class="control-label"><?php echo "Hora:" . " " . $row['hora']; ?></label>
            <select class="form-control col-sm-10" id="hour" name="hour" required>
              <option value="">Selecciona la hora</option>
<option value="1" <?php if($row['hora']==1) echo 'selected'; ?>>6:00 - 7:40</option>
<option value="2" <?php if($row['hora']==2) echo 'selected'; ?>>8:00 - 9:40</option>
<option value="3" <?php if($row['hora']==3) echo 'selected'; ?>>10:00 - 11:40</option>
<option value="4" <?php if($row['hora']==4) echo 'selected'; ?>>12:00 - 13:40</option>
<option value="5" <?php if($row['hora']==5) echo 'selected'; ?>>14:20 - 16:00</option>
<option value="6" <?php if($row['hora']==6) echo 'selected'; ?>>16:20 - 18:00</option>
<option value="7" <?php if($row['hora']==7) echo 'selected'; ?>>18:15 - 19:45</option>
<option value="8" <?php if($row['hora']==8) echo 'selected'; ?>>20:00 - 21:40</option>
            </select>
            <br>
            <label class="control-label" for="descripcion">Descripción: </label>
            <input type="text" class="form-control col-sm-10" name="descrip" id="descrip" value="<?php echo $row['descripcion']; ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi-arrow-left"></i>Cancelar</button>
          <button type="submit" class="btn btn-success">Editar</button>
        </div>
      </form>
    </div>
  </div>
</div>