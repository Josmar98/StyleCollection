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
        <?php echo "Promoción de Campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Promoción"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " Promoción de Campaña"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Promoción"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Promoción de campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Promoción de campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="nombre">Nombre de promoción</label>
                      <input type="text" class="form-control nombre" name="nombre" maxlength="40" id="nombre">
                      <span id="error_nombre" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="precio">Precio de promoción</label>
                      <div class="input-group">
                        <span class="input-group-addon">$</span>                      
                        <input type="number" class="form-control precio" name="precio" id="precio">
                      </div>
                      <span id="error_precio" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12">
                      <hr>
                    </div>

                    <div class="form-group col-xs-12">
                       <label for="productos">Productos para conformar la promoción</label>
                       <select class="form-control select2" id="productos" name="productos[]" multiple="multiple">
                        <option value=""></option>
                        <?php 
                          foreach ($productos as $data) {
                            if(!empty($data['id_producto'])){
                              ?>
                              <option value="<?php echo "Producto-".$data['id_producto'] ?>">Producto: <?php echo $data['producto']." (<small>".$data['cantidad']."</small>)"; ?></option>
                              <?php
                            }
                          }
                          foreach ($premios as $data) {
                            if(!empty($data['id_premio'])){
                              ?>
                              <option value="<?php echo "Premio-".$data['id_premio'] ?>">Premio: <?php echo $data['nombre_premio']; ?></option>
                              <?php
                            }
                          }
                        ?>
                       </select>
                       <span id="error_productos" class="errors"></span>
                    </div>

                    <!-- <div class="form-group col-xs-12 col-sm-6">
                       <label for="fechaA">Fecha apertura de selección de promoción</label>
                        <input type="date" class="form-control fechaA" name="fechaA" id="fechaA">
                       <span id="error_fechaA" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fechaC">Fecha limite de selección de promoción</label>
                        <input type="date" class="form-control fechaC" name="fechaC" id="fechaC">
                       <span id="error_fechaC" class="errors"></span>
                    </div> -->
                    <div class="form-group col-xs-12">
                      <hr>
                    </div>
                    
                    <div class="form-group col-xs-12">
                       <label for="premios">Premios de ganancia de la promoción</label>
                       <select class="form-control select2" id="premios" name="premios[]" multiple="multiple">
                        <option value=""></option>
                        <?php 
                          foreach ($productos as $data) {
                            if(!empty($data['id_producto'])){
                              ?>
                              <option value="<?php echo "Producto-".$data['id_producto'] ?>">Producto: <?php echo $data['producto']." (<small>".$data['cantidad']."</small>)"; ?></option>
                              <?php
                            }
                          }
                          foreach ($premios as $data) {
                            if(!empty($data['id_premio'])){
                              ?>
                              <option value="<?php echo "Premio-".$data['id_premio'] ?>">Premio: <?php echo $data['nombre_premio']; ?></option>
                              <?php
                            }
                          }
                        ?>
                       </select>
                       <span id="error_premios" class="errors"></span>
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PromocionCamp";
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
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      nombre: $("#nombre").val(),
                      precio: $("#precio").val(),
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
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern2);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre no debe contener caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el nombre de la promoción");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/
  var precio = $("#precio").val();
  var rprecio = checkInput(precio, numberPattern2);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precio").html("EL precio solo debe contener numeros");
    }else{
      $("#error_precio").html("Debe llenar el precio de la promoción");      
    }
  }else{
    $("#error_precio").html("");
  }
  /*===================================================================*/
  var productos = $("#productos").val();
  // alert(productos);
  var rproductos = false;
  if(productos == ""){
    rproductos = false;
    $("#error_productos").html("Debe seleccionar los productos de la promoción");
  }else{
    rproductos = true;
    $("#error_productos").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var premios = $("#premios").val();
  // alert(premios);
  var rpremios = false;
  if(premios == ""){
    rpremios = false;
    $("#error_premios").html("Debe seleccionar los premios para la promoción");
  }else{
    rpremios = true;
    $("#error_premios").html("");
  }
  /*===================================================================*/



  /*===================================================================*/
  var result = false;
  if( rnombre==true && rprecio==true && rproductos==true && rpremios==true){
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
