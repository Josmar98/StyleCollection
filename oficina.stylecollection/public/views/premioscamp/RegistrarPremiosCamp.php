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
        <?php echo "Premios de la campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Premios"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Premios"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Premios de la campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Premios a la campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <?php 
                      ?>
                      <h3 class="box-title">
                        Plan
                        <select name="plan" id="plan" class="select2" style="width:70%">
                          <option value=""></option>
                          <?php   foreach ($planes as $data): if(!empty($data['id_plan_campana'])): ?>
                          <option <?php foreach ($planesya as $keya) { if(!empty($keya['id_plan_campana'])){ if($data['id_plan_campana'] == $keya['id_plan_campana']){ echo "disabled"; } } } ?> value="<?php echo $data['id_plan_campana'] ?>"><?php echo $data['nombre_plan']; ?></option>
                          <?php endif; endforeach; ?>
                        </select>
                      </h3>
                      <span id="error_plan" class="errors"></span>
                    </div>
                  </div>
                    <!-- <input type="hidden" name="id_plan" value="titulo"> -->
                  
<!-- ========================================================================================================== -->
                      <!-- INICIAL -->
<!-- ========================================================================================================== -->
                  <div class="row">

                    <!--   -->
                    <div class="form-group col-sm-6">
                       <label for="tipoInicial">Inicial</label>
                       <select class="form-control select2" name="tipoInicial" id="tipoInicial">
                         <option value=""></option>
                         <option>Productos</option>
                         <option>Premios</option>
                       </select>
                       <span id="error_tipo_inicial" class="errors"></span>
                    </div>
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-productosInicial d-none">
                      <label for="productosInicial">Productos</label>                      
                      <select class="select2" style="width:100%" id="productosInicial" multiple="multiple" name="productosInicial[]">
                         <option value=""></option>
                        <!-- <option value="0">Ninguna</option> -->
                            <?php foreach ($productos as $data): if( !empty($data['id_producto']) ): ?>
                        
                          <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option>
                        
                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_productos_inicial" class="errors"></span>
                    </div> 
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-premiosInicial d-none">
                      <label for="premiosInicial">Premios</label>                      
                      <select class="select2" style="width:100%" id="premiosInicial" multiple="multiple" name="premiosInicial[]">
                         <option value=""></option>
                        <!-- <option value="0">Ninguna</option> -->
                            <?php foreach ($premios as $data): if( !empty($data['id_premio']) ): ?>

                          <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option>

                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_premios_inicial" class="errors"></span>
                    </div> 
                    <!--   -->
                  </div>
<!-- ========================================================================================================== -->



<!-- ========================================================================================================== -->
                  <!-- PRIMER PAGO -->
<!-- ========================================================================================================== -->
                  <div class="row">

                    <!--   -->
                    <div class="form-group col-sm-6">
                       <label for="tipoPrimer">Primer Pago</label>
                       <select class="form-control select2" name="tipoPrimer" id="tipoPrimer">
                         <option value=""></option>
                         <option>Productos</option>
                         <option>Premios</option>
                       </select>
                       <span id="error_tipo_primer" class="errors"></span>
                    </div>
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-productosPrimer d-none">
                      <label for="productosPrimer">Productos</label>                      
                      <select class="select2" style="width:100%;" id="productosPrimer" multiple="multiple" name="productosPrimer[]">
                         <option value=""></option>
                          <!-- <option value="0">Ninguna</option> -->
                            <?php foreach ($productos as $data): if( !empty($data['id_producto']) ): ?>
                          <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option>
                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_productos_primer" class="errors"></span>
                    </div> 
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-premiosPrimer d-none">
                      <label for="premiosPrimer">Premios</label>                      
                      <select class="select2" style="width:100%;" id="premiosPrimer" multiple="multiple" name="premiosPrimer[]">
                         <option value=""></option>
                        <!-- <option value="0">Ninguna</option> -->
                            <?php foreach ($premios as $data): if( !empty($data['id_premio']) ): ?>
                          <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option>
                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_premios_primer" class="errors"></span>
                    </div> 
                    <!--   -->
                  </div>
