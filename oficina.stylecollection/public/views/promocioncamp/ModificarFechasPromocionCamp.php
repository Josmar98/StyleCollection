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
        <?php echo "Fechas de Promoción"; ?>
        <small><?php if(!empty($action)){echo "Registrar";} echo " Fechas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " Fechas de Promoción"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Modificar ";} echo "Fechas"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=PromocionFechasCamp" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Fechas de Promociones" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Fechas de Promoción"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fechaA">Fecha apertura de selección de promoción</label>
                        <input type="date" class="form-control fechaA" name="fechaA" id="fechaA" value="<?=$fechas['fecha_apertura_promocion']; ?>">
                       <span id="error_fechaA" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fechaC">Fecha limite de selección de promoción</label>
                        <input type="date" class="form-control fechaC" name="fechaC" id="fechaC" value="<?=$fechas['fecha_cierre_promocion']; ?>">
                       <span id="error_fechaC" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12">
                       <label for="fechaPago">Fecha de pago puntual de promoción</label>
                        <input type="date" class="form-control fechaPago" name="fechaPago" id="fechaPago" value="<?=$fechas['fecha_pago_promocion']; ?>">
                       <span id="error_fechaPago" class="errors"></span>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PromocionFechasCamp";
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
  var fechaA = $("#fechaA").val();
  // alert(fechaA);
  var rfechaA = false;
  if(fechaA == ""){
    rfechaA = false;
    $("#error_fechaA").html("Debe seleccionar la fecha de apertura de la promoción");
  }else{
    rfechaA = true;
    $("#error_fechaA").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var fechaC = $("#fechaC").val();
  // alert(fechaC);
  var rfechaC = false;
  if(fechaC == ""){
    rfechaC = false;
    $("#error_fechaC").html("Debe seleccionar la fecha de cierre para la promoción");
  }else{
    rfechaC = true;
    $("#error_fechaC").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var fechaPago = $("#fechaPago").val();
  // alert(fechaPago);
  var rfechaPago = false;
  if(fechaPago == ""){
    rfechaPago = false;
    $("#error_fechaPago").html("Debe seleccionar la fecha de pago puntual para la promoción");
  }else{
    rfechaPago = true;
    $("#error_fechaPago").html("");
  }
  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if( rfechaA==true && rfechaC==true && rfechaPago==true){
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
