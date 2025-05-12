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
        <small><?php if(!empty($action)){echo "Pedidos Solicitados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Pedidos Solicitados";} echo " "; ?></li>
      </ol>
    </section>
          <br>

    <!-- Main content -->
    <section class="content">
      <div class="row">


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <form action="" method="get">
                      <?php
                        $meses=[
                          0=>['id'=>'01', 'name'=>"Enero"],
                          1=>['id'=>'02', 'name'=>"Febrero"],
                          2=>['id'=>'03', 'name'=>"Marzo"],
                          3=>['id'=>'04', 'name'=>"Abril"],
                          4=>['id'=>'05', 'name'=>"Mayo"],
                          5=>['id'=>'06', 'name'=>"Junio"],
                          6=>['id'=>'07', 'name'=>"Julio"],
                          7=>['id'=>'08', 'name'=>"Agosto"],
                          8=>['id'=>'09', 'name'=>"Septiembre"],
                          9=>['id'=>'10', 'name'=>"Octubre"],
                          10=>['id'=>'11', 'name'=>"Noviembre"],
                          11=>['id'=>'12', 'name'=>"Diciembre"],
                        ];
                      ?>
                      <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                      <div class="form-group col-sm-10">
                          <label for="mes">Mes</label>
                          <select name="mes" id="mes" class="form-control select2" style="width:100%;">
                            <option value=""></option>
                            <?php
                              foreach($meses as $mes){
                                if($mes['id'] <= date('m')){
                                  ?>
                                    <option <?php if(!empty($_GET['mes'])){ if($mes['id']==$_GET['mes']){ echo "selected"; } } ?> value="<?=$mes['id']; ?>"><?=$mes['name']; ?></option>
                                  <?php
                                }
                              }
                            ?>
                          </select>
                      </div>
                      <div class="form-group col-sm-2">
                        <br>
                        <button class="btn enviar2">Enviar</button>
                      </div>
                    </form>
                  </div>
                  <hr>
                  <div class="row">
                    <?php
                      $index=0;
                      $resumenCuentas = [];
                    ?>
                    <div class="form-group col-sm-12" style='text-align:right;'>
                      <?php
                        $rutaExcel = "route=ExportarReporteResumenGemas";
                        if(!empty($_GET['mes'])){
                          $rutaExcel .= "&mes=".$_GET['mes'];
                        }
                      ?>
                      <a href="?<?=$rutaExcel; ?>" target="_blank" class='btn btn-success' style='margin-right:50px;'>GENERAR EXCEL</a>          
                    </div>
                    <div class="form-group col-sm-12">
                      <table class="table text-center">
                          <tr style='border:2px solid;font-size:1.35em;'>
                              <th>
                                <?php
                                  $resumenCuentas['inicial'][$index]['name1']="";
                                  if(!empty($lastMes)){
                                    $idMesLast=(int) $lastMes; 
                                    $resumenCuentas['inicial'][$index]['name1'].=$meses[($idMesLast-1)]['name']." ";
                                    echo $meses[($idMesLast-1)]['name']." ";
                                  }
                                  echo $currentDate;
                                  
                                  $resumenCuentas['inicial'][$index]['name1'].=$currentDate;
                                  $resumenCuentas['inicial'][$index]['name2']="Saldo Inicial";
                                  $resumenCuentas['inicial'][$index]['cantidad']=$saldo_inicial;
                                  $index++;
                                ?>
                              </th>
                              <th style='text-align:left;'>Saldo Inicial</th>
                              <th><?=number_format($saldo_inicial,2,',','.'); ?></th>
                          </tr>
                          <tr><td colspan='3' style='height:30px;'></td></tr>
                          <?php
                              $sumatoriaSumas = 0;
                              $index=0;
                              foreach($suma as $key){
                                  $sumatoriaSumas+=$key['cantidad'];
                                  ?>
                                      <tr>
                                          <td>
                                            <?php
                                              $resumenCuentas['sumatoria'][$index]['name1']="";
                                              if(!empty($currentMes)){
                                                $idMes=(int) $currentMes; 
                                                echo $meses[($idMes-1)]['name']." ";
                                                $resumenCuentas['sumatoria'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                              }
                                              echo $currentDate; 

                                              $resumenCuentas['sumatoria'][$index]['name1'].=$currentDate;
                                              $resumenCuentas['sumatoria'][$index]['name2']=$key['name'];
                                              $resumenCuentas['sumatoria'][$index]['cantidad']=$key['cantidad'];
                                              $index++;
                                            ?>
                                          </td>
                                          <td style='text-align:left;'><?=$key['name']; ?></td>
                                          <td><?=number_format($key['cantidad'],2,',','.'); ?></td>
                                      </tr>
                                  <?php
                              }
                          ?>
                          <tr style='border:2px solid;font-size:1.2em;'>
                              <th>
                                <?php
                                  $index=0;
                                  $resumenCuentas['total_sumatoria'][$index]['name1']="";
                                  if(!empty($currentMes)){
                                    $idMes=(int) $currentMes; 
                                    echo $meses[($idMes-1)]['name']." ";
                                    $resumenCuentas['total_sumatoria'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                  }
                                  echo $currentDate; 

                                  $resumenCuentas['total_sumatoria'][$index]['name1'].=$currentDate;
                                  $resumenCuentas['total_sumatoria'][$index]['name2']="Total Gemas Generadas";
                                  $resumenCuentas['total_sumatoria'][$index]['cantidad']=$sumatoriaSumas;
                                  $index++;
                                ?>
                              </th>
                              <th style='text-align:left;'><?="Total Gemas Generadas" ?></th>
                              <th><?=number_format($sumatoriaSumas,2,',','.'); ?><span style='float:right;'>( + )</span></th>
                          </tr>
                          <tr><td colspan='3' style='height:30px;'></td></tr>
                          <?php
                              $index=0;
                              foreach($generada as $key){
                                ?>
                                  <tr>
                                      <td>
                                        <?php
                                          
                                          $resumenCuentas['ganadas'][$index]['name1']="";
                                          if(!empty($currentMes)){
                                            $idMes=(int) $currentMes; 
                                            echo $meses[($idMes-1)]['name']." ";
                                            $resumenCuentas['ganadas'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                          }
                                          echo $currentDate; 

                                          $resumenCuentas['ganadas'][$index]['name1'].=$currentDate;
                                          $resumenCuentas['ganadas'][$index]['name2']=$key['name'];
                                          $resumenCuentas['ganadas'][$index]['cantidad']=$key['cantidad'];
                                          $index++;
                                        ?>
                                      </td>
                                      <td style='text-align:left;'><?=$key['name']; ?></td>
                                      <td><?=number_format($key['cantidad'],2,',','.'); ?></td>
                                  </tr>
                                <?php
                              }
                          ?>
                          
                          <tr><td colspan='3' style='height:30px;'></td></tr>
                          <?php  
                              $index=0;
                              $sumatoriaRestas = 0;
                              foreach($resta as $key){
                                $sumatoriaRestas+=$key['cantidad'];
                                ?>
                                  <tr>
                                    <td>
                                      <?php
                                        $resumenCuentas['restas'][$index]['name1']="";
                                        if(!empty($currentMes)){
                                          $idMes=(int) $currentMes; 
                                          echo $meses[($idMes-1)]['name']." ";
                                          $resumenCuentas['restas'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                        }
                                        echo $currentDate; 
                                        $resumenCuentas['restas'][$index]['name1'].=$currentDate;
                                        $resumenCuentas['restas'][$index]['name2']=$key['name'];
                                        $resumenCuentas['restas'][$index]['cantidad']=$key['cantidad'];
                                        $index++;
                                      ?>
                                    </td>
                                    <td style='text-align:left;'><?=$key['name']; ?></td>
                                    <td><?=number_format($key['cantidad'],2,',','.'); ?></td>
                                  </tr>
                                <?php
                              }
                          ?>
                          <tr style='border:2px solid;font-size:1.2em;'>
                            <th>
                              <?php
                                $index=0;
                                $resumenCuentas['total_resta'][$index]['name1']="";
                                if(!empty($currentMes)){
                                  $idMes=(int) $currentMes; 
                                  echo $meses[($idMes-1)]['name']." ";
                                  $resumenCuentas['total_resta'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                }
                                echo $currentDate; 
                                $resumenCuentas['total_resta'][$index]['name1'].=$currentDate;
                                $resumenCuentas['total_resta'][$index]['name2']="Total Gemas Pagadas";
                                $resumenCuentas['total_resta'][$index]['cantidad']=$sumatoriaRestas;
                                $index++;
                              ?>
                            </th>
                            <th style='text-align:left;'><?="Total Gemas Pagadas" ?></th>
                            <th><?=number_format($sumatoriaRestas,2,',','.'); ?><span style='float:right;'>( - )</span></th>
                          </tr>
                          <tr><td colspan='3' style='height:30px;'></td></tr>
                          <?php 
                              $totalGemasDisponibles=0;
                              $totalGemasDisponibles+=$saldo_inicial;
                              $totalGemasDisponibles+=$sumatoriaSumas;
                              $totalGemasDisponibles-=$sumatoriaRestas;
                          ?>
                          <tr style='border:2px solid;font-size:1.4em;'>
                            <th>
                              <?php
                                $index=0;
                                $resumenCuentas['total_disponible'][$index]['name1']="";
                                if(!empty($currentMes)){
                                  $idMes=(int) $currentMes; 
                                  echo $meses[($idMes-1)]['name']." ";
                                  $resumenCuentas['total_disponible'][$index]['name1'].=$meses[($idMes-1)]['name']." ";
                                }
                                echo $currentDate; 


                                $resumenCuentas['total_disponible'][$index]['name1'].=$currentDate;
                                $resumenCuentas['total_disponible'][$index]['name2']="Total Gemas Disponibles";
                                $resumenCuentas['total_disponible'][$index]['cantidad']=$totalGemasDisponibles;
                                $index++;
                              ?>
                            </th>
                            <th style='text-align:left;'><?="Total Gemas Disponibles" ?></th>
                            <th><?=number_format($totalGemasDisponibles,2,',','.'); ?></th>
                          </tr>
                      </table>
                    </div>

                    <?php
                      $_SESSION['resumenCuentas']=$resumenCuentas;
                      // foreach ($resumenCuentas as $resumen => $array) {
                      //   print_r($resumen);
                      //   echo "<br>";
                      // }
                    ?>
                  </div>
                  
              </div>
              <!-- /.box-body -->

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
