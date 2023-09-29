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
        <?php echo "Planes de campaña ".$n; ?>
        <small><?php echo "Ver Planes de campaña ".$n; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Planes"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo "Planes"; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amPlanesCampR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Plan de campaña <?php echo $n ?></a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Planes Agregados en campaña ".$n; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if ($amPlanesCampE==1||$amPlanesCampB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Plan</th>
                  <th>Descuento directo</th>
                  <th>Descuentos Puntuales</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($planes_campana);
                foreach ($planes_campana as $data):
                if(!empty($data['id_plan_campana'])):  
                ?>
                <tr style="background:<?=$data['color_plan']?>77">
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if($amPlanesCampE==1 || $amPlanesCampB==1): ?>
                  <td style="width:10%">
                      <?php if($amPlanesCampE==1): ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_plan_campana'] ?>">
                            <span class="fa fa-wrench"></span>
                          </button>
                      <?php endif; ?>
                      <?php if($amPlanesCampB==1): ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_plan_campana'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                      <?php endif; ?>
                  </td>
                  <?php endif; ?>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['nombre_plan']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "$".number_format($data['descuento_directo'],2,',','.'); ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <table style="width:100%;">
                      <?php
                        foreach ($pagos_planes_campana as $data2) {
                          if(!empty($data2['id_plan_campana'])){
                            if($data['id_plan_campana'] == $data2['id_plan_campana']){ ?>
                              <tr>
                                <td style="width:50%;text-align:right;"><?=$data2['tipo_pago_plan_campana']; ?> : </td>
                                <td style="width:50%;"><?="$".number_format($data2['descuento_pago_plan_campana'],2,',','.'); ?></td>
                              </tr>
                            <?php }
                          }
                        }
                      ?>
                      </table>
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
                  <?php if ($amPlanesCampE==1||$amPlanesCampB==1): ?>
                  <th>---</th>
                  <?php endif ?>
                  <th>Plan</th>
                  <th>Descuento directo</th>
                  <th>Descuentos Puntuales</th>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">

<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">


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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PlanesCamp";
        window.location = menu;
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
