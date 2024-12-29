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
        <?php echo "".$modulo; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing2"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing2"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">



        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar <?php echo "".$modulo; ?></h3>
            </div>

                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" id="cantPagosMax" value="<?=count($cantidadPagosDespachos); ?>">
                    <input type="hidden" id="opInicial" value="<?=$opInicial; ?>">
                    <input type="hidden" id="cantPagos" value="<?=$cantPagos; ?>">
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
                          <div class="form-group col-xs-12">
                            <label for="nombre_coleccion">Nombre de Coleccion</label>
                            <input type="text" class="form-control" id="nombre_coleccion" name="nombre_coleccion" value="<?=$despachoSec['nombre_coleccion_sec'] ?>">
                            <span id="error_nombre_coleccion" class="errors"></span>
                          </div>

                          
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
                        <div class="row" style="max-height:80vh;overflow:auto;border:1px solid #CCC;width:100%;margin-left:0%;margin-right:0%;">
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
                                  foreach ($productos as $data){
                                    if(!empty($data['id_producto'])){
                                      $valuePrecio = 0;
                                      $valueCantidad = 0;
                                      $valueIdProduct = false;
                                        foreach ($coleccionesSec as $key){
                                          if(!empty($key['id_despacho_sec'])){
                                            if($data['id_producto']==$key['id_producto']){
                                              $valuePrecio=$key['precio_producto'];       
                                              $valueCantidad=$key['cantidad_productos'];       
                                              $valueIdProduct = true;
                                            }
                                          }
                                        }
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
                                    
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['cantidad']; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <input type="number" step="0.10" min="0" name="precios[]" value="<?=$valuePrecio; ?>" class="precio_productos preciosid<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px" <?php if($valueIdProduct){ echo "readonly"; } ?>>
                                      <input type="hidden" name="precioid[]" value="<?php echo $data['id_producto'] ?>">
                                    </td>
                                    <td style="width:20%">
                                      <input type="number" min="0" name="cantidad_productos[]" value="<?=$valueCantidad; ?>" class="cantidad_productos cantidad<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px"  <?php if($valueIdProduct){ echo "readonly"; } ?>>
                                      <input type="hidden" name="elementosid[]" value="<?php echo $data['id_producto'] ?>">
                                    </td>
                                    <td style="width:10%">
                                      <input type="checkbox" class="cheking check<?php echo $data['id_producto'] ?>" value="<?php echo $data['id_producto'] ?>" name="cheking[]" <?php if($valueIdProduct){ echo "checked"; } ?> >
                                      <!-- <input type="" class="preciosid<?php echo $data['id_producto'] ?>" name="precios[]" value="<?php echo $data['precio'] ?>"> -->
                                    </td>
                                  </tr>
                                    <?php
                                    }
                                  }
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
                              <input type="text" class="form-control" min="0" id="precio_coleccion" name="precio_coleccion" maxlength="30" placeholder="Precio de la coleccion" value="<?=$despachoSec['precio_coleccion_sec']; ?>" readonly="">
                             </div>
                             <span id="error_precio_coleccion" class="errors"></span>
                          </div>

                        </div>

                        <div class="row">
                          <?php foreach ($cantidadPagosDespachosFild as $cvPagos) { ?>
                            <?php
                              $precioPagoSec = "";
                              foreach ($despachosSecPagos as $key) { if(!empty($key['id_despacho_sec'])){
                                if($cvPagos['name']==$key['tipo_pago_despacho_sec']){
                                  $precioPagoSec = $key['pago_precio_coleccion_sec'];
                                }
                              } }
                            ?>
                            <div class="form-group col-sm-6">
                              <label for="precio_<?=$cvPagos['id']; ?>"><?=$cvPagos['name']; ?> de coleccion</label>
                              <div class="input-group">
                                <span class="input-group-addon">$</span> 
                                <input type="number" step="0.1" class="form-control" min="0" id="precio_<?=$cvPagos['id']; ?>" name="preciosPagos[precio_<?=$cvPagos['id']; ?>]" maxlength="30" placeholder="Precio de <?=mb_strtolower($cvPagos['name']); ?> la coleccion" value="<?=$precioPagoSec; ?>">
                              </div>
                              <span id="error_precio_<?=$cvPagos['id']; ?>" class="errors"></span>
                            </div>
                          <?php } ?>

                          <div class="form-group col-xs-12" style="text-align:center;">
                            <span id="error_comparativa"  class="errors"></span>
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
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Colecciones";
        window.location.href=menu;
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
                      nombre_coleccion: $("#nombre_coleccion").val(),
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
  var nombre_coleccion = $("#nombre_coleccion").val();
  var rnombre_coleccion = false;
  if(nombre_coleccion.length != 0){
    rnombre_coleccion = true;
    $("#error_nombre_coleccion").html("");
  }else{
    rnombre_coleccion = false;
    $("#error_nombre_coleccion").html("Debe asignar un nombre a la coleccion");      
  }

  var cantPagos = $("#cantPagos").val();
 
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
  // alert(false);
  // alert(rprecios);
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


  /*===================================================================*/
  var result = false;
  if( 
    rnombre_coleccion==true && rprecio_coleccion==true && rprecios==true && comparativa==true
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
  // var inicial = $("#opcion_inicial").val();
  // var rinicial = false;
  // if(inicial.length != 0){
  //   $("#error_opcion_inicial").html("");
  //   rinicial = true;
  // }else{
  //   $("#error_opcion_inicial").html("Debe seleccionar una opcion para la inicial");
  //   rinicial = false;
  // }
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
