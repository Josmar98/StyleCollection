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


        ?>
        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="font-size:2em;"><?php echo "Carro - Ciclo ".$num_ciclo."/".$ano_ciclo; ?></h3>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <!-- <div class="row" style="text-align:right;">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Cart" class="dropdown-toggle box_notificaciones" style="" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-shopping-cart" style="font-size:1.2em"></i>
                    <span class="label cantidad_carrito <?=$classHidden; ?>" style="background:#00000022;border-radius:10px;font-size:1em;position:relative;top:-10px;right:0px;"><?=$cantidadCarrito; ?></span>
                  </a>
                </div>
              </div> -->
              <!-- <div class="row">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Pedidos&action=Registrar<?=$addUrlAdmin; ?>">
                    <span style="margin-left:25px;">Volver al catalogo de premios de Ciclo <?=$num_ciclo."/".$ano_ciclo; ?></span>
                  </a>
                </div>
              </div> -->
              <br>
              <div class="row">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Pedidos&action=Registrar<?=$addUrlAdmin; ?>">
                    <span style="margin-left:25px;">Volver al catalogo de premios de Ciclo <?=$num_ciclo."/".$ano_ciclo; ?></span>
                  </a>
                </div>
              </div>
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

                          <option value="<?=$lid['id_cliente']; ?>"
                            <?php if(!empty($_GET['lider']) && $_GET['lider']==$lid['id_cliente']){ echo "selected"; } ?> 
                            <?php 
                              if(!empty($_GET['op']) && $_GET['op']=="Editar"){ 
                                if(!empty($_GET['lider']) && $lid['id_cliente']!=$_GET['lider']){
                                  echo "disabled";
                                } 
                              } 
                            ?> 
                            ><?=$lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']; ?></option>


                          <?php } } } ?>
                        </select>
                        <button class="btn enviar2">Seleccionar Lider</button>
                      </form>
                    </div>
                  </div>
                  <br>
                  <?php
                }
              ?>
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-responsive" style="padding-left:2.5%;padding-right:2.5%;max-height:65vh;overflow:auto;">
                    <?php
                      $subtotal = 0;
                    ?>
                    <table class="table table-hover table-striped" style="width:100%;text-align:left !important;">
                      <thead>
                        <tr style="background:#EEE;font-size:1.3em;">
                          <?php if(($addUrlAdmin!="" && $accesoPedidosClienteE) || $addUrlAdmin==""){ ?>
                          <th style="text-align:left;"></th>
                          <?php } ?>
                          <th style="text-align:left;"></th>
                          <th style="text-align:left;">Producto</th>
                          <th style="text-align:left;">Precio</th>
                          <th style="text-align:left;">Cantidad</th>
                          <th style="text-align:left;">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($carrito)>1){ ?>
                          <form class="formCantidadCarrito" method="POST" action="?<?=$menu; ?>&route=<?=$_GET['route'].$addUrlAdmin; ?>">
                            <?php foreach ($carrito as $cart){ if(!empty($cart['id_carrito'])){ ?>
                              <tr>
                                <?php if(($addUrlAdmin!="" && $accesoPedidosClienteE) || $addUrlAdmin==""){ ?>
                                <td style="width:2%;">
                                    <span class="btn eliminarBtn" style="border:0;background:none;color:red" id="?<?=$menu; ?>&route=<?=$url.$addUrlAdmin; ?>&id=<?=$cart['id_carrito']; ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </span>
                                </td>
                                <?php } ?>
                                <td style="width:10%;"><img src="<?=$cart['imagen_inventario']; ?>" style="width:100%;"></td>
                                <td style="width:30%;"><?=$cart['nombre_inventario']; ?></td>
                                <td style="width:15%;"><?="$".number_format($cart['precio_inventario'],2,',','.'); ?></td>
                                <td style="width:30%;">
                                  <div class="input-group col-xs-12 col-sm-6" style="">
                                    <input type="hidden" name="id_carrito[]" value="<?=$cart['id_carrito']; ?>">
                                    <input type="hidden" name="cod_inventario[]" value="<?=$cart['cod_inventario']; ?>">
                                    <span id="<?=$cart['cod_inventario']; ?>" class="Menoss input-group-addon btn" style="width:25%;">-</span>
                                    <input type="number" step="1" min="1" value="<?=$cart['cantidad_inventario']; ?>" id="<?=$cart['cod_inventario']; ?>" style="text-align:center;" name="cantidad_inventario[]" class="form-control valuesCant val<?=$cart['cod_inventario']; ?>">
                                    <span id="<?=$cart['cod_inventario']; ?>" class="Mass input-group-addon btn" style="width:25%;">+</span>
                                  </div>
                                  <input type="hidden" id="precio<?=$cart['cod_inventario']; ?>" value="<?=$cart['precio_inventario']; ?>">
                                  <input type="hidden" id="cant<?=$cart['cod_inventario']; ?>" value="<?=$cart['cantidad_inventario']; ?>">
                                </td>
                                <td style="width:15%;"><span class="totaltxt<?=$cart['cod_inventario']; ?>"><?="$".number_format(($cart['cantidad_inventario'])*($cart['precio_inventario']),2,',','.'); ?></span></td>
                              </tr>
                              <?php $subtotal += ($cart['cantidad_inventario'])*($cart['precio_inventario']) ?>
                            <?php } } ?>
                          </form>
                        <?php }else{ ?>
                          <tr>
                            <td style="text-align:center;font-size:1.25em;" colspan="6">No hay elementos en el carrito</td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-xs-12 text-right">
                  <div class="table" style="padding-left:2.5%;padding-right:2.0%;">
                    <table class="table table-hover table-striped" style="font-size:1.5em;width:100%;text-align:left !important;">
                      <thead style="background:#CCC;">
                        <tr>
                          <th style="width:40%;"></th>
                          <th style="width:35%;text-align:right;">Sub total: </th>
                          <th style="width:25%;text-align:left;padding-right:20px;"><span id="subtotaltxt"><?="$".number_format($subtotal,2,',','.'); ?></span></th>
                        </tr>
                        <input type="hidden" id="subtotalGeneral" value="<?=$subtotal; ?>">
                      </thead>
                      <tfoot style="padding-top:2%;">
                        <!-- <tr><td colspan="6"><hr></td></tr> -->
                        <?php if($estado_ciclo=="1"){ ?>
                          <?php 
                            $mostrar=0;
                            if($accesoPedidosClienteR || $accesoPedidosClienteM){
                              $mostrar=1;
                            } else if(($accesoPedidosR||$accesoPedidosR) && ($fechaActual <= $ciclo['cierre_seleccion']) ){ 
                              $mostrar=1;
                            }
                            if($mostrar==1){
                              ?>
                              <tr><td colspan="6" style="text-align:right;"><button class="btn enviar2 actualizarCarrito" style="margin-top:2%;">Actualizar Carrito</button></td></tr>
                              <?php
                            }
                          ?>
                        <?php } ?>
                        <!-- <tr><td colspan="6"><hr></td></tr> -->
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-7 col-sm-offset-4 col-md-5 col-md-offset-6">
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
                        <td style="padding:20px 30px;width:60%;"><b><?="$".number_format($subtotal,2,',','.'); ?></b></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php if($estado_ciclo=="1"){ ?>
                  <div>
                    <?php if($subtotal<$ciclo['precio_minimo']){ ?>
                    <div class="alerta_mensaje alert alert-warning">
                      Debe tener un total minimo <b><?="$".number_format($ciclo['precio_minimo'],2,',','.'); ?></b> para realizar el pedido.
                    </div>
                    <?php } ?>
                    <form action="" method="post" class="FormPedidoFacturaTotal">
                      <input type="hidden" name="solicitarPedido" value="1">
                      <input type="hidden" name="totalFactura" value="<?=$subtotal; ?>">
                    </form>
                    <?php if(count($pedidos)>1){ ?>
                      <?php 
                        $mostrar=0;
                        if($accesoPedidosClienteR || $accesoPedidosClienteM){
                          $mostrar=1;
                        } else if(($accesoPedidosR||$accesoPedidosR) && ($fechaActual <= $ciclo['cierre_seleccion']) ){ 
                          $mostrar=1;
                        }
                        if($mostrar==1){
                          ?>
                            <?php if($notaExistente==0){ ?>
                          <button class="btn btn-lg  btn-warning realizarPedido" <?php if($subtotal < $ciclo['precio_minimo']){ echo "disabled"; } ?> style="width:100%;font-size:1.5em;">Carrito cerrado | Actualizar Pedido</button>
                            <?php } ?>
                          <?php
                        }
                      ?>
                    <?php }else{ ?>
                      <?php 
                        $mostrar=0;
                        if($accesoPedidosClienteR || $accesoPedidosClienteM){
                          $mostrar=1;
                        } else if(($accesoPedidosR||$accesoPedidosR) && ($fechaActual <= $ciclo['cierre_seleccion']) ){ 
                          $mostrar=1;
                        }
                        if($mostrar==1){
                          if($deudaEnCiclosAnteriores>0){
                          ?>
                          <div class="alert alert-danger">
                            Para realizar un pedido en este ciclo, debe estar al día con sus abonos en sus ciclos con factura abierta.
                          </div>
                          <?php
                          }else{
                          ?>
                            <?php if($notaExistente==0){ ?>
                          <button class="btn btn-lg enviar2 realizarPedido" <?php if($subtotal < $ciclo['precio_minimo']){ echo "disabled"; } ?> style="width:100%;font-size:1.5em;">Cerrar carrito | Realizar Pedido</button>
                            <?php } ?>
                          <?php
                          }
                        }
                      ?>
                    <?php } ?>
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
        title: '¡Carrito actualizado correctamente!',
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?<?=$menu; ?>&route=<?=$url.$addUrlAdmin; ?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    if(response == "11"){
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
        window.location = "?<?=$menu; ?>&route=<?=$url.$addUrlAdmin; ?>";
      });
    }
    if(response == "22"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    if(response == "1111"){
      swal.fire({
        type: 'success',
        title: '¡Pedido realizado correctamente!',
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?<?=$menu; ?>&route=CHome";
      });
    }
    if(response == "2222"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  }
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
        $("#subtotaltxt").html("$"+monto);
      }
    });
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
        $("#subtotaltxt").html("$"+monto);
      }
    });
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
        $("#subtotaltxt").html("$"+monto);
      }
    });
  });

  $(".actualizarCarrito").click(function(){
    swal.fire({ 
      title: "¿Desea actualizar al carrito?",
      text: "Se va a actualizar la cantidad especificada al carrito, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      confirmButtonText: "¡Si!",
      cancelButtonText: "No", 
      closeOnConfirm: false,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        $(".formCantidadCarrito").submit();
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        });
      } 
    });
  });

  $(".realizarPedido").click(function(){
    swal.fire({ 
      title: "¿Desea guardar y realizar el pedido?",
      text: "Se va a guardar su selección y se hará la solicitud de pedido, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      confirmButtonText: "¡Si!",
      cancelButtonText: "No", 
      closeOnConfirm: false,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        // var factura = $("#totalFactura").val();
        // alert(factura);
        // alert('vamoj a ve');
        $(".FormPedidoFacturaTotal").submit();
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
