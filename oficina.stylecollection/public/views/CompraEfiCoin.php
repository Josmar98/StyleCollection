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
      <?php
        $nameActionEject=""; 
        if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Analista"){
          $nameActionEject="Registrar&admin=1&select=1"; 
        }else{
          $nameActionEject="Reportar"; 
        }
      ?>
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
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Fecha</th>
                  <th>Líder</th>
                  <th>Referencia</th>
                  <th>Equivalente</th>
                  <?php if(!empty($_GET['admin'])){ ?>
                  <th>---</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($eficoins as $data){
                    if(!empty($data['id_eficoin_div'])){ 
                        if(mb_strtolower($data['estado_pago'])==mb_strtolower("Abonado")){
                            $bgTablePago="rgba(0,210,0,.5)";
                        }else{
                            $bgTablePago="";
                        }
                    ?>
                    <tr style="background:<?=$bgTablePago;?>;">
                      <td style="width:5%">
                        <span class="contenido2">
                          <?php echo $num++; ?>
                        </span>
                      </td>
                      <td style="width:10%">
                        <?php if(mb_strtolower($data['estado_pago'])==mb_strtolower("Reportado")){ ?>
                            <?php
                                $rutaComplemento="";
                                if($_SESSION['nombre_rol']=="Vendedor"){
                                }else{
                                    $rutaComplemento="&admin=1&select=1&lider=".$data['id_cliente'];
                                }
                            ?>
                            <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu3;?>route=<?=$url; ?>&action=Modificar&id=<?=$data['id_eficoin_div'].$rutaComplemento; ?>">
                              <span class="fa fa-wrench"></span>
                            </button>
                            <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu3;?>route=<?php echo $url; ?>&id=<?php echo $data['id_eficoin_div'] ?>&permission=1">
                              <span class="fa fa-trash"></span>
                            </button>
                        <?php } ?>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2" style="font-size:.9em;">
                          <?php echo $lider->formatFecha($data['fecha_pago']); ?>
                        </span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2" style="font-size:.9em;">
                          <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                        </span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2">
                          <?php 
                            if($data['referencia_pago']==""){
                              foreach ($detalleEficoin as $detall) {
                                if(!empty($detall['id_detalle_eficoin'])){
                                  if($data['id_eficoin_div']==$detall['id_eficoin_div']){
                                    echo $detall['referencia_pago']."<br>";
                                  }
                                }
                              }
                            }else{
                              echo $data['referencia_pago']; 
                            }
                          ?>
                        </span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2">
                          <table class='table'  style='background:none;'>

                            <?php
                            $cssstyle=""; 
                            foreach ($detalleEficoin as $detall) {
                              if(!empty($detall['id_detalle_eficoin'])){
                                if($data['id_eficoin_div']==$detall['id_eficoin_div']){
                                  $cssstyle="border-top:2px solid #000 !important;"; 
                                  echo "<tr  style='background:none;'>";
                                    if($detall['turno']==1){ echo "<td>(Mañana)</td>"; }
                                    if($detall['turno']==2){ echo "<td>(Tarde)</td>"; }
                                    echo "<td>".number_format($detall['equivalente_pago'],2,',','.')."</td><td> => </td><td>".number_format($detall['equivalente_pago_total'],2,',','.')."</td>";
                                  echo "</tr>";
                                }
                              }
                            }
                            echo "<tr style='background:none;font-size:1.2em;".$cssstyle."'>";
                            echo "<th></th><th>".number_format($data['equivalente_pago'],2,',','.')."</th><th> => </th><th>".number_format($data['equivalente_pago_extra'],2,',','.')."</th>";
                            echo "</tr>";
                            ?>
                          </table>
                        </span>
                      </td>
                      <?php if(!empty($_GET['admin'])){ ?>
                      <td style="width:20%">
                        <?php 
                          if(mb_strtolower($data['estado_pago'])==mb_strtolower("Abonado")){
                            $pagoID=$data['id_pago'];
                            $rutaPdfEficoin = $menu3."route=".$_GET['route']."&action=GenerarRecepcionPago&id=".$data['id_eficoin_div'];
                            $rutaPdfEficoinbs = $menu3."route=".$_GET['route']."&action=GenerarRecepcionPago&id=".$data['id_eficoin_div']."&codigo=bs";
                          }
                        ?>
                        <span class="contenido2">
                          <div style='padding:2px;'>
                            <a class="btn enviar2" target="_blank" href="?<?=$rutaPdfEficoin; ?>">PDF en Eficoin</a>
                          </div>
                          <div style='padding:2px;'>
                            <a class="btn enviar2" target="_blank" href="?<?=$rutaPdfEficoinbs; ?>">PDF en Bs</a>
                          </div>
                        </span>
                      </td>
                      <?php } ?>
                    </tr>
                    <?php
                    }
                  }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Fecha</th>
                  <th>Líder</th>
                  <th>Referencia</th>
                  <th>Equivalente</th>
                  <?php if(!empty($_GET['admin'])){ ?>
                  <th>---</th>
                  <?php } ?>
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