<!-- ========================================================================================================== -->



<!-- ========================================================================================================== -->
                  <!-- SEGUNDO PAGO -->
<!-- ========================================================================================================== -->
                  <div class="row">

                    <!--   -->
                    <div class="form-group col-sm-6">
                       <label for="tipoSegundo">Segundo Pago</label>
                       <select class="form-control select2" name="tipoSegundo" id="tipoSegundo">
                         <option value=""></option>
                         <option>Productos</option>
                         <option>Premios</option>
                       </select>
                       <span id="error_tipo_segundo" class="errors"></span>
                    </div>
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-productosSegundo d-none">
                      <label for="productosSegundo">Productos</label>                      
                      <select class="select2" style="width:100%" id="productosSegundo" multiple="multiple" name="productosSegundo[]">
                         <option value=""></option>
                        <option value="0">Ninguno</option>
                            <?php foreach ($productos as $data): if( !empty($data['id_producto'])): ?>
                          <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option>
                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_productos_segundo" class="errors"></span>
                    </div> 
                    <!--   -->

                    <!--   -->
                    <div class="form-group col-sm-6 box-premiosSegundo d-none">
                      <label for="premiosSegundo">Premios</label>                      
                      <select class="select2" style="width:100%" id="premiosSegundo" multiple="multiple" name="premiosSegundo[]">
                         <option value=""></option>
                        <option value="0">Ninguno</option>
                            <?php foreach ($premios as $data): if( !empty($data['id_premio'])): ?>
                          <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option>
                            <?php endif; endforeach; ?>
                      </select>
                      <span id="error_premios_segundo" class="errors"></span>
                    </div> 
                    <!--   -->
                  </div>
