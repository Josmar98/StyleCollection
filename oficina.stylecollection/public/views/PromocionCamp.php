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
        <?php echo "Promoción de campaña ".$n; ?>
        <small><?php echo "Ver Promoción"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Promoción"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo "Promoción"; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amPlanesCampR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Promoción</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Promoción de campaña ".$n; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">



              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Nombre de promoción</th>
                  <th>Precio</th>
                  <th>Productos</th>
                  <th>Premios</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($planes_campana);
                foreach ($promocion as $data):
                if(!empty($data['id_promocion'])):  
                ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td >
                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?=$data['id_promocion']?>">
                        <span class="fa fa-wrench"></span>
                      </button>

                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_promocion'] ?>&permission=1">
                          <span class="fa fa-trash"></span>
                      </button>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['nombre_promocion']; ?>
                    </span>
                  </td>
                  <td style="width:10%">
                    <span class="contenido2">
                      <?php echo "$".number_format($data['precio_promocion'],2,',','.'); ?>
                    </span>
                  </td>
                  <td style="width:25%">
                    <span class="contenido2">
                      <?php
                        $nElement = 1;
                        $id_premios_busqueda = 0;
                        foreach ($promocion_productos as $dataProd){ 
                          if(!empty($dataProd['id_promocion'])){
                            if($dataProd['id_promocion']==$data['id_promocion']){
                              $id_premios_busqueda=$dataProd['id_producto'];
                              // print_r($dataProd);
                              if($dataProd['tipo_producto']=="Producto"){
                                foreach ($productos as $prod) {
                                  if(!empty($prod['id_producto'])){
                                    if($prod['id_producto']==$dataProd['id_producto']){
                                      echo "<small>".$nElement."-".$prod['producto']."</small><br>";
                                    }
                                  }
                                }
                              }
                              if($dataProd['tipo_producto']=="Premio"){
                                foreach ($premios as $prem) {
                                  if(!empty($prem['id_premio'])){
                                    if($prem['id_premio']==$dataProd['id_producto']){
                                      echo "<small>".$nElement."-".$prem['nombre_premio']."</small><br>";
                                    }
                                  }
                                }
                              }
                              $nElement++;
                            }
                          }
                        }
                      ?>
                    </span>
                  </td>
                  <td style="width:30%;">
                    <span class="contenido2" style="">
                      <?php
                        $nElement = 1;
                        $premiosinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus = 1 and id_premio = {$id_premios_busqueda}");
                        foreach($premiosinv as $pinv){
                          if(!empty($pinv['id_premio_inventario'])){
                            if($pinv['tipo_inventario']=="Productos"){
                              $queryMosInv = "SELECT *, productos.producto as elemento FROM premios_inventario, productos WHERE premios_inventario.id_inventario=productos.id_producto and productos.id_producto={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                            }
                            if($pinv['tipo_inventario']=="Mercancia"){
                              $queryMosInv = "SELECT *, mercancia.mercancia as elemento FROM premios_inventario, mercancia WHERE premios_inventario.id_inventario=mercancia.id_mercancia and mercancia.id_mercancia={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                            }
                            $inventariosMos = $lider->consultarQuery($queryMosInv);
                            foreach ($inventariosMos as $invm) {
                              if(!empty($invm[0])){
                                echo $invm['unidades_inventario']." ".$invm['elemento']."<br>";
                              }
                            }
                          }
                        }
                      ?>
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
                  <th>---</th>
                  <th>Nombre de promoción</th>
                  <th>Precio</th>
                  <th>Productos</th>
                  <th>Premios</th>
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PromocionCamp";
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
