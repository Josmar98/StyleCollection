<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $url; ?>
        <small><?php echo "Historial de ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
            
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Historial de ".$url; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <?php
                $saldo = 0;
                if(!empty($_GET['lider'])){
                  if(count($clientes)>1){
                    echo "<b>Líder ".$cliente['primer_nombre']." ".$cliente['primer_apellido']."</b>";
                    echo "<br>";
                  }
                }
                if(!empty($_GET['camp'])){
                  if(count($camps)>1){
                    echo "<b>Campaña ".$campp['numero_campana']." ".$campp['anio_campana']."</b>";
                    echo "<br>";
                  }
                }
              ?>
                <br>
                  <input type="hidden" name="route" id="route" value="Gemas">
                  <input type="hidden" name="action" id="action" value="Historiall">

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label>Seleccione al líder</label>
                      <select class="form-control select2" id="lider" name="lider" style="width:100%;">
                        <option value=""></option>
                        <?php foreach ($lideres as $data): ?>
                          <?php if (!empty($data['id_cliente'])): ?>
                        
                        <option <?php if(!empty($_GET['lider'])){ if($_GET['lider']==$data['id_cliente']){ echo "selected"; } } ?> value="<?=$data['id_cliente']?>">
                          <?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']?>
                        </option>

                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                      <label>Seleccione la Campaña</label>
                      <select class="form-control select2" id="camp" name="camp" style="width:100%;">
                        <option value=""></option>
                        <?php foreach ($campanas as $data): ?>
                          <?php if (!empty($data['id_despacho'])): ?>

                        <option <?php if(!empty($_GET['camp'])){ if($_GET['camp']==$data['id_despacho']){ echo "selected"; } } ?> value="<?=$data['id_despacho']?>">
                          Pedido <?php if($data['numero_despacho']!="1"){ echo $data['numero_despacho']; } ?> Campaña <?=$data['numero_campana']."/".$data['anio_campana']." - ".$data['nombre_campana']?>
                        </option>

                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                      <span class="btn enviar2 enviarForm">Enviar</span>

              <br><br>
              <table id="" class="table table-bordered table-striped datatable2" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Fecha y Hora</th>
                  <th>Concepto</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php 
                  // print_r($historial);
                  $num = 1;
                  foreach ($historial as $data): if(!empty($data['id_cliente'])):                
                    if(!empty($data['fecha_canjeo'])){
                      $razon = '-';
                      $concepto = "Por Canjeo de premio";
                      $fechaMostrar = $data['fecha_canjeo'];
                    // }else if(!empty($data['fecha_aprobado'])){
                    }else if(!empty($data['nombreconfiggema']) && $data['nombreconfiggema'] == 'Por Colecciones De Factura Directa'){

                      $razon = '+';
                      $concepto = "Por Factura Directa <br><small>Pedido ";
                      if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
                      $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
                      $fechaMostrar = $lider->formatFechaInver($data['fecha_aprobado']);
                      $data['cantidad_gemas'] = $data['activas'];
                    // }else if(!empty($data['fecha_gemas'])){
                    }else if(!empty($data['nombreconfiggema']) && $data['nombreconfiggema'] != 'Por Colecciones De Factura Directa'){
                      $razon = '+';
                      // $concepto = "por Gemas";
                      $concepto = $data['nombreconfiggema']." <br><small>Pedido ";
                      if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
                      $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";

                      $data['cantidad_gemas'] = $data['activas'];

                      $fechaMostrar = $data['fecha_gemas'];
                    }else if(!empty($data['fecha_nombramiento'])){
                      $razon = '+';
                      $concepto = "Por Nombramiento <br><small> ".$data['nombre_liderazgo']."</small>";
                      $fechaMostrar = $data['fecha_nombramiento'];
                    }else if(!empty($data['fecha_descuento_gema'])){
                      $razon = '-';
                      $concepto = "Por Liquidación de gemas <br><small>Pedido";
                      if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
                      $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";

                      $fechaMostrar = $data['fecha_descuento_gema'];
                    }else if(!empty($data['fecha_canjeo_gema'])){
                      $razon = '-';
                      $concepto = "Por Canjeo de Gemas por Divisas en Físico <br><small>Pedido";
                      if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
                      $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";

                      $fechaMostrar = $data['fecha_canjeo_gema'];
                    }else if(!empty($data['fecha_obsequio'])){
                      $razon = '+';
                      if($data['descripcion_gemas']==""){
                        $concepto = "Obsequio otorgado por ".$data['firma_obsequio'];
                      }else{
                        $concepto = $data['descripcion_gemas'];
                      }
                      $concepto .= "<br><small>Pedido";
                      // $concepto = "Por Canjeo de Gemas por Divisas en Físico <br><small>Pedido";
                      if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
                      $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";

                      $fechaMostrar = $data['fecha_obsequio'];
                    }
                    if(!empty($data['hora_canjeo'])){
                      $horaMostrar = $data['hora_canjeo'];
                    }else if(!empty($data['hora_aprobado'])){
                      $horaMostrar = $data['hora_aprobado'];
                    }else if(!empty($data['hora_gemas'])){
                      $horaMostrar = $data['hora_gemas'];
                    }else if(!empty($data['hora_nombramiento'])){
                      $horaMostrar = $data['hora_nombramiento'];
                    }else if(!empty($data['hora_descuento_gema'])){
                      $horaMostrar = $data['hora_descuento_gema'];
                    }else if(!empty($data['hora_canjeo_gema'])){
                      $horaMostrar = $data['hora_canjeo_gema'];
                    }else if(!empty($data['hora_obsequio'])){
                      $horaMostrar = $data['hora_obsequio'];
                    }

                ?>
                <tr>

                  <td>
                    <span class="contenido2">
                      <?php echo $num++; ?>
                        
                    </span>
                  </td>
                  <td>
                    <span class="contenido2">
                      <?php 
                        foreach ($lideresHistorial as $liderH) {
                          if(!empty($liderH['id_cliente'])){
                            if($liderH['id_cliente']==$data['id_cliente']){
                              echo $liderH['primer_nombre']." ".$liderH['primer_apellido'];
                            }
                          }
                        }
                      ?>
                    </span>
                  </td>
                  <td>
                    <?php echo $lider->formatFecha($fechaMostrar)." ".$horaMostrar; ?>
                  </td>
                  <td>
                    <?php echo $concepto; ?>
                  </td>
                  <td>
                    <?php echo $razon.number_format($data['cantidad_gemas'],2,',','.'); ?> Gemas
                  </td>
                  <td>
                    <?php if ($razon=="+"): ?>
                      <?php $saldo = $saldo + $data['cantidad_gemas']; ?>
                    <?php elseif ($razon=="-"): ?>
                      <?php $saldo = $saldo - $data['cantidad_gemas']; ?>
                    <?php endif; ?>
                    <?php echo number_format($saldo,2,',','.'); ?>
                  </td>
                      
                </tr>
                <?php
                    endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Fecha y Hora</th>
                  <th>Concepto</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                </tr>
                </tfoot>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->


  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Modulos";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
      });
    }
    
  }
  $(".enviarForm").click(function(){
    var route = $("#route").val();
    var action = $("#action").val();
    var lider = $("#lider").val();
    var camp = $("#camp").val();
    var ruta1 = "?route="+route+"&action="+action;
    var ruta = "?route="+route+"&action="+action;
    if(lider=="" && camp==""){
      ruta += "&all=1";
    }else{
      if(lider!=""){
        ruta += "&lider="+lider;
      }
      if(camp!=""){
        ruta += "&camp="+camp;
      }
    }
    if(ruta!=ruta1){
      window.location = ruta;
    }
  });
  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            window.location = $(this).val();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
                  confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
                    showCancelButton: true,
                  confirmButtonColor: "#ED2A77",
                    confirmButtonText: "¡Si!",
                    cancelButtonText: "No", 
                    closeOnConfirm: false,
                    closeOnCancel: false 
                }).then((isConfirm) => {
                    if (isConfirm.value){                      
                        window.location = $(this).val();
                    }else { 
                        swal.fire({
                            type: 'error',
                            title: '¡Proceso cancelado!',
                            confirmButtonColor: "#ED2A77",
                        });
                    } 
                });

          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });
});  
</script>
</body>
</html>
