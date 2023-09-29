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
        <small><?php if(!empty($action)){echo "Porcentaje Premios Seleccionados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Porcentaje Premios Seleccionados";} echo " "; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de <?php echo "Porcentaje Premios Seleccionados"; ?></h3>
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
                        <input type="hidden" name="action" value="PorcentajePremiosSeleccionados">

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
                                        <?php echo "Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana']; ?>
                                      
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
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;">
                          <a href="?route=Reportes&action=GenerarPorcentajePremiosSeleccionados&id=<?=$id_despacho?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table class="table table-bordered table-striped text-center" style="" id="">
                      <thead style="background:#ccc;">
                        <tr>
                          <th style="width:10%">Nº</th>
                          <th style="width:20%">Planes</th>
                          <th style="width:50%">Cantidad y Premios</th>
                          <th style="width:20%">Porcentaje</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num = 1;
                        $nume = 0;
                          // $array['plan'] = [];
                          // $array['premios'] = [];
                        ?>
                        <?php foreach ($planes_campana as $data): if(!empty($data['id_plan_campana'])):?>
                          <?php foreach ($premioscol as $data4): if(!empty($data4['id_premio'])): ?>  
                            <?php if ($data['id_plan_campana']==$data4['id_plan_campana']): ?>
                                <?php $nume+= $data4['cantidad_premios_plan']; ?>
                            <?php endif ?>
                          <?php endif; endforeach; ?>
                        <?php endif; endforeach; ?>

                        <?php foreach ($planes_campana as $data): if(!empty($data['id_plan_campana'])):?>
                          <?php $array = []; ?>
                          <tr class="elementTR">
                            <td style="width:10%;"><?=$num?></td>
                            <td style="text-align:left;width:20%">
                              <?php echo "Plan ".$data['nombre_plan']."<br>"; ?>
                            </td>
                            <td style="width:70%;text-align:justify;" colspan="2">
                                        <table class='table' style='background:none'>
                                          <tr style="font-size:1.3em;">
                                              <td style="width:100%;">
                                                  <table class='table table-hover' style='background:none'> 
                                                  <?php foreach ($premioscol as $data4): if(!empty($data4['id_premio'])): ?>  
                                                    <?php if ($data['id_plan_campana']==$data4['id_plan_campana']): ?>
                                                      <?php //if($data4['cantidad_premios_plan']>0): ?>
                                                        <?php //$nume+= $data4['cantidad_premios_plan']; ?>
                                                            <?php 
                                                              if(isset($array['id'][$data4['id_tppc']])){
                                                                $array['id'][$data4['id_tppc']]['cantidad'] += $data4['cantidad_premios_plan'];
                                                                // $array['id'][$data4['id_tppc']]['nombre_premio'] += $data4['nombre_premio'];
                                                              }else{
                                                                $array['id'][$data4['id_tppc']]['cantidad'] = $data4['cantidad_premios_plan'] ;
                                                                $array['id'][$data4['id_tppc']]['nombre_premio'] = $data4['nombre_premio'];
                                                              }
                                                            ?>
                                                    <?php //endif ?>
                                                    <?php endif ?>
                                                  <?php endif; endforeach; ?>

                                                  <?php $porcent = 0; ?>
                                                  <?php foreach ($array as $key): ?>
                                                    <?php foreach ($key as $key2): ?>

                                                      <?php 
                                                        $porcent = $key2['cantidad']*100/$nume; 
                                                      ?>


                                                      <tr>
                                                        <td style="width:70%;text-align:left;">
                                                          <b><?php echo $key2['cantidad']; ?></b>
                                                          <?php echo $key2['nombre_premio']; ?>
                                                        </td>
                                                        <td style="width:30%;text-align:right;">
                                                          <b>
                                                            (<?php echo number_format($porcent,2,',','.'); ?>%)
                                                          </b>
                                                        </td>
                                                      </tr>
                                                    <?php endforeach ?>
                                                  <?php endforeach ?>


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
