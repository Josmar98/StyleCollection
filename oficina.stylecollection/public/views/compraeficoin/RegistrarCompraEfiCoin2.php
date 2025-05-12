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
        <?php echo $modulo; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

      <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
      <?php require_once 'public/views/assets/bloque_precio_eficoin.php'; ?>

        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }
        ?>
        <!-- left column -->
        <div class="col-md-12" >
          <?php
            //echo " | ".$tasabcv." | ".$tasaeficoin." | ";
          ?>
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Registrar <?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($_GET['admin']) && !empty($_GET['select'])){ ?>
              <form action="" method="GET" class="form_select_lider">
                <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="lider">Seleccione al Lider</label>
                      <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                      <input type="hidden" value="<?=$numero_campana;?>" name="n">
                      <input type="hidden" value="<?=$anio_campana;?>" name="y">
                      <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                      <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                      <input type="hidden" value="<?=$_GET['route']?>" name="route">
                      <input type="hidden" value="<?=$_GET['action']?>" name="action">
                      <input type="hidden" value="<?=$_GET['admin']?>" name="admin">
                      <input type="hidden" value="<?=$_GET['select']?>" name="select">
                      <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                        <option></option>
                          <?php foreach ($lideres as $data): ?>
                            <?php if (!empty($data['id_cliente'])): ?>
                              <?php
                                if($accesoBloqueo=="1"){
                                  if(!empty($accesosEstructuras)){
                                    foreach ($accesosEstructuras as $struct) {
                                      if(!empty($struct['id_cliente'])){
                                        if($struct['id_cliente']==$data['id_cliente']){
                                          if($data['cantidad_aprobado']>0){
                                            ?>
                                            <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                            <?php 
                                          }
                                        }
                                      }
                                    }
                                  }
                                }else if($accesoBloqueo=="0"){
                                  if($data['cantidad_aprobado']>0){
                                    ?>
                                    <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                    <?php
                                  }
                                }
                              ?>
                        
                            <?php endif ?>
                          <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
              </form>
            <?php } ?>
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                <?php
                  if($_SESSION['nombre_rol']!="Vendedor" && empty($_GET['admin']) && empty($_GET['select'])){
                    ?>
                    <div class="row">
                      <div class="col-xs-12 text-right">
                        <a href="?<?=$menu3."route=".$_GET['route']."&action=".$_GET['action']."&admin=1&select=1&lider=0";?>" class="btn enviar2">Reportar Eficoin por Líder</a>
                      </div>
                    </div>
                    <?php
                  }
                ?>
                  <div class="row">
                    
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){
                            if(!empty($pagosD['id_despacho'])){
                              ?>
                                <option><?=$pagosD['tipo_pago_despacho'] ?></option>
                              <?php
                            }
                          }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                ?>
                                  <option><?=$promoPagos['nombre_promocion'] ?></option>
                                <?php
                              }
                            }
                          }
                        ?>
                      </select>
                      <span id="error_tipoPago" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="serial">Serial de billete en dolar</label>
                      <input type="text" class="form-control" id="serial" name="serial">
                      <span id="error_serial" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente montoDinero" value="0" id="equivalente" class="equivalente" name="equivalente">
                      </div>
                      <span id="error_equivalente" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="firma">Firma</label>
                      <input type="text" class="form-control" id="firma" name="firma">
                      <span id="error_firma" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="leyenda">Leyenda</label>
                      <input type="text" class="form-control" id="leyenda" name="leyenda">
                      <span id="error_leyenda" class="errors"></span>
                    </div>
                  </div>
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>
            </form>
          </div>

        </div>
        <!--/.col (left) -->

        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php //require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
  <input type="hidden" class="responses" value="<?php echo $response ?>">
  <input type="hidden" class="rutar" value="<?php echo $rutaRecargaR ?>">
  <input type="hidden" class="ruta" value="<?php echo $rutaRecarga; ?>">
<?php endif; ?>
<?php if(!empty($rutaPdfEficoin)): ?>
<input type="hidden" class="recepcionPago" value="<?php echo $rutaPdfEficoin; ?>">
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
</style>
<script>
$(document).ready(function(){
  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var recepcionPago = $(".recepcionPago").val();
        if(recepcionPago==undefined){
        }else{
          window.open(`?${recepcionPago}`, '_blank');
        }
        var ruta = $(".ruta").val();
        window.location = "?"+ruta;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro repetido!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var ruta = $(".rutar").val();
        window.location = "?"+ruta;
      });
    }
  }

  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
    
  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");

      swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("#fechaPago").val();
  var rfechaPago = false;
  if(fechaPago.length != 0){
    // $("#error_fechaPago").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("#error_fechaPago").html("Debe seleccionar una fecha"); 
  }   
  /*===================================================================*/

  /*===================================================================*/
  var tipoPago = $("#tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("#error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("#error_tipoPago").html("Debe seleccionar el tipo de pago");
  }
  var serial = $("#serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("#error_serial").html("El serial del billete solo acepta numero y Letras");
    }else{
      $("#error_serial").html("Debe llenar el serial del billete");      
    }
  }else{
    $("#error_serial").html("");
  }

  var equivalente = $("#equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("#error_equivalente").html("");
    requivalente = true;
  }else{
    $("#error_equivalente").html("Debe cargar monto del billete");
    requivalente = false;
  }
  /*===================================================================*/

  var firma = $("#firma").val();
  var rfirma = checkInput(firma, alfanumericPattern2);
  if( rfirma == false ){
    if(firma.length != 0){
      $("#error_firma").html("El firma del billete solo acepta numero y Letras");
    }else{
      $("#error_firma").html("Debe llenar el firma del billete");      
    }
  }else{
    $("#error_firma").html("");
  }

  // var leyenda = $("#leyenda").val();
  // var rleyenda = checkInput(leyenda, alfanumericPattern2);
  // if( rleyenda == false ){
  //   if(leyenda.length != 0){
  //     $("#error_leyenda").html("El leyenda del billete solo acepta numero y Letras");
  //   }else{
  //     $("#error_leyenda").html("Debe llenar el leyenda del billete");      
  //   }
  // }else{
  //   $("#error_leyenda").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rserial==true && requivalente==true && rfirma==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  // alert(result);
  return result;
}

</script>
</body>
</html>
