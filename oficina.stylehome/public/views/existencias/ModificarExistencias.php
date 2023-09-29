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
                      <label for="premio">Premio de Inventario</label>
                      <select class="form-control select2" style="width:100%;" id="premio" name="premio">
                        <!-- <option value=""></option> -->
                        <?php foreach ($existencias as $inv){ if(!empty($inv['cod_inventario'])){ ?>
                        <option value="<?=$inv['cod_inventario']; ?>" selected><?=$inv['nombre_inventario']." ( $".number_format($inv['precio_inventario'],2,',','.')." )"; ?></option>
                        <?php } } ?>
                      </select>
                      <span id="error_premio" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="disponible">Cantidad disponible</label>
                      <input type="number" class="form-control" value="<?=$existencia['cantidad_disponible'] ?>" id="disponible" name="disponible" step="1" placeholder="Ingresar la cantidad disponible en existencia" >
                      <span id="error_disponible" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="total">Cantidad Total de existencia</label>
                      <input type="hidden" value="<?=$existencia['cantidad_total'] ?>" id="totalH" name="totalH">
                      <input type="number" class="form-control" value="<?=$existencia['cantidad_total'] ?>" id="total" name="total" step="1" placeholder="Ingresar la cantidad total de existencia" readonly>
                      <span id="error_total" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="bloqueada">Cantidad bloqueada</label>
                      <input type="number" class="form-control" value="<?=$existencia['cantidad_bloqueada'] ?>" id="bloqueada" name="bloqueada" step="1" placeholder="Ingresar la cantidad bloqueada en existencia" readonly>
                      <span id="error_bloqueada" class="errors"></span>
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
        window.location = "?route=Existencias";
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
                      premio: $("#premio").val(),
                      total: $("#total").val(),
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

  $("#disponible").change(function(){
    var total = parseInt($("#totalH").val());
    var totalt = parseInt($("#total").val());
    var disponible = parseInt($("#disponible").val());
    var bloqueados = parseInt($("#bloqueada").val());
    var cant = parseInt($(this).val());
    if((totalt+cant) >= bloqueados){
      $("#total").val(disponible+bloqueados);
    }else{
      $(this).val(0);
    }
  });
  $("#disponible").keyup(function(){
    var total = parseInt($("#totalH").val());
    var totalt = parseInt($("#total").val());
    var disponible = parseInt($("#disponible").val());
    var bloqueados = parseInt($("#bloqueada").val());
    var cant = parseInt($(this).val());
    if((totalt+cant) >= bloqueados){
      $("#total").val(disponible+bloqueados);
    }else{
      $(this).val(0);
    }
  });
  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var premio = $("#premio").val();
  var rpremio = false;
  // var rnombre = checkInput(nombre, alfanumericPattern2);
  // alert(premio);
  if(premio==""){
    rpremio = false;
    $("#error_premio").html("Debe seleccionar un premio del inventario");      
  }else{
    rpremio = true;
    $("#error_premio").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var total = $("#total").val();
  var rtotal = checkInput(total, numberPattern2);
  if( rtotal == false ){
    if(total.length != 0){
      $("#error_total").html("La cantidad total de existencia del premio solo debe contener numeros");
    }else{
      $("#error_total").html("Debe llenar una cantidad total de existencia para el premio");
    }
  }else{
    $("#error_total").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rpremio==true && rtotal==true){
  // if( rnombre==true && rcodigo==true && rcantidad==true){
  // if( rnombre==true && rcantidad==true){
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
