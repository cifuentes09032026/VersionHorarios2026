<?php
// editar-horas-extra.php
// Este archivo recibe la variable $extra (definida en insped1.php dentro del bucle de horas_extra)
?>

<!-- Modal Editar Horas Extra -->
<div class="modal fade" id="edit_extra_<?php echo $extra['id']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar hora extra</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
      <form action="../../controlador/HorariosController/actualizar_horas_extra.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $extra['id']; ?>">
          <input type="hidden" name="instructor_id" value="<?php echo $id_ins; ?>">
          <input type="hidden" name="redirect" value="../../vista/admin/insped1.php?instructor=<?php echo $id_ins; ?>">

          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de hora</label>
            <select name="tipo" class="form-control" required>
              <option value="seguimiento" <?php if($extra['tipo']=="seguimiento") echo "selected"; ?>>Seguimiento etapa productiva</option>
              <option value="red" <?php if($extra['tipo']=="red") echo "selected"; ?>>Red de medios</option>
              <option value="produccion" <?php if($extra['tipo']=="produccion") echo "selected"; ?>>Producción</option>
              <option value="planeacion" <?php if($extra['tipo']=="planeacion") echo "selected"; ?>>Planeación</option>
              <option value="sindical" <?php if($extra['tipo']=="sindical") echo "selected"; ?>>Permiso sindical</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="horas" class="form-label">Cantidad de horas</label>
            <input type="number" class="form-control" name="horas" min="1"
                   value="<?php echo $extra['horas']; ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>