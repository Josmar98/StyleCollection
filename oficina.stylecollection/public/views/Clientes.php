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

        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }

        ?>
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
                  <?php if ($amClientesE==1 || $amClientesB==1): ?>
                  <th>---</th>
                  <?php endif ?>
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
              foreach ($clientes as $data):
                if(!empty($data['id_cliente'])):  
                  if($accesoBloqueo=="1"){
                    if(!empty($accesosEstructuras)){
                      foreach ($accesosEstructuras as $struct) {
                        if(!empty($struct['id_cliente'])){
                          if($struct['id_cliente']==$data['id_cliente']){
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if ($amClientesE==1||$amClientesB==1): ?>                    
                  <td style="width:10%">
                        <?php if ($amClientesE==1): ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_cliente'] ?>">
                            <span class="fa fa-wrench">
                              
                            </span>
                          </button>
                        <?php endif ?>
                        <?php if ($amClientesB): ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_cliente'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <?php endif ?>
                  </td>
                  <?php endif ?>
                  <td style="width:5%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                      <?php echo $data['cedula']; ?>
                    </a>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                    <?php echo $data['primer_nombre']." ".$data['segundo_nombre']; ?>
                    </a>
                    </span>
                  </td>
                  
                  <td style="width:20%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                      <?php echo $data['primer_apellido']." ".$data['segundo_apellido']; ?>
                    </a>
                    </span>
                  </td>
                      
                </tr>
            <?php 
                          }
                        }
                      }
                    }
                  } else if($accesoBloqueo=="0"){
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <?php if ($amClientesE==1||$amClientesB==1): ?>                    
                  <td style="width:10%">
                        <?php if ($amClientesE==1): ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_cliente'] ?>">
                            <span class="fa fa-wrench">
                              
                            </span>
                          </button>
                        <?php endif ?>
                        <?php if ($amClientesB): ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_cliente'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <?php endif ?>
                  </td>
                  <?php endif ?>
                  <td style="width:5%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                      <?php echo $data['cedula']; ?>
                    </a>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                    <?php echo $data['primer_nombre']." ".$data['segundo_nombre']; ?>
                    </a>
                    </span>
                  </td>
                  
                  <td style="width:20%">
                    <span class="contenido2">
                    <a href="?route=<?php echo $url ?>&action=Detalles&id=<?php echo $data['id_cliente'] ?>">
                      <?php echo $data['primer_apellido']." ".$data['segundo_apellido']; ?>
                    </a>
                    </span>
                  </td>
                      
                </tr>
            <?php
                  }
                endif; 
              endforeach;
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if ($amClientesE==1||$amClientesB==1): ?>                    
                  <th>---</th>
                  <?php endif ?>
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
