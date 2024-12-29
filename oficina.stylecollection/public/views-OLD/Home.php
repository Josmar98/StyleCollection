<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- <body class=""> -->
<div class="wrapper">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <h1>
        <?php echo "Inicio"; ?>
        <!-- <small><?php echo "Ver Campañas"; ?></small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li class="active"><?php echo $url; ?></li>
      </ol>
    </section>
    
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>

        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <!-- <input type="color" value="#EA018C"> -->

            <div class="box-header">
              <h3 class="box-title"><?php echo "Campañas"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Nombre Campaña</th>
                  <th>Numero</th>
                  <!-- <th>---</th> -->
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($campanas as $data):
                if(!empty($data['id_campana'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
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
                 <!--  <td style="width:10%">
                    <table style="background:none;text-align:center;width:100%">
                      <tr>
                        <td style="width:50%">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_campana'] ?>">
                            <span class="fa fa-wrench">
                              
                            </span>
                          </button>
                        </td>
                        <td style="width:50%">
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_campana'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        </td>
                      </tr>
                    </table>
                      
                      
                  </td> -->
                </tr>
            <?php
              endif; endforeach;
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Nombre Campaña</th>
                  <th>Numero</th>
                  <!-- <th>---</th> -->
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
<input type="hidden" id="tiempoActualDeEjecucion" value="<?=time();?>">
<input type="hidden" id="tiempoLimiteDeEjecucion" value="<?=$_SESSION['timeLimiteSystem'];?>">

<?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<script>
$(document).ready(function(){ 
  console.clear();
  var timeLimit = $("#tiempoLimiteDeEjecucion").val();


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
