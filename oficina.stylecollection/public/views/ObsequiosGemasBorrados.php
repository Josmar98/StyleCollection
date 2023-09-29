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
        <?php echo "Gemas"; ?>
        <small><?php echo "Ver Gemas autorizadas Borrados"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo "Configuracion" ?>"><?php echo "Gemas autorizadas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Gemas autorizadas Borrados"; ?></li>
      </ol>
    </section>
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

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"): ?>
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        <?php endif; ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>


        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Gemas autorizadas Borrados"; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php 
              // $supereditargemas = 0;
              // $admineditargemas = 0;
              // $analistaeditargemas = 0;
              // $superanalistaeditargemas = 0;

              // $superborrargemas = 0;
              // $adminborrargemas = 0;
              // $analistaborrargemas = 0;
              // $superanalistaborrargemas = 0;

              // $superbloqdesbloqgemas = 0;
              // $adminbloqdesbloqgemas = 0;
              // $analistabloqdesbloqgemas = 0;
              // $superanalistabloqdesbloqgemas = 0;
              // $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              // foreach ($configuraciones as $config) {
              //   if(!empty($config['id_configuracion'])){
              //     if($config['clausula']=="Supereditargemas"){
              //       $supereditargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Admineditargemas"){
              //       $admineditargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Analistaeditargemas"){
              //       $analistaeditargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Superanalistaeditargemas"){
              //       $superanalistaeditargemas = $config['valor'];
              //     }

              //     if($config['clausula']=="Superborrargemas"){
              //       $superborrargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Adminborrargemas"){
              //       $adminborrargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Analistaborrargemas"){
              //       $analistaborrargemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Superanalistaborrargemas"){
              //       $superanalistaborrargemas = $config['valor'];
              //     }

              //     if($config['clausula']=="Superbloqdesbloqgemas"){
              //       $superbloqdesbloqgemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Adminbloqdesbloqgemas"){
              //       $adminbloqdesbloqgemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Analistabloqdesbloqgemas"){
              //       $analistabloqdesbloqgemas = $config['valor'];
              //     }
              //     if($config['clausula']=="Superanalistabloqdesbloqgemas"){
              //       $superanalistabloqdesbloqgemas = $config['valor'];
              //     }
              //   }
              // }
             ?>
            <div class="box-body table-responsive">
              <?php
                // echo "superanalistaeditargemas: ".$superanalistaeditargemas."<br>";
                // echo "accesoBloqueo: ".$accesoBloqueo."<br>";
              ?>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Lider</th>
                  <th>Campaña</th>
                  <th>Gemas</th>
                  <th>Descripción</th>
                  <th>Fecha y hora</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                foreach ($obsequios as $data):
                if(!empty($data['id_obsequio_gema'])):  
                ?>
                  <?php
                    $permitido = "0";
                    if($accesoBloqueo=="1"){
                      if(!empty($accesosEstructuras)){
                        foreach ($accesosEstructuras as $struct) {
                          if(!empty($struct['id_cliente'])){
                            if($struct['id_cliente']==$data['id_cliente']){
                              $permitido = "1";
                            }
                          }
                        }
                      }
                    }
                    if($accesoBloqueo=="0"){
                      $permitido = "1";
                    }
                    ?>
                    <?php if ($permitido=="1"): ?>
                      <tr>
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:8%">
                          <?php if($estado_campana=="1"){ ?>
                             
                              <button class="btn eliminarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=<?php echo $url; ?>&id=<?php echo $data['id_obsequio_gema'] ?>&permission=1">
                                <span class="fa fa-trash"></span>
                              </button>

                          <?php } ?>
                        </td>
                        <td style="width:16%">
                          <span class="contenido2">
                            <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                          </span>
                        </td>
                        <td style="width:16%">
                          <span class="contenido2">
                            <?php 
                              if($data['numero_despacho']=="1"){
                                echo "1er Pedido - ";
                              }
                              if($data['numero_despacho']=="2"){
                                echo "2do Pedido - ";
                              }
                              if($data['numero_despacho']=="4"){
                                echo "3er Pedido - ";
                              }
                              echo "Campaña ".$data['numero_campana']."/".$data['anio_campana']."<br>"."<small>".$data['nombre_campana']."</small>";
                              ?>
                          </span>
                        </td>
                        <td style="width:16%">
                          <span class="contenido2">
                            <?=number_format($data['cantidad_gemas'],2,',','.')?>
                            <?php if ($data['cantidad_gemas']=="1"): ?> Gema <?php elseif($data['cantidad_gemas']>"0"): ?> Gemas <?php endif; ?>
                          </span>
                        </td> 
                        <td style="width:16%">
                          <span class="contenido2">
                            <?php 
                              if($data['descripcion_gemas']==""){
                                $data['descripcion_gemas'] = "Obsequio otorgado por ".$data['firma_obsequio'];
                              }
                              echo $data['descripcion_gemas']; 
                            ?>
                          </span>
                        </td>
                        <td style="width:16%">
                          <span class="contenido2" style="text-align:center;">
                            <?php echo $lider->formatFecha($data['fecha_obsequio'])." <br> ".$data['hora_obsequio']; ?>
                          </span>
                        </td>
                      </tr>
                    <?php endif; ?>
              
                      
                <?php
               endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Lider</th>
                  <th>Campaña</th>
                  <th>Gemas</th>
                  <th>Descripción</th>
                  <th>Fecha y hora</th>
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

<style type="text/css">
.buttonexpandedhijo1:hover,
.buttonexpandedhijo2:hover{
  cursor:pointer;
}

</style>
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
            title: '¡Obsequio restaurado correctamente!',
            confirmButtonColor: "#ED2A77",
        }).then(function(){
          window.location = "?<?=$menu?>&route=ObsequiosGemas";
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
          title: "¿Desea restaurar los datos?",
          text: "Se restauraran los datos escogidos, ¿desea continuar?",
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
                    title: "¿Esta seguro de restaurar los datos?",
                    text: "Se restauraran los datos, ¿desea continuar?",
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
