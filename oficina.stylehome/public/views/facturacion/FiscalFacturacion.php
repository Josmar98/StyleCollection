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
        <small><?php echo $modulo; if(!empty($action)){echo " ".$action;} ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php echo $modulo; if(!empty($action)){echo " ".$action; } ?></li>
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

        <div class="col-xs-12 col-sm-6">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $modulo; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <?php if($accesoFacturacionM || $accesoFacturacionE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Precio Fiscal del Dolar</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($facturas as $data):
                if(!empty($data['precio_dolar_fiscal'])):  
            ?>
                <tr>
                  <?php if($accesoFacturacionM || $accesoFacturacionE){ ?>
                  <td style="width:10%">
                    <?php if($accesoFacturacionM){ ?>
                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu; ?>&route=<?=$url; ?>&action=<?=$action; ?>&operation=Modificar&id=<?=$data['id_fiscal']; ?>">
                        <span class="fa fa-wrench"></span>
                      </button>
                    <?php } ?>
                    <?php if($accesoFacturacionE){ ?>
                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu; ?>&route=<?=$url; ?>&action=<?=$action; ?>&id=<?=$data['id_fiscal']; ?>&permission=1">
                        <span class="fa fa-trash"></span>
                      </button>
                    <?php } ?>
                  </td>
                  <?php } ?>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "Bs. ".number_format($data['precio_dolar_fiscal'],2,',','.'); ?>
                    </span>
                  </td>
                </tr>
          <?php
              endif; endforeach;
          ?>
                </tbody>
                <tfoot>
                <tr>
                  <?php if($accesoFacturacionM || $accesoFacturacionE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Precio Fiscal del Dolar</th>
                </tr>
                </tfoot>
              </table>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-xs-12 col-sm-6">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Configuracion de Facturas"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="" method="post">
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="precio_col">Precio de Coleccion</label>
                    <?php if(!empty($_GET['operation']) && $_GET['operation']=="Modificar"){ $facturas = $facturas[0]; ?>
                      <input type="number" step="0.01" class="form-control" value="<?=$facturas['precio_dolar_fiscal']?>" min="0" name="precio_col" id="precio_col">
                    <?php }else{ ?>
                      <input type="number" step="0.01" class="form-control" value="0" min="0" name="precio_col" id="precio_col">
                    <?php } ?>
                       <span id="error_precio_col" class="errors"></span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <?php if(!empty($_GET['operation']) && $_GET['operation']=="Modificar"){ ?>
                          <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
                    <?php }else{ ?>
                          <?php if(count($facturas)<2){ ?>
                            <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
                          <?php } ?>
                    <?php } ?>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar d-none" disabled="">enviar</button>
                  </div>
              </form>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

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
<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
</style>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Cambios guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>&action=<?=$action; ?>";
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
    if(response == "9"){
      swal.fire({
          type: 'error',
          title: '¡Precio de Coleccion Ya establecido en esta Campaña!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>&action=<?=$action; ?>";
        window.location = menu;
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


  $(".enviar").click(function(){
    var response = validarEnvio();

    if(response == true){
      $(".btn-enviar").attr("disabled");

       swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){      
              // var campaing = $(".campaing").val();
              // var n = $(".n").val();
              // var y = $(".y").val();
              // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=LiderazgosCamp";
              // $.ajax({
              //       url: '?campaing='+campaing+'&n='+n+'&y='+y+'&route=LiderazgosCamp&action=Registrar',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         id_liderazgo: $("#titulo").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                //       }
                //       if (respuesta == "9"){
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Los datos ingresados estan repetidos!',
                //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                //         });
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                //         });
                //       }
                //     }
                // });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });



    
    }
  });

});  
function validarEnvio(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var precio_col = $("#precio_col").val();
  var rprecio_col = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( precio_col > 0){
      $("#error_precio_col").html("");
      rprecio_col = true;
    }else{
      rprecio_col = false;
      $("#error_precio_col").html("Debe establecer un precio para la coleccion en Bs.");
    }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rprecio_col==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}

</script>
</body>
</html>
