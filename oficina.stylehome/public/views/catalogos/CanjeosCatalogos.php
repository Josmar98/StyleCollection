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
              <h3 class="box-title"><?php echo $modulo." "; if(!empty($action)){ echo $action; } ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div class="row">
                <form action="" method="GET">
                  <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                  <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
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
              <table id="datatable2" class="table  table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Premios canjeados</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  if(!empty($lideres)){
                    $total = 0;
                    foreach ($lideres as $data){ if(!empty($data['id_cliente'])){
                        ?>
                      <tr>
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?=$data['primer_nombre']." ".$data['primer_apellido']; ?>
                            <br>
                            <?php
                              $enlace = "?route=".$url."&action=Asignar&id=".$data['id_cliente'];
                              if(!empty($_GET['op'])){ $enlace .= "&op=".$_GET['op']; }
                            ?>
                            <a href="<?=$enlace ?>"><u>Asignar Premio a Factura</u></a>
                          </span>
                        </td>
                        <td style="width:60%">
                          <span class="contenido2">
                            <table class="table table-hover table-striped">
                            <?php foreach ($canjeos as $data2){ if(!empty($data2['id_canjeo'])){ ?>
                              <?php if($data['id_cliente']==$data2['id_cliente']){ ?>
                                <tr>
                                  <?php
                                    $mensajeMostrarPremiosCanjeados = "";
                                    $mensajeMostrarPremiosCanjeados .= "(".number_format($data2['puntos_inventario'],2,',','.')." pts)";
                                    $mensajeMostrarPremiosCanjeados .= " ";
                                    $mensajeMostrarPremiosCanjeados .= $data2['nombre_inventario'];
                                    $mensajeMostrarPremiosCanjeados .= " <br> ";
                                    if($data2['id_ciclo']!=0){
                                      $cicloAct = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo={$data2['id_ciclo']}");
                                      if(count($cicloAct)>1){
                                        $cicloAct = $cicloAct[0];
                                        $mensajeMostrarPremiosCanjeados .= "(Ciclo ".$cicloAct['numero_ciclo']."/".$cicloAct['ano_ciclo'].")";
                                      }
                                    }
                                    $mensajeMostrarPremiosCanjeados .= " <small>(".$lider->formatFecha($data2['fecha_canjeo'])." ".$data2['hora_canjeo'].")</small>";
                                  ?>
                                  <td >
                                    <?=$mensajeMostrarPremiosCanjeados; ?>
                                  </td>
                                </tr>
                              <?php } ?>
                            <?php } } ?>
                            </table>
                          </span>
                        </td>                  
                      </tr>
                      <?php
                    } }
                  }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Premios canjeados</th>
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
        window.location = "?route=Ciclos";
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
        window.location = "?route=Ciclos";
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
