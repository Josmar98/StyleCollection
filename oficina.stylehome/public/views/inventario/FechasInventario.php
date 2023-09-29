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
                       <label for="apertura">Fecha de apertura</label>
                       <input type="date" class="form-control" id="apertura" name="apertura" <?php if($apertura!=""){ ?> value="<?=$apertura;?>" <?php } ?>>
                       <span id="error_apertura" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="cierre">Fecha de cierre</label>
                       <input type="date" class="form-control" id="cierre" name="cierre" <?php if($cierre!=""){ ?> value="<?=$cierre;?>" <?php } ?>>
                       <span id="error_cierre" class="errors"></span>
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
        window.location = "?route=<?=$url; ?>&action=<?=$_GET['action']; ?>";
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
                      apertura: $("#apertura").val(),
                      cierre: $("#cierre").val(),
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
  var apertura = $("#apertura").val();
  var rapertura = false;
  if(apertura.length == 0){
    $("#error_apertura").html("Debe seleccionar la fecha de apertura del catálogo");      
  }else{
    rapertura = true;
    $("#error_apertura").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cierre = $("#cierre").val();
  var rcierre = false;
  if(cierre.length == 0){
    $("#error_cierre").html("Debe seleccionar la fecha de cierre del catálogo");      
  }else{
    rcierre = true;
    $("#error_cierre").html("");
  }
  /*===================================================================*/
  

  /*===================================================================*/
  var result = false;
  if( rapertura==true && rcierre==true){
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
