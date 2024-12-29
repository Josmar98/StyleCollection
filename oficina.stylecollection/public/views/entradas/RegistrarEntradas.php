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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
          <?php if($amInventarioC==1){ ?>
            <div style="width:100%;text-align:center;"><a href="?route=<?=$url; ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo; ?></a></div>
          <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Registrar <?=$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="tipoInv">Tipo de inventario</label>
                      <select class="form-control" id="tipoInv" name="tipoInv" style="width:100%;">
                        <option value=""></option>
                        <?php foreach($tipoInventarios as $tipoInv){ ?>
                          <option value="<?=$tipoInv['id'] ?>"><?=$tipoInv['name'] ?></option>
                        <?php } ?>
                      </select>
                      <span id="error_tipoInv" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="transaccion">Seleccionar transacción</label>
                      <select class="form-control transacciones" id="transaccion" name="transaccion"  style="width:100%">
                        <option value=""></option>
                        <option class="transaccion_prod" value="Produccion">Producción</option>
                        <option class="transaccion_comp" value="Compra">Compra</option>
                        <option value="Averia">Averia</option>
                      </select>
                      <span id="error_transaccion" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <!-- <div class="form-group col-sm-12 col-md-4">
                      <label for="fecha_operacion">Fecha de operación (Entrada)</label>
                      <input type="datetime-local" class="form-control" id="fecha_operacion" name="fecha_operacion" value="<?php echo date('Y-m-d H:i'); ?>" readonly>
                      <span id="error_fecha_operacion" class="errors"></span>
                    </div> -->

                    <div class="form-group col-sm-12 col-md-6">
                      <label for="fecha_documento">Fecha de documento</label>
                      <input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="<?php echo date('Y-m-d'); ?>">
                      <span id="error_fecha_documento" class="errors"></span>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                      <label for="numero_documento">Número de documento</label>
                      <input type="number" class="form-control" id="numero_documento" name="numero_documento" step="1" placeholder="Ingresar número de documento">
                      <span id="error_numero_documento" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="numero_lote">Número de lote</label>
                      <input type="number" class="form-control" id="numero_lote" name="numero_lote" step="1" placeholder="Ingresar número de lote">
                      <span id="error_numero_lote" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="fecha_vencimiento">Fecha de vencimiento</label>
                      <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                      <span id="error_fecha_vencimiento" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    

                    <div class="form-group col-sm-12 col-md-4 box-proveedores box-proveedoress">
                      <label for="proveedor">Seleccionar Proveedor / Cliente</label>
                      <select class="form-control select2 proveedores" id="proveedor" style="width:100%">
                        <option value=""></option>
                      </select>
                      <span id="error_proveedor" class="errors"></span>
                    </div>
                    <?php foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){ ?>
                      <div class="form-group col-sm-12 col-md-4 box-proveedores<?=$tp['id']; ?> box-proveedoress box-proveedoresx d-none">
                        <label for="proveedor<?=$tp['id']; ?>">Seleccionar Proveedor</label>
                        <select class="form-control select2 proveedores" id="proveedor<?=$tp['id']; ?>" name="proveedor<?=$tp['id']; ?>"  style="width:100%">
                          <option value=""></option>
                          <?php foreach($proveedores[$tp['id']] as $prov){ if(!empty($prov['id_proveedor_inventario'])){ ?>
                            <option value="<?php echo $prov['id_proveedor_inventario']; ?>"><?php echo $prov['codRif'].$prov['rif']." ".$prov['nombreProveedor']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_proveedor<?=$tp['id']; ?>" class="errors"></span>
                      </div>
                    <?php } } ?>
                    <?php if(!empty($clientes)){ ?>
                      <div class="form-group col-sm-12 col-md-4 box-proveedoresClientes box-proveedoress box-proveedoresx d-none">
                        <label for="proveedorClientes">Seleccionar Clientes</label>
                        <select class="form-control select2 proveedores" id="proveedorClientes" name="proveedorClientes"  style="width:100%;">
                          <option value=""></option>
                          <?php foreach($clientes as $client){ if(!empty($client['id_cliente'])){ ?>
                            <option value="<?php echo $client['id_cliente']; ?>"><?php echo $client['cod_rif'].$client['rif']." ".$client['primer_nombre']." ".$client['primer_apellido']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_proveedorClientes" class="errors"></span>
                      </div>
                    <?php } ?>
                    
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="almacen">Seleccionar Almacen</label>
                      <select class="form-control select2 almacenes" id="almacen" name="almacen"  style="width:100%">
                        <option value=""></option>
                        <?php foreach ($almacenes as $alm){ if(!empty($alm['id_almacen'])){  ?>
                          <option value="<?=$alm['id_almacen']; ?>"><?=$alm['nombre_almacen'];?></option>
                        <?php }} ?>
                      </select>
                      <span id="error_almacen" class="errors"></span>
                    </div>
                    

                    <div class="form-group col-sm-12 col-md-4 box-descincorporar d-none">
                      <label for="descincorporar">¿Desincorporar?</label>
                      <select class="form-control" id="descincorporar" name="descincorporar"  style="width:100%">
                        <option value="No">No</option>
                        <option value="Si">Si</option>
                      </select>
                      <span id="error_descincorporar" class="errors"></span>
                    </div>
                     
                  </div>
                  <hr>
                  <!-- <div class="row">
                    <div class="form-group col-sm-12 col-md-4 box-inventariosProductos box-inventariosMercancia box-inventarios d-none">
                      <label for="stock">Cantidad de Unidades</label>
                      <input type="number" class="form-control" id="stock" name="stock" step="1" placeholder="Cantidad de Stock (150)">
                      <span id="error_stock" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-12 col-md-8 box-inventariosProductos box-inventarios d-none">
                      <label for="inventarioProductos">Seleccionar Productos</label>
                      <select class="form-control select2 inventarios" id="inventarioProductos" name="inventarioProductos"  style="width:100%">
                        <option value=""></option>
                        <?php foreach($productos as $inv){ if(!empty($inv['id_producto'])){ ?>
                          <option value="<?php echo $inv['id_producto']; ?>"><?php echo $inv['codigo_producto']." ".$inv['producto']."(".$inv['cantidad'].") ".$inv['marca_producto']; ?></option>
                        <?php } } ?>
                      </select>
                      <span id="error_inventarioProductos" class="errors"></span>
                    </div>
  
                    <div class="form-group col-sm-12 col-md-8 box-inventariosMercancia box-inventarios d-none">
                      <label for="inventarioMercancia">Seleccionar Mercancia</label>
                      <select class="form-control select2 inventarios" id="inventarioMercancia" name="inventarioMercancia"  style="width:100%">
                        <option value=""></option>
                        <?php foreach($mercancia as $inv){ if(!empty($inv['id_mercancia'])){ ?>
                          <option value="<?php echo $inv['id_mercancia']; ?>"><?php echo $inv['codigo_mercancia']." ".$inv['mercancia']."(".$inv['medidas_mercancia'].") ".$inv['marca_mercancia']; ?></option>
                        <?php } } ?>
                      </select>
                      <span id="error_inventarioMercancia" class="errors"></span>
                    </div>
                  </div> -->
                  
                  <input type="hidden" id="limiteElementos" value="<?=$limiteElementos; ?>">
                  <div class="row" style="padding:0px 17px;">
                    <div style="width:15%;float:left" class=" box-inventariosProductos1 box-inventariosMercancia1 box-inventario d-none">
                      <label>Cantidad</label>
                    </div>
                    <div style="width:65%;float:left" class=" box-inventariosProductos1 box-inventariosMercancia1 box-inventario d-none">
                      <label>Descripcion</label>
                    </div>
                    <div style="width:20%;float:right;" class=" box-inventariosProductos1 box-inventariosMercancia1 box-inventario d-none">
                      <label>Monto Total</label>
                    </div>
                  </div>
                  <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                    <div class="row" style="padding:0px 15px;">
                      <div style="width:15%;float:left;" class=" box-inventariosProductos<?=$z; ?> box-inventariosMercancia<?=$z; ?> box-inventario d-none">
                        <input type="number" class="form-control" id="stock<?=$z; ?>" min="0" name="stock[]" step="1" placeholder="Cantidad (150)">
                        <span id="error_stock<?=$z; ?>" class="errors"></span>
                      </div>
                      <div style="width:65%;float:left;" class=" box-inventariosProductos<?=$z; ?> box-inventario d-none">
                        <select class="form-control select2 inventarios" id="inventarioProductos<?=$z; ?>" name="inventarioProductos[]"  style="width:100%">
                          <option value=""></option>
                          <?php foreach($productos as $inv){ if(!empty($inv['id_producto'])){ ?>
                            <option value="<?php echo $inv['id_producto']; ?>"><?php echo $inv['codigo_producto']." ".$inv['producto']."(".$inv['cantidad'].") ".$inv['marca_producto']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_inventarioProductos<?=$z; ?>" class="errors"></span>
                      </div>
    
                      <div style="width:65%;float:left;" class=" box-inventariosMercancia<?=$z; ?> box-inventario d-none">
                        <select class="form-control select2 inventarios" id="inventarioMercancia<?=$z; ?>" name="inventarioMercancia[]"  style="width:100%">
                          <option value=""></option>
                          <?php foreach($mercancia as $inv){ if(!empty($inv['id_mercancia'])){ ?>
                            <option value="<?php echo $inv['id_mercancia']; ?>"><?php echo $inv['codigo_mercancia']." ".$inv['mercancia']."(".$inv['medidas_mercancia'].") ".$inv['marca_mercancia']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_inventarioMercancia<?=$z; ?>" class="errors"></span>
                      </div>

                      <div style="width:20%;float:right;" class=" box-inventariosProductos<?=$z; ?> box-inventariosMercancia<?=$z; ?> box-inventario d-none">
                        <input type="number" class="form-control" id="total<?=$z; ?>" name="total[]" step="1" placeholder="Monto ($.1500)">
                        <span id="error_total<?=$z; ?>" class="errors"></span>
                      </div>
                    </div>
                    <div style='width:100%;'>
                      <span style='float:left' id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success box-inventariosProductos<?=$z; ?> box-inventariosMercancia<?=$z; ?> box-inventario d-none"><b>+</b></span>
                      <span style='float:right' id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger box-inventariosProductos<?=$z; ?> box-inventariosMercancia<?=$z; ?> box-inventario d-none"><b>-</b></span>
                    </div>
                  <?php } ?>

                  <hr>
                  <input type="hidden" id="cantidad_elementos" name="cantidad_elementos" value="0">
                  
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
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

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.addMore, .addMenos{
  border-radius:40px;
  border:1px solid #CCC;
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
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Entradas";
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

  $(".box-inventarios").hide();
  $(".box-inventarios").removeClass("d-none");
  $(".box-proveedoresx").hide();
  $(".box-proveedoresx").removeClass("d-none");
  $("#tipoInv").on('change', function(){
    var tpInv = $(this).val();
    var transaccion = $('#transaccion').val();
    var tpInvs = "";
    if(transaccion=="Averia"){
      tpInvs = "Clientes";
    }else{
      tpInvs = tpInv;
    }
    $(".box-inventario").hide();
    $("#cantidad_elementos").val(0);
    $(".box-proveedoress").hide();
    $(`.box-proveedores${tpInvs}`).show();
    $(".transaccion_prod").removeAttr("disabled style");
    $(".transaccion_comp").removeAttr("disabled style");
    var inventarios = "";
    if(tpInv=="Productos"){
      inventarios = $(".json_productos").html();
      $(".transaccion_comp").attr("disabled", "disabled");
      $(".transaccion_comp").attr("style", "color:#ccc");
    }
    if(tpInv=="Mercancia"){
      inventarios = $(".json_mercancia").html();
      $(".transaccion_prod").attr("disabled", "disabled");
      $(".transaccion_prod").attr("style", "color:#ccc");
    }
    // if(tpInv!=""){
    //   $(`.box-inventarios${tpInv}`).slideDown();
    // }
    var cant = $("#cantidad_elementos").val();
    if(cant==0){
      cant++;
      alimentarFormInventario(tpInv,inventarios);
      $("#addMenos"+cant).hide();
    }
    // $(".elementsInventario").html();
  });
  $("#transaccion").on('change', function(){
    var tpInv = $("#tipoInv").val();
    var transaccion = $('#transaccion').val();
    var tpInvs = "";
    if(transaccion=="Averia"){
      tpInvs = "Clientes";
    }else{
      tpInvs = tpInv;
    }
    $(".box-inventario").hide();
    $("#cantidad_elementos").val(0);
    $(".box-proveedoress").hide();
    $(`.box-proveedores${tpInvs}`).show();
    $(".transaccion_prod").removeAttr("disabled style");
    $(".transaccion_comp").removeAttr("disabled style");
    var inventarios = "";
    if(tpInv=="Productos"){
      inventarios = $(".json_productos").html();
      $(".transaccion_comp").attr("disabled", "disabled");
      $(".transaccion_comp").attr("style", "color:#ccc");
    }
    if(tpInv=="Mercancia"){
      inventarios = $(".json_mercancia").html();
      $(".transaccion_prod").attr("disabled", "disabled");
      $(".transaccion_prod").attr("style", "color:#ccc");
    }
    // if(tpInv!=""){
    //   $(`.box-inventarios${tpInv}`).slideDown();
    // }
    var cant = $("#cantidad_elementos").val();
    if(cant==0){
      cant++;
      alimentarFormInventario(tpInv,inventarios);
      $("#addMenos"+cant).hide();
    }
    // $(".elementsInventario").html();
  });

  $(".addMore").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    var tpInv=$("#tipoInv").val();
    var inventarios = "";
    if(tpInv=="Productos"){
      inventarios = $(".json_productos").html();
    }
    if(tpInv=="Mercancia"){
      inventarios = $(".json_mercancia").html();
    }
    // alert(index);
    $("#addMore"+index).hide();
    $("#addMenos"+index).hide();
    alimentarFormInventario(tpInv,inventarios);
  });

  $(".addMenos").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    var tpInv=$("#tipoInv").val();
    var inventarios = "";
    if(tpInv=="Productos"){
      inventarios = $(".json_productos").html();
    }
    if(tpInv=="Mercancia"){
      inventarios = $(".json_mercancia").html();
    }
    // alert(index);
    $("#addMore"+index).hide();
    $("#addMenos"+index).hide();
    var cant = parseInt($("#cantidad_elementos").val());
    cant--;
    $("#addMore"+cant).show();
    $("#addMenos"+cant).show();
    retroalimentarFormInventario(tpInv,inventarios);
  });

  function alimentarFormInventario(inv, inventarios){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementos").val());
    cant++;
    $(`.box-inventarios${inv}${cant}`).show();
    if(cant == limite){
      $("#addMore"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  function retroalimentarFormInventario(inv, inventarios){
    var cant = parseInt($("#cantidad_elementos").val());
    $(`.box-inventarios${inv}${cant}`).hide();
    cant--;
    if(cant<2){
      $("#addMenos"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  
  $(".box-descincorporar").hide();
  $(".box-descincorporar").removeClass('d-none');
  $("#transaccion").on('change', function(){
    var op = $(this).val();
    if(op=='Averia'){
      $(".box-descincorporar").slideDown();
    }else{
      $(".box-descincorporar").slideUp();
    }
  });
    
  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");
      var datas = $(".form_register").serialize();
      swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
            // $.ajax({
            //     url: '',
            //     type: 'POST',
            //     data: {
            //       validarData: true,
            //       nombre_mercancia: nombre_mercancia,
            //       codigo_mercancia: codigo_mercancia,
            //       // cantidad: cantidad,
            //     },
            //     success: function(respuesta){
            //       // alert(respuesta);
            //       if (respuesta == "1"){
            //           $(".btn-enviar").removeAttr("disabled");
            //           $(".btn-enviar").click();
            //       }
            //       if (respuesta == "9"){
            //         swal.fire({
            //             type: 'error',
            //             title: '¡Los datos ingresados estan repetidos!',
            //             confirmButtonColor: "#ED2A77",
            //         });
            //       }
            //       if (respuesta == "5"){ 
            //         swal.fire({
            //             type: 'error',
            //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
            //             confirmButtonColor: "#ED2A77",
            //         });
            //       }
            //     }
            // });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var tipoInv = $("#tipoInv").val();
  var rtipoInv = false;
  if(tipoInv==""){
    rtipoInv=false;
    $("#error_tipoInv").html("Debe seleccionar un tipo de inventario");
  }else{
    rtipoInv=true;
    $("#error_tipoInv").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var transaccion = $("#transaccion").val();
  var rtransaccion = false;
  if(transaccion==""){
    rtransaccion=false;
    $("#error_transaccion").html("Debe seleccionar un tipo de inventario");
  }else{
    rtransaccion=true;
    $("#error_transaccion").html("");
  }
  /*===================================================================*/



  /*===================================================================*/
  var fecha_doc = $("#fecha_documento").val();
  var rfecha_doc = false;
  if(fecha_doc==""){
    rfecha_doc=false;
    $("#error_fecha_documento").html("Debe seleccionar la fecha de documento");
  }else{
    rfecha_doc=true;
    $("#error_fecha_documento").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var rnumero_documento = false;
  if(transaccion=="Averia"){
    rnumero_documento = true;
    $("#error_numero_documento").html("");
  }else{
    var numero_documento = $("#numero_documento").val();
    var rnumero_documento = checkInput(numero_documento, numberPattern);
    if( rnumero_documento == false ){
      if(numero_documento.length != 0){
        $("#error_numero_documento").html("El numero de documento no debe contener letras o caracteres especiales");
      }else{
        $("#error_numero_documento").html("Debe llenar el campo de numero de documento");      
      }
    }else{
      $("#error_numero_documento").html("");
    }
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var rfecha_vencimiento = false;
  if(transaccion=="Produccion"){
    var fecha_vencimiento = $("#fecha_vencimiento").val();
    rfecha_vencimiento = false;
    if(fecha_vencimiento==""){
      rfecha_vencimiento=false;
      $("#error_fecha_vencimiento").html("Debe seleccionar la fecha de vencimiento");
    }else{
      rfecha_vencimiento=true;
      $("#error_fecha_vencimiento").html("");
    }
  }else{
    $("#error_fecha_vencimiento").html("");
    rfecha_vencimiento = true;
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var rnumero_lote=false;
  if(transaccion=="Produccion"){
    var numero_lote = $("#numero_lote").val();
    rnumero_lote = checkInput(numero_lote, numberPattern);
    if( rnumero_lote == false ){
      if(numero_lote.length != 0){
        $("#error_numero_lote").html("El numero de lote no debe contener letras o caracteres especiales");
      }else{
        $("#error_numero_lote").html("Debe llenar el campo de numero de lote");      
      }
    }else{
      $("#error_numero_lote").html("");
    }
  }else{
    $("#error_numero_lote").html("");
    rnumero_lote=true;
  }
  /*===================================================================*/

  /*===================================================================*/
  var tpInvs = "";
  var provecliente = "";
  if(transaccion=="Averia"){
    tpInvs = "Clientes";
    provecliente = "cliente";
  }else{
    tpInvs = tipoInv;
    provecliente = "proveedor";
  }
  var rproveedor = false;
  var proveedor = $("#proveedor"+tpInvs).val();
  if(proveedor==""){
    rproveedor=false;
    $("#error_proveedor"+tpInvs).html("Debe seleccionar un "+provecliente+" de inventario");
  }else{
    rproveedor=true;
    $("#error_proveedor"+tpInvs).html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var almacen = $("#almacen").val();
  var ralmacen = false;
  if(almacen==""){
    ralmacen=false;
    $("#error_almacen").html("Debe seleccionar el almacen");
  }else{
    ralmacen=true;
    $("#error_almacen").html("");
  }
  /*===================================================================*/
  
  

  var cantidad_elementos = $("#cantidad_elementos").val();
  var rstocks = false;
  var rinventarios = false;
  var rtotales = false;
  if(cantidad_elementos==0){
    var rstocks = false;
    var rinventarios = false;
    var rtotales = false;
  }else{
    var erroresStock=0;
    var erroresInventario=0;
    var erroresTotales=0;
    for (let i=1; i<=cantidad_elementos;i++) {
      /*===================================================================*/
        var stock = $("#stock"+i).val();
        var rstock = checkInput(stock, numberPattern);
        if( rstock == false ){
          if(stock.length != 0){
            $("#error_stock"+i).html("La cantidad de unidades #"+i+" no debe contener letras o caracteres especiales");
          }else{
            $("#error_stock"+i).html("Debe llenar el campo de cantidad de unidades #"+i);      
          }
        }else{
          $("#error_stock"+i).html("");
        }
        if(rstock==false){ erroresStock++; }
      /*===================================================================*/
      
      /*===================================================================*/
        var inventario = $("#inventario"+tipoInv+i).val();
        var rinventario = false;
        if(inventario==""){
          rinventario=false;
          $("#error_inventario"+tipoInv+i).html("Debe seleccionar un elemento del inventario #"+i);
        }else{
          rinventario=true;
          $("#error_inventario"+tipoInv+i).html("");
        }
        if(rinventario==false){ erroresInventario++; }
      /*===================================================================*/
    
      /*===================================================================*/
        if(transaccion=="Compra"){
          var total = $("#total"+i).val();
          var rtotal = checkInput(total, numberPattern);
          if( rtotal == false ){
            if(total.length != 0){
              $("#error_total"+i).html("El total #"+i+" del documento debe ser un valor numerico");
            }else{
              $("#error_total"+i).html("Debe llenar el total #"+i+" del documento");      
            }
          }else{
            $("#error_total"+i).html("");
          }
          if(rtotal==false){ erroresTotales++; }
        }else{
          $("#error_total"+i).html("");
        }
      /*===================================================================*/
    }
    if(erroresStock==0){ rstocks=true; }
    if(erroresInventario==0){ rinventarios=true; }
    if(erroresTotales==0){ rtotales=true; }
  }

  /*===================================================================*/
    var result = false;
    if( rfecha_doc==true && rnumero_documento==true && rnumero_lote==true && rfecha_vencimiento==true && rtipoInv==true && rproveedor==true && ralmacen==true && rtransaccion==true && rstocks==true && rinventarios==true && rtotales==true){
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
