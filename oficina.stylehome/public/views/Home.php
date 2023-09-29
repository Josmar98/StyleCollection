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
    <section class="content-header" >
      <h1>
        <?php echo $modulo; ?>
        <!-- <small><?php echo "Ver Ciclos"; ?></small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> <?=$modulo ?> </a></li>
        <li class="active"><?php echo $modulo; ?></li>
      </ol>
    </section>
    <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. -->

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        

        <div class="col-xs-12">
          <!-- <input type="color" value="#0204B7" name=""> -->
          <!-- <p style="font-weight:500;">Probando</p> -->
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Ciclo"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable2" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Numero de Ciclo</th>
                  <?php
                    if(
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
                    ){
                  ?>
                  <th>Estado del Ciclo</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  if(!empty($ciclos)){
                    foreach ($ciclos as $data){
                      if(!empty($data['id_ciclo'])){
                        $permitir = 0;
                        if($data['visibilidad_ciclo']){
                          $permitir = 1;
                        }else{
                          if(
                            mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") ||
                            mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") ||
                            mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo") ||
                            mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor") ||
                            mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
                            
                          ){
                            $permitir = 1;
                          }
                        }
                        if($permitir){
                        ?>
                          <tr>
                            <td style="width:5%">
                              <span class="contenido2">
                                <?php echo $num++; ?>
                              </span>
                            </td>
                            <td style="width:20%">
                              <span class="contenido2">
                                <a href="?c=<?=$data['id_ciclo']; ?>&n=<?=$data['numero_ciclo']; ?>&y=<?=$data['ano_ciclo']; ?>&route=CHome">
                                  <?php
                                    echo "Ciclo ";
                                    if(strlen($data['numero_ciclo']) == 1){ echo "0"; }
                                    echo $data['numero_ciclo']."/".$data['ano_ciclo'];
                                  ?>
                                </a>
                              </span>
                            </td>
                            <?php
                              if(
                                mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") ||
                                mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") ||
                                mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo") ||
                                mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor") ||
                                mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
                              ){
                            ?>
                            <td style="width:20%">
                              <span class="contenido2">
                                <?php
                                  if($data['estado_ciclo']==0){
                                    echo "Cerrado";  
                                  }else{
                                    echo "Activo";  
                                  }
                                  if($data['visibilidad_ciclo']==0){
                                    echo " / Oculto";
                                  }
                                ?>
                              </span>
                            </td>
                            <?php } ?>             
                          </tr>
                        <?php
                        }
                      }
                    }
                  }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Numero de Ciclo</th>
                  <?php
                    if(
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor") ||
                      mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
                    ){
                  ?>
                  <th>Estado del Ciclo</th>
                  <?php } ?>
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
          title: '¡Datos borrados correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Ciclos";
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
