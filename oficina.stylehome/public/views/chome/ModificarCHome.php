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
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
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

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="font-size:2em;"><?php if(!empty($action)){echo $action;} echo " ".$modulo ?></h3>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <br>
              <div class="row">
                <div class="col-xs-12">
                  <div class="container">
                    <div class="user-block">
                      <?php
                        $fotoPerfilActual = "public/assets/img/profile/";
                        if($pedido['sexo']=="Femenino"){$fotoPerfilActual .= "Femenino.png";}
                        if($pedido['sexo']=="Masculino"){$fotoPerfilActual .= "Masculino.png";} 
                        if($pedido['fotoPerfil']!=""){
                          $fotoPerfilActual = $pedido['fotoPerfil'];
                        }
                      ?>
                      <img class="img-circle img-bordered-sm" src="<?=$fotoPerfilActual; ?>" alt="user image">
                      <span class="username">
                        <?php 
                          $enviarPerfil="";
                          if($pedido['id_cliente']==$_SESSION['home']['id_cliente']){
                            $enviarPerfil="route=Perfil";
                          }else{
                            $enviarPerfil="route=Clientes&action=Detalles&id=".$pedido['id_cliente'];
                          }
                        ?>
                        <a href="?<?=$enviarPerfil; ?>">
                          <?php echo $pedido['primer_nombre']." ".$pedido['primer_apellido']; ?>  
                        </a>
                      </span>
                      <span class="description">
                        Pedido solicitado - <?php echo $pedido['fecha_pedido'] ?> a las <?php echo $pedido['hora_pedido']; ?>
                        <br>
                      </span>
                    </div>
                  </div>
                  <br>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                    <div class="alert alertaErrorAprobar d-none" style="color:#FFFFFF;background:#CC0000AA;">
                      Algunos productos del inventario no cuentan una existencia disponible suficiente para aprobar el pedido.
                    </div>
                  <div class="table-responsive" style="padding-left:2.5%;padding-right:2.5%;max-height:65vh;overflow:auto;">
                    <?php
                      $subtotal = 0;
                    ?>
                    <table class="table table-hover table-striped" style="width:100%;text-align:left !important;">
                      <thead>
                        <tr style="background:#EEE;font-size:1.3em;">
                          <th style="text-align:left;"></th>
                          <th style="text-align:left;"></th>
                          <th style="text-align:left;">Producto</th>
                          <th style="text-align:left;">Precio</th>
                          <th style="text-align:left;">Cantidad</th>
                          <th style="text-align:left;">Subtotal</th>
                          <th style="text-align:left;">Existencia</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($pedidosInv)>1){ ?>
                          <?php $codigoInventarios=[]; ?>
                          <form class="FormPedidoFacturaTotal" method="POST" action="">
                            <?php foreach ($pedidosInv as $cart){ if(!empty($cart['id_pedido'])){ ?>
                              <?php $codigoInventarios[count($codigoInventarios)]['cod']=$cart['cod_inventario']; ?>
                              <tr class="tr<?=$cart['cod_inventario']; ?>">
                                <td style="width:5%;"></td>
                                <td style="width:10%;"><img src="<?=$cart['imagen_inventario']; ?>" style="width:100%;"></td>
                                <td style="width:30%;"><?=$cart['nombre_inventario']; ?></td>
                                <td style="width:15%;"><?="$".number_format($cart['precio_inventario'],2,',','.'); ?></td>
                                <td style="width:30%;">
                                  <div class="input-group col-xs-12 col-sm-6" style="">
                                    <input type="hidden" name="pedido_inventario[]" value="<?=$cart['id_pedido_inventario']; ?>">
                                    <input type="hidden" name="cod_inventario[]" value="<?=$cart['cod_inventario']; ?>">
                                    <span id="<?=$cart['cod_inventario']; ?>" class="Menoss input-group-addon btn" style="width:25%;">-</span>
                                    <input type="number" step="1" min="0" value="<?=$cart['cantidad_aprobada']; ?>" class="form-control valuesCant val<?=$cart['cod_inventario']; ?>" style="text-align:center;" name="cantidad_aprobada[]" id="<?=$cart['cod_inventario']; ?>">
                                    <input type="hidden" class="precio<?=$cart['cod_inventario']; ?>" name="precios[]" value="<?=$cart['precio_inventario']; ?>">
                                    <span id="<?=$cart['cod_inventario']; ?>" class="Mass input-group-addon btn" style="width:25%;">+</span>
                                  </div>
                                  <input type="hidden" id="precio<?=$cart['cod_inventario']; ?>" value="<?=$cart['precio_inventario']; ?>">
                                  <input type="hidden" id="cant<?=$cart['cod_inventario']; ?>" value="<?=$cart['cantidad_aprobada']; ?>">
                                </td>
                                <td style="width:10%;"><span class="totaltxt<?=$cart['cod_inventario']; ?>"><?="$".number_format(($cart['cantidad_aprobada'])*($cart['precio_inventario']),2,',','.'); ?></span></td>
                                <td style="text-align:right;padding-right:20px;">
                                  <?php
                                    $cantExistencia = 0;
                                    foreach ($existencias as $exist){ if(!empty($exist['id_existencia'])){
                                      if($cart['cod_inventario']==$exist['cod_inventario']){
                                        $cantExistencia = $exist['cantidad_disponible'];
                                      }
                                    } }
                                    $cantExistencia += $cart['cantidad_aprobada'];
                                    if($cart['cantidad_aprobada'] > $cantExistencia){
                                      $colorr="#CC0000";
                                    }else{
                                      $colorr="#00CC00";
                                    }
                                    echo "<b style='color:{$colorr}'>{$cantExistencia}</b>";
                                  ?>
                                  <input type="hidden" class="existencia<?=$cart['cod_inventario']; ?>" name="existencia[]" value="<?=$cantExistencia; ?>">
                                </td>
                              </tr>
                              <?php $subtotal += ($cart['cantidad_aprobada'])*($cart['precio_inventario']) ?>
                            <?php } } ?>
                            <?php
                              $points = (($subtotal/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
                            ?>
                            <input type="hidden" name="aprobarPedido" value="1">
                          </form>
                        <?php }else{ ?>
                          <tr>
                            <td style="text-align:center;font-size:1.25em;" colspan="6">No hay elementos en el carrito</td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <span class="codigosInventarios d-none"><?=json_encode($codigoInventarios); ?></span>
                    <input type="hidden" class="facturaMinima" value="<?=$ciclo['precio_minimo']; ?>" name="facturaMinima">
                  </div>
                </div>
                <br>
                <div class="col-xs-12 text-right">
                  <div class="table" style="padding-left:2.5%;padding-right:2.0%;">
                    <table class="table table-hover table-striped" style="background:#CCC;font-size:1.5em;width:100%;text-align:left !important;">
                      <thead>
                        <tr>
                          <th style="width:40%;"></th>
                          <th style="width:35%;text-align:right;">Sub total: </th>
                          <th style="width:25%;text-align:left;padding-right:20px;"><span class="subtotaltxt"><?="$".number_format($subtotal,2,',','.'); ?></span></th>
                        </tr>
                        <input type="hidden" id="subtotalGeneral" value="<?=$subtotal; ?>">
                        <input type="hidden" id="puntosCuotas" value="<?=$ciclo['puntos_cuotas']; ?>">
                        <input type="hidden" id="precioMinimo" value="<?=$ciclo['precio_minimo']; ?>">
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-7 col-sm-offset-4 col-md-5 col-md-offset-6">
                  <div class="alert alert-warning d-none errorCantidadMinimaAprobar" id="<?="$".number_format($ciclo['precio_minimo'],2,',','.'); ?>" style="color:#FFFFFF;"><b></b></div>
                  <h3 style="font-size:2.5em;">Total del carrito</h3>
                  
                  <table class="table" style="width:100%;font-size:1.4em;">
                    <tbody>
                      <!-- <tr>
                        <td style="padding:20px 30px;width:40%;background:#EEEEEE88;">Subtotal</td>
                        <td style="padding:20px 30px;width:60%;"><?="$".number_format($subtotal,2,',','.'); ?></td>
                      </tr>
                      <tr>
                        <td style="padding:20px 30px;width:40%;background:#EEEEEE88;">Adicional</td>
                        <td style="padding:20px 30px;width:60%;"><?="$".number_format($subtotal,2,',','.'); ?></td>
                      </tr> -->
                      <tr>
                        <td style="padding:20px 30px;width:40%;background:#EEEEEE88;"><b>Total</b></td>
                        <td style="padding:20px 30px;width:60%;"><b class="subtotaltxt"><?="$".number_format($subtotal,2,',','.'); ?></b></td>
                      </tr>
                      <tr>
                        <td style="padding:20px 30px;width:40%;background:#EEEEEE88;"><b>Puntos</b></td>
                        <td style="padding:20px 30px;width:60%;"><b id="puntostxt"><?=number_format($points,2)." pts"; ?></b></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php if($estado_ciclo=="1"){ ?>
                  <div>
                    
                    <?php 
                      $mostrar=0;
                      if($accesoAprobarPedidosR || $accesoAprobarPedidosM){
                        ?>
                        <button class="btn btn-lg enviar2 aprobarPedido" <?php if($subtotal < $ciclo['precio_minimo']){ echo "disabled"; } ?> style="width:100%;font-size:1.5em;">Aprobar Pedido</button>
                        <?php
                      }
                    ?>
                  </div>
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
        title: '¡Pedido aprobado correctamente!',
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?<?=$menu; ?>&route=Estados&id=<?=$id; ?>";
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
  // $(".Mass").click(function(){
  //   var cod = $(this).attr("id");
  //   var val = parseInt($(".val"+cod).val());
  //   $(".val"+cod).val(val+1);
  // });
  // $(".Menoss").click(function(){
  //   var cod = $(this).attr("id");
  //   var val = parseInt($(".val"+cod).val());
  //   if( (val-1)>=0 ){
  //     $(".val"+cod).val(val-1);
  //   }
  // });
  // $('.valuesCant').on('input', function () {
  //   this.value = this.value.replace(/[^0-9]/g, '');
  // });
  $(".Mass").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($(".val"+cod).val());
    var precio = parseFloat($("#precio"+cod).val());
    var anterior = precio*val;
    $(".val"+cod).val(val+1);
    val = parseInt($(".val"+cod).val());
    $("#cant"+cod).val(val);
    var nsubtotal = precio*val;
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: nsubtotal,
        formatNumber: true, 
      },
      success: function(monto){
        $(".totaltxt"+cod).html("$"+monto);
      }
    });
    var subtotalGeneral = parseFloat($("#subtotalGeneral").val());
    subtotalGeneral = subtotalGeneral-anterior;
    subtotalGeneral = subtotalGeneral+nsubtotal; 
    $("#subtotalGeneral").val(subtotalGeneral);
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: subtotalGeneral,
        formatNumber: true, 
      },
      success: function(monto){
        $(".subtotaltxt").html("$"+monto);
      }
    });
    var puntos = parseFloat($("#puntosCuotas").val());
    var precioMinimo = parseFloat($("#precioMinimo").val());
    var nPuntos = ((subtotalGeneral/precioMinimo)*puntos).toFixed(2);
    // $("#puntostxt").html(nPuntos+" pts");
  });
  $(".Menoss").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($(".val"+cod).val());
    var precio = parseFloat($("#precio"+cod).val());
    var anterior = precio*val;
    if( (val-1)>0 ){
      $(".val"+cod).val(val-1);
    }
    val = parseInt($(".val"+cod).val());
    $("#cant"+cod).val(val);
    var nsubtotal = precio*val;
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: nsubtotal,
        formatNumber: true, 
      },
      success: function(monto){
        $(".totaltxt"+cod).html("$"+monto);
      }
    });
    var subtotalGeneral = parseFloat($("#subtotalGeneral").val());
    subtotalGeneral = subtotalGeneral-anterior;
    subtotalGeneral = subtotalGeneral+nsubtotal;
    $("#subtotalGeneral").val(subtotalGeneral);
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: subtotalGeneral,
        formatNumber: true, 
      },
      success: function(monto){
        $(".subtotaltxt").html("$"+monto);
      }
    });
    var puntos = parseFloat($("#puntosCuotas").val());
    var precioMinimo = parseFloat($("#precioMinimo").val());
    var nPuntos = ((subtotalGeneral/precioMinimo)*puntos).toFixed(2);
    $("#puntostxt").html(nPuntos+" pts");
  });
  $('.valuesCant').on('input', function () {
    var cod = $(this).attr("id");
    var valcant = parseInt($("#cant"+cod).val());
    var precio = parseFloat($("#precio"+cod).val());
    var anterior = precio*valcant;
    this.value = this.value.replace(/[^0-9]/g, '');
    val = parseInt($(".val"+cod).val());
    $("#cant"+cod).val(val);
    var nsubtotal = precio*val;
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: nsubtotal,
        formatNumber: true, 
      },
      success: function(monto){
        $(".totaltxt"+cod).html("$"+monto);
      }
    });
    var subtotalGeneral = parseFloat($("#subtotalGeneral").val());
    subtotalGeneral = subtotalGeneral-anterior;
    subtotalGeneral = subtotalGeneral+nsubtotal;
    $("#subtotalGeneral").val(subtotalGeneral);
    $.ajax({
      url:'',
      type:"POST",
      data:{
        val: subtotalGeneral,
        formatNumber: true, 
      },
      success: function(monto){
        $(".subtotaltxt").html("$"+monto);
      }
    });
    var puntos = parseFloat($("#puntosCuotas").val());
    var precioMinimo = parseFloat($("#precioMinimo").val());
    var nPuntos = ((subtotalGeneral/precioMinimo)*puntos).toFixed(2);
    $("#puntostxt").html(nPuntos+" pts");
  });

  $(".aprobarPedido").click(function(){
    var inventarios = $(".codigosInventarios").html();
    var invent = JSON.parse(inventarios);
    var errors = 0;
    var factura = 0;
    for (var i = 0; i <= invent.length-1; i++) {
      var cod = invent[i]['cod'];
      var value = parseFloat($(".val"+cod).val());
      var precio = parseFloat($(".precio"+cod).val());
      var exist = parseInt($(".existencia"+cod).val());
      factura+=(value*precio);
      if(value > exist){
        $(".tr"+cod).attr("style","background:#CC000088");
        errors++;
      }else{
        $(".tr"+cod).attr("style","background:none;");
      }
    }
    var minimoFactura = parseFloat($(".facturaMinima").val());
    if(factura>=minimoFactura){
      $(".errorCantidadMinimaAprobar").addClass("d-none");
      if(errors==0){
        $(".alertaErrorAprobar").addClass("d-none");
        swal.fire({ 
          title: "¿Desea aprobar el pedido?",
          text: "Se va a guardar su selección para aprobar el pedido, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
            $(".FormPedidoFacturaTotal").submit();
          }else { 
            swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "<?=$colorPrimaryAll; ?>",
            });
          } 
        });
      }else{
        $(".alertaErrorAprobar").removeClass("d-none");
      }
    }else{
      $(".errorCantidadMinimaAprobar").removeClass("d-none");
      var letraMinimo = $(".errorCantidadMinimaAprobar").attr("id");
      var mensajeMostrar = "La cantidad minima para aprobar es de <b>"+letraMinimo+"</b><br>La factura actual es menor a esa cantidad ($"+factura+").";
      // alert(letraMinimo);
      $(".errorCantidadMinimaAprobar").html(mensajeMostrar);
    }
  });

  // $(".actualizarCarrito").click(function(){
  //   swal.fire({ 
  //     title: "¿Desea actualizar al carrito?",
  //     text: "Se va a actualizar la cantidad especificada al carrito, ¿desea continuar?",
  //     type: "question",
  //     showCancelButton: true,
  //     confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //     confirmButtonText: "¡Si!",
  //     cancelButtonText: "No", 
  //     closeOnConfirm: false,
  //     closeOnCancel: false 
  //   }).then((isConfirm) => {
  //     if (isConfirm.value){
  //       $(".formCantidadCarrito").submit();
  //     }else { 
  //       swal.fire({
  //         type: 'error',
  //         title: '¡Proceso cancelado!',
  //         confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //       });
  //     } 
  //   });
  // });

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
                      // alert($(this).attr("id"));
                      window.location = $(this).attr("id");
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
