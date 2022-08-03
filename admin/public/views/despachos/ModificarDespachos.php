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
              <div style="width:100%;text-align:right;">

                <a href="?<?=$menu."&route=Despachos&action=ModificarFechas&id=".$id?>" style="border:0;background:none;color:#04a7c9">Editar Fechas de Pedido <span class="fa fa-wrench"></span></a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="numero_despacho">Numero de Despacho</label>
                       <input type="number" class="form-control" id="numero_despacho" name="numero_despacho" min="1" max="10" maxlength="2" placeholder="Ingresar numero de despacho" readonly="" value="<?php echo $despacho['numero_despacho'] ?>">
                       <span id="error_numero_despacho" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="inicial">Fecha de pago inicial</label>
                       <input type="date" class="form-control" id="inicial" name="inicial" value="<?php echo $despacho['fecha_inicial'] ?>" >
                       <span id="error_inicial" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="primer_pago">Fecha de 1er pago</label>
                        <input type="date" class="form-control" id="primer_pago" name="primer_pago" value="<?php echo $despacho['fecha_primera'] ?>" >
                       <span id="error_primer_pago" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="segundo_pago">Fecha de 2do pago</label>
                       <input type="date" class="form-control" id="segundo_pago" name="segundo_pago" value="<?php echo $despacho['fecha_segunda'] ?>" >
                       <span id="error_segundo_pago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="limite_pedido">Fecha Limite de Pedido</label>
                        <input type="date" class="form-control" id="limite_pedido" name="limite_pedido" value="<?php echo $despacho['limite_pedido'] ?>">
                       <span id="error_limite_pedido" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="limite_seleccion_plan">Fecha limite para Seleccion de Plan</label>
                       <input type="date" class="form-control" id="limite_seleccion_plan" name="limite_seleccion_plan" value="<?php echo $despacho['limite_seleccion_plan'] ?>">
                       <span id="error_limite_seleccion_plan" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="inicial_senior">Fecha de pago inicial Senior</label>
                       <input type="date" class="form-control" id="inicial_senior" name="inicial_senior"  value="<?php echo $despacho['fecha_inicial_senior'] ?>">
                       <span id="error_inicial_senior" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="primer_pago_senior">Fecha de 1er pago Senior</label>
                        <input type="date" class="form-control" id="primer_pago_senior" name="primer_pago_senior"  value="<?php echo $despacho['fecha_primera_senior'] ?>">
                       <span id="error_primer_pago_senior" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="segundo_pago_senior">Fecha de 2do pago Senior</label>
                       <input type="date" class="form-control" id="segundo_pago_senior" name="segundo_pago_senior"  value="<?php echo $despacho['fecha_segunda_senior'] ?>">
                       <span id="error_segundo_pago_senior" class="errors"></span>
                    </div>
                    
                  </div>
                  
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-12">
                        <b><i><span style="color:red">(Importante) Nota:</span> Debe marcar las casillas de cada producto que desee agregar a la coleccion, una vez alla seleccionado la cantidad de productos para construir la misma. De lo contrario podria no calcularse el monto correcto.</i></b><br><br>
                        <table id="datatablee" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                          <thead>
                          <tr>
                            <th>Nº</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>---</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $num = 1;
                          foreach ($productos as $data):
                          if(!empty($data['id_producto'])):  
                          ?>
                          <tr>
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
                              <!-- <input type="number" min="0" class="preciosid<?php echo $data['id_producto'] ?>" name="precios[]" value="<?php echo $data['precio_producto'] ?>"> -->
                              <input type="number" step="0.10" min="0" name="precios[]" value="<?php echo $data['precio_producto'] ?>" class="precio_productos preciosid<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px">
                              <input type="hidden" name="precioid[]" value="<?php echo $data['id_producto'] ?>">
