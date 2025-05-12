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
        <small><?php if(!empty($action)){echo $nameaccion;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?=$url; ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $nameaccion;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?=$url; ?>&action=VerCompras" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <input type="hidden" id="route" value="<?=$_GET['route']; ?>">
        <input type="hidden" id="action" value="<?=$_GET['action']; ?>">

        <!-- left column -->
        <div class="col-sm-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $modulo; ?> - Compras</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="periodoAnio">Periodo (Año)</label>
                      <select class="form-control select2" id="periodoAnio" name="periodoAnio">
                        <!-- <option value=""></option> -->
                        <?php
                        for($x = date('Y'); $x >= 2022; $x--){
                          ?>
                          <option value="<?=$x; ?>" <?php if($x==$compra['periodoAnio']){ echo "selected"; } ?> ><?=$x; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <span id="error_periodoAnio" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="periodoMes">Periodo (Mes)</label>
                      <select class="form-control select2" id="periodoMes" name="periodoMes">
                        <option value=""></option>
                        <?php
                          foreach ($meses as $key => $val) {
                          ?>
                          <option value="<?=$key; ?>" <?php if($key==$compra['periodoMes']){ echo "selected"; } ?> ><?=$val; ?></option>
                          <?php
                          }
                        ?>
                      </select>
                      <span id="error_periodoMes" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="fechaFactura">Fecha Factura /NC/ND/</label>
                       <input type="date" class="form-control" id="fechaFactura" value="<?=$compra['fechaFactura']; ?>" name="fechaFactura" placeholder="2024-01-01">
                       <span id="error_fechaFactura" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="idProveedor">Proveedores</label>
                      <select class="form-control select2" id="idProveedor" name="idProveedor" style="width:100%;">
                        <option value="0"></option>
                        <?php foreach ($proveedores as $prov){ if(!empty($prov['id_proveedor_compras'])){ ?>
                          <option <?php if($compra['id_proveedor_compras']==$prov['id_proveedor_compras']){ echo "selected"; } ?> value="<?=$prov['id_proveedor_compras']; ?>"><?=$prov['codRif']."-".$prov['rif']." ".$prov['nombreProveedor']; ?></option>
                        <?php } }?>
                      </select>
                      <span id="error_idProveedor" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="numeroFactura">Numero de Factura</label>
                       <input type="text" class="form-control" id="numeroFactura" value="<?=$compra['numeroFactura']; ?>" name="numeroFactura" placeholder="ABC1234567">
                       <input type="hidden" id="numeroFacturaH" value="<?=$compra['numeroFactura']; ?>" name="numeroFacturaH" placeholder="ABC1234567">
                       <span id="error_numeroFactura" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="numeroControl">Numero de Control</label>
                       <input type="text" class="form-control" id="numeroControl" value="<?=$compra['numeroControl']; ?>" name="numeroControl" placeholder="ABC1234567">
                       <span id="error_numeroControl" class="errors"></span>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="totalCompra">Total Compras de Bienes Incluyendo IVA</label>
                       <input type="number" class="form-control" id="totalCompra" value="<?=$compra['totalCompra']; ?>" step="0.01" name="totalCompra" placeholder="0,00">
                       <span id="error_totalCompra" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="comprasExentas">Compras Exentas Exoneradas</label>
                       <input type="number" class="form-control" id="comprasExentas" value="<?=$compra['comprasExentas']; ?>" step="0.01" name="comprasExentas" placeholder="0,00">
                       <span id="error_comprasExentas" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-5">
                       <label for="comprasInternasGravadas">Compras Internas Gravadas</label>
                       <input type="number" class="form-control" id="comprasInternasGravadas" value="<?=$compra['comprasInternasGravadas']; ?>"  name="comprasInternasGravadas" value="0" placeholder="0,00" readonly>
                       <span id="error_comprasInternasGravadas" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-2">
                       <label for="iva">% Alicuota</label>
                       <input type="text" class="form-control" id="iva" value="<?=$cantidadIVA; ?>%" name="iva" readonly>
                       <input type="hidden" id="ivaH" value="<?=$cantidadIVA; ?>" name="ivaH">
                       <span id="error_iva" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-5">
                       <label for="ivaGeneral">Iva Alicuota General</label>
                       <input type="number" class="form-control" id="ivaGeneral" value="<?=$compra['ivaGeneral']; ?>" name="ivaGeneral" value="0" placeholder="0,00" readonly>
                       <span id="error_ivaGeneral" class="errors"></span>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                      <label for="opRetencion">Existe Retención de IVA</label>
                      <select class="form-control select2" id="opRetencion" name="opRetencion" style="width:100%;">
                        <option value="0" <?php if(!empty($compra['opRetencion'])){ if($compra['opRetencion']=="0"){ echo "selected"; } } ?> >No</option>
                        <option value="1" <?php if(!empty($compra['opRetencion'])){ if($compra['opRetencion']=="1"){ echo "selected"; } } ?> >Si</option>
                      </select>
                      <span id="error_tipo" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-md-6 boxNoRet <?php if($compra['opRetencion']=="0"){ echo "d-none"; } ?>">
                      <label for="porcentajeRetencion">Selecciona el % de Retencion de IVA</label>
                      <select class="form-control select2" id="porcentajeRetencion" name="porcentajeRetencion" style="width:100%;">
                        <option <?php if(!empty($compra['porcentajeRetencion'])){ if($compra['porcentajeRetencion']=="75"){ echo "selected"; } } ?> value="75" >75%</option>
                        <option <?php if(!empty($compra['porcentajeRetencion'])){ if($compra['porcentajeRetencion']=="100"){ echo "selected"; } } ?> value="100" >100%</option>
                      </select>
                      <span id="error_porcentajeRetencion" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 boxNoRet <?php if($compra['opRetencion']=="0"){ echo "d-none"; } ?>">
                       <label for="retencionIva">Retención IVA ALicuota General</label>
                       <input type="number" class="form-control" value="<?=$compra['retencionIva']; ?>" id="retencionIva" name="retencionIva" placeholder="0,00" readonly>
                       <span id="error_retencionIva" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 boxNoRet <?php if($compra['opRetencion']=="0"){ echo "d-none"; } ?>">
                       <label for="comprobante">Comprobante de Retención de IVA</label>
                       <input type="text" class="form-control" value="<?=$compra['comprobante']; ?>" id="comprobante" maxlength="15" name="comprobante" placeholder="ABC1234567">
                       <span id="error_comprobante" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4 boxNoRet <?php if($compra['opRetencion']=="0"){ echo "d-none"; } ?>">
                       <label for="fechaComprobante">Fecha del Comprobante de Retención</label>
                       <input type="date" class="form-control" value="<?=$compra['fechaComprobante']; ?>" id="fechaComprobante" name="fechaComprobante" placeholder="Ingresar nombre de liderazgo">
                       <span id="error_fechaComprobante" class="errors"></span>
                    </div>
                  </div>

                  <hr>

              </div>
              <div class="box-footer">
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>  
              <hr>
              
            </form>

          </div>
          <span class="rangos d-none"><?=json_encode($range); ?></span>

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
<input type="hidden" class="responses" value="<?=$response; ?>">
<?php endif; ?>
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
        var route = '<?=$_GET['route']; ?>';
        var action = '<?=$_GET['action']; ?>';
        window.location = "?route="+route+"&action=VerCompras";
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
  var anio = $("#periodoAnio").val();
  var mes = $("#periodoMes").val();
  if(mes==""){
    $("#fechaFactura").removeAttr("max");
  } else {
    var rangoss = $(".rangos").html();
    var rangos = JSON.parse(rangoss);
    var limite = anio+"-"+mes+"-"+rangos[mes];
    $("#fechaFactura").attr("max",limite);
  }
  $("#periodoMes").change(function(){
    var anio = $("#periodoAnio").val();
    var mes = $("#periodoMes").val();
    if(mes==""){
      $("#fechaFactura").removeAttr("max");
    } else {
      var rangoss = $(".rangos").html();
      var rangos = JSON.parse(rangoss);
      var limite = anio+"-"+mes+"-"+rangos[mes];
      $("#fechaFactura").attr("max",limite);
    }
  });

  $("#periodoAnio").change(function(){
    var anio = $("#periodoAnio").val();
    var mes = $("#periodoMes").val();
    if(mes==""){
      $("#fechaFactura").removeAttr("max");
    } else {
      var rangoss = $(".rangos").html();
      var rangos = JSON.parse(rangoss);
      var limite = anio+"-"+mes+"-"+rangos[mes];
      $("#fechaFactura").attr("max",limite);
    }
  });

  $("#totalCompra").focusout(function(){
    var totalCompra = parseFloat($("#totalCompra").val());
    var comprasExentas = parseFloat($("#comprasExentas").val());
    var comprasInternasGravadas = 0;
    var ivaGeneral = 0;
    if($("#totalCompra").val()!="" && $("#comprasExentas").val()!=""){
      if((totalCompra>0)){
        if( comprasExentas > totalCompra ){
          $("#comprasExentas").val(totalCompra-1);
          totalCompra = parseFloat($("#totalCompra").val());
          comprasExentas = parseFloat($("#comprasExentas").val());
        }
      }
      var iva = parseInt($("#iva").val());
      if( (totalCompra>0) && (comprasExentas==0) ){
        comprasInternasGravadas = totalCompra / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      } else if( (totalCompra>0) && (comprasExentas>0) ){
        comprasInternasGravadas = (totalCompra-comprasExentas) / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      }
    }
    $("#comprasInternasGravadas").val(parseFloat(comprasInternasGravadas.toFixed(2)));
    $("#ivaGeneral").val(parseFloat(ivaGeneral.toFixed(2)));

    var porcentajeRetencion=$("#porcentajeRetencion").val();
    var retencionIva = 0;
    if(ivaGeneral>0){
      retencionIva = (ivaGeneral/100*porcentajeRetencion);
    }
    $("#retencionIva").val(parseFloat(retencionIva.toFixed(2)));
  });

  $("#comprasExentas").focusout(function(){
    var totalCompra = parseFloat($("#totalCompra").val());
    var comprasExentas = parseFloat($("#comprasExentas").val());
    var comprasInternasGravadas = 0;
    var ivaGeneral = 0;
    if($("#totalCompra").val()!="" && $("#comprasExentas").val()!=""){
      if((totalCompra>0)){
        if( comprasExentas > totalCompra ){
          $("#comprasExentas").val(totalCompra-1);
          totalCompra = parseFloat($("#totalCompra").val());
          comprasExentas = parseFloat($("#comprasExentas").val());
        }
      }
      var iva = parseInt($("#iva").val());
      if( (totalCompra>0) && (comprasExentas==0) ){
        comprasInternasGravadas = totalCompra / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      } else if( (totalCompra>0) && (comprasExentas>0) ){
        comprasInternasGravadas = (totalCompra-comprasExentas) / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      }
    }
    $("#comprasInternasGravadas").val(parseFloat(comprasInternasGravadas.toFixed(2)));
    $("#ivaGeneral").val(parseFloat(ivaGeneral.toFixed(2)));

    var porcentajeRetencion=$("#porcentajeRetencion").val();
    var retencionIva = 0;
    if(ivaGeneral>0){
      retencionIva = (ivaGeneral/100*porcentajeRetencion);
    }
    $("#retencionIva").val(parseFloat(retencionIva.toFixed(2)));
    
  });

  $("#porcentajeRetencion").change(function(){
    var totalCompra = parseFloat($("#totalCompra").val());
    var comprasExentas = parseFloat($("#comprasExentas").val());
    var comprasInternasGravadas = 0;
    var ivaGeneral = 0;
    if($("#totalCompra").val()!="" && $("#comprasExentas").val()!=""){
      if((totalCompra>0)){
        if( comprasExentas > totalCompra ){
          $("#comprasExentas").val(totalCompra);
          totalCompra = parseFloat($("#totalCompra").val());
          comprasExentas = parseFloat($("#comprasExentas").val());
        }
      }
      var iva = parseInt($("#iva").val());
      if( (totalCompra>0) && (comprasExentas==0) ){
        comprasInternasGravadas = totalCompra / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      } else if( (totalCompra>0) && (comprasExentas>0) ){
        comprasInternasGravadas = (totalCompra-comprasExentas) / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      }
    }
    $("#comprasInternasGravadas").val(parseFloat(comprasInternasGravadas.toFixed(2)));
    $("#ivaGeneral").val(parseFloat(ivaGeneral.toFixed(2)));

    var porcentajeRetencion=$("#porcentajeRetencion").val();
    var retencionIva = 0;
    if(ivaGeneral>0){
      retencionIva = (ivaGeneral/100*porcentajeRetencion);
    }
    $("#retencionIva").val(parseFloat(retencionIva.toFixed(2)));
    
  });


  var opRetencion = $("#opRetencion").val();
  if(opRetencion==0){
    $(".boxNoRet").hide();
    $(".boxNoRet").removeClass("d-none");
  }

  $("#opRetencion").change(function(){
    var val = $(this).val();
    if(val==0){
      $(".boxNoRet").slideUp();
    }
    if(val==1){
      $(".boxNoRet").slideDown();
    }

    var totalCompra = parseFloat($("#totalCompra").val());
    var comprasExentas = parseFloat($("#comprasExentas").val());
    var comprasInternasGravadas = 0;
    var ivaGeneral = 0;
    if($("#totalCompra").val()!="" && $("#comprasExentas").val()!=""){
      if((totalCompra>0)){
        if( comprasExentas > totalCompra ){
          $("#comprasExentas").val(totalCompra-1);
          totalCompra = parseFloat($("#totalCompra").val());
          comprasExentas = parseFloat($("#comprasExentas").val());
        }
      }
      var iva = parseInt($("#iva").val());
      if( (totalCompra>0) && (comprasExentas==0) ){
        comprasInternasGravadas = totalCompra / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      } else if( (totalCompra>0) && (comprasExentas>0) ){
        comprasInternasGravadas = (totalCompra-comprasExentas) / ((iva/100)+1);
        ivaGeneral=comprasInternasGravadas*(iva/100);
      }
    }
    $("#comprasInternasGravadas").val(parseFloat(comprasInternasGravadas.toFixed(2)));
    $("#ivaGeneral").val(parseFloat(ivaGeneral.toFixed(2)));

    var porcentajeRetencion=$("#porcentajeRetencion").val();
    var retencionIva = 0;
    if(ivaGeneral>0){
      retencionIva = (ivaGeneral/100*porcentajeRetencion);
    }
    $("#retencionIva").val(parseFloat(retencionIva.toFixed(2)));
  });

  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");
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
          $.ajax({
            url: '',
            type: 'POST',
            data: {
              validarData: true,
              idProveedor: $("#idProveedor").val(),
              numeroFactura: $("#numeroFacturaH").val(),
              numeroControl: $("#numeroControl").val(),
              totalCompra: $("#totalCompra").val(),
            },
            success: function(respuesta){
              // alert(respuesta);
              if (respuesta == "1"){
                $(".btn-enviar").removeAttr("disabled");
                $(".btn-enviar").click();
              }
              if (respuesta == "9"){
                swal.fire({
                  type: 'error',
                  title: '¡Los datos ingresados estan repetidos!',
                  confirmButtonColor: "#ED2A77",
                });
              }
              if (respuesta == "5"){ 
                swal.fire({
                  type: 'error',
                  title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                  confirmButtonColor: "#ED2A77",
                });
              }
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
    }
  });




});


