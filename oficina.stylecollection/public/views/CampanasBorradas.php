<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" style="height:10px;">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo "Campañas"; ?>
        <small><?php echo "Ver Campañas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Campañas"; ?></a></li>
        <li class="active"><?php echo "Campañas"; ?></li>
      </ol>
    </section>

              <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amCampanasR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div>
              <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php 
          $fecha = date('Y-m-d');
          $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '$fecha'");
          if(Count($tasas)>1){ $tasa = $tasas[0];
        ?>
            <div class="col-xs-12 col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title" style="margin-left:15%"><u><b>Tasa del dia</b></u></h3>
                  <?php $fechaHoy = $lider->formatFecha($tasa['fecha_tasa']); ?>
                  <?php 
                    $dd = substr($fechaHoy, 0, 2);
                    $mm = substr($fechaHoy, 3, 2);
                    $yy = substr($fechaHoy, 6, 4);
                    if($mm=="01"){$mm="Enero";}
                    if($mm=="02"){$mm="Fecbrero";}
                    if($mm=="03"){$mm="Marzo";}
                    if($mm=="04"){$mm="Abril";}
                    if($mm=="05"){$mm="Mayo";}
                    if($mm=="06"){$mm="Junio";}
                    if($mm=="07"){$mm="Julio";}
                    if($mm=="08"){$mm="Agosto";}
                    if($mm=="09"){$mm="Septiembre";}
                    if($mm=="10"){$mm="Octubre";}
                    if($mm=="11"){$mm="Noviembre";}
                    if($mm=="12"){$mm="Diciembre";}
                  ?>
                  <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>Bs. ".number_format($tasa['monto_tasa'],4,',','.')."</b> al ".$dd." de ".strtolower($mm)." del ".$yy; ?></h4>
                  <!-- <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>$".number_format($tasa['monto_tasa'],4,',','.')."</b> a la fecha ".$fechaHoy; ?></h4> -->
                </div>
              </div>
            </div>
        <?php } ?>

        
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Campañas"; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatable2" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if ($amCampanasE==1||$amCampanasB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Nombre Campaña</th>
                  <th>Numero</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($campanass as $data):
                if(!empty($data['id_campana'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if ($amCampanasE==1||$amCampanasB==1): ?>
                  <td style="width:10%">
                    <!-- <table style="background:none;text-align:center;width:100%"> -->
                      <!-- <tr> -->
                        
                        <?php if ($amCampanasB==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_campana'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <!-- </td> -->
                        <?php endif ?>
                      <!-- </tr> -->
                    <!-- </table> -->
                  </td>
                  <?php endif ?>
                  <td style="width:20%">
                    <span class="contenido2">
                      <a href="?campaing=<?php echo $data['id_campana'] ?>&n=<?php echo $data['numero_campana'] ?>&y=<?php echo $data['anio_campana'] ?>&route=Homing">
                        <?php echo $data['nombre_campana'] ?>
                      </a>
                    </span>
                  </td>                  
                  <td style="width:20%">
                    <span class="contenido2">
                      <!-- <a href="?campaing=<?php echo $data['id_campana'] ?>&n=<?php echo $data['numero_campana'] ?>&y=<?php echo $data['anio_campana'] ?>&route=Homing"> -->
                        <?php if(strlen($data['numero_campana']) == 1){ echo "0"; }
                        echo $data['numero_campana']." / ".$data['anio_campana']; ?>
                      <!-- </a> -->
                    </span>
                  </td>
                      
                </tr>
          <?php
              endif; endforeach;
          ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if ($amCampanasE==1||$amCampanasB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Nombre Campaña</th>
                  <th>Numero</th>
                </tr>
                </tfoot>
              </table>

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
        window.location = "?route=CampanasBorradas";
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
