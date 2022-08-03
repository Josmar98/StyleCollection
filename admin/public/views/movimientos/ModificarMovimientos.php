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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Home </a></li>
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
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="banco">Nombre de Banco</label>
                       <select class="form-control select2" id="banco" name="banco">
                          <option value="<?php echo $banco['id_banco'] ?>"><?php echo $banco['nombre_banco']." (<smal>".$banco['nombre_propietario']." "."</small>) <small>Cuenta ".$banco['tipo_cuenta']."</small>" ?></option>
                       </select>
                       <span id="error_banco" class="errors"></span>
                    </div>
               
                    <div class="form-group col-sm-6">
                      <label for="fecha">Fecha</label>
                      <input type="date" max="<?php echo date('Y-m-d') ?>" value="<?php echo $datas['fecha_movimiento']?>" class="form-control" id="fecha" name="fecha">
                      <!-- <input type="hidden" name="max_anterior" id="maxima_anterior"> -->
                      <span id="error_fecha" class="errors"></span>
                    </div>
                  </div>
                  

                  <div class="row">
                    <div class="form-group  col-sm-6">
                      <label for="movimiento">Numero de Movimiento</label>
                      <input type="text" min="0" step="1" value="<?php echo $datas['num_movimiento'] ?>" class="form-control" id="movimiento" name="movimiento" placeholder="Cantidad maxima de colecciones">
                      <span id="error_movimiento" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="monto">Monto</label>
                      <input type="number" min="0" step="0.01" value="<?php echo $datas['monto_movimiento'] ?>" class="form-control" id="monto" name="monto" placeholder="Descuento de cada coleccion">
                      <span id="error_monto" class="errors"></span>
                    </div>
                  </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>

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
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var menu = "?route=Movimientoss";
        window.location.href=menu;
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

  // $("#descuento_coleccion").keyup(function(){
  //   var max = parseFloat($(".max_total_descuento").val());
  //   var descuento = parseFloat($(this).val());
  //   var total = (max+descuento).toFixed(2);
  //   $("#total_descuento").val(total);
  // });
  $(".enviar").click(function(){
    var response = validarLiderazgos();

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
              // var campaing = $(".campaing").val();
              // var n = $(".n").val();
              // var y = $(".y").val();
              // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=LiderazgosCamp";
              // $.ajax({
                    // url: '',
                    // type: 'POST',
                    // data: {
                      // validarData: true,
                      // movimiento: $("#movimiento").val(),
                    // },
                    // success: function(respuesta){
                      // alert(respuesta);
                      // if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                      // }
                      // if (respuesta == "9"){
                        // swal.fire({
                            // type: 'error',
                            // title: '¡Los datos ingresados estan repetidos!',
                            // confirmButtonColor: "#ED2A77",
                        // });
                      // }
                      // if (respuesta == "5"){ 
                        // swal.fire({
                            // type: 'error',
                            // title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            // confirmButtonColor: "#ED2A77",
                        // });
                      // }
                    // }
                // });
              
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
function validarLiderazgos(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var banco = $("#banco").val();
  var rbanco = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( banco.length  != 0 ){
      $("#error_banco").html("");
      rbanco = true;
    }else{
      rbanco = false;
      $("#error_banco").html("Debe llenar el campo de banco");
    }
  /*===================================================================*/

  /*===================================================================*/
  var fecha = $("#fecha").val();
  var rfecha = false;
  if(fecha.length != 0){
    // $("#error_inicial").html("El nombre del producto no debe contener numeros o caracteres especiales");
    $("#error_fecha").html("");
    rfecha = true;
  }else{
    rfecha = false;
    $("#error_fecha").html("Debe seleccionar una fecha del movimiento bancario");  
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var mov = $("#movimiento").val();
  var rmov = checkInput(mov, numberPattern);

  if(mov.length > 0){
    rmov = true;
    // if(mov.length >= 6 && mov.length <= 15 ){
    //   $("#error_movimiento").html("");    
    //   rmov = true;
    // }else{
    //   $("#error_movimiento").html("Un movimiento bancario valido debe tener entre 6 y 15 digitos");
    //   rmov = false;
    // }
  }else{
    rmov = false;
    $("#error_movimiento").html("Debe llenar un numero de movimiento bancario");    
  }
  /*===================================================================*/
    // if(maxima==""){    
    //     $("#error_maximo").html("Debe llenar el campo para la cantidad maxima de colecciones");
    //     rmaxima = false;
    // }else{
    //   if(maxima==0){
    //       $("#error_maximo").html("<span style='color:#0B0'><b><small>Numero indefinido de colecciones</small></b></span>");
    //       rmaxima = false;
    //   }else{
    //     if(parseInt(maxima) > parseInt(minima)){
    //       $("#error_maximo").html("");
    //       rmaxima = true;
    //     }else{
    //     }
    //   }
    // }

  /*===================================================================*/
  var monto = $("#monto").val();
  var rmonto = checkInput(monto, numberPattern);

  if(monto.length > 0){
    $("#error_montoimiento").html("");    
    rmonto = true;
  }else{
    rmonto = false;
    $("#error_monto").html("Debe llenar un numero de movimiento bancario");    
  }
  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if( rbanco==true && rfecha==true && rmov==true && rmonto==true){
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
