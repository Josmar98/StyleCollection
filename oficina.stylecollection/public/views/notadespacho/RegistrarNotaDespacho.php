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
        <?php echo "Nota de Despacho"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Nota de Despacho"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Nota"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Nota";}else{echo "Nota";} ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Notas de Despacho</a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">


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
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Nota de Despacho"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
              $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE despachos.id_campana = campanas.id_campana and campanas.estatus =1 and despachos.estatus=1 and campanas.id_campana={$_GET['campaing']}");
            ?>
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                      <div class="form-group col-sm-6">
                       <label for="">Numero de Nota</label>
                       <input type="number" class="form-control" name="num_nota" value="<?php echo $numero_nota; ?>">
                       <span id="error_fecha1" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-6">
                       <label for="pedidoss">Pedidos</label>
                       <select class="form-control select2" id="pedidoss" name="pedidoss[]" multiple="multiple">
                          <option value="" disabled>Seleccione al menos un pedido</option>
                          <?php foreach ($despachos as $desp){ if(!empty($desp['id_despacho'])){ ?>
                            <option value="<?=$desp['id_despacho']; ?>" <?php if($desp['id_despacho']==$_GET['dpid']){ echo "selected"; } ?> >
                              <?php
                                echo "Pedido N° ".$desp['numero_despacho']; 
                                if(!empty($desp['nombre_despacho'])){
                                  if($desp['nombre_despacho']!=""){
                                    echo " - ".$desp['nombre_despacho'];
                                  }else{
                                    echo " - Campaña ".$desp['numero_campana']."/".$desp['anio_campana'];
                                  }
                                }else{
                                  echo " - Campaña ".$desp['numero_campana']."/".$desp['anio_campana'];
                                }

                              ?>
                            </option>
                          <?php } } ?>
                       </select>
                       <input type="hidden" class="form-control" value="Crédito" id="forma" name="forma">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="pedido">Líder y Pedido</label>
                       <select class="form-control select2" id="pedido" name="pedido">
                          <option value=""></option>
                          <?php  foreach ($pedidosFull as $data) { if(!empty($data['id_pedido'])){  ?>
                            <?php
                              if($accesoBloqueo=="1"){
                                if(!empty($accesosEstructuras)){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$data['id_cliente']){
                                          ?>
                                        <option value="<?php echo $data['id_pedido'] ?>" 
                                              <?php foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                                if ($data['id_pedido'] == $key['id_pedido']): ?>
                                                  disabled
                                              <?php endif; endif; endforeach; ?> 
                                        ><!-- Aqui cierra el Option de apertura  -->
                                              <?php echo $data['cedula']." ".$data['primer_nombre']." ".$data['primer_apellido']. " Pedido: ". $data['cantidad_aprobado'] . " colecciones"; ?>
                                          <?php 
                                      }
                                    }
                                  }
                                }
                              }else if($accesoBloqueo=="0"){
                                  ?>

                                <option value="<?php echo $data['id_pedido'] ?>" 
                                      <?php foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                        if ($data['id_pedido'] == $key['id_pedido']): ?>
                                          disabled
                                      <?php endif; endif; endforeach; ?> 
                                ><!-- Aqui cierra el Option de apertura  -->
                                      <?php echo $data['cedula']." ".$data['primer_nombre']." ".$data['primer_apellido']. " Pedido: ". $data['cantidad_aprobado'] . " colecciones"; ?>

                                  <?php
                              }
                            ?>
                              </option>
                          <?php  }  } ?>
                       </select>
                       <span id="error_pedido" class="errors"></span>
                    </div>
                    <?php foreach ($despachos as $desp){ if(!empty($desp['id_despacho'])){ ?>
                      <div class="form-group col-xs-12 col-sm-3">
                         <label for="cantidad">Cantidad de colecciones - Pedido <?=$desp['numero_despacho']; ?></label>
                         <input type="number" step="1" class="form-control select2 cantidad" id="cantidad<?=$desp['numero_despacho']; ?>" name="cantidad<?=$desp['numero_despacho']; ?>" value="0">
                         <span id="error_cantidad" class="errors"></span>
                      </div>
                    <?php } } ?>

                  </div>

                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="preciodolar">Precio Colección en Dolares</label>
                       <input type="number" step="0.01" class="form-control" id="preciodolar" name="preciodolar">
                       <span id="error_preciodolar" class="errors"></span>
                    </div>

                    <!-- <div class="form-group col-sm-4">
                       <label for="preciobs">Precio Colección en Bolivares</label>
                       <input type="number" step="0.01" class="form-control" id="preciobs" name="preciobs">
                       <span id="error_preciobs" class="errors"></span>
                    </div> -->
                    
                    <div class="form-group col-sm-6">
                       <label for="preciobsfiscal">Precio Colección Fiscal</label>
                       <input type="number" step="0.01" class="form-control" id="preciobsfiscal" name="preciobsfiscal">
                       <span id="error_preciobsfiscal" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="fecha1">Emision de Factura</label>
                       <input type="date" class="form-control" id="fecha1" name="fecha1" value="<?php echo date('Y-m-d'); ?>">
                       <span id="error_fecha1" class="errors"></span>
                    </div>
                    
                    <div class="form-group col-sm-6">
                       <label for="fecha2">Vencimiento de Factura</label>
                       <input type="date" class="form-control" id="fecha2" name="fecha2" min="<?php echo date('Y-m-d'); ?>">
                       <span id="error_fecha2" class="errors"></span>
                    </div>
                  </div>
                
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
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
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=NotaDespacho";
        window.location.href=menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Factura Repetida!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=NotaDespacho";
        window.location.href=menu;
      });
    }
    
  }

  $("#descuento_coleccion").keyup(function(){
    var max = parseFloat($(".max_total_descuento").val());
    var descuento = parseFloat($(this).val());
    var total = (max+descuento).toFixed(2);
    $("#total_descuento").val(total);
  });
  $(".enviar").click(function(){
    var response = validarLiderazgos();

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
              // var campaing = $(".campaing").val();
              // var n = $(".n").val();
              // var y = $(".y").val();
              // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=LiderazgosCamp";
              // $.ajax({
              //       url: '?campaing='+campaing+'&n='+n+'&y='+y+'&route=LiderazgosCamp&action=Registrar',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         id_liderazgo: $("#titulo").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                //       }
                //       if (respuesta == "9"){
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Los datos ingresados estan repetidos!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //     }
                // });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });



    
    }
  });

  $(".cantidad").focusout(function(){
    if($(this).val()==""){
      $(this).val(0);
    }
  });


});
function validarLiderazgos(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var pedido = $("#pedido").val();
  var rpedido = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( pedido.length  != 0 ){
      $("#error_pedido").html("");
      rpedido = true;
    }else{
      rpedido = false;
      $("#error_pedido").html("Debe seleccionar al vendedor con su pedido");
    }
  /*===================================================================*/
  // var cantidad = $("#cantidad").val();
  // var rcantidad = false;
  // // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  //   if( cantidad.length  != 0 ){
  //     $("#error_cantidad").html("");
  //     rcantidad = true;
  //   }else{
  //     rcantidad = false;
  //     $("#error_cantidad").html("Debe llenar la cantidad de colecciones");
  //   }
  /*===================================================================*/
  /*===================================================================*/
  var preciodolar = $("#preciodolar").val();
  var rpreciodolar = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( preciodolar.length  > 0 ){
      $("#error_preciodolar").html("");
      rpreciodolar = true;
    }else{
      rpreciodolar = false;
      $("#error_preciodolar").html("Debe llenar el precio de la colección en Dolares");
    }
  /*===================================================================*/

  /*===================================================================*/
  // var preciobs = $("#preciobs").val();
  // var rpreciobs = false;
  //   if( preciobs.length  > 0 ){
  //     $("#error_preciobs").html("");
  //     rpreciobs = true;
  //   }else{
  //     rpreciobs = false;
  //     $("#error_preciobs").html("Debe llenar el precio de la colección en Bolivares");
  //   }
  /*===================================================================*/

  /*===================================================================*/
  var preciobsfiscal = $("#preciobsfiscal").val();
  var rpreciobsfiscal = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( preciobsfiscal.length  > 0 ){
      $("#error_preciobsfiscal").html("");
      rpreciobsfiscal = true;
    }else{
      rpreciobsfiscal = false;
      $("#error_preciobsfiscal").html("Debe llenar el precio de la colección para nota fiscal");
    }
  /*===================================================================*/

  /*===================================================================*/
  var fecha1 = $("#fecha1").val();
  var rfecha1 = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( fecha1.length  != 0 ){
      $("#error_fecha1").html("");
      rfecha1 = true;
    }else{
      rfecha1 = false;
      $("#error_fecha1").html("Debe seleccionar la fecha de emision de factura");
    }
  /*===================================================================*/
    var fecha2 = $("#fecha2").val();
  var rfecha2 = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( fecha2.length  != 0 ){
      $("#error_fecha2").html("");
      rfecha2 = true;
    }else{
      rfecha2 = false;
      $("#error_fecha2").html("Debe seleccionar la fecha de vencimiento de factura");
    }
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if( rpedido==true && rfecha1==true && rfecha2==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}

</script>
</body>
</html>
