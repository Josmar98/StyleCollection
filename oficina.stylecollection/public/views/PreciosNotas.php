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
        <?php echo "".$modulo; ?>
        <small><?php echo "Ver ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "";} echo "".$modulo; ?></li>
      </ol>
    </section>
            <?php if($amInventarioR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Actualizar <?=$modulo; ?></a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Ver ".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">



              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Descripcion</th>
                  <th>Tipo de Premios</th>
                  <th>Nombre Premio</th>
                  <th>Precio Premio</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                foreach ($preciosPremios as $data){
                  if(!empty($data['id_premio'])){
                    $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$data['id_premio']} ORDER BY id_premio_inventario ASC");
                    for ($i=0; $i < count($prinv)-1; $i++) { 
                      if($prinv[$i]['tipo_inventario']=="Productos"){
                        $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                      }
                      if($prinv[$i]['tipo_inventario']=="Mercancia"){
                        $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                      }
                      foreach ($inventario as $key) {
                        if(!empty($key['elemento'])){
                          $prinv[$i]['elemento']=$key['elemento'];
                        }
                      }
                    }
                    $pricess = 0;
                    foreach($prinv as $inv){
                      if(!empty($inv['id_premio_inventario'])){
                        $pricess+=$inv['precio_notas'];
                      }
                    }
                    if($pricess>0){
                    ?>
                    <tr>
                      <td style="width:5%">
                        <span class="contenido2"><?php echo $num++; ?></span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2"><?=$data['descripcion']; ?></span>
                      </td>
                      <td style="width:23%">
                        <span class="contenido2"><?=$data['tipo_premio']; ?></span>
                      </td>
                      <td style="width:23%">
                        <span class="contenido2"><?=$data['nombre_premio']; ?></span>
                      </td>
                      <td style="width:30%">
                        <span class="contenido2">
                          <?php
                            foreach($prinv as $inv){
                              if(!empty($inv['id_premio_inventario'])){
                                echo $inv['elemento']." [".number_format($inv['precio_notas'],2,',','.')."]<br>";
                              }
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
                  <th>Descripcion</th>
                  <th>Tipo de Premios</th>
                  <th>Nombre Premio</th>
                  <th>Precio Premio</th>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PreciosGema";
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
