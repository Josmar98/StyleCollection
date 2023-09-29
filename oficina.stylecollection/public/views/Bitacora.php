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
        <?php echo "Bitácora"; ?>
        <small><?php echo "Ver Bitácora"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Bitácora"; ?></a></li>
        <li class="active"><?php echo "Bitácora"; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
                
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Bitácora"; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form action="" method="get">
                  <input type="hidden" name="route" value="<?=$_GET['route']?>">
                  <div class="form-group col-xs-12 col-md-6">
                    <label for="rangoI">Desde: </label>
                    <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI" required>
                  </div>
                  <div class="form-group col-xs-12 col-md-6">
                    <label for="rangoF">Hasta: </label>
                    <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" required>
                  </div>
                  <br>
                  <div class="form-group col-xs-12 col-md-6">
                    <button class="btn enviar">Enviar</button>
                  </div>
                </form>
              </div>
            </div>
                  <br>
                  <br>

            <div class="box-body">
              <table id="datatable2" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Cuenta</th>
                  <th>Modulo</th>
                  <th>Accion</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($bitacora as $data):
                if(!empty($data['id_bitacora'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <a href="?route=Bitacora&action=Detalles&id=<?=$data['id_bitacora']?>">
                        <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                      </a>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $data['accion'] ?>
                    </span>
                  </td>                  
                  <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $data['modulo'] ?>
                    </span>
                  </td> 
                  <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $lider->formatFecha($data['fecha']) ?>
                    </span>
                  </td> 
                  <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $data['hora'] ?>
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
                  <th>Cuenta</th>
                  <th>Modulo</th>
                  <th>Accion</th>
                  <th>Fecha</th>
                  <th>Hora</th>
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
        window.location = "?route=Campanas";
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
