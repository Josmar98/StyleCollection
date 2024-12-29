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
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3 ?>route=<?php echo "Homing2" ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
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
          // print_r($accesosEstructuras);

        ?>
        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Solicitar Pedido</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <?php $optAdmin = !empty($_GET['admin']) ? $_GET['admin'] : ""; ?>
                  <input type="hidden" id="optAdmin" value="<?=$optAdmin; ?>">
                  <div class="row">
                      <?php 
                        if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
                      ?>
                    <div class="form-group col-xs-12">
                      <label for="Cliente">Cliente</label>
                      <select class="form-control select2" name="cliente" id="cliente" required="" style="width:100%">
                        <option value="">Seleccione</option>
                        <?php foreach ($clientss as $client) { if($client['id_cliente']){ ?>
                          <?php
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$client['id_cliente']){
                                      ?>
                                      <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                                      <option <?php foreach ($clientesConPedido as $key){ if(!empty($key['id_cliente'])){
                                        if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                        }} ?> value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                      <?php 
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                              ?>
                              <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                              <option <?php foreach ($clientesConPedido as $key){ if(!empty($key['id_cliente'])){
                                if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                }} ?> value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                              <?php
                            }
                          ?>
                        <?php  } } ?>
                      </select>
                      <span id="error_clientes" class="errors"></span>
                    </div>
                      <?php } ?>
                    <div class="form-group col-xs-12">
                      <label for="cantidad">Cantidad (Coleccion: Productos)</label>
                      <input type="number" class="form-control cantidadesT" data-val="0" id="cantidad" step="1" name="cantidad">
                        <!-- <input type="hidden" name="id[]" value="0"> -->
                      <!-- <input type="hidden" name="id[]" value="0"> -->
                    </div>
                    <?php foreach ($despachosSec as $despSec){ if(!empty($despSec['id_despacho_sec'])){ ?>
                      <div class="form-group col-xs-12">
                        <label for="cantidad_sec">Cantidad (Coleccion: <?=$despSec['nombre_coleccion_sec']; ?>)</label>
                        <input type="number" class="form-control cantidad_sec cantidadesT" data-val="<?=$despSec['id_despacho_sec']; ?>" id="cantidad_sec<?=$despSec['id_despacho_sec']; ?>" step="1" name="cantidadSec[]" min="0" value="0">
                        <input type="hidden" name="idColSec[]" value="<?=$despSec['id_despacho_sec']; ?>">
                      </div>
                    <?php } } ?>
                
                      <span id="error_cantidad" class="errors"></span>
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
        <?php $liderazgo = []; 
        foreach ($liderazgos as $l){
          if(!empty($l['nombre_liderazgo'])){
            if($l['nombre_liderazgo']=='SENIOR'){
              $liderazgo = $l; 
            }
          }
        } ?>
        <?php 
          $despachoMinimaCantidad = 0;
          if(!empty($despachos[0]['cantidad_minima_pedido'])){
            $despachoMinimaCantidad = $despachos[0]['cantidad_minima_pedido'];
          }
        ?>
        <?php if ($despachoMinimaCantidad > 0): ?>
        <input type="hidden" id="cantidad_minima" value="<?=$despachoMinimaCantidad; ?>">
        <?php else: ?>
        <input type="hidden" id="cantidad_minima" value="<?=$liderazgo['minima_cantidad']; ?>">
        <?php endif; ?>
        <!-- <input type="hidden" id="cantidad_minima" value="<?=$liderazgo['minima_cantidad']?>"> -->
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
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Homing2";
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
          title: '¡El Pedido esta repetido!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Homing2";
      });
    }
  }
  

  // alert("asd");
  $("#cantidad").attr('value', $("#cantidad_minima").val());

  // $("#cantidad").change(function(){
  //   var minima = parseInt($("#cantidad_minima").val());
  //   var x = parseInt($(this).val());
  //   if(x<minima){
  //     $(this).val(minima);
  //   }else{
  //     $(this).val(x);
  //   }
  // });
  // $("#cantidad").focusout(function(){
  //   var minima = parseInt($("#cantidad_minima").val());
  //   var x = parseInt($(this).val());
  //   if(x<minima){
  //     $(this).val(minima);
  //   }else{
  //     $(this).val(x);
  //   }
  // });
  // $(".cantidadesT").each(function(index, element){
  //   // console.log($(element).val());
  // })
  // console.log();
  $(".cantidadesT").on("change focusout keyup",function(){
    var cant = parseInt($(this).val());
    if(cant < 0){
      $(this).val(0);
    }
    var minimaCol = $("#cantidad_minima").val();
    let totalcant = [];
    $(".cantidadesT").each(function(index, element){
      // console.log($(element).val());
      totalcant.push(parseInt($(element).val()));
    });
    let sumatoriaCant = 0;
    for (var i = 0; i < totalcant.length; i++) {
      sumatoriaCant+=totalcant[i]
    }
    if(sumatoriaCant>=minimaCol){
      $("#error_cantidad").html("");
    }else{
      $("#error_cantidad").html(`Debe hacer un pedido con al menos ${minimaCol} colecciones`);
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      nombre: $("#nombre").val(),
                      id_user: $("#cliente").val(),
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
                            title: '¡Ya se cuenta con un pedido realizado!',
                            text: 'Solo se puede realizar un pedido por cada despacho disponible',
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
  var minimaCol = $("#cantidad_minima").val();
  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //     $("#error_cantidad").html("Debe llenar una cantidad de colecciones");
  //   }
  // }else{
  //   $("#error_cantidad").html("");
  // }
    let totalcant = [];
    let rcantidades = [];
    $(".cantidadesT").each(function(index, element){
      totalcant.push(parseInt($(element).val()));
      rcantidades.push(checkInput($(element).val(), numberPattern));
    });
    let sumatoriaCant = 0;
    for (var i = 0; i < totalcant.length; i++) {
      sumatoriaCant+=totalcant[i]
    }
    rerrores = 0;
    for (var i = 0; i < rcantidades.length; i++) {
      if(!rcantidades[i]){
        rerrores++;
      }
    }
    rcantidad = false;
    if(rerrores==0){
      if(sumatoriaCant>=minimaCol){
        rcantidad = true;
        $("#error_cantidad").html("");
      }else{
        rcantidad = false;
        $("#error_cantidad").html(`Debe hacer un pedido con al menos ${minimaCol} colecciones`);
      }
    }

    let rcliente = true;
    let optAdmin = $("#optAdmin").val();
    if(optAdmin!=""){
      rcliente = false;
      var cliente = $("#cliente").val();
      if(cliente.length>0){
        rcliente = true;
        $("#error_clientes").html("");
      }else{
        rcliente = false;
        $("#error_clientes").html("Debe Seleccionar al Líder");
      }
    }
    // console.log(minimaCol);
    // console.log(sumatoriaCant);
    // console.log(rerrores);
  /*===================================================================*/

  /*===================================================================*/
  // var descripcion = $("#descripcion").val();
  // var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  // if( rdescripcion == false ){
  //   if(descripcion.length != 0){
  //     $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
  //   }else{
  //     $("#error_descripcion").html("Debe llenar la descripcion del permiso");      
  //   }
  // }else{
  //   $("#error_descripcion").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;

  if( rcliente==true && rcantidad==true ){
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
