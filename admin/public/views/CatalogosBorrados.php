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
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar en Catalogo</a></div>
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

                  <div class="row box<?=$cant['cantidad_gemas']?>" style="margin-top:5px">
                    <?php foreach ($catalogos as $data): ?>
                      <?php if (!empty($data['codigo_catalogo'])): ?>
                          <?php if (!empty($_GET['t']) && $_GET['t']=="1"): ?>
                          <div class="col-xs-12 col-sm-6 col-md-4" style="text-align:center;font-size:1.1em;padding:0 5px;">
                          <?php endif; ?>
                          <?php if ((!empty($_GET['t']) && $_GET['t']=="0") || empty($_GET['t'])): ?>
                          <div class="col-xs-6 col-sm-4 col-md-3" style="text-align:center;font-size:1.1em;padding:0 5px;">
                          <?php endif; ?>
                          <?php

                            $disenioModelo = "";
                            $anchoModelo = "";
                            $altoModelo = "";

                            if($data['imagen_catalogo1'] != ""){
                              $ancho = "";
                              $alto = "";
                              if(file_exists($data['imagen_catalogo1'])){
                                $imagen = getimagesize($data['imagen_catalogo1']); //Sacamos la información.
                                $ancho = $imagen[0]; //Ancho.
                                $alto = $imagen[1]; //Alto.
                                if($disenioModelo==""){ $disenioModelo = $data['imagen_catalogo1']; }
                              }
                              if($anchoModelo==""){ $anchoModelo = $ancho; }
                              if($altoModelo==""){ $altoModelo = $alto; }
                            }
                            // if($data['ficha_catalogo'] != ""){
                            //   $anchoFicha = "";
                            //   $altoFicha = "";
                            //   if(file_exists($data['ficha_catalogo'])){
                            //     $ficha = getimagesize($data['ficha_catalogo']); //Sacamos la información.
                            //     $anchoFicha = $ficha[0]; //AnchoImagen.
                            //     $altoFicha = $ficha[1]; //AltoImagen.
                            //     if($disenioModelo==""){ $disenioModelo = $data['ficha_catalogo']; }
                            //   }
                            //   if($anchoModelo==""){ $anchoModelo = $anchoFicha; }
                            //   if($altoModelo==""){ $altoModelo = $altoFicha; }
                            // }
                            // if($data['ficha_catalogo2'] != ""){
                            //   $anchoFicha2 = "";
                            //   $altoFicha2 = "";
                            //   if(file_exists($data['ficha_catalogo2'])){
                            //     $ficha = getimagesize($data['ficha_catalogo2']); //Sacamos la información.
                            //     $anchoFicha2 = $ficha[0]; //AnchoImagen.
                            //     $altoFicha2 = $ficha[1]; //AltoImagen.
                            //     if($disenioModelo==""){ $disenioModelo = $data['ficha_catalogo2']; }
                            //   }
                            //   if($anchoModelo==""){ $anchoModelo = $anchoFicha2; }
                            //   if($altoModelo==""){ $altoModelo = $altoFicha2; }
                            // }
                            // if($data['ficha_catalogo3'] != ""){
                            //   $anchoFicha3 = "";
                            //   $altoFicha3 = "";
                            //   if(file_exists($data['ficha_catalogo3'])){
                            //     $ficha = getimagesize($data['ficha_catalogo3']); //Sacamos la información.
                            //     $anchoFicha3 = $ficha[0]; //AnchoImagen.
                            //     $altoFicha3 = $ficha[1]; //AltoImagen.
                            //     if($disenioModelo==""){ $disenioModelo = $data['ficha_catalogo3']; }
                            //   }
                            //   if($anchoModelo==""){ $anchoModelo = $anchoFicha3; }
                            //   if($altoModelo==""){ $altoModelo = $altoFicha3; }
                            // }
                            // if($data['ficha_catalogo4'] != ""){
                            //   $anchoFicha4 = "";
                            //   $altoFicha4 = "";
                            //   if(file_exists($data['ficha_catalogo4'])){
                            //     $ficha = getimagesize($data['ficha_catalogo4']); //Sacamos la información.
                            //     $anchoFicha4 = $ficha[0]; //AnchoImagen.
                            //     $altoFicha4 = $ficha[1]; //AltoImagen.
                            //     if($disenioModelo==""){ $disenioModelo = $data['ficha_catalogo4']; }
                            //   }
                            //   if($anchoModelo==""){ $anchoModelo = $anchoFicha4; }
                            //   if($altoModelo==""){ $altoModelo = $altoFicha4; }
                            // }
                          ?>
                          <style>
                            .boxCatalogo:hover{
                              border:1px solid rgba(230,230,230,1) !important;
                              box-shadow:0px 8px 15px rgba(230,230,230,1) !important;
                            }
                          </style>
                          <?php if (!empty($_GET['t']) && $_GET['t']=="1"): ?>
                            <div class='boxCatalogo' style="border:0px solid <?=$color?>;background:rgba(252,252,252,1);height:35em;">
                          <?php endif; ?>
                          <?php if ((!empty($_GET['t']) && $_GET['t']=="0") || empty($_GET['t'])): ?>
                            <div class='boxCatalogo' style="border:0px solid <?=$color?>;background:rgba(252,252,252,1);height:25em;">
                          <?php endif; ?>
                              <div class="" style="width:90%;height:65%;margin-left:auto;margin-right:auto;">
                                <?php if ($disenioModelo!=""): ?>
                                  <?php if ($altoModelo >= $anchoModelo): ?>
                                    <img style="margin:0;padding:0 0;padding-top:5%;min-height:50%;max-height:100%;max-width:100%;" class="" src="<?=$disenioModelo;?>">
                                  <?php endif ?>
                                  <?php if ($altoModelo < $anchoModelo): ?>
                                    <img style="margin:0;padding:0 0;padding-top:5%;min-height:50%;max-height:100%;" class="col-xs-12" src="<?=$disenioModelo;?>">
                                  <?php endif ?>
                                <?php endif; ?>
                              </div>
                              <div class="row" style="height:12.5%;padding:2% 0;">
                                <div class="col-xs-10 col-xs-offset-1" style="border-bottom:0px solid <?=$color?>;">
                                  <b style="color:<?=$fucsia?>"><?=$data['nombre_catalogo']?></b>
                                </div>
                              </div>
                              <?php if ($data['codigo_catalogo']!=""): ?>
                              <div class="" style="border-bottom:1px solid <?=$color?>;">
                                <b>#<?=$data['codigo_catalogo']?></b>
                              </div>
                              <?php endif; ?>
                                <div class="row">
                                  <div class="col-xs-12" style="height:12.5%;width:100%;margin-top:2%;" >
                                      
                                      <button class="eliminarBtn btn" style="font-size:1em;border:0;background:none;background:#04a7c9;color:#FFF;width:40%;height:auto;margin-left:auto;margin-right:auto;display:inline-block;" value="?route=<?php echo $url; ?>&id=<?php echo $data['codigo_catalogo'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                  </div>
                                </div>

                              
                            </div>
                            <br>
                          </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>

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
        window.location = "?route=CatalogosBorrados";
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
