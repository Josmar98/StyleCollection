        <div class="col-xs-12 col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Visibilidad</h3>
              <select class="form-control" id="visibilidadCiclo" name="visibilidadCiclo">
                <option value="0" <?php if($ciclo['visibilidad_ciclo'] == "0"){ echo "selected=''"; } ?>>Oculto</option>
                <option value="1" <?php if($ciclo['visibilidad_ciclo'] == "1"){ echo "selected=''"; } ?>>Visible</option>
              </select>
              <button class="btn enviar enviarVisibilidadCiclo" style="">Enviar</button>
            </div>
          </div>
        </div>
