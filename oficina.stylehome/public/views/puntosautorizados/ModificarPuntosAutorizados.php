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
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="lider">Nombre de Liderazgo</label>
                       <select class="form-control select2" id="lider" name="lider">
                          <option value="<?php echo $punto['id_pedido']; ?>"><?=$punto['primer_nombre']." ".$punto['primer_apellido']." (".$punto['cedula'].")"; ?></option>
                       </select>
                       <span id="error_lider" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="cantidad">Cantidad de puntos</label>
                      <input type="number" min="1" step="1" value="<?=$punto['cantidad_puntos']; ?>" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad cantidad de colecciones">
                      <!-- <input type="hidden" name="max_anterior" id="maxima_anterior"> -->
                      <span id="error_cantidad" class="errors"></span>
                    </div>
                  </div>
               
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="descripcion">Descripcion</label>
                      <textarea class="form-control" maxlength="250" id="descripcion" name="descripcion" style="min-width:100%;max-width:100%;min-height:60px;max-height:110px;"><?=$punto['concepto']; ?></textarea>
                      <span id="error_descripcion" class="errors"></span>
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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        // var c = $(".c").val();
        // var n = $(".n").val();
        // var y = $(".y").val();

        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>";
        window.location = menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      });
    }
    
  }

  // $("#descuento_coleccion").change(function(){
  //   var descuento = parseFloat($(this).val());
  //   if($(".cant").val()>0){
  //     var max = parseFloat($(".max_total_descuento").val());
  //     var total = (max+descuento).toFixed(2);
  //   }else{
  //     var total = (descuento).toFixed(2);
  //   }
  //   $("#total_descuento").val(total);
  //   $(this).val((descuento).toFixed(2));
  // });

  // $("#descuento_coleccion").keyup(function(){
  //   var descuento = parseFloat($(this).val());
  //   if($(".cant").val()>1){
  //     var max = parseFloat($(".max_total_descuento").val());
  //     var total = (max+descuento).toFixed(2);
  //   }else{
  //     var total = (descuento).toFixed(2);
  //   }
  //   $("#total_descuento").val(total);
  //   $(this).val((descuento).toFixed(2));
  // });

  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");

       swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){      
              // var campaing = $(".campaing").val();
              // var n = $(".n").val();
              // var y = $(".y").val();
              // var dpid = $(".dpid").val();
              // var dp = $(".dp").val();
              // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=LiderazgosCamp";
                    // url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=LiderazgosCamp&action=Registrar',
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         lider: $("#lider").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Los datos ingresados estan repetidos!',
              //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              //           });
              //         }
              //       }
              //   });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });



    
    }
  });




});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var lider = $("#lider").val();
  var rlider = false;
  // var rlider = checkInput(lider, textPattern);
    if( lider.length  != 0 ){
      $("#error_lider").html("");
      rlider = true;
    }else{
      rlider = false;
      $("#error_lider").html("Debe seleccionar al líder");
    }
  /*===================================================================*/

  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern);
  if(rcantidad==false){
    $("#error_cantidad").html("Debe colocar la cantidad de puntos");    
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var descripcion = $("#descripcion").val();
  var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  if(rdescripcion==false){
    $("#error_descripcion").html("Debe colocar la descripcion de puntos");    
  }else{
    $("#error_descripcion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rlider==true && rcantidad==true && rdescripcion==true){
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
