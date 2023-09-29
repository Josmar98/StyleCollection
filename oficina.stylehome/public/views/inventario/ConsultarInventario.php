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

              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
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
                  <?php if($accesoInventariosM || $accesoInventariosE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Puntos</th>
                  <th>estado</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              if(!empty($inventarios)){
                foreach ($inventarios as $data){
                  if(!empty($data['cod_inventario'])){
                    ?>
                  <tr>
                    <td style="width:10%">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                    </td>
                    <?php if($accesoInventariosM || $accesoInventariosE){ ?>
                    <td style="width:15%">
                      <?php if($accesoInventariosM){ ?>
                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['cod_inventario'] ?>">
                          <span class="fa fa-wrench"></span>
                        </button>
                      <?php } ?>
                      <?php if($accesoInventariosM){ ?>
                        <?php 
                          $classView = "";
                          $classExec = "";
                          if($data['inventario_visible']==1){ $classView = "fa-eye"; $classExec = "Ocultar"; }
                          else { $classView = "fa-eye-slash"; $classExec = "Mostrar"; } 
                        ?>
                        <button class="btn OcultarMostrarBtn" style="border:0;background:none;color:#a704c9" value="?route=<?=$url; ?>&operation=<?=$classExec; ?>&id=<?php echo $data['cod_inventario'] ?>">
                          <span class="fa <?=$classView; ?>"></span>
                        </button>
                      <?php } ?>
                      <?php if($accesoInventariosE){ ?>
                        <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['cod_inventario'] ?>&permission=1">
                          <span class="fa fa-trash"></span>
                        </button>
                      <?php } ?>
                    </td>
                    <td style="width:25%">
                      <span class="contenido2">
                        <b>
                          <?php echo $data['cod_inventario']; ?>
                        </b>
                      </span>
                    </td>
                    <?php } ?>
                    <td style="width:25%">
                      <span class="contenido2">
                        <img style="max-width:100px;max-height:100px;" src="<?=$data['imagen_inventario']; ?>">
                        <br>
                        <?php echo $data['nombre_inventario']; ?>
                      </span>
                    </td>                  
                    <td style="width:25%">
                      <span class="contenido2">
                        <?php echo "$".number_format($data['precio_inventario'],2,',','.'); ?>
                      </span>
                    </td>
                    <td style="width:25%">
                      <span class="contenido2">
                        <?php echo $data['puntos_inventario']." pts"; ?>
                      </span>
                    </td>
                    <td style="width:25%">
                      <span class="contenido2">
                        <?php
                          if($data['inventario_visible']==1){
                            echo "Visible";
                          }else{
                            echo "Oculto";
                          }
                        ?>
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
                  <?php if($accesoInventariosM || $accesoInventariosE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Puntos</th>
                  <th>estado</th>
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
<?php if(!empty($response2)): ?>
<input type="hidden" class="responses2" value="<?php echo $response2 ?>">
<?php endif; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
    var response2 = $(".responses2").val();
  if(response==undefined){
  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=Inventario";
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
  if(response2==undefined){
  }else{
    if(response2 == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?route=Inventario";
      });
    }
    if(response2 == "2"){
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

  $(".OcultarMostrarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea cambiar el estado del premio?",
          text: "Se cambiar el estado del premio, ¿desea continuar?",
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
