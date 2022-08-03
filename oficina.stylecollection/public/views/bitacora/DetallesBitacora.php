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
        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $action." ".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body" style="padding: 0% 2%">
              <!-- data-page-length='5' paginatorAlwaysVisible="true" rowsPerPageTemplate="5,10,15" -->
                <?php 
                if($bitacora['elementos'] != "") {
                  // echo strlen($bitacora['elementos']);
                  $elementos = json_decode($bitacora['elementos'], true);
                  $nombre = $elementos['Nombres'];
                  $actual = $elementos['Actual'];
                  $anterior = $elementos['Anterior'];
                ?>
                  <div class="row">
                    <div class="col-xs-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Nombres</th>
                            <th>Anterior</th>
                            <th>Actual</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $index = 0; 
                            for ($i=0; $i < count($actual); $i++) { ?>
                              <tr>
                                <td>
                                  <?php 
                                    if(!empty($nombre[$i])){
                                      echo $nombre[$i]; 
                                    }
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if(!empty($anterior[$i])){
                                      echo $anterior[$i]; 
                                    }
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if(!empty($actual[$i])){
                                      if(!empty($anterior[$i])){
                                        if($actual[$i]!==$anterior[$i]){?>
                                          <span style="color:green">
                                            <?php echo $actual[$i]; ?>
                                          </span>
                                         
                                  <?php }else{
                                          echo $actual[$i]; 
                                        }
                                      }else{
                                        echo $actual[$i]; 
                                      }
                                    }
                                  ?>
                                </td>
                              </tr>


                            <?php } ?>
                        </tbody>
                      </table>
                      <br>
                      <a href="?route=Bitacora" class="btn enviar">Volver</a>
                      <br>
                    </div>
                  </div>
                <?php } else { ?>
                  <h3>No hay Elementos</h3>

                  <br>
                  <br>
                  <a href="?route=Bitacora" class="btn enviar">Volver</a>
                  <br>
                <?php } ?>
              
              <br>
             <!--  <table id="datatable"  class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Bancos</th>
                  <th>Propietario</th>
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  // print_r($clientes);
                  foreach ($bancos as $data):
                    if(!empty($data['id_banco'])):  
                ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                    <?php echo $data['nombre_banco']; ?>
                    </span>
                  </td>

                  <td style="width:20%">
                    <span class="contenido2">
                    <?php echo $data['nombre_propietario']; ?>
                    </span>
                  </td>
                  
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <td style="width:10%">
                    <table style="background:none;text-align:center;width:100%">
                      <tr>
                        <?php if ($amBancosE==1): ?>
                        <td style="width:50%">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&operation=Modificar&id=<?php echo $data['id_banco'] ?>">
                            <span class="fa fa-wrench"></span>
                          </button>
                        </td>
                        <?php endif; ?>
                        <?php if ($amBancosB==1): ?>
                        <td style="width:50%">
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_banco'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        </td>
                        <?php endif; ?>
                      </tr>
                    </table>
                  </td>
                  <?php endif ?>
                      
                      
                </tr>
                <?php
                    endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Bancos</th>
                  <th>Propietario</th>
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                </tr>
                </tfoot>
              </table> -->

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
