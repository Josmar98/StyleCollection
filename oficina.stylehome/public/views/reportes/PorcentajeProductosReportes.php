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

<?php 
$amLiderazgosB = 0;
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $modulo; ?>
        <small><?php echo "Ver ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Niveles de ".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="" method="get">
                <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                <div class="form-group">
                  <label>Ciclos</label>
                  <select class="form-control select2" style="width:100%;" name="ciclo" required>
                    <option value=""></option>
                    <?php
                      foreach ($ciclos as $ciclo){ if(!empty($ciclo['id_ciclo'])){
                        ?>
                        <option <?php if(!empty($_GET['ciclo'])){ if($_GET['ciclo']==$ciclo['id_ciclo']){ echo "selected"; } } ?> value="<?=$ciclo['id_ciclo']; ?>"><?="Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']; ?></option>
                        <?php
                      } }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <button class="btn enviar2">Enviar ciclo</button>
                </div>
              </form>

              <?php if(!empty($_GET['ciclo']) ){ ?>
              <hr>
              <?php
                $id_ciclo = $_GET['ciclo'];
                $rutaPDF = "route={$url}&action=Generar{$action}&ciclo={$id_ciclo}";
              ?>
              <div class="row">
                <div class="col-xs-12" style="text-align:right;">
                  <a href="?<?=$rutaPDF; ?>" target="_blank"><button class="btn enviar2">Generar PDF</button></a>
                </div>
              </div>
              <hr>
              <div style="max-height:110vh;overflow:auto;border:1px solid #CCC;">
                
              <?php 
                $resumen = [];
                $porcentaje = ['solicitado'=>0, 'aprobado'=>0, 'porcentaje_solicitado'=>0, 'porcentaje_aprobado'=>0];
                foreach ($productosInventario as $data){ if(!empty($data['cod_inventario'])){
                  $codInv = $data['cod_inventario'];
                  $pedidosInventarios = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos_inventarios.estatus=1 and inventarios.estatus=1 and inventarios.cod_inventario='{$codInv}'");

                  foreach ($pedidosInventarios as $key){ if(!empty($key['cod_inventario'])){
                    if(!empty($resumen[$codInv])){
                      $resumen[$codInv]['cantidad_solicitada'] += $key['cantidad_solicitada'];
                      $resumen[$codInv]['cantidad_aprobada'] += $key['cantidad_aprobada'];
                    }else{
                      $resumen[$codInv]['cod'] = $key['cod_inventario'];
                      $resumen[$codInv]['nombre'] = $key['nombre_inventario'];
                      $resumen[$codInv]['cantidad_solicitada'] = $key['cantidad_solicitada'];
                      $resumen[$codInv]['cantidad_aprobada'] = $key['cantidad_aprobada'];
                    }
                    $porcentaje['solicitado'] += $key['cantidad_solicitada'];
                    $porcentaje['aprobado'] += $key['cantidad_aprobada'];
                  } }

                } }
               ?>
              <table class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                  <tr style="background:#DDD;">
                    <th style='width:5% !important;'>N°</th>
                    <th style='width:55% !important;text-align:left !important'>Producto</th>
                    <th style='width:20% !important;' colspan="2">Solicitado</th>
                    <th style='width:20% !important;' colspan="2">Aprobado</th>
                  </tr>
                </thead>
                <tbody>

                  <?php 
                    $num = 1;
                    foreach ($productosInventario as $data){ if(!empty($data['cod_inventario'])){
                      $codInv = $data['cod_inventario'];
                      $porcentaje['solicitado_porcentaje'] = ($resumen[$codInv]['cantidad_solicitada']*100)/$porcentaje['solicitado'];
                      $porcentaje['aprobado_porcentaje'] = ($resumen[$codInv]['cantidad_aprobada']*100)/$porcentaje['aprobado'];
                      $porcentaje['porcentaje_solicitado'] += $porcentaje['solicitado_porcentaje'];
                      $porcentaje['porcentaje_aprobado'] += $porcentaje['aprobado_porcentaje'];
                      $porcentaje['solicitado_porcentaje'] = (float) number_format($porcentaje['solicitado_porcentaje'],2);
                      $porcentaje['aprobado_porcentaje'] = (float) number_format($porcentaje['aprobado_porcentaje'],2);
                      ?>
                      <tr>
                        <td style="width:5% !important;">
                          <span class="contenido2">
                            <?=$num++; ?>
                          </span>
                        </td>
                        <td style="width:55% !important;text-align:left !important;">
                          <span class="contenido2">
                            <?=$resumen[$codInv]['nombre']; ?>
                          </span>
                        </td>
                        <td style="width:20% !important;text-align:center;">
                          <span class="contenido2">
                            <?=$resumen[$codInv]['cantidad_solicitada']." Unds"; ?>
                          </span>
                        </td>
                        <td style="width:5% !important;text-align:center;">
                          <span class="contenido2">
                            <b>(<?=$porcentaje['solicitado_porcentaje']."%"; ?>)</b>
                          </span>
                        </td>
                        <td style="width:15% !important;text-align:center;">
                          <span class="contenido2">
                            <?=$resumen[$codInv]['cantidad_aprobada']." Unds"; ?>
                          </span>
                        </td>
                        <td style="width:5% !important;text-align:center;">
                          <span class="contenido2">
                            <b>(<?=$porcentaje['aprobado_porcentaje']."%"; ?>)</b>
                          </span>
                        </td>
                      </tr>
                      <?php
                    } }
                  ?>
                </tbody>
                <tfoot style='background:#ccc;font-size:1.2em;'>
                  <tr>
                    <th></th>
                    <th></th>
                    <th><?=$porcentaje['solicitado']." Unds"; ?></th>
                    <th><?=$porcentaje['porcentaje_solicitado']."%"; ?></th>
                    <th><?=$porcentaje['aprobado']." Unds"; ?></th>
                    <th><?=$porcentaje['porcentaje_aprobado']."%"; ?></th>
                  </tr>
                </tfoot>
              </table>

              </div>

              <hr>
              <div class="row">
                <div class="col-xs-12" style="text-align:right;">
                  <a href="?<?=$rutaPDF; ?>" target="_blank"><button class="btn enviar2">Generar PDF</button></a>
                </div>
              </div>
              <?php } ?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=Liderazgos";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    
  }

  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                        });
                    } 
                });

          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });
});  
</script>
</body>
</html>
