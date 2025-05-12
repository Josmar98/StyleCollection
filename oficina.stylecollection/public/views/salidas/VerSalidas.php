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
              <h3 class="box-title"><?php echo "".$modulo." "; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="" class="form_fechas_operaciones">
              <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
              <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
              <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <input type="date" class="form-control" id="fechaa" name="fechaa" <?php if(!empty($_GET['fechaa'])){ echo 'value="'.$_GET['fechaa'].'"'; } ?>>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <input type="date" class="form-control" id="fechac" name="fechac" <?php if(!empty($_GET['fechac'])){ echo 'value="'.$_GET['fechac'].'"'; } ?>>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <br>
                    <span class="btn enviar2 enviarFechaas">Enviar</span>
                  </div>
                </div>
              </form>
              <hr>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th style="width:5%;">Nº</th>
                <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                  <th style="width:10%;">---</th>
                <?php } ?>
                  <th style="width:15%;">Codigo</th>
                  <th style="width:15%;">Fecha</th>
                  <th style="width:15%;">Persona</th>
                  <th style="width:15%;">Concepto</th>
                  <th style="width:15%;">Total</th>
                  <th style="width:10%;">---</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($ventas as $data){ if(!empty($data['numero_documento'])){ 
                    ?>
                    <tr>
                      <td>
                        <span class="contenido2">
                          <?php echo $num++; ?>
                        </span>
                      </td>
                      <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                      <td>
                            <?php $procederEliminar=false; ?>
                            <?php if($amInventarioE==1){ ?>
                              <!-- <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?=$url; ?>&action=Modificar&cod=<?=$data['id_operacion']; ?>">
                                <span class="fa fa-wrench">
                                  <?=$data['tipo_operacion']; ?>
                                </span>
                              </button> -->
                            <?php } ?>
                            <?php if($procederEliminar==true && $amInventarioB==1){ ?>
                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?=$url; ?>&delete=<?=$data['id_operacion']; ?>">
                                <span class="fa fa-trash"></span>
                              </button>
                            <?php } ?>
                      </td>
                      <?php } ?>
                      <td>
                        <span class="contenido2">
                          <?php
                            $lim = 7;
                            $alterNumeroNew = substr($data['numero_documento'],0,3);
                            $numeroNew = substr($data['numero_documento'],3);
                            $falta = $lim-strlen($numeroNew);
                            $num_doc="";
                            for ($i=0; $i < $falta; $i++) {
                              $num_doc.="0";
                            }
                            $num_doc .= $numeroNew;
                            echo "<b>".$alterNumeroNew.$num_doc."</b>";
                          ?>
                          </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            $timestamp = strtotime($data['fecha_operacion']); 
                            $fechaBonita = date("d/m/Y h:i A", $timestamp); 
                            echo $fechaBonita;
                          ?>
                          </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            echo $data['cod_rif']."-".$data['rif']." ".$data['primer_nombre']." ".$data['primer_apellido'];
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            echo $data['leyenda']." a ".$data['tipo_persona'];
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php 
                            echo number_format($data['precioVenta'],2,',','.');
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php
                            $rutaPdfSalidas = "route=".$_GET['route']."&action=GenerarOrden&cod=".$data['numero_documento'];
                          ?>
                          <a href="?<?=$rutaPdfSalidas; ?>" target="_blank" class="btn enviar2"><span>Generar PDF</span></a>
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
                <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                  <th>---</th>
                <?php } ?>
                  <th>Codigo</th>
                  <th>Fecha</th>
                  <th>Persona</th>
                  <th>Concepto</th>
                  <th>Total</th>
                  <th>---</th>
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
        window.location = "?route=Operaciones";
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

  $(".enviarFechaas").click(function(){
    var fechaa = $("#fechaa").val();
    var fechac = $("#fechac").val();
    if(fechaa!="" && fechac!=""){
      $(".form_fechas_operaciones").submit();
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
