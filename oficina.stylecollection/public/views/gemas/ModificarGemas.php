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
        <?php echo $url ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$url; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo $url ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              
              <form action="" method="post" role="form" class="form_register">
                <div class="box-body">
                    <input type="hidden" name="lider" value="<?=$gema['id_cliente']?>">
                    <input type="hidden" name="tipo" value="<?=$gema['id_configgema']?>">

                    <div class="row">

                      <div class="form-group col-xs-12">
                         <label for="clientes">lideres</label>
                         <select class="form-control select2 clientes" style="width:100%;" name="clientes[]" id="clientes" multiple="multiple">
                          <option value="0"></option>
                            <?php foreach ($nuevosClientes as $data): if (!empty($data['id_cliente'])):  ?>
                          <option <?php foreach ($lideresHijos as $hijos): ?>
                              <?php if (!empty($hijos['id_cliente'])): ?>
                                  <?php if ($hijos['id_cliente']==$data['id_cliente']): ?>
                                    selected=''
                                  <?php endif ?>
                              <?php endif ?>
                          <?php endforeach ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']; ?></option>
                            <?php endif; endforeach; ?>
                         </select>
                         <span id="error_clientes" class="errors"></span>
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="cantidad_correspondiente">Gemas correspondientes</label>
                         <div class="input-group">
                           <input type="text" class="form-control cantidad_correspondiente" value="<?=$configuracion['cantidad_correspondiente']?>" id="cantidad_correspondiente" name="cantidad_correspondiente" readonly>
                            <span class="input-group-addon"><?php if($configuracion['cantidad_correspondiente']=="1"){ echo "Gema";}else{ echo "Gemas"; } ?></span>                         
                         </div>
                         <span id="error_cantidad_correspondiente" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6">
                         <label for="cantidad_gemas">Lideres</label>
                         <input type="text" class="form-control cantidad_gemas" value="<?=$gema['cantidad_gemas']?>" id="cantidad_gemas" name="cantidad_gemas" readonly>
                         <span id="error_cantidad_gemas" class="errors"></span>
                      </div>
                      
                      <input type="hidden" class="condicion" id="condicion" value="<?=$configuracion['condicion']?>">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  
                  <span type="submit" class="btn enviar2 enviarsegundoform">Enviar</span>
                  <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                  <button class="btn-enviarsegundoform d-none" disabled=""  >enviar</button>
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
        window.location = "?<?=$menu?>&route=Gemas";
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
    
  $(".enviarprimerform").click(function(){
    var response = validar();
    if(response == true){
      $(".btn-enviarprimerform").attr("disabled");
      $(".btn-enviarprimerform").removeAttr("disabled");
      $(".btn-enviarprimerform").click();
    } //Fin condicion

  }); // Fin Evento


  $(".enviarsegundoform").click(function(){
    var response = validar2();

    if(response == true){
      $(".btn-enviarsegundoform").attr("disabled");

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
                          $(".btn-enviarsegundoform").removeAttr("disabled");
                          $(".btn-enviarsegundoform").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         // validarData: true,
              //         lider: $("#lideres").val(),
              //         liderazgo: $("#liderazgo").val(),
              //         campana: $("#campana").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
              //             swal.fire({
              //                 type: 'success',
              //                 title: '¡Datos guardados correctamente!',
              //                 confirmButtonColor: "#ED2A77",
              //             }).then(function(){
              //               window.location = "?route=Nombramientos";
              //             });
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Los datos ingresados estan repetidos!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //       }
              //   });
              
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
  $(".clientes").change(function(){
    var clientes = $(this).val();
    var cantidad = clientes.length;
    var cant_corresp = parseFloat($("#cantidad_correspondiente").val());
    var condicion = $("#condicion").val();
    var gemas = 0;
    if(condicion=="Dividir"){
      gemas = cant_corresp / cantidad;
    }
    if(condicion=="Multiplicar"){
      gemas = cant_corresp * cantidad;
    }
    $("#cantidad_gemas").val(gemas);

  });

});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var lider = $("#lideres").val();
  var rlider = false;
  if( lider==0 ){
    $("#error_lideres").html("Debe seleccionar un lider");      
    rlider = false;
  }else if( lider > 0 ){
    $("#error_lideres").html("");
    rlider = true;
  }
  /*===================================================================*/
  var configgema = $("#configgema").val();
  var rconfiggema = false;
  if( configgema==0 ){
    $("#error_configgema").html("Debe seleccionar un tipo de premio de gema");      
    rconfiggema = false;
  }else if( configgema > 0 ){
    $("#error_configgema").html("");
    rconfiggema = true;
  }
  /*===================================================================*/
  
  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern2);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //       $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //     if(cantidad < 1){
  //       $("#error_cantidad").html("La cantidad de gemas debe ser mayor a 0");      
  //     }else{
  //       $("#error_cantidad").html("");
  //       rcantidad = true;
  //     }
  // }

  /*===================================================================*/
  var result = false;
  if( rlider==true && rconfiggema==true){
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
  // var campana = $("#campana").val();
  // var rcampana = false;
  // if( campana==0 ){
  //   $("#error_campana").html("Debe seleccionar un campana");      
  //   rcampana = false;
  // }else if( campana > 0 ){
  //   $("#error_campana").html("");
  //   rcampana = true;
  // }
  /*===================================================================*/
  var clientes = $("#clientes").val();
  // alert(clientes);
  var rclientes = false;
  if( clientes.length==0 ){
    $("#error_clientes").html("Debe seleccionar un tipo de premio de gema");      
    rclientes = false;
  }else if( clientes.length > 0 ){
    $("#error_clientes").html("");
    rclientes = true;
  }
  /*===================================================================*/
  var gemas = $("#cantidad_gemas").val();
  var rgemas = false;
  if(gemas > 0){
    $("#error_cantidad_gemas").html("");
    rgemas = true;
  }else{
    $("#error_cantidad_gemas").html("Debe tener una cantidad de gemas mayor a 0");
    rgemas = false;
  }
  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern2);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //       $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //     if(cantidad < 1){
  //       $("#error_cantidad").html("La cantidad de gemas debe ser mayor a 0");      
  //     }else{
  //       $("#error_cantidad").html("");
  //       rcantidad = true;
  //     }
  // }

  /*===================================================================*/
  var result = false;
  if( rclientes==true && rgemas==true){
  // if( rcampana==true && rclientes==true && rgemas==true){
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
