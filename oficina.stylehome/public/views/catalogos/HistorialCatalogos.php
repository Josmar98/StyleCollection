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
              <?php if($personalInterno && empty($_GET['option'])){ ?>
              <div class="row">
                <div class="col-xs-12 col-sm-6" style="text-align:left;">
                  <a href="?route=<?=$_GET['route']; ?>&action=<?=$_GET['action']; ?>&option=All"><u>Ver todo el Historial</u></a>
                </div>
                <div class="col-xs-12 col-sm-6" style="text-align:right;">
                  <a href="?route=<?=$_GET['route']; ?>&action=<?=$_GET['action']; ?>&option=Filtrarr"><u>Filtrar para ver el Historial</u></a>
                </div>
              </div>
              <br>
              <?php } ?>
              <?php if(!empty($_GET['option'])){ ?>
              <div class="row">
                <form action="" method="GET">
                  <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                  <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                  <input type="hidden" name="option" value="Filtrar">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Seleccione al Líder</label>
                      <select class="form-control select2" name="lider" style="width:100%;">
                        <option value=""></option>
                        <?php
                          if(Count($lideres)>1){
                            foreach ($lideres as $data){ if(!empty($data['id_cliente'])){
                              $permitido = 0;
                              if(!empty($accesosEstructuras)){
                                if(count($accesosEstructuras)>1){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$lid['id_cliente']){
                                        $permitido = 1;
                                      }
                                    }
                                  }
                                }else if($personalInterno){
                                  $permitido = 1;
                                }
                              }
                              if($permitido==1){
                                ?>
                                <option value="<?=$data['id_cliente']; ?>" <?php if(!empty($_GET['lider'])){ if($data['id_cliente']==$_GET['lider']){ echo "selected"; } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']; ?></option>
                                <?php
                              }
                            } }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Seleccione el Ciclo</label>
                      <select class="form-control select2" name="ciclo" style="width:100%;">
                        <option value=""></option>
                        <?php
                          if(Count($ciclosAll)>1){
                            foreach ($ciclosAll as $data){ if(!empty($data['id_ciclo'])){
                              ?>
                              <option value="<?=$data['id_ciclo']; ?>" <?php if(!empty($_GET['ciclo'])){ if($data['id_ciclo']==$_GET['ciclo']){ echo "selected"; } } ?>>Ciclo <?=$data['numero_ciclo']."/".$data['ano_ciclo']; ?></option>
                              <?php
                            } }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button class="btn enviar2">Enviar</button>
                  </div>
                </form>

              </div>
              <?php } ?>
              <br>
              <table id="datatable2" class="table  table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Fecha y Hora</th>
                  <th>Concepto</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  if(!empty($historial)){
                    $total = 0;
                    foreach ($historial as $data){
                      if($data['operacion']=="+"){
                        $total += $data['cantidad'];
                      }
                      if($data['operacion']=="-"){
                        $total -= $data['cantidad'];
                      }
                      //if(!empty($data['id_punto'])){
                        ?>
                      <tr>
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?=$data['lider']; ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?=$lider->formatFecha($data['fecha'])." ".$data['hora']; ?>
                          </span>
                        </td>                  
                        <td style="width:20%">
                          <span class="contenido2">
                            <?=$data['concepto']; ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?=$data['operacion']."".number_format($data['cantidad'],2,',','.')." pts"; ?>
                          </span>
                        </td>
                        <td style="width:20%;">
                          <span class="contenido2">
                            <?=number_format($total,2,',','.')." pts"; ?>
                          </span>
                        </td>
                      </tr>
                      <?php
                      //}
                    }
                  }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Líder</th>
                  <th>Fecha y Hora</th>
                  <th>Concepto</th>
                  <th>Cantidad</th>
                  <th>Total</th>
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
