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
        <?php echo "Gemas"; ?>
        <small><?php echo "Ver Gemas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo "Configuracion" ?>"><?php echo "Gemas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Gemas"; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Gemas</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Gemas"; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php 

             ?>
            <div class="box-body table-responsive">
              <table id="datatable2" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Lider</th>
                  <th>Campaña</th>
                  <th>Tipo de Gema</th>
                  <th>Gemas ganadas</th>
                  <th>Líderes</th>
                  <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                foreach ($gemas as $data):
                if(!empty($data['id_gema'])):  
                ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:8%">
                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=<?php echo $url; ?>&id=<?php echo $data['id_gema'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                    <?php } ?>
                  </td>
                  <td style="width:16%">
                    <span class="contenido2">
                      <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                    </span>
                  </td>
                  <td style="width:16%">
                    <span class="contenido2">
                      <?php echo "Campaña ".$data['numero_campana']."/".$data['anio_campana']."<br>"."<small>".$data['nombre_campana']."</small>"; ?>
                    </span>
                  </td>
                  <td style="width:16%">
                    <span class="contenido2">
                      <?php echo $data['nombreconfiggema'] ?>
                    </span>
                  </td>
                  <td style="width:16%">
                    <span class="contenido2">
                      <?=number_format($data['cantidad_gemas'],2,',','.')?>
                      <?php if ($data['cantidad_gemas']=="1"): ?> Gema <?php elseif($data['cantidad_gemas']>"0"): ?> Gemas <?php endif; ?>
                    </span>
                  </td> 
                  <td style="width:16%">
                    <?php if ($data['nombreconfiggema']!="Por Colecciones De Factura Directa"): ?>
                    <span class="contenido2" style="text-align:center;">
                      <u>
                      <span class="buttonexpandedhijo1 buttonexpandedhijo1<?=$data['id_gema']?>" id='<?=$data['id_gema']?>'>Ver mas ▼</span>
                      <span style="display:none;" class="buttonexpandedhijo2 buttonexpandedhijo2<?=$data['id_gema']?>" id='<?=$data['id_gema']?>'>Dejar de ver ▲</span>
                      </u>
                        
                      <div style="display:none;" class='boxexpandedhijo boxexpandedhijo<?=$data['id_gema']?>' >
                      <table style="text-align:left;">
                      <?php foreach ($lideresHijos as $hijos): ?>
                        <?php if (!empty($hijos['id_gema_cliente'])): ?>
                        <?php if ($hijos['id_gema']==$data['id_gema']): ?>
                          <tr>
                            <td>
                          <?=$hijos['primer_nombre']." ".$hijos['primer_apellido']?>
                              
                            </td>
                          </tr>
                        <?php endif ?>                        
                        <?php endif ?>                        
                      <?php endforeach ?>
                      </table>
                      </div>
                    </span>
                    <?php endif; ?>
                  </td>
                  <td style="width:7%">
                    <span class="contenido2">
                      <?php echo $data['estado'] ?>
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
                  <th>Lider</th>
                  <th>Campaña</th>
                  <th>Tipo de Gema</th>
                  <th>Gemas ganadas</th>
                  <th>Líderes</th>
                  <th>Estado</th>
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
          title: '¡Gemas restauradas correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?<?=$menu?>&route=GemasBorradas";
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

  $(".buttonexpandedhijo1").click(function(){
    var id = $(this).attr("id");
    $(".buttonexpandedhijo2"+id).show();
    $(this).hide();
    $(".boxexpandedhijo"+id).slideToggle();
  });
  $(".buttonexpandedhijo2").click(function(){
    var id = $(this).attr("id");
    $(".buttonexpandedhijo1"+id).show();
    $(this).hide();
    $(".boxexpandedhijo"+id).slideToggle();
  });
  
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
