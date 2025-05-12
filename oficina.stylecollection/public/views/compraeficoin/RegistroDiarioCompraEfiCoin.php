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
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
      <br>
      <div style="width:100%;text-align:center;"><a href="?<?=$menu3;?>route=<?php echo $url ?>&action=<?=$nameActionEject;?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$modulo.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
                <form action="" methdod="get" class="form">
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                            <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                            <label for="fecha_seleccionada">Fecha Recibidos</label>
                            <input type="date" class="form-control fecha_seleccionada" id="fecha_seleccionada" name="fecha_seleccionada" value="<?=$_GET['fecha_seleccionada']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn enviar2">Cargar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <?php if(!empty($_GET['fecha_seleccionada'])){ ?>
                    <hr>
                    <br>
                    <form action="" method="get" target="_blank">
                    <input type="hidden" name='route' value='<?=$_GET['route']; ?>'>
                    <input type="hidden" name='action' value='Generar<?=$_GET['action']; ?>'>
                    <input type="hidden" name='fecha_seleccionada' value='<?=$_GET['fecha_seleccionada']; ?>'>
                    <div class="row">
                            <div class="col-xs-12" style='text-align:right;'>
                                <button class="btn enviar2">Generar PDF</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 style='margin-left:30px;'>Reporte de Recepción de EfiCoin <span style='float:right;margin-right:30px;'>Fecha: <?=$lider->formatFechaSlash($_GET['fecha_seleccionada']); ?></span></h3>
                            </div>
                        </div>
                        <table id="" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                            <thead>
                                <tr>
                                    <th>Nro. Control de Recibos</th>
                                    <th>Cantidad</th>
                                    <th>Reportado El</th>
                                    <th>Líder</th>
                                    <th>RIF</th>
                                    <th>Concepto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $num = 1;
                                    $totalRecibido = 0;
                                    foreach ($eficoins as $data){
                                        if(!empty($data['id_eficoin_div'])){ 
                                            $lim = 7;
                                            $falta = $lim-strlen($data['numero_recibo']);
                                            $numero_recibo="";
                                            for ($i=0; $i < $falta; $i++) {
                                                $numero_recibo.="0";
                                            }
                                            $numero_recibo .= $data['numero_recibo'];
                                            $totalRecibido+=(float) number_format($data['equivalente_pago'],2,'.','');
                                            ?>
                                            <tr style="background:<?=$bgTablePago;?>;">
                                                <td style="width:10%">
                                                <span class="contenido2">
                                                    <?php echo "00-".$numero_recibo; ?>
                                                </span>
                                                </td>
                                                <td style="width:10%">
                                                <span class="contenido2" style="font-size:.9em;">
                                                    <?php echo number_format($data['equivalente_pago'],2,',','.'); ?>
                                                </span>
                                                </td>
                                                <td style="width:10%">
                                                    <span class="contenido2" style="font-size:.9em;">
                                                        <?php echo $lider->formatFechaSlash($data['fecha_pago']); ?>
                                                    </span>
                                                </td>
                                                <td style="width:15%">
                                                    <span class="contenido2">
                                                        <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                                                    </span>
                                                </td>
                                                <td style="width:15%">
                                                    <span class="contenido2">
                                                        <?php echo $data['cod_rif'].$data['rif']; ?>
                                                    </span>
                                                </td>
                                                <td style="width:40%">
                                                    <span class="contenido2">
                                                        <?php
                                                            $campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana=despachos.id_campana and campanas.id_campana={$data['id_campana']}");
                                                            if(count($campanas)>1){
                                                                $campana=$campanas[0];
                                                                $concepto = "Abono de ".$data['tipo_pago']." - Campaña ".$campana['numero_campana']."/".$campana['anio_campana']." - Pedido ".$campana['numero_despacho']." - N° ".$data['id_pedido'];
                                                                echo $concepto;
                                                            }
                                                        ?>    
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr style="font-size:1.2em;">
                                    <th>Total</th>
                                    <th><?=number_format($totalRecibido,2,',','.'); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br>
                        <table id="" class="table table-bordered table-striped" style="text-align:left;width:100%;">
                            <thead>
                                <tr style='text-align:center;'>
                                    <td style='padding-left:25px;width:50%;'><b>Contado y Entregado Por</b></td>
                                    <td style='padding-left:25px;width:50%;'><b>Recibido y Contado Por</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  style='text-align:center;'>
                                    <td style='padding-left:25px;'>Dpto. Comercialización <input type="text" name="comercializacion" value=""></td>
                                    <td style='padding-left:25px;'>Dpto. Administración <input type="text" name="administracion" value=""></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Firma</th>
                                    <th>Firma</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
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
<input type="hidden" class="ruta" value="<?php echo $rutaRecarga; ?>">
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
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var ruta = $(".ruta").val();
        window.location = "?"+ruta;
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

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
                  confirmButtonColor: "#ED2A77",
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
</script>
</body>
</html>
