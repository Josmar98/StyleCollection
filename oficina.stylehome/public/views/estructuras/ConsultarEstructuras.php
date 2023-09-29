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
            <?php if($accesoEstructurasR){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?php echo $modulo; ?></a></div>
            <?php } ?>
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
                  <?php if($accesoEstructurasM || $accesoEstructurasE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Nombre y Apellido</th>
                  <th>Rol</th>
                  <th>Detalle</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($clientes);
                foreach ($analistas as $data):
                if(!empty($data['id_usuario'])):  
                ?>
                  <?php foreach ($estructurasAnalistas as $data2): ?>
                    <?php if (!empty($data2['analista'])): ?>
                      <?php if ($data['id_usuario']==$data2['analista']): ?>
                        
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if($accesoEstructurasM || $accesoEstructurasE){ ?>
                  <td style="width:10%">
                    <?php if($accesoEstructurasM){ ?>
                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?=$url; ?>&action=Modificar&id=<?=$data2['analista'] ?>">
                        <span class="fa fa-wrench"></span>
                      </button>
                    <?php } ?>
                    <?php if($accesoEstructurasE){ ?>
                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?=$url; ?>&id=<?=$data2['analista'] ?>&permission=1">
                        <span class="fa fa-trash"></span>
                      </button>
                    <?php } ?>
                  </td>
                  <?php } ?>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['nombre_rol']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <u><b><a href="?route=<?=$url; ?>&action=Detalle&id=<?=$data2['analista'] ?>">Ver Estructura</a></b></u>
                    </span>
                  </td>
                      
                      
                </tr>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php
               endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if($accesoEstructurasM || $accesoEstructurasE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Nombre y Apellido</th>
                  <th>Rol</th>
                  <th>Detalle</th>
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
        window.location = "?route=Estructuras";
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
