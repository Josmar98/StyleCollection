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
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3 ?>route=<?php echo "Homing2" ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <?php  if(!empty($_GET['admin'])){ ?> 
                <h3 class="box-title">Eliminar Pedido aprobado</h3><br>
                <small>Pedido de <?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido'] ?>
                  <?=$pedido['cantidad_pedido']?> Colecciones Solicitadas
                </small>
              <?php  }else{ ?>
                <h3 class="box-title">Eliminar solicitud de Pedido</h3>              
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <?php $vecesVal = 4; ?>
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                 <?php if($pedido['cantidad_aprobado']==0){ 
                    $numMax = $pedido['cantidad_pedido']*$vecesVal;
                  ?>
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="cantidad">Cantidad de Colecciones</label>
                      <input type="hidden" class="maxOculto" value="<?php echo $numMax; ?>">
                      <input type="number" class="form-control" step="1" id="cantidad" value="0" name="cantidad" placeholder="Ingresar cantidad de colecciones para el despacho" readonly="">
                      <span id="error_cantidad" class="errors"></span>
                    </div>
                
                  </div>
              <?php }
                    if($pedido['cantidad_aprobado']>0){ 
                        $numMax = $pedido['cantidad_pedido']*$vecesVal;
                      ?>
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <input type="hidden" class="maxOculto" value="<?php echo $numMax; ?>">
                      <label for="cantidad">Cantidad de Colecciones</label>
                      <input type="number" class="form-control" step="1" id="cantidad" value="0" name="cantidad" maxlength="30" placeholder="Ingresar cantidad de colecciones para el despacho" readonly="">
                      <span id="error_cantidad" class="errors"></span>
                    </div>
                
                  </div>
              <?php } ?>
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

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
          <?php $liderazgo = []; 
        foreach ($liderazgos as $l){
          if(!empty($l['nombre_liderazgo'])){
            if($l['nombre_liderazgo']=='SENIOR'){
              $liderazgo = $l; 
            }
          }
        } ?>
        <?php 
          $despachoMinimaCantidad = 0;
          if(!empty($despachos[0]['cantidad_minima_pedido'])){
            $despachoMinimaCantidad = $despachos[0]['cantidad_minima_pedido'];
          }
        ?>
        <?php if ($despachoMinimaCantidad > 0): ?>
        <input type="hidden" id="cantidad_minima" value="<?=$despachoMinimaCantidad; ?>">
        <?php else: ?>
        <input type="hidden" id="cantidad_minima" value="<?=$liderazgo['minima_cantidad']; ?>">
        <?php endif; ?>
        <input type="hidden" id="pedido" value="<?=$pedido['cantidad_pedido']; ?>">
        
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
          title: '¡Pedido Eliminado correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Homing2";
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

  // $("#cantidad").change(function(){
  //   var minima = parseInt($("#cantidad_minima").val());
  //   var x = parseInt($(this).val());
  //   if(x<minima){
  //     $(this).val(minima);
  //   }
  //   var pedido = parseInt($("#pedido").val());
  //   if(x>=(pedido*<?php echo $vecesVal; ?>)){      
  //     $("#error_cantidad").html("Debe seleccionar maximo "+max+" colecciones");
  //     $(this).val(pedido*<?php echo $vecesVal; ?>);
  //   }
  // });
  // $("#cantidad").change(function(){
  //   var minima = parseInt($("#cantidad_minima").val());
  //   var x = parseInt($(this).val());
  //   if(x<minima){
  //     $(this).val(minima);
  //   }else{
  //     $(this).val(x);
  //   }

  //   // var pedido = parseInt($("#pedido").val());
  //   // if(x>=(pedido*<?php echo $vecesVal; ?>)){      
  //   //   $(this).val(pedido*<?php echo $vecesVal; ?>);
  //   // }
  // });
  // $("#cantidad").focusout(function(){
  //   var minima = parseInt($("#cantidad_minima").val());
  //   var x = parseInt($(this).val());
  //   if(x<minima){
  //     $(this).val(minima);
  //   }else{
  //     $(this).val(x);
  //   }
  //   // var pedido = parseInt($("#pedido").val());
  //   // if(x>=(pedido*<?php echo $vecesVal; ?>)){    
  //   //   $(this).val(pedido*<?php echo $vecesVal; ?>);
  //   // }

  // });
    
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      nombre: $("#nombre").val(),
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
                            title: '¡No se ha encontrado pedido!',
                            text: '¡Error al encontrar el pedido para poder editar!',
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


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var max = parseInt($(".maxOculto").val());
  var rcantidad = checkInput(cantidad, numberPattern);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad de colecciones");
    }
  }else{
    if(cantidad <= max){
      $("#error_cantidad").html("");
      rcantidad = true;
    }else{
      $("#error_cantidad").html("Debe seleccionar maximo "+max+" colecciones");
      rcantidad = false;
    }
  }
  /*===================================================================*/

  /*===================================================================*/
  // var descripcion = $("#descripcion").val();
  // var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  // if( rdescripcion == false ){
  //   if(descripcion.length != 0){
  //     $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
  //   }else{
  //     $("#error_descripcion").html("Debe llenar la descripcion del permiso");      
  //   }
  // }else{
  //   $("#error_descripcion").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;

  if( rcantidad==true){
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
