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
        <?php echo $modulo; ?>
        <small><?php echo "Ver ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php echo $modulo; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatable2" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if($accesoCiclosE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Nombre Campaña</th>
                  <th>Numero</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              if(!empty($ciclos)){
                foreach ($ciclos as $data){
                  if(!empty($data['id_campana'])){
                    ?>
                  <tr>
                    <td style="width:5%">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                    </td>
                    <?php if($accesoCiclosE){ ?>
                    <td style="width:10%">
                      <?php if($accesoCiclosE){ ?>
                        <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_campana'] ?>&permission=1">
                          <span class="fa fa-trash"></span>
                        </button>
                      <?php } ?>
                    </td>
                    <?php } ?>
                    <td style="width:20%">
                      <span class="contenido2">
                          <?php echo $data['nombre_campana'] ?>
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
                  }
                }
              }
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if($accesoCiclosE){ ?>
                  <th>---</th>
                  <?php } ?>
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
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=Ciclos&action=Borrados";
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
