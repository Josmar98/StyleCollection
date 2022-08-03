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
        <?php echo $url; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amProductosR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Catalogo</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url." "; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <div class="sm-none">
                    <form action="" method="g">
                    <input type="hidden" name="route" value="CatalogosBorrados">
                    <label style="margin:0">Tamaño</label>
                    <select class="form-control" name="t" onchange="if($(this).val()=='0'){ window.location.href='?route=CatalogosBorrados'; }else{ $('.tamBtn').click(); }">
                      <option <?php if(!empty($_GET['t']) && $_GET['t']=="0"){ echo "selected"; } ?> value="0">Normal</option>
                      <option <?php if(!empty($_GET['t']) && $_GET['t']=="1"){ echo "selected"; } ?> value="1">Grande</option>
                    </select>
                    <button class="tamBtn" style="display:none"></button>
                    </form>
                  </div>
            </div>

            <div class="box-body">
              <div class="container-fluid">
                <?php $color = "#CCC"; ?>
                <?php foreach ($cantidades as $cant): ?>
                  <?php if (!empty($cant['cantidad_gemas'])): ?>
                  <div class="row">
                    <div class="col-xs-12" style="border-top:1px solid <?=$color?>;border-bottom:1px solid <?=$color?>;">
                      <!-- <span class="btn btn-primary"></span> -->
                      <h4>
                        <img style="width:25px;margin-left:15px" src="<?=$fotoGema?>">
                        <b><?=number_format($cant['cantidad_gemas'],2,',','.');?> Gemas</b>
                      <button class="btn enviar2" onclick="
                        var canid=$(this).val();
                        if( $('#btn'+canid).attr('class')=='fa fa-caret-square-o-down'){ 
                          $('.box'+canid).slideDown(); 
                          $('#btn'+canid).attr('class', 'fa fa-caret-square-o-up'); 
                        }
                        else if( $('#btn'+canid).attr('class')=='fa fa-caret-square-o-up'){ 
                          $('.box'+canid).slideUp(); 
                          $('#btn'+canid).attr('class', 'fa fa-caret-square-o-down'); 
                        } 
                        " value="<?=$cant['cantidad_gemas']?>" style="background:none;float:right;margin-top:-7.5px"><span class="fa fa-caret-square-o-up" id="btn<?=$cant['cantidad_gemas']?>" style="font-size:1.2em"></span></button>
                      </h4>
                      <div style="clear:both;"></div>
                    </div>
                  </div>

                  <div class="row box<?=$cant['cantidad_gemas']?>" style="margin-top:5px">
                    <?php foreach ($catalogos as $data): ?>
                      <?php if (!empty($data['id_catalogo'])): ?>
                        <?php if ($data['cantidad_gemas']==$cant['cantidad_gemas']): ?>
                          <?php if (!empty($_GET['t']) && $_GET['t']=="1"): ?>
                          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" style="text-align:center;font-size:1.1em">
                          <?php endif; ?>
                          <?php if ((!empty($_GET['t']) && $_GET['t']=="0") || empty($_GET['t'])): ?>
                          <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2" style="text-align:center;font-size:1.1em">
                          <?php endif; ?>
                            <div style="border:1px solid <?=$color?>;">
                              <div class="">
                                <?php if (!empty($data['imagen_catalogo'])): ?>
                                  <img style="margin:0;padding:0;" class="col-xs-12" src="<?=$data['imagen_catalogo']?>">
                                <?php endif; ?>
                              </div>
                              <div class="" style="border-bottom:1px solid <?=$color?>;">
                                <b><?=$data['nombre_catalogo']?></b>
                              </div>
                              <div style="border-bottom:1px solid <?=$color?>;">
                                <img style="width:20px" src="<?=$fotoGema?>">
                                <b><?=number_format($data['cantidad_gemas'],2,',','.');?></b>
                              </div>
                              <?php if ($data['codigo_catalogo']!=""): ?>
                              <div class="" style="border-bottom:1px solid <?=$color?>;">
                                <b>#<?=$data['codigo_catalogo']?></b>
                              </div>
                              <?php endif; ?>
                              

                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                              <div class="" >
                                      
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                  <button class="btn eliminarBtn" style="font-size:1em;border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_catalogo'] ?>&permission=1">
                                    <span class="fa fa-trash"></span>
                                  </button>
                                <?php endif; ?>
                              
                              </div>
                              <?php endif; ?>
                              
                            </div>
                            <br>
                          </div>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>

                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
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
          title: '¡Datos borrados correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=CatalogosBorrados";
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
