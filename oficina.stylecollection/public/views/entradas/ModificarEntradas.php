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
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
          <?php if($amInventarioC==1){ ?>
            <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo ?></a></div>
          <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">



        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-6">
                       <label for="codigo_mercancia">Nombre</label>
                       <input type="hidden" id="id_mercancia" value="<?=$mercancia['id_mercancia'] ?>" name="id_mercancia">
                       <input type="text" class="form-control" id="codigo_mercancia" value="<?=$mercancia['codigo_mercancia'] ?>" name="codigo_mercancia" maxlength="150" placeholder="Ingresar nombre del mercancia">
                       <span id="error_codigo_mercancia" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                       <label for="nombre_mercancia">Nombre</label>
                       <input type="text" class="form-control" id="nombre_mercancia" value="<?=$mercancia['mercancia'] ?>" name="nombre_mercancia" maxlength="150" placeholder="Ingresar nombre del mercancia">
                       <span id="error_nombre_mercancia" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                       <label for="medidas_mercancia">Unidad de medida</label>
                       <input type="text" class="form-control" id="medidas_mercancia" value="<?=$mercancia['medidas_mercancia'] ?>" name="medidas_mercancia" maxlength="20" placeholder="Medida del mercancia. (400ml, 50g, 2lts)">
                       <span id="error_medidas_mercancia" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="marca_mercancia">Marca</label>
                      <input type="text" class="form-control" id="marca_mercancia" value="<?=$mercancia['marca_mercancia'] ?>" name="marca_mercancia" maxlength="150" placeholder="Ingresar la marca del mercancia">
                      <span id="error_marca_mercancia" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="tam_mercancia">Tamaño</label>
                      <input type="text" class="form-control" id="tam_mercancia" value="<?=$mercancia['tam_mercancia'] ?>" name="tam_mercancia" maxlength="150" placeholder="Ingresar el tamaño del mercancia">
                      <span id="error_tam_mercancia" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-6">
                      <label for="color_mercancia">Color</label>
                      <input type="color" class="form-control" id="color_mercancia" value="<?=$mercancia['color_mercancia'] ?>" name="color_mercancia" maxlength="150" placeholder="Ingresar color del mercancia">
                      <span id="error_color_mercancia" class="errors"></span>
                    </div>
                    

                    <div class="form-group col-sm-12">
                      <label for="descripcion_mercancia">Descripcion del mercancia</label>
                      <textarea class="form-control" id="descripcion_mercancia" name="descripcion_mercancia" placeholder="Descripcion del mercancia" maxlength="200" style="height:60px;max-height:60px;min-height:60px;width:100%;min-width:100%;max-width:100%;"><?php echo $mercancia['descripcion_mercancia'] ?></textarea>
                      <span id="error_descripcion_mercancia" class="errors"></span>
                    </div> 
                    
                  </div>
                  
                  <div class="row">
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
                <a style="margin-left:5%" href="?route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>

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
        window.location = "?route=Mercancia";
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
            var id_mercancia = $("#id_mercancia").val();
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                  validarData: true,
                  id_mercancia: id_mercancia,
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

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre_mercancia = $("#nombre_mercancia").val();
  var rnombre_mercancia = checkInput(nombre_mercancia, alfanumericPattern2);
  if( rnombre_mercancia == false ){
    if(nombre_mercancia.length != 0){
      $("#error_nombre_mercancia").html("El nombre de la mercancia solo debe contener numeros o letras");
    }else{
      $("#error_nombre_mercancia").html("Debe llenar el campo de nombre de la mercancia");      
    }
  }else{
    $("#error_nombre_mercancia").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var codigo_mercancia = $("#codigo_mercancia").val();
  var rcodigo_mercancia = checkInput(codigo_mercancia, alfanumericPattern);
  if( rcodigo_mercancia == false ){
    if(codigo_mercancia.length != 0){
      $("#error_codigo_mercancia").html("El codigo de la mercancia solo debe contener numeros o letras");
    }else{
      $("#error_codigo_mercancia").html("Debe llenar el campo de codigo de la mercancia ");      
    }
  }else{
    $("#error_codigo_mercancia").html("");
  }
  /*===================================================================*/
  /*===================================================================*/
  var medidas_mercancia = $("#medidas_mercancia").val();
  var rmedidas_mercancia = checkInput(medidas_mercancia, alfanumericPattern);
  if( rmedidas_mercancia == false ){
    if(medidas_mercancia.length != 0){
      $("#error_medidas_mercancia").html("La medidas de mercancia no debe contener caracteres especiales");
    }else{
      $("#error_medidas_mercancia").html("Debe llenar una medidas para la mercancia");      
    }
  }else{
    $("#error_medidas_mercancia").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var marca_mercancia = $("#marca_mercancia").val();
  var rmarca_mercancia = checkInput(marca_mercancia, alfanumericPattern2);
  if( rmarca_mercancia == false ){
    if(marca_mercancia.length != 0){
      $("#error_marca_mercancia").html("La marca de la mercancia solo debe contener numeros o letras");
    }else{
      $("#error_marca_mercancia").html("Debe llenar el campo de marca de la mercancia");
    }
  }else{
    $("#error_marca_mercancia").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var tam_mercancia = $("#tam_mercancia").val();
  var rtam_mercancia = checkInput(tam_mercancia, alfanumericPattern2);
  if( rtam_mercancia == false ){
    if(tam_mercancia.length != 0){
      $("#error_tam_mercancia").html("El tamaño de la mercancia solo debe contener numeros o letras");
    }else{
      $("#error_tam_mercancia").html("Debe llenar el campo de tamaño de mercancia");      
    }
  }else{
    $("#error_tam_mercancia").html("");
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var descripcion = $("#descripcion_mercancia").val();
  var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  if( rdescripcion == false ){
    if(descripcion.length != 0){
      $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
    }else{
      $("#error_descripcion").html("Debe llenar la descripcion de la mercancia");      
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
  // if( rnombre_mercancia==true && rcantidad==true && rprecio==true && rdescripcion==true && rfragancias==true){
  if( rnombre_mercancia==true && rcodigo_mercancia==true && rmedidas_mercancia==true && rmarca_mercancia==true && rtam_mercancia==true && rdescripcion==true){
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
