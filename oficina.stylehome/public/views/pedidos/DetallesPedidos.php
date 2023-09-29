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
        <li><a href="?<?php echo $menu; ?>&route=CHome"><i class="fa fa-dashboard"></i> <?=$modulo; ?> </a></li>
        <li><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
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
            <!-- <div class="box-header">
              <h3 class="box-title"><?php echo "Catalogo - Ciclo ".$num_ciclo."/".$ano_ciclo; ?></h3>
              <span style="clear:both;"></span>
            </div> -->

            <!-- /.box-header -->
            <div class="box-body">
              <br>
              <div class="row">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Pedidos&action=Registrar<?=$addUrlAdmin; ?>">
                    <span style="margin-left:25px;">Volver al catalogo de premios de Ciclo <?=$num_ciclo."/".$ano_ciclo; ?></span>
                  </a>
                </div>
              </div>
              <div class="row" style="text-align:right;margin-right:10px;">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Cart<?=$addUrlAdmin; ?>" class="dropdown-toggle box_notificaciones" style="">
                    <i class="glyphicon glyphicon-shopping-cart" style="font-size:1.2em"></i>
                    <span class="label cantidad_carrito <?=$classHidden; ?>" style="background:#00000022;border-radius:10px;font-size:1em;position:relative;top:-10px;right:0px;"><?=$cantidadCarrito; ?></span>
                  </a>
                </div>
              </div>
              <br>
              <?php 
                if($addUrlAdmin != ""){
                  ?>
                  <div class="row">
                    <div class="col-xs-12">
                      <form action="">
                        <input type="hidden" name="c" value="<?=$_GET['c'] ?>">
                        <input type="hidden" name="n" value="<?=$_GET['n'] ?>">
                        <input type="hidden" name="y" value="<?=$_GET['y'] ?>">
                        <input type="hidden" name="route" value="<?=$_GET['route'] ?>">
                        <input type="hidden" name="action" value="<?=$_GET['action'] ?>">
                        <input type="hidden" name="cod" value="<?=$_GET['cod'] ?>">
                        <input type="hidden" name="admin" value="<?=$_GET['admin'] ?>">
                        <select class="form-control select2" style="width:100%;" name="lider">
                          <option value="">Ningún(a) - Seleccionar</option>
                          <?php foreach ($lideres as $lid){ if(!empty($lid['id_cliente'])){ ?>
                            <?php
                              $permitido = 0;
                              if(!empty($accesosEstructuras)){
                                if(count($accesosEstructuras)>1){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$lid['id_cliente']){
                                        $permitido = 1;
                                      }
                                    }
                                  }
                                }else if($personalInterno){
                                  $permitido = 1;
                                }
                              }
                              if($permitido){
                              ?>
                          <option value="<?=$lid['id_cliente']; ?>" <?php if(!empty($_GET['lider']) && $_GET['lider']==$lid['id_cliente']){ echo "selected"; } ?>><?=$lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']; ?></option>
                          <?php } } } ?>
                        </select>
                        <button class="btn enviar2">Seleccionar Lider</button>
                      </form>
                    </div>
                  </div>
                  <?php
                }
              ?>
              <div class="row">
                <div class="col-xs-12 col-sm-6" style="padding:10px 25px;box-sizing:border-box;">
                  <div style="background:;text-align:center;">
                    <img src="<?=$cat['imagen_inventario']; ?>" style="max-width:100%;margin-top:5%;margin-bottom:5%;">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6" style="padding:10px 25px;box-sizing:border-box;">
                  <div style="background:;">
                    <span style="font-size:2.5em;"><?=$cat['nombre_inventario']; ?></span>
                    <br>
                    <br>
                    <span style="color:#555;font-size:1.5em;"><?="$".number_format($cat['precio_inventario'],2,',','.'); ?></span>
                    <br>
                    <br>
                    <div class="input-group col-xs-12 col-sm-6" style="">
                      <span id="<?=$cat['cod_inventario']; ?>" class="Menoss input-group-addon btn" style="width:25%;">-</span>
                      <input type="number" step="1" min="1" value="1" id="val<?=$cat['cod_inventario']; ?>" style="text-align:center;" class="form-control valuesCant">
                      <span id="<?=$cat['cod_inventario']; ?>" class="Mass input-group-addon btn" style="width:25%;">+</span>
                    </div>
                    <?php if($ciclo['estado_ciclo']=="1"){ ?>
                      <?php 
                        $mostrar=0;
                        if($accesoPedidosClienteR || $accesoPedidosClienteM){
                          $mostrar=1;
                        } else if(($accesoPedidosR||$accesoPedidosR) && ($fechaActual <= $ciclo['cierre_seleccion']) ){ 
                          $mostrar=1;
                        }
                        if($mostrar==1){
                          ?>
                          <span class="btn enviar enviarAlCarrito col-xs-12 col-sm-6" id="<?=$cat['cod_inventario']; ?>" style="margin-top:10px;">Agregar al carrito</span>
                          <?php
                        }
                      ?>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-6" style="padding:0px 25px;box-sizing:border-box;">
                  <?php if(trim($cat['descripcion_inventario'])!=""){ ?>
                    <span style="font-size:2.5em;">Descripción</span>
                    <br>
                    <span style="font-size:1.2em;"><?=$cat['descripcion_inventario']; ?></span>
                  <?php } ?>
                </div>
              </div>
              <br><br>
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
  $(".Mass").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($("#val"+cod).val());
    $("#val"+cod).val(val+1);
  });
  $(".Menoss").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($("#val"+cod).val());
    if( (val-1)>0 ){
      $("#val"+cod).val(val-1);
    }
  });
  $('.valuesCant').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $(".enviarAlCarrito").click(function(){
    var id = $(this).attr("id");
    var val = $("#val"+id).val();
    swal.fire({ 
      title: "¿Desea anexar al carrito?",
      text: "Se va a agregar al carrito su selección, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      confirmButtonText: "¡Si!",
      cancelButtonText: "No", 
      closeOnConfirm: false,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            addCart: true,
            codigo: id,
            cantidad: val,
          },
          success: function(respuesta){
            // alert(respuesta);
            var data = JSON.parse(respuesta);
            if(data['exec']=="1"){
              var title=""; 
              if(data['data']['op']=="1"){
                title="¡Anexado al carrito con exito!";
              }
              if(data['data']['op']=="2"){
                title="¡Registro del carrito actualizado!";
              }
              swal.fire({
                type: 'success',
                title: title,
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              }).then(function(){
                var newCant = data['data']['cantidad'];
                $(".cantidad_carrito").html(data['data']['cantidad']);
                if(newCant>0){
                  $(".cantidad_carrito").removeClass("d-none");
                }
              });
            }
            if(data['exec']=="2"){
              swal.fire({
                type: 'error',
                title: '¡Error al realizar la operacion!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
            }
          }
        });
        // var rutaId = $(this).attr("id");
        // window.location = "?"+rutaId;
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        });
      } 
    });
  });

  // $(".enviarVisibilidadCiclo").click(function(){
  //   swal.fire({ 
  //     title: "¿Desea guardar los datos?",
  //     text: "Se guardaran los datos ingresados, ¿desea continuar?",
  //     type: "question",
  //     showCancelButton: true,
  //     confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //     confirmButtonText: "¡Guardar!",
  //     cancelButtonText: "Cancelar", 
  //     closeOnConfirm: false,
  //     closeOnCancel: false 
  //   }).then((isConfirm) => {
  //     if (isConfirm.value){
  //       $.ajax({
  //         url: '',
  //         type: 'POST',
  //         data: {
  //           validarVisibilidad: true,
  //           visibilidad: $("#visibilidadCiclo").val(),
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           if (respuesta == "1"){
  //             swal.fire({
  //               type: 'success',
  //               title: '¡Datos guardados correctamente!',
  //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               window.location = "";
  //             });
  //           }
  //           if (respuesta == "9"){
  //             swal.fire({
  //               type: 'error',
  //               title: '¡Los datos ingresados estan repetidos!',
  //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //           }
  //           if (respuesta == "5"){ 
  //             swal.fire({
  //               type: 'error',
  //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
  //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //           }
  //         }
  //       });
  //     }else { 
  //       swal.fire({
  //         type: 'error',
  //         title: '¡Proceso cancelado!',
  //         confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //       });
  //     } 
  //   });
  // });
  // $(".btnBoxEstado").click(function(){
  //   var clase = $("#fasEstado").attr("class");
  //   if(clase=="fa fa-chevron-up"){
  //     $("#fasEstado").attr("class","fa fa-chevron-down");
  //     $(".box_Estados").slideUp();
  //   }
  //   if(clase=="fa fa-chevron-down"){
  //     $("#fasEstado").attr("class","fa fa-chevron-up");
  //     $(".box_Estados").slideDown();
  //   }
  // });
  // $(".enviarEstadoCiclo").click(function(){
  //   swal.fire({ 
  //     title: "¿Desea guardar los datos?",
  //     text: "Se guardaran los datos ingresados, ¿desea continuar?",
  //     type: "question",
  //     showCancelButton: true,
  //     confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //     confirmButtonText: "¡Guardar!",
  //     cancelButtonText: "Cancelar", 
  //     closeOnConfirm: false,
  //     closeOnCancel: false 
  //   }).then((isConfirm) => {
  //     if (isConfirm.value){
  //       $.ajax({
  //         url: '',
  //         type: 'POST',
  //         data: {
  //           validarEstadoCamp: true,
  //           estadoCiclo: $("#estadoCiclo").val(),
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           if (respuesta == "1"){
  //               swal.fire({
  //                   type: 'success',
  //                   title: '¡Datos guardados correctamente!',
  //                   confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //               }).then(function(){
  //                 window.location = "";
  //               });
  //           }
  //           if (respuesta == "9"){
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Los datos ingresados estan repetidos!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //           }
  //           if (respuesta == "5"){ 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Error de conexion con la base de datos, contacte con el soporte!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //           }
  //         }
  //       });
  //     }else { 
  //       swal.fire({
  //         type: 'error',
  //         title: '¡Proceso cancelado!',
  //         confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //       });
  //     }
  //     });
  // });

  // $(".editarPedidoLideres").click(function(){
  //     swal.fire({ 
  //         title: "¿Desea modificar los datos?",
  //         text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
  //         type: "question",
  //         showCancelButton: true,
  //         confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //         confirmButtonText: "¡Si!",
  //         cancelButtonText: "No", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //     }).then((isConfirm) => {
  //         if (isConfirm.value){          
  //           var rutaId = $(this).attr("id");
  //           window.location = "?"+rutaId;
  //         }else { 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Proceso cancelado!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //         } 
  //     });
  // });

  // $(".modalHistorico").click(function(){
  //   var id = $(this).attr('id');
  //   var show = $(".modalHistorico"+id).attr("placeholder");
  //   $(".modalesHistorico").slideUp();
  //   $(".modalesHistorico").attr("placeholder","0");
  //   if(show==0){
  //     var carga = $(".carga"+id).val();
  //     // alert(carga);
  //     if(carga==0){
  //       $.ajax({
  //         url: '',
  //         type: 'POST',
  //         data: {
  //           pedidos_historicos: true,
  //           id_pedido: id,
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           var json = JSON.parse(respuesta);
  //           if(json['msj']=="Good"){
  //             var data = json['data'];
  //             var html = "";
  //             html += '<table style="width:;text-align:left;">';
  //               for (var i = 0; i < data.length; i++) {
  //                 html += '<tr>';
  //                   html += '<td>';
  //                     html += 'Aprobadas: <b style="color:#0D0">'+data[i]['cantidad_aprobado']+' Cols.</b>';
  //                     html += 'Por: <b>'+data[i]['primer_nombre']+' '+data[i]['primer_apellido']+'</b>';
  //                     html += '<small>('+data[i]['fecha_aprobado']+' '+data[i]['hora_aprobado']+')</small>';
  //                   html += '</td>';
  //                 html += '</tr>';
  //               }
  //             html += '</table>';
  //             $(".contentHistorico"+id).html(html);
  //             $(".carga"+id).val(1);
  //           }
  //         }
  //       });
  //     }
  //     $(".modalHistorico"+id).attr("placeholder","1");
  //     $(".modalHistorico"+id).slideDown();
  //   }
  //   if(show==1){
  //     $(".modalHistorico"+id).attr("placeholder","0");
  //     $(".modalHistorico"+id).slideUp();
  //   }
  //   // alert(show);
  //   // alert(id);
  //   // $(".modalHistorico"+id).slideToggle();
  // });

  // var filter = $(".filter").val();
  // $("."+filter).hide(); 
  // $(".title_ocultar").hide();
  // $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
  // $(".siempre").show();
  // $(".filter").change(function(){
  //   $("#table_colecciones tr").show();
  //   var filter = $(".filter").val();
  //   $("."+filter).hide(); 
  //   $(".title_ocultar").hide();
  //   $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
  // });

  // $(".modificarBtn").click(function(){
  //   swal.fire({ 
  //         title: "¿Desea modificar los datos?",
  //         text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
  //         type: "question",
  //         showCancelButton: true,
  //         confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //         confirmButtonText: "¡Si!",
  //         cancelButtonText: "No", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //     }).then((isConfirm) => {
  //         if (isConfirm.value){            
  //           window.location = $(this).val();
  //         }else { 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Proceso cancelado!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //         } 
  //     });
  // });

  // $(".eliminarBtn").click(function(){
  //     swal.fire({ 
  //         title: "¿Desea borrar los datos?",
  //         text: "Se borraran los datos escogidos, ¿desea continuar?",
  //         type: "error",
  //         showCancelButton: true,
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //         confirmButtonText: "¡Si!",
  //         cancelButtonText: "No", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //     }).then((isConfirm) => {
  //         if (isConfirm.value){            
      
  //               swal.fire({ 
  //                   title: "¿Esta seguro de borrar los datos?",
  //                   text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
  //                   type: "error",
  //                   showCancelButton: true,
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //                   confirmButtonText: "¡Si!",
  //                   cancelButtonText: "No", 
  //                   closeOnConfirm: false,
  //                   closeOnCancel: false 
  //               }).then((isConfirm) => {
  //                   if (isConfirm.value){                      
  //                       window.location = $(this).val();
  //                   }else { 
  //                       swal.fire({
  //                           type: 'error',
  //                           title: '¡Proceso cancelado!',
  //                           confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //                       });
  //                   } 
  //               });

  //         }else { 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Proceso cancelado!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             });
  //         } 
  //     });
  // });
});  
</script>
</body>
</html>
