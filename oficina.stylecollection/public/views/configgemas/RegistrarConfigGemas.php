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
        <?php echo "Configuracion" ?>
        <small><?php if(!empty($action)){echo $action;} echo " Configuracion de Gemas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Configuracion"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Configuracion de Gemas"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Configuracion"; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Configuracion de Gemas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="nombreConfig">Nombre de configuracion</label>
                       <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ...">
                       <span id="error_nombreConfig" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="cantidad">Cantidad de gemas</label>
                       <input type="number" class="form-control cantidad" id="cantidad" name="cantidad" maxlength="20" placeholder="1">

                       <span id="error_cantidad" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="condicion">Cantidad de gemas</label>
                       <select class="form-control condicion" name="condicion" id="condicion">
                         <option>Multiplicar</option>
                         <option>Dividir</option>
                       </select>
                       <span id="error_cantidad" class="errors"></span>
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
        window.location = "?route=ConfigNombramientos";
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
                      // validarData: true,
                      nombre: $("#nombreConfig").val(),
                      cantidadGemas: $("#cantidad").val(),
                      condicion: $("#condicion").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          swal.fire({
                              type: 'success',
                              title: '¡Datos guardados correctamente!',
                              confirmButtonColor: "#ED2A77",
                          }).then(function(){
                            window.location = "?route=ConfigGemas";
                          });
                          // $(".btn-enviar").removeAttr("disabled");
                          // $(".btn-enviar").click();
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


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombreConfig = $("#nombreConfig").val();
  var rnombreConfig = checkInput(nombreConfig, textPattern2);
  if( rnombreConfig == false ){
    $("#error_nombreConfig").html("Debe seleccionar un nombreConfig");      
  }else{
    $("#error_nombreConfig").html("");
    rnombreConfig = true;
  }
  /*===================================================================*/

  /*===================================================================*/

  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern2);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
    }else{
        $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
    }
  }else{
      if(cantidad < 1){
        $("#error_cantidad").html("La cantidad de gemas debe ser mayor a 0");      
      }else{
        $("#error_cantidad").html("");
        rcantidad = true;
      }
  }

  /*===================================================================*/
  var result = false;
  if( rnombreConfig==true && rcantidad==true){
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
