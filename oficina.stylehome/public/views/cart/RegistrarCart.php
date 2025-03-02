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
        <small><?php echo $modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> <?=$modulo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      

      <div class="row">

        <?php
          // $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          // $accesoBloqueo = "0";
          // $superAnalistaBloqueo="1";
          // $analistaBloqueo="1";
          // foreach ($configuraciones as $config) {
          //   if(!empty($config['id_configuracion'])){
          //     if($config['clausula']=='Analistabloqueolideres'){
          //       $analistaBloqueo = $config['valor'];
          //     }
          //     if($config['clausula']=='Superanalistabloqueolideres'){
          //       $superAnalistaBloqueo = $config['valor'];
          //     }
          //   }
          // }
          // if($_SESSION['home']['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          // if($_SESSION['home']['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          // if($accesoBloqueo=="0"){
          //   // echo "Acceso Abierto";
          // }
          // if($accesoBloqueo=="1"){
          //   // echo "Acceso Restringido";
          // }

        ?>

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Estado de cuentas - Ciclo ".$num_ciclo."/".$ano_ciclo; ?></h3>
                  <?php if($estado_ciclo=="1"){ ?>
                        <?php  if($accesoPedidosClienteR){ ?>
                            <br>
                            <a class="btn" style="float:right;margin-right:20px;margin-top:10px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pedidos&action=Registrar&admin=1"><b>Realizar solicitud de Pedido de Lider</b></a>
                            <br><br>
                        <?php } ?>
                  <?php } ?>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <?php
                $fechaActual = date('Y-m-d');
                // $fechaActual = "2021-10-14";
                if(Count($pedidos)>1){
                  $pedido = $pedidos[0];
                  if($pedido['fecha_aprobado']!="" && $pedido['hora_aprobado']!=""){ ?>
                    <?php //if(Count($cols)>1 || Count($pedd)<2 || $limittteee=="0"){}else{ ?>
                      <!-- <tr>
                        <th colspan="4" style="font-size:1em;"><a href="?<?=$menu; ?>&route=PlanCol&action=Registrar" class="btn enviar">Seleccionar Planes</a></th>
                      </tr> -->
                    <?php //} ?>
                    <?php //if(Count($prems)>1 || Count($cols)<2 || $limittteee=="0"){}else{ ?>
                      <!-- <tr>
                        <th colspan="4" style="font-size:1em;"><a href="?<?=$menu; ?>&route=PremioCol&action=Registrar" class="btn enviar">Seleccionar premios</a></th>
                      </tr> -->
                    <?php //} ?>
                    <table id="" class="datatablee table table-bordered table-striped" style="text-align:center;width:100%;">
                      <thead>
                        <tr>
                          <!-- <th>---</th> -->
                          <th>Nombre, Apellido y Cedula</th>
                          <!-- <th></th> -->
                          <th>Colecciones Solicitadas</th>
                          <th>Colecciones Aprobadas</th>
                          <!-- <th>---</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $num = 1;
                          if(Count($pedidos)>1){
                            foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
                                ?>
                              <tr>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                                  </span>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php echo $data['cantidad_pedido']." Col Solicitadas"; ?>
                                  </span>
                                </td>                  
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <span style="color:#0d0;">
                                      <?php echo $data['cantidad_aprobado']. " Col Aprobadas"; ?>
                                    </span>
                                  </span>
                                </td>
                              </tr>
                                <?php
                              $href=$menu."&route=Pedidos&id=".$data['id_pedido']; 
                            } }
                          }else{ 
                            ?> <tr><td colspan='7'>Ningún dato disponible en esta tabla</td></tr> <?php
                          }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <?php 
                            if(Count($pedidos)>1){
                              $pedido = $pedidos[0];
                              if($pedido['cantidad_aprobado']>0){
                              }
                            }
                          ?>
                          <th colspan="4" style="font-size:1em;"><a href="?<?=$href?>">Ver Estado de cuentas</a></th>
                        </tr>
                      </tfoot>
                    </table>
                  <?php }else{ ?>
                    <div style="margin-left:3%;font-size:1.1em;">
                      <b><i>
                        <?php if($fechaActual <= $ciclo['cierre_seleccion']){ ?>
                          <b style="float:right;margin-right:25px;"><u><a href="?<?=$menu; ?>&route=Pedidos&action=Modificar&id=<?php echo $pedido['id_pedido'] ?>"><i>Editar Pedido</i></a></u></b>
                        <?php } ?>
                        <br><br>
                        <span style="color:red;margin-left:1%">Importante: </span> Ya se solicito su pedido por <u><?php echo $pedido['cantidad_pedido'] ?> colecciones</u> para este Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> - debera esperar a ser confirmado por el / la Gerente. Gracias.
                      </i></b>
                    </div>
                  <?php } ?>
                  <br><br>
                <?php 
                }else{
                  if($fechaActual <= $ciclo['cierre_seleccion']){ ?>
                    <div style="margin-left:3%;font-size:1.1em;">
                      <b><i>
                        <span style="color:red;margin-left:1%;" >Importante: </span> Podra solicitar su pedido para este Ciclo <?=$num_ciclo."/".$ano_ciclo; ?> hasta la fecha <u><?php echo $lider->formatFecha($ciclo['cierre_seleccion']); ?></u>. de lo contrario la opcion para solicitar su pedido ya no estara disponible. Gracias.
                      </i></b> 
                    </div>
                    <?php if($accesoPedidosR && $_SESSION['home']['cuenta']['estatus'] == 1){ ?>
                      <center>
                        <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pedidos&action=Registrar">
                          <b>Realizar Solicitud de Pedido</b>    
                        </a>
                      </center>
                    <?php } ?>
                  <?php }else{ ?>
                    <div style="margin-left:3%;font-size:1.1em;">
                      <b><i>
                        <span style="color:red;margin-left:1%">Importante: </span> Usted alcanzo la fecha limite para solicitar su pedido para este Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> - debera esperar a un proximo Ciclo para realizar su pedido. Gracias.
                      </i></b>  
                    </div>
                  <?php } ?>
                  <br><br>
                  <?php 
                }
              ?>

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

            <!-- // <table style="width:;text-align:left;">
              //foreach ($pedidos_historicos as $hist){ if(!empty($hist['id_pedidos_historicos'])){
                //if ($hist['id_pedido']==$data['id_pedido']){ ?>
                  // <tr>
                    // <td>
                      // Aprobadas: <b style="color:#0D0"><?=$hist['cantidad_aprobado']; ?> Cols.</b>
                      // Por <b><?=$hist['primer_nombre']." ".$hist['primer_apellido']; ?></b>
                      // <small>(<?=$hist['fecha_aprobado']." ".$hist['hora_aprobado']; ?>)</small>
                    // </td>
                  // </tr>
                //} 
              //} }
            // </table> -->

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
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    
  }

  $(".enviarVisibilidadCiclo").click(function(){
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
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            validarVisibilidad: true,
            visibilidad: $("#visibilidadCiclo").val(),
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              }).then(function(){
                window.location = "";
              });
            }
            if (respuesta == "9"){
              swal.fire({
                type: 'error',
                title: '¡Los datos ingresados estan repetidos!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
            }
            if (respuesta == "5"){ 
              swal.fire({
                type: 'error',
                title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
            }
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
  $(".btnBoxEstado").click(function(){
    var clase = $("#fasEstado").attr("class");
    if(clase=="fa fa-chevron-up"){
      $("#fasEstado").attr("class","fa fa-chevron-down");
      $(".box_Estados").slideUp();
    }
    if(clase=="fa fa-chevron-down"){
      $("#fasEstado").attr("class","fa fa-chevron-up");
      $(".box_Estados").slideDown();
    }
  });
  $(".enviarEstadoCiclo").click(function(){
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
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            validarEstadoCamp: true,
            estadoCiclo: $("#estadoCiclo").val(),
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
                swal.fire({
                    type: 'success',
                    title: '¡Datos guardados correctamente!',
                    confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                }).then(function(){
                  window.location = "";
                });
            }
            if (respuesta == "9"){
              swal.fire({
                  type: 'error',
                  title: '¡Los datos ingresados estan repetidos!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
            }
            if (respuesta == "5"){ 
              swal.fire({
                  type: 'error',
                  title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
            }
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

  $(".editarPedidoLideres").click(function(){
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
            var rutaId = $(this).attr("id");
            window.location = "?"+rutaId;
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });

  $(".modalHistorico").click(function(){
    var id = $(this).attr('id');
    var show = $(".modalHistorico"+id).attr("placeholder");
    $(".modalesHistorico").slideUp();
    $(".modalesHistorico").attr("placeholder","0");
    if(show==0){
      var carga = $(".carga"+id).val();
      // alert(carga);
      if(carga==0){
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            pedidos_historicos: true,
            id_pedido: id,
          },
          success: function(respuesta){
            // alert(respuesta);
            var json = JSON.parse(respuesta);
            if(json['msj']=="Good"){
              var data = json['data'];
              var html = "";
              html += '<table style="width:;text-align:left;">';
                for (var i = 0; i < data.length; i++) {
                  html += '<tr>';
                    html += '<td>';
                      html += 'Aprobadas: <b style="color:#0D0">'+data[i]['cantidad_aprobado']+' Cols.</b>';
                      html += 'Por: <b>'+data[i]['primer_nombre']+' '+data[i]['primer_apellido']+'</b>';
                      html += '<small>('+data[i]['fecha_aprobado']+' '+data[i]['hora_aprobado']+')</small>';
                    html += '</td>';
                  html += '</tr>';
                }
              html += '</table>';
              $(".contentHistorico"+id).html(html);
              $(".carga"+id).val(1);
            }
          }
        });
      }
      $(".modalHistorico"+id).attr("placeholder","1");
      $(".modalHistorico"+id).slideDown();
    }
    if(show==1){
      $(".modalHistorico"+id).attr("placeholder","0");
      $(".modalHistorico"+id).slideUp();
    }
    // alert(show);
    // alert(id);
    // $(".modalHistorico"+id).slideToggle();
  });

  var filter = $(".filter").val();
  $("."+filter).hide(); 
  $(".title_ocultar").hide();
  $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
  $(".siempre").show();
  $(".filter").change(function(){
    $("#table_colecciones tr").show();
    var filter = $(".filter").val();
    $("."+filter).hide(); 
    $(".title_ocultar").hide();
    $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
  });

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
});  
</script>
</body>
</html>
