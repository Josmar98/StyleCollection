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
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $url; ?></h3>
            </div>

            <form action="" method="post" class="form_register" enctype="multipart/form-data">
                    
              <div class="box-body">

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="codigo">Codigo de producto</label>
                       <input type="text" class="form-control" id="codigo" name="codigo" maxlength="30" placeholder="Ingresar el codigo del producto">
                       <span id="error_codigo" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="nombre">Nombre de producto</label>
                       <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" placeholder="Ingresar nombre del producto">
                       <span id="error_nombre" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="imagen">Imagen de producto</label>
                       <input type="file" class="form-control" id="imagen" name="imagen" maxlength="100" placeholder="Ingresar la imagen del producto">
                       <span id="error_imagen" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="ficha">Imagen de Ficha técnica del producto</label>
                       <input type="file" class="form-control" id="ficha" name="ficha" maxlength="100" placeholder="Ingresar la ficha técnica del producto">
                       <span id="error_ficha" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="ficha2">Imagen de 2da Ficha técnica del producto</label>
                       <input type="file" class="form-control" id="ficha2" name="ficha2" maxlength="100" placeholder="Ingresar la 2da ficha técnica del producto">
                       <span id="error_ficha2" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="ficha3">Imagen de 3era Ficha técnica del producto</label>
                       <input type="file" class="form-control" id="ficha3" name="ficha3" maxlength="100" placeholder="Ingresar la 3era ficha técnica del producto">
                       <span id="error_ficha3" class="errors"></span>
                    </div>
                  </div>

              </div>

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
        window.location = "?route=ProductosCatalogos";
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
    // var response = true;
    if(response == true){
      $(".btn-enviar").attr("disabled");
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      nombre: $("#nombre").val(),
                      codigo: $("#codigo").val(),
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


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern3);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre del producto no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo de nombre del producto ");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var codigo = $("#codigo").val();
  var rcodigo = checkInput(codigo, alfanumericPattern2);
  if( rcodigo == false ){
    if(codigo.length != 0){
      $("#error_codigo").html("La codigo de producto no debe contener caracteres especiales");
    }else{
      $("#error_codigo").html("Debe llenar una codigo para el producto");      
    }
  }else{
    $("#error_codigo").html("");
  }
  /*===================================================================*/
  // var imagen = $("#imagen").val();
  // var rimagen = false;
  // if(imagen.length == 0){
  //   $("#error_imagen").html("Debe seleccionar una imagen para el producto");
  //   rimagen = false;
  // }else{
  //   $("#error_imagen").html("");
  //   rimagen = true;
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  // if( rnombre==true && rcodigo==true && rcantidad==true){
  // if( rnombre==true && rcodigo==true && rimagen==true){
  if( rnombre==true && rcodigo==true){
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
