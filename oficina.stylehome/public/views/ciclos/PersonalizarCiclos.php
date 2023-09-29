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
              <h3 class="box-title">Agregar Nuevo <?=$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
              <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-sm-12">
                    <label for="ciclo">Seleccionar ciclo</label>
                    <select class="form-control select2" id="ciclo" name="ciclo">
                      <option value=""></option>
                      <?php foreach ($ciclos as $ciclo){ if(!empty($ciclo['id_ciclo'])){ ?>
                        <option <?php if(!empty($_GET['ciclo'])){ if($_GET['ciclo']==$ciclo['id_ciclo']){ echo "selected"; } } ?> value="<?=$ciclo['id_ciclo']; ?>"><?="Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']; ?></option>
                      <?php } } ?>
                    </select>
                    <span id="error_ciclo" class="errors"></span>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar2 enviarciclo color-button-sweetalert" >Cargar Ciclo</span>
                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>
            </form>

            <?php if(!empty($_GET['ciclo'])){ ?>
              <hr>
              <form action="" method="post" role="form" class="formPersonalizado">
                <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label>Seleccionar Cuotas de Entrega de Premios</label>
                      <select class="form-control select2" name="cuotas[]" style="width:100%;" multiple>
                        <?php foreach ($cantidadPagosCiclos as $key){ ?>
                          <?php if($key['numero_cuota'] < $cicloSelect['cantidad_cuotas']){ ?>
                          <option
                            <?php if(count($ciclosPagos)>1){ foreach ($ciclosPagos as $key2){ if(!empty($key2['id_pago_ciclo'])){ if($key['name']==$key2['numero_cuota']){ if(mb_strtolower($key2['opcion_ciclo'])==mb_strtolower("Nota")){ echo "selected"; } } } } } ?>
                           ><?=$key['name']; ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <span type="submit" class="btn enviar2 enviarPersonalizacion">Enviar</span>
                  <button class="btn-enviarPerson d-none" disabled="" >enviar</button>
                </div>
              </form>
            <?php } ?>
            <br><br>
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
        window.location = "?route=<?=$url; ?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  }
    
  $(".enviarciclo").click(function(){
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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
          } 
      });
    } //Fin condicion
  }); // Fin Evento

  $(".enviarPersonalizacion").click(function(){
    // var response = validar();

    //if(response == true){
      $(".btn-enviarPerson").attr("disabled");

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
            // alert('asdd');
            // $(".formPersonalizado").submit();
            $(".btn-enviarPerson").removeAttr("disabled");
            $(".btn-enviarPerson").click();
          } 
      });

    //} //Fin condicion

  }); 
  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var Ciclo = $("#ciclo").val();
  var rCiclo = false;
  // var rCiclo = checkInput(Ciclo, textPattern);
    if( Ciclo.length  != 0 ){
      $("#error_ciclo").html("");
      rCiclo = true;
    }else{
      rCiclo = false;
      $("#error_ciclo").html("Debe seleccionar  el ciclo");
    }
  /*===================================================================*/
  /*===================================================================*/
  var result = false;
  if( rCiclo==true ){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}
function validar2(){
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