<!--                               <span class="contenido2">
                                <?php echo "$".$data['precio_producto']; ?>
                              </span> -->
                            </td>
                            <td style="width:20%">
                              <input type="number" min="0" name="cantidad_productos[]" class="cantidad_productos cantidad<?php echo $data['id_producto'] ?> form-control" style="width:50%;padding:0px 5px" <?php foreach ($colecciones as $key){ if(!empty($key['id_coleccion'])){ if($data['id_producto'] == $key['id_producto']){ ?> value="<?php echo $key['cantidad_productos'] ?>" readonly="" <?php }else{ ?>  <?php }}} ?> >
                              <input type="hidden" name="elementosid[]" value="<?php echo $data['id_producto'] ?>">
                            </td>
                            <td style="width:10%">
                              <input type="checkbox" class="cheking check<?php echo $data['id_producto'] ?>" value="<?php echo $data['id_producto'] ?>" name="cheking[]" <?php foreach ($colecciones as $key){if(!empty($key['id_coleccion'])){if($data['id_producto'] == $key['id_producto']){ echo "checked=''"; }}} ?>>

                            </td>
                          </tr>
                          <?php
                         endif; endforeach;
                          ?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <th>Nº</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>---</th>
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="form-group col-sm-4">
                       <label for="precio_coleccion">Precio de coleccion</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="text" class="form-control" min="0" id="precio_coleccion" value="<?php echo $despacho['precio_coleccion']; ?>" name="precio_coleccion" maxlength="30" placeholder="Precio de la coleccion" readonly="">
                       </div>
                       <span id="error_precio_coleccion" class="errors"></span>
                    </div>
                    

                    <div class="form-group col-sm-4">
                       <label for="precio1">Primer Pago de coleccion</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="number" step="0.1" class="form-control" min="0" id="precio1" value="<?php echo $despacho['primer_precio_coleccion']; ?>" name="precio1" maxlength="30" placeholder="Precio de la coleccion">
                       </div>
                       <span id="error_precio1" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-4">
                       <label for="precio2">Segundo Pago de coleccion</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="number" step="0.1" class="form-control" min="0" id="precio2" value="<?php echo $despacho['segundo_precio_coleccion']; ?>" name="precio2" maxlength="30" placeholder="Precio de la coleccion">
                       </div>
                       <span id="error_precio2" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-4">
                       <label for="precioInn">Precio Inicial de coleccion</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="number" step="0.1" class="form-control" min="0" id="precioInn" value="<?php echo $despacho['inicial_precio_coleccion']; ?>" name="precioInn" maxlength="30" placeholder="Precio de la coleccion">
                       </div>
                       <span id="error_precioInn" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-4">
                       <label for="precioInn">Descuento de Contado de coleccion</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="number" step="0.1" class="form-control" min="0" id="precioContado" value="<?php echo $despacho['contado_precio_coleccion']; ?>" name="precioContado" maxlength="30" placeholder="Precio de la coleccion">
                       </div>
                       <span id="error_precioContado" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-4">
                      <span id="error_comparativa"  class="errors"></span>
                    </div>
                      
                    
                  </div>
                 
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <a style="margin-left:5%" href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>

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
    var valor = parseFloat($(".preciosid"+id).val());
    var operation = parseFloat(cantidad) * valor;

    if($(this).prop('checked')){
      $(".cantidad"+id).attr("readonly","1");
      $("#precio_coleccion").val(precioactual+operation);
    }else{
      $(".cantidad"+id).removeAttr("readonly","0");
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
  /*===================================================================*/
  var inicial = $("#inicial").val();
  var rinicial = false;
  if(inicial.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_inicial").html("");
    rinicial = true;
  }else{
    rinicial = false;
    $("#error_inicial").html("Debe seleccionar una fecha de inicial");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var primer_pago = $("#primer_pago").val();
  var rprimer_pago = false;
  if(primer_pago.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_primer_pago").html("");
    rprimer_pago = true;
  }else{
    rprimer_pago = false;
    $("#error_primer_pago").html("Debe seleccionar una fecha de primero pago");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var segundo_pago = $("#segundo_pago").val();
  var rsegundo_pago = false;
  if(segundo_pago.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_segundo_pago").html("");
    rsegundo_pago = true;
  }else{
    rsegundo_pago = false;
    $("#error_segundo_pago").html("Debe seleccionar una fecha de segundo pago");      
  }
  /*===================================================================*/

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


    var inicial_senior = $("#inicial_senior").val();
  var rinicial_senior = false;
  if(inicial_senior.length != 0){
    // $("#error_inicial_senior").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_inicial_senior").html("");
    rinicial_senior = true;
  }else{
    rinicial_senior = false;
    $("#error_inicial_senior").html("Debe seleccionar una fecha de inicial para el senior");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var primer_pago_senior = $("#primer_pago_senior").val();
  var rprimer_pago_senior = false;
  if(primer_pago_senior.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_primer_pago_senior").html("");
    rprimer_pago_senior = true;
  }else{
    rprimer_pago_senior = false;
    $("#error_primer_pago_senior").html("Debe seleccionar una fecha de primero pago para el senior");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var segundo_pago_senior = $("#segundo_pago_senior").val();
  var rsegundo_pago_senior = false;
  if(segundo_pago_senior.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_segundo_pago_senior").html("");
    rsegundo_pago_senior = true;
  }else{
    rsegundo_pago_senior = false;
    $("#error_segundo_pago_senior").html("Debe seleccionar una fecha de segundo pago para el senior");      
  }



    /*===================================================================*/
  var limite_seleccion_plan = $("#limite_seleccion_plan").val();
  var rlimite_seleccion_plan = false;
  if(limite_seleccion_plan.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_limite_seleccion_plan").html("");
    rlimite_seleccion_plan = true;
  }else{
    rlimite_seleccion_plan = false;
    $("#error_limite_seleccion_plan").html("Debe seleccionar una fecha limite para seleccionar plan de las colecciones");      
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
  var precio1 = $("#precio1").val();
  var rprecio1 = false;
  if(precio1.length != 0){
    if(precio1 > 0){
      rprecio1 = true;
      $("#error_precio1").html("");
    }else{
      rprecio1 = false;
      $("#error_precio1").html("Debe llenar el precio del primer pago de la colección");
    }
  }else{
    rprecio1 = false;
    $("#error_precio1").html("Debe llenar el precio del primer pago de la colección");
  }
  /*===================================================================*/

  /*===================================================================*/
  var precio2 = $("#precio2").val();
  var rprecio2 = false;
  if(precio2.length != 0){
    if(precio2 > 0){
      rprecio2 = true;
      $("#error_precio2").html("");
    }else{
      rprecio2 = false;
      $("#error_precio2").html("Debe llenar el precio del segundo pago de la colección");
    }
  }else{
    rprecio2 = false;
    $("#error_precio2").html("Debe llenar el precio del segundo pago de la colección");
  }

  var precioInn = $("#precioInn").val();
  var rprecioInn = false;
  if(precioInn.length != 0){
    if(precioInn > 0){
      rprecioInn = true;
      $("#error_precioInn").html("");
    }else{
      rprecioInn = false;
      $("#error_precioInn").html("Debe llenar el precio de la inicial de la colección");
    }
  }else{
    rprecioInn = false;
    $("#error_precioInn").html("Debe llenar el precio de la inicial de la colección");
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

  /*===================================================================*/
  var comparativa = false;
  if(rprecio1==true && rprecio2==true){
    var totalidad = parseFloat(precio1) + parseFloat(precio2);
    if(totalidad == precio_coleccion){
      comparativa = true;
      $("#error_comparativa").html("");
    }else{
      comparativa = false;
      $("#error_comparativa").html("La suma del <b>Primer pago</b> y <b>Segundo pago</b> no cumplen con el precio de la colección");
    }
  }
  // alert(precio_coleccion);
  // alert(precio1);


  /*===================================================================*/
  var result = false;
  if( rinicial==true && rinicial_senior==true && rprimer_pago==true && rprimer_pago_senior==true && rsegundo_pago==true && rsegundo_pago_senior==true && rprecio_coleccion==true && rprecioInn==true && rprecioContado==true && rprecio1==true && rprecio2==true && comparativa==true){
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
