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
        <?php echo "Premios Perdidos"; ?>
        <small><?php if(!empty($action)){echo "Premios Perdidos";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Perdidos";} echo " "; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu;?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?php echo "Premios Perdidos"; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Premios Perdidos de los lideres"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
        <?php //if(!empty($_POST['selectedPedido'])){ ?>
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
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                    </div>
                    <table class="table text-center datatable" id="">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th>---</th>
                          <th style="width:10%">Nº</th>
                          <th style="width:20%">Lider</th>
                          <th style="width:17.5%">Colecciones</th>
                          <th style="width:17.5%">Planes Seleccionado</th>
                          <th style="width:35%">Premios Seleccionado y Perdidos</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num = 1; ?>
                        <?php foreach ($pedidos as $data): if(!empty($data['id_pedido'])):?>

                          <tr class="elementTR">
                            <td>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=<?php echo $url; ?>&action=Modificar&admin=1&select=1&lider=<?php echo $data['id_cliente']; ?>">
                                    <span class="fa fa-wrench"></span>
                                  </button>
                                  <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?php echo $url; ?>&id=<?php echo $data['id_gema'] ?>&permission=1">
                                    <span class="fa fa-trash"></span>
                                  </button> -->
                            </td>
                            <td style="width:10%;"><?=$num?></td>
                            <td style="width:20%">
                                <?php 
                                  echo number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']." <br> ".
                                      $data['cantidad_aprobado']." Colecciones Aprobadas";
                                ?>
                            </td>
                            <td style="width:70%;text-align:justify;" colspan="3">
                                <table class='table table-striped table-hover' style='background:none'>
                                  <tr>
                                    <td style="text-align:left;">
                                        <?php echo $data['cantidad_aprobado']." Colecciones<br>"; ?>
                                      
                                    </td>
                                    <td style="text-align:left;">
                                        <?php echo $data['cantidad_aprobado']." Premios de Inicial<br>"; ?>
                                    </td>
                                    <td style="width:50%;">
                                            <table class='' style='background:none'> 
                                                <tr>
                                                  <td>
                                                    <?php 
                                                    foreach ($premios_perdidos as $dataperdidos) {
                                                      if(!empty($dataperdidos['id_premio_perdido'])){
                                                        if(($dataperdidos['valor'] == "Inicial") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                          $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
                                                          echo $data['cantidad_aprobado']."-".$dataperdidos['cantidad_premios_perdidos']." = ".$nuevoResult." Premios de ".$dataperdidos['valor'];

                                                          echo "<br>";
                                                        }
                                                      }
                                                    }
                                                     ?>
                                                  </td>
                                                </tr>
                                            </table>
                                    </td>
                                  </tr>
                              <?php foreach ($planesCol as $data2): if(!empty($data2['id_cliente'])): ?>
                                  <?php if ($data['id_pedido'] == $data2['id_pedido']): ?>
                                      <?php if ($data2['cantidad_coleccion_plan']>0): ?>
                                          <tr >
                                              <td style="text-align:left;width:25%">
                                                <?php echo ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan'])." Colecciones ";?>
                                              </td>
                                              <td style="text-align:left;width:25%">
                                              <?php echo $data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."<br>"; ?>

                                              </td>

                                              <td style="width:50%;">
                                                  <table class='' style='background:none'> 
                                                      <tr>
                                                        <td>
                                                        <?php 
                                                          foreach ($premios_perdidos as $dataperdidos) {
                                                            if(!empty($dataperdidos['id_premio_perdido'])){
                                                              if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                                $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                                echo $data2['cantidad_coleccion_plan']."-".$dataperdidos['cantidad_premios_perdidos']." = ".$nuevoResult." Plan ".$dataperdidos['valor'];

                                                                echo "<br>";
                                                              }
                                                            }
                                                          }
                                                        ?>

                                                        </td>
                                                      </tr>
                                                      <?php foreach ($premioscol as $data3): if(!empty($data3['id_premio'])): ?>  
                                                        <?php if ($data3['id_plan']==$data2['id_plan']): ?>
                                                          <?php if ($data['id_pedido']==$data3['id_pedido']): ?>
                                                            <?php if($data3['cantidad_premios_plan']>0): ?>
                                                          <tr>
                                                            <td style="text-align:left;">
                                                              
                                                            <?php 
                                                              foreach ($premios_perdidos as $dataperdidos) {
                                                                  if(!empty($dataperdidos['id_premio_perdido'])){
                                                                    if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                                      $nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                                      echo $data3['cantidad_premios_plan']."-".$dataperdidos['cantidad_premios_perdidos'];
                                                                      echo " = ";
                                                                      echo $nuevoResult." ".$data3['nombre_premio'];
                                                                      echo "<br>";
                                                                    }
                                                                  }
                                                                }
                                                             ?>
                                                            </td>
                                                          </tr>
                                                            <?php endif ?>
                                                          <?php endif ?>
                                                        <?php endif ?>
                                                      <?php endif; endforeach; ?>

                                                      
                                                  </table>
                                                  <!-- <br> -->
                                              </td>
                                          </tr>
                                      <?php endif ?>
                                  <?php endif ?>
                              <?php endif; endforeach; ?>
                                  <tr>
                                    <td style="text-align:left;">
                                        <?php echo $data['cantidad_aprobado']." Colecciones<br>"; ?>
                                      
                                    </td>
                                    <td style="text-align:left;">
                                        <?php echo $data['cantidad_aprobado']." Premios de Segundo Pago<br>"; ?>
                                    </td>
                                    <td style="text-align:left;">
                                      <table class='' style='background:none'> 
                                          <tr>
                                            <td>
                                              <?php 
                                              foreach ($premios_perdidos as $dataperdidos) {
                                                if(!empty($dataperdidos['id_premio_perdido'])){
                                                  if(($dataperdidos['valor'] == "Segundo") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                    $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
                                                    echo $data['cantidad_aprobado']."-".$dataperdidos['cantidad_premios_perdidos']." = ".$nuevoResult." Premios de ".$dataperdidos['valor'];

                                                    echo "<br>";
                                                  }
                                                }
                                              }
                                               ?>
                                            </td>
                                          </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                            </td>
                          </tr>
                            <?php $num++; ?>
                        <?php endif; endforeach; ?>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
        <?php //} ?>
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


  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            window.location = $(this).val();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
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
