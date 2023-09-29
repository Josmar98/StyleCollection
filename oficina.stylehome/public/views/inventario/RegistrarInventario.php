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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo $modulo; ?></h3>
            </div>

            <form action="" method="post" class="form_register" enctype="multipart/form-data">
                    
              <div class="box-body">

                  <div class="row">

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="imagen">Imagen de premio</label>
                      <input type="file" class="form-control" id="imagen" name="imagen" maxlength="100" placeholder="Ingresar el imagen del premio">
                      <span id="error_imagen" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="codigo">Codigo de premio</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" maxlength="150" placeholder="Ingresar codigo del premio">
                      <span id="error_codigo" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="nombre">Nombre de premio</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" placeholder="Ingresar nombre del premio">
                      <span id="error_nombre" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="precio">Precio</label>
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" placeholder="Ingresar el precio en gemas, Ej, 10,25">
                      </div>
                      <span id="error_precio" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="puntos">Puntos</label>
                      <input type="number" class="form-control" id="puntos" name="puntos" step="0.01" placeholder="Ingresar el precio en gemas, Ej, 10,25">
                      <span id="error_puntos" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="descripcion">Descripción</label>
                      <textarea style="min-width:100%;max-width:100%;min-height:70px;max-height:120px;" class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar descripcion del premio"></textarea>
                      <span id="error_descripcion" class="errors"></span>
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
          confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
      }).then(function(){
        window.location = "?route=Inventario";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
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
          confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
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
                      codigo: $("#codigo").val(),
                      nombre: $("#nombre").val(),
                      precio: $("#precio").val(),
                      puntos: $("#puntos").val(),
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
                          confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                          type: 'error',
                          title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                          confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
                        });
                      }
                    }
                });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$color_btn_sweetalert; ?>",
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
  var codigo = $("#codigo").val();
  var rcodigo = checkInput(codigo, alfanumericPattern2);
  if( rcodigo == false ){
    if(codigo.length != 0){
      $("#error_codigo").html("El codigo del premio no debe contener numeros o caracteres especiales");
    }else{
      $("#error_codigo").html("Debe llenar el campo de codigo del premio");      
    }
  }else{
    $("#error_codigo").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern2);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre del premio no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo de nombre del premio");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var precio = $("#precio").val();
  var rprecio = checkInput(precio, numberPattern2);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precio").html("El precio del premio no debe contener caracteres especiales");
    }else{
      $("#error_precio").html("Debe llenar un precio para el premio");      
    }
  }else{
    $("#error_precio").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var puntos = $("#puntos").val();
  var rpuntos = checkInput(puntos, numberPattern2);
  if( rpuntos == false ){
    if(puntos.length != 0){
      $("#error_puntos").html("Los puntos del premio no debe contener caracteres especiales");
    }else{
      $("#error_puntos").html("Debe llenar un puntos para el premio");      
    }
  }else{
    $("#error_puntos").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var descripcion = $("#descripcion").val();
  var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  if( rdescripcion == false ){
    if(descripcion.length != 0){
      $("#error_descripcion").html("El descripcion del producto no debe contener numeros o caracteres especiales");
    }else{
      $("#error_descripcion").html("Debe llenar el campo de descripcion del premio ");      
    }
  }else{
    $("#error_descripcion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rcodigo==true && rnombre==true && rprecio==true && rpuntos==true && rdescripcion==true){
  // if( rnombre==true && rcodigo==true && rcantidad==true){
  // if( rnombre==true && rcantidad==true){
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