function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/

  // X fechaFactura
  // X idProveedor
  // X numeroFactura
  // X numeroControl
  // X totalCompra
  // X comprasExentas
  // - comprasInternasGravadas
  // - ivaH
  // - iva
  // - ivaGeneral
  // - opRetencion
  // - porcentajeRetencion
  // - retencionIva
  // X comprobante
  // X fechaComprobante

  var periodoMes = $("#periodoMes").val();
  var rperiodoMes = false;
  // alert(periodoMes);
  if(periodoMes>0){ 
    $("#error_periodoMes").html("");
    rperiodoMes = true;
  }else{
    rperiodoMes = false;
    $("#error_periodoMes").html("Debe seleccionar al Mes del periodo");
  }


  var fechaFactura = $("#fechaFactura").val();
  var rfechaFactura = false;
  if(fechaFactura==""){
    rfechaFactura = false;
    $("#error_fechaFactura").html("Seleccione la Fecha de Factura");
  }else{
    $("#error_fechaFactura").html("");
    rfechaFactura = true;
  }

  var idProveedor = $("#idProveedor").val();
  var ridProveedor = false;
  // alert(idProveedor);
  if(idProveedor>0){ 
    $("#error_idProveedor").html("");
    ridProveedor = true;
  }else{
    ridProveedor = false;
    $("#error_idProveedor").html("Debe seleccionar al proveedor");
  }

  var numeroControl = $("#numeroControl").val();
  var rnumeroControl = checkInput(numeroControl, alfanumericPattern2);
  if(rnumeroControl == false){ 
    if( numeroControl.length > 3 ){
        $("#error_numeroControl").html("EL numero de control no debe tener caracteres especiales");      
    }else{
        $("#error_numeroControl").html("Debe llenar el numero de control");
    }
  }else{
      $("#error_numeroControl").html("");
  }

  var numeroFactura = $("#numeroFactura").val();
  var rnumeroFactura = checkInput(numeroFactura, alfanumericPattern2);
  if(rnumeroFactura == false){ 
    if( numeroFactura.length > 3 ){
        $("#error_numeroFactura").html("EL numero de factura no debe tener caracteres especiales");      
    }else{
        $("#error_numeroFactura").html("Debe llenar el numero de factura");
    }
  }else{
      $("#error_numeroFactura").html("");
  }

  var totalCompra = $("#totalCompra").val();
  var rtotalCompra = checkInput(totalCompra, numberPattern2);
  if(rtotalCompra == false){ 
    if( totalCompra.length > 0 ){
        $("#error_totalCompra").html("EL precio total de compra no debe tener ni letras ni caracteres especiales");      
    }else{
        $("#error_totalCompra").html("Debe llenar el precio total de compra");
    }
  }else{
      $("#error_totalCompra").html("");
  }

  var comprasExentas = $("#comprasExentas").val();
  var rcomprasExentas = checkInput(comprasExentas, numberPattern2);
  if(rcomprasExentas == false){ 
    if( comprasExentas.length > 0 ){
        $("#error_comprasExentas").html("EL precio de compras exentas exoneradas no debe tener ni letras ni caracteres especiales");      
    }else{
        $("#error_comprasExentas").html("Debe llenar el precio compras exentas exoneradas");
    }
  }else{
      $("#error_comprasExentas").html("");
  }

  var opRetencion = $("#opRetencion").val();
  var estadoRetencion = true;
  if(opRetencion==1){
    estadoRetencion = false;
    var comprobante = $("#comprobante").val();
    var rcomprobante = checkInput(comprobante, alfanumericPattern2);
    if(rcomprobante == false){ 
      if( comprobante.length > 3 ){
          $("#error_comprobante").html("EL comprobante de retención de IVA no debe tener caracteres especiales");      
      }else{
          $("#error_comprobante").html("Debe llenar el comprobante de retención de IVA");
      }
    }else{
        $("#error_comprobante").html("");
    }

    var fechaComprobante = $("#fechaComprobante").val();
    var rfechaComprobante = false;
    if(fechaComprobante==""){
      rfechaComprobante = false;
      $("#error_fechaComprobante").html("Seleccione la Fecha del comprobante");
    }else{
      $("#error_fechaComprobante").html("");
      rfechaComprobante = true;
    }

    if(rcomprobante==true && rfechaComprobante==true){
      estadoRetencion = true;
    }else{
      estadoRetencion=false;
    }
  }

  /*===================================================================*/


  
  /*===================================================================*/
  var result = false;
  if( rperiodoMes==true && rfechaFactura==true && ridProveedor==true && rnumeroFactura==true && rnumeroControl==true && rtotalCompra==true && rcomprasExentas==true && estadoRetencion==true ){
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
