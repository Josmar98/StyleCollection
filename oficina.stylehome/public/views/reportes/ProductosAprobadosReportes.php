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
                
              <table class="table table-bordered table-striped" style="text-align:center;width:100%;">
                  <?php 
                    $resumen = [];
                    $num = 1;
                    foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
                      $permitido = 0;
                      if(!empty($accesosEstructuras)){
                        if(count($accesosEstructuras)>1){
                          foreach ($accesosEstructuras as $struct) {
                            if(!empty($struct['id_cliente'])){
                              if($struct['id_cliente']==$lid['id_cliente']){
                                $permitido = 1;
                              }
                            }
                          }
                        }else if($personalInterno){
                          $permitido = 1;
                        }
                      }
                      if($permitido == 1){
                        $id_pedido = $data['id_pedido'];
                        $pedidosInventarios = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos_inventarios.estatus=1 and inventarios.estatus=1 and pedidos.id_pedido={$id_pedido}");
                        ?>
                        <thead>
                          <tr style="font-size:1.25em;">
                            <th style="width:10%;text-align:left !important;padding-left:25px;">
                              <span class="contenido2">
                                <?php echo $num++; ?>
                                <?php
                                  echo " | ";
                                  echo " <span style='margin-left:5px;'>".number_format($data['cedula'],0,',','.')."</span>";
                                  echo " <span style='margin-left:10px;'>".$data['primer_nombre']."</span>";
                                  echo " <span style='margin-left:5px;'>".$data['primer_apellido']."</span>";
                                ?>
                              </span>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan="2" style="padding:0;">
                              <table class="table" style="width:100%;text-align:left;">
                                <thead>
                                  <tr style="text-align:center;">
                                    <th style="text-align:left;">Producto</th>
                                    <th>Solicitado</th>
                                    <th>Aprobado</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                  foreach ($pedidosInventarios as $pedInv){ if(!empty($pedInv['cod_inventario'])){
                                    if(!empty($resumen[$pedInv['cod_inventario']])){
                                      $resumen[$pedInv['cod_inventario']]['cantidad_solicitada'] += $pedInv['cantidad_solicitada'];
                                      $resumen[$pedInv['cod_inventario']]['cantidad_aprobada'] += $pedInv['cantidad_aprobada'];
                                    }else{
                                      $resumen[$pedInv['cod_inventario']]['nombre'] = $pedInv['nombre_inventario'];
                                      $resumen[$pedInv['cod_inventario']]['cantidad_solicitada'] = $pedInv['cantidad_solicitada'];
                                      $resumen[$pedInv['cod_inventario']]['cantidad_aprobada'] = $pedInv['cantidad_aprobada'];
                                    }
                                    ?>
                                      <tr>
                                        <td style="width:60%;padding-left:25px;">
                                          <span class="contenido2">
                                            <?=$pedInv['nombre_inventario']; ?>
                                          </span>
                                        </td>
                                        <td style="width:20%;text-align:center;">
                                          <span class="contenido2">
                                            <?=$pedInv['cantidad_solicitada']." Unds"; ?>
                                          </span>
                                        </td>
                                        <td style="width:20%;text-align:center;">
                                          <span class="contenido2">
                                            <?=$pedInv['cantidad_aprobada']." Unds"; ?>
                                          </span>
                                        </td>
                                      </tr>
                                    <?php
                                  } }
                                ?>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                        <?php
                      }
                    } }
                  ?>
                <tfoot style='background:#ccc;font-size:1.2em;'>
                  <?php foreach ($resumen as $key){ ?>
                    <tr>
                      <th style="text-align:left !important;width:60%;padding-left:25px;">
                        <?=$key['nombre']; ?>
                      </th>
                      <th style="width:40% !important;">
                        <table style="width:100%;">
                          <tr>
                            <td style="width:50%;">
                              <?=$key['cantidad_solicitada']." Unds"; ?>
                            </td>
                            <td style="width:50%;">
                              <?=$key['cantidad_aprobada']." Unds"; ?>
                            </td>
                          </tr>
                        </table>
                      </th>
                    </tr>
                  <?php } ?>
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
