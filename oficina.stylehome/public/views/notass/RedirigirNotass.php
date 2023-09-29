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
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      
      <div class="row">

        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Nueva <?php echo $modulo; ?></h3>
            </div>

            <!-- /.box-header -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-sm-12">
                    <label for="ciclo">Seleccionar ciclo</label>
                    <select class="form-control select2" style="width:100%;" id="ciclo" name="ciclo">
                      <option value=""></option>
                      <?php foreach ($cicloNotas as $ciclo){ if(!empty($ciclo['id_ciclo'])){ ?>
                        <option value="<?="?c=".$ciclo['id_ciclo']."&n=".$ciclo['numero_ciclo']."&y=".$ciclo['ano_ciclo']; ?>&route=Notas&action=Registrar" >
                          Ciclo <?=$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']." (".$ciclo['numero_cuota'].") (".$ciclo['fecha_pago_cuota'].")"; ?>
                        </option>
                      <?php } } ?>
                    </select>
                    <span id="error_ciclo" class="errors"></span>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Ir al ciclo</span>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        var menu = "?route=<?=$url; ?>";
        window.location = menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      });
    }
    
  }


  $(".enviar").click(function(){
    var response = validar();
    if(response == true){
      $(".btn-enviar").attr("disabled");
      swal.fire({ 
          title: "¿Desea cargar ser llevado al ciclo seleccionado?",
          text: "Se movera a la interfaz para crear las notas de entrega, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Aceptar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){
            var menu = $("#ciclo").val();
            window.location = menu;
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
    }
  });
});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var ciclo = $("#ciclo").val();
  var rciclo = false;
  // var rciclo = checkInput(ciclo, textPattern);
    if( ciclo.length  != 0 ){
      $("#error_ciclo").html("");
      rciclo = true;
    }else{
      rciclo = false;
      $("#error_ciclo").html("Debe seleccionar un ciclo");
    }
  /*===================================================================*/


  /*===================================================================*/
  var result = false;
  if( rciclo==true ){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}

</script>
</body>
</html>
