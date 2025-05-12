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
        <li><a href="?route=<?php echo "Configuracion" ?>"><?php echo "".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
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
              <h3 class="box-title"><?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php 
              $supereditargemas = 0;
              $admineditargemas = 0;
              $analistaeditargemas = 0;
              $superanalistaeditargemas = 0;

              $superborrargemas = 0;
              $adminborrargemas = 0;
              $analistaborrargemas = 0;
              $superanalistaborrargemas = 0;

              $superbloqdesbloqgemas = 0;
              $adminbloqdesbloqgemas = 0;
              $analistabloqdesbloqgemas = 0;
              $superanalistabloqdesbloqgemas = 0;
              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              foreach ($configuraciones as $config) {
                if(!empty($config['id_configuracion'])){
                  if($config['clausula']=="Supereditargemas"){
                    $supereditargemas = $config['valor'];
                  }
                  if($config['clausula']=="Admineditargemas"){
                    $admineditargemas = $config['valor'];
                  }
                  if($config['clausula']=="Analistaeditargemas"){
                    $analistaeditargemas = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaeditargemas"){
                    $superanalistaeditargemas = $config['valor'];
                  }

                  if($config['clausula']=="Superborrargemas"){
                    $superborrargemas = $config['valor'];
                  }
                  if($config['clausula']=="Adminborrargemas"){
                    $adminborrargemas = $config['valor'];
                  }
                  if($config['clausula']=="Analistaborrargemas"){
                    $analistaborrargemas = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaborrargemas"){
                    $superanalistaborrargemas = $config['valor'];
                  }

                  if($config['clausula']=="Superbloqdesbloqgemas"){
                    $superbloqdesbloqgemas = $config['valor'];
                  }
                  if($config['clausula']=="Adminbloqdesbloqgemas"){
                    $adminbloqdesbloqgemas = $config['valor'];
                  }
                  if($config['clausula']=="Analistabloqdesbloqgemas"){
                    $analistabloqdesbloqgemas = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistabloqdesbloqgemas"){
                    $superanalistabloqdesbloqgemas = $config['valor'];
                  }
                }
              }
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
                    <th>Lider</th>
                    <th>Pedido</th>
                    <th>Colecciones</th>
                    <th>Observaciones</th>
                    <th>---</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $num = 1;
                    foreach ($devoluciones as $data){
                      if(!empty($data['id_orden'])){ 
                        $id_orden=$data['id_orden'];
                        $id_orden=str_replace('-','',$id_orden);
                        $id_orden=str_replace(':','',$id_orden);
                        $data['id_orden']=$id_orden;
                        $coleccionesDevueltas=$lider->consultarQuery("SELECT * FROM orden_devolucion_colecciones WHERE id_despacho={$id_despacho} and id_pedido={$data['id_pedido']}");
                        $permitido=false;
                        if($accesoBloqueo=="1"){
                          if(!empty($accesosEstructuras)){
                            foreach ($accesosEstructuras as $struct) {
                              if(!empty($struct['id_cliente'])){
                                if($struct['id_cliente']==$data['id_cliente']){
                                  $permitido=true;
                                }
                              }
                            }
                          }
                        }else if($accesoBloqueo=="0"){
                          $permitido=true;
                        }
                        if($permitido==true){
                          ?>
                          <tr>
                            <td style="width:5%">
                              <span class="contenido2">
                                <?php echo $num++; ?>
                              </span>
                            </td>
                            <td style="width:15%">
                              <span class="contenido2">
                                <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                              </span>
                            </td>
                            <td style="width:10%">
                              <span class="contenido2">
                                <?php echo "Pedido N° ".$data['id_pedido']; ?>
                              </span>
                            </td>
                            <td style="width:25%">
                              <span class="contenido2">
                                <?php 
                                  foreach ($coleccionesDevueltas as $col) {
                                    if(!empty($col['nombre_coleccion'])){
                                      if($col['cantidad_colecciones']>0){
                                        $frase="";
                                        if($col['cantidad_colecciones']==1){
                                          $frase="Colección";
                                        }else{
                                          $frase="Colecciones";
                                        }                                      
                                        echo "(".$col['cantidad_colecciones'].") ".$frase." ".$col['nombre_coleccion']."<br>"; 
                                      }
                                    }
                                  }
                                ?>
                              </span>
                            </td>
                            <td style="width:35%">
                              <span class="contenido2">
                                <?php echo $data['observaciones'] ?>
                              </span>
                            </td>
                            <td style="width:10%">
                              <span class="contenido2">
                                <?php
                                  $urlPDF = $menu3."route=".$_GET['route']."&action=Generar&id=".$data['id_orden'];
                                ?>
                                <a href="?<?=$urlPDF; ?>" target="_blank" class="btn enviar2">Generar PDF</a>
                              </span>
                            </td>
                            
                          </tr>
                          <?php
                        }
                      }
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nº</th>
                    <th>Lider</th>
                    <th>Pedido</th>
                    <th>Colecciones</th>
                    <th>Observaciones</th>
                    <th>---</th>
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
<?php if (!empty($_GET['permission'])): ?>
<input type="hidden" class="opcionResp" value="Borrar">
<?php endif; ?>
<?php if (!empty($_GET['bloqueo'])): ?>
<input type="hidden" class="opcionResp" value="Bloquear">
<?php endif; ?>
<?php if (!empty($_GET['desbloqueo'])): ?>
<input type="hidden" class="opcionResp" value="Desbloquear">
<?php endif; ?>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      if($(".opcionResp").val()=="Borrar"){
        swal.fire({
            type: 'success',
            title: '¡Gemas borrados correctamente!',
                    confirmButtonColor: "#ED2A77",
        }).then(function(){
          window.location = "?<?=$menu?>&route=Gemas";
        });
      }
      if($(".opcionResp").val()=="Bloquear"){
        swal.fire({
            type: 'success',
            title: '¡Gemas bloqueados correctamente!',
                    confirmButtonColor: "#ED2A77",
        }).then(function(){
          window.location = "?<?=$menu?>&route=Gemas";
        });
      }
      if($(".opcionResp").val()=="Desbloquear"){
        swal.fire({
            type: 'success',
            title: '¡Gemas desbloqueado correctamente!',
                    confirmButtonColor: "#ED2A77",
        }).then(function(){
          window.location = "?<?=$menu?>&route=Gemas";
        });
      }
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
      });
    }
    
  }

  $(".buttonexpandedhijo1").click(function(){
    var id = $(this).attr("id");
    $(".buttonexpandedhijo2"+id).show();
    $(this).hide();
    $(".boxexpandedhijo"+id).slideToggle();
  });
  $(".buttonexpandedhijo2").click(function(){
    var id = $(this).attr("id");
    $(".buttonexpandedhijo1"+id).show();
    $(this).hide();
    $(".boxexpandedhijo"+id).slideToggle();
  });

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

  $(".bloquearGemaBtn").click(function(){
      swal.fire({ 
          title: "¿Desea bloquear la cantidad de gemas?",
          text: "Se quedarán bloqueadas las gemas, no estarán disponibles, ¿desea continuar?",
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
  });

  $(".desbloquearGemaBtn").click(function(){
      swal.fire({ 
          title: "¿Desea desbloquear la cantidad de gemas?",
          text: "Las gemas volveran a estar disponibles, ¿desea continuar?",
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
});  
</script>
</body>
</html>
