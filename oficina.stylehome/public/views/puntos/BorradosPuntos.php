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
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
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
                  <?php if($accesoPuntosM || $accesoPuntosE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Líder</th>
                  <th>Ciclo</th>
                  <th>Concepto de Puntos</th>
                  <th>Disponibles</th>
                  <th>Bloqueados</th>
                  <th>Estado</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($puntos as $data):
                if(!empty($data['id_punto'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if($accesoPuntosM || $accesoPuntosE){ ?>
                  <td style="width:20%">
                    <?php if($accesoPuntosE){ ?>
                      <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu; ?>&route=<?=$url; ?>&action=Borrados&id=<?php echo $data['id_punto'] ?>&permission=1">
                        <span class="fa fa-trash"></span>
                      </button>
                    <?php } ?>
                  </td>
                  <?php } ?>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "Ciclo ".$data['numero_ciclo']."/".$data['ano_ciclo']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php 
                        if($data['concepto']=="1"){
                          echo "Por Factura Directa";
                        } else {
                          echo $data['concepto'];
                        }
                      ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo number_format($data['puntos_disponibles'],2)." pts"; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo number_format($data['puntos_bloqueados'],2)." pts"; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php 
                        if($data['estado_puntos']==0){ echo "Bloqueado"; }
                        if($data['estado_puntos']==1){ echo "Disponible"; }
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
                  <?php if($accesoPuntosM || $accesoPuntosE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Líder</th>
                  <th>Ciclo</th>
                  <th>Concepto de Puntos</th>
                  <th>Disponibles</th>
                  <th>Bloqueados</th>
                  <th>Estado</th>
                </tr>
                </tfoot>
              </table>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

              <!-- <br> -->

                            <!-- <input type="color" name=""> -->
          <?php 
            // $color[0] = "rgb(14, 216, 27)";
            // $color[1] = "rgb(216, 14, 152)";
            // $color[2] = "rgb(105, 14, 216)";
            // $color[3] = "rgb(194, 169, 46)";
            // $color[4] = "rgb(185, 182, 167)";
            // $color[5] = "rgb(140, 218, 238)";
            // $num = 0;
            // foreach ($liderazgos as $data):
            //   if(!empty($data['id_liderazgo'])):
          ?>
              <!-- <div style="border:1px solid #000;background: <?php echo $color[$num] ?>; width: <?php echo ($data['total_descuento'] * 30)."px" ?>; padding:10px;margin-left:5%;"> -->
                <?php 
                  // echo "Líder <b>".$data['nombre_liderazgo']."</b>"; 
                  // echo "<br>";
                  // if($data['maxima_cantidad'] == ""){
                  //   echo "<b>".$data['minima_cantidad']." o más</b>";
                  // }else{
                  //   echo "<b>".$data['minima_cantidad']." - ".$data['maxima_cantidad']."</b>";
                  // }
                  // echo "<br>";
                  // echo "Colecciones";
                ?>    
              <!-- </div> -->
              <?php //$num++; ?>
         <?php //endif; endforeach;?>

            <!-- <br><br> -->




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
<!-- <input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">

<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
 -->


<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>&action=Borrados";
        window.location = menu;
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
