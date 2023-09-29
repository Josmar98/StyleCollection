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
              <h3 class="box-title">Editar Nuevas <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="linea">Línea de Productos</label>
                      <input type="text" class="form-control" id="linea" name="linea" value="<?=$linea['nombre_linea'] ?>" maxlength="150" placeholder="Línea de productos">
                      <span id="error_linea" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="posicion">Posición de Línea de Productos</label>
                      <input type="number" class="form-control" id="posicion" name="posicion" value="<?=$linea['posicion_linea']; ?>" placeholder="Orden de la Línea de productos">
                      <span id="error_posicion" class="errors"></span>
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
        window.location = "?route=Lineas";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Línea repetida!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Lineas&action=Registrar";
      });
    }
  }
  
  $(".productos").click(function(){
    var val = $(this).val();
    var id = $(this).attr("id");
    if($(this).is(":checked")){
      $("."+id).attr("style","border-bottom:1px solid #CCC;padding-top:5px;background:#4AC;");
    }else{
      $("."+id).attr("style","border-bottom:1px solid #CCC;padding-top:5px;background:;");
    }
  });

    
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
  var linea = $("#linea").val();
  var rlinea = checkInput(linea, alfanumericPattern3);
  if( rlinea == false ){
    if(linea.length != 0){
      $("#error_linea").html("La línea del producto no debe contener numeros o caracteres especiales");
    }else{
      $("#error_linea").html("Debe llenar el campo de línea del producto ");      
    }
  }else{
    $("#error_linea").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var posicion = $("#posicion").val();
  var rposicion = checkInput(posicion, numberPattern);
  if( rposicion == false ){
    if(posicion.length != 0){
      $("#error_posicion").html("La posicion solo debe contener numeros");
    }else{
      $("#error_posicion").html("Debe llenar el campo de posicion para la línea de productos");      
    }
  }else{
    $("#error_posicion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  // if( rnombre_producto==true && rcantidad==true && rprecio==true && rdescripcion==true && rfragancias==true){
  // if( rnombre_producto==true && rcantidad==true && rdescripcion==true && rfragancias==true){
  if( rlinea==true &&  rposicion==true){
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
