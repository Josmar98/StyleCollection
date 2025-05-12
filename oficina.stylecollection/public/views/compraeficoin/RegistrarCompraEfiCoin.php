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
              <div style="width:100%;text-align:center;"><a href="?<?=$menu3;?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo ?></a></div>
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
              <h3 class="box-title">Reportar <?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php
                    $preciom=0;
                    $preciot=0;
                    $preciobcv=0;
                    if(count($eficoins)>1){
                      $eficoin = $eficoins[0];
                      if($eficoin['monto_tasa']!=0){
                        $preciom = (float) $eficoin['monto_tasa'];
                      }
                      if($eficoin['monto_tasa_tarde']!=0){
                        $preciot = (float) $eficoin['monto_tasa_tarde'];;
                      }
                    }
                    if(count($tasaDolarBcv)>1){
                      $tasaDolarBcv=$tasaDolarBcv[0];
                      $preciobcv= (float) $tasaDolarBcv['monto_tasa'];
                    }
                  ?>
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

            <?php 
              $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
              $diaHoy = $dias[date('w')];
              if(date('w')==1){
                $limiteFechaMinimo=date('Y-m-d', time()-((3600*24)*3));
              }else if(date('w')==0){
                $limiteFechaMinimo=date('Y-m-d', time()-((3600*24)*2));
              }else{
                $limiteFechaMinimo=date('Y-m-d', time()-((3600*24)*1));
              }
              // echo date('w');
            
            ?>
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
                    
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="fechaPago">Fecha de Pago</label>
                      <!-- min="<?=$limiteFechaMinimo; ?>" -->
                      <input type="date" class="form-control fechaPago"  value="<?=$fechaActualHoy; ?>" <?php if(empty($_GET['admin'])){ echo "readonly"; } ?> name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="firma">Firma</label>
                      <input type="text" class="form-control" id="firma" name="firma">
                      <span id="error_firma" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="leyenda">Leyenda</label>
                      <input type="text" class="form-control" id="leyenda" name="leyenda">
                      <span id="error_leyenda" class="errors"></span>
                    </div>
                  </div>
                  <!-- <div class="row">

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="turno">Turno</label>
                      <select class="form-control select2 turno" style="width:100%;" name="turno" id="turno">
                        <?php 
                          if(empty($_GET['admin'])){
                            if(empty($_GET['admin'])){ if($horaActual<"14:00:00"){ 
                              ?> <option selected value="1">Mañana</option> <?php
                            } }
                            if(empty($_GET['admin'])){ if($horaActual>="14:00:00"){ 
                              $precioValidoEficoin=$preciot;
                              ?> <option selected value="2">Tarde</option> <?php
                            } }
                          }else{
                            ?>
                              <option value=""></option>
                              <option <?php if($horaActual<"14:00:00"){ echo "selected"; } ?> value="1">Mañana</option>
                              <option <?php if($horaActual>="14:00:00"){ echo "selected"; } ?> value="2">Tarde</option>
                            <?php
                          }
                        ?>
                      </select>
                      <span id="error_turno" class="errors"></span>
                    </div>
                  </div> -->

                  <hr>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="use1">Reportar Tasa (Mañana)</label>
                      <input type="checkbox" id="use1" name="use[ma]">
                      <span class="error_usess errors"></span>
                    </div>
                  </div>
                  <div class="box-turnom d-none">
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                        <br>
                        
                        <select class="form-control select2" id="tipoPago" name="tipoPago[]" style="width:100%;">
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
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="precio_eficoin_total">Tasa Eficoin</label>
                        <input type="number" class="form-control precio_eficoin_total" readonly value="<?=$preciom; ?>" name="precio_eficoin_total[]" id="precio_eficoin_total">
                        <span id="error_precio_eficoin_total" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <label for="tipo_eficoin">Tipo de EfiCoin</label>
                        <select class="form-control select2 tipo_eficoin"  style="width:100%;" name="tipo_eficoin[]" id="tipo_eficoin">
                          <option value=""></option>
                          <option value="Fisico">Fisico</option>
                          <option value="Deposito">Deposito</option>
                        </select>
                        <span id="error_tipo_eficoin" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <label for="serial" id="txt-serial">Serial del billete</label>
                        <input type="text" class="form-control" id="serial" name="serial[]">
                        <span id="error_serial" class="errors"></span>
                      </div>
  
                      <div class="form-group col-xs-12 col-sm-6 col-md-4 box-bancos d-none">
                        <label for="banco">Bancos (Depositado)</label>
                        <select class="form-control select2 banco" style="width:100%;" name="banco[]" id="banco">
                          <option value=""></option>
                          <?php foreach ($bancosDepositos as $bank) { if(!empty($bank['id_banco'])){ ?>
                            <option value="<?=$bank['id_banco']; ?>"><?=$bank['nombre_banco']." - ".$bank['nombre_propietario']." ".$bank['cedula_cuenta']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_banco" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente montoDinero" value="0" id="equivalente" class="equivalente" name="equivalente[]">
                        </div>
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="total_equivalente">Equivalente Total</label>
                        <input type="number" class="form-control total_equivalente" readonly value="0" name="total_equivalente[]" id="total_equivalente">
                        <span id="error_total_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <hr>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="use2">Reportar Tasa (Tarde)</label>
                      <input type="checkbox" id="use2" name="use[ta]">
                      <span class="error_usess errors"></span>
                    </div>
                  </div>

                  <div class="box-turnot d-none">
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tipoPagot">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                        <br>
                        
                        <select class="form-control select2" id="tipoPagot" name="tipoPago[]" style="width:100%;">
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
                        <span id="error_tipoPagot" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="precio_eficoin_totalt">Tasa Eficoin</label>
                        <input type="number" class="form-control precio_eficoin_totalt" readonly value="<?=$preciot; ?>" name="precio_eficoin_total[]" id="precio_eficoin_totalt">
                        <span id="error_precio_eficoin_totalt" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <label for="tipo_eficoint">Tipo de EfiCoin</label>
                        <select class="form-control select2 tipo_eficoint"  style="width:100%;" name="tipo_eficoin[]" id="tipo_eficoint">
                          <option value=""></option>
                          <option value="Fisico">Fisico</option>
                          <option value="Deposito">Deposito</option>
                        </select>
                        <span id="error_tipo_eficoint" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <label for="serialt" id="txt-serialt">Serial del billete</label>
                        <input type="text" class="form-control" id="serialt" name="serial[]">
                        <span id="error_serialt" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-4 box-bancost d-none">
                        <label for="bancot">Bancos (Depositado)</label>
                        <select class="form-control select2 bancot" style="width:100%;" name="banco[]" id="bancot">
                          <option value=""></option>
                          <?php foreach ($bancosDepositos as $bank) { if(!empty($bank['id_banco'])){ ?>
                            <option value="<?=$bank['id_banco']; ?>"><?=$bank['nombre_banco']." - ".$bank['nombre_propietario']." ".$bank['cedula_cuenta']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_bancot" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalentet">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalentet montoDinero" value="0" id="equivalentet" name="equivalente[]">
                        </div>
                        <span id="error_equivalentet" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="total_equivalentet">Equivalente Total</label>
                        <input type="number" class="form-control total_equivalentet" readonly value="0" name="total_equivalente[]" id="total_equivalentet">
                        <span id="error_total_equivalentet" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <hr>

                  
                  <input type="hidden" value="<?=$preciom; ?>" id="precio_eficoin_m" id="precio_eficoin_m">
                  <input type="hidden" value="<?=$preciot; ?>" id="precio_eficoin_t">
                  <input type="hidden" value="<?=$preciobcv; ?>" name="precio_bcv" id="precio_bcv">
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
  $("#use1").change(function(){
    var estadoUse=$(this).is(":checked");
    if(estadoUse==true){
      $(".box-turnom").slideDown();
    }else{
      $(".box-turnom").slideUp();
    }
  });
  $("#use2").change(function(){
    var estadoUse=$(this).is(":checked");
    if(estadoUse==true){
      $(".box-turnot").slideDown();
    }else{
      $(".box-turnot").slideUp();
    }
  });

  $(".box-bancos").hide();
  $(".box-bancos").removeClass("d-none");
  $("#tipo_eficoin").change(function(){
    var forma = $(this).val();
    // alert(forma);
    $(".box-bancos").slideUp();
    if(forma=="Deposito"){
      $("#txt-serial").html("Numero de Comprobante de deposito");
      $(".box-bancos").slideDown();
    } else{
      $("#txt-serial").html("Serial del billete");
    }
  });
  $("#tipo_eficoint").change(function(){
    var forma = $(this).val();
    // alert(forma);
    $(".box-bancost").slideUp();
    if(forma=="Deposito"){
      $("#txt-serialt").html("Numero de Comprobante de deposito");
      $(".box-bancost").slideDown();
    } else{
      $("#txt-serialt").html("Serial del billete");
    }
  });
  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });

  $(".fechaPago").change(function(){
    var fechaPago = $(this).val();
    var turno = $("#turno").val();
    $.ajax({
      url: '',
      type: 'POST',
      data: {
        tasa_eficoin_fecha: fechaPago,
      },
      success: function(respuesta){
        // alert(respuesta);
        var data=JSON.parse(respuesta);
        console.log(data);
        if (data.msj == "1"){
          if(data.msj_efi=="1"){
            var datos_efi = data.data_efi;
            datos_efi.monto_tasa
            $("#precio_eficoin_m").val(datos_efi.monto_tasa);
            $("#precio_eficoin_t").val(datos_efi.monto_tasa_tarde);
            $("#precio_eficoin_total").val(datos_efi.monto_tasa);
            $("#precio_eficoin_totalt").val(datos_efi.monto_tasa_tarde);
            // if(turno==""){
            //   $("#precio_eficoin_total").val(0);
            //   $("#precio_eficoin_totalt").val(0);
            // }else{
            //   if(turno=="1"){
            //     $("#precio_eficoin_total").val(datos_efi.monto_tasa);
            //   }
            //   if(turno=="2"){
            //     $("#precio_eficoin_totalt").val(datos_efi.monto_tasa_tarde);
            //   }
            // }
          }else{
            $("#precio_eficoin_total").val(0);
            $("#precio_eficoin_totalt").val(0);
          }
          if(data.msj_bcv=="1"){
            var datos_bcv = data.data_bcv;
            datos_bcv.monto_tasa
            $("#precio_bcv").val(datos_bcv.monto_tasa);
          }else{
            $("#precio_bcv").val(0);
          }
          var eqv = parseFloat($("#equivalente").val());
          var tasaefi = parseFloat($("#precio_eficoin_total").val());
          var tasabcv = parseFloat($("#precio_bcv").val());
          var bsefi = (eqv*tasaefi);
          var bsbcv = (eqv*tasabcv);
          if(bsefi>bsbcv){
            var diferencia = bsefi-bsbcv;
          }else{
            var diferencia = bsbcv-bsefi;
          }
          var eqvadd = (diferencia/tasabcv);
          var nuevoeqv = parseFloat((eqv+eqvadd).toFixed(2));
          if(tasaefi==0){
            nuevoeqv=0;
          }
          if(tasabcv==0){
            nuevoeqv=0;
          }
          $("#total_equivalente").val(nuevoeqv);

          var eqv = parseFloat($("#equivalentet").val());
          var tasaefi = parseFloat($("#precio_eficoin_totalt").val());
          var tasabcv = parseFloat($("#precio_bcv").val());
          var bsefi = (eqv*tasaefi);
          var bsbcv = (eqv*tasabcv);
          if(bsefi>bsbcv){
            var diferencia = bsefi-bsbcv;
          }else{
            var diferencia = bsbcv-bsefi;
          }
          var eqvadd = (diferencia/tasabcv);
          var nuevoeqv = parseFloat((eqv+eqvadd).toFixed(2));
          if(tasaefi==0){
            nuevoeqv=0;
          }
          if(tasabcv==0){
            nuevoeqv=0;
          }
          $("#total_equivalentet").val(nuevoeqv);
        }
        if (data.msj == "2"){ 
          $("#precio_eficoin_m").val(0);
          $("#precio_eficoin_t").val(0);
          $("#precio_eficoin_total").val(0);
          $("#precio_eficoin_totalt").val(0);
          $("#precio_eficoin_totalt").val(0);
          $("#precio_bcv").val(0);
        }
      }
    });

  });

  $("#turno").change(function(){
    var turno = $(this).val();
    if(turno==""){
      $("#precio_eficoin_total").val("");
    }
    if(turno==1){
      var eficoin = parseFloat($("#precio_eficoin_m").val());
      if(eficoin>0){
        $("#precio_eficoin_total").val(eficoin);
      }else{
        $("#precio_eficoin_total").val(0);
      }
    }
    if(turno==2){
      var eficoin = parseFloat($("#precio_eficoin_t").val());
      if(eficoin>0){
        $("#precio_eficoin_total").val(eficoin);
      }else{
        $("#precio_eficoin_total").val(0);
      }
    }

    var eqv = parseFloat($("#equivalente").val());
    var tasaefi = parseFloat($("#precio_eficoin_total").val());
    var tasabcv = parseFloat($("#precio_bcv").val());
    var bsefi = (eqv*tasaefi);
    var bsbcv = (eqv*tasabcv);
    if(bsefi>bsbcv){
      var diferencia = bsefi-bsbcv;
    }else{
      var diferencia = bsbcv-bsefi;
    }
    var eqvadd = (diferencia/tasabcv);
    var nuevoeqv = parseFloat((eqv+eqvadd).toFixed(2));
    if(tasaefi==0){
      nuevoeqv=0;
    }
    if(tasabcv==0){
      nuevoeqv=0;
    }
    $("#total_equivalente").val(nuevoeqv); 
  });

  $("#equivalente").on('change keyup',function(){
    var eqv = parseFloat($("#equivalente").val());
    var tasaefi = parseFloat($("#precio_eficoin_total").val());
    var tasabcv = parseFloat($("#precio_bcv").val());
    var bsefi = (eqv*tasaefi);
    var bsbcv = (eqv*tasabcv);
    if(bsefi>bsbcv){
      var diferencia = bsefi-bsbcv;
    }else{
      var diferencia = bsbcv-bsefi;
    }
    var eqvadd = (diferencia/tasabcv);
    var nuevoeqv = parseFloat((eqv+eqvadd).toFixed(2));
    if(tasaefi==0){
      nuevoeqv=0;
    }
    if(tasabcv==0){
      nuevoeqv=0;
    }
    $("#total_equivalente").val(nuevoeqv);    
  });

  $("#equivalentet").on('change keyup',function(){
    var eqv = parseFloat($("#equivalentet").val());
    var tasaefi = parseFloat($("#precio_eficoin_totalt").val());
    var tasabcv = parseFloat($("#precio_bcv").val());
    var bsefi = (eqv*tasaefi);
    var bsbcv = (eqv*tasabcv);
    if(bsefi>bsbcv){
      var diferencia = bsefi-bsbcv;
    }else{
      var diferencia = bsbcv-bsefi;
    }
    var eqvadd = (diferencia/tasabcv);
    var nuevoeqv = parseFloat((eqv+eqvadd).toFixed(2));
    if(tasaefi==0){
      nuevoeqv=0;
    }
    if(tasabcv==0){
      nuevoeqv=0;
    }
    $("#total_equivalentet").val(nuevoeqv);    
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

  /*===================================================================*/
  


  /*===================================================================*/
  var mturno = $("#use1").is(":checked");
  var tturno = $("#use2").is(":checked");
  var rturno = false;
  if(mturno==true || tturno==true){
    rturno=true;
    $(".error_usess").html("");
  }else{
    $(".error_usess").html("Debe escoger llenar alguno de los turnos");
  }
  // var turno = $("#turno").val();
  // var rturno = false;
  // if(turno.length != 0){
  //   // $("#error_turno").html("El nombre del producto no debe contener numeros o caracteres especiales");
  //   $("#error_turno").html("");
  //   rturno = true;
  // }else{
  //   rturno = false;
  //   $("#error_turno").html("Debe seleccionar un turno"); 
  // }
  /*===================================================================*/
  if(tturno==true){
    /*===================================================================*/
    var tipoPagot = $("#tipoPagot").val();
    var rtipoPagot = false;
    // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( tipoPagot.length != 0 ){
      $("#error_tipoPagot").html("");
      rtipoPagot = true;
    }else{
      rtipoPagot = false;
      $("#error_tipoPagot").html("Debe seleccionar el tipo de pago");
    }
    /*===================================================================*/
    /*===================================================================*/
    var serialt = $("#serialt").val();
    var rserialt = checkInput(serialt, alfanumericPattern);
    if( rserialt == false ){
      if(serialt.length != 0){
        $("#error_serialt").html("El serial del billete solo acepta numero y Letras");
      }else{
        $("#error_serialt").html("Debe llenar el serial del billete");      
      }
    }else{
      $("#error_serialt").html("");
    }
    /*===================================================================*/
    /*===================================================================*/
    var tipo_eficoint = $("#tipo_eficoint").val();
    var rtipo_eficoint = false;
    // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( tipo_eficoint.length != 0 ){
      $("#error_tipo_eficoint").html("");
      rtipo_eficoint = true;
    }else{
      rtipo_eficoint = false;
      $("#error_tipo_eficoint").html("Debe seleccionar el tipo de eficoin");
    }
    /*===================================================================*/
    if(tipo_eficoint=="Deposito"){
      var bancot = $("#bancot").val();
      var rbancot = false;
      // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
      if( bancot.length != 0 ){
        $("#error_bancot").html("");
        rbancot = true;
      }else{
        rbancot = false;
        $("#error_bancot").html("Debe seleccionar el banco");
      }
      
    }else{
      var rbancot = true;
    } 
    /*===================================================================*/
    var equivalentet = $("#equivalentet").val();
    equivalentet = parseFloat(equivalentet);
    var requivalentet = false;
    if(equivalentet > 0){
      $("#error_equivalentet").html("");
      requivalentet = true;
    }else{
      $("#error_equivalentet").html("Debe cargar monto del billete");
      requivalentet = false;
    }
    /*===================================================================*/
  
    /*===================================================================*/
    
    var tasaeficoint=parseFloat($("#precio_eficoin_totalt").val());
    if(tasaeficoint==0){
      var rtasaeficoint=false;
      $("#error_precio_eficoin_totalt").html("La tasa no debe ser 0");
    }else if(tasaeficoint > 0){
      var rtasaeficoint=true;
      $("#error_precio_eficoin_totalt").html("");
    } else {
      var rtasaeficoint=false;
      $("#error_precio_eficoin_totalt").html("La Tasa no debe contener un monto negativo");
    }
  
    var total_equivalentet=parseFloat($("#total_equivalentet").val());
    if(total_equivalentet==0){
      var rtotal_equivalentet=false;
      $("#error_total_equivalentet").html("El total no debe ser 0");
    }else if(total_equivalentet > 0){
      var rtotal_equivalentet=true;
      $("#error_total_equivalentet").html("");
    } else {
      var rtotal_equivalentet=false;
      $("#error_total_equivalentet").html("El total no debe contener un monto negativo");
    }
    /*===================================================================*/
  }else{
    var rtipoPagot = true;
    var rserialt = true;
    var rtipo_eficoint = true;
    var rbancot = true;
    var requivalentet = true;
    var rtasaeficoint = true;
    var rtotal_equivalentet = true;
  }
  if(mturno==true){
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
    /*===================================================================*/
    /*===================================================================*/
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
    /*===================================================================*/
    /*===================================================================*/
    var tipo_eficoin = $("#tipo_eficoin").val();
    var rtipo_eficoin = false;
    // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( tipo_eficoin.length != 0 ){
      $("#error_tipo_eficoin").html("");
      rtipo_eficoin = true;
    }else{
      rtipo_eficoin = false;
      $("#error_tipo_eficoin").html("Debe seleccionar el tipo de eficoin");
    }
    /*===================================================================*/
    if(tipo_eficoin=="Deposito"){
      var banco = $("#banco").val();
      var rbanco = false;
      // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
      if( banco.length != 0 ){
        $("#error_banco").html("");
        rbanco = true;
      }else{
        rbanco = false;
        $("#error_banco").html("Debe seleccionar el banco");
      }
      
    }else{
      var rbanco = true;
    } 
    /*===================================================================*/
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
  
    /*===================================================================*/
    
    var tasaeficoin=parseFloat($("#precio_eficoin_total").val());
    if(tasaeficoin==0){
      var rtasaeficoin=false;
      $("#error_precio_eficoin_total").html("La tasa no debe ser 0");
    }else if(tasaeficoin > 0){
      var rtasaeficoin=true;
      $("#error_precio_eficoin_total").html("");
    } else {
      var rtasaeficoin=false;
      $("#error_precio_eficoin_total").html("La Tasa no debe contener un monto negativo");
    }
  
    var total_equivalente=parseFloat($("#total_equivalente").val());
    if(total_equivalente==0){
      var rtotal_equivalente=false;
      $("#error_total_equivalente").html("El total no debe ser 0");
    }else if(total_equivalente > 0){
      var rtotal_equivalente=true;
      $("#error_total_equivalente").html("");
    } else {
      var rtotal_equivalente=false;
      $("#error_total_equivalente").html("El total no debe contener un monto negativo");
    }
    /*===================================================================*/
  }else{
    var rtipoPago = true;
    var rserial = true;
    var rtipo_eficoin = true;
    var rbanco = true;
    var requivalente = true;
    var rtasaeficoin = true;
    var rtotal_equivalente = true;
  }  






  /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rfirma==true && rtipoPago==true && rturno==true && rtipo_eficoin==true && rtasaeficoin==true && rbanco==true && rserial==true && requivalente==true && rtotal_equivalente==true && rtipoPagot==true && rserialt==true && rtipo_eficoint==true && rbancot==true && requivalentet==true && rtasaeficoint==true && rtotal_equivalentet==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  // alert('rfechaPago: '+rfechaPago);
  // alert('rfirma: '+rfirma);
  // alert('rtipoPago: '+rtipoPago);
  // alert('rturno: '+rturno);
  // alert('rtipo_eficoin: '+rtipo_eficoin);
  // alert('rtasaeficoin: '+rtasaeficoin);
  // alert('rbanco: '+rbanco);
  // alert('rserial: '+rserial);
  // alert('requivalente: '+requivalente);
  // alert('rtotal_equivalente: '+rtotal_equivalente);
  // alert('rtipoPagot: '+rtipoPagot);
  // alert('rserialt: '+rserialt);
  // alert('rtipo_eficoint: '+rtipo_eficoint);
  // alert('rbancot: '+rbancot);
  // alert('requivalentet: '+requivalentet);
  // alert('rtasaeficoint: '+rtasaeficoint);
  // alert('rtotal_equivalentet: '+rtotal_equivalentet);
  // alert(result);
  return result;
}

</script>
</body>
</html>
