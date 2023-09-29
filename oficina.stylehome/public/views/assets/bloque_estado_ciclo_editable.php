        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <div class="col-xs-12 col-md-12">
          <div class="box">
            <div style="width:100%;text-align:right;position:absolute;z-index:1">
              <button class="btnBoxEstado" style="margin-top:0%;margin-right:1%;background:none;border:none;">
                <span id="fasEstado" class="fa fa-chevron-down" ></span>
              </button>
            </div>
            <div class="box-header">
              <h3 class="box-title">
                Estado de Ciclo ~ <?php if($estado_ciclo=="1"){ echo "Abierta"; } if($estado_ciclo=="0"){ echo "Cerrada"; } ?> ~
              </h3>
              <div class="box_Estados" style="display:none;">
              <select class="form-control" id="estadoCiclo" name="estado_ciclo">
                <option value="0" <?php if($estado_ciclo == "0"){echo "selected=''";} ?>>Cerrada</option>
                <option value="1" <?php if($estado_ciclo == "1"){echo "selected=''";} ?>>Abierta</option>
              </select>
              <button class="btn enviar enviarEstadoCiclo" style="">Enviar</button>
              </div>
            </div>
          </div>
        </div>