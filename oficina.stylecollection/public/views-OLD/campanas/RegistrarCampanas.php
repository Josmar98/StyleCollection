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
        <?php echo "Campañas"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Campañas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Campañas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Campañas"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Campañas" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nueva <?php echo "Campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-6">
                       <label for="nombre_campana">Nombre de Campaña</label>
                       <input type="text" class="form-control" id="nombre_campana" name="nombre_campana" maxlength="80" placeholder="Ingresar nombre de la campaña">
                       <span id="error_nombre_campana" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="num_campana">Numero de campaña</label>
                       <input type="number" min="1" max="10" step="0.1" class="form-control" id="num_campana" name="num_campana" placeholder="Numero de campaña">
                       <span id="error_num_campana" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-3">
                       <label for="anio">Año de la campaña</label>
                       <input type="number" class="form-control" id="anio" minlength="4" maxlength="4" min="2020" value="<?php echo date("Y") ?>" name="anio" maxlength="30" placeholder="Año de la campaña">
                       <span id="error_anio" class="errors"></span>
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
        window.location = "?route=Campanas";
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
                      nombre_campana: $("#nombre_campana").val(),
                      numero_campana: $("#num_campana").val(),
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

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre_campana = $("#nombre_campana").val();
  var rnombre_campana = checkInput(nombre_campana, textPattern2);
  if( rnombre_campana == false ){
    if(nombre_campana.length != 0){
      $("#error_nombre_campana").html("El nombre de la campaña no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre_campana").html("Debe llenar el nombre de campaña ");      
    }
  }else{
    $("#error_nombre_campana").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var num_campana = $("#num_campana").val();
  var rnum_campana = checkInput(num_campana, numberPattern2);
  if( rnum_campana == false ){
    if(num_campana.length != 0){
      $("#error_num_campana").html("EL numero de campana solo debe contener numeros");
    }else{
      $("#error_num_campana").html("Debe llenar un numero de campaña");      
    }
  }else{
    $("#error_num_campana").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var anio = $("#anio").val();
  var ranio = checkInput(anio, numberPattern);
  if( ranio == false ){
    if(anio.length != 0){
      $("#error_anio").html("El Año solo debe contener numeros");
    }else{
      $("#error_anio").html("Debe llenar el Año de la campaña");      
    }
  }else{
    $("#error_anio").html("");
  }
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre_campana==true && rnum_campana==true && ranio==true){
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
