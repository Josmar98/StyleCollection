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
        <?php echo $url; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
            
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <!-- <th>---</th> -->
                  <th>Líder</th>
                  <th>Premios Canjeados</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($clientes);
                foreach ($lideres as $data):
                if(!empty($data['id_cliente'])):  
                ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:35%">
                    <span class="contenido2">
                      <?php echo number_format($data['cedula'], 0, '.','.')." ".$data['primer_nombre']." ".$data['primer_apellido']; ?>
                      <br>
                      <a href="?route=<?=$_GET['route']?>&action=Asignar&id=<?=$data['id_cliente'];?>"><u>Asignar a nota de entrega</u></a>
                    </span>
                  </td>
                  <td style="width:60%">
                        <table class="table" style="background:none;">
                    <?php 
                      foreach ($premiosCanjeados as $data2) { if(!empty($data2['id_canjeo'])){
                        if($data['id_cliente'] == $data2['id_cliente']){
                    ?>
                      <?php if ($data2['estado_canjeo']=="Asignado"): ?>
                          <tr>
                            <td>
                              <span class="contenido2" style='color:#CCC'>
                                <?php echo "<img style='width:20px;margin-right:1px;' src='{$fotoGema}'> ".$data2['cantidad_gemas']." <span style='margin-right:5px;margin-left:5px;'>-</span> ".$data2['nombre_catalogo']." -> ";
                                foreach ($campanas as $camp) {
                                  if(!empty($camp['id_campana'])){
                                    if($data2['id_campana'] == $camp['id_campana']){
                                      echo "(Camp ".$camp['numero_campana']."/".$camp['anio_campana'].")";
                                    }
                                  }
                                }
                                // echo "<br>"; 
                                ?>
                              </span>
                            </td>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor2" || $_SESSION['nombre_rol']=="Analista2"): ?>
                            <td>
                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data2['id_canjeo'] ?>&permission=1">
                                <span class="fa fa-trash"></span>
                              </button>
                            </td>
                            <?php endif ?>
                          </tr>
                      <?php else: ?>
                        <tr>
                          <td>
                            <span class="contenido2">
                              <?php echo "<img style='width:20px;margin-right:1px;' src='{$fotoGema}'> ".$data2['cantidad_gemas']." <span style='margin-right:5px;margin-left:5px;'>-</span> ".$data2['nombre_catalogo']."<br>"; ?>
                            </span>
                          </td>
                          <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor2" || $_SESSION['nombre_rol']=="Analista2"): ?>
                          <td>
                            <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data2['id_canjeo'] ?>&permission=1">
                              <span class="fa fa-trash"></span>
                            </button>
                          </td>
                          <?php endif ?>
                        </tr>
                      <?php endif; ?>
                    <?php 
                        }
                      } }
                    ?>
                        </table>
                  </td>
                      
                </tr>
                <?php
               endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <!-- <th>---</th> -->
                  <th>Líder</th>
                  <th>Premios Canjeados</th>
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
          title: '¡Premio borrado correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Canjeados";
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
                      // alert($(this).val());
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
