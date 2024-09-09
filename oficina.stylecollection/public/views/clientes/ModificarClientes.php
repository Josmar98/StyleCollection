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
        <?php echo "Lideres"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Lideres"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Lideres"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Lideres"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Lideres" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Lideres"; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php
              $editarFotos=0;
              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              foreach ($configuraciones as $config) {
                if(!empty($config['id_configuracion'])){
                  if($config['clausula']=="Editar Fotos"){
                    $editarFotos = $config['valor'];
                  }
                }
              }
            ?>
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register" <?php if($editarFotos==1){ ?> enctype="multipart/form-data" <?php } ?> >
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-3">
                       <label for="nombre1">Primer Nombre</label>
                       <input type="text" class="form-control" id="nombre1" value="<?php echo $datas['primer_nombre']; ?>" name="nombre1" maxlength="30" placeholder="Ingresar primer nombre">
                       <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                       <span id="error_nombre1" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="nombre2">Segundo Nombre</label>
                       <input type="text" class="form-control" id="nombre2" value="<?php echo $datas['segundo_nombre'] ?>" name="nombre2" maxlength="30" placeholder="Ingresar segundo nombre">
                       <span id="error_nombre2" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="apellido1">Primer Apellido</label>
                       <input type="text" class="form-control" id="apellido1" value="<?php echo $datas['primer_apellido'] ?>" name="apellido1" maxlength="30" placeholder="Ingresar primer apellido">
                       <span id="error_apellido1" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="apellido2">Segundo Apellido</label>
                       <input type="text" class="form-control" id="apellido2" value="<?php echo $datas['segundo_apellido'] ?>" name="apellido2" maxlength="30" placeholder="Ingresar segundo apellido">
                       <span id="error_apellido2" class="errors"></span>
                    </div>

                  </div>
                      
                  <div class="row">

                    <div class="form-group col-sm-4">
                      <label for="cedula">Cedula de identidad</label>
                      <div class="input-group">
                        <span class="input-group-addon">V</span>
                        <input type="hidden" name="cod_cedula" value="V">
                        <input type="text" class="form-control" id="cedula" value="<?php echo $datas['cedula'] ?>" name="cedula" maxlength="9" placeholder="Cedula de identidad">
                        <input type="hidden" class="form-control" id="cedulahidden" value="<?php echo $datas['cedula'] ?>" name="cedulahidden" maxlength="9" placeholder="Cedula de identidad">
                      </div>
                      <span id="error_cedula" class="errors"></span>
                    </div>


                    <div class="form-group col-sm-4">
                      <label for="rif">Nº Rif</label>
                      <div class="input-group col-xs-12">
                            <select id="cod_rif" name="cod_rif" class="form-control input-group-addon" style="width:25%">
                              <option <?php if($datas['cod_rif'] == "V"){ echo "selected=''";} ?>>V</option>
                              <option <?php if($datas['cod_rif'] == "J"){ echo "selected=''";} ?>>J</option>
                              <option <?php if($datas['cod_rif'] == "G"){ echo "selected=''";} ?>>G</option>
                              <option <?php if($datas['cod_rif'] == "E"){ echo "selected=''";} ?>>E</option>
                            </select>  
                            <input type="text" style="width:75%" class="form-control" value="<?php echo $datas['rif']; ?>" id="rif" maxlength="12" name="rif" placeholder="Numero Rif">
                      </div>
                      <span id="error_rif" class="errors"></span>
                    </div>
                    

                    <div class="form-group  col-sm-4">
                      <label for="fechaNacimiento">Fecha Nacimiento</label>
                      <input type="date" max="<?php echo date("Y-m-d") ?>" value="<?php echo $datas['fecha_nacimiento'] ?>" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                      <span id="error_fechaNacimiento" class="errors"></span>
                    </div>

                  </div>

                  <div class="row">
                    
                    <div class="form-group col-sm-6">
                      <label for="telefono">Nº de Telefono</label>
                      <div class="input-group col-xs-12">
                          <select id="cod_tlfn" name="cod_tlfn" class="form-control input-group-addon" style="width:25%">
                              <option <?php if($cod_tlfn == "0412"){ echo "selected=''";} ?>>0412</option>
                              <option <?php if($cod_tlfn == "0414"){ echo "selected=''";} ?>>0414</option>
                              <option <?php if($cod_tlfn == "0424"){ echo "selected=''";} ?>>0424</option>
                              <option <?php if($cod_tlfn == "0416"){ echo "selected=''";} ?>>0416</option>
                              <option <?php if($cod_tlfn == "0426"){ echo "selected=''";} ?>>0426</option>
                              <option <?php if($cod_tlfn == "0251"){ echo "selected=''";} ?>>0251</option>
                            </select>  
                          <input type="text" style="width:75%" maxlength="7" value="<?php echo $numtelefono; ?>" minlength="7" class="form-control" id="telefono" name="telefono" maxlength="9" placeholder="Numero de telefono">
                      </div>
                      <span id="error_telefono" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="telefono2">Nº de Telefono 2 <small>(Opcional)</small></label>
                      <div class="input-group col-xs-12">
                          <select id="cod_tlfn2" name="cod_tlfn2" class="form-control input-group-addon" style="width:25%">
                              <option <?php if($cod_tlfn2 == "0412"){ echo "selected=''";} ?>>0412</option>
                              <option <?php if($cod_tlfn2 == "0414"){ echo "selected=''";} ?>>0414</option>
                              <option <?php if($cod_tlfn2 == "0424"){ echo "selected=''";} ?>>0424</option>
                              <option <?php if($cod_tlfn2 == "0416"){ echo "selected=''";} ?>>0416</option>
                              <option <?php if($cod_tlfn2 == "0426"){ echo "selected=''";} ?>>0426</option>
                              <option <?php if($cod_tlfn2 == "0251"){ echo "selected=''";} ?>>0251</option>
                            </select>  
                          <input type="text" style="width:75%" value="<?php echo $numtelefono2; ?>" class="form-control" id="telefono2" name="telefono2" placeholder="Numero de telefono 2">
                      </div>
                      <span id="error_telefono" class="errors"></span>
                    </div>
                    
                  </div>
                  <div class="row">

                    <div class="form-group col-sm-6">
                      <label for="correo">Correo Electronico</label>
                      <input type="email" class="form-control" id="correo" value="<?php echo $datas['correo']; ?>" name="correo" placeholder="Correo electronico">
                      <input type="hidden" class="correoOp">
                      <span id="error_correo" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="Sexo">Sexo</label>
                      <div style="clear:both;"></div>
                      <div class="input-group" style="margin-left:2%;float:left;">
                        <label for="masculino">Masculino</label>
                        <input type="radio" class="sexoOp" id="masculino" <?php if($datas['sexo'] == "Masculino"){ echo "checked=''"; } ?> name="sexoOp" value="Masculino" style="margin-left:5px;">
                      </div>
                      <div class="input-group" style="margin-left:8%;float:left;">
                          <label for="femenino">Femenino</label>
                          <input type="radio" class="sexoOp" id="femenino" <?php if($datas['sexo'] == "Femenino"){ echo "checked=''"; } ?> name="sexoOp" value="Femenino" style="margin-left:5px;">
                      </div>
                      <input type="hidden" name="sexo" id="sexo" value="<?php echo $datas['sexo'] ?>">
                      <div style="clear:both;"></div>
                      <span id="error_sexo" class="errors"></span>
                    </div>

                  </div>


                  <hr>
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label for="lider">Lider Distruibor(a)</label>
                      <select class="form-control select2" id="lider" name="lider">
                        <option value="-1">Seleccione un Lider</option>
                        <option <?php if(0 == $datas['id_lider']){ echo "selected"; } ?> value="0">Ningun(a) Lider</option>
                            <?php 
                            foreach ($lideress as $lideres) {
                              if(!empty($lideres['id_cliente'])){
                            ?>
                        <option <?php if($lideres['id_cliente'] == $datas['id_lider']){ echo "selected"; } ?> value="<?php echo $lideres['id_cliente'] ?>"><?php echo $lideres['primer_nombre']." ".$lideres['primer_apellido']." ".$lideres['cedula']; ?></option>
                            <?php 
                              }
                            }
                            ?>
                      </select>
                      <input type="hidden" class="correoOp">
                      <span id="error_lider" class="errors"></span>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="direccion">Direccion Fisica de RIF</label>
                      <textarea class="form-control" id="direccion" name="direccion" placeholder="Direccion Fisica de Documento RIF" maxlength="200" style="height:60px;max-height:60px;min-height:60px;width:100%;min-width:100%;max-width:100%;"><?php echo $datas['direccion'] ?></textarea>
                      <span id="error_direccion" class="errors"></span>
                    </div> 
                  </div>


                  <?php if($editarFotos==1){ ?>
                  <hr>
                  
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="fotos">Foto de perfil</label>
                      <input type="file" class="form-control" id="fotos" name="fotos">
                      <span id="error_fotos" class="errors"><b>Nota: </b> Si desea dejar la misma foto de perfil, <b>No</b> seleccione una foto nueva</span>
                    </div>

                  </div>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-4 col-md-3">
                      <img style="width:100%;" src="<?=$usuario['fotoPerfil']; ?>">
                    </div>
                  </div>
                  
                  <hr>

                  <?php } ?>
                
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
<?php if(!empty($_GET['aux'])): ?>
<input type="hidden" class="aux" value="<?php echo $_GET['aux']; ?>">
<?php else: ?>
<input type="hidden" class="aux" value="0">
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
        var aux = $(".aux").val();
        if(aux == 0){
          window.location = "?route=Clientes";
        }else{
          window.location = "?route=Clientes&action=Detalles&id="+aux;
        }

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
                    url: '?route=Clientes&action=Modificar',
                    type: 'POST',
                    data: {
                      validarData: true,
                      cedula: $("#cedulahidden").val(),
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
    }
  });



  // $("#sexo").val("");
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
  

  /*===================================================================*/

  /*===================================================================*/
  var lider = $("#lider").val();
  var rlider = false;
  if(lider >= 0){
    rlider = true;
    $("#error_lider").html("");
  }else{
    $("#error_lider").html("Debe seleccionar un(a) Lider");
    rlider = false;
  }

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
  var fotos = $("#fotos").val();
  // var rfotos = checkInput(direccion, alfanumericPattern2);
  // if( rdireccion == false ){
  //   if(direccion.length != 0){
  //     $("#error_direccion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
  //   }else{
  //     $("#error_direccion").html("Debe llenar la direccion de vivienda - misma direccion del documento RIF");      
  //   }
  // }else{
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre1==true && rnombre2==true && rapellido1==true && rapellido2==true && rcedula==true && rfechaNacimiento==true && rrif == true && rtelefono == true && rcorreo == true && rsexo == true && rlider==true && rdireccion == true){
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
