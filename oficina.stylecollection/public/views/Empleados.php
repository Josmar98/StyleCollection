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
        <?php echo "".$modulo; ?>
        <small><?php echo "Ver ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "".$modulo; ?></a></li>
        <li class="active"><?php echo "".$modulo; ?></li>
      </ol>
    </section>
              <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amEmpleadosR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$modulo; ?></a></div>
              <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if ($amEmpleadosE==1 || $amEmpleadosB==1){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Cedula</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <!-- <th>Correo</th> -->
                  <!-- <th>Direccion</th> -->
                  <!-- <th>Rif</th> -->
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($empleados as $data){
                if(!empty($data['id_empleado'])){
                  ?>
                  <tr>
                    <td style="width:5%">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                    </td>
                    <?php if ($amEmpleadosE==1||$amEmpleadosB==1): ?>                    
                    <td style="width:10%">
                          <?php if ($amEmpleadosE==1): ?>
                            <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_empleado'] ?>">
                              <span class="fa fa-wrench">
                                
                              </span>
                            </button>
                          <?php endif ?>
                          <?php if ($amEmpleadosB): ?>
                            <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_empleado'] ?>&permission=1">
                              <span class="fa fa-trash"></span>
                            </button>
                          <?php endif ?>
                    </td>
                    <?php endif ?>
                    <td style="width:5%">
                      <span class="contenido2">
                      <!-- <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_empleado'] ?>"> -->
                        <?php echo $data['cedula']; ?>
                      <!-- </a> -->
                      </span>
                    </td>
                    <td style="width:20%">
                      <span class="contenido2">
                      <!-- <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_empleado'] ?>"> -->
                      <?php echo $data['primer_nombre']." ".$data['segundo_nombre']; ?>
                      <!-- </a> -->
                      </span>
                    </td>
                    
                    <td style="width:20%">
                      <span class="contenido2">
                      <!-- <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_empleado'] ?>"> -->
                        <?php echo $data['primer_apellido']." ".$data['segundo_apellido']; ?>
                      <!-- </a> -->
                      </span>
                    </td>
                        
                  </tr>
                  <?php
                }
              }
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if ($amEmpleadosE==1 || $amEmpleadosB==1){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Cedula</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <!-- <th>Correo</th> -->
                  <!-- <th>Direccion</th> -->
                  <!-- <th>Rif</th> -->

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
          title: '¡Lider suspendido correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Empleados";
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
          title: "¿Desea suspender al empleado?",
          text: "Se suspendera al empleado escogido, ¿desea continuar?",
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
                    title: "¿Esta seguro de suspender al empleado?",
                    text: "El empleado suspendido no estara disponible en el sistema, ¿desea continuar?",
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
