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
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amProductosR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
            <?php } ?>
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
              <div class="row">
                <div class="col-xs-12" style="text-align:right;">
                    <a href="?route=<?=$_GET['route']; ?>&action=GenerarReporteInventario" target="_blank"><button class="btn btn-success" style="color:#FFF;">Generar Excel</button></a>
                </div>
              </div>
              <br>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th style="width:5%;">Nº</th>
                <?php if($amProductosE==1 || $amProductosB==1){ ?>
                  <th style="width:10%;">---</th>
                <?php } ?>
                  <th style="width:15%;">Producto</th>
                  <th style="width:10%;">Marca</th>
                  <th style="width:25%;">Descripcion</th>
                  <th style="width:10%;">Stock Total</th>
                  <th style="width:20%;">Stock x Almacen</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($productos as $data){ if(!empty($data['id_producto'])){ 
                    ?>
                    <tr>
                      <td>
                        <span class="contenido2">
                          <?php echo $num++; ?>
                        </span>
                      </td>
                      <?php if($amProductosE==1 || $amProductosB==1){ ?>
                      <td>
                            <?php if($amProductosE==1){ ?>
                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&cod=<?php echo $data['codigo_producto'] ?>">
                                <span class="fa fa-wrench">
                                </span>
                              </button>
                            <?php } ?>
                            <?php if($amProductosB==1){ ?>
                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&cod=<?php echo $data['codigo_producto'] ?>&permission=1">
                                <span class="fa fa-trash"></span>
                              </button>
                            <?php } ?>
                      </td>
                      <?php } ?>
                      <td>
                        <span class="contenido2">
                          <?=$data['producto']; ?> (<?php echo $data['cantidad']; ?>)
                          <br>
                          (<b>#<?=strtoupper($data['codigo_producto']); ?></b>)
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php echo $data['marca_producto']; ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php echo $data['descripcion']; ?>
                        </span>
                      </td>
                    
                      <td>
                        <span class="contenido2">
                          <?php echo $data['stock_total']; ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            foreach($almacenes as $alm){
                              if(!empty($alm['id_almacen'])){
                                echo $alm['nombre_almacen'].": ".$data['stock_almacen'.$alm['id_almacen']]."<br>"; 
                              }
                            }
                          ?>
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
                <?php if($amProductosE==1 || $amProductosB==1){ ?>
                  <th>---</th>
                <?php } ?>
                  <th>Producto</th>
                  <th>Marca</th>
                  <th>Descripcion</th>
                  <th>Stock Total</th>
                  <th>Stock x Almacen</th>
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
        window.location = "?route=Productos";
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
