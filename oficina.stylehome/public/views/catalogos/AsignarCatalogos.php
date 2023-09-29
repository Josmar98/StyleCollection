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
        <small><?php if(!empty($action)){ echo $action; } echo " ".$modulo; ?></small>
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
              <h3 class="box-title"><?php if(!empty($action)){ echo $action; } echo " Premios a Factura "; ?></h3>
              <br>
              <br>
              <h4><b>Líder <?=$cliente['primer_nombre']." ".$cliente['primer_apellido']." - ".$cliente['cedula']; ?></b></h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form action="" method="GET">
                  <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                  <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                  <input type="hidden" name="id" value="<?=$_GET['id']; ?>">
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label>Mostrar Premios Canjeados</label>
                      <select class="form-control select2" name="op" style="width:100%;">
                        <option value="1" <?php if(!empty($_GET['op'])){ if($_GET['op']==1){ echo "selected"; } } ?> >Pendientes por asignar a factura</option>
                        <option value="2" <?php if(!empty($_GET['op'])){ if($_GET['op']==2){ echo "selected"; } } ?> >Asignados a la factura de un ciclo</option>
                        <option value="3" <?php if(!empty($_GET['op'])){ if($_GET['op']==3){ echo "selected"; } } ?> >Ambos</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button class="btn enviar2">Enviar</button>
                  </div>
                </form>
              </div>
              <br>
              <table class="table  table-bordered table-striped" style="text-align:center;width:100%;">
                <?php foreach($canjeos as $canje){ if(!empty($canje['id_canjeo'])){ ?>
                  <tr>
                    <td style="width:25%;">
                      <div style="width:100%;">
                        <img style="width:80%;" src="<?=$canje['imagen_inventario']; ?>">
                      </div>
                    </td>
                    <td style="width:30%;">
                      <div style="text-align:left;">
                        <span style="font-size:1.3em;"><b><?=$canje['nombre_inventario']; ?></b></span>
                        <br>
                        <span><b>Cantidad de Puntos:</b> <?=number_format($canje['puntos_inventario'],2,',','.')." pts"; ?></span>
                        <span><?=$canje['descripcion_inventario']; ?></span>
                      </div>
                    </td>
                    <td style="width:40%;">
                      <form action="" method="POST" style="text-align:left;">
                        <div class="form-group">
                          <input type="hidden" name="id_canjeo" value="<?=$canje['id_canjeo']; ?>">
                          <label>Asignar a: </label>
                          <select class="form-control select2" style="width:100%;" name="id_ciclo">
                            <option value="0"></option>
                            <?php foreach ($ciclosDisponibles as $ciclo){ if(!empty($ciclo['id_ciclo'])){  ?>
                              <option value="<?=$ciclo['id_ciclo']; ?>" <?php if($ciclo['id_ciclo']==$canje['id_ciclo']){ echo "selected"; } ?> >
                                <?="Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']; ?>
                              </option>
                            <?php } } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <button class="btn enviar2">Asignar</button>
                        </div>
                      </form>
                    </td>
                  </tr>
                <?php } } ?>
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
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=<?=$url ?>&action=<?=$action; ?>&id=<?=$id ?>&op=<?=$_GET['op']; ?>";
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
