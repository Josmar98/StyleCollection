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
        <li><a href="?route=<?php echo $url ?>&action=Ver"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Canjear gemas"; ?></h3>
            </div>
            <!-- /.box-header -->
    
            <div class="box-body">
              <div class="container-fluid">
                <b> Gemas Disponibles: <?=number_format($gemasAdquiridasDisponibles,2,',','.')?> </b>
                <?php $color = "#CCC"; ?>
                <?php foreach ($catalogos as $data): ?>
                  <?php if (!empty($data['id_catalogo'])): ?>
                  <div class="row">
                    <div class="col-xs-12" style="border-top:1px solid <?=$color?>;border-bottom:1px solid <?=$color?>;">
                      <h2 style="color:<?=$fucsia;?>">
                        <img style="width:60px;padding:0;margin:0;margin-left:15px;" src="<?=$fotoGema?>">
                        <b><?=number_format($data['cantidad_gemas'],2,',','.');?> Gemas</b>
                      </h2>
                      <div style="clear:both;"></div>
                    </div>
                  </div>

                  <div class="row box<?=$cant['cantidad_gemas']?>" style="margin-top:5px">

                          <div class="col-xs-12 col-sm-6" style="text-align:center;font-size:1.1em">
                            <div class="row">
                              <div class="">
                                <?php if (!empty($data['imagen_catalogo'])): ?>
                                  <div class="col-xs-3 col-md-3"></div>
                                  <img style="margin:0;padding:0;" class="col-xs-6 col-sm-6 col-md-6" src="<?=$data['imagen_catalogo']?>">
                                  <div class="col-xs-3 col-md-3"></div>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>
                          <style>
                            .title{
                              color:<?=$fucsia; ?>;
                              /*text-transform:uppercase;*/
                              font-size:1.3em;
                            }
                            .info{
                              font-size:1.1em;
                            }
                          </style>
                          <div class="col-xs-12 col-sm-6" style="text-align:left;font-size:1.1em">
                            <table class="tablee" style="width:100%;font-size:1.1em">
                              <?php if ($data['nombre_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Nombre: </label> </td>
                                  <td class="info" style=""> <b><?=$data['nombre_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['codigo_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Codigo: </label> </td>
                                  <td class="info" style=""> <b>#<?=$data['codigo_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['marca_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Marca: </label> </td>
                                  <td class="info" style=""> <b><?=$data['marca_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['color_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Color: </label> </td>
                                  <td class="info" style=""> <b><?=$data['color_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['voltaje_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Voltaje: </label> </td>
                                  <td class="info" style=""> <b><?=$data['voltaje_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['caracteristicas_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Caracteristicas: </label> </td>
                                  <td class="info" style=""> <b><?=$data['caracteristicas_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['puestos_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Puestos: </label> </td>
                                  <td class="info" style=""> <b><?=$data['puestos_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['otros_catalogo']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Otros: </label> </td>
                                  <td class="info" style=""> <b><?=$data['otros_catalogo']?></b> </td>
                                </tr>
                              <?php endif; ?>

                              <?php if ($data['cantidad_gemas']!=""): ?>
                                <tr>
                                  <td class="title" style=""> <label>Costo: </label> </td>
                                  <td class="info" style="">
                                    <img style="width:35px" src="<?=$fotoGema?>">
                                    <b><?=number_format($data['cantidad_gemas'],2,',','.');?></b>
                                  </td>
                                </tr>
                              <?php endif; ?>
                            </table>
                            
                            <div class="" style="margin-top:2%;">
                              <?php if ($gemasAdquiridasDisponibles >= $data['cantidad_gemas']): ?>
                                  <span class="btn enviar2 canjearBtn col-xs-12" style="font-size:1em;border:0;background:none;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></span>
                              <?php else: ?>
                                <button class="btn col-xs-12" style="font-size:1em;color:#FFF;background:#999;border:0;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></button>
                              <?php endif; ?>
                            </div>
                          </div>
                          <br>

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
        window.location = "?route=Catalogos";
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
  
  $(".canjearBtn").click(function(){
    swal.fire({ 
          title: "¿Desea canjear este premio?",
          text: "Al canjear este premio se descontara de su cantidad disponibles de gemas, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Canjear!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                  valueCanjeo: true,
                },
                success: function(respuesta){
                  // alert(respuesta);
                  if (respuesta == "1"){
                    swal.fire({
                        type: 'success',
                        title: '¡Premio canjeado con exito!',
                        confirmButtonColor: "#ED2A77",
                    }).then(function(){
                      window.location = "?route=Catalogo&action=Ver";
                    });
                  }
                  if (respuesta == "2"){
                    swal.fire({
                        type: 'error',
                        title: '¡Error al canjear el premio!',
                        confirmButtonColor: "#ED2A77",
                    });
                  }
                  // if (respuesta == "5"){ 
                  //   swal.fire({
                  //       type: 'error',
                  //       title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                  //       confirmButtonColor: "#ED2A77",
                  //   });
                  // }
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
