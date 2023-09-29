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
        <small><?php if(!empty($action)){echo "Pedidos Solicitados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Pedidos Solicitados";} echo " "; ?></li>
      </ol>
    </section>
          <br>

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
              <h3 class="box-title">Reporte de <?php echo "Pedidos Solicitados"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-12">

                    <?php 
                  $pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id']; ?>
                        <input type="hidden" name="route" value="Reportes">
                        <input type="hidden" name="action" value="PedidosSolicitados">
                        <label for="selectedPedido"><b style="color:#000;">Seleccionar Pedido de Campaña</b></label>
                        <select id="selectedPedido" name="P" class="form-control select2" style="width:100%;">
                            <option value="0"></option>
                              <?php 
                                if(count($pedidos)>1){
                                  foreach ($pedidos as $key) {
                                    if(!empty($key['id_campana'])){                        
                                      ?>
                                      <option 
                                            value="<?=$key['id_despacho']?>" 
                                            <?php if(!empty($id_despacho)){if($key['id_despacho']==$id_despacho){echo "selected='1'";}} ?>    >
                                        <?php
                                          $ndp = "";
                                          if($key['numero_despacho']=="1"){ $ndp = "1er"; }
                                          if($key['numero_despacho']=="2"){ $ndp = "2do"; }
                                          if($key['numero_despacho']=="3"){ $ndp = "3er"; }
                                          if($key['numero_despacho']=="4"){ $ndp = "4to"; }
                                          if($key['numero_despacho']=="5"){ $ndp = "5to"; }
                                          if($key['numero_despacho']=="6"){ $ndp = "6to"; }
                                          if($key['numero_despacho']=="7"){ $ndp = "7mo"; }
                                          if($key['numero_despacho']=="8"){ $ndp = "8vo"; }
                                          if($key['numero_despacho']=="9"){ $ndp = "9no"; }
                                        ?>
                                        <?php 
                                          if($key['numero_despacho']!="1"){
                                            // echo $key['numero_despacho'];
                                            echo $ndp;
                                          }
                                          echo " Pedido ";
                                          echo " de Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana'];
                                        ?>
                                      
                                      </option>
                                      <?php 

                                    }
                                  }

                                }
                              ?>
                        </select>
                        <span class="errors error_selected_pedido"></span>
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
        <?php if(!empty($_GET['P'])){ ?>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                  
                    <br>
                    <hr style="border-bottom:1px solid #bbb">
                </div>
              </div>
            </div>
            <div class="box-body"> 
              <div class="row">
                <div class="col-xs-12">

                    <div class="row">
                      <div class="col-xs-10 col-xs-offset-1">
                        <h4 style="font-size:1.7em;margin:0;padding:0;">
                          <b>
                          Pedido 
                          <?php if($despachos[0]['numero_despacho']!="1"): echo $despachos[0]['numero_despacho']; endif; ?>
                           de Campana 
                            <?=$despachos[0]['numero_campana']."/".$despachos[0]['anio_campana']; ?>
                          -
                            <?=$despachos[0]['nombre_campana']; ?>
                          </b>
                        </h3>
                      </div>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;">
                          <a href="?route=Reportes&action=GenerarPedidosSolicitados&id=<?=$id_despacho?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>

                    <table class="table table-bordered table-striped text-center" style="font-size:1.1em;">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th>Nº</th>
                          <th>Lider</th>
                          <th>Pedido Solicitado</th>
                          <th>Pedido Aprobado <small>(En espera)</small></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num = 1; 
                          $cantidadPedido = 0;
                        ?>
                        <?php foreach ($pedidosClientes as $data): if(!empty($data['id_pedido'])):?>
                          <?php foreach ($clientess as $data2): if(!empty($data2['id_cliente'])): ?>
                            <?php if($data['id_cliente'] == $data2['id_cliente']): ?>
                              
                              <?php
                                $permitido = "0";
                                if($accesoBloqueo=="1"){
                                  if(!empty($accesosEstructuras)){
                                    foreach ($accesosEstructuras as $struct) {
                                      if(!empty($struct['id_cliente'])){
                                        if($struct['id_cliente']==$data['id_cliente']){
                                          $permitido = "1";
                                        }
                                      }
                                    }
                                  }
                                }else if($accesoBloqueo=="0"){
                                  $permitido = "1";
                                }


                                if($permitido=="1"):
                                ?>
                                  <tr class="elementTR">
                                    <td><?=$num?></td>
                                    <td>
                                        <?php 
                                          echo number_format($data2['cedula'],0,'','.')." ".$data2['primer_nombre']." ".$data2['primer_apellido'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                          echo $data['cantidad_pedido']." Colecciones";
                                          $cantidadPedido += $data['cantidad_pedido'];
                                        ?>
                                    </td>
                                    <td>
                                        <span style="font-size:1.3em;border:1px solid #ccc;border-radius:5px;padding:5px;color:#00000000;"> ___ </span>

                                    </td>
                                  </tr>
                                  <?php $num++; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; endforeach; ?>
                        <?php endif; endforeach; ?>
                          <tr style="background:#eee;">
                            <td></td>
                            <td><b>Total: </b></td>
                            <td>
                              <b>
                                  <?php 
                                      echo $cantidadPedido." Colecciones"; 
                                  ?>
                              </b>
                            </td>
                            <td></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
        <?php } ?>
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
        window.location = "?route=Configuraciones";
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

  $("#buscando").keyup(function(){
    $(".elementTR").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".elementTR:not(:contains('"+buscar+"'))").hide();
    }
  });
});

function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var selected = parseInt($("#selectedPedido").val());
  var rselected = false;
  if(selected > 0){
    rselected = true;
    $(".error_selected_pedido").html("");
  }else{
    rselected = false;
    $(".error_selected_pedido").html("Debe Seleccionar un Pedido");      
  }
  /*===================================================================*/

  /*===================================================================*/

  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //     $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //   $("#error_cantidad").html("");
  // }


  /*===================================================================*/
  var result = false;
  if( rselected==true){
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
