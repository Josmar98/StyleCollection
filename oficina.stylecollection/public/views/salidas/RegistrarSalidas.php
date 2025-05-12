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
            <!-- <div style="width:100%;text-align:center;"><a href="?route=<?=$url; ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo; ?></a></div> -->
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
                      <label for="almacen">Seleccionar Almacen</label>
                      <select class="form-control select2 almacenes" id="almacen" name="almacen"  style="width:100%">
                        <option value=""></option>
                        <?php foreach ($almacenes as $alm){ if(!empty($alm['id_almacen'])){  ?>
                          <option value="<?=$alm['id_almacen']; ?>"><?=$alm['nombre_almacen'];?></option>
                        <?php }} ?>
                      </select>
                      <span id="error_almacen" class="errors"></span>
                    </div>

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

                  </div>
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="transaccion">Seleccionar transacción</label>
                      <select class="form-control transacciones" id="transaccion" name="transaccion"  style="width:100%">
                        <option value=""></option>
                        <option value="Desincorporacion">Desincorporación</option>
                        <option value="Reposicion">Reposición de averia</option>
                        <!-- <option class="transaccion_comp" value="Compra">Compra</option> -->
                        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                        <option value="Venta">Venta</option>
                        <?php } ?>
                      </select>
                      <span id="error_transaccion" class="errors"></span>
                    </div>

                    <!--
                      <div class="form-group col-sm-12 col-md-4">
                        <label for="fecha_operacion">Fecha de operación (Entrada)</label>
                        <input type="datetime-local" class="form-control" id="fecha_operacion" name="fecha_operacion" value="<?php echo date('Y-m-d H:i'); ?>" readonly>
                        <span id="error_fecha_operacion" class="errors"></span>
                      </div>
                    -->

                    <div class="form-group col-sm-12 col-md-6">
                      <label for="fecha_documento">Fecha de documento</label>
                      <input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="<?php echo date('Y-m-d'); ?>">
                      <span id="error_fecha_documento" class="errors"></span>
                    </div>

                  </div>
                  <!-- <div class="row">
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
                  </div> -->
                  <div class="row">
                    
                    <div class="form-group col-sm-12 col-md-6">
                      <label for="numero_documento">Número de documento</label>
                      <input type="hidden" id="numero_control_Venta" name="numero_control_venta" value="<?=$numero_control_venta; ?>">
                      <input type="hidden" id="numero_control_Desincorporacion" name="numero_control_desincorporacion" value="<?=$numero_control_desincorporacion; ?>">
                      <input type="hidden" id="numero_control_Reposicion" name="numero_control_reposicion" value="<?=$numero_control_reposicion; ?>">
                      <input type="number" class="form-control" id="numero_documento" name="numero_documento" step="1" placeholder="Ingresar número de documento" value="0" readonly>
                      <span id="error_numero_documento" class="errors"></span>
                    </div>
                        
                    <div class="form-group col-sm-12 col-md-6 box-leyendaVentas d-none">
                      <label for="leyenda">Concepto de Venta</label>
                      <select class="form-control transacciones select2" id="leyenda" name="leyenda"  style="width:100%">
                        <option value=""></option>
                        <?php if($_SESSION['nombre_rol']=="Administrativo"){ ?>
                          <option value="Credito Style">Credito Style</option>
                          <option value="Rifas o Premios">Rifas o Premios</option>
                          <option value="Consumo Interno">Consumo Interno</option>
                        <?php } else { ?>
                          <option value="Venta">Venta</option>
                          <option value="Promociones">Promociones</option>
                          <option value="Credito Style">Credito Style</option>
                          <option value="Rifas o Premios">Rifas o Premios</option>
                          <option value="Consumo Interno">Consumo Interno</option>
                          <option value="Obsequio a terceros">Obsequio a terceros</option>
                        <?php } ?>
                      </select>
                      <span id="error_leyenda" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 box-leyendaDes d-none">
                      <label for="leyendaDes">Leyenda de Desincorporación</label>
                      <input type="text" class="form-control" id="leyendaDes" name="leyendaDes">
                      <span id="error_leyendaDes" class="errors"></span>
                    </div>
                    


                    <!-- <div class="form-group col-sm-12 col-md-4 box-proveedores box-proveedoress">
                      <label for="proveedor">Seleccionar Proveedor / Cliente</label>
                      <select class="form-control select2 proveedores" id="proveedor" style="width:100%">
                        <option value=""></option>
                      </select>
                      <span id="error_proveedor" class="errors"></span>
                    </div> -->
                    <?php foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){ ?>
                      <div class="form-group col-sm-12 col-md-6 box-proveedores<?=$tp['id']; ?> box-proveedoress box-proveedoresx d-none">
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
                      <div class="form-group col-sm-12 col-md-6 box-proveedoresClientes box-proveedoress box-proveedoresx d-none">
                        <label for="proveedorClientes">Seleccionar Clientes</label>
                        <select class="form-control select2 proveedores" id="proveedorClientes" name="proveedorClientes"  style="width:100%;">
                          <option value=""></option>
                          <?php foreach($clientes as $client){ if(!empty($client['id_cliente'])){ ?>
                            <option value="<?php echo $client['id_cliente']; ?>"><?php echo $client['cod_rif'].$client['rif']." ".$client['primer_nombre']." ".$client['primer_apellido']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_proveedorClientes" class="errors"></span>
                      </div>
                      <div class="form-group col-sm-12 col-md-6 box-proveedoresClientesAutorizado box-proveedoress box-proveedoresx d-none">
                        <label for="proveedorClientesAutorizado">Seleccionar Clientes / Autorizados</label>
                        <select class="form-control select2 proveedores" id="proveedorClientesAutorizado" name="proveedorClientesAutorizado"  style="width:100%;">
                          <option value=""></option>
                          <!-- <option value="-1"> Juan Carlos Aguilar Cuellar</option> -->
                          <?php foreach($infoInternos as $intern){ if(!empty($intern['id_interno'])){ ?>
                            <option value="<?php echo $intern['id_interno']; ?>"><?php echo $intern['cod_rif'].$intern['rif']." ".$intern['primer_nombre']." ".$intern['primer_apellido']; ?></option>
                          <?php } } ?>
                          <?php foreach($clientes as $client){ if(!empty($client['id_cliente'])){ ?>
                            <option value="<?php echo $client['id_cliente']; ?>"><?php echo $client['cod_rif'].$client['rif']." ".$client['primer_nombre']." ".$client['primer_apellido']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_proveedorClientesAutorizado" class="errors"></span>
                      </div>
                    <?php } ?>
                    <?php if(!empty($empleados)){ ?>
                      <div class="form-group col-sm-12 col-md-6 box-proveedoresEmpleados box-proveedoress box-proveedoresx d-none">
                        <label for="proveedorEmpleados">Seleccionar Empleados</label>
                        <select class="form-control select2 proveedores" id="proveedorEmpleados" name="proveedorEmpleados"  style="width:100%;">
                          <option value=""></option>
                          <!-- <option value="-1">J408497786 STYLE COLLECTION</option> -->
                          <?php foreach($empleados as $emple){ if(!empty($emple['id_empleado'])){ ?>
                            <option value="<?php echo $emple['id_empleado']; ?>"><?php echo $emple['cod_rif'].$emple['rif']." ".$emple['primer_nombre']." ".$emple['primer_apellido']; ?></option>
                          <?php } } ?>
                        </select>
                        <span id="error_proveedorEmpleados" class="errors"></span>
                      </div>
                    <?php } ?>
                      <div class="form-group col-sm-12 col-md-6 box-proveedoresAutorizado box-proveedoress box-proveedoresx d-none">
                        <label for="proveedorAutorizado">Seleccionar Autorizados</label>
                        <select class="form-control select2 proveedores" id="proveedorAutorizado" name="proveedorAutorizado"  style="width:100%;">
                          <option value=""></option>
                          <?php foreach($infoInternos as $intern){ if(!empty($intern['id_interno'])){ ?>
                            <option value="<?php echo $intern['id_interno']; ?>"><?php echo $intern['cod_rif'].$intern['rif']." ".$intern['primer_nombre']." ".$intern['primer_apellido']; ?></option>
                          <?php } } ?>
                          <!-- <option class='opt-style' value="-1">J408497786 STYLE COLLECTION</option> -->
                        </select>
                        <span id="error_proveedorAutorizado" class="errors"></span>
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
                    <div style="width:15%;float:left" class=" box-inventarios1 box-inventario d-none">
                      <label>Cantidad</label>
                    </div>
                    <div style="width:65%;float:left" class=" box-inventarios1 box-inventario d-none">
                      <label>Descripcion</label>
                    </div>
                    <div style="width:20%;float:right;" class=" box-inventarios1 box-inventario d-none">
                      <label>Precio unitario de venta</label>
                    </div>
                  </div>
                  <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                    <div class="row" style="padding:0px 15px;">
                      <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario d-none">
                        <input type="number" class="form-control" id="stock<?=$z; ?>" min="0" name="stock[]" step="1" placeholder="Cantidad (150)">
                        <span id="error_stock<?=$z; ?>" class="errors"></span>
                      </div>
                      <?php foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){ $idAl = $almacen['id_almacen']; ?>
                        <div style="width:65%;float:left;" class=" box-inventarioProductos<?=$z; ?> box-inventariosProductos<?=$z.$idAl; ?> box-inventario d-none">
                          <select class="form-control select2 inventarios" id="inventarioProductos<?=$z.$idAl; ?>" name="inventarioProductos<?=$idAl;?>[]"  style="width:100%">
                            <option value=""></option>
                            <?php foreach($productos[$idAl] as $inv){ if(!empty($inv['id_producto'])){ ?>
                              <option value="<?php echo $inv['id_producto']; ?>"><?php echo $inv['codigo_producto']." ".$inv['producto']."(".$inv['cantidad'].") ".$inv['marca_producto']." - (".$inv['stock_operacion_almacen'].")"; ?></option>
                            <?php } } ?>
                          </select>
                          <span id="error_inventarioProductos<?=$z.$idAl; ?>" class="errors"></span>
                        </div>
      
                        <div style="width:65%;float:left;" class=" box-inventariosMercancia<?=$z.$idAl; ?> box-inventario d-none">
                          <select class="form-control select2 inventarios" id="inventarioMercancia<?=$z.$idAl; ?>" name="inventarioMercancia<?=$idAl;?>[]"  style="width:100%">
                            <option value=""></option>
                            <?php foreach($mercancia[$idAl] as $inv){ if(!empty($inv['id_mercancia'])){ ?>
                              <option value="<?php echo $inv['id_mercancia']; ?>"><?php echo $inv['codigo_mercancia']." ".$inv['mercancia']."(".$inv['medidas_mercancia'].") ".$inv['marca_mercancia']." - (".$inv['stock_operacion_almacen'].")"; ?></option>
                            <?php } } ?>
                          </select>
                          <span id="error_inventarioMercancia<?=$z.$idAl; ?>" class="errors"></span>
                        </div>
                      <?php } } ?>


                      <div style="width:20%;float:right;" class=" box-inventarios<?=$z; ?> box-inventario d-none">
                        <input type="number" class="form-control" id="total<?=$z; ?>" name="total[]" step="0.01" placeholder="Precio ($.150)">
                        <span id="error_total<?=$z; ?>" class="errors"></span>
                      </div>
                    </div>
                    <div style='width:100%;'>
                      <span style='float:left' id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success box-inventario d-none"><b>+</b></span>
                      <span style='float:right' id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger box-inventario d-none"><b>-</b></span>
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
<?php if(!empty($rutaPdfSalidas)): ?>
<input type="hidden" class="rutaSalida" value="<?php echo $rutaPdfSalidas; ?>">
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
        var rutaSalida = $(".rutaSalida").val();
        if(rutaSalida==undefined){
        }else{
          // alert(rutaSalida);
          window.open(`?${rutaSalida}`, '_blank');
        }
        window.location = "?route=Salidas&action=Ver";
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
  $(".box-leyendaVentas").hide();
  $(".box-leyendaVentas").removeClass("d-none");
  $(".box-leyendaDes").hide();
  $(".box-leyendaDes").removeClass("d-none");
  
  $("#tipoInv").on('change', function(){
    var tpInv = $(this).val();
    var transaccion = $('#transaccion').val();
    var tpInvs = "";
    $(".box-inventario").hide();
    $("#cantidad_elementos").val(0);
    $(".box-proveedoress").hide();
    if(transaccion=="Venta"){
      tpInvs = "Clientes";
      $(`.box-proveedores${tpInvs}`).show();
    }else{
      // tpInvs = tpInv;
    }
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
      alimentarFormInventario(tpInv);
      $("#addMenos"+cant).hide();
    }
    // $(".elementsInventario").html();
  });
  $("#transaccion").on('change', function(){
    var tpInv = $("#tipoInv").val();
    var transaccion = $('#transaccion').val();
    // if()
    if(transaccion!=""){
      var numControl = parseInt($("#numero_control_"+transaccion).val());
      $("#numero_documento").val(numControl);
    }else{
      $("#numero_documento").val(0);
    }

    var tpInvs = "";
    $(".box-inventario").hide();
    $("#cantidad_elementos").val(0);
    $(".box-proveedoress").slideUp();
    $(".box-leyendaVentas").slideUp();
    $(".box-leyendaDes").slideUp();
    // alert(transaccion.toLowerCase());
    if(transaccion.toLowerCase()=="venta"){
      $(".box-leyendaVentas").slideDown();
    }else if(transaccion.toLowerCase()=="desincorporacion"){
      $(".box-leyendaDes").slideDown();
    }else{
      // tpInvs = tpInv;
    }

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
      alimentarFormInventario(tpInv);
      $("#addMenos"+cant).hide();
    }
    // $(".elementsInventario").html();
  });
  $("#leyenda").on('change', function(){
    var tpInv = $("#tipoInv").val();
    var transaccion = $('#transaccion').val();
    var leyenda = $('#leyenda').val();

    var tpInvs = "";
    // $(".box-inventario").hide();
    // $("#cantidad_elementos").val(0);
    $(".box-proveedoress").hide();
    
    if(transaccion=="Venta"){
      if(leyenda=="Credito Style"){
        tpInvs = "Empleados";
      }else if(leyenda=="Obsequio a terceros" || leyenda=="Consumo Interno"){
        tpInvs = "Autorizado";
      } else if(leyenda=="Venta" || leyenda=="Promociones"){
        tpInvs = "Clientes";
      } else {
        tpInvs = "ClientesAutorizado";
      }
      $(`.box-proveedores${tpInvs}`).show();
    }else{
      // tpInvs = tpInv;
    }
    
    // $(".elementsInventario").html();
  });
  $("#almacen").on('change', function(){
    var tpInv = $("#tipoInv").val();
    var transaccion = $('#transaccion').val();
    var leyenda = $('#leyenda').val();
    var tpInvs = "";
    $(".box-inventario").hide();
    $("#cantidad_elementos").val(0);
    $(".box-proveedoress").hide();
    if(transaccion=="Venta"){
      if(leyenda=="Credito Style"){
        tpInvs = "Empleados";
      }else if(leyenda=="Obsequio a terceros" || leyenda=="Consumo Interno"){
        tpInvs = "Autorizado";
      } else if(leyenda=="Venta" || leyenda=="Promociones"){
        tpInvs = "Clientes";
      } else {
        tpInvs = "ClientesAutorizado";
      }
      $(`.box-proveedores${tpInvs}`).show();
    }else{
      // tpInvs = tpInv;
    }
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
      alimentarFormInventario(tpInv);
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
    alimentarFormInventario(tpInv);
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
    retroalimentarFormInventario(tpInv);
  });

  function alimentarFormInventario(inv){
    var limite = parseInt($("#limiteElementos").val());
    var idAl = $("#almacen").val();
    var cant = parseInt($("#cantidad_elementos").val());
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant++;
    if(inv!="" && idAl!=""){
      $("#addMore"+cant).show();
      $("#addMenos"+cant).show();
      $(`.box-inventarios${cant}`).show();
      $(`.box-inventarios${inv}${cant}${idAl}`).show();
      // alert(cant);
      // alert(limite);
      if(cant == limite){
        $("#addMore"+cant).hide();
      }
      $("#cantidad_elementos").val(cant);
    }
  }
  function retroalimentarFormInventario(inv){
    var cant = parseInt($("#cantidad_elementos").val());
    var idAl = $("#almacen").val();
    if(inv!="" && idAl!=""){
      $("#addMore"+cant).hide();
      $("#addMenos"+cant).hide();
      $(`.box-inventarios${cant}`).hide();
      $(`.box-inventarios${inv}${cant}${idAl}`).hide();
      cant--;
      $("#addMore"+cant).show();
      $("#addMenos"+cant).show();
      if(cant<2){
        $("#addMenos"+cant).hide();
      }
      $("#cantidad_elementos").val(cant);
    }
  }

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
  var rnumero_documento = false;
  if(transaccion=="Venta"){
    var numero_documento = $("#numero_documento").val();
    rnumero_documento = checkInput(numero_documento, numberPattern);
    if( rnumero_documento == false ){
      if(numero_documento.length != 0){
        $("#error_numero_documento").html("El numero de documento no debe contener letras o caracteres especiales");
      }else{
        $("#error_numero_documento").html("Debe llenar el campo de numero de documento");      
      }
    }else{
      $("#error_numero_documento").html("");
    }
  }else{
    rnumero_documento = true;
    $("#error_numero_documento").html("");
  }
  /*===================================================================*/
  



  // /*===================================================================*/
  var fecha_doc = $("#fecha_documento").val();
  var rfecha_doc = false;
  if(fecha_doc==""){
    rfecha_doc=false;
    $("#error_fecha_documento").html("Debe seleccionar la fecha de documento");
  }else{
    rfecha_doc=true;
    $("#error_fecha_documento").html("");
  }
  // /*===================================================================*/


  if(transaccion=="Venta"){
    var rleyenda = false;
    var leyenda = $("#leyenda").val();
    if(leyenda==""){
      rleyenda=false;
      $("#error_leyenda").html("Debe seleccionar un concepto de venta");
    }else{
      rleyenda=true;
      $("#error_leyenda").html("");
    }
  }else{
    var rleyenda = true;
  }
  // /*===================================================================*/
  
  /*===================================================================*/
  // var rnumero_lote=false;
  // if(transaccion=="Venta"){
  //   $("#error_numero_lote").html("");
  //   rnumero_lote=true;
  // }else{
  //   alert(transaccion);
  //   var numero_lote = $("#numero_lote").val();
  //   rnumero_lote = checkInput(numero_lote, numberPattern);
  //   if( rnumero_lote == false ){
  //     if(numero_lote.length != 0){
  //       $("#error_numero_lote").html("El numero de lote no debe contener letras o caracteres especiales");
  //     }else{
  //       $("#error_numero_lote").html("Debe llenar el campo de numero de lote");      
  //     }
  //   }else{
  //     $("#error_numero_lote").html("");
  //   }
  // }
  /*===================================================================*/

  /*===================================================================*/
  var tpInvs = "";
  var provecliente = "";
  var rproveedor = false;
  if(transaccion=="Venta"){
    var proveedor = "";
    // if(leyenda=="Credito Style"){
    //   tpInvs = "Empleados";
    //   provecliente = "empleado";
    // }else{
    //   tpInvs = "Clientes";
    //   provecliente = "cliente";
    // }
    if(leyenda=="Credito Style"){
      tpInvs = "Empleados";
      provecliente = "empleado";
    }else if(leyenda=="Obsequio a terceros" || leyenda=="Consumo Interno"){
      tpInvs = "Autorizado";
      provecliente = "Personal autorizado";
    } else if(leyenda=="Venta" || leyenda=="Promociones"){
      tpInvs = "Clientes";
      provecliente = "cliente";
    } else {
      tpInvs = "ClientesAutorizado";
      provecliente = "cliente";
    }
    // provecliente = "cliente";
    proveedor = $("#proveedor"+tpInvs).val();
    rproveedor = false;
    if(proveedor==""){
      rproveedor=false;
      $("#error_proveedor"+tpInvs).html("Debe seleccionar un "+provecliente+"");
    }else{
      rproveedor=true;
      $("#error_proveedor"+tpInvs).html("");
    }
  }else{
    rproveedor = true;
    // tpInvs = tipoInv;
    // provecliente = "proveedor";
  }
  /*===================================================================*/
  // alert('asdasd');
 
  
  

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
            $("#error_stock"+i).html("La cantidad no debe contener letras o caracteres especiales");
          }else{
            $("#error_stock"+i).html("Debe llenar la cantidad");      
          }
        }else{
          $("#error_stock"+i).html("");
        }
        if(rstock==false){ erroresStock++; }
      /*===================================================================*/
      
      /*===================================================================*/
        var inventario = $("#inventario"+tipoInv+i+almacen).val();
        var rinventario = false;
        if(inventario==""){
          rinventario=false;
          $("#error_inventario"+tipoInv+i+almacen).html("Debe seleccionar el elemento del inventario");
        }else{
          rinventario=true;
          $("#error_inventario"+tipoInv+i+almacen).html("");
        }
        if(rinventario==false){ erroresInventario++; }
      /*===================================================================*/
    
      /*===================================================================*/
        if(transaccion=="Venta"){
          var total = $("#total"+i).val();
          var rtotal = checkInput(total, numberPattern);
          if( rtotal == false ){
            if(total.length != 0){
              $("#error_total"+i).html("El monto total debe ser un valor numerico");
            }else{
              $("#error_total"+i).html("Debe colocar el monto total");      
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
    // if( rfecha_doc==true && rnumero_documento==true && rnumero_lote==true && rfecha_vencimiento==true && rtipoInv==true && rproveedor==true && ralmacen==true && rtransaccion==true && rstocks==true && rinventarios==true && rtotales==true){
    if( rfecha_doc==true && rnumero_documento==true && rtipoInv==true && rproveedor==true && ralmacen==true && rtransaccion==true && rstocks==true && rinventarios==true && rtotales==true){
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
