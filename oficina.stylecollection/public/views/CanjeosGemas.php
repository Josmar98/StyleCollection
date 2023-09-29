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
        <?php echo "Gemas a Físico"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Gemas a Físico de lideres"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Gemas a Físico"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Gemas a Físico";}else{echo "Gemas a Físico";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Gemas a Físico</a></div>
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



        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Gemas a Físico"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form action="" method="post" role="form" class="form_register"> -->
            <div class="box-body">

              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Líder</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($planesCol);
                // echo Count($planesCol);
                foreach ($canjeos as $data):
                  if(!empty($data['id_canjeo_gema'])):  
                ?>
                  <?php
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
                    }else if($accesoBloqueo=="0"){
                      $permitido = "1"; 
                    }
                    if($permitido == "1"){ ?>
                      <tr >
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:10%">
                          <?php if($estado_campana=="1"){ ?>
                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu; ?>&route=<?=$url; ?>&action=Modificar&id=<?=$data['id_canjeo_gema']?>&lider=<?=$data['id_cliente']?>">
                                <span class="fa fa-wrench"></span>
                              </button>

                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"): ?>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$data['id_canjeo_gema']; ?>&permission=1">
                                    <span class="fa fa-trash"></span>
                                </button>

                                <?php if ($data['estado']=="0"): ?>
                                  
                                <button class="btn retirarBtn" style="border:0;background:none;color:green" value="?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$data['id_canjeo_gema']; ?>&retirar=1">
                                    <span class="fa fa-list"></span>
                                </button>

                                <?php endif; ?>


                              <?php endif; ?>
                          <?php } ?>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                          </span>
                        </td>
                        <td style="width:10%">
                          <span class="contenido2">
                            <?php echo number_format($data['precio_gema'],2,',','.'); ?>
                          </span>
                        </td>
                        <td style="width:10%">
                          <span class="contenido2">
                            <?php echo $data['cantidad']; ?>
                          </span>
                        </td>
                        <td style="width:10%">
                          <span class="contenido2">
                            <?php echo "$".number_format($data['total'],2,',','.'); ?>
                          </span>
                        </td>
                        <td style="width:25%">
                          <span class="contenido2">
                            <?php 
                              if ($data['estado']=="1"){
                                echo "Retirado";
                              } 
                              if ($data['estado']=="0"){
                                echo "En Espera De Ser Retirado";
                              } 
                            ?>
                          </span>
                        </td>
                 
                      </tr>
                  <?php } ?>
                      
                      
                <?php
                  endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Líder</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
              </table>

            </div>
              
          </div>

        </div>
        <!--/.col (left) -->

        
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
<input type="hidden" class="responses" value="<?php echo $response; ?>">
<?php endif; ?>
<?php if(!empty($response2)): ?>
<input type="hidden" class="responses2" value="<?php echo $response2; ?>">
<?php endif; ?>

<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
          title: '¡Datos guardados correctamente!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=CanjeosGemas";
        window.location.href=menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      });
    }
  }
  var response2 = $(".responses2").val();
  if(response2==undefined){
  }else{
    if(response2 == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=CanjeosGemas";
        window.location.href=menu;
      });
    }
    if(response2 == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
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

    $(".retirarBtn").click(function(){
    swal.fire({ 
        title: "¿Desea marcar el canjeo como retirado?",
        text: "Se cambiara el estado a retirado, ¿desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#ED2A77",
        confirmButtonText: "¡Si!",
        cancelButtonText: "No", 
        closeOnConfirm: false,
        closeOnCancel: false 
    }).then((isConfirm) => {
        if (isConfirm.value){            
    
              swal.fire({ 
                  title: "¿Esta seguro de cambiar a retirado?",
                  text: "Se cambiara el estado, esta opcion no se puede deshacer, ¿desea continuar?",
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
function validarLiderazgos(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var aprobadas = $("#cantidad_aprobado").val();
  var raprobadas = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( aprobadas == 0 ){
      $("#error_cantidad_aprobado").html("");
      raprobadas = true;
    }else{
      raprobadas = false;
      $("#error_cantidad_aprobado").html("Debe escoger las cantidad de colecciones para cada plan y alcanzar la cantidad de colecciones disponibles");
    }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( raprobadas==true){
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
