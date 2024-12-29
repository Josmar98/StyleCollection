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
        <div class="col-md-10" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-6">
                      <label for="cliente">Usuario</label>                      
                      <select class="form-control select2" id="cliente" name="cliente">
                         <option value=""></option>
                        <!-- <option value="0">Ninguna</option> -->
                        <?php 
                        foreach ($clientes as $data) {
                          if( !empty($data['id_cliente']) ){
                            ?>
                              <option value="<?php echo $data['id_cliente'] ?>"
                                <?php foreach ($usuarios as $users) { if(!empty($users['id_cliente'])){ if($users['id_cliente'] == $data['id_cliente']){ ?>
                                        disabled="disabled"
                                  <?php } } }?>
                                >
                                <?php echo $data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula'] ?>    
                              </option>
                            <?php
                          }
                        } ?>
                      </select>
                      <span id="error_cliente" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="rol">Rol de usuario</label>                      
                      <select class="form-control select2" id="rol" name="rol">
                         <option value=""></option>
                        <!-- <option value="0">Ninguna</option> -->
                        <?php 
                        foreach ($roles as $data) {
                          if( !empty($data['id_rol']) ){
                            ?>
                              <option value="<?php echo $data['id_rol'] ?>"><?php echo $data['nombre_rol'] ?></option>
                            <?php
                          }
                        } ?>
                      </select>
                      <span id="error_rol" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-4">
                       <label for="nombre_usuario">Nombre de usuario</label>
                       <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" maxlength="30" placeholder="Ingresar nombre de usuario">
                       <span id="error_nombre" class="errors"></span>
                    </div>


                    <div class="form-group col-sm-4">
                      <label for="password">Contraseña</label>
                      <input type="password" class="form-control" id="password" name="password" maxlength="30" placeholder="Contraseña">
                      <span id="info_password" class="info"></span>
                      <span id="error_password" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="password2">Confirmar Contraseña</label>
                      <input type="password" class="form-control" id="password2" name="password2" maxlength="30" placeholder="Confirmar la Contraseña">
                      <span id="info_password2" class="info2"></span>
                      <span id="error_password2" class="errors"></span>
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
        window.location = "?route=Usuarios";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Cuenta de usuario ya exitente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Usuarios";
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
                      nombre_usuario: $("#nombre_usuario").val(),
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

  $("#password").keyup(function(){
    $("#error_password2").html("");
    var p1 = $("#password").val();
    var p2 = $("#password2").val();
    if(p1 == p2){
      $("#info_password2").attr("style","color:green;");
      $("#info_password2").html("Las contraseñas coinciden");
    }else{
      $("#info_password2").attr("style","color:red;");
      $("#info_password2").html("Las contraseñas no coinciden");
    }
  });
  $("#password2").keyup(function(){
    $("#error_password2").html("");
    var p1 = $("#password").val();
    var p2 = $("#password2").val();
    if(p1 == p2){
      $("#info_password2").attr("style","color:green;");
      $("#info_password2").html("Las contraseñas coinciden");
    }else{
      $("#info_password2").attr("style","color:red;");
      $("#info_password2").html("Las contraseñas no coinciden");
    }
  });


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre = $("#nombre_usuario").val();
  var rnombre = checkInput(nombre, alfanumericPattern3);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre de usuario solo acepta algunos caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo con un nombre de usuario");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/

   /*===================================================================*/
  var password = $("#password").val();
  var rpassword = checkInput(password, alfanumericPattern3);
  if( rpassword == false ){
    if(password.length != 0){
      $("#error_password").html("La contraseña solo acepta algunos caracteres especiales");
    }else{
      $("#error_password").html("Debe escribir una contraseña para la seguridad de la cuenta");      
    }
  }else{
    $("#error_password").html("");
  }
  /*==================================================================

  /*===================================================================*/
  var password2 = $("#password2").val();
  var rpassword2 = checkInput(password2, alfanumericPattern3);
  if( rpassword2 == false ){
    if(password2.length != 0){
      $("#error_password2").html("La contraseña solo acepta algunos caracteres especiales");
    }else{
      $("#error_password2").html("Debe confirmar la contraseña para la seguridad de la cuenta");      
    }
  }else{
    $("#error_password2").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cliente = $("#cliente").val();
  var rcliente = false;
  if(cliente == ""){
    rcliente = false;
    $("#error_cliente").html("Debe seleccionar un cliente para la cuenta de usuario");
  }else{
    rcliente = true;
    $("#error_cliente").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var rol = $("#rol").val();
  var rrol = false;
  if(rol == ""){
    rrol = false;
    $("#error_rol").html("Debe seleccionar un rol para el usuario");
  }else{
    rrol = true;
    $("#error_rol").html("");
  }
  /*===================================================================*/
  var rPassRes = false;
  if(password==password2){
    rPassRes = true;
  }
  // /*===================================================================*/
  var result = false;
  if( rnombre==true && rpassword==true && rpassword2==true && rPassRes==true && rcliente==true && rrol==true){
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
