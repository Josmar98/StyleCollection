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
        <?php echo "Pedidos"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Pedidos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pedidos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Pedidos"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Pedidos" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">



        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Nuevo <?php echo "Pedidos"; ?></h3>
            </div>
            <?php if ( empty($_GET['opInicial']) && empty($_GET['cantPagos']) ): ?>
              <form action="" method="get" role="form" class="form_register">
                <div class="box-body">
                    <input type="hidden" name="campaing" value="<?=$_GET['campaing']; ?>">
                    <input type="hidden" name="n" value="<?=$_GET['n']; ?>">
                    <input type="hidden" name="y" value="<?=$_GET['y']; ?>">
                    <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                    <input type="hidden" name="action" value="<?=$_GET['action']; ?>">

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="opcion_inicial">¿Se va a trabajar con Inicial?</label>
                          <select class="form-control select2" id="opcion_inicial" name="opInicial" style="width:100%;">
                            <option value=""></option>
                            <option value="Y">SI</option>
                            <option value="N">NO</option>
                          </select>
                         <span id="error_opcion_inicial" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="">¿La Inicial se descontará en el ultimo pago?</label>
                        <!-- <br> -->
                        <select class="form-control select2" id="" name="opOpt" style="width:100%;">
                          <option value="Y">SI</option>
                          <option value="N">NO</option>
                        </select>
                        <small><b style="color:#000;">Nota: </b><b style="color:red;">Si no va a haber Inicial mantenga en "SI"</b></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="">¿Los Pagos son Full?</label>
                        <!-- <small>Si no va a haber opcional mantenga en "SI"</small> -->
                        <br>
                        <select class="form-control select2" id="" name="opOblig" style="width:100%;">
                          <option value="Y">SI</option>
                          <option value="N">NO</option>
                        </select>
                        <small><b style="color:#000;">Pagos Full: </b><b style="color:red;">Se debe pagar el 100% de cada pago para pasar al siguiente concepto de pago</b></small>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="cantidad_pagos">Cantidad de Pagos</label>
                          <select class="form-control select2" id="cantidad_pagos" name="cantPagos" style="width:100%;">
                            <option value="0"></option>
                          <?php foreach ($cantidadPagosDespachos as $pagosd): ?>
                            <option value="<?=$pagosd['cantidad']; ?>"><?=$pagosd['cantidad']; ?> (<?=$pagosd['name']; ?>)</option>
                          <?php endforeach ?>
                          </select>
                         <span id="error_cantidad_pagos" class="errors"></span>
                      </div>

                    </div>
                    
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  
                  <span type="submit" class="btn enviar2 enviarCarga">Enviar</span>
                  <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                  <button class="btn-enviarCarga d-none" disabled="" >enviar</button>
                </div>
              </form>
            <?php 
              elseif ( !empty($_GET['opInicial']) && !empty($_GET['cantPagos']) ): 
                if($_GET['cantPagos']>0 && $_GET['cantPagos']<=count($cantidadPagosDespachos)): ?>
                  <form action="" method="post" role="form" class="form_register">
                    
                    <input type="hidden" id="cantPagosMax" value="<?=count($cantidadPagosDespachos); ?>">
                    <input type="hidden" id="opInicial" value="<?=$_GET['opInicial']; ?>">
                    <input type="hidden" id="cantPagos" value="<?=$_GET['cantPagos']; ?>">
                    <span class="d-none json_inicial"><?php echo json_encode($claveInicial); ?></span>
                    <span class="d-none json_pagos"><?php echo json_encode($cantidadPagosDespachosFild); ?></span>
                    
                    <div class="box-header">
                      <span type="submit" class="btn enviar">Enviar</span>
                      <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar d-none" disabled="" >enviar</button>
                    </div>
                    
                    <hr>

                    <div class="box-body">
                        <div class="row">
                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="numero_despacho">Numero de Pedido</label>
                            <input type="number" class="form-control" id="numero_despacho" name="numero_despacho" min="1" max="10" maxlength="2" placeholder="Ingresar numero de despacho" readonly="" value="<?php echo ($despachosActual+1) ?>">
                            <span id="error_numero_despacho" class="errors"></span>
                          </div>
                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="nombre_despacho">Nombre de Despacho</label>
                            <input type="text" class="form-control" id="nombre_despacho" name="nombre_despacho" >
                          </div>

                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="limite_pedido">Fecha Limite de Pedido</label>
                            <input type="date" class="form-control" id="limite_pedido" name="limite_pedido" >
                            <span id="error_limite_pedido" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6">
                             <label for="apertura_seleccion_plan">Fecha apertura para Seleccion de Plan</label>
                             <input type="date" class="form-control" id="apertura_seleccion_plan" name="apertura_seleccion_plan"  >
                             <span id="error_apertura_seleccion_plan" class="errors"></span>
                          </div>
                          
                          <div class="form-group col-xs-12 col-sm-6">
                             <label for="limite_seleccion_plan">Fecha limite para Seleccion de Plan</label>
                             <input type="date" class="form-control" id="limite_seleccion_plan" name="limite_seleccion_plan"  >
                             <span id="error_limite_seleccion_plan" class="errors"></span>
                          </div>
                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="plan_seleccion">Plan de Seleccion de premios</label>
                            <select class="form-control select2" id="plan_seleccion" name="plan_seleccion" style="width:100%;">
                              <?php foreach ($cantidadPagosDespachosFild as $cvPagos): ?>
                              <option value="<?=$cvPagos['id']; ?>"><?=$cvPagos['name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        
                        <hr>

                        

                        <div class="row">
                          <?php if (!empty($_GET['opInicial']) && $_GET['opInicial']=="Y"){ foreach ($claveInicial as $cvInicial) { ?>
                            <div class="form-group col-xs-12 col-sm-6" >
                               <label for="inicial<?=$cvInicial['id']; ?>">Fecha de pago inicial <?=$cvInicial['name']; ?></label>
                               <input type="date" class="form-control" id="inicial<?=$cvInicial['id']; ?>" name="fechasInicial[inicial<?=$cvInicial['id']; ?>]">
                               <span id="error_inicial<?=$cvInicial['id']; ?>" class="errors"></span>
                            </div>
                          <?php } } ?>

                          <?php  foreach ($cantidadPagosDespachosFild as $cvPagos){  foreach ($claveInicial as $cvInicial) { ?>
                            <div class="form-group col-xs-12 col-sm-6">
                               <label for="<?=$cvPagos['id'].$cvInicial['id']; ?>">Fecha de <?=mb_strtolower($cvPagos['name']); ?> <?=$cvInicial['name']; ?></label>
                                <input type="date" class="form-control" id="<?=$cvPagos['id'].$cvInicial['id']; ?>" name="fechasPagos[<?=$cvPagos['id'].$cvInicial['id']; ?>]">
                               <span id="error_<?=$cvPagos['id'].$cvInicial['id']; ?>" class="errors"></span>
                            </div>
                          <?php } } ?>
                        </div>

                        
                        <hr>
                        <!-- TABLA DE PRODUCTOS -->
                        <div class="row">
                          <div class="col-sm-12">
                            <b><i><span style="color:red">(Importante) Nota:</span> Debe marcar las casillas de cada producto que desee agregar a la coleccion, una vez alla seleccionado la cantidad de productos para construir la misma. De lo contrario podria no calcularse el monto correcto.</i></b><br><br>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12" style="margin-left:5%;">
                            <label for="buscando">Buscar: </label>
                            <input type="text" id="buscando">
                          </div>
                          <br><br>
                        </div>
                        <div class="row" style="max-height:90vh;overflow:auto;border:1px solid #CCC;width:100%;margin-left:0%;margin-right:0%;">
                          <div class="col-sm-12">
                            <table id="datatablee" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Producto</th>
                                  <!-- <th>Descripcion</th> -->
                                  <th>Cantidad</th>
                                  <th>Precio</th>
                                  <th>Cantidad</th>
                                  <th>---</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                  $num = 1;
                                  // print_r($clientes);
                                  foreach ($productos as $data):
                                    if(!empty($data['id_producto'])):  
                                ?>
                                  <tr class="elementTR">
                                    <td style="width:5%">
                                      <span class="contenido2">
                                        <?php echo $num++; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['producto']; ?>
                                      </span>
                                    </td>
                                    
                                    
                                    <!-- <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['descripcion']; ?>
                                      </span>
                                    </td> -->
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['cantidad']; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <input type="number" step="0.10" min="0" name="precios[]" value="0" class="precio_productos preciosid<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px">
                                      <input type="hidden" name="precioid[]" value="<?php echo $data['id_producto'] ?>">
                                    </td>
                                    <td style="width:20%">
                                      <input type="number" min="0" name="cantidad_productos[]" value="0" class="cantidad_productos cantidad<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px">
                                      <input type="hidden" name="elementosid[]" value="<?php echo $data['id_producto'] ?>">
                                    </td>
                                    <td style="width:10%">
                                      <input type="checkbox" class="cheking check<?php echo $data['id_producto'] ?>" value="<?php echo $data['id_producto'] ?>" name="cheking[]">
                                      <!-- <input type="" class="preciosid<?php echo $data['id_producto'] ?>" name="precios[]" value="<?php echo $data['precio'] ?>"> -->
                                    </td>
                                  </tr>
                                <?php
                                    endif;
                                  endforeach;
                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>Nº</th>
                                  <th>Producto</th>
                                  <!-- <th>Descripcion</th> -->
                                  <th>Cantidad</th>
                                  <th>Precio</th>
                                  <th>Cantidad</th>
                                  <th>---</th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                        <!-- TABLA DE PRODUCTOS -->

                        <hr>

                        <div class="row">
                          <div class="form-group col-sm-6">
                             <label for="precio_coleccion">Precio de coleccion</label>
                             <div class="input-group">
                              <span class="input-group-addon">$</span> 
                              <input type="text" class="form-control" min="0" id="precio_coleccion" name="precio_coleccion" maxlength="30" placeholder="Precio de la coleccion" readonly="">
                             </div>
                             <span id="error_precio_coleccion" class="errors"></span>
                          </div>
                          
                          <?php if (!empty($_GET['opInicial']) && $_GET['opInicial']=="Y"): ?>
                            <div class="form-group col-sm-6">
                               <label for="precioInn">Precio Inicial de coleccion</label>
                               <div class="input-group">
                                <span class="input-group-addon">$</span> 
                                <input type="number" step="0.1" class="form-control" min="0" id="precioInn" name="precioInn" maxlength="30" placeholder="Precio de la coleccion">
                               </div>
                               <span id="error_precioInn" class="errors"></span>
                            </div>
                          <?php endif; ?>
                        </div>

                        <div class="row">
                          <?php foreach ($cantidadPagosDespachosFild as $cvPagos) { ?>
                            <div class="form-group col-sm-6">
                              <label for="precio_<?=$cvPagos['id']; ?>"><?=$cvPagos['name']; ?> de coleccion</label>
                              <div class="input-group">
                                <span class="input-group-addon">$</span> 
                                <input type="number" step="0.1" class="form-control" min="0" id="precio_<?=$cvPagos['id']; ?>" name="preciosPagos[precio_<?=$cvPagos['id']; ?>]" maxlength="30" placeholder="Precio de <?=mb_strtolower($cvPagos['name']); ?> la coleccion">
                              </div>
                              <span id="error_precio_<?=$cvPagos['id']; ?>" class="errors"></span>
                            </div>
                          <?php } ?>

                          <div class="form-group col-xs-12" style="text-align:center;">
                            <span id="error_comparativa"  class="errors"></span>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-sm-6">
                             <label for="precioInn">Descuento de Contado de coleccion</label>
                             <div class="input-group">
                              <span class="input-group-addon">$</span> 
                              <input type="number" step="0.1" class="form-control" min="0" id="precioContado" value="<?php echo $despacho['contado_precio_coleccion']; ?>" name="precioContado" maxlength="30" placeholder="Precio de la coleccion">
                             </div>
                             <span id="error_precioContado" class="errors"></span>
                          </div>
                          
                          <div class="form-group col-sm-6">
                             <label for="minimasPedido">Colecciones minimas para pedido</label>
                             <div class="input-group">
                              <span class="input-group-addon">$</span> 
                              <input type="number" step="1" class="form-control" min="1" id="minimasPedido" value="<?php echo $despacho['cantidad_minima_pedido']; ?>" name="minimasPedido" maxlength="30" placeholder="Colecciones minimas para pedido">
                             </div>
                             <span id="error_minimasPedido" class="errors"></span>
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
                  <?php 
                else: ?> 
                    <div class="box-body">
                        <p><b>Ha seleccionado una cantidad de pagos que esta fuera de los limites permitidos, por favor, vuelva atras, para seleccionar nuevamente la cantidad de pagos</b></p>
                        <br>
                        <a href="?campaing=<?=$_GET['campaing']; ?>&n=<?=$_GET['n']; ?>&y=<?=$_GET['y']; ?>&route=<?=$_GET['route']; ?>&action=<?=$_GET['action']; ?>" class="btn enviar2">Volver Atras</a>
                    </div>
                <?php endif; 
              endif;
            ?>

          </div>

        </div>
        <input type="hidden" id="opOpt" value="<?=$_GET['opOpt']; ?>">
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=Despachos";
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
  $("#buscando").keyup(function(){
    $(".elementTR").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".elementTR:not(:contains('"+buscar+"'))").hide();
    }
  });

  function Capitalizar(str){
    return str.replace(/\w\S*/g, function(txt){
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
  }

  $(".enviarCarga").click(function(){
    var response = validarCarga();

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
            $(".btn-enviarCarga").removeAttr("disabled");
            $(".btn-enviarCarga").click();
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      numero_despacho: $("#numero_despacho").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                      }
                      if (respuesta == "9"){
                        swal.fire({
                            type: 'error',
                            title: '¡Los datos ingresados estan repetidos!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                            type: 'error',
                            title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
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

    } //Fin condicion

  }); // Fin Evento

  var precioInicial = $("#precio_coleccion").val();
  if(precioInicial.length == 0){
    $("#precio_coleccion").val("0");
  }
  $(".cheking").click(function(){

    var id = $(this).val();
    var precioactual = parseFloat($("#precio_coleccion").val());
    var cantidad = $(".cantidad"+id).val();
    if(cantidad.length == 0){
      $(".cantidad"+id).val(0);
    }
    if(cantidad.length > 0){
      cantidad = $(".cantidad"+id).val();
    }

    // var valor = parseFloat($(".preciosid"+id).val());
    // var operation = parseFloat(cantidad) * valor;
    var nvalor = $(".preciosid"+id).val();
    if(nvalor==""){
      var valor = parseFloat("0");
    }else{
      var valor = parseFloat($(".preciosid"+id).val());
    }
    var operation = parseFloat(cantidad) * valor;

    if($(this).prop('checked')){
      var newPrecioCol = parseFloat((precioactual+operation).toFixed(2));
      $(".cantidad"+id).attr("readonly","1");
      $(".preciosid"+id).attr("readonly","1");
      $("#precio_coleccion").val(newPrecioCol);
    }else{
      var newPrecioCol = parseFloat((precioactual-operation).toFixed(2));
      $(".cantidad"+id).removeAttr("readonly","0");
      $(".preciosid"+id).removeAttr("readonly","0");
      $("#precio_coleccion").val(newPrecioCol);
    }

  });
  $("#inicial").change(function(){
    var inicial = $(this).val();
    $("#primer_pago").attr("min",inicial);
  });
  $("#primer_pago").change(function(){
    var primer = $(this).val();
    $("#inicial").attr("max",primer);
    $("#segundo_pago").attr("min",primer);
  });
  $("#segundo_pago").change(function(){
    var segundo = $(this).val();
    $("#primer_pago").attr("max",segundo);
  });

  $(".cantidad_productos").change(function(){
    var cantidad = parseInt($(this).val());
    $(this).val(cantidad);
  });

});
function validar(){
  $(".btn-enviar").attr("disabled");
  var cantPagosMax = $("#cantPagosMax").val();


  /*===================================================================*/
  var limite_pedido = $("#limite_pedido").val();
  var rlimite_pedido = false;
  if(limite_pedido.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_limite_pedido").html("");
    rlimite_pedido = true;
  }else{
    rlimite_pedido = false;
    $("#error_limite_pedido").html("Debe seleccionar una fecha limite para el pedido");      
  }
  /*===================================================================*/
  var apertura_seleccion_plan = $("#apertura_seleccion_plan").val();
  var rapertura_seleccion_plan = false;
  if(apertura_seleccion_plan.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_apertura_seleccion_plan").html("");
    rapertura_seleccion_plan = true;
  }else{
    rapertura_seleccion_plan = false;
    $("#error_apertura_seleccion_plan").html("Debe seleccionar una fecha de apertura para seleccionar planes y premios");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var limite_seleccion_plan = $("#limite_seleccion_plan").val();
  var rlimite_seleccion_plan = false;
  if(limite_seleccion_plan.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_limite_seleccion_plan").html("");
    rlimite_seleccion_plan = true;
  }else{
    rlimite_seleccion_plan = false;
    $("#error_limite_seleccion_plan").html("Debe seleccionar una fecha limite para seleccionar planes y premios");      
  }
  /*===================================================================*/


  /*===================================================================*/
  var opInicial = $("#opInicial").val();
  if(opInicial=="Y"){
    var claveInicial = $(".json_inicial").html();
    var jsonInicial = JSON.parse(claveInicial);
    /*===================================================================*/
    var inicial = Array();
    var rinicialArr = Array();
    var rinicial = false;
    var errorInicial = 0;
    for (var i = 0 ; i < jsonInicial.length; i++) {
      var idAct = "inicial"+jsonInicial[i]['id'];
      var nameAct = jsonInicial[i]['name']=="" ? "" : " de "+jsonInicial[i]['name'];
      inicial[i] = $("#"+idAct).val();
      if(inicial[i].length != 0){
        $("#error_"+idAct).html("");
        rinicialArr[i] = true;
      }else{
        $("#error_"+idAct).html("Debe seleccionar una fecha de inicial"+nameAct);      
        rinicialArr[i] = false;
        errorInicial++;
      }
    }
    /*===================================================================*/
    rinicial = errorInicial==0 ? true : false;
  }else{
    rinicial = true;
  }
  /*===================================================================*/


  /*===================================================================*/  
  var cantPagos = $("#cantPagos").val();
  var rpagos = false;
  if(parseInt(cantPagos) > 0 && parseInt(cantPagos) <= parseInt(cantPagosMax)){
    var clavePagos = $(".json_pagos").html();
    var jsonPagos = JSON.parse(clavePagos);
    /*===================================================================*/
    var pagos = Array();
    var rpagosArr = Array();
    var errorPagos = 0;
    for (var i = 0 ; i < jsonPagos.length; i++) {
      var idActPagos = jsonPagos[i]['id'];
      var nameActPagos = jsonPagos[i]['name'].toLowerCase();
      var claveInicial = $(".json_inicial").html();
      var jsonInicial = JSON.parse(claveInicial);
      for (var j = 0 ; j < jsonInicial.length; j++) {
        var idAct = jsonInicial[j]['id'];
        var nameAct = jsonInicial[j]['name']=="" ? "" : " de "+jsonInicial[j]['name'];
        pagos[i] = $("#"+idActPagos+idAct).val();
        if(pagos[i].length != 0){
          $("#error_"+idActPagos+idAct).html("");
          rpagosArr[i] = true;
        }else{
          $("#error_"+idActPagos+idAct).html("Debe seleccionar una fecha de "+nameActPagos+nameAct);      
          rpagosArr[i] = false;
          errorPagos++;
        }   
      }
    }
    rpagos = errorPagos==0 ? true : false;
    /*===================================================================*/
  }
  /*===================================================================*/



  /*===================================================================*/
  var precio_coleccion = $("#precio_coleccion").val();
  var rprecio_coleccion = false;
  if(precio_coleccion.length != 0){
    if(precio_coleccion > 0){
      rprecio_coleccion = true;
      $("#error_precio_coleccion").html("");
    }else{
      rprecio_coleccion = false;
      $("#error_precio_coleccion").html("Debe seleccionar los productos necesarios para llenar la coleccion y tener un precio de la misma");
    }
  }else{
    rprecio_coleccion = false;
    $("#error_precio_coleccion").html("Debe seleccionar los productos necesarios para llenar la coleccion y tener un precio de la misma");
  }


  /*===================================================================*/
  if(opInicial=="Y"){
    /*===================================================================*/
    var precioInn = $("#precioInn").val();
    var rprecioInn = false;
    if(precioInn.length != 0){
      if(precioInn > 0){
        rprecioInn = true;
        $("#error_precioInn").html("");
      }else{
        rprecioInn = false;
        $("#error_precioInn").html("Debe llenar el precio de la inicial de la coleccion");
      }
    }else{
      rprecioInn = false;
      $("#error_precioInn").html("Debe llenar el precio de la inicial de la coleccion");
    }
    /*===================================================================*/
  }else{
    rprecioInn = true;
  }
  /*===================================================================*/

  /*===================================================================*/
  var rprecios = false;
  var totalidad = 0;
  var mensajePagos = "";
  var opOpt = $("#opOpt").val();
  if(opOpt=="N"){
    totalidad += parseFloat(precioInn);
    mensajePagos += "<b>Inicial, </b>";
  }

  if(parseInt(cantPagos) > 0 && parseInt(cantPagos) <= parseInt(cantPagosMax)){
    var clavePrecios = $(".json_pagos").html();
    var jsonPrecios = JSON.parse(clavePrecios);
    /*===================================================================*/
    var precios = Array();
    var rpreciosArr = Array();
    var erroresPrecios = 0;
    for (var i = 0 ; i < jsonPrecios.length; i++) {
      var idActPrecios = jsonPrecios[i]['id'];
      var nameActPrecios = jsonPrecios[i]['name'].toLowerCase();
      precios[i] = $("#precio_"+idActPrecios).val();
      totalidad += parseFloat(precios[i]);
      if(precios[i].length != 0){
        if(precios[i] > 0){
          rprecios[i] = true;
          $("#error_precio_"+idActPrecios).html("");
        }else{
          rprecios[i] = false;
          $("#error_precio_"+idActPrecios).html("Debe llenar el precio del "+nameActPrecios+" de la coleccion con un precio mayor a cero ( 0 )");
        }
      }else{
        $("#error_precio_"+idActPrecios).html("Debe llenar el precio del "+nameActPrecios+" de la coleccion");
        rprecios[i] = false;
        erroresPrecios++;
      }
      if(cantPagos>1){
        if(i == (parseInt(cantPagos)-1) ){
          mensajePagos += " y ";
        }
        mensajePagos += "<b>"+jsonPrecios[i]['name']+"</b>";
        if( i != (parseInt(cantPagos)-1) && i != (parseInt(cantPagos)-2)){
          mensajePagos += ", ";
        }
      }else{
        mensajePagos += "<b>"+jsonPrecios[i]['name']+"</b>";
      }
    }
    /*===================================================================*/
    rprecios = erroresPrecios==0 ? true : false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var comparativa = false;
  if(rprecios==true){
    // var totalidad = parseFloat(precio1) + parseFloat(precio2);
    if(totalidad == precio_coleccion){
      comparativa = true;
      $("#error_comparativa").html("");
    }else{
      comparativa = false;
      // $("#error_comparativa").html("La suma de <b>Primer pago</b> y <b>Segundo pago</b> no cumplen con el precio de la coleccion");
      if(cantPagos>1){
        $("#error_comparativa").html("La suma del "+mensajePagos+" no suman el precio total de la coleccion");
      }else{
        $("#error_comparativa").html("El precio del "+mensajePagos+" no es el precio total de la coleccion");
      }
    }
  }

  var precioContado = $("#precioContado").val();
  var rprecioContado = false;
  if(precioContado.length != 0){
    if(precioContado > 0){
      rprecioContado = true;
      $("#error_precioContado").html("");
    }else{
      rprecioContado = false;
      $("#error_precioContado").html("Debe llenar el precio de descuento de contado la colección");
    }
  }else{
    rprecioContado = false;
    $("#error_precioContado").html("Debe llenar el precio de descuento de contado la colección");
  }

  // alert(rinicial);
  // alert(rpagos);
  // alert(rprecioInn);
  // alert(rprecios);

  /*===================================================================*/
  var result = false;
  if( 
    rlimite_pedido==true && rapertura_seleccion_plan==true && rlimite_seleccion_plan==true && 
    rinicial==true && rpagos==true &&  rprecio_coleccion==true && 
    rprecioInn==true && rprecioContado==true && rprecios==true && comparativa==true
  ){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}

function validarCarga(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var inicial = $("#opcion_inicial").val();
  var rinicial = false;
  if(inicial.length != 0){
    $("#error_opcion_inicial").html("");
    rinicial = true;
  }else{
    $("#error_opcion_inicial").html("Debe seleccionar una opcion para la inicial");
    rinicial = false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var pagos = $("#cantidad_pagos").val();
  var rpagos = false;
  if(pagos > 0){
    $("#error_cantidad_pagos").html("");
    rpagos = true;
  }else{
    $("#error_cantidad_pagos").html("Debe seleccionar una fecha de primero pago");      
    rpagos = false;
  }
  /*===================================================================*/
  /*===================================================================*/
  var result = false;
  if( rinicial==true && rpagos==true){
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
