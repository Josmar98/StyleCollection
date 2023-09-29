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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Accesos de Usuarios</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">

                  <div class="row">
                    <div class="col-sm-12">
                        <b><i><span style="color:red">(Importante) Nota:</span> Deben estar marcadas las casillas de todos los usuarios que desee mantener con acceso a la oficina virtual. En caso de querer inhabilitar el acceso a alguno de los usuarios, solo debe desmarcar la casilla y guardar los cambios.</i></b><br><br>
                        <table id="datatablee" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                          <thead>
                          <tr style="text-align:left;">
                            <td colspan="3">
                              <?php 
                                $xdxd = [];
                                $h=0;
                                foreach ($clientes as $data){
                                  if(!empty($data['id_cliente'])){
                                    if(!empty($accesosUsuarios[$h])){
                                      $accLider = $accesosUsuarios[$h];
                                      $permisoAccesoLider = $accLider['permiso_accesos'];
                                      if($permisoAccesoLider=="on"){
                                        $xdxd[$h] = "0";
                                      }
                                      if($permisoAccesoLider=="off"){
                                        $xdxd[$h] = "1";
                                      }
                                    }
                                    $h++;
                                  }
                                }
                                $allOpt = 0;
                                foreach ($xdxd as $key) {
                                  $allOpt += $key;
                                }
                                // echo $allOpt;

                              ?>
                              <label for="all">Seleccionar Todos</label>
                              <!-- <br> -->
                              <input type="checkbox" name="all" id="all" <?php if($allOpt==0){echo "checked='1'";} ?>>
                            </td>
                          </tr>
                          <tr>
                            <th>Nº</th>
                            <th>Lider</th>
                            <th>---</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $num = 1;
                          $x = 0;
                          foreach ($clientes as $data):
                          if(!empty($data['id_cliente'])):  
                          ?>
                          <?php 
                          foreach ($accesosUsuarios as $accLider){
                            if(!empty($accLider['id_cliente'])){
                              if($accLider['id_cliente']==$data['id_cliente']){
                                $permisoAccesoLider = $accLider['permiso_accesos'];
                                if($permisoAccesoLider=="on"){
                                  echo "<tr style='background:#00ff001c'>";
                                }else{
                                  echo "<tr style='background:#ff00001c'>";
                                }

                              }
                            }
                          } ?>
                          <!-- <tr> -->
                            <td style="width:5%">
                              <span class="contenido2">
                                <?php echo $num++; ?>
                              </span>
                            </td>
                            <td style="width:20%">
                              <span class="contenido2">
                                <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                              </span>
                            </td>
                            
                            <td style="width:10%">
                              <input type="checkbox" class="cheking check<?php echo $data['id_cliente'] ?>" name="accesos[]" cheked='cheked' value="<?php echo $data['id_cliente'] ?>" <?php foreach ($accesosUsuarios as $accLider){if(!empty($accLider['id_cliente'])){if($accLider['id_cliente']==$data['id_cliente']){$permisoAccesoLider = $accLider['permiso_accesos'];if($permisoAccesoLider=="on"){echo "checked='1'";}}}}?>>


                              <input type="hidden" class="clienteid<?php echo $data['cliente'] ?>" name="clientes[]" value="<?php echo $data['id_cliente'] ?>">


                              <input type="hidden" name="accLider[]" class="accliderAll acclider<?=$data['id_cliente']?>"<?php 
                              foreach ($accesosUsuarios as $accLider){if(!empty($accLider['id_cliente'])){if($accLider['id_cliente']==$data['id_cliente']){$permisoAccesoLider = $accLider['permiso_accesos'];echo "value='".$permisoAccesoLider."'";}}else{echo "value='off'";}}?> ><!-- CIERRE DEL INPUT  -->


                            </td>
                          </tr>
                          <?php
                          $x++;
                         endif; endforeach;
                          ?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <th>Nº</th>
                            <th>Lider</th>
                            <th>---</th>
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                  
               
             

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Guardar</span>
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
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
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
        window.location = "?route=Usuarios&action=Accesos";
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
  $(".cheking").click(function(){
    var id = $(this).val();
    if($(this).prop('checked')){
      $(".acclider"+id).val("on");
      // $(this).val("on");
    }else{
      $(".acclider"+id).val("off");
      // $(this).val("Off");      
    }
  });
  $("#all").click(function(){
    if($(this).prop('checked')){
      $(".cheking").attr("checked","1");
      // $(".cheking").attr("value","on");
      
      $(".accliderAll").val("on");
    }else{
      $(".cheking").removeAttr("checked","0");
      // $(".cheking").attr("value","off");
      $(".accliderAll").val("off");
    }
  });
    
  $(".enviar").click(function(){
    // var response = validar();
    var response = true;

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
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         numero_despacho: $("#numero_despacho").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Los datos ingresados estan repetidos!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //       }
              //   });
              
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
  // var precioInicial = $("#precio_coleccion").val();
  // if(precioInicial.length == 0){
  //   $("#precio_coleccion").val("0");
  // }
  // $(".cheking").click(function(){

  //   var id = $(this).val();
  //   var precioactual = parseFloat($("#precio_coleccion").val());
  //   var cantidad = $(".cantidad"+id).val();
  //   if(cantidad.length == 0){
  //     $(".cantidad"+id).val(0);
  //   }
  //   if(cantidad.length > 0){
  //     cantidad = $(".cantidad"+id).val();
  //   }

  //   var valor = parseFloat($(".preciosid"+id).val());
  //   var operation = parseFloat(cantidad) * valor;

  //   if($(this).prop('checked')){
  //     $(".cantidad"+id).attr("readonly","1");
  //     $(".preciosid"+id).attr("readonly","1");
  //     $("#precio_coleccion").val(precioactual+operation);
  //   }else{
  //     $(".cantidad"+id).removeAttr("readonly","0");
  //     $(".preciosid"+id).removeAttr("readonly","0");
  //     $("#precio_coleccion").val(precioactual-operation);
  //   }

  // });
  // $("#inicial").change(function(){
  //   var inicial = $(this).val();
  //   $("#primer_pago").attr("min",inicial);
  // });
  // $("#primer_pago").change(function(){
  //   var primer = $(this).val();
  //   $("#inicial").attr("max",primer);
  //   $("#segundo_pago").attr("min",primer);
  // });
  // $("#segundo_pago").change(function(){
  //   var segundo = $(this).val();
  //   $("#primer_pago").attr("max",segundo);
  // });



  // $(".cantidad_productos").change(function(){
  //   var cantidad = parseInt($(this).val());
  //   $(this).val(cantidad);
  // });
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
      $("#error_precio1").html("Debe llenar el precio del primer pago de la coleccion");
    }
  }else{
    rprecio1 = false;
    $("#error_precio1").html("Debe llenar el precio del primer pago de la coleccion");
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
      $("#error_precio2").html("Debe llenar el precio del segundo pago de la coleccion");
    }
  }else{
    rprecio2 = false;
    $("#error_precio2").html("Debe llenar el precio del segundo pago de la coleccion");
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
      $("#error_comparativa").html("La suma del <b>Primer pago</b> y <b>Segundo pago</b> no cumplen con el precio de la coleccion");
    }
  }
  // alert(precio_coleccion);
  // alert(precio1);


  /*===================================================================*/
  var result = false;
  if( rinicial==true && rprimer_pago==true && rsegundo_pago==true && rprecio_coleccion==true && rprecio1==true && rprecio2==true && comparativa==true){
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
