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
        <small><?php if(!empty($nameaccion)){echo $nameaccion;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?=$url; ?>"><?=$url; ?></a></li>
        <li class="active"><?php if(!empty($nameaccion)){echo $nameaccion;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?=$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <input type="hidden" id="route" value="<?=$_GET['route']; ?>">
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="numero_factura">Numero de factura</label>
                       <input type="number" class="form-control" id="numero_factura" value="<?=$venta['numero_factura'] ?>" name="numero_factura" placeholder="Ingresar nombre de liderazgo" readonly>

                       <input type="hidden" class="form-control" id="id_factura_despacho" name="id_factura_despacho" value="<?php echo $venta['id_factura_despacho'] ?>" placeholder="Ingresar nombre de liderazgo">
                       <span id="error_numero_factura" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="monto">Monto de la Venta (Base Imponible)</label>
                      <input type="number" name="monto" value="<?=$venta['totalVenta']; ?>" id="monto" class="form-control">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="control1">Numero de control #1 (<small>En talonario</small>)</label>
                       <input type="number" class="form-control" id="control1" name="control1" value="<?=$venta['numero_control1']; ?>">
                       <span id="error_control1" class="errors"></span>
                    </div>
                    
                    <div class="form-group col-sm-6">
                       <label for="control2">Numero de control #2 (<small>En talonario</small>)</label>
                       <input type="number" class="form-control" id="control2" name="control2" value="<?=$venta['numero_control2']; ?>">
                       <span id="error_control2" class="errors"></span>
                    </div>
                  </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <a style="margin-left:5%" href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>
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
<input type="hidden" id="ruta" value="<?=$ruta; ?>">
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
        window.location = "?route=Liderazgos";
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
                id_factura_despacho: $("#id_factura_despacho").val(),
                monto: $("#monto").val(),
                control1: $("#control1").val(),
                control2: $("#control2").val(),
              },
              success: function(respuesta){
                // alert(respuesta);
                if (respuesta == "1"){
                  swal.fire({
                    type: 'success',
                    title: '¡Datos guardados correctamente!',
                    confirmButtonColor: "#ED2A77",
                  }).then(function(){
                    var route = $("#route").val();
                    var ruta = $("#ruta").val();
                    var url = "?route="+route+"&action=ComprasVentas"+ruta;
                    window.location.href=url;
                  });
                }
                if (respuesta == "9"){
                  swal.fire({
                    type: 'error',
                    title: '¡No se ha encontrado el registro!',
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
  var monto = $("#monto").val();
  var rmonto = checkInput(monto, numberPattern2);
  if(rmonto == false){ 
    if( monto.length  > 1 ){
        $("#error_monto").html("EL monto solo debe tener numeros");      
    }else{
        $("#error_monto").html("Debe llenar un monto para la factura");
    }
  }else{
      $("#error_monto").html("");
  }

  /*===================================================================*/

  /*===================================================================*/
  var control1 = $("#control1").val();
  var rcontrol1 = checkInput(control1, numberPattern);
  if(rcontrol1 == false){ 
    if( control1.length  > 0 ){
      $("#error_control1").html("EL numero de control solo debe tener numeros");
    }else{
      $("#error_control1").html("Debe ingresar el numero de control acorde al talonario");
    }
  }else{
    $("#error_control1").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var control2 = $("#control2").val();
  var rcontrol2 = checkInput(control2, numberPattern);
  if(rcontrol2 == false){ 
    if( control2.length  > 0 ){
      $("#error_control2").html("EL numero de control solo debe tener numeros");
    }else{
      $("#error_control2").html("Debe ingresar el numero de control acorde al talonario");
    }
  }else{
    $("#error_control2").html("");
  }
  /*===================================================================*/


  /*===================================================================*/
  var result = false;
  if( rmonto==true && rcontrol1==true && rcontrol2==true ){
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
