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
        <?php echo "Gemas"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Gemas autorizadas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo "Gemas autorizadas"; ?>"><?php echo "Gemas autorizadas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Gemas autorizadas"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Gemas autorizadas"; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Gemas autorizadas"; ?></h3>
            </div>
           
              
              <form action="" method="post" role="form" class="form_register">
                <div class="box-body">
                    <div class="row">
                      <div class="form-group col-xs-12 col-md-6">
                         <label for="clientes">lideres</label>
                         <select class="form-control select2 clientes" style="width:100%" name="clientes" id="clientes">
                            <?php foreach ($lideres as $data): if (!empty($data['id_cliente'])): ?>
                              <?php if($obsequio['id_cliente']==$data['id_cliente']): ?>
                              <option value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']?></option>
                              <?php endif; ?>
                            <?php endif; endforeach; ?>
                         </select>
                         <span id="error_clientes" class="errors"></span>
                      </div>
                      
                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="cantidad_gemas">Cantidad de Gemas</label>
                         <input type="number" class="form-control cantidad_gemas" min="0" value="<?=$obsequio['cantidad_gemas']; ?>" id="cantidad_gemas" name="cantidad_gemas">
                         <span id="error_cantidad_gemas" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">

                      <div class="form-group col-xs-12 col-sm-12">
                         <label for="descripcion">Descripción</label>
                          <input type="text" class="form-control descripcion" value="<?=$obsequio['descripcion_gemas'];?>" maxlength="100" id="descripcion" name="descripcion">
                         <span id="error_descripcion" class="errors"></span>
                      </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  
                  <span type="submit" class="btn enviar2 enviar">Enviar</span>
                  <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                  <button class="btn-enviar d-none" disabled=""  >enviar</button>
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
        window.location = "?<?=$menu?>&route=ObsequiosGemas";
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
          title: '¡Registro repetido!',
          confirmButtonColor: "#ED2A77",
      });
    }
    
  }

  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviarsegundoform").attr("disabled");

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
              $(".btn-enviar").click()
              
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
});

function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var clientes = $("#clientes").val();
  var rclientes = checkInput(clientes, numberPattern);
  if( clientes==0 ){
    $("#error_clientes").html("Debe seleccionar un Líder");      
    rclientes = false;
  }else if( clientes > 0 ){
    $("#error_clientes").html("");
    rclientes = true;
  }
  /*===================================================================*/
  var gemas = $("#cantidad_gemas").val();
  var rgemas = checkInput(clientes, numberPattern);

  if( gemas==0 ){
    $("#error_cantidad_gemas").html("Debe llenar una cantidad de gemas");      
    rgemas = false;
  }else if( gemas > 0 ){
    $("#error_cantidad_gemas").html("");
    rgemas = true;
  }else{
    $("#error_cantidad_gemas").html("Debe tener una cantidad de gemas mayor a 0");
    rgemas = false;
  }

  /*===================================================================*/
  var result = false;
  if( rclientes==true && rgemas==true){
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
