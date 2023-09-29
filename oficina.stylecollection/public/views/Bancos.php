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
        <small><?php echo "Ver ".$url; ?></small>
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
        <div class="col-sm-12 col-md-7 ">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <!-- data-page-length='5' paginatorAlwaysVisible="true" rowsPerPageTemplate="5,10,15" -->
              <table id="datatable"  class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Bancos</th>
                  <th>Propietario</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($bancos as $data){
                if(!empty($data['id_banco'])){
                  $proceder = false;
                  if(
                    $_SESSION['nombre_rol']=="Superusuario"
                    || $_SESSION['nombre_rol']=="Administrador"
                    || $_SESSION['nombre_rol']=="administrativo"
                    || $_SESSION['nombre_rol']=="Asistente Bancario"
                    // || $_SESSION['nombre_rol']=="Analista Supervisor"
                  ){
                    $proceder = true;
                  }else{
                    if($data['disponibilidad']=="Habilitado"){
                      $proceder = true;
                    }
                  }
                  if($proceder==true){
                ?>
                <tr>
                    <td style="width:5%">
                      <a href="?route=<?=$url?>&action=Detalles&id=<?=$data['id_banco']?>">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                      </a>
                    </td>
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <td style="width:10%">
                    <!-- <table style="background:none;text-align:center;width:100%"> -->
                      <!-- <tr> -->
                        <?php if ($amBancosE==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&operation=Modificar&id=<?php echo $data['id_banco'] ?>">
                            <span class="fa fa-wrench"></span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                        <?php if ($amBancosB==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_banco'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                      <!-- </tr> -->
                    <!-- </table> -->
                  </td>
                  <?php endif ?>
                  

                    <td style="width:20%">
                      <a href="?route=<?=$url?>&action=Detalles&id=<?=$data['id_banco']?>">
                      <span class="contenido2">
                      <?php echo $data['nombre_banco']; ?>
                      <br>
                      <small>(C. <?=$data['tipo_cuenta'];?>)</small>
                      </span>
                      </a>
                    </td>


                    <td style="width:20%">
                      <a href="?route=<?=$url?>&action=Detalles&id=<?=$data['id_banco']?>">
                      <span class="contenido2">
                      <?php echo $data['nombre_propietario']; ?>
                      <br>
                      <small>(<?=$data['disponibilidad']?>)</small>
                      </span>
                      </a>
                    </td>
                  
                </tr>
                <?php
                  }
            } }
          ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if ($amBancosE==1||$amBancosB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Bancos</th>
                  <th>Propietario</th>
                </tr>
                </tfoot>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <?php if(($amBancosE==1&&!empty($_GET['operation'])) || $amBancosR==1 && empty($_GET['operation'])): ?>
        <div class="col-sm-12 col-md-5">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <?php
                if(empty($_GET['operation'])){ 
                  echo "Agregar ".$url.""; 
                }else{ 
                  echo "Modificar ".$url."";
                }
              ?>
                
              </h3>
            </div>
            <!-- /.box-header -->

            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <?php if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){ ?>
                        <div class="form-group">
                          <label for="banco">Nombre del Banco</label>
                          <input type="text" class="form-control" id="banco" value="<?php echo $datas['nombre_banco'] ?>" name="banco" placeholder="Ingresar nombre del banco">

                           <span id="error_banco" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="codigo_banco">Codigo del Banco</label>
                          <input type="text" class="form-control" maxlength="4" id="codigo_banco" value="<?php echo $datas['codigo_banco'] ?>" name="codigo_banco" placeholder="Ingresar el codigo del banco">
                           <span id="error_codigo_banco" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="disponibilidad">Disponibilidad de Banco</label>
                          <select id="disponibilidad" name="disponibilidad" class="form-control">
                            <option <?php if($datas['disponibilidad']=="Habilitado"){ echo "selected='1'"; } ?>>Habilitado</option>
                            <option <?php if($datas['disponibilidad']=="Deshabilitado"){ echo "selected='1'"; } ?>>Deshabilitado</option>
                          </select>
                           <span id="error_disponibilidad" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="opcion_pago">Opcion de Pago</label>
                          <select id="opcion_pago" name="opcion_pago" class="form-control">
                            <option <?php if($datas['opcion_pago']=="Ambos"){ echo "selected='1'"; } ?>>Ambos</option>
                            <option <?php if($datas['opcion_pago']=="Transferencia"){ echo "selected='1'"; } ?>>Transferencia</option>
                            <option <?php if($datas['opcion_pago']=="Pago Movil"){ echo "selected='1'"; } ?>>Pago Movil</option>
                            <option <?php if($datas['opcion_pago']=="Divisas"){ echo "selected='1'"; } ?>>Divisas</option>
                          </select>
                           <span id="error_tipo_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="tipo_cuenta">Tipo de Cuenta</label>
                          <select id="tipo_cuenta" name="tipo_cuenta" class="form-control">
                            <option <?php if($datas['tipo_cuenta']=="Corriente"){ echo "selected='1'"; } ?>>Corriente</option>
                            <option <?php if($datas['tipo_cuenta']=="Ahorro"){ echo "selected='1'"; } ?>>Ahorro</option>
                            <option <?php if($datas['tipo_cuenta']=="Divisas"){ echo "selected='1'"; } ?>>Divisas</option>
                          </select>
                          <!-- <input type="text" class="form-control" maxlength="4" id="tipo_cuenta" value="<?php echo $datas['tipo_cuenta'] ?>" name="tipo_cuenta" placeholder="Ingresar el codigo del banco"> -->
                           <span id="error_tipo_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="numero_cuenta">Numero de Cuenta</label>
                          <input type="text" class="form-control" id="numero_cuenta" value="<?php echo $datas['numero_cuenta'] ?>" name="numero_cuenta" placeholder="Ingresar el numero de cuenta">
                           <span id="error_numero_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="nombre_propietario">Nombre y Apellido</label>
                          <input type="text" class="form-control" id="nombre_propietario" value="<?php echo $datas['nombre_propietario'] ?>" name="nombre_propietario" placeholder="Ingresar nombre y apellido del propietario">
                           <span id="error_nombre_propietario" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="cedula_cuenta">Cedula de Propietario</label>
                          <input type="text" class="form-control" id="cedula_cuenta" value="<?php echo $datas['cedula_cuenta'] ?>" name="cedula_cuenta" placeholder="Ingresar cedula del propietario">
                           <span id="error_cedula_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="telefono_cuenta">Teléfono del Propietario</label>
                          <input type="text" class="form-control" id="telefono_cuenta" value="<?php echo $datas['telefono_cuenta'] ?>" name="telefono_cuenta" placeholder="Ingresar Teléfono del propietario">
                           <span id="error_telefono_cuenta" class="errors"></span>
                        </div>


                      <?php }else{ ?>
                        

                        <div class="form-group">
                          <label for="banco">Nombre del Banco</label>
                          <input type="text" class="form-control" id="banco" name="banco" placeholder="Ingresar nombre del banco">
                           <span id="error_banco" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="codigo_banco">Codigo del Banco</label>
                          <input type="text" class="form-control" maxlength="4" id="codigo_banco" name="codigo_banco" placeholder="Ingresar el codigo del banco">
                           <span id="error_codigo_banco" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="disponibilidad">Disponibilidad de Banco</label>
                          <select id="disponibilidad" name="disponibilidad" class="form-control">
                            <option>Habilitado</option>
                            <option>Deshabilitado</option>
                          </select>
                           <span id="error_disponibilidad" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="opcion_pago">Opcion de Pago</label>
                          <select id="opcion_pago" name="opcion_pago" class="form-control">
                            <option>Ambos</option>
                            <option>Transferencia</option>
                            <option>Pago Movil</option>
                            <option>Divisas</option>
                          </select>
                           <span id="error_tipo_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="tipo_cuenta">Tipo de Cuenta</label>
                          <select id="tipo_cuenta" name="tipo_cuenta" class="form-control">
                            <option>Corriente</option>
                            <option>Ahorro</option>
                            <option>Divisas</option>
                          </select>
                          <!-- <input type="text" class="form-control" maxlength="4" id="tipo_cuenta" value="<?php echo $datas['tipo_cuenta'] ?>" name="tipo_cuenta" placeholder="Ingresar el codigo del banco"> -->
                           <span id="error_tipo_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="numero_cuenta">Numero de Cuenta</label>
                          <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" placeholder="Ingresar el numero de cuenta">
                           <span id="error_numero_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="nombre_propietario">Nombre y Apellido</label>
                          <input type="text" class="form-control" id="nombre_propietario" name="nombre_propietario" placeholder="Ingresar nombre y apellido del propietario">
                           <span id="error_nombre_propietario" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="cedula_cuenta">Cedula de Propietario</label>
                          <input type="text" class="form-control" id="cedula_cuenta" name="cedula_cuenta" placeholder="Ingresar cedula del propietario">
                           <span id="error_cedula_cuenta" class="errors"></span>
                        </div>

                        <div class="form-group">
                          <label for="telefono_cuenta">Teléfono del Propietario</label>
                          <input type="text" class="form-control" id="telefono_cuenta" name="telefono_cuenta" placeholder="Ingresar Teléfono del propietario">
                           <span id="error_telefono_cuenta" class="errors"></span>
                        </div>


                      <?php } ?>
                    </div>
                  </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <?php if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){ ?>

                <a style="margin-left:5%" href="?route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>
                <?php } ?>

                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php endif ?>

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
  var rcedula_cuenta = checkInput(cedula_cuenta, alfanumericPattern);
  if( rcedula_cuenta == false ){
    if(cedula_cuenta.length != 0){
      $("#error_cedula_cuenta").html("La cedula del propietario solo debe contener numeros");
    }else{
      $("#error_cedula_cuenta").html("Debe llenar la cedula del propietario de la cuenta");      
    }
  }else{
    $("#error_cedula_cuenta").html("");
  }


  //     var telefono_cuenta = $("#telefono_cuenta").val();
  // var rtelefono_cuenta = checkInput(telefono_cuenta, numberPattern);
  // if( rtelefono_cuenta == false ){
  //   if(telefono_cuenta.length != 0){
  //     $("#error_telefono_cuenta").html("El teléfono del propietario solo debe contener numeros");
  //   }else{
  //     $("#error_telefono_cuenta").html("Debe llenar el teléfono del propietario de la cuenta");      
  //   }
  // }else{
  //   $("#error_telefono_cuenta").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  // if( rbanco==true && rcodigo_banco==true && rnumero_cuenta==true && rnombre_propietario==true && rcedula_cuenta==true && rtelefono_cuenta==true){
  if( rbanco==true && rcodigo_banco==true && rnumero_cuenta==true && rnombre_propietario==true && rcedula_cuenta==true){
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
