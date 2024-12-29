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
        <?php echo "Premios"; ?>
        <small><?php echo "Ver Premios de la campaña ".$n; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Premios"; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amPremioscampR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Premio de campaña</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
          <?php 
          if(Count($planes)>1){
            foreach ($planes as $dataPlanes):
              if(!empty($dataPlanes['id_plan'])):
            ?>
      <div class="row">
        <div class="col-sm-10">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="display:inline-block;"><?php echo "Premios de <b>Plan ".$dataPlanes['nombre_plan']."</b> Agregados"; ?></h3>
                  <?php $aprobado = "0";
                      foreach ($tipos_planes as $data): if(!empty($data['tipo_premio'])):  if($dataPlanes['nombre_plan'] == $data['nombre_plan']):
                        $aprobado = "1";
                      endif; endif; endforeach;
                    ?>
              <?php if($aprobado == "1"){ ?>
              <table style="background:none;text-align:center;width:30%;float:right;"><tr>
                  <?php if ($amPremioscampE==1): ?>
                    <td style="width:50%"><button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&plan=<?php echo $dataPlanes['id_plan'] ?>">Editar <span class="fa fa-wrench"></span></button></td>
                  <?php endif ?>
                  <?php if ($amPremioscampB==1): ?>
                  <td style="width:50%"><button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&plan=<?php echo $dataPlanes['id_plan_campana'] ?>&permission=1">Borrar <span class="fa fa-trash"></span></button></td>
                  <?php endif ?>
              </tr></table>
              <?php } ?>



            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table class="datatables table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Tipo de premio</th>
                  <th>Tipo premio producto</th>
                  <th>Premios</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($tipos_planes as $data):
                    if(!empty($data['tipo_premio'])):  
                      if($dataPlanes['nombre_plan'] == $data['nombre_plan']):
                ?>
                <tr>
                  <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $data['tipo_premio']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <?php 
                    foreach ($tipos_premios as $data2): if(!empty($data2['tipo_premio_producto'])):
                    if($data2['nombre_plan']==$dataPlanes['nombre_plan']):
                    if($data['tipo_premio'] == $data2['tipo_premio']){ ?>
                    <span class="contenido2">
                        <?php echo $data2['tipo_premio_producto']; ?>
                    </span>
                    <?php } 
                    endif;
                    endif; endforeach; 
                    ?>
                  </td>
                  <td style="width:20%;text-align:left;">
                    <?php $numPremio = 1; ?>
                    <?php foreach ($tpremios as $data2): if(!empty($data2['tipo_premio_producto'])):
                      if($data2['nombre_plan']==$dataPlanes['nombre_plan']):
                      //======================================================================================================                  //==================== PRODUCTOS ==========================================================                  //======================================================================================================
                      if($data['tipo_premio'] == $data2['tipo_premio'] && $data2['tipo_premio_producto'] == "Productos"):
                        foreach ($productos as $dataProductos): if(!empty($dataProductos['id_producto'])):
                            if($dataProductos['id_producto'] == $data2['id_premio']):
                      ?>
                          
                      <span class="contenido2">
                          <?php echo "• ".$dataProductos['producto']."<br>"; ?>
                      </span>
                        
                      <?php $numPremio++;
                            endif;
                        endif; endforeach; 
                      endif;
                     //====================================================================================================== 
                    
                      //======================================================================================================                  //==================== PREMIOS ==========================================================                  //======================================================================================================
                      if($data['tipo_premio'] == $data2['tipo_premio'] && $data2['tipo_premio_producto'] == "Premios"):
                        foreach ($premios as $dataPremios): if(!empty($dataPremios['id_premio'])):
                           if($dataPremios['id_premio'] == $data2['id_premio']):
                        ?>
                        
                    <span class="contenido2">
                        <?php echo $numPremio."- ".$dataPremios['nombre_premio']."<br>"; ?>
                    </span>
                        <?php $numPremio++;
                            endif; 
                        endif; endforeach; 
                      endif;
                    //====================================================================================================== 

                    endif;endif; endforeach; 
                    ?>
                  </td>
                     
                </tr>
                 <?php
                    endif; endif; endforeach;
                  ?>
                  </tbody>
                <tfoot>
                <tr>
                  <th>Tipo de premio</th>
                  <th>Tipo premio producto</th>
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
          <?php endif; endforeach; }else{ ?>
       <div class="row">
          <div class="col-sm-10">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="display:inline-block;"><?php echo "No hay <b>Planes</b> Agregados en esta campaña"; ?></h3>            
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div class="row">
                <div class="col-xs-12" style="margin-left:3%">
                    <h4 style="width:100%;font-size:1.2em;">
                      <span>ir a </span>
                      <b>
                        
                      <a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Premio de campaña</a>
                      </b>
                    <span> para agregar los planes que seran utilizados en la <b>Campana <?php echo $n."/".$y; ?></b></span>
                    </h4>
                    <br>
                </div>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
      </div>      
         <?php } ?>
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
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosCamp";
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
