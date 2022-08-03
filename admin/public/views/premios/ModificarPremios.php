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
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-9" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-6">
                       <label for="nombre_premio">Nombre</label>
                       <input type="text" class="form-control" id="nombre_premio" name="nombre_premio" value="<?php echo $premio['nombre_premio'] ?>" maxlength="150" placeholder="Ingresar nombre del premio">
                       <span id="error_nombre_producto" class="errors"></span>
                    </div>


                    <div class="form-group col-sm-6">
                       <label for="precio">Precio</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $premio['precio_premio'] ?>" maxlength="20" placeholder="Precio del premio">
                       </div>
                       <span id="error_precio" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label for="descripcion">Descripcion del premio</label>
                      <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del premio" maxlength="200" style="height:60px;max-height:60px;min-height:60px;width:100%;min-width:100%;max-width:100%;"><?php echo $premio['descripcion_premio'] ?></textarea>
                      <span id="error_descripcion" class="errors"></span>
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
                <a style="margin-left:5%" href="?route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>

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
        window.location = "?route=Premios";
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
                      nombre_premio: $("#nombre_premio").val(),
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


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre_premio = $("#nombre_premio").val();
  var rnombre_premio = checkInput(nombre_premio, alfanumericPattern2);
  if( rnombre_premio == false ){
    if(nombre_premio.length != 0){
      $("#error_nombre_producto").html("El nombre del premio no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre_producto").html("Debe llenar el campo de nombre del premio");      
    }
  }else{
    $("#error_nombre_producto").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, alfanumericPattern);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de producto no debe contener caracteres especiales");
  //   }else{
  //     $("#error_cantidad").html("Debe llenar una cantidad para el producto");      
  //   }
  // }else{
  //   $("#error_cantidad").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var precio = $("#precio").val();
  var rprecio = checkInput(precio, numberPattern2);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precio").html("El precio no debe contener caracteres especiales. solo permite {, .}");
    }else{
      $("#error_precio").html("Debe llenar el campo de precio para el premio");      
    }
  }else{
    $("#error_precio").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var descripcion = $("#descripcion").val();
  var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  if( rdescripcion == false ){
    if(descripcion.length != 0){
      $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
    }else{
      $("#error_descripcion").html("Debe llenar la descripcion del premio");      
    }
  }else{
    $("#error_descripcion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // var fragancias = $("#fragancias").val();
  // var rfragancias = false;
  // if(fragancias == ""){
  //   rfragancias = false;
  //   $("#error_fragancias").html("Debe seleccionar las fragancias para el producto");
  // }else{
  //   rfragancias = true;
  //   $("#error_fragancias").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre_premio==true && rprecio==true && rdescripcion==true){
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
