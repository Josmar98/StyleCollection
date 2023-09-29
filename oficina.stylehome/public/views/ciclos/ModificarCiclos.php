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
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?=$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="numero">Numero de ciclo</label>
                      <input type="number" step="1" min="1" maxlength="2" max="10" class="form-control" id="numero" name="numero" maxlength="30" placeholder="Numero de campaña" value="<?=$ciclo['numero_ciclo']; ?>">
                      <span id="error_numero" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="ano">Año de ciclo</label>
                      <input type="number" class="form-control" id="ano" minlength="4" maxlength="4" min="2020" value="<?=$ciclo['ano_ciclo']; ?>" name="ano" maxlength="30" placeholder="Año de la campaña">
                      <span id="error_ano" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="apertura">Apertura de selección</label>
                      <input type="date" class="form-control" id="apertura" name="apertura" placeholder="Apertura de selección" value="<?=$ciclo['apertura_seleccion']; ?>">
                      <span id="error_apertura" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="cierre">Cierre de selección</label>
                      <input type="date" class="form-control" id="cierre" name="cierre" placeholder="Cierre de selección" value="<?=$ciclo['cierre_seleccion']; ?>">
                      <span id="error_cierre" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="pago">Pago de ciclo</label>
                      <input type="date" class="form-control" id="pago" name="pago" placeholder="Pago del ciclo" value="<?=$ciclo['pago_inicio']; ?>">
                      <span id="error_pago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="cuotas">Cantidad de Cuotas del ciclo</label>
                      <input type="number" step="1" min="1" class="form-control" id="cuotas" name="cuotas" placeholder="Ej (10)" value="<?=$ciclo['cantidad_cuotas']; ?>">
                      <span id="error_cuotas" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="precio">Precio minimo</label>
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="number" step="0.1" min="1" class="form-control" id="precio" name="precio" placeholder="Precio minimo" value="<?=$ciclo['precio_minimo']; ?>">
                      </div>
                      <span id="error_precio" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="puntos">Puntos por cuotas puntuales</label>
                      <input type="number" step="0.05" min="0" class="form-control" id="puntos" name="puntos" placeholder="Puntos ganados" value="<?=$ciclo['puntos_cuotas']; ?>">
                      <span id="error_puntos" class="errors"></span>
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=Ciclos";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    if(response == "9"){
      swal.fire({
        type: 'error',
        title: '¡Los datos ingresados estan repetidos!',
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
            var numero = $("#numero").val();
            var ano = $("#ano").val();
            // var apertura = $("#apertura").val();
            // var cierre = $("#cierre").val();
            // var pago = $("#pago").val();
            // var cuotas = $("#cuotas").val();
            // var precio = $("#precio").val();
            // var puntos = $("#puntos").val();
            $.ajax({
              url: '',
              type: 'POST',
              data: {
                validarData: true,
                numero_ciclo: numero,
                ano_ciclo: ano,
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
                      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                  });
                }
                if (respuesta == "5"){ 
                  swal.fire({
                      type: 'error',
                      title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                  });
                }
              }
            });
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
  var numero = $("#numero").val();
  var rnumero = checkInput(numero, numberPattern);
  if( rnumero == false ){
    if(numero.length != 0){
      $("#error_numero").html("EL numero del ciclo solo debe contener numeros");
    }else{
      $("#error_numero").html("Debe llenar un numero del ciclo");      
    }
  }else{
    $("#error_numero").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var ano = $("#ano").val();
  var rano = checkInput(ano, numberPattern);
  if( rano == false ){
    if(ano.length != 0){
      $("#error_ano").html("El año solo debe contener numeros");
    }else{
      $("#error_ano").html("Debe llenar el año del ciclo");      
    }
  }else{
    $("#error_ano").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var apertura = $("#apertura").val();
  var rapertura = false;
  if(apertura.length != 0){
    $("#error_apertura").html("");
    rapertura = true;
  }else{
    $("#error_apertura").html("Debe seleccionar la fecha de apertura de selección");
    rapertura = false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var cierre = $("#cierre").val();
  var rcierre = false;
  if(cierre.length != 0){
    $("#error_cierre").html("");
    rcierre = true;
  }else{
    $("#error_cierre").html("Debe seleccionar la fecha de cierre de selección");
    rcierre = false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var pago = $("#pago").val();
  var rpago = false;
  if(pago.length != 0){
    $("#error_pago").html("");
    rpago = true;
  }else{
    $("#error_pago").html("Debe seleccionar la fecha de inicio de pagos del ciclo");
    rpago = false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var cuotas = $("#cuotas").val();
  var rcuotas = checkInput(cuotas, numberPattern);
  if( rcuotas == false ){
    if(cuotas.length != 0){
      $("#error_cuotas").html("El numero de cuotas solo debe contener numeros");
    }else{
      $("#error_cuotas").html("Debe llenar un numero de campaña");      
    }
  }else{
    $("#error_cuotas").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var precio = $("#precio").val();
  var rprecio = checkInput(precio, numberPattern);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precio").html("El precio solo debe incluir numeros");
    }else{
      $("#error_precio").html("Debe llenar el campo de precio minimo");      
    }
  }else{
    $("#error_precio").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var puntos = $("#puntos").val();
  var rpuntos = checkInput(puntos, numberPattern2);
  if( rpuntos == false ){
    if(puntos.length != 0){
      $("#error_puntos").html("La cantidad de puntos solo debe incluir numeros");
    }else{
      $("#error_puntos").html("Debe llenar el campo de puntos por coutas puntuales");      
    }
  }else{
    $("#error_puntos").html("");
  }
  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if(rnumero==true && rano==true && rapertura==true && rcierre==true && rpago==true && rcuotas==true && rprecio==true && rpuntos==true){
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
