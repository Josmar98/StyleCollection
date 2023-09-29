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
        <?php echo "Pedidos"; ?>
        <small><?php echo "Ver Pedidos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pedidos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Pedidos"; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Pedido</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Pedidos De Campaña"; ?></h3>
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
                  <th>Fechas de Pago</th>
                  <th>Precio Coleccion</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($despachos as $data):
                if(!empty($data['id_despacho'])):  
            ?>
                <tr>
                  <!-- <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td> -->
                  <td style="width:20%">
                    <span class="contenido2">
                      <a href="?<?php echo $menu ?>&dpid=<?php echo $data['id_despacho'] ?>&dp=<?php echo $data['numero_despacho'] ?>&route=Homing2">
                      <?php
                        $ndp = "";
                        if($data['numero_despacho']=="1"){ $ndp = "1er"; }
                        if($data['numero_despacho']=="2"){ $ndp = "2do"; }
                        if($data['numero_despacho']=="3"){ $ndp = "3er"; }
                        if($data['numero_despacho']=="4"){ $ndp = "4to"; }
                        if($data['numero_despacho']=="5"){ $ndp = "5to"; }
                        if($data['numero_despacho']=="6"){ $ndp = "6to"; }
                        if($data['numero_despacho']=="7"){ $ndp = "7mo"; }
                        if($data['numero_despacho']=="8"){ $ndp = "8vo"; }
                        if($data['numero_despacho']=="9"){ $ndp = "9no"; }
                      ?>
                      <?php 
                          if($data['numero_despacho']!="1"){
                            // echo $data['numero_despacho'];
                            echo $ndp;
                          }
                          echo " Pedido ";
                          echo " - Campaña ".$numero_campana."/".$anio_campana;
                      ?>
                      </a>
                    </span>
                  </td>
                  <?php if ($amDespachosE==1||$amDespachosB==1): ?>
                  <td style="min-width:20%">
                    <!-- <table style="background:none;text-align:center;width:100%"> -->
                      <!-- <tr> -->
                        <?php if ($amDespachosE==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_despacho'] ?>&opInicial=<?=$data['opcion_inicial'];?>&opOpt=<?=$data['opcionOpcionalInicial'];?>&opOblig=<?=$data['opcionInicialObligatorio']; ?>&cantPagos=<?=$data['cantidad_pagos']; ?>">
                            <span class="fa fa-wrench">
                              
                            </span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                        <?php if ($amDespachosB==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_despacho'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                      <!-- </tr> -->
                    <!-- </table> -->
                  </td>
                  <?php endif; ?>
                  <td style="width:40%;">
                    <span class="contenido2">
                      <table style="width:100%;">
                        <?php 
                          foreach ($pagos_despacho as $dataPD){ if (!empty($dataPD['id_despacho'])){
                              if($data['id_despacho'] == $dataPD['id_despacho']){ ?>
                                <tr>
                                  <td style="text-align:right;"><?=$dataPD['tipo_pago_despacho']; ?></td>
                                  <td>:</td>
                                  <td><?=$lider->formatFecha($dataPD['fecha_pago_despacho']); ?></td>
                                  <td>|</td>
                                  <td style="text-align:right;"><?=$dataPD['tipo_pago_despacho']." Senior"; ?></td>
                                  <td>:</td>
                                  <td><?=$lider->formatFecha($dataPD['fecha_pago_despacho_senior']); ?></td>
                                </tr>
                              <?php }
                          } }
                        ?>
                      </table>
                    </span>
                  </td>
 
                  <td style="width:20%">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&dpid=<?php echo $data['id_despacho'] ?>&dp=<?php echo $data['numero_despacho'] ?>&route=Homing2"> -->
                      <?php echo "$".number_format($data['precio_coleccion'],2,',','.'); ?>
                      <!-- </a> -->
                    </span>
                  </td>
                      
                      
                </tr>
          <?php
              endif; endforeach;
          ?>
                </tbody>
                <tfoot>
                <tr>
                  <!-- <th>Nº</th> -->
                  <th>Pedido</th>
                  <?php if ($amDespachosE==1||$amDespachosB==1): ?>
                  <th>---</th>
                  <?php endif; ?>
                  <th>Fechas de Pago</th>
                  <th>Precio Coleccion</th>
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=Despachos";
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
