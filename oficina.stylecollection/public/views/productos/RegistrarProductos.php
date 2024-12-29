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
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
          <?php if($amProductosC==1){ ?>
            <div style="width:100%;text-align:center;"><a href="?route=<?=$url; ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo; ?></a></div>
          <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?=$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    
                    <div class="form-group col-sm-6">
                      <label for="codigo_producto">Codigo #</label>
                      <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" maxlength="150" placeholder="Ingresar codigo del producto">
                      <span id="error_codigo_producto" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="nombre_producto">Nombre</label>
                      <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" maxlength="150" placeholder="Ingresar nombre del producto">
                      <span id="error_nombre_producto" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="cantidad">Unidad de medida</label>
                      <input type="text" class="form-control" id="cantidad" name="cantidad" maxlength="20" placeholder="Medida del producto. (400ml, 50g, 2lts)">
                      <span id="error_cantidad" class="errors"></span>
                    </div>
                    
                    <div class="form-group col-sm-6">
                      <label for="marca_producto">Marca</label>
                      <input type="text" class="form-control" id="marca_producto" name="marca_producto" maxlength="150" placeholder="Ingresar la marca del producto">
                      <span id="error_marca_producto" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="color_producto">Color</label>
                      <input type="color" class="form-control" id="color_producto" name="color_producto" maxlength="150" placeholder="Ingresar color del producto">
                      <span id="error_color_producto" class="errors"></span>
                    </div>

                    <!-- <div class="form-group col-sm-6">
                      <label for="fecha_vencimiento">Fecha de vencimient</label>
                      <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                      <span id="error_fecha_vencimiento" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="num_lote">N° de Lote</label>
                      <input type="text" class="form-control" id="num_lote" name="num_lote" maxlength="150" placeholder="Ingresar el numero de lote del producto">
                      <span id="error_num_lote" class="errors"></span>
                    </div> -->

                    <!-- <div class="form-group col-sm-4">
                       <label for="precio">Precio</label>
                       <div class="input-group">
                         <span class="input-group-addon">$</span> 
                         <input type="text" class="form-control" id="precio" name="precio" maxlength="30" placeholder="Precio del producto">
                        </div>
                        <span id="error_precio" class="errors"></span>
                      </div> -->
                      <div class="form-group col-sm-6">
                        <label for="descripcion">Descripcion del producto</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del producto" maxlength="200" style="height:60px;max-height:60px;min-height:60px;width:100%;min-width:100%;max-width:100%;"></textarea>
                        <span id="error_descripcion" class="errors"></span>
                      </div> 
                  </div>
                  
                  
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

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
        window.location = "?route=Productos";
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
            var nombre_producto = $("#nombre_producto").val();
            var codigo_producto = $("#codigo_producto").val();
            var cantidad = $("#cantidad").val();
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                  validarData: true,
                  nombre_producto: nombre_producto,
                  codigo_producto: codigo_producto,
                  cantidad: cantidad,
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
  var nombre_producto = $("#nombre_producto").val();
  var rnombre_producto = checkInput(nombre_producto, alfanumericPattern2);
  if( rnombre_producto == false ){
    if(nombre_producto.length != 0){
      $("#error_nombre_producto").html("El nombre del producto solo debe contener numeros o letras");
    }else{
      $("#error_nombre_producto").html("Debe llenar el campo de nombre del producto ");      
    }
  }else{
    $("#error_nombre_producto").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var codigo_producto = $("#codigo_producto").val();
  var rcodigo_producto = checkInput(codigo_producto, alfanumericPattern);
  if( rcodigo_producto == false ){
    if(codigo_producto.length != 0){
      $("#error_codigo_producto").html("El codigo del producto solo debe contener numeros o letras");
    }else{
      $("#error_codigo_producto").html("Debe llenar el campo de codigo del producto ");      
    }
  }else{
    $("#error_codigo_producto").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, alfanumericPattern);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de producto no debe contener caracteres especiales");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad para el producto");      
    }
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var marca_producto = $("#marca_producto").val();
  var rmarca_producto = checkInput(marca_producto, alfanumericPattern2);
  if( rmarca_producto == false ){
    if(marca_producto.length != 0){
      $("#error_marca_producto").html("La marca del producto solo debe contener numeros o letras");
    }else{
      $("#error_marca_producto").html("Debe llenar el campo de marca del producto ");      
    }
  }else{
    $("#error_marca_producto").html("");
  }
  /*===================================================================*/


  /*===================================================================*/
  var descripcion = $("#descripcion").val();
  var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  if( rdescripcion == false ){
    if(descripcion.length != 0){
      $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
    }else{
      $("#error_descripcion").html("Debe llenar la descripcion del producto");      
    }
  }else{
    $("#error_descripcion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // var fragancias = $("#fragancias").val();
  // var rfragancias = false;
  // if(fragancias == ""){
  //   rfragancias = false;
  //   $("#error_fragancias").html("Debe seleccionar las fragancias para el producto");
  // }else{
  //   rfragancias = true;
  //   $("#error_fragancias").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  // if( rnombre_producto==true && rcantidad==true && rprecio==true && rdescripcion==true && rfragancias==true){
  if( rnombre_producto==true && rcodigo_producto==true && rcantidad==true && rmarca_producto==true && rdescripcion==true){
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
