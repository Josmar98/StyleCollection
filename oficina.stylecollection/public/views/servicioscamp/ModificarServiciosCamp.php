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
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo." de campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo." de campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-xs-12">
                      <label for="servicio"><?=$modulo; ?> para campaña <?php echo $n."/".$y ?></label>
                      <select class="form-control select2" id="servicio" name="servicio">
                        <option value=""></option>
                        <?php 
                          
                          foreach ($servicioss as $data) {
                            if(!empty($data['id_servicioss'])){
                              
                              ?>
                              <option value="<?php echo $data['id_servicioss'] ?>" <?php if($servicio['id_servicioss']==$data['id_servicioss']){ echo "selected"; } ?>>
                                <?php echo $data['nombre_servicioss']; ?>
                              </option>
                              <?php
                          }
                        }
                        ?>
                      </select>
                      <span id="error_servicio" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12">
                      <hr>
                    </div>
                  </div>
                  <div class="row" style="padding:0px 15px;">
                    <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                      <br>
                      <div style="width:15%;float:left;">
                        <label for="name_opcion" style="font-size:1.3em;"><u>Nombre Servicio</u></label>
                      </div>
                      <div style="width:65%;float:left;">
                        <input type="text" class="form-control" style="" id="name_opcion" name="name_opcion" placeholder="Coloque nombre del servicio"  value="<?php if(!empty($servicio['nombre_servicio'])){ echo $servicio['nombre_servicio']; } ?>">
                        <span id="error_name_opcion" class="errors"></span>
                      </div>
                      <div style="width:20%;float:left;">
                        <input type="number" class="form-control" step="0.01" style="" id="precio_opcion" name="precio_opcion" value="<?=$servicio['precio_servicio']; ?>">
                        <span id="error_precio_opcion" class="errors"></span>
                      </div>
                      <div style="clear:both;"></div>
                      <br>
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=ServiciosCamp";
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
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         nombre: $("#nombre").val(),
              //         precio: $("#precio").val(),
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

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var servicio = $("#servicio").val();
  // var rnombre = checkInput(nombre, alfanumericPattern2);
  // if( rnombre == false ){
  if(servicio==""){
    rservicio=false;
    $("#error_servicio").html("Debe seleccionar el Servicio");      
  }else{
    rservicio=true;
    $("#error_servicio").html("");
  }
  
  // /*===================================================================*/
  var nombre = $("#name_opcion").val();
  var rnombre = false;
  if(nombre==""){
    rnombre = false;
    $("#error_name_opcion").html("Debe agregar un nombre para el servicio");
  }else{
    rnombre = true;
    $("#error_name_opcion").html("");
  }

  var precio = $("#precio_opcion").val();
  var rprecio = false;
  if(precio=="" || precio==0){
    rprecio = false;
    $("#error_precio_opcion").html("Debe agregar un precio para el servicio");
  }else{
    rprecio = true;
    $("#error_precio_opcion").html("");
  }


  /*===================================================================*/
  var result = false;
  if( rservicio==true && rnombre==true && rprecio==true){
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
