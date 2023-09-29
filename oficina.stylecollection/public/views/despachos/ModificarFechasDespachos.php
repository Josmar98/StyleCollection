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
              <h3 class="box-title">Editar <?php echo "Pedidos"; ?></h3>
              <br>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if ( empty($_GET['opInicial']) && empty($_GET['cantPagos']) ): ?>
              <form action="" method="get" role="form" class="form_register">
                <div class="box-body">
                    <input type="hidden" name="campaing" value="<?=$_GET['campaing']; ?>">
                    <input type="hidden" name="n" value="<?=$_GET['n']; ?>">
                    <input type="hidden" name="y" value="<?=$_GET['y']; ?>">
                    <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                    <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                    <input type="hidden" name="id" value="<?=$_GET['id']; ?>">

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="opcion_inicial">Inicial</label>
                          <select class="form-control select2" id="opcion_inicial" name="opInicial" style="width:100%;">
                            <option value=""></option>
                            <option value="Y" <?php if($despacho['opcion_inicial']=="Y"){ echo "selected='selected'"; } ?> >SI</option>
                            <option value="N" <?php if($despacho['opcion_inicial']=="N"){ echo "selected='selected'"; } ?> >NO</option>
                          </select>
                         <span id="error_opcion_inicial" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="cantidad_pagos">Cantida de Pagos</label>
                          <select class="form-control select2" id="cantidad_pagos" name="cantPagos" style="width:100%;">
                            <option value="0"></option>
                          <?php foreach ($cantidadPagosDespachos as $pagosd){ ?>
                            <option 
                              value="<?=$pagosd['cantidad']; ?>" 
                              <?php if($despacho['cantidad_pagos']==$pagosd['cantidad']){ echo "selected='selected'"; } ?> >
                                <?=$pagosd['cantidad']; ?> (<?=$pagosd['name']; ?>)
                            </option>
                          <?php } ?>
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
                  <a style="margin-left:5%" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Modificar&id=<?=$_GET['id']; ?>&opInicial=<?=$despacho['opcion_inicial']; ?>&cantPagos=<?=$despacho['cantidad_pagos']; ?>" class="btn btn-default">Cancelar</a>
                </div>
              </form>
            <?php 
              elseif ( !empty($_GET['opInicial']) && !empty($_GET['cantPagos']) ): 
                if($_GET['cantPagos']>0 && $_GET['cantPagos']<=count($cantidadPagosDespachos)): ?>
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" id="cantPagosMax" value="<?=count($cantidadPagosDespachos); ?>">

                    <div class="box-body">
                      <div class="row">
                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="numero_despacho">Numero de Despacho</label>
                           <input type="number" class="form-control" id="numero_despacho" name="numero_despacho" min="1" max="10" maxlength="2" placeholder="Ingresar numero de despacho" readonly="" value="<?php echo $despacho['numero_despacho'] ?>">
                           <span id="error_numero_despacho" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="limite_pedido">Fecha Limite de Pedido</label>
                            <input type="date" class="form-control" id="limite_pedido" name="limite_pedido" value="<?php echo $despacho['limite_pedido'] ?>">
                           <span id="error_limite_pedido" class="errors"></span>
                        </div>


                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="apertura_seleccion_plan">Fecha apertura para Seleccion de Plan</label>
                           <input type="date" class="form-control" id="apertura_seleccion_plan" name="apertura_seleccion_plan" value="<?php echo $despacho['apertura_seleccion_plan'] ?>">
                           <span id="error_apertura_seleccion_plan" class="errors"></span>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="limite_seleccion_plan">Fecha limite para Seleccion de Plan</label>
                           <input type="date" class="form-control" id="limite_seleccion_plan" name="limite_seleccion_plan" value="<?php echo $despacho['limite_seleccion_plan'] ?>">
                           <span id="error_limite_seleccion_plan" class="errors"></span>
                        </div>

                      </div>

                      <hr>
                      
                      <input type="hidden" id="opInicial" value="<?=$_GET['opInicial']; ?>">
                      <input type="hidden" id="cantPagos" value="<?=$_GET['cantPagos']; ?>">
                      <span class="d-none json_inicial"><?php echo json_encode($claveInicial); ?></span>
                      <span class="d-none json_pagos"><?php echo json_encode($cantidadPagosDespachosFild); ?></span>



                      <div class="row">

                        <?php if (!empty($_GET['opInicial']) && $_GET['opInicial']=="Y"){ foreach ($claveInicial as $cvInicial) { ?>
                          <div class="form-group col-xs-12 col-sm-6" style="margin-bottom:35px;">
                             <label for="inicial<?=$cvInicial['id']; ?>">Fecha de pago inicial <?=$cvInicial['name']; ?></label>
                             <input type="date" class="form-control" id="inicial<?=$cvInicial['id']; ?>" name="fechasInicial[inicial<?=$cvInicial['id']; ?>]"
                             <?php foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){ 
                                    $valInputtemp = $pagosD["fecha_pago_despacho".$cvInicial['id']];
                                    echo "value='{$valInputtemp}'";
                                } } } ?> >
                              <span id="error_inicial<?=$cvInicial['id']; ?>" class="errors" style="position:absolute;"></span>
                          </div>

                        <?php } } ?>

                        <?php  foreach ($cantidadPagosDespachosFild as $cvPagos){  foreach ($claveInicial as $cvInicial) { ?>
                          <div class="form-group col-xs-12 col-sm-6" style="margin-bottom:35px;">
                             <label for="<?=$cvPagos['id'].$cvInicial['id']; ?>">Fecha de <?=mb_strtolower($cvPagos['name']); ?> <?=$cvInicial['name']; ?></label>
                              <input type="date" class="form-control" id="<?=$cvPagos['id'].$cvInicial['id']; ?>" name="fechasPagos[<?=$cvPagos['id'].$cvInicial['id']; ?>]"
                                <?php foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagosD['tipo_pago_despacho']==$cvPagos['name']){ 
                                    $valInputtemp = $pagosD["fecha_pago_despacho".$cvInicial['id']];
                                    echo "value='{$valInputtemp}'";
                                } } } ?> >
                              <span id="error_<?=$cvPagos['id'].$cvInicial['id']; ?>" class="errors" style="position:absolute;"></span>
                          </div>
                        <?php } } ?>
                      </div>


                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                      
                      <span type="submit" class="btn enviar">Enviar</span>
                      <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <a style="margin-left:5%" href="?<?php echo $menu ?>&route=<?php echo $url ?>&" class="btn btn-default">Cancelar</a>

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
                            title: '¡No se ha encontrado el registro!',
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

  // $("body").hide(500);
  var precioInicial = $("#precio_coleccion").val();
  if(precioInicial.length == 0){
    $("#precio_coleccion").val("0");
  }
  $(".cheking").click(function(){
    var id = $(this).val();
    var precioactual = parseFloat($("#precio_coleccion").val());
    var cantidad = $(".cantidad"+id).val();
    var type = typeof(cantidad);
    if(type == "string"){
      if(cantidad.length == 0){
        $(".cantidad"+id).val(0);
        cantidad = $(".cantidad"+id).val();
      }
      if(cantidad.length > 0){
        cantidad = $(".cantidad"+id).val();
      }
    }
    var nvalor = $(".preciosid"+id).val();
    if(nvalor==""){
      var valor = parseFloat("0");
    }else{
      var valor = parseFloat($(".preciosid"+id).val());
    }
    var operation = parseFloat(cantidad) * valor;

    if($(this).prop('checked')){
      $(".cantidad"+id).attr("readonly","1");
      $(".preciosid"+id).attr("readonly","1");
      $("#precio_coleccion").val(precioactual+operation);
    }else{
      $(".cantidad"+id).removeAttr("readonly","0");
      $(".preciosid"+id).removeAttr("readonly","0");
      $("#precio_coleccion").val(precioactual-operation);
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
  $(".cantidad_productos").focusin(function(){
    var cantidad = $(this).val();
    var type = typeof(cantidad);
    if(type == "string"){
      if(cantidad.length==0){
        $(this).val(0);
      }
    }
  });
  //   var list = $(this).prop('classList');
  //   var cad1 = list[1];
  //   var cad2 = 8;
  //   var cad3 = cad1.length;
  //   var id_producto = cad1.substring(cad2, cad3);
  //   // $(".check"+id_producto).hide();
  //   $(".check"+id_producto).removeAttr("checked");
  //   if(cantidad.length == 0){
  //     $(this).val(0);
  //   }
  //   if(cantidad.length > 0){
  //     cantidad = $(this).val();
  //   }
  //   // $(".check"+id_producto).attr("disabled");


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
  var result = false;
  if(  rlimite_pedido==true && rapertura_seleccion_plan==true && rlimite_seleccion_plan==true &&  rinicial==true && rpagos==true ){
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
// function validar(){
//   $(".btn-enviar").attr("disabled");
//   /*===================================================================*/
//   var inicial = $("#inicial").val();
//   var rinicial = false;
//   if(inicial.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_inicial").html("");
//     rinicial = true;
//   }else{
//     rinicial = false;
//     $("#error_inicial").html("Debe seleccionar una fecha de inicial");      
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var primer_pago = $("#primer_pago").val();
//   var rprimer_pago = false;
//   if(primer_pago.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_primer_pago").html("");
//     rprimer_pago = true;
//   }else{
//     rprimer_pago = false;
//     $("#error_primer_pago").html("Debe seleccionar una fecha de primero pago");      
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var segundo_pago = $("#segundo_pago").val();
//   var rsegundo_pago = false;
//   if(segundo_pago.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_segundo_pago").html("");
//     rsegundo_pago = true;
//   }else{
//     rsegundo_pago = false;
//     $("#error_segundo_pago").html("Debe seleccionar una fecha de segundo pago");      
//   }
//   /*===================================================================*/

//       /*===================================================================*/
//   var limite_pedido = $("#limite_pedido").val();
//   var rlimite_pedido = false;
//   if(limite_pedido.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_limite_pedido").html("");
//     rlimite_pedido = true;
//   }else{
//     rlimite_pedido = false;
//     $("#error_limite_pedido").html("Debe seleccionar una fecha limite para el pedido");      
//   }
//   /*===================================================================*/


//     var inicial_senior = $("#inicial_senior").val();
//   var rinicial_senior = false;
//   if(inicial_senior.length != 0){
//     // $("#error_inicial_senior").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_inicial_senior").html("");
//     rinicial_senior = true;
//   }else{
//     rinicial_senior = false;
//     $("#error_inicial_senior").html("Debe seleccionar una fecha de inicial para el senior");      
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var primer_pago_senior = $("#primer_pago_senior").val();
//   var rprimer_pago_senior = false;
//   if(primer_pago_senior.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_primer_pago_senior").html("");
//     rprimer_pago_senior = true;
//   }else{
//     rprimer_pago_senior = false;
//     $("#error_primer_pago_senior").html("Debe seleccionar una fecha de primero pago para el senior");      
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var segundo_pago_senior = $("#segundo_pago_senior").val();
//   var rsegundo_pago_senior = false;
//   if(segundo_pago_senior.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_segundo_pago_senior").html("");
//     rsegundo_pago_senior = true;
//   }else{
//     rsegundo_pago_senior = false;
//     $("#error_segundo_pago_senior").html("Debe seleccionar una fecha de segundo pago para el senior");      
//   }

//   /*===================================================================*/
//   var apertura_seleccion_plan = $("#apertura_seleccion_plan").val();
//   var rapertura_seleccion_plan = false;
//   if(apertura_seleccion_plan.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_apertura_seleccion_plan").html("");
//     rapertura_seleccion_plan = true;
//   }else{
//     rapertura_seleccion_plan = false;
//     $("#error_apertura_seleccion_plan").html("Debe seleccionar una fecha de apertura para seleccionar planes y premios");      
//   }
//   /*===================================================================*/



//     /*===================================================================*/
//   var limite_seleccion_plan = $("#limite_seleccion_plan").val();
//   var rlimite_seleccion_plan = false;
//   if(limite_seleccion_plan.length != 0){
//     // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     $("#error_limite_seleccion_plan").html("");
//     rlimite_seleccion_plan = true;
//   }else{
//     rlimite_seleccion_plan = false;
//     $("#error_limite_seleccion_plan").html("Debe seleccionar una fecha limite para seleccionar planes y premios");      
//   }
//   /*===================================================================*/

  

//   /*===================================================================*/
//   var precio_coleccion = $("#precio_coleccion").val();
//   var rprecio_coleccion = false;
//   if(precio_coleccion.length != 0){
//     if(precio_coleccion > 0){
//       rprecio_coleccion = true;
//       $("#error_precio_coleccion").html("");
//     }else{
//       rprecio_coleccion = false;
//       $("#error_precio_coleccion").html("Debe seleccionar los productos necesarios para llenar la coleccion y tener un precio de la misma");
//     }
//   }else{
//     rprecio_coleccion = false;
//     $("#error_precio_coleccion").html("Debe seleccionar los productos necesarios para llenar la coleccion y tener un precio de la misma");
//   }
//   /*===================================================================*/
//   var precio1 = $("#precio1").val();
//   var rprecio1 = false;
//   if(precio1.length != 0){
//     if(precio1 > 0){
//       rprecio1 = true;
//       $("#error_precio1").html("");
//     }else{
//       rprecio1 = false;
//       $("#error_precio1").html("Debe llenar el precio del primer pago de la colección");
//     }
//   }else{
//     rprecio1 = false;
//     $("#error_precio1").html("Debe llenar el precio del primer pago de la colección");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var precio2 = $("#precio2").val();
//   var rprecio2 = false;
//   if(precio2.length != 0){
//     if(precio2 > 0){
//       rprecio2 = true;
//       $("#error_precio2").html("");
//     }else{
//       rprecio2 = false;
//       $("#error_precio2").html("Debe llenar el precio del segundo pago de la colección");
//     }
//   }else{
//     rprecio2 = false;
//     $("#error_precio2").html("Debe llenar el precio del segundo pago de la colección");
//   }

//   var precioInn = $("#precioInn").val();
//   var rprecioInn = false;
//   if(precioInn.length != 0){
//     if(precioInn > 0){
//       rprecioInn = true;
//       $("#error_precioInn").html("");
//     }else{
//       rprecioInn = false;
//       $("#error_precioInn").html("Debe llenar el precio de la inicial de la colección");
//     }
//   }else{
//     rprecioInn = false;
//     $("#error_precioInn").html("Debe llenar el precio de la inicial de la colección");
//   }


//   var precioContado = $("#precioContado").val();
//   var rprecioContado = false;
//   if(precioContado.length != 0){
//     if(precioContado > 0){
//       rprecioContado = true;
//       $("#error_precioContado").html("");
//     }else{
//       rprecioContado = false;
//       $("#error_precioContado").html("Debe llenar el precio de descuento de contado la colección");
//     }
//   }else{
//     rprecioContado = false;
//     $("#error_precioContado").html("Debe llenar el precio de descuento de contado la colección");
//   }

//   /*===================================================================*/
//   var comparativa = false;
//   if(rprecio1==true && rprecio2==true){
//     var totalidad = parseFloat(precio1) + parseFloat(precio2);
//     if(totalidad == precio_coleccion){
//       comparativa = true;
//       $("#error_comparativa").html("");
//     }else{
//       comparativa = false;
//       $("#error_comparativa").html("La suma del <b>Primer pago</b> y <b>Segundo pago</b> no cumplen con el precio de la colección");
//     }
//   }
//   // alert(precio_coleccion);
//   // alert(precio1);


//   /*===================================================================*/
//   var result = false;
//   if( rinicial==true && rinicial_senior==true && rprimer_pago==true && rprimer_pago_senior==true && rsegundo_pago==true && rsegundo_pago_senior==true && rapertura_seleccion_plan==true && rlimite_seleccion_plan==true && rprecio_coleccion==true && rprecioInn==true && rprecioContado==true && rprecio1==true && rprecio2==true && comparativa==true){
//     result = true;
//   }else{
//     result = false;
//   }
//   /*===================================================================*/
//   return result;
// }

</script>
</body>
</html>
