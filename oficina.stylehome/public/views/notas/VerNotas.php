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
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      
      <div class="row">

        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo; ?></h3>
            </div>

            <form action="" method="get" class="form table-responsive" target="_blank">
              <input type="hidden" name="c" value="<?=$_GET['c']; ?>">
              <input type="hidden" name="n" value="<?=$_GET['n']; ?>">
              <input type="hidden" name="y" value="<?=$_GET['y']; ?>">
              <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
              <input type="hidden" name="action" value="GenerarPDF">
              <input type="hidden" name="id" value="<?=$_GET['id']; ?>">
              <div class="box-body">
                <div class="col-xs-12">
                  <div class="col-xs-12 col-sm-7 text-center">
                    <br>
                    <img src="public/assets/img/logo5.png" style="width:450px;">
                    <br><br>
                    Rif.: J408497786
                    <br>
                    <div readonly="" maxlength="255" style="border:none;min-width:100%;max-width:100%;min-height:60px;max-height:60px;text-align:center;padding:0;padding-right:10%;padding-left:10%;"><?=$nota['direccion_emision']?></div>
                    <b style="color:<?=$fucsia?>">
                    </b>
                  </div>
                  <div class="col-xs-12 col-sm-5 text-center">
                    <br class="xs-none">
                    <br class="xs-none">
                    <div style="">
                      <div class="col-xs-12 col-md-6" style="display:inline-block;">
                        <small>LUGAR DE EMISION</small>
                        <br>
                        <input type="text" style="border:none;" readonly="" value="<?=$nota['lugar_emision']?>" maxlength="90">
                      </div>
                      <div class="col-xs-12 col-md-6" style="display:inline-block;">
                        <small>FECHA DE EMISION</small>
                        <br>
                        <input type="date"  style="border:none;" readonly="" value="<?=$nota['fecha_emision'];?>">
                      </div>
                    </div>
                    <br><br><br><br>
                    <h4 style="margin-top:0;margin-bottom:0;">
                      <b>
                      NOTA DE ENTREGA
                      </b>
                    </h4>
                    <div style="display:inline-block;width:60%;">
                      <h3 style="display:inline-block;float:left;margin:0;padding:0;width:15%;"><b>N° </b></h3>
                      <!-- <span style="margin-left:10px;margin-right:10px;"></span> -->
                      <input type="number" class="form-control" min="1" readonly step="1" value="<?=$numeroNota; ?>" onfocusout="$(this).val(parseInt($(this).val()))" style="display:inline-block;font-size:1.6em;float:right;width:85%;margin:0;">
                    </div>
                  </div>
                </div> 

                <div class="col-xs-12 text-center">
                  <div class="col-xs-12" style="border-top:1px solid #777;border-bottom:1px solid #777;width:95%;margin-left:2.5%;">
                    <?=mb_strtoupper('Nota de entrega de premios'); ?>
                  </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-3" style="font-size:1.1em">
                      Ciclo <?=$num_ciclo."/".$ano_ciclo; ?>
                    </div>
                    <div class="col-xs-5" style="font-size:1.1em">
                      <!-- Analista: <input type="text" style="width:60%" placeholder="Nombre del analista" name="nombreanalista" maxlength="50"> -->
                    </div>
                    <div class="col-xs-4" style="font-size:1.2em">
                      <?php if ($numFactura != ""): ?>
                        Factura N°. 
                        <b>
                        <?=$numFactura; ?> 
                        </b>
                      <?php endif; ?>
                    </div>
                </div>

                <div class="">
                  <div class="col-xs-12" >
                    <!-- <div style="border:1px solid <?=$fucsia?>;border-radius:20px !important;padding:0;"> -->
                      <table class="table table-bordered" style="border:none;">
                        <tr>
                          <td colspan="3" style="display:inline-block;width:60%;">
                            NOMBRES Y APELLIDOS:
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']?>
                          </td>
                          <td colspan="2" style="display:inline-block;width:40%;">
                            CEDULA:
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=number_format($pedido['cedula'],0,'','.')?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3" style="display:inline-block;width:60%;">
                            DIRECCION:
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=$pedido['direccion']?>
                          </td>
                          <td colspan="2" style="display:inline-block;width:40%;">
                            TELEFONO: 
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?php 
                              echo separateDatosCuentaTel($pedido['telefono']);
                              if(strlen($pedido['telefono2'])>5){
                                echo " / ".separateDatosCuentaTel($pedido['telefono2']);
                              }
                            ?> 
                          </td>
                        </tr>
                      </table>
                    <!-- </div> -->
                  </div>
                </div>
                <div class="">
                  <div class="col-xs-12">
                    <table class="table table-bordered text-left table-striped table-hover" id="">
                      <thead style="background:#DDD;font-size:1.05em;">
                        <tr>
                          <th style="text-align:center;width:4%;">Cantidad</th>
                          <th style="text-align:left;width:48%;">Descripcion</th>
                          <th style="text-align:left;width:28%;">Concepto</th>
                          <th style="text-align:left;width:10%;"></th>
                          <th style="text-align:left;width:10%;"></th>
                        </tr>
                        <style>
                          .col1{text-align:center;}
                          .col2{text-align:left;}
                          .col3{text-align:left;}
                          .col4{text-align:left;}
                          .col5{text-align:left;}
                        </style>
                      </thead>
                      <tbody>
                        <?php
                          $num = 1;
                          foreach ($pedidosInv as $data){ if(!empty($data['id_pedido'])){ 
                            $option = "";
                            foreach ($opcinesEntrega as $opt) {
                              if(!empty($opt['id_nota'])){
                                if("P".$data['cod_inventario']==$opt['cod']){
                                  $option=$opt['val'];
                                }
                              }
                            }
                            ?>
                            <tr class="codigoP<?=$data['cod_inventario']; ?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?>>
                              <td><?=$data['cantidad_aprobada']; ?></td>
                              <td><?=$data['nombre_inventario']; ?></td>
                              <td>Pedido de Factura Directa</td>
                              <td></td>
                              <td></td>
                              <td>
                                <select class="opciones" name="P<?=$data['cod_inventario']; ?>" id="P<?=$data['cod_inventario']; ?>">
                                  <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                  <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                </select>
                              </td>
                            </tr>
                            <?php
                          } }
                          foreach ($canjeosPedidos as $data){ if(!empty($data['cod_inventario'])){
                            $option = "";
                            foreach ($opcinesEntrega as $opt) {
                              if(!empty($opt['id_nota'])){
                                if("C".$data['cod_inventario']==$opt['cod']){
                                  $option=$opt['val'];
                                }
                              }
                            }
                            ?>
                            <tr class="codigoC<?=$data['cod_inventario']; ?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?>>
                              <td><?=$data['cantidad']; ?></td>
                              <td><?=$data['nombre_inventario']; ?></td>
                              <td>Canjeo de Premio</td>
                              <td></td>
                              <td></td>
                              <td>
                                <select class="opciones" name="C<?=$data['cod_inventario']; ?>" id="C<?=$data['cod_inventario']; ?>">
                                  <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                  <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                </select>
                              </td>
                            </tr>
                            <?php
                          } }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn enviar2">Generar PDF</button>
                <!-- <button class="btn-enviar-nota d-none" disabled="" >enviar</button> -->
              </div>
            </form>
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
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<!-- <input type="hidden" class="c" value="<?php echo $id_ciclo ?>"> -->
<!-- <input type="hidden" class="n" value="<?php echo $num_ciclo ?>"> -->
<!-- <input type="hidden" class="y" value="<?php echo $ano_ciclo ?>"> -->
<input type="hidden" class="cant" value="<?php echo $cant; ?>">
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<!-- <input type="hidde" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>"> -->
<!-- <input type="hidde" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>"> -->
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>";
        window.location = menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      });
    }
    
  }

  $(".opciones").change(function(){
    var cod = $(this).attr("id");
    var val = $(this).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
    }
  });

  // $("#descuento_coleccion").change(function(){
  //   var descuento = parseFloat($(this).val());
  //   if($(".cant").val()>0){
  //     var max = parseFloat($(".max_total_descuento").val());
  //     var total = (max+descuento).toFixed(2);
  //   }else{
  //     var total = (descuento).toFixed(2);
  //   }
  //   $("#total_descuento").val(total);
  //   $(this).val((descuento).toFixed(2));
  // });

  // $("#descuento_coleccion").keyup(function(){
  //   var descuento = parseFloat($(this).val());
  //   if($(".cant").val()>1){
  //     var max = parseFloat($(".max_total_descuento").val());
  //     var total = (max+descuento).toFixed(2);
  //   }else{
  //     var total = (descuento).toFixed(2);
  //   }
  //   $("#total_descuento").val(total);
  //   $(this).val((descuento).toFixed(2));
  // });

  $(".enviar").click(function(){
    var response = validar();
    if(response == true){
      $(".btn-enviar").attr("disabled");
      swal.fire({ 
          title: "¿Desea cargar nota con el pedido seleccionado?",
          text: "Se previsualizará la nota de entrega, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Cargar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){      
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
    }
  });

  $(".enviar-nota").click(function(){
    $(".btn-enviar-nota").attr("disabled");
    swal.fire({ 
        title: "¿Desea cargar nota con el pedido seleccionado?",
        text: "Se previsualizará la nota de entrega, ¿desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        confirmButtonText: "¡Cargar!",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
    }).then((isConfirm) => {
        if (isConfirm.value){      
          $.ajax({
            url: '',
            type: 'POST',
            data: {
              validarDataNota: true,
              id_pedido: $("#id_pedido").val(),
            },
            success: function(respuesta){
              // alert(respuesta);
              if (respuesta == "1"){
                $(".btn-enviar-nota").removeAttr("disabled");
                $(".btn-enviar-nota").click();
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




});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var pedido = $("#pedido").val();
  var rpedido = false;
  // var rpedido = checkInput(pedido, textPattern);
    if( pedido.length  != 0 ){
      $("#error_pedido").html("");
      rpedido = true;
    }else{
      rpedido = false;
      $("#error_pedido").html("Debe seleccionar una factura de lider");
    }
  /*===================================================================*/


  /*===================================================================*/
  var result = false;
  if( rpedido==true ){
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
