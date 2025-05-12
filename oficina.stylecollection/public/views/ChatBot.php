<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- <body class=""> -->
<div class="wrapper">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <h1>
        <?php echo "Inicio"; ?>
        <!-- <small><?php echo "Ver Campañas"; ?></small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li class="active"><?php echo $url; ?></li>
      </ol>
    </section>
    
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>

        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <!-- <input type="color" value="#EA018C"> -->

            <div class="box-header">
              <h3 class="box-title"><?php echo "Chatbot"; ?></h3>
            </div>
            <!-- /.box-header -->
            <form action="" method="post">
                <div class="box-body">
                    
                    <div class="row">
                    
                        <div class="form-group col-xs-12">
                            <label for="mensaje">Mensaje para enviar por Stela</label>
                            <textarea type="text" class="form-control" id="mensaje" name="mensaje" maxlength="150" placeholder="Ingresar Mensaje de parte de Stela"></textarea>
                            <span id="error_mensaje" class="errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                
                    <span type="submit" class="btn enviar">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                    <button class="btn-enviar d-none" disabled="" >enviar</button>
                </div>
            </form>

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                    <th>Nº</th>
                    <th>Texto del Mensaje</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $num = 1;
                        foreach ($chats as $data){
                            if(!empty($data['id_mensaje'])){
                                ?>
                                <tr>
                                <td style="width:10%">
                                    <span class="contenido2">
                                    <?php echo $num++; ?>
                                    </span>
                                </td>
                                <td style="width:90%">
                                    <span class="contenido2">
                                        <?php echo $data['texto_mensaje']; ?>
                                    </span>
                                </td>                  
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Nº</th>
                    <th>Texto del Mensaje</th>
                </tr>
                </tfoot>
              </table>

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
<input type="hidden" id="tiempoActualDeEjecucion" value="<?=time();?>">
<input type="hidden" id="tiempoLimiteDeEjecucion" value="<?=$_SESSION['timeLimiteSystem'];?>">

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
  console.clear();
  var timeLimit = $("#tiempoLimiteDeEjecucion").val();


    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
        type: 'success',
        title: '¡Mensaje Enviado correctamente!',
        confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=ChatBot";
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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
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

  /*===================================================================*/
    var mensaje = $("#mensaje").val();
    // var rmensaje = checkInput(mensaje, alfanumericPattern3);
    var rmensaje = false;
    if(mensaje.length == 0){
        rmensaje=false;
        $("#error_mensaje").html("Debe llenar el mensaje para enviar");
    }else{
        if(mensaje.length>0){
            rmensaje=true;
            // $("#error_mensaje").html("Algunos caracteres especiales no son aceptados");
            $("#error_mensaje").html("");
        }
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
  // if( rnombre_producto==true && rcantidad==true && rprecio==true && rdescripcion==true && rfragancias==true){
  if( rmensaje==true){
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
