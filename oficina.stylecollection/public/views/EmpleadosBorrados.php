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
        <?php echo "{$modulo} Suspendidos"; ?>
        <small><?php echo "Ver {$modulo} Suspendidos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "{$modulo} Suspendidos"; ?></a></li>
        <li class="active"><?php echo "{$modulo} Suspendidos"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "{$modulo} Suspendidos"; ?></h3>
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
              // print_r($clientes);
              foreach ($empleadoss as $data){
                if(!empty($data['id_empleado'])){
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if ($amEmpleadosE==1||$amEmpleadosB==1){ ?>                    
                  <td style="width:10%">
                        <?php if ($amEmpleadosB){ ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?route=EmpleadosBorrados&id=<?php echo $data['id_empleado'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <?php } ?>
                  </td>
                  <?php } ?>
                  <td style="width:5%">
                    <span class="contenido2">
                    <!-- <a href="?route=Empleados&action=Detalles&id=<?php echo $data['id_cliente'] ?>"> -->
                      <?php echo $data['cedula']; ?>
                    <!-- </a> -->
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                    <!-- <a href="?route=Empleados&action=Detalles&id=<?php echo $data['id_cliente'] ?>"> -->
                    <?php echo $data['primer_nombre']." ".$data['segundo_nombre']; ?>
                    <!-- </a> -->
                    </span>
                  </td>
                  
                  <td style="width:20%">
                    <span class="contenido2">
                    <!-- <a href="?route=Empleados&action=Detalles&id=<?php echo $data['id_cliente'] ?>"> -->
                      <?php echo $data['primer_apellido']." ".$data['segundo_apellido']; ?>
                    <!-- </a> -->
                    </span>
                  </td>

                  <!-- <td  class="col-xs-none" style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['correo']; ?>
                    </span>
                  </td>
                  <td  class="col-xs-none" style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['direccion']; ?>
                    </span>
                  </td> -->
                  <!-- 
                  <td  class="col-xs-none" style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['sexo']; ?>
                    </span>
                  </td> -->
                  <!-- <td style="width:20%">
                    <span class="contenido2">
                        <?php echo $data['cod_rif']."-".$data['rif']; ?>
                    </span>
                    </td> -->

                      
                      
                </tr>
          <?php
              } }
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
          title: '¡Datos restaurados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=EmpleadosBorrados";
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
          title: "¿Desea restaurar al empleado?",
          text: "Se restaura al empleado escogido, ¿desea continuar?",
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
                    title: "¿Esta seguro de restaurar al empleado?",
                    text: "El empleado restaurado podra estar disponible en el sistema, ¿desea continuar?",
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
