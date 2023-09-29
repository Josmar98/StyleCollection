<?php
  $estado_ciclo = $ciclo['estado_ciclo'];
  if($estado_ciclo=="0"){
    ?>
      <div class="col-xs-12 col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              Estado de Ciclo ~ <?php if($estado_ciclo=="1"){ echo "Abiert0"; } if($estado_ciclo=="0"){ echo "Cerrado"; } ?> ~
            </h3>
          </div>
        </div>
      </div>  
    <?php
  }
  if ($_SESSION['home']['nombre_rol']=="Administrador" || $_SESSION['home']['nombre_rol']=="Superusuario"){
    $estado_ciclo = "1";
  }
?>