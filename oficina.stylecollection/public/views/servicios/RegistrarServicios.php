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
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3 ?>route=<?=$url; ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">


        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          $opcionFacturasCerradas = 0;
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
              <h3 class="box-title">Seleccionar Servicio</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
              if( empty($_GET['all']) && (!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")) ) {
                ?>
                  <div class="box-body">
                    <div style='display:block;text-align:right;'>
                      <a href="?<?=$menu;?>&route=<?=$_GET['route']?>&action=<?=$_GET['action']?>&admin=1&all=1" class="btn enviar2" style=''>Seleccionar varios</a>
                    </div>
                    <div class="row">
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
                            <label for="Cliente">Cliente</label> <?php //echo $promocionLimitadaPorPedidoAprobado; ?>
                              <select class="form-control select2" name="lider" id="cliente" style="width:100%">
                                <option value="">Seleccione</option>
                                <?php foreach ($data as $client) { if($client['id_cliente']){  ?>
                                  <?php
                                    $limitarLideres = true;
                                    if($promocionLimitadaPorPedidoAprobado==1){
                                      if($client['cantidad_aprobado']>0){
                                        $limitarLideres=true;
                                      }else{
                                        $limitarLideres=false;
                                      }
                                    }else{

                                      if($client['cantidad_pedido']>0){
                                        $limitarLideres=true;
                                      }else{
                                        $limitarLideres=false;
                                      }
                                    }
                                  ?>
                                  <?php if($limitarLideres){ ?>
                                    <?php
                                      if($accesoBloqueo=="1"){
                                        if(!empty($accesosEstructuras)){
                                          foreach ($accesosEstructuras as $struct) {
                                            if(!empty($struct['id_cliente'])){
                                              if($struct['id_cliente']==$client['id_cliente']){
                                                ?>
                                                <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                                                <option 
                                                <?php 
                                                  // foreach ($clientesConPromociones as $key){ if(!empty($key['id_cliente'])){
                                                  //   if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                                  //   }
                                                  // }
                                                  if(!empty($_GET['lider']) && $_GET['lider']==$client['id_cliente']){ echo "selected"; } 
                                                ?>
                                                value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                                <?php 
                                              }
                                            }
                                          }
                                        }
                                      }else if($accesoBloqueo=="0"){
                                        ?>
                                        <!-- <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option> -->
                                        <option 
                                          <?php 
                                            // foreach ($clientesConPromociones as $key){ if(!empty($key['id_cliente'])){
                                            //   if($key['id_cliente'] == $client['id_cliente']){ echo "disabled"; }
                                            //   }
                                            // } 
                                            if(!empty($_GET['lider']) && $_GET['lider']==$client['id_cliente']){ echo "selected"; } 
                                          ?> 
                                          value="<?php echo $client['id_cliente'] ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                        <?php
                                      }
                                    ?>
                                  <?php } ?>
                                <?php  } } ?>
                              </select>

                            <span id="error_clientes" class="errors"></span>
                          </div>
                      </form>
                    </div>
                  </div>
                <?php
              }
            ?>

            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="servicio">Servicio</label>
                      <select class="form-control select2" id="servicio" name="servicio" style="width:100%;" <?php if( empty($_GET['all']) && (!empty($_GET['admin']) && empty($_GET['lider'])) ){ echo "disabled"; } ?>>
                        <option value="">Seleccione un servicio</option>
                        <?php foreach ($servicios as $data){ if(!empty($data['id_servicio'])){ ?>
                          <option value="<?=$data['id_servicio']; ?>">
                            <?=$data['nombre_servicio']." (".$data['nombre_servicioss'].") => (".number_format($data['precio_servicio'],2,',','.').")"; ?>
                          </option>
                        <?php } } ?>
                      </select>
                      <span id="error_servicio" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12">
                      <?php if(!empty($_GET['admin']) && !empty($_GET['lider'])){ ?>
                      <input type="hidden" name="clientes[]" value="<?=$_GET['lider']; ?>">
                      <?php } ?>
                      <label for="cantidad">Cantidad de promociones</label>
                      <input type="number" class="form-control" id="cantidad" step="1" name="cantidad" <?php if( empty($_GET['all']) && (!empty($_GET['admin']) && empty($_GET['lider'])) ){ echo "disabled"; } ?>>
                      <span id="error_cantidad" class="errors"></span>
                    </div>
                  </div>

                  <?php
                    if(!empty($_GET['all'])){
                      ?>
                  <div class="row">
                    <div class="col-sm-12">
                        <b><i><span style="color:red">(Importante) Nota:</span> Deben estar marcadas las casillas de todos los líderes que desee se les asigne el servicio.</i></b><br><br>
                        <table id="datatablee" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                          <thead>
                          <tr style="text-align:left;">
                            <td colspan="3">
                              <?php 
                                $xdxd = [];
                                $h=0;
                                foreach ($pedidos as $data){
                                  if(!empty($data['id_cliente'])){
                                    if(!empty($accesosUsuarios[$h])){
                                      // $accLider = $accesosUsuarios[$h];
                                      // $permisoAccesoLider = $accLider['permiso_accesos'];
                                      // if($permisoAccesoLider=="on"){
                                      //   $xdxd[$h] = "0";
                                      // }
                                      // if($permisoAccesoLider=="off"){
                                      //   $xdxd[$h] = "1";
                                      // }
                                    }
                                    $h++;
                                  }
                                }
                                // $allOpt = 0;
                                // foreach ($xdxd as $key) {
                                //   $allOpt += $key;
                                // }
                                // echo $allOpt;

                              ?>
                              <label for="all">Seleccionar Todos</label>
                              <!-- <br> -->
                              <input type="checkbox" name="all" id="all">
                            </td>
                          </tr>
                          <tr>
                            <th>Nº</th>
                            <th>Lider</th>
                            <th>---</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $num = 1;
                          $x = 0;
                          // print_r($pedidos);
                          foreach ($pedidosFull as $data):
                          if(!empty($data['id_cliente'])):  
                          ?>
                          <?php 
                          if($accesoBloqueo=="1"){
                            if(!empty($accesosEstructuras)){
                              foreach ($accesosEstructuras as $struct) {
                                if(!empty($struct['id_cliente'])){
                                  if($struct['id_cliente']==$data['id_cliente']){
                                    ?>
                                    <tr>
                                      <td style="width:5%">
                                        <span class="contenido2">
                                          <?php echo $num++; ?>
                                        </span>
                                      </td>
                                      <td style="width:20%">
                                        <span class="contenido2">
                                          <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                                        </span>
                                      </td>
                                      
                                      <td style="width:10%">
                                        <input type="checkbox" class="cheking check<?php echo $data['id_cliente'] ?>" name="clientes[]" cheked='cheked' value="<?php echo $data['id_cliente'] ?>">
                                        <!-- <input type="hidden" class="clienteid<?php echo $data['cliente'] ?>" name="clientes[]" value="<?php echo $data['id_cliente'] ?>"> -->
                                      </td>
                                    </tr>
                                    <?php
                                    $x++;
                                  }
                                }
                              }
                            }
                          }else if($accesoBloqueo=="0"){
                            ?>
                            <tr>
                              <td style="width:5%">
                                <span class="contenido2">
                                  <?php echo $num++; ?>
                                </span>
                              </td>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                                </span>
                              </td>
                              
                              <td style="width:10%">
                                <input type="checkbox" class="cheking check<?php echo $data['id_cliente'] ?>" name="clientes[]" cheked='cheked' value="<?php echo $data['id_cliente'] ?>">
                                <!-- <input type="hidden" class="clienteid<?php echo $data['cliente'] ?>" name="clientes[]" value="<?php echo $data['id_cliente'] ?>"> -->
                              </td>
                            </tr>
                            <?php
                            $x++;
                          }
                         endif; endforeach;
                          ?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <th>Nº</th>
                            <th>Lider</th>
                            <th>---</th>
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                      <?php
                    }
                  
                  ?>

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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Servicios";
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
          title: '¡La Promoción esta repetido!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Servicios";
      });
    }
  }
  $(".cheking").click(function(){
    var id = $(this).val();
    if($(this).prop('checked')){
      $(".acclider"+id).val("on");
      // $(this).val("on");
    }else{
      $(".acclider"+id).val("off");
      // $(this).val("Off");      
    }
  });
  $("#all").click(function(){
    if($(this).prop('checked')){
      $(".cheking").attr("checked","1");
      // $(".cheking").attr("value","on");
      
      $(".accliderAll").val("on");
    }else{
      $(".cheking").removeAttr("checked","0");
      // $(".cheking").attr("value","off");
      $(".accliderAll").val("off");
    }
  });

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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
                // $.ajax({
                //     url: '',
                //     type: 'POST',
                //     data: {
                //       validarData: true,
                //       nombre: $("#nombre").val(),
                //       id_user: $("#cliente").val(),
                //       id_promocion: $("#promocion").val(),
                //     },
                //     success: function(respuesta){
                //         // alert(respuesta);
                //       if (respuesta == "1"){
                //       }
                //       if (respuesta == "9"){
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Ya se cuenta con está promoción solicitada!',
                //             text: 'Solo se puede solicitar un tipo de Promoción por cada despacho disponible',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //     }
                // });
              
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
      $("#error_cantidad").html("La cantidad solo debe contener numeros");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad");
    }
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/
  var servicio = $("#servicio").val();
  var rservicio = checkInput(servicio, numberPattern);
  if( servicio==0 ){
    $("#error_servicio").html("Debe seleccionar un servicio");      
    rservicio = false;
  }else if( servicio > 0 ){
    $("#error_servicio").html("");
    rservicio = true;
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

  if( rcantidad==true && rservicio==true){
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
