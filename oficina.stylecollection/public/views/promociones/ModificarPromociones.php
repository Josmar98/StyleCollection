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
              <h3 class="box-title">Editar Solicitud de Promoción</h3>
              <?php
                if(count($lideres)>1){
                  echo "<br>";
                  echo "<h4><i>Líder <b>".$lideres[0]['primer_nombre']." ".$lideres[0]['primer_apellido']."</b></i></h4>";
                }
              ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                    <?php 
                        if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
                      ?>

                    <form action="" method="GET" class="formLiderSelect">
                        <input type="hidden" name="campaing" value="<?=$_GET['campaing'] ?>">
                        <input type="hidden" name="n" value="<?=$_GET['n'] ?>">
                        <input type="hidden" name="y" value="<?=$_GET['y'] ?>">
                        <input type="hidden" name="dpid" value="<?=$_GET['dpid'] ?>">
                        <input type="hidden" name="dp" value="<?=$_GET['dp'] ?>">
                        <input type="hidden" name="route" value="<?=$_GET['route'] ?>">
                        <input type="hidden" name="action" value="<?=$_GET['action'] ?>">
                        <input type="hidden" name="admin" value="<?=$_GET['admin']."1"; ?>">
                    <div class="form-group col-xs-12">
                      <label for="Cliente">Cliente</label>
                        <select class="form-control select2" name="lider" id="cliente" style="width:100%">
                          <option value="">Seleccione</option>
                          <?php foreach ($clientss as $client) { if($client['id_cliente']){ if($client['cantidad_aprobado']>0){ ?>
                            <?php
                              if($accesoBloqueo=="1"){
                                if(!empty($accesosEstructuras)){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$client['id_cliente']){
                                        ?>
                                        <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                                        <option <?php foreach ($clientesConPromociones as $key){ if(!empty($key['id_cliente'])){
                                          if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                          }} if(!empty($_GET['lider']) && $_GET['lider']==$client['id_cliente']){ echo "selected"; } ?>  value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                        <?php 
                                      }
                                    }
                                  }
                                }
                              }else if($accesoBloqueo=="0"){
                                ?>
                                <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                                <option <?php foreach ($clientesConPromociones as $key){ if(!empty($key['id_cliente'])){
                                  if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                  }} if(!empty($_GET['lider']) && $_GET['lider']==$client['id_cliente']){ echo "selected"; } ?>  value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                <?php
                              }
                            ?>








                          <?php } } } ?>
                        </select>

                      <span id="error_clientes" class="errors"></span>
                    </div>
                    </form>
                      <?php } ?>


                </div>
              </div>
              <?php 
                // print_r($promocionEditar);
              ?>
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="promocion">Promoción</label>
                      <select class="form-control select2" id="promocion" name="promocion" style="width:100%;" <?php if(!empty($_GET['admin']) && empty($_GET['lider'])){ echo "disabled"; } ?>>
                        <option value="">Seleccione una promoción</option>
                        <?php foreach ($promociones as $data){ if(!empty($data['id_promocion'])){ ?>
                          <option <?php if($promocionEditar['id_promocion']==$data['id_promocion']){ echo "selected"; } ?> value="<?=$data['id_promocion']; ?>">
                            <?=$data['nombre_promocion']; ?>
                            <?php
                              $id_promo = $data['id_promocion'];
                              foreach ($lider->consultarQuery("SELECT * FROM productos_promocion WHERE id_promocion = {$id_promo}") as $key){
                                if(!empty($key[0])){
                                  // echo $key['id_producto'];
                                  $id_premios_busqueda = $key['id_producto'];
                                  $premiosinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus = 1 and id_premio = {$id_premios_busqueda}");
                                  $iter = 1;
                                  echo " => <b><small>[";
                                  foreach($premiosinv as $pinv){
                                    if(!empty($pinv['id_premio_inventario'])){
                                      if($pinv['tipo_inventario']=="Productos"){
                                        $queryMosInv = "SELECT *, productos.producto as elemento FROM premios_inventario, productos WHERE premios_inventario.id_inventario=productos.id_producto and productos.id_producto={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                                      }
                                      if($pinv['tipo_inventario']=="Mercancia"){
                                        $queryMosInv = "SELECT *, mercancia.mercancia as elemento FROM premios_inventario, mercancia WHERE premios_inventario.id_inventario=mercancia.id_mercancia and mercancia.id_mercancia={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                                      }
                                      $inventariosMos = $lider->consultarQuery($queryMosInv);
                                      foreach ($inventariosMos as $invm) {
                                        if(!empty($invm[0])){
                                          echo $invm['unidades_inventario']." ".$invm['elemento'];
                                          if($iter < (count($premiosinv)-1)){
                                            echo " | ";
                                          }
    
                                        }
                                      }
                                    }
                                    $iter++;
                                  }
                                  echo "]</small></b>";
                                }
                              }
                            ?>
                          </option>
                        <?php } } ?>
                      </select>
                      <span id="error_promocion" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12">
                      <?php if(!empty($_GET['admin']) && !empty($_GET['lider'])){ ?>
                      <input type="hidden" name="cliente" value="<?=$_GET['lider']; ?>">
                      <?php } ?>
                      <label for="cantidad">Cantidad de promociones</label>
                      <input type="number" class="form-control" id="cantidad" step="1" name="cantidad" value="<?=$promocionEditar['cantidad_solicitada_promocion'] ?>" <?php if(!empty($_GET['admin']) && empty($_GET['lider'])){ echo "disabled"; } ?>>
                      <span id="error_cantidad" class="errors"></span>
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
        <?php 
          $newLimitePedidos = 0;
          $limiteMax = 10;
          if($promocionLimitadaPorPedidoAprobado==1){
            if(count($pedidos)>1){
              if($pedido['cantidad_aprobado']>0){
                $newLimitePedidos=$pedido['cantidad_aprobado'];
              }else{
                $newLimitePedidos=$pedido['cantidad_pedido'];
              }
            // }else{
              // $newLimitePedidos=$limiteMax;
            }
          } else {
            $newLimitePedidos=$limiteMax;
          } 
        ?>
        <input type="hidden" id="cantidad_max" value="<?=$newLimitePedidos;?>">
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Promociones";
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
          title: '¡La promoción esta repetido!',
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
  $("#cliente").change(function(){
    // alert("asd");
    $(".formLiderSelect").submit();
  });

  $("#cantidad").change(function(){
    var max = parseInt($("#cantidad_max").val());
    var x = parseInt($(this).val());

    if(x>max){
      $(this).val(max);
    }else{
      // $(this).val(x);
      if(x<0){
        $(this).val(0);
      }else{
        $(this).val(x);
      }
    }
  });
  $("#cantidad").focusout(function(){
    var max = parseInt($("#cantidad_max").val());
    var x = parseInt($(this).val());
    if(x>max){
      $(this).val(max);
    }else{
      // $(this).val(x);
      if(x<0){
        $(this).val(0);
      }else{
        $(this).val(x);
      }
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
                      id_promocion: $("#promocion").val(),
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
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad de colecciones");
    }
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/
  var promocion = $("#promocion").val();
  var rpromocion = checkInput(promocion, numberPattern);
  if( promocion==0 ){
    $("#error_promocion").html("Debe seleccionar una Promoción");      
    rpromocion = false;
  }else if( promocion > 0 ){
    $("#error_promocion").html("");
    rpromocion = true;
  }
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

  if( rcantidad==true && rpromocion==true){
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
