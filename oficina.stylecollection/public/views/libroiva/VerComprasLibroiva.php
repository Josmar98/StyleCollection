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
        <li class="active"><?php if(!empty($nameaccion)){echo $nameaccion;} echo " ". $modulo; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amLiderazgosR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=RegistrarCompras" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Lista de Compras - ".$modulo.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div class="table-responsive">
                <table id="datatables" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                  <thead>
                  <tr style="white-space:nowrap;">
                    <th>Nº</th>
                    <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Contable"){  ?>
                    <th>---</th>
                    <?php } ?>
                    <th>Periodo</th>
                    <th>Fecha Factura</th>
                    <th>Nro. Rif</th>
                    <th>Nombre o Razón Social del Proveedor</th>
                    <th>Numero Factura</th>
                    <th>Numero Control</th>
                    <th>Total Compras</th>
                    <th>Compras Exentas</th>
                    <th>Compras Internas Agravadas</th>
                    <th>% Alicuota</th>
                    <th>IVA Alicuota General</th>
                    <th>% de Retención IVA</th>
                    <th>RET IVA Alicuota General</th>
                    <th>Comprobante de Retención de IVA</th>
                    <th>Fecha de Comprobante</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $num = 1;
                    foreach ($compras as $data){
                      if(!empty($data['id_factura_compra'])){
                        ?>
                      <tr style="white-space:nowrap;">
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Contable"){  ?>
                        <td style="width:20%">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?=$url; ?>&action=ModificarCompras&id=<?=$data['id_factura_compra']; ?>">
                            <span class="fa fa-wrench"></span>
                          </button>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?=$url; ?>&action=<?=$action; ?>&id=<?=$data['id_factura_compra']; ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        </td>
                        <?php } ?>
                        <td style="width:20%">
                          <span class="contenido2"><?=$data['periodoMes']."-".$data['periodoAnio']; ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=$lider->formatFecha($data['fechaFactura']); ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=$data['codRif'].$data['rif']; ?></span>
                        </td>
                        <td style="width:20%;text-align:left;">
                          <span class="contenido2"><?=$data['nombreProveedor']; ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=$data['numeroFactura']; ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=$data['numeroControl']; ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=number_format($data['totalCompra'],2,',','.'); ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=number_format($data['comprasExentas'],2,',','.'); ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=number_format($data['comprasInternasGravadas'],2,',','.'); ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=$data['iva']."%"; ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2"><?=number_format($data['ivaGeneral'],2,',','.'); ?></span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?php if($data['opRetencion']==1){ echo $data['porcentajeRetencion']."%"; } else { echo "---"; } ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?php if($data['opRetencion']==1){ echo number_format($data['retencionIva'],2,',','.'); } else { echo "---"; } ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?php if($data['opRetencion']==1){ echo $data['comprobante']; } else { echo "---"; } ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?php if($data['opRetencion']==1){ echo $lider->formatFecha($data['fechaComprobante']); } else { echo "---"; } ?>
                          </span>
                        </td>
                      </tr>
                        <?php
                    } }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nº</th>
                    <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Contable"){  ?>
                    <th>---</th>
                    <?php } ?>
                    <th>Periodo</th>
                    <th>Fecha Factura</th>
                    <th>Nro. Rif</th>
                    <th>Nombre o Razón Social del Proveedor</th>
                    <th>Numero Factura</th>
                    <th>Numero Control</th>
                    <th>Total Compras</th>
                    <th>Compras Exentas</th>
                    <th>Compras Internas Agravadas</th>
                    <th>% Alicuota</th>
                    <th>IVA Alicuota General</th>
                    <th>% de Retención IVA</th>
                    <th>RET IVA Alicuota General</th>
                    <th>Comprobante de Retención de IVA</th>
                    <th>Fecha de Comprobante</th>
                  </tr>
                  </tfoot>
                </table>
                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
              </div>
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
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var route='<?=$url; ?>';
        var action='<?=$action; ?>';
        window.location = `?route=${route}&action=${action}`;
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
