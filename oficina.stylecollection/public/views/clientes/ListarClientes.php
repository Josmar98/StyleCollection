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
        <?php echo "Lideres"; ?>
        <small><?php echo "Ver Lideres"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Lideres"; ?></a></li>
        <li class="active"><?php echo "Lideres"; ?></li>
      </ol>
    </section>
              <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $amClientesR==1){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Lideres</a></div>
              <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Lideres"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>ID</th>
                  <th>Cedula</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <!-- <th>Fecha de Nacimiento</th> -->
                  <!-- <th>Telefono</th> -->
                  <!-- <th>Direccion</th> -->
                  <!-- <th>Correo</th> -->
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($clientes as $data):
                if(!empty($data['id_cliente'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:10%">
                    <span class="contenido2">
                      <?php echo $data['id_cliente']; ?>
                    </span>
                  </td>
                  <td style="width:10%">
                    <span class="contenido2">
                      <?php echo $data['cedula']; ?>
                    </span>
                  </td>
                  <td style="width:10%">
                    <span class="contenido2">
                    <?php echo $data['primer_nombre']." ".$data['segundo_nombre']; ?>
                    </span>
                  </td>
                  
                  <td style="width:10%">
                    <span class="contenido2">
                      <?php echo $data['primer_apellido']." ".$data['segundo_apellido']; ?>
                    </span>
                  </td>

                 <!--  <td style="width:10%">
                    <span class="contenido2">
                      <?php
                        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                        $datet = $lider->formatFechaExtract($data['fecha_nacimiento']);
                        $diat = $datet['day'];
                        $mest = $meses[intval($datet['month'])-1];
                        $yeart = $datet['year'];
                        echo $diat." de ".$mest." de ".$yeart;
                      ?>
                      <?php //echo $lider->formatFechaExtract($data['fecha_nacimiento']); ?>
                    </span>
                  </td>

                  <td style="width:10%">
                    <span class="contenido2">
                      <?php
                        echo $data['telefono'];
                        if(strlen($data['telefono2'])>5){
                          echo " / ".$data['telefono2'];
                        }
                      ?>
                    </span>
                  </td>
                  <td style="width:40%">
                    <span class="contenido2">
                      <?php echo $data['direccion']; ?>
                    </span>
                  </td>
                  <td style="width:15%">
                    <span class="contenido2">
                      <?php echo $data['correo']; ?>
                    </span>
                  </td> -->
                      
                </tr>
            <?php 
                endif; 
              endforeach;
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>ID</th>
                  <th>Cedula</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <!-- <th>Fecha de Nacimiento</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Correo</th> -->

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
        window.location = "?route=Clientes";
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
          title: "¿Desea suspender al lider?",
          text: "Se suspendera al lider escogido, ¿desea continuar?",
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
                    title: "¿Esta seguro de suspender al lider?",
                    text: "El lider suspendido no podra hacer pedidos en esta ni en las siguientes campañas, ¿desea continuar?",
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
