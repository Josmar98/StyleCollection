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

<?php 
$amLiderazgosB = 0;
?>
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
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amLiderazgosR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Liderazgo</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Niveles de ".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if($amLiderazgosE==1||$amLiderazgosB==1): ?>
                  <th>---</th>
                  <?php endif; ?>
                  <th>Titulo</th>
                  <th>Color</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($liderazgos as $data):
                if(!empty($data['id_liderazgo'])):  
            ?>
                <tr style="background :<?=$data['color_liderazgo'];?>33">
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if($amLiderazgosE==1||$amLiderazgosB==1): ?>
                  <td style="width:20%">
                    <!-- <table style="background:;text-align:center;width:100%"> -->
                      <!-- <tr> -->
                        <?php if($amLiderazgosE==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url ?>&action=Modificar&id=<?php echo $data['id_liderazgo'] ?>">
                            <span class="fa fa-wrench">
                            </span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                        <?php if($amLiderazgosB==1): ?>
                        <!-- <td style="width:50%"> -->
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url ?>&id=<?php echo $data['id_liderazgo'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <!-- </td> -->
                        <?php endif; ?>
                      <!-- </tr>
                    </table> -->
                  </td>
                  <?php endif; ?>
                  <td style="width:20%">
                    <span class="contenido2" style="color:<?=$data['color_liderazgo']?>;text-shadow:0px 0px 1px <?=$data['color_liderazgo']?>">
                        <h4>
                      <img src="public/assets/img/liderazgos/<?=$data['nombre_liderazgo']?>logo.png" style="width:30px">        
                          
                      <?php 
                          echo "Líder <b>";
                      ?>
                          <img src="public/assets/img/liderazgos/<?=$data['nombre_liderazgo']?>txt.png" style="width:75px">        
                      <?php
                          // echo $data['nombre_liderazgo'];
                          echo "</b>";
                      ?>

                        </h4>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "<b>". $data['color_liderazgo']."</b>"; ?>
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
                  <?php if($amLiderazgosE==1||$amLiderazgosB==1): ?>
                  <th>---</th>
                  <?php endif; ?>
                  <th>Titulo</th>
                  <th>Color</th>
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
        window.location = "?route=Liderazgos";
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
