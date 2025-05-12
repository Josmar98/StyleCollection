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
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-6">
                       <label for="fecha">Fecha</label>
                       <input type="date" class="form-control" value="<?=date("Y-m-d") ?>" max="<?=date("Y-m-d") ?>" id="fecha" name="fecha" maxlength="30">
                       <span id="error_fecha" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <?php
                        $fechaActual=date("Y-m-d");
                        $horaActual=date("H:i:s");
                        $tasaActual = $lider->consultarQuery("SELECT * FROM eficoin WHERE fecha_tasa='{$fechaActual}'");
                        // $horaActual="14:00:01";
                        $selected1="";
                        $selected2="";
                        if($horaActual>="07:00:00" && $horaActual<="13:59:00"){
                          if(count($tasaActual)>1){
                            $tasaActual=$tasaActual[0];
                            if($tasaActual['monto_tasa']==0){
                              $selected1="selected";
                            }
                            if($tasaActual['monto_tasa']!=0){
                              $selected1="disabled='disabled' style='background:#CCC;'";
                            }
                          }else{
                            $selected1="selected";
                          }
                        }
                        if($horaActual>="14:00:00" && $horaActual<="23:59:00"){
                          if(count($tasaActual)>1){
                            $tasaActual=$tasaActual[0];
                            if($tasaActual['monto_tasa_tarde']==0){
                              $selected2="selected";
                            }
                            if($tasaActual['monto_tasa_tarde']!=0){
                              $selected2="disabled='disabled' style='background:#CCC;'";
                            }
                          }else{
                            $selected2="selected";
                          }
                        }
                      ?>
                      <label for="turno">Turno</label>
                      <select class="form-control" name="turno" id="turno">
                        <option value=""></option>
                        <option <?=$selected1; ?> value="1">Mañana</option>
                        <option <?=$selected2; ?> value="2">Tarde</option>
                      </select>
                      <span id="error_turno" class="errors"></span>
                      
                    </div>

                    <div class="form-group col-sm-6">
                       <label for="tasa">Tasa</label>
                       <input type="number" step="0.0001" class="form-control" id="tasa" name="tasa" maxlength="30" placeholder="Precio de la Tasa del dia">
                       <span id="error_tasa" class="errors"></span>
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
        window.location = "?route=Eficoin";
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
                      fecha: $("#fecha").val(),
                      turno: $("#turno").val(),
                      tasa: $("#tasa").val(),
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
  var inicial = $("#fecha").val();
  var rinicial = false;
  if(inicial.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_fecha").html("");
    rinicial = true;
  }else{
    rinicial = false;
    $("#error_fecha").html("Debe seleccionar una fecha"); 
  }   
  /*===================================================================*/

  /*===================================================================*/
  var turno = $("#turno").val();
  var rturno = false;
  if(turno.length != 0){
    // $("#error_turno").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_turno").html("");
    rturno = true;
  }else{
    rturno = false;
    $("#error_turno").html("Debe seleccionar un turno"); 
  }   
  /*===================================================================*/

  /*===================================================================*/
  var precio = $("#tasa").val();
  var rprecio = checkInput(precio, numberPattern3);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_tasa").html("La tasa no debe contener caracteres especiales. solo permite {.}");
    }else{
      $("#error_tasa").html("Debe llenar el campo de precio");      
    }
  }
  else{
    $("#error_tasa").html("");
  }
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rinicial==true && rturno==true && rprecio==true){
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
