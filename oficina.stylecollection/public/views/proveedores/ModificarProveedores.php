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
        <li><a href="?route=<?=$url; ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <input type="hidden" id="route" value="<?=$_GET['route']; ?>">
        <input type="hidden" id="action" value="<?=$_GET['action']; ?>">

        <!-- left column -->
        <div class="col-sm-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo; ?> </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-xs-12 col-sm-6">
                     <label for="rif">R.I.F</label>
                     <div class="input-group" style="width:100%;">
                       <select class="input-group-addon form-control" id="codRif" name="codRif" style="width:20%;">
                         <option <?php if($proveedor['codRif']=="V"){ echo "selected"; } ?>>V</option>
                         <option <?php if($proveedor['codRif']=="J"){ echo "selected"; } ?>>J</option>
                         <option <?php if($proveedor['codRif']=="G"){ echo "selected"; } ?>>G</option>
                         <option <?php if($proveedor['codRif']=="E"){ echo "selected"; } ?>>E</option>
                       </select>
                       <input type="text" class="form-control" maxlength="10" style="width:80%;" id="rif" value="<?=$proveedor['rif']; ?>" name="rif" placeholder="12345678-9">
                     </div>
                     <span id="error_rif" class="errors"></span>
                  </div>
                  <div class="form-group col-xs-12 col-sm-6">
                     <label for="nombre">Nombre o razón social del Proveedor</label>
                     <input type="text" class="form-control" id="nombre" name="nombre" value="<?=$proveedor['nombreProveedor']; ?>" placeholder="Nombre de proveedor">
                     <span id="error_nombre" class="errors"></span>
                  </div>
                </div>

              </div>
              <div class="box-footer">
                <span class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>  
              <hr>
              
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
<input type="hidden" class="responses" value="<?=$response; ?>">
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
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var route = '<?=$_GET['route']; ?>';
        window.location = `?route=${route}`;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      });
    }
  }

  $(".enviar").click(function(){
    var response = validar();
    var route = '<?=$_GET['route']; ?>';
    var action = '<?=$_GET['action']; ?>';
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
            url: `?route=${route}&action=${action}`,
            type: 'POST',
            data: {
              validarData: true,
              codRif: $("#codRif").val(),
              rif: $("#rif").val(),
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

});


function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var rif = $("#rif").val();
  var rrif = checkInput(rif, numberPattern);
  if(rrif == false){ 
    if( rif.length > 1 ){
      $("#error_rif").html("EL Rif no debe tener numeros ni caracteres especiales");      
    }else{
      $("#error_rif").html("Debe llenar el numero del Rif");
    }
  }else{
    if( rif.length > 6 ){
      rrif=true;
      $("#error_rif").html("");
    }else{
      rrif=false;
      $("#error_rif").html("Debe llenar el numero del Rif");
    }
  }

  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern3);
  if(rnombre == false){ 
    if( nombre.length > 3 ){
        $("#error_nombre").html("EL nombre parece contener algun caracter no permitido");      
    }else{
        $("#error_nombre").html("Debe llenar el nombre de proveedor");
    }
  }else{
      $("#error_nombre").html("");
  }
  /*===================================================================*/


  
  /*===================================================================*/
  var result = false;
  if( rrif==true && rnombre==true ){
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
