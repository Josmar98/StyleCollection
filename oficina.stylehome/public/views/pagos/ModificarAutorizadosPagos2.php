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
        <?php echo "".$modulo; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?=$url ?>"><?=$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $rut ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                  <form action="" method="post" role="form" class="form_register_autorizado">
                    <div class="box-body">
                      <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="lider">Seleccione al Lider</label>
                          <select class="form-control select2 lider" id="lider" name="lider" style="width:100%;">
                            <option value="<?=$pago['id_pedido']; ?>"><?=$pago['primer_nombre']." ".$pago['primer_apellido']." ".$pago['cedula']; ?></option>
                          </select>
                           <span id="error_lider" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="fechaPago">Fecha de Pago</label>
                           <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']; ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d'); ?>">
                           <span id="error_fechaPago" class="errors"></span>
                        </div>
                      </div>

                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" step="0.01" value="<?=$pago['equivalente_pago']; ?>" class="form-control equivalente montoDinero" id="equivalente" class="equivalente" name="equivalente">
                            </div>
                             <span id="error_equivalente" class="errors"></span>
                          </div>
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="serial">Observacion Pago Autorizado</label>
                             <input type="text" class="form-control" value="<?=$pago['referencia_pago']; ?>" id="serial" name="serial">
                             <span id="error_serial" class="errors"></span>
                          </div>
                      </div>
                    </div>
                      
                  </form>
                </div>
            </div>
            <div class="box-footer">
              <span type="submit" class="btn btn-default enviar color-button-sweetalert">Enviar</span>
              <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
            </div>

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
  alert("asd");
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
        window.location.href="?<?=$menu; ?>&route=Pagos<?=$aux; ?>";
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
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro Repetido!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        var menu = "?<?=$menu; ?>&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
  }

  $(".montoDinero").focusin(function(){
    $(this).val("");
  });
  $(".montoDinero").focusout(function(){
    var x = $(this).val();
    if(x==""){
      $(this).val("0.00");
    }
    else if(x==0){
      $(this).val("0.00");
    }else {
      // alert('asd');
    }
  });

  $(".enviar").click(function(){
    var response = false;
    response = validarFormDivisasDolares();
    var btn = "btn-enviar";
    if(response == true){
      $(".btn-enviar").attr("disabled");

       swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){
            $(".form_register_autorizado").submit();
            // $("."+btn).removeAttr("disabled");
            // $("."+btn).click();
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

function validarFormDivisasDolares(){
  // alert(id);
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var lider = $("#lider").val();
  var rlider = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( lider.length != "" ){
    $("#error_lider").html("");
    rlider = true;
  }else{
    rlider = false;
    $("#error_lider").html("Debe seleccionar al lider con pedido");
  }

  var fechaPago = $("#fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("#error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("#error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var serial = $("#serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("#error_serial").html("La observacion del pago solo acepta numero y Letras");
    }else{
      $("#error_serial").html("Debe llenar el campo de Observacion");      
    }
  }else{
    $("#error_serial").html("");
  }

  var equivalente = $("#equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("#error_equivalente").html("");
    requivalente = true;
  }else{
    $("#error_equivalente").html("Debe cargar monto equivalente al pago");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rlider==true && rfechaPago==true && rserial==true && requivalente==true){
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