<!-- ========================================================================================================== -->

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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PremiosCamp";
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
                      plan: $("#plan").val(),
                      // nombre_producto: $("#nombre_producto").val(),
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

  $(".box-productosInicial").hide();
  $(".box-productosInicial").removeClass("d-none");
  $(".box-premiosInicial").hide();
  $(".box-premiosInicial").removeClass("d-none");

  $("#tipoInicial").change(function(){
    $("#error_productos_inicial").html("");
    $("#error_premios_inicial").html("");

    var tipoInicial = $(this).val();
    if(tipoInicial == ""){
      $(".box-premiosInicial").hide();
      $(".box-productosInicial").hide();      
    }
    if(tipoInicial == "Productos"){
      $(".box-premiosInicial").hide();
      $(".box-productosInicial").show();
    }
    if(tipoInicial == "Premios"){
      $(".box-productosInicial").hide();
      $(".box-premiosInicial").show();
    }
  });

  $(".box-productosPrimer").hide();
  $(".box-productosPrimer").removeClass("d-none");
  $(".box-premiosPrimer").hide();
  $(".box-premiosPrimer").removeClass("d-none");

  $("#tipoPrimer").change(function(){
    $("#error_productos_primer").html("");
    $("#error_premios_primer").html("");

    var tipoPrimer = $(this).val();
    if(tipoPrimer == ""){
      $(".box-premiosPrimer").hide();
      $(".box-productosPrimer").hide();      
    }
    if(tipoPrimer == "Productos"){
      $(".box-premiosPrimer").hide();
      $(".box-productosPrimer").show();
    }
    if(tipoPrimer == "Premios"){
      $(".box-productosPrimer").hide();
      $(".box-premiosPrimer").show();
    }
  });

  $(".box-productosSegundo").hide();
  $(".box-productosSegundo").removeClass("d-none");
  $(".box-premiosSegundo").hide();
  $(".box-premiosSegundo").removeClass("d-none");

  $("#tipoSegundo").change(function(){
    $("#error_productos_segundo").html("");
    $("#error_premios_segundo").html("");

    var tipoSegundo = $(this).val();
    if(tipoSegundo == ""){
      $(".box-premiosSegundo").hide();
      $(".box-productosSegundo").hide();      
    }
    if(tipoSegundo == "Productos"){
      $(".box-premiosSegundo").hide();
      $(".box-productosSegundo").show();
    }
    if(tipoSegundo == "Premios"){
      $(".box-productosSegundo").hide();
      $(".box-premiosSegundo").show();
    }
  });
  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var plan = $("#plan").val();
  var rplan = false;
  if(plan == ""){
    rplan = false;
    $("#error_plan").html("Debe seleccionar el plan para seleccionar los premios");
  }else{
    rplan = true;
    $("#error_plan").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
    // Inicial
  /*===================================================================*/
  var tipoInicial = $("#tipoInicial").val();
  var rtipoInicial = false;
  if(tipoInicial == ""){
    rtipoInicial = false;
    $("#error_tipo_inicial").html("Debe seleccionar el tipo premio para la inicial");
  }else{
    rtipoInicial = true;
    $("#error_tipo_inicial").html("");
  }
  /*===================================================================*/
  var premioIncial;
  var rpremioInicial = false;

  if(tipoInicial == "Productos"){
    premioIncial = $("#productosInicial").val();
    if(premioIncial == ""){
      rpremioInicial = false;
      $("#error_productos_inicial").html("Debe seleccionar los premios de inicial");
    }else{
      rpremioInicial = true;
      $("#error_productos_inicial").html("");
    }
  }
  if(tipoInicial == "Premios"){
    premioIncial = $("#premiosInicial").val();
    if(premioIncial == ""){
      rpremioInicial = false;
      $("#error_premios_inicial").html("Debe seleccionar los premios de inicial");
    }else{
      rpremioInicial = true;
      $("#error_premios_inicial").html("");
    }
  }
  /*===================================================================*/


  /*===================================================================*/
  var tipoPrimer = $("#tipoPrimer").val();
  var rtipoPrimer = false;
  if(tipoPrimer == ""){
    rtipoPrimer = false;
    $("#error_tipo_primer").html("Debe seleccionar el tipo premio para el primer pago");
  }else{
    rtipoPrimer = true;
    $("#error_tipo_primer").html("");
  }
  /*===================================================================*/
  var premioPrimer;
  var rpremioPrimer = false;

  if(tipoPrimer == "Productos"){
    premioPrimer = $("#productosPrimer").val();
    if(premioPrimer == ""){
      rpremioPrimer = false;
      $("#error_productos_primer").html("Debe seleccionar los premios de primer pago");
    }else{
      rpremioPrimer = true;
      $("#error_productos_primer").html("");
    }
  }
  if(tipoPrimer == "Premios"){
    premioPrimer = $("#premiosPrimer").val();
    if(premioPrimer == ""){
      rpremioPrimer = false;
      $("#error_premios_primer").html("Debe seleccionar los premios de primer pago");
    }else{
      rpremioPrimer = true;
      $("#error_premios_primer").html("");
    }
  }
  /*===================================================================*/

  /*===================================================================*/
  var tipoSegundo = $("#tipoSegundo").val();
  var rtipoSegundo = false;
  if(tipoSegundo == ""){
    rtipoSegundo = false;
    $("#error_tipo_segundo").html("Debe seleccionar el tipo premio para el segundo pago");
  }else{
    rtipoSegundo = true;
    $("#error_tipo_segundo").html("");
  }
  /*===================================================================*/
  var premioSegundo;
  var rpremioSegundo = false;

  if(tipoSegundo == "Productos"){
    premioSegundo = $("#productosSegundo").val();
    if(premioSegundo == ""){
      rpremioSegundo = false;
      $("#error_productos_segundo").html("Debe seleccionar los premios de segundo pago");
    }else{
      rpremioSegundo = true;
      $("#error_productos_segundo").html("");
    }
  }
  if(tipoSegundo == "Premios"){
    premioSegundo = $("#premiosSegundo").val();
    if(premioSegundo == ""){
      rpremioSegundo = false;
      $("#error_premios_primer").html("Debe seleccionar los premios de segundo pago");
    }else{
      rpremioSegundo = true;
      $("#error_premios_primer").html("");
    }
  }
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rplan==true && rtipoInicial==true && rpremioInicial==true && rtipoPrimer==true && rpremioPrimer==true && rtipoSegundo==true && rpremioSegundo==true){
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
