<!-- observaciones.php (modal) -->
<div class="modal fade" id="modalObservaciones" tabindex="-1" aria-labelledby="modalObservacionesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="../../controlador/HorariosController/guardar_observacion.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Agregar Observaciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="textoObservacion">Escribe tu observación:</label>
            <textarea id="textoObservacion" name="observacion" class="form-control"
              style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; border-radius: 10px; padding: 10px;"
              rows="5" placeholder="Ejemplo: El instructor cumplió con las horas..." required></textarea>
          </div>
          <!-- IMPORTANTE: usar la variable que tienes definida en insped3 (probablemente $id_ins) -->
          <input type="hidden" name="instructor_id" id="instructor_id" value="<?php echo isset($id_ins) ? intval($id_ins) : ''; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
