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
        <li><a href="?<?php echo $menu3 ?>&route=Homing2"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu3 ?>&route=Homing2"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu3 ?>&route=<?php echo $url ?>"><?php echo "".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>

              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $modulo." Del Pedido"; ?></h3>
            </div>

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <!-- <th>Nº</th> -->
                  <th>Pedido</th>
                  <?php if ($amDespachosE==1||$amDespachosB==1): ?>
                  <th>---</th>
                  <?php endif; ?>
                  <th>Precio Coleccion</th>
                  <th>Coleccion</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($despachos as $data){ if(!empty($data['id_despacho'])){
                      ?>
                    <tr>
                      <td style="width:30%">
                        <span class="contenido2">
                          <?php echo "Coleccion: Productos"; ?>
                        </span>
                      </td>
                      <?php if ($amDespachosE==1||$amDespachosB==1){ ?>
                        <td style="min-width:20%">
                              <?php if ($amDespachosE==1){ ?>
                                <!-- <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_despacho'] ?>&opInicial=<?=$data['opcion_inicial'];?>&opOpt=<?=$data['opcionOpcionalInicial'];?>&opOblig=<?=$data['opcionInicialObligatorio']; ?>&cantPagos=<?=$data['cantidad_pagos']; ?>">
                                  <span class="fa fa-wrench"></span>
                                </button> -->
                              <?php } ?>
                              <?php if ($amDespachosB==1){ ?>
                                <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_despacho'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button> -->
                              <?php } ?>
                        </td>
                      <?php } ?>
                      <td style="width:30%">
                        <span class="contenido2">
                          <?php echo "$".number_format($data['precio_coleccion'],2,',','.'); ?>
                        </span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2">
                          <?php echo "$".number_format($data['precio_coleccion'],2,',','.'); ?>
                        </span>
                      </td>
                    </tr>
                      <?php
                  } }
                ?>
                <?php 
                  $num = 1;
                  foreach ($despachosSec as $data){ if(!empty($data['id_despacho'])){
                      ?>
                    <tr>
                      <td style="width:30%">
                        <span class="contenido2">
                          <?php echo "Coleccion: ".$data['nombre_coleccion_sec']; ?>
                        </span>
                      </td>
                      <?php if ($amDespachosE==1||$amDespachosB==1){ ?>
                        <td style="min-width:20%">
                              <?php if ($amDespachosE==1){ ?>
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_despacho_sec'] ?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                              <?php } ?>
                              <?php if ($amDespachosB==1){ ?>
                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_despacho_sec'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>
                              <?php } ?>
                        </td>
                      <?php } ?>
                      <td style="width:30%">
                        <span class="contenido2">
                          <?php echo "$".number_format($data['precio_coleccion_sec'],2,',','.'); ?>
                        </span>
                      </td>
                      <td style="width:20%">
                        <span class="contenido2">
                          <?php echo "$".number_format($data['precio_coleccion_sec'],2,',','.'); ?>
                        </span>
                      </td>
                    </tr>
                      <?php
                  } }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <!-- <th>Nº</th> -->
                  <th>Pedido</th>
                  <?php if ($amDespachosE==1||$amDespachosB==1): ?>
                  <th>---</th>
                  <?php endif; ?>
                  <th>Precio Coleccion</th>
                  <th>Coleccion</th>
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
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Colecciones";
        window.location.href=menu;
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
