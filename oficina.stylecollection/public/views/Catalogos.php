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
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar en Catalogo</a></div>
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
                    <input type="hidden" name="route" value="Catalogos">
                    <label style="margin:0">Tamaño</label>
                    <select class="form-control" name="t" onchange="if($(this).val()=='0'){ window.location.href='?route=Catalogos'; }else{ $('.tamBtn').click(); }">
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
                        <img style="width:35px;margin-left:15px" src="<?=$fotoGema?>">
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
                        " value="<?=$cant['cantidad_gemas']?>" style="background:none;float:right;margin-top:0px"><span class="fa fa-caret-square-o-up" id="btn<?=$cant['cantidad_gemas']?>" style="font-size:1.2em"></span></button>
                      </h4>
                      <div style="clear:both;"></div>
                    </div>
                  </div>

                  <div class="row box<?=$cant['cantidad_gemas']?>" style="margin-top:5px">
                    <?php foreach ($catalogos as $data): ?>
                      <?php if (!empty($data['id_catalogo'])): ?>
                        <?php if ($data['cantidad_gemas']==$cant['cantidad_gemas']): ?>
                          <?php if (!empty($_GET['t']) && $_GET['t']=="1"): ?>
                          <div class="col-xs-12 col-sm-6 col-md-4" style="text-align:center;font-size:1.1em;padding:0 5px;">
                          <?php endif; ?>
                          <?php if ((!empty($_GET['t']) && $_GET['t']=="0") || empty($_GET['t'])): ?>
                          <div class="col-xs-6 col-sm-4 col-md-3" style="text-align:center;font-size:1.1em;padding:0 5px;">
                          <?php endif; ?>
                          <?php
                            $ancho = "";
                            $alto = "";
                            if($data['imagen_catalogo'] != ""){
                              if(file_exists($data['imagen_catalogo'])){

                              $imagen = getimagesize($data['imagen_catalogo']); //Sacamos la información.
                              $ancho = $imagen[0]; //Ancho.
                              $alto = $imagen[1]; //Alto.
                              }
                            }
                          ?>
                          <style>
                            .boxCatalogo:hover{
                              /*border:1px solid rgba(230,230,230,1) !important;*/
                              box-shadow:0px 8px 15px rgba(230,230,230,1) !important;
                            }
                          </style>
                          <?php if (!empty($_GET['t']) && $_GET['t']=="1"): ?>
                            <div class='boxCatalogo' style="border:0px solid <?=$color?>;background:rgba(252,252,252,1);height:35em;">
                          <?php endif; ?>
                          <?php if ((!empty($_GET['t']) && $_GET['t']=="0") || empty($_GET['t'])): ?>
                            <div class='boxCatalogo' style="border:0px solid <?=$color?>;background:rgba(252,252,252,1);height:25em;">
                          <?php endif; ?>
                              <div class="" style="width:90%;height:65%;margin-left:auto;margin-right:auto;margin-top:auto;">
                                <?php if (!empty($data['imagen_catalogo'])): ?>
                                  <?php if ($alto >= $ancho): ?>
                                    <img style="margin:0;padding:0 0;padding-top:5%;min-height:50%;max-height:100%;max-width:100%;" class="" src="<?=$data['imagen_catalogo']?>">
                                  <?php endif ?>
                                  <?php if ($alto < $ancho): ?>
                                    <img style="margin:0;padding:0 0;padding-top:5%;min-height:50%;max-height:100%;" class="col-xs-12" src="<?=$data['imagen_catalogo']?>">
                                  <?php endif ?>
                                <?php endif; ?>
                              </div>
                              <div class="row" style="height:12.5%;padding:2% 0;">
                                <div class="col-xs-10 col-xs-offset-1" style="border-bottom:0px solid <?=$color?>;">
                                  <b style="color:<?=$fucsia?>"><?=$data['nombre_catalogo']?></b>
                                </div>
                              </div>
                                  <?php
                                    if($data['id_premio']==0){
                                      echo "<small style='font-size:0.7em;color:red;'><u>No vinculado a inventario</u></small>";
                                    }
                                  ?>

                              <div class="row" style="height:10%;">
                                <div style="color:<?=$fucsia;?>;background:#fff;border:1px solid <?=$fucsia?>;" class="btn col-xs-8 col-xs-offset-2">
                                  <img style="width:25px" src="<?=$fotoGema?>">
                                  <b><?=number_format($data['cantidad_gemas'],2,',','.');?></b>
                                </div>
                              </div>
                              <?php if ($data['codigo_catalogo']!=""): ?>
                              <!-- <div class="" style="border-bottom:1px solid <?=$color?>;">
                                <b>#<?=$data['codigo_catalogo']?></b>
                              </div> -->
                              <?php endif; ?>
                              

                              <?php if($amCatalogosE==1 || $amCatalogosB==1): ?>
                               
                                <div class="row">
                                    
                                  <div class="col-xs-12" style="height:12.5%;width:100%;margin-top:2%;" >
                                          
                                    <?php if($amCatalogosE==1): ?>
                                      <button class="modificarBtn btn" style="font-size:1em;border:0;background:none;background:#04a7c9;color:#FFF;width:40%;height:auto;margin-left:auto;margin-right:auto;display:inline-block;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>">
                                        <span class="fa fa-wrench">
                                          
                                        </span>
                                      </button>
                                    <?php endif; ?>

                                    <?php if($amCatalogosB==1): ?>
                                      <button class="eliminarBtn btn" style="font-size:1em;border:0;background:none;background:red;color:#FFF;width:40%;height:auto;margin-left:auto;margin-right:auto;display:inline-block;" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_catalogo'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                    <?php endif; ?>
                                  
                                  </div>
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
          title: '¡Elemento deshabilitado correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Catalogos";
      });
    }
    if(response == "2"){
      swal.fire({
        type: 'error',
        title: '¡Error al deshabilitar el elemento!',
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
          title: "¿Desea deshabilitar el elemento?",
          text: "Se deshabilitara el elemento escogido, ¿desea continuar?",
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
                    title: "¿Esta seguro de deshabilitar el elemento?",
                    text: "Se deshabilitara el elemento. ¿desea continuar?",
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
