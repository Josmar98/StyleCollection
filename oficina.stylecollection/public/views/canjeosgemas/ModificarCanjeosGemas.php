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
        <?php echo "Gemas a Físico"; ?>
        <small><?php if(!empty($action)){echo "Realizar Canjeos a Físico";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Canjeos a Físico"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Realizar ";} echo " Canjeos a Físico"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Canjeos de Gemas a Físico"; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">



        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }

        ?>


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Realizar <?php echo "Canjeos de Gemas a Físico"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
            <form action="" method="post" class="form">
              <div class="box-body ">
                    
                <div class="row">
                  
                  <div class="form-group col-xs-12 col-sm-6">
                     <label for="precioGema">Precio de Gema</label>
                     <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input type="number" class="form-control precioGema" id="precioGema" name="precioGema" value="<?=$canjeo_gema['precio_gema'];?>" readonly>
                     </div>
                     <span id="error_precioGema" class="errors"></span>
                  </div>

                  <div class="form-group col-xs-12 col-sm-6">
                     <label for="disponible">Gemas Disponibles</label>
                     <div class="input-group">
                      <input type="number" class="form-control disponible" id="disponible" name="disponible" value="<?=$gemasAdquiridasDisponiblesCliente-$canjeo_gema['cantidad'];?>" readonly>
                      <input type="hidden" class="form-control disponibleOculto" id="disponibleOculto" name="disponibleOculto" value="<?=$gemasAdquiridasDisponiblesCliente;?>" readonly>
                      <span class="input-group-addon">Gemas</span>
                     </div>
                     <span id="error_disponible" class="errors"></span>
                  </div>

                  <div class="form-group col-xs-12 col-sm-6">
                    <label for="cantidad">Cantidad de Gemas de Canjear</label>
                    <input type="number" class="form-control cantidad" id="cantidad" name="cantidad" value="<?=$canjeo_gema['cantidad']?>">
                    <span id="error_cantidad" class="errors"></span>
                  </div>

                  <div class="form-group col-xs-12 col-sm-6">
                    <label for="total">Gemas correspondientes</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input type="text" class="form-control total" id="total" name="total" value="<?=$canjeo_gema['total']?>" readonly="">
                    </div>
                    <span id="error_total" class="errors"></span>
                  </div>

                </div>   

              </div>
              <div class="box-footer">
                <span type="submit" class="btn enviar">Enviar</span>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">

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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=CanjeosGemas";
        window.location.href=menu;
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
  
  $(".selectLider").change(function(){
    var select = $(this).val();
    // alert(select);
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });


  $(".cantidad").keyup(function(){
    var disponibleOculto = $(".disponibleOculto").val();
    disponibleOculto = parseFloat(disponibleOculto);
    var disponible = $(".disponible").val();
    disponible = parseFloat(disponible);
    var canti = $(this).val();
    var precio = $(".precioGema").val();
    if(canti > disponible){
      $(this).val(disponible);
      canti = $(this).val();
    }
    if(canti < 0){
      $(this).val(0);
      canti = $(this).val();
    }
    if(canti.trim().length == 0){
      canti = 0;
    }
    // alert(disponibleOculto);
    $(".disponible").val(disponibleOculto-canti);
    canti = parseFloat(canti);
    precio = parseFloat(precio);
    var total = canti*precio;
    $(".total").val(total);
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
  var precio = $("#precioGema").val();
  var rprecio = checkInput(precio, numberPattern2);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precioGema").html("El precio de la gema no debe contener caracteres especiales. solo permite {.}");
    }else{
      $("#error_precioGema").html("Se debe cargar el precio de la gema con anterioridad");      
    }
  }
  else{
    $("#error_precioGema").html("");
  }

  /*===================================================================*/

  /*===================================================================*/
  var disponible = $("#disponible").val();
  var rdisponible = checkInput(disponible, numberPattern3);
  if( rdisponible == false ){
    if(disponible.length != 0){
      $("#error_disponible").html("La cantida de gemas no debe contener caracteres especiales. solo permite {.}");
    }else{
      $("#error_disponible").html("Debe tener Gemas disponibles");      
    }
  }
  else{
    $("#error_disponible").html("");
  }
  /*===================================================================*/


  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern2);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de gemas a canjear no debe contener caracteres especiales. solo permite {.}");
    }else{
      $("#error_cantidad").html("Debe llenar la cantidad de gemas para canjear");      
    }
  }
  else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/

   /*===================================================================*/
  var total = $("#total").val();
  var rtotal = checkInput(total, numberPattern3);
  if( rtotal == false ){
    if(total.length != 0){
      $("#error_total").html("El total equivalente a Divisas no debe contener caracteres especiales. solo permite {.}");
    }else{
      $("#error_total").html("Debe llenar el campo de total para conocer cuando corresponde al lider");      
    }
  }
  else{
    $("#error_total").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rprecio==true && rdisponible==true && rcantidad==true && rtotal==true){
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
