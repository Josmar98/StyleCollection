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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-3">
                       <label for="nombre1">Primer Nombre</label>
                       <input type="text" class="form-control" id="nombre1" name="nombre1" maxlength="30" placeholder="Ingresar primer nombre">
                       <span id="error_nombre1" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="nombre2">Segundo Nombre</label>
                       <input type="text" class="form-control" id="nombre2" name="nombre2" maxlength="30" placeholder="Ingresar segundo nombre">
                       <span id="error_nombre2" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="apellido1">Primer Apellido</label>
                       <input type="text" class="form-control" id="apellido1" name="apellido1" maxlength="30" placeholder="Ingresar primer apellido">
                       <span id="error_apellido1" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="apellido2">Segundo Apellido</label>
                       <input type="text" class="form-control" id="apellido2" name="apellido2" maxlength="30" placeholder="Ingresar segundo apellido">
                       <span id="error_apellido2" class="errors"></span>
                    </div>

                  </div>
                      
                  <div class="row">

                    <div class="form-group col-sm-4">
                      <label for="cedula">Cedula de identidad</label>
                      <div class="input-group">
                        <span class="input-group-addon">V</span>
                        <input type="hidden" name="cod_cedula" value="V">
                        <input type="text" class="form-control" id="cedula" name="cedula" maxlength="9" placeholder="Cedula de identidad">
                      </div>
                      <span id="error_cedula" class="errors"></span>
                    </div>


                    <div class="form-group col-sm-4">
                      <label for="rif">Nº Rif</label>
                      <div class="input-group col-xs-12">
                            <select id="cod_rif" name="cod_rif" class="form-control input-group-addon" style="width:25%">
                              <option>V</option>
                              <option>J</option>
                              <option>G</option>
                              <option>E</option>
                            </select>  
                            <input type="text" style="width:75%" class="form-control" id="rif" maxlength="12" name="rif" placeholder="Numero Rif">
                      </div>
                      <span id="error_rif" class="errors"></span>
                    </div>
                    
                    <div class="form-group  col-sm-4">
                      <label for="fechaNacimiento">Fecha Nacimiento</label>
                      <input type="date" max="<?php echo date("Y-m-d") ?>" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                      <span id="error_fechaNacimiento" class="errors"></span>
                    </div>

                  </div>

                  <div class="row">
                    
                    <div class="form-group col-sm-6">
                      <label for="telefono">Nº de Telefono</label>
                      <div class="input-group col-xs-12">
                          <select id="cod_tlfn" name="cod_tlfn" class="form-control input-group-addon" style="width:25%">
                              <option>0412</option>
                              <option>0414</option>
                              <option>0424</option>
                              <option>0416</option>
                              <option>0426</option>
                              <option>0251</option>
                            </select>  
                          <input type="text" style="width:75%" maxlength="7" minlength="7" class="form-control" id="telefono" name="telefono" maxlength="9" placeholder="Numero de telefono">
                      </div>
                      <span id="error_telefono" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="telefono2">Nº de Telefono 2 <small>(Opcional)</small></label>
                      <div class="input-group col-xs-12">
                          <select id="cod_tlfn2" name="cod_tlfn2" class="form-control input-group-addon" style="width:25%">
                              <option>0412</option>
                              <option>0414</option>
                              <option>0424</option>
                              <option>0416</option>
                              <option>0426</option>
                              <option>0251</option>
                            </select>  
                          <input type="text" style="width:75%" class="form-control" id="telefono2" name="telefono2" maxlength="9" placeholder="Numero de telefono 2">
                      </div>
                      <span id="error_telefono2" class="errors"></span>
                    </div>
                    
                  </div>
                  <div class="row">

                    <div class="form-group col-sm-6">
                      <label for="correo">Correo Electronico</label>
                      <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electronico">
                      <input type="hidden" class="correoOp">
                      <span id="error_correo" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="Sexo">Sexo</label>
                      <div style="clear:both;"></div>
                      <div class="input-group" style="margin-left:2%;float:left;">
                        <label for="masculino">Masculino</label>
                        <input type="radio" class="sexoOp" id="masculino" name="sexoOp" value="Masculino" style="margin-left:5px;">
                      </div>
                      <div class="input-group" style="margin-left:8%;float:left;">
                          <label for="femenino">Femenino</label>
                          <input type="radio" class="sexoOp" id="femenino" name="sexoOp" value="Femenino" style="margin-left:5px;">
                      </div>
                      <input type="hidden" name="sexo" id="sexo">
                      <div style="clear:both;"></div>
                      <span id="error_sexo" class="errors"></span>
                    </div>

                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="direccion">Direccion Fisica de RIF</label>
                      <textarea class="form-control" id="direccion" name="direccion" placeholder="Direccion Fisica de Documento RIF" maxlength="200" style="height:60px;max-height:60px;min-height:60px;width:100%;min-width:100%;max-width:100%;"></textarea>
                      <span id="error_direccion" class="errors"></span>
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
        window.location = "?route=Empleados";
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
                      cedula: $("#cedula").val(),
                      correo: $("#correo").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                      }
                      if (respuesta == "4"){
                        $(".correoOp").val("error");
                        $("#error_correo").html("Ingrese una direccion de correo electronico valida. Debe terminar en <b>.com</b>");
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
    }
  });



  $("#sexo").val("");
  $("#masculino").click(function(){
    $("#sexo").val("Masculino");
  });
  $("#femenino").click(function(){
    $("#sexo").val("Femenino");
  });
  // sexoOp



});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre1 = $("#nombre1").val();
  var rnombre1 = checkInput(nombre1, textPattern2);
  if( rnombre1 == false ){
    if(nombre1.length != 0){
      $("#error_nombre1").html("El primer nombre no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre1").html("Debe llenar el campo de primer nombre");      
    }
  }else{
    $("#error_nombre1").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var nombre2 = $("#nombre2").val();
  var rnombre2 = checkInput(nombre2, textPattern2);
  if( rnombre2 == false ){
    if(nombre2.length != 0){
      $("#error_nombre2").html("El segundo nombre no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre2").html("Debe llenar el campo de segundo nombre");      
    }
  }else{
    $("#error_nombre2").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var apellido1 = $("#apellido1").val();
  var rapellido1 = checkInput(apellido1, textPattern2);
  if( rapellido1 == false ){
    if(apellido1.length != 0){
      $("#error_apellido1").html("El primer apellido no debe contener numeros o caracteres especiales");
    }else{
      $("#error_apellido1").html("Debe llenar el campo de primer apellido");      
    }
  }else{
    $("#error_apellido1").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var apellido2 = $("#apellido2").val();
  var rapellido2 = checkInput(apellido2, textPattern2);
  if( rapellido2 == false ){
    if(apellido2.length != 0){
      $("#error_apellido2").html("El segundo apellido no debe contener numeros o caracteres especiales");
    }else{
      $("#error_apellido2").html("Debe llenar el campo de segundo apellido");      
    }
  }else{
    $("#error_apellido2").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cedula = $("#cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
        $("#error_cedula").html("La cedula debe tener minimo 7 caracteres y solo de tipo numerico");
    }else{
      $("#error_cedula").html("Debe llenar el campo de la cedula");      
    }
  }else{
      if(cedula.length >= 7){
        $("#error_cedula").html("");
      }else{
        $("#error_cedula").html("La cedula debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }
  /*===================================================================*/

  /*===================================================================*/
  var fechaNacimiento = $("#fechaNacimiento").val();
  var rfechaNacimiento = false;
  if(fechaNacimiento.length != 0){
    $("#error_fechaNacimiento").html("");
    rfechaNacimiento = true;
  }else{
    $("#error_fechaNacimiento").html("Debe llenar el campo de Fecha de Nacimiento");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var rif = $("#rif").val();
  var rrif = checkInput(rif, numberPattern);
  if( rrif == false ){
    if(rif.length != 0){
        $("#error_rif").html("El Rif debe tener minimo 7 caracteres y solo de tipo numerico");
    }else{
      $("#error_rif").html("Debe llenar el campo del Rif");      
    }
  }else{
      if(rif.length >= 7){
        $("#error_rif").html("");
      }else{
        $("#error_rif").html("El Rif debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }
  /*===================================================================*/

  /*===================================================================*/
  var telefono = $("#telefono").val();
  var rtelefono = checkInput(telefono, numberPattern);
  if( rtelefono == false ){
    if(telefono.length != 0){
        $("#error_telefono").html("El telefono debe tener minimo 7 caracteres y solo de tipo numerico");
    }else{
      $("#error_telefono").html("Debe llenar el campo del telefono");      
    }
  }else{
      if(telefono.length >= 7){
        $("#error_telefono").html("");
      }else{
        $("#error_telefono").html("El telefono debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }


  /*===================================================================*/
  //emailPattern

  /*===================================================================*/
  var correo = $("#correo").val();
  var rcorreo = checkInput(correo, emailPattern);
  $(".correoOp").val("");
  if( rcorreo == false ){
    if(correo.length != 0){
      $("#error_correo").html("Ingrese una direccion de correo electronico valida");
    }else{
      $("#error_correo").html("Debe llenar el campo del correo electronico");      
    }
  }else{
    if($(".correoOp").val() == "error"){
      rcorreo = false;
    }else{
      rcorreo = true;
      $("#error_correo").html("");
    }
  }

  /*===================================================================*/

  /*===================================================================*/
  var sexo = $("#sexo").val();
  var rsexo = false;
  // alert(sexo.length);

  if(sexo.length == 0){
    $("#error_sexo").html("Debe seleccionar una opcion"); 
    rsexo = false;
  }else{
    rsexo = true;
    $("#error_sexo").html("");
  }
  // alert(rsexo);
  // if(sexo == ""){
  //     if(sexoM == "off"){ sexo = "";  }
  //     if(sexoM == "on"){  sexo = "Masculino"; }
  // }
  // if(sexo == ""){
  //     if(sexoF == "off"){ sexo = "";  }
  //     if(sexoF == "on"){  sexo = "Femenino";  }
  // }

  // if(sexo == ""){
  //   rsexo = false;
  // }else{
  // }
  /*===================================================================*/

  /*===================================================================*/
  var direccion = $("#direccion").val();
  var rdireccion = checkInput(direccion, alfanumericPattern2);
  if( rdireccion == false ){
    if(direccion.length != 0){
      $("#error_direccion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
    }else{
      $("#error_direccion").html("Debe llenar la direccion de vivienda - misma direccion del documento RIF");      
    }
  }else{
    $("#error_direccion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre1==true && rnombre2==true && rapellido1==true && rapellido2==true && rcedula==true && rfechaNacimiento==true && rrif == true && rtelefono == true && rcorreo == true && rsexo == true && rdireccion == true){
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
