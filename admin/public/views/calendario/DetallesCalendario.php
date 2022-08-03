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

<?php 
$amBancosB = 0;
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $url; ?>
        <small><?php echo $action." ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" style="text-decoration-line:underline;color:#04a7c9">Registrar Fragancia</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12 col-md-10 ">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
                <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                  <i class="fa fa-arrow-left" style="font-size:2em"></i>
                </a>
              <h3 class="box-title"><?php echo $action." ".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php

            ?>
            <div class="box-body" style="padding: 0% 2%">
              <!-- data-page-length='5' paginatorAlwaysVisible="true" rowsPerPageTemplate="5,10,15" -->
              <?php if(count($tasas)>1){ ?>
              <div class="row">
                <div class="col-xs-12">
                  <h3>
                    <div style="margin-top:10px;margin-bottom:10px;">
                      EL precio de la tasa del <b>Dolar</b>
                    <span style="margin-top:10px;margin-bottom:10px;color:#0B0;"><b>$<?=$tasa['monto_tasa']?></b></span>
                      el <?=$diaTasa?> de <?=$mesTasa?> del <?=$yearTasa?>
                    </div>
                      
                  </h3>               
                </div>
              </div>
              <?php } ?>

              <?php if(count($festividades)>1){ ?>
              <div class="row">
                <div class="col-xs-12">
                  <h3>
                    <div style="margin-top:10px;margin-bottom:10px;">
                      El <?=$festividad['dia_calendario']?> de <?=$mes?> del <?=$festividad['year_calendario']?>
                    </div>
                    <div style="margin-top:10px;margin-bottom:10px;">
                      Cae Dia <?=$festividad['diaSemana']?> <?=$festividad['tipo_festividad']?>
                        "<i><b><?=$festividad['nombre_festividad']?></b></i>"
                    </div>
                      
                  </h3>               
                </div>
              </div>
              <?php } ?>
              <br>
              <br>
              <br>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <!-- /.col -->
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
<?php if(!empty($response2)): ?>
<input type="hidden" class="responses2" value="<?php echo $response2 ?>">
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
        window.location = "?route=Bancos";
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
  var response2 = $(".responses2").val();
  if(response2==undefined){

  }else{
    if(response2 == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Bancos";
      });
    }
    if(response2 == "2"){
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
          closeOnCancel: false, 
      }).then((isConfirm) => {
          if (isConfirm.value){
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      banco: $("#banco").val(),
                      numero_cuenta: $("#numero_cuenta").val(),
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
    
    }


  });

  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            window.location = $(this).val();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });



  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#ED2A77",
                    confirmButtonText: "¡Si!",
                    cancelButtonText: "No", 
                    closeOnConfirm: false,
                    closeOnCancel: false 
                }).then((isConfirm) => {
                    if (isConfirm.value){                      
                        window.location = $(this).val();
                    }else { 
                        swal.fire({
                            type: 'error',
                            title: '¡Proceso cancelado!',
                            confirmButtonColor: "#ED2A77",
                        });
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
  });



});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var banco = $("#banco").val();
  var rbanco = checkInput(banco, alfanumericPattern);
  if( rbanco == false ){
    if(banco.length != 0){
      $("#error_banco").html("El nombre del banco no debe contener numeros o caracteres especiales");
    }else{
      $("#error_banco").html("Debe llenar el campo del banco");      
    }
  }else{
    $("#error_banco").html("");
  }

  var codigo_banco = $("#codigo_banco").val();
  var rcodigo_banco = checkInput(codigo_banco, numberPattern);
  if( rcodigo_banco == false ){
    if(codigo_banco.length != 0){
      $("#error_codigo_banco").html("El codigo del banco solo debe contener numeros");
    }else{
      $("#error_codigo_banco").html("Debe llenar el campo del codigo del banco");      
    }
  }else{
    $("#error_codigo_banco").html("");
  }

  var numero_cuenta = $("#numero_cuenta").val();
  var rnumero_cuenta = checkInput(numero_cuenta, numberPattern);
  if( rnumero_cuenta == false ){
    if(numero_cuenta.length != 0){
      $("#error_numero_cuenta").html("El numero de cuenta solo debe contener numeros");
    }else{
      $("#error_numero_cuenta").html("Debe llenar el campo del numero de cuenta");      
    }
  }else{
    $("#error_numero_cuenta").html("");
  }

  var nombre_propietario = $("#nombre_propietario").val();
  var rnombre_propietario = checkInput(nombre_propietario, alfanumericPatternName);
  if( rnombre_propietario == false ){
    if(nombre_propietario.length != 0){
      $("#error_nombre_propietario").html("El nombre del propietario no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre_propietario").html("Debe llenar el nombre y apellido del propietario de la cuenta");      
    }
  }else{
    $("#error_nombre_propietario").html("");
  }

    var cedula_cuenta = $("#cedula_cuenta").val();
  var rcedula_cuenta = checkInput(cedula_cuenta, numberPattern);
  if( rcedula_cuenta == false ){
    if(cedula_cuenta.length != 0){
      $("#error_cedula_cuenta").html("La cedula del propietario solo debe contener numeros");
    }else{
      $("#error_cedula_cuenta").html("Debe llenar la cedula del propietario de la cuenta");      
    }
  }else{
    $("#error_cedula_cuenta").html("");
  }


      var telefono_cuenta = $("#telefono_cuenta").val();
  var rtelefono_cuenta = checkInput(telefono_cuenta, numberPattern);
  if( rtelefono_cuenta == false ){
    if(telefono_cuenta.length != 0){
      $("#error_telefono_cuenta").html("El teléfono del propietario solo debe contener numeros");
    }else{
      $("#error_telefono_cuenta").html("Debe llenar el teléfono del propietario de la cuenta");      
    }
  }else{
    $("#error_telefono_cuenta").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rbanco==true && rcodigo_banco==true && rnumero_cuenta==true && rnombre_propietario==true && rcedula_cuenta==true && rtelefono_cuenta==true){
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
