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
              <h3 class="box-title">Agregar Nuevos <?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="lider">Nombre de Liderazgo</label>
                       <select class="form-control select2" id="lider" name="lider">
                          <option value=""></option>
                          <?php foreach ($lideres as $data){ if (!empty($data['id_cliente'])){ ?>
                            <option value="<?php echo $data['id_pedido']; ?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." (".$data['cedula'].")"; ?></option>
                          <?php } } ?>
                       </select>
                       <span id="error_lider" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="concepto">Tipos de puntos</label>
                       <select class="form-control select2" id="concepto" name="concepto">
                          <option value=""></option>
                          <option value="2">Por</option>
                       </select>
                       <span id="error_concepto" class="errors"></span>
                    </div>
                  </div>
               
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="minima">Precio de factura desde</label>
                      <input type="number" min="1" step="1" class="form-control" id="minima" name="minima" placeholder="Cantidad minima de colecciones">
                      <!-- <input type="hidden" name="max_anterior" id="maxima_anterior"> -->
                      <span id="error_minima" class="errors"></span>
                    </div>
                    <div class="form-group  col-sm-6">
                      <label for="maxima">Precio de factura hasta   <i><small style="color:#0B0">  Cantidad <b>0</b> se tomara como valor indefinido</small></i></label>
                      <input type="number" min="0" step="1" class="form-control" id="maxima" name="maxima" placeholder="Cantidad maxima de colecciones">
                      <span id="error_maximo" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="descuento_coleccion">Porcentaje de Descuento por Factura</label>
                        <div class="input-group">
                            <input type="number" min="1" step="1" max="100" class="form-control" id="descuento_coleccion" name="descuento_coleccion" placeholder="Descuento de cada coleccion">
                            <span class="input-group-addon">%</span>
                        </div>
                        <span id="error_descuento_coleccion" class="errors"></span>
                          
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="total_descuento">Descuento total</label>
                        <div class="input-group">
                          <input type="number" min="1" step="1" class="form-control" id="total_descuento" name="total_descuento" placeholder="Descuento acumulado de cada coleccion" readonly="">
                          <span class="input-group-addon">%</span>
                        </div>
                        <span id="error_total_descuento" class="errors"></span>

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
<!-- <input type="hidden" class="c" value="<?php echo $id_ciclo ?>"> -->
<!-- <input type="hidden" class="n" value="<?php echo $num_ciclo ?>"> -->
<!-- <input type="hidden" class="y" value="<?php echo $ano_ciclo ?>"> -->
<input type="hidden" class="cant" value="<?php echo $cant; ?>">
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<!-- <input type="hidde" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>"> -->
<!-- <input type="hidde" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>"> -->
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

  $("#descuento_coleccion").change(function(){
    var descuento = parseFloat($(this).val());
    if($(".cant").val()>0){
      var max = parseFloat($(".max_total_descuento").val());
      var total = (max+descuento).toFixed(2);
    }else{
      var total = (descuento).toFixed(2);
    }
    $("#total_descuento").val(total);
    $(this).val((descuento).toFixed(2));
  });

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
    var response = validarLiderazgos();

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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      id_liderazgo: $("#titulo").val(),
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
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                            type: 'error',
                            title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                        });
                      }
                    }
                });
              
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
function validarLiderazgos(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre_liderazgo = $("#titulo").val();
  var rnombre_liderazgo = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( nombre_liderazgo.length  != 0 ){
      $("#error_titulo").html("");
      rnombre_liderazgo = true;
    }else{
      rnombre_liderazgo = false;
      $("#error_titulo").html("Debe llenar el campo de nombre de liderazgo");
    }
  /*===================================================================*/

  /*===================================================================*/
  var minima = $("#minima").val();
  var rminima = checkInput(minima, numberPattern);
  if(rminima==false){
    $("#error_minima").html("Debe colocar el precio minima de la factura");    
  }else{
    $("#error_minima").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var maxima = $("#maxima").val();
  var rmaxima = checkInput(maxima, numberPattern);
    if(maxima==""){    
        $("#error_maximo").html("Debe colocar el precio maximo de factura");
        rmaxima = false;
    }else{
      if(maxima==0){
          $("#error_maximo").html("<span style='color:#0B0'><b><small>Numero indefinido de colecciones</small></b></span>");
          rmaxima = true;
      }else{
        if(parseInt(maxima) > parseInt(minima)){
          $("#error_maximo").html("");
          rmaxima = true;
        }else{
          rmaxima = false;
          $("#error_maximo").html("El precio maximo de la factura debe ser mayor a la cantidad minima");    
        }
      }
    }
  /*===================================================================*/

  /*===================================================================*/
  var descuento = parseFloat($("#descuento_coleccion").val());
  var rdescuento = false;
  if (descuento > 0) {
    $("#error_descuento_coleccion").html("");
    rdescuento = true;
  } else {
    rdescuento = false;
    if(descuento.length == undefined){
      $("#error_descuento_coleccion").html("Debe colocar el porcentaje de descuento por cada factura");
    }
    if(descuento == 0){
      $("#error_descuento_coleccion").html("Debe tener un descuento por factura mayor a 0%");
    }
  }
  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if( rnombre_liderazgo==true && rminima==true && rmaxima==true && rdescuento==true){
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
