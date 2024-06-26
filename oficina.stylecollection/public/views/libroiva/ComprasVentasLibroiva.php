<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $nameaccion; } ?> <?php if(!empty($url)){echo $url;} ?></title>
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
        <li class="active"><?php if(!empty($action)){echo $nameaccion;} echo " de ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div> -->
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
              <h3 class="box-title"><?php echo $modulo; ?> - <?=$nameaccion; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                    
                <form action="" method="get" class="form_register_get">
                  <div class="row">
                    <div class="form-group col-xs-12 col-md-4">
                      <label for="tipo">Selecciona el tipo de fecha</label>
                      <select class="form-control select2" id="tipo" name="tipo" style="width:100%;">
                        <option value=""></option>
                        <option value="2" <?php if(!empty($_GET['tipo'])){ if($_GET['tipo']=="2"){ echo "selected"; } } ?> >Por Mes</option>
                        <option value="1" <?php if(!empty($_GET['tipo'])){ if($_GET['tipo']=="1"){ echo "selected"; } } ?> >Por Año</option>
                      </select>
                      <!-- <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ingresar nombre de liderazgo"> -->
                      <span id="error_tipo" class="errors"></span>
                    </div>

                    <div id="boxAnio" class="form-group col-xs-12 col-md-4 boxss 
                      <?php 
                        if( !(!empty($_GET['tipo']) && ($_GET['tipo']=="1" || $_GET['tipo']=="2")) ){ 
                          echo "d-none"; 
                        } 
                      ?>
                    ">
                      <label for="anio">Selecciona el Año</label>
                      <select class="form-control select2" id="anio" name="anio" style="width:100%;">
                        <!-- <option value=""></option> -->
                        <?php
                        for($x = date('Y'); $x >= 2022; $x--){
                          ?>
                          <option value="<?=$x; ?>" <?php if(!empty($_GET['anio'])){ if($_GET['anio']==$x){ echo "selected"; } } ?> ><?=$x; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <span id="error_anio" class="errors"></span>
                    </div>

                    <div id="boxMes" class="form-group col-xs-12 col-md-4 boxss
                      <?php 
                        if( !(!empty($_GET['tipo']) && $_GET['tipo']=="2") ){ 
                          echo "d-none"; 
                        } 
                      ?>
                    ">
                      <label for="mes">Selecciona el Mes</label>
                      <select class="form-control select2" id="mes" name="mes" style="width:100%;">
                        <option value=""></option>
                        <?php
                        foreach ($meses as $index => $values) {
                          ?>
                          <option value="<?=$index; ?>" <?php if(!empty($_GET['mes'])){ if($_GET['mes']==$index){ echo "selected"; } } ?> ><?=$values; ?></option>
                          <?php
                        }
                        
                        ?>
                      </select>
                      <span id="error_mes" class="errors"></span>
                    </div>
                  </div>
                </form>

              </div>
              <div class="box-footer">
                <span type="submit" class="btn btn-default cargar enviar2 color-button-sweetalert" >Cargar</span>
                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>  
              <hr>
              

              <!-- <ul class="nav nav-tabs nav-justified">
                <li class="active"><a id="1">Libro de Ventas</a></li>
                <li><a id="2">Libro de Compras</a></li>
                <li><a id="3">Libro Resumen</a></li>
              </ul> -->
              
              <?php if($operacionMostrarInformacion){ ?>
                <div class="box-body">
                  <?php if(!empty($_GET['mes'])){ ?>
                  <div class="row">
                    <div class="col-xs-12">
                      <?php
                        $actualAnio = $_GET['anio'];
                        $actualMes = $_GET['mes'];

                        if($actualMes=="01"){
                          $anteriorMes="12";
                          $anteriorAnio=$actualAnio-1;
                        }else{
                          $anteriorAnio=$actualAnio;
                          if(strlen($actualMes-1)==1){
                            $anteriorMes="0";
                            $anteriorMes.=($actualMes-1);
                          }else{
                            $anteriorMes=$actualMes-1;
                          }
                        }
                        // echo "Año Actual: ".$actualAnio." | Mes Actual: ".$actualMes." <br>";
                        // echo "Año anterior: ".$anteriorAnio." | Mes anterior: ".$anteriorMes." <br>";
                      ?>
                      <style type="text/css">.expand:hover{ cursor:pointer; }</style>
                      <div class="btnExpandFiscal expand" style="border-bottom:1px solid #ccc;">
                        <span class="" style="font-size:1.2em;">
                          <span>&nbsp Credito Fiscal del mes anterior, <?=$meses[$anteriorMes]." de ".$anteriorAnio; ?></span>
                          <span>&nbsp&nbsp|</span>
                          <span>&nbsp&nbsp Crédito Fiscal: &nbsp&nbsp<b><?=number_format($excedenteCreditosFiscalesPendienteAnterior,2,',','.'); ?></b></span>
                          <span>&nbsp&nbsp|</span>
                          <span>&nbsp&nbsp Débito Fiscal: &nbsp&nbsp<b><?=number_format($debitosFiscalesPendienteAnterior,2,',','.'); ?></b></span>
                        </span>
                        <span class="pull-right-container">
                          <i class="etiq fa fa-sort-down pull-right" style="font-size:1.5em;"></i>
                        </span>
                      </div>

                      <div class="boxContentFiscal d-none" style="background:#f9f9f9;padding:2px 10px;">
                        <br>
                        <input type="hidden" id="nameCreditoANT" value="creditoFiscalANT">
                        <input type="hidden" id="nameDebitoANT" value="debitoFiscalANT">
                        <input type="hidden" id="anioValueANT" value="<?=$anteriorAnio; ?>">
                        <input type="hidden" id="mesValueANT" value="<?=$anteriorMes; ?>">
                        <div class="row">
                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="creditoFiscalANT">Crédito Fiscal</label>
                            <input type="number" class="form-control" id="creditoFiscalANT" value="<?=$excedenteCreditosFiscalesPendienteAnterior; ?>" name="creditoFiscalANT" placeholder="0,00">
                            <span id="error_creditoFiscalANT" class="errors"></span>
                          </div>
                          <div class="form-group col-xs-12 col-sm-6">
                            <label for="debitoFiscalANT">Débito Fiscal</label>
                            <input type="number" class="form-control" id="debitoFiscalANT" value="<?=$debitosFiscalesPendienteAnterior; ?>" name="debitoFiscalANT" placeholder="0,00">
                            <span id="error_debitoFiscalANT" class="errors"></span>
                          </div>
                        </div>
                        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Contable"){ ?>
                        <div class="row">
                          <div class="col-xs-12">
                            <button id="ANT" class="btn btn-default ActualizarValoresFiscales enviar2 color-button-sweetalert" >Enviar</button>
                          </div>
                        </div>
                        <?php } ?>

                        <br>
                      </div>

                    </div>
                  </div>
                  <?php } ?>

                  <div class="row">
                    <hr>
                    <div class="col-xs-12">
                      <div style="float:right;margin-right:2%;">
                        <?php 
                          $rutaExcelUrl = "";
                          if(!empty($_GET['mes'])){
                            $rutaExcelUrl="?route={$_GET['route']}&action=Generar{$_GET['action']}&tipo={$_GET['tipo']}&anio={$_GET['anio']}&mes={$_GET['mes']}";
                          } else {
                            $rutaExcelUrl="?route={$_GET['route']}&action=Generar{$_GET['action']}&tipo={$_GET['tipo']}&anio={$_GET['anio']}";
                          } 
                        ?>
                        <a href="<?=$rutaExcelUrl; ?>" target="_blank" class="btn btn-success">Generar Reporte de Libro IVA</a>
                      </div>
                    </div>
                  </div>

                  <hr>
                  <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a data-toggle="tab" href="#ventas"><b>Libro de Ventas</b></a></li>
                    <li><a data-toggle="tab" href="#compras"><b>Libro de Compras</b></a></li>
                    <li><a data-toggle="tab" href="#resumen"><b>Libro Resumen</b></a></li>
                  </ul>
                  <div class="tab-content">
                    
                    <div id="ventas" class="tab-pane fade in active">
                      <br>
                      <br>
                      <style type="text/css">
                        .textR{ text-align:right; }
                        .bd-black{ border:1px solid #000 !important; }
                        .bdt-black{ border-top:1px solid #000 !important; }
                        .bdb-black{ border-bottom:1px solid #000 !important; }
                        .bdl-black{ border-left:1px solid #000 !important; }
                        .bdr-black{ border-right:1px solid #000 !important; }
                        .table-simple td{ padding:1px 3px; }
                        .tab-content span{color:#000 !important;font-size:1.1em;}
                      </style>
                      <!-- TABLA PRINCIPAL DE REGISTROS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <label style="font-size:1.3em;">
                            <span>INVERSIONES STYLE COLLECTION, C.A.</span>
                            <br>
                            <span>RIF: J-408497786</span>
                            <br>
                            <span><u>LIBRO DE VENTAS DEL </u></span>
                            <span>
                              &nbsp
                              <u>
                                <?php
                                  echo " ".str_replace("-","/",$lider->formatFecha($inicioFecha)).
                                  " HASTA EL  ".
                                  str_replace("-","/",$lider->formatFecha($finFecha)); 
                                ?>
                                
                              </u>
                            </span>
                          </label>
                        </div>
                        <br>
                        <div class="col-xs-12">
                          <div class="table-responsive" style="max-height:80vh;overflow:auto;">
                            <table class="table">
                              <tr style="font-size:1.05em;">
                                <td colspan="10" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
                                <td colspan="8" class="text-center" style="background:#ddd;border:1px solid #000;"><b>VENTAS GRAVADAS</b></td>
                              </tr>
                              <tr class="text-center" style="white-space:nowrap;background:#ddd;font-size:1.05em;">
                                <td class="bd-black">Oper. <br>Nro</td>
                                <td class="bd-black">Fecha <br>Factura <br>/NC/ND/</td>
                                <td class="bd-black">Nro. R.I.F</td>
                                <td class="bd-black">Nombre o Razón Social del Cliente</td>
                                <td class="bd-black">Tipo de <br>Transacción</td>
                                <td class="bd-black">Número de Factura</td>
                                <td class="bd-black">Número de Control</td>
                                <td class="bd-black">Número <br>Nota Débito</td>
                                <td class="bd-black">Número <br>Nota Crédito</td>
                                <td class="bd-black">Número de <br>Factura Afectada</td>
                                
                                <td class="bd-black">Total Ventas <br>Incluyendo <br>el IVA</td>
                                <td class="bd-black">Ventas <br>Exentas <br>Exoneradas o <br>No Sujetas</td>
                                <td class="bd-black">Auto consumo, <br>Retiro, <br>Desincorporación <br>de Inventario</td>
                                <td class="bd-black">Base Imponible</td>
                                <td class="bd-black">% Alicuota</td>
                                <td class="bd-black">Impuesto IVA <br>Alicuota General</td>
                                <td class="bd-black">IVA Retenido <br>(Por Comprador)</td>
                                <td class="bd-black">Numero de <br>Comprobante <br>(Ret IVA)</td>
                              </tr>
                                <?php  
                                  $cuotaSinIVA=0;
                                  $precioIVA=0;
                                  $cuotaConIVA=0;
                                  $coutasExentasIva=0;
                                  $autoConsumo=0;
                                  $retencionIVa=0;

                                  $totalCuotaConIva = 0;
                                  $totalCuotaSinIva = 0;
                                  $totalPrecioIva = 0;
                                  $totalCoutasExentasIva=0;
                                  $totalAutoConsumo=0;
                                  $totalRetencionIVa=0;
                                  $num=1;
                                ?>
                                <?php if(count($facturasFiscales)>1){ foreach ($facturasFiscales as $fiscal){ if(!empty($fiscal['fecha_emision'])){ ?>
                                  <?php  
                                    $estat = false;
                                    if($fiscal['estado_factura']==1){
                                      $estat = true;
                                    }
                                    $cantidadfactura = $digitosParaCodigo-strlen($fiscal['numero_factura']);
                                    $numero_factura = "";
                                    for ($i=0; $i<$cantidadfactura; $i++){  $numero_factura.="0";}
                                    $numero_factura .= "".$fiscal['numero_factura'];

                                    // $fiscal['numero_control1']=221;
                                    $cantidadControl1 = $digitosParaCodigo-strlen($fiscal['numero_control1']);
                                    $numero_control1 = "";
                                    if($cantidadControl1>0){ $numero_control1 .= "00-"; }
                                    for ($i=0; $i<$cantidadControl1; $i++){  $numero_control1.="0";}
                                    $numero_control1 .= "".$fiscal['numero_control1'];

                                    // $fiscal['numero_control2']=222;
                                    $cantidadControl2 = $digitosParaCodigo-strlen($fiscal['numero_control2']);
                                    $numero_control2 = "";
                                    if($cantidadControl2>0){ $numero_control2 .= "00-"; }
                                    for ($i=0; $i<$cantidadControl2; $i++){  $numero_control2.="0";}
                                    $numero_control2 .= "".$fiscal['numero_control2'];


                                    $precio_coleccion = $fiscal['precio_coleccion'];
                                    $cantidad_colecciones = $fiscal['cantidad_aprobado'];
                                    $cuotaSinIVA = ($precio_coleccion*$cantidad_colecciones);
                                    $cuotaSinIVA = $fiscal['totalVenta'];
                                    $precioIVA = ($cuotaSinIVA/100)*$cantidadIVA;
                                    $cuotaConIVA = $cuotaSinIVA+$precioIVA;
                                    $coutasExentasIva=0;
                                    $autoConsumo=0;
                                    $retencionIVa=0;

                                    
                                    if($estat){
                                      $totalCuotaConIva+=$cuotaConIVA;
                                      $totalCuotaSinIva+=$cuotaSinIVA;
                                      $totalPrecioIva+=$precioIVA;
                                      $totalCoutasExentasIva+=$coutasExentasIva;
                                      $totalAutoConsumo+=$autoConsumo;
                                      $totalRetencionIVa+=$retencionIVa;
                                    }
                                  ?>
                                  <tr style="white-space:nowrap;">
                                    <td class="text-center bdl-black"><?php if($estat){ echo "<span style='color:".$fucsia." !important;'>".$num++."</span>";  } else { echo $num++; } ?></td>
                                    <td class="text-center"><?=str_replace("-","/",$lider->formatFecha($fiscal['fecha_emision'])); ?></td>
                                    <td><?php if($estat){ echo $fiscal['cod_rif'].$fiscal['rif']; } ?></td>
                                    <td style="text-transform:uppercase;"><?php if($estat){ echo $fiscal['primer_nombre']." ".$fiscal['segundo_nombre']." ".$fiscal['primer_apellido']." ".$fiscal['segundo_apellido']; } else { echo "***ANULADO***"; } ?></td>
                                    <td class="text-center"><?php if($estat){ echo "01"; } ?></td>
                                    <td><?php if($estat){ echo $numero_factura; } ?></td>
                                    <td><?php if($numero_control1==$numero_control2){ echo $numero_control1; } else { echo $numero_control1." / ".$numero_control2; } ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td class="textR"><?php if($estat){ echo number_format($cuotaConIVA,2,',','.'); } ?></td>
                                    <td class="textR"><?php if($estat){ echo number_format($coutasExentasIva,2,',','.'); } ?></td>
                                    <td class="textR"><?php if($estat){ echo number_format($autoConsumo,2,',','.'); } ?></td>
                                    <td class="textR"><?php if($estat){ echo number_format($cuotaSinIVA,2,',','.'); } ?></td>
                                    <td class="text-center"><?php if($estat){ echo $cantidadIVA."%"; } ?></td>
                                    <td class="textR"><?php if($estat){ echo number_format($precioIVA,2,',','.'); } ?></td>
                                    <td class="textR"><?php if($estat){ echo number_format($retencionIVa,2,',','.'); } ?></td>
                                    <td class="bdr-black textR"></td>
                                  </tr>
                                <?php } } } else{ ?>
                                  <tr style="white-space:nowrap;">
                                    <td class="bdl-black"><?=$num++; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-transform:uppercase;"><?php echo "***NO HUBO VENTAS***"; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td class="textR"><?php echo number_format($cuotaConIVA,2,',','.'); ?></td>
                                    <td class="textR"><?php echo number_format($coutasExentasIva,2,',','.'); ?></td>
                                    <td class="textR"><?php echo number_format($autoConsumo,2,',','.'); ?></td>
                                    <td class="textR"><?php echo number_format($cuotaSinIVA,2,',','.'); ?></td>
                                    <td class="text-center"><?php echo $cantidadIVA."%"; ?></td>
                                    <td class="textR"><?php echo number_format($precioIVA,2,',','.'); ?></td>
                                    <td class="textR"><?php echo number_format($retencionIVa,2,',','.'); ?></td>
                                    <td class="bdr-black textR"></td>
                                  </tr>
                                <?php } ?>
                                <tr class="text-center" style="font-size:1.10em;">
                                  <td colspan="10" class="bdl-black bdt-black bdb-black"><b>TOTALES</b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalCuotaConIva,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalCoutasExentasIva,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalAutoConsumo,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalCuotaSinIva,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black"><b></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalPrecioIva,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalRetencionIVa,2,',','.'); ?></b></td>
                                  <td class="bdr-black bdt-black bdb-black"><b></b></td>
                                </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br><br>
                      <!-- PARA LOS DEBITOS REGISTRADOS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="table-responsive">
                            <?php
                              $vtotalDBaseImponible = 0;
                              $vtotalDBaseImponible+=$totalCuotaSinIva;

                              $vtotalDDebitoFiscal = 0;
                              $vtotalDDebitoFiscal=+$totalPrecioIva;
                            ?>
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-6 text-center bd-black" colspan="3">
                                  Resumen del <?php if($tipo==1){ echo "Año"; } else if($tipo==2){ echo "Mes"; } ?> Base Imponible y Débitos Fiscales
                                </td>
                                <td class="col-xs-2 text-center bd-black">Base Imponible</td>
                                <td class="col-xs-2 text-center bd-black">Débito Fiscal</td>
                                <td class="col-xs-2 text-center bd-black">Retenciones de IVA</td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas No Gravadas</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas Afectas solo Alicuota General</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalCuotaSinIva,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalPrecioIva,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas Afectas Alicuota General + Adicional</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black bdb-black">Ventas Internas Afectas en Alicuota Reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black" colspan="3"><b>Total Ventas y Débitos Fiscales</b></td>
                                <td class="textR bd-black"><b><?=number_format($vtotalDBaseImponible,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($vtotalDDebitoFiscal,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format(0,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br><br>
                      <!-- PARA LOS CREDITOS REGISTRADOS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="table-responsive">
                            <?php 
                              $ventatotalCompra=0;
                              $ventacompraExentas=0;
                              $ventacomprasInternasGravadas=0;
                              $ventaivaGeneral=0;
                              $ventaretencionIVa=0;

                              $ventatotalTotalCompra = 0;
                              $ventatotalCompraExentas=0;
                              $ventatotalComprasInternasGravadas = 0;
                              $ventatotalIvaGeneral = 0;
                              $ventatotalRetencionIVa=0;
                              if(count($compras)>1){ foreach ($compras as $compra){ if(!empty($compra['id_factura_compra'])){
                                $ventaopRetencion = $compra['opRetencion'];
                                $ventatotalCompra = $compra['totalCompra'];
                                $ventacompraExentas = $compra['comprasExentas'];
                                $ventacomprasInternasGravadas = $compra['comprasInternasGravadas'];
                                $ventaprecioIVA = $compra['iva'];
                                $ventaivaGeneral = $compra['ivaGeneral'];
                                if($ventaopRetencion==1){
                                  $ventaretencionIVa=$compra['retencionIva'];
                                }

                                $ventatotalTotalCompra+=$ventatotalCompra;
                                $ventatotalCompraExentas+=$ventacompraExentas;
                                $ventatotalComprasInternasGravadas+=$ventacomprasInternasGravadas;
                                $ventatotalIvaGeneral+=$ventaivaGeneral;
                                $ventatotalRetencionIVa+=$ventaretencionIVa;
                              } } }

                              $ventatotalCBaseImponible=0;
                              $ventatotalCBaseImponible+=$ventatotalCompraExentas;
                              $ventatotalCBaseImponible+=$ventatotalComprasInternasGravadas;

                              $ventatotalCCreditoFiscal=0;
                              $ventatotalCCreditoFiscal+=$ventatotalIvaGeneral;

                              $ventatotalCRetencionesIVA=0;
                              $ventatotalCRetencionesIVA+=$ventatotalRetencionIVa;
                            ?>
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-6 text-center bd-black" colspan="3">
                                  Resumen del <?php if($tipo==1){ echo "Año"; } else if($tipo==2){ echo "Mes"; } ?> Base Imponible y Créditos Fiscales
                                </td>
                                <td class="col-xs-2 text-center bd-black">Base Imponible</td>
                                <td class="col-xs-2 text-center bd-black">Crédito Fiscal</td>
                                <td class="col-xs-2 text-center bd-black">Retenciones de IVA</td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Total: Compras no gravadas y/o sin derecho a crédito fiscal</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($ventatotalCompraExentas,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Σ de las: Compras Internas gravadas sólo por Alícuota General</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($ventatotalComprasInternasGravadas,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($ventatotalIvaGeneral,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($ventatotalRetencionIVa,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Σ de las: Compras Internas gravadas por Alícuota General + Adicional</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black bdb-black">Σ de las: Compras Internas gravadas por Alícuota Reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black" colspan="3"><b>Total Compras y Créditos Fiscales del Período</b></td>
                                <td class="textR bd-black"><b><?=number_format($ventatotalCBaseImponible,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($ventatotalCCreditoFiscal,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($ventatotalCRetencionesIVA,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="compras" class="tab-pane fade">
                      <br>
                      <br>
                      <style type="text/css">
                        .textR{ text-align:right; }
                        .bd-black{ border:1px solid #000 !important; }
                        .bdt-black{ border-top:1px solid #000 !important; }
                        .bdb-black{ border-bottom:1px solid #000 !important; }
                        .bdl-black{ border-left:1px solid #000 !important; }
                        .bdr-black{ border-right:1px solid #000 !important; }
                        .table-simple td{ padding:1px 3px; }
                        .tab-content span{color:#000 !important;font-size:1.1em;}
                      </style>
                      <!-- TABLA PRINCIPAL DE REGISTROS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <label style="font-size:1.3em;">
                            <span>INVERSIONES STYLE COLLECTION, C.A.</span>
                            <br>
                            <span>RIF: J-408497786</span>
                            <br>
                            <span><u>LIBRO DE COMPRAS DEL </u></span>
                            <span>
                              &nbsp
                              <u>
                                <?php
                                  echo " ".str_replace("-","/",$lider->formatFecha($inicioFecha)).
                                  " HASTA EL  ".
                                  str_replace("-","/",$lider->formatFecha($finFecha)); 
                                ?>
                                
                              </u>
                            </span>
                          </label>
                        </div>
                        <br>
                        <div class="col-xs-12">
                          <div class="table-responsive" style="max-height:80vh;overflow:auto;">
                            <table class="table">
                              <tr class="text-center" style="white-space:nowrap;background:#ddd;font-size:1.05em;">
                                <td class="bd-black">Oper. <br>Nro</td>
                                <td class="bd-black">Fecha <br>Factura <br>/NC/ND/</td>
                                <td class="bd-black">Nro. R.I.F</td>
                                <td class="bd-black">Nombre o Razón Social del Proveedor</td>
                                <td class="bd-black">Número de <br>Factura</td>
                                <td class="bd-black">Número de <br>Control</td>
                                <td class="bd-black">Tipo de <br>Transacción</td>
                                <td class="bd-black">Número <br>Nota Débito</td>
                                <td class="bd-black">Número <br>Nota Crédito</td>
                                <td class="bd-black">Número <br>Factura <br>Afectada</td>
                                
                                <td class="bd-black">Total Compras <br>de Bienes y <br>Servicios <br>Incluyendo <br>IVA</td>
                                <td class="bd-black">Compras <br>Exentas <br>Exoneradas o <br>No Sujetas</td>
                                <td class="bd-black">Compras <br>Internas <br>Gravadas</td>
                                <td class="bd-black">% Alicuota</td>
                                <td class="bd-black">IVA <br>Alicuota <br>General</td>
                                <td class="bd-black">RET IVA <br>Alicuota <br>General</td>
                                <td class="bd-black">Comprobante de <br>Retención de IVA</td>
                                <td class="bd-black">Fecha del <br>Comprobante <br>de Retentecíón</td>
                              </tr>
                                <?php  
                                  $totalCompra=0;
                                  $compraExentas=0;
                                  $comprasInternasGravadas=0;
                                  $ivaGeneral=0;
                                  $retencionIVa=0;



                                  $totalTotalCompra = 0;
                                  $totalCompraExentas=0;
                                  $totalComprasInternasGravadas = 0;
                                  $totalIvaGeneral = 0;
                                  $totalRetencionIVa=0;
                                  $num=1;
                                ?>
                                <?php if(count($compras)>1){ foreach ($compras as $compra){ if(!empty($compra['id_factura_compra'])){ ?>
                                  <?php  
                                    $opRetencion = $compra['opRetencion'];
                                    // $cantidadfactura = $digitosParaCodigo-strlen($compra['numeroFactura']);
                                    // $numero_factura = "";
                                    // for ($i=0; $i<$cantidadfactura; $i++){  $numero_factura.="0";}
                                    // $numero_factura .= "".$fiscal['numero_factura'];

                                    // // $fiscal['numero_control1']=221;
                                    // $cantidadControl1 = $digitosParaCodigo-strlen($fiscal['numeroControl']);
                                    // $numero_control1 = "";
                                    // if($cantidadControl1>0){ $numero_control1 .= "00-"; }
                                    // for ($i=0; $i<$cantidadControl1; $i++){  $numero_control1.="0";}
                                    // $numero_control1 .= "".$fiscal['numero_control1'];


                                    $totalCompra = $compra['totalCompra'];
                                    $compraExentas = $compra['comprasExentas'];
                                    $comprasInternasGravadas = $compra['comprasInternasGravadas'];
                                    $precioIVA = $compra['iva'];
                                    $ivaGeneral = $compra['ivaGeneral'];
                                    if($opRetencion==1){
                                      $retencionIVa=$compra['retencionIva'];
                                    }

                                    $totalTotalCompra+=$totalCompra;
                                    $totalCompraExentas+=$compraExentas;
                                    $totalComprasInternasGravadas+=$comprasInternasGravadas;
                                    $totalIvaGeneral+=$ivaGeneral;
                                    $totalRetencionIVa+=$retencionIVa;
                                  ?>
                                  <tr style="white-space:nowrap;">
                                    <td class="bdl-black"><?=$num++; ?></td>
                                    <td class="text-center"><?=str_replace("-","/",$lider->formatFecha($compra['fechaFactura'])); ?></td>
                                    <td><?=$compra['codRif'].$compra['rif']; ?></td>
                                    <td style="text-transform:uppercase;"><?=$compra['nombreProveedor']; ?></td>
                                    <td><?=$compra['numeroFactura']; ?></td>
                                    <td><?=$compra['numeroControl']; ?></td>
                                    <td class="text-center"><?php echo "01"; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td class="textR"><?=number_format($totalCompra,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($compraExentas,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($comprasInternasGravadas,2,',','.'); ?></td>
                                    <td class="text-center"><?=$precioIVA."%"; ?></td>
                                    <td class="textR"><?=number_format($ivaGeneral,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($retencionIVa,2,',','.'); ?></td>
                                    <td class="text-center"><?php if($opRetencion==1){ echo $compra['comprobante']; } else { echo ""; } ?></td>
                                    <td class="bdr-black text-center"><?php if($opRetencion==1){ echo str_replace("-","/",$lider->formatFecha($compra['fechaComprobante'])); } else { echo ""; } ?></td>
                                  </tr>
                                <?php } } } else{ ?>
                                  <tr style="white-space:nowrap;">
                                    <td class="bdl-black"><?=$num++; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-transform:uppercase;"><?php echo "***NO HUBO COMPRAS***"; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td class="textR"><?=number_format($totalCompra,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($compraExentas,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($comprasInternasGravadas,2,',','.'); ?></td>
                                    <td class="text-center"></td>
                                    <td class="textR"><?=number_format($ivaGeneral,2,',','.'); ?></td>
                                    <td class="textR"><?=number_format($retencionIVa,2,',','.'); ?></td>
                                    <td class="text-center"></td>
                                    <td class="bdr-black text-center"></td>
                                  </tr>
                                <?php } ?>
                                <tr class="text-center bdb-black" style="font-size:1.10em;">
                                  <td colspan="10" class="bdl-black bdt-black bdb-black"><b>TOTALES</b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalTotalCompra,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalCompraExentas,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalComprasInternasGravadas,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black"><b></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalIvaGeneral,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b><?=number_format($totalRetencionIVa,2,',','.'); ?></b></td>
                                  <td class="bdt-black bdb-black textR"><b></b></td>
                                  <td class="bdr-black bdt-black bdb-black"><b></b></td>
                                </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br><br>
                      <!-- PARA LOS CREDITOS REGISTRADOS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="table-responsive">
                            <?php
                              $ctotalCBaseImponible = 0;
                              $ctotalCBaseImponible+=$totalCompraExentas;
                              $ctotalCBaseImponible+=$totalComprasInternasGravadas;

                              $ctotalCCreditoFiscal = 0;
                              $ctotalCCreditoFiscal+=$totalIvaGeneral;

                              $ctotalCRetencionesIVA=0;
                              $ctotalCRetencionesIVA+=$totalRetencionIVa;
                            ?>
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-6 text-center bd-black" colspan="3">
                                  Resumen del <?php if($tipo==1){ echo "Año"; } else if($tipo==2){ echo "Mes"; } ?> Base Imponible y Créditos Fiscales
                                </td>
                                <td class="col-xs-2 text-center bd-black">Base Imponible</td>
                                <td class="col-xs-2 text-center bd-black">Crédito Fiscal</td>
                                <td class="col-xs-2 text-center bd-black">Retenciones de IVA</td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Total: Compras no gravadas y/o sin derecho a crédito fiscal</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalCompraExentas,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Σ de las: Compras Internas gravadas sólo por Alícuota General</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalComprasInternasGravadas,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalIvaGeneral,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalRetencionIVa,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Σ de las: Compras Internas gravadas por Alícuota General + Adicional</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black bdb-black">Σ de las: Compras Internas gravadas por Alícuota Reducida </td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black" colspan="3"><b>Total Compras y Créditos Fiscales del Período</b></td>
                                <td class="textR bd-black"><b><?=number_format($ctotalCBaseImponible,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($ctotalCCreditoFiscal,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($ctotalCRetencionesIVA,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br><br>
                      <!-- PARA LOS DEBITOS REGISTRADOS -->
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="table-responsive">
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-6 text-center bd-black" colspan="3">
                                  Resumen del <?php if($tipo==1){ echo "Año"; } else if($tipo==2){ echo "Mes"; } ?> Base Imponible y Débitos Fiscales
                                </td>
                                <td class="col-xs-2 text-center bd-black">Base Imponible</td>
                                <td class="col-xs-2 text-center bd-black">Débito Fiscal</td>
                                <td class="col-xs-2 text-center bd-black">Retenciones de IVA</td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas No Gravadas</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas Afectas solo Alicuota General</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalCuotaSinIva,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format($totalPrecioIva,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black">Ventas Internas Afectas Alicuota General + Adicional</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="bdl-black bdb-black">Ventas Internas Afectas en Alicuota Reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                                <td class="textR bdl-black bdr-black bdb-black"><?=number_format(0,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black" colspan="3"><b>Total Ventas y Débitos Fiscales</b></td>
                                <td class="textR bd-black"><b><?=number_format($totalCuotaSinIva,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($totalPrecioIva,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format(0,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="resumen" class="tab-pane fade">
                      <br>
                      <br>
                      <style type="text/css">
                        .textR{ text-align:right; }
                        .bd-black{ border:1px solid #000 !important; }
                        .bdt-black{ border-top:1px solid #000 !important; }
                        .bdb-black{ border-bottom:1px solid #000 !important; }
                        .bdl-black{ border-left:1px solid #000 !important; }
                        .bdr-black{ border-right:1px solid #000 !important; }
                        .table-simple td{ padding:1px 3px; }
                        .tab-content span{color:#000 !important;font-size:1.1em;}
                      </style>
                      <div class="row">
                        <div class="col-xs-12">
                          <label style="font-size:1.3em;">
                            <span>INVERSIONES STYLE COLLECTION, C.A.</span>
                            <br>
                            <span>RIF: J-408497786</span>
                            <br>
                            <span><u>RESUMEN DE LOS DÉBITOS Y CRÉDITOS DESDE EL</u></span>
                            <span>
                              &nbsp
                              <u>
                                <?php
                                  echo " ".str_replace("-","/",$lider->formatFecha($inicioFecha)).
                                  " HASTA EL  ".
                                  str_replace("-","/",$lider->formatFecha($finFecha)); 
                                ?>
                                
                              </u>
                            </span>
                          </label>
                        </div>
                      </div>

                      <!-- DEBITOS DE PERIODO -->
                      <br>
                      <?php 
                        $numeBlock = 1;
                        
                        ### ===========================================================================
                          $ventasInternasNoGravadas=$totalCoutasExentasIva;
                          $ventasDeExportacion=0;
                          $ventasInternasAGBaseImponible=$totalCuotaSinIva;
                          $ventasInternasAGAdicionalBaseImponible=0;
                          $ventasInternasAReducidaBaseImponible=0;
                          $totalVentasDebitosFiscalesBaseImp = $ventasInternasNoGravadas+
                                                        $ventasDeExportacion+
                                                        $ventasInternasAGBaseImponible+
                                                        $ventasInternasAGAdicionalBaseImponible+
                                                        $ventasInternasAReducidaBaseImponible;
                            # =================== # ========================= #
                          $ventasInternasAGDebito=$totalPrecioIva;
                          $ventasInternasAGAdicionalDebito=0;
                          $ventasInternasAReducidaDebito=0;
                          $totalVentasDebitosFiscalesDebitos = $ventasInternasAGDebito+
                                                              $ventasInternasAGAdicionalDebito+
                                                              $ventasInternasAReducidaDebito;
                          
                          $ajustesDebitosFiscalesPeriodosAnt = $debitosFiscalesPendienteAnterior;
                          $certificadoDebitosFiscalesExonerados=0;
                            # =================== # ========================= #
                          $totalDebitosFiscales=$totalVentasDebitosFiscalesDebitos+
                                                $ajustesDebitosFiscalesPeriodosAnt+
                                                $certificadoDebitosFiscalesExonerados;
                        ### ===========================================================================

                        ### ===========================================================================
                          $comprasNoGravadasSDCreditoFiscalBI=$totalCompraExentas;
                          $ImportGravadasAlicuotaGeneralBI=0;
                          $ImportGravadasAlicuotaGeneralAdicionalBI=0;
                          $ImportGravadasAlicuotaReducidaBI=0;
                          $comprasGravadasPorALicuotaGeneralBI=$totalComprasInternasGravadas;
                          $comprasGravadasPorALicuotaGeneralAdicionalBI=0;
                          $comprasGravadasPorALicuotaReducidaBI=0;
                          $totalCompraVentaFiscalesPeriodoBI=$comprasNoGravadasSDCreditoFiscalBI+
                                                            $ImportGravadasAlicuotaGeneralBI+
                                                            $ImportGravadasAlicuotaGeneralAdicionalBI+
                                                            $ImportGravadasAlicuotaReducidaBI+
                                                            $comprasGravadasPorALicuotaGeneralBI+
                                                            $comprasGravadasPorALicuotaGeneralAdicionalBI+
                                                            $comprasGravadasPorALicuotaReducidaBI;
                            # =================== # ========================= #
                          $ImportGravadasAlicuotaGeneralCR=0;
                          $ImportGravadasAlicuotaGeneralAdicionalCR=0;
                          $ImportGravadasAlicuotaReducidaCR=0;
                          $comprasGravadasPorALicuotaGeneralCR=$totalIvaGeneral;
                          $comprasGravadasPorALicuotaGeneralAdicionalCR=0;
                          $comprasGravadasPorALicuotaReducidaCR=0;
                          $totalCompraVentaFiscalesPeriodoCR=$ImportGravadasAlicuotaGeneralCR+
                                                            $ImportGravadasAlicuotaGeneralAdicionalCR+
                                                            $ImportGravadasAlicuotaReducidaCR+
                                                            $comprasGravadasPorALicuotaGeneralCR+
                                                            $comprasGravadasPorALicuotaGeneralAdicionalCR+
                                                            $comprasGravadasPorALicuotaReducidaCR;
                        ### ===========================================================================

                        ### ===========================================================================
                          $cFTotalmenteDeducibles=$totalCompraVentaFiscalesPeriodoCR;
                          $cFProductoAplicarProrrata=0;
                          $totalCreditosFiscalesDeducibles=$cFTotalmenteDeducibles+$cFProductoAplicarProrrata;

                          $excedentesCFMesAnterior=$excedenteCreditosFiscalesPendienteAnterior;
                          $ajusteCFPeriodosAnteriores=0;
                          $ajusteDFExonerados=$certificadoDebitosFiscalesExonerados;
                          $totalCreditosFiscales = $excedenteCreditosFiscalesPendienteAnterior+
                                                  $ajusteCFPeriodosAnteriores-
                                                  $ajusteDFExonerados+
                                                  $cFTotalmenteDeducibles;
                        ### ===========================================================================

                        ### ===========================================================================
                          if(0>($totalDebitosFiscales-$totalCreditosFiscales)){
                            $totalCuotaTributaria=0;
                          }else{
                            $totalCuotaTributaria = ($totalDebitosFiscales-$totalCreditosFiscales);
                          }
                          if(0>($totalCreditosFiscales-$totalDebitosFiscales)){
                            $excedenteCreditoFiscalMesSiguiente=0;
                          }else{
                            $excedenteCreditoFiscalMesSiguiente = ($totalCreditosFiscales-$totalDebitosFiscales);
                          }
                            # =================== # ========================= #
                          $retencionACumuladaPorDescontar=0;
                          $retencionDelPeriodo=$totalRetencionIVa;
                          $totalRetenciones = $retencionACumuladaPorDescontar+$retencionDelPeriodo;

                          $retencionSoportadaDescontadaDeclaracion=0;
                          $retencionSoportadaDescontadaDeclaracionD=0;
                          if($totalCuotaTributaria>$totalRetenciones){
                            $retencionSoportadaDescontadaDeclaracionD=$totalRetenciones;
                          }else{
                            $retencionSoportadaDescontadaDeclaracionD=$totalCuotaTributaria;
                          }
                          $saldoRetencionIVANoAplicado = $totalRetenciones-$retencionSoportadaDescontadaDeclaracionD;
                          $totalAPagar = $totalCuotaTributaria-$retencionSoportadaDescontadaDeclaracionD;
                        ### ===========================================================================

                      ?>
                      <div class="row">
                        <div class="col-xs-10">
                          <div class="table-responsive">
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-1 text-center bd-black"><b></b></td>
                                <td class="col-xs-7 text-center bd-black" colspan="3"><b>Débitos del periodo</b></td>
                                <td class="col-xs-2 text-center bd-black"><b>Base Imponible</b></td>
                                <td class="col-xs-2 text-center bd-black"><b>Débito</b></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ventas Internas no Gravadas</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasNoGravadas,2,',','.'); ?></td>
                                <td class="textR bd-black" style="background:#ddd;"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ventas de Exportación</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ventasDeExportacion,2,',','.'); ?></td>
                                <td class="textR bd-black" style="background:#ddd;"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ventas internas gravadas alícuota general</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAGBaseImponible,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAGDebito,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ventas internas gravadas por alícuota general mas adicional</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAReducidaBaseImponible,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAReducidaDebito,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ventas internas gravadas alícuota reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAReducidaBaseImponible,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ventasInternasAReducidaDebito,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Total ventas y débitos fiscales para efectos de determinación</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($totalVentasDebitosFiscalesBaseImp,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($totalVentasDebitosFiscalesDebitos,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ajuste a los débitos fiscales de períodos anteriores</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($ajustesDebitosFiscalesPeriodosAnt,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Certificado de Débitos Fiscales Exonerados (recibidos)</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($certificadoDebitosFiscalesExonerados,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bd-black" colspan="4"><b>Total Débitos Fiscales</b></td>
                                <td class="textR bd-black"><b><?=number_format($totalDebitosFiscales,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-xs-10">
                          <div class="table-responsive">
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-1 text-center bd-black"><b></b></td>
                                <td class="col-xs-7 text-center bd-black" colspan="3"><b>Créditos del periodo</b></td>
                                <td class="col-xs-2 text-center bd-black"><b>Base Imponible</b></td>
                                <td class="col-xs-2 text-center bd-black"><b>Crédito</b></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Compras no gravadas y/o sin derecho a crédito fiscal</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($comprasNoGravadasSDCreditoFiscalBI,2,',','.'); ?></td>
                                <td class="textR bd-black" style="background:#ddd;"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Importaciones gravadas por alícuota general</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaGeneralBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaGeneralCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Importaciones gravadas por alícuota general mas adicional</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaGeneralAdicionalBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaGeneralAdicionalCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Importaciones gravadas por alícuota reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaReducidaBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($ImportGravadasAlicuotaReducidaCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Compras Internas gravadas solo por alícuota general</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaGeneralBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaGeneralCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Compras Internas gravadas por alícuota general mas adicional</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaGeneralAdicionalBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaGeneralAdicionalCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Compras Internas gravadas por alícuota reducida</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaReducidaBI,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($comprasGravadasPorALicuotaReducidaCR,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bd-black" colspan="3"><b>Total Compras y Créditos Fiscales del periodo</b></td>
                                <td class="textR bd-black"><b><?=number_format($totalCompraVentaFiscalesPeriodoBI,2,',','.'); ?></b></td>
                                <td class="textR bd-black"><b><?=number_format($totalCompraVentaFiscalesPeriodoCR,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-xs-10">
                          <div class="table-responsive">
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-1 text-center bd-black"><b></b></td>
                                <td class="col-xs-7 text-center bdt-black bdb-black" colspan="3"><b>Cálculo del Crédito deducible </b></td>
                                <td class="col-xs-2 text-center bdt-black bdb-black"><b></b></td>
                                <td class="col-xs-2 text-center bdt-black bdb-black bdr-black"><b></b></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Créditos fiscales totalmente deducibles</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($cFTotalmenteDeducibles,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Créditos fiscales producto de la aplicación de la prorrata</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($cFProductoAplicarProrrata,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Total créditos fiscales deducibles</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($totalCreditosFiscalesDeducibles,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Excedente créditos fiscales del mes anterior </td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($excedentesCFMesAnterior,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Ajuste a los créditos fiscales de periodos anteriores</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($ajusteCFPeriodosAnteriores,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Certificados de Débitos Fiscales Exonerados (emitidos)</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($ajusteDFExonerados,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bd-black" colspan="4"><b>Total Créditos Fiscales</b></td>
                                <td class="textR bd-black"><b><?=number_format($totalCreditosFiscales,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-xs-10">
                          <div class="table-responsive">
                            <table class="table-simple" style="width:100%;">
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="col-xs-1 text-center bd-black"><b></b></td>
                                <td class="col-xs-7 text-center bdl-black bdt-black bdb-black" colspan="3"><b>Autoliquidación</b></td>
                                <td class="col-xs-2 text-center bdt-black bdb-black"><b></b></td>
                                <td class="col-xs-2 text-center bdt-black bdb-black bdr-black"><b></b></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black"><b>Total Cuota tributaria</b></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($totalCuotaTributaria,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Excedente de Crédito Fiscal Para el Mes Siguiente</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black"></td>
                                <td class="textR bd-black"><?=number_format($excedenteCreditoFiscalMesSiguiente,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Retenciones Acumuladas por Descontar</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($retencionACumuladaPorDescontar,2,',','.'); ?></td>
                                <td class="textR bd-black"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Retención del Periodo</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($retencionDelPeriodo,2,',','.'); ?></td>
                                <td class="textR bd-black"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Total Retenciones</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($totalRetenciones,2,',','.'); ?></td>
                                <td class="textR bd-black"></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Retenciones Soportadas Descontadas en esta Declaración</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($retencionSoportadaDescontadaDeclaracion,2,',','.'); ?></td>
                                <td class="textR bd-black"><?=number_format($retencionSoportadaDescontadaDeclaracionD,2,',','.'); ?></td>
                              </tr>
                              <tr style="white-space:nowrap;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bdl-black bdb-black">Saldo de Retenciones de IVA no Aplicado</td>
                                <td class="bdb-black"></td>
                                <td class="bdb-black bdr-black"></td>
                                <td class="textR bd-black"><?=number_format($saldoRetencionIVANoAplicado,2,',','.'); ?></td>
                                <td class="textR bd-black"></td>
                              </tr>
                              <tr style="white-space:nowrap;font-size:1.10em;">
                                <td class="text-center bd-black"><?=$numeBlock++; ?></td>
                                <td class="bd-black" colspan="3"><b>Total a Pagar</b></td>
                                <td class="textR bd-black"><b></b></td>
                                <td class="textR bd-black"><b><?=number_format($totalAPagar,2,',','.'); ?></b></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <br>
                      <br>
                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Contable"){ ?>
                        <div class="">
                          <input type="hidden" id="nameCreditoACT" value="creditoFiscalACT">
                          <input type="hidden" id="nameDebitoACT" value="debitoFiscalACT">
                          <input type="hidden" id="anioValueACT" value="<?=$actualAnio; ?>">
                          <input type="hidden" id="mesValueACT" value="<?=$actualMes; ?>">
                          <input type="hidden" class="form-control" id="creditoFiscalACT" value="<?=$excedenteCreditoFiscalMesSiguiente; ?>" name="creditoFiscalACT" placeholder="0,00">
                          <input type="hidden" class="form-control" id="debitoFiscalACT" value="<?=$totalAPagar; ?>" name="debitoFiscalACT" placeholder="0,00">
                          <div class="row">
                            <div class="col-xs-12">
                              <button id="ACT" class="btn btn-default ActualizarValoresFiscales enviar2 color-button-sweetalert" >Guardar</button>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>

                  </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <!-- <span type="submit" class="btn btn-default cargar enviar2 color-button-sweetalert" >Cargar</span> -->
                  <!-- <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>"> -->
                  <!-- <button class="btn-enviar d-none" disabled="">enviar</button> -->
                </div>

                <input type="hidden" id="route" value="<?=$_GET['route']; ?>">
                <input type="hidden" id="action" value="<?=$_GET['action']; ?>">
                <input type="hidden" id="tipo" value="<?=$_GET['tipo']; ?>">
                <input type="hidden" id="anio" value="<?=$_GET['anio']; ?>">
                <input type="hidden" id="mes" value="<?=$_GET['mes']; ?>">
              <?php } ?>
            <form action="" method="post" role="form" class="form_register">
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
</style>
<script type="text/javascript">
$(document).ready(function(){
  // alert("asdasd");
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
        window.location = "?route=Liderazgos";
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
  
  $(".btnExpandFiscal").click(function(){
    var estat = $(".etiq").hasClass("fa-sort-down");
    if(estat){
      $(".etiq").removeClass("fa-sort-down");
      $(".etiq").addClass("fa-sort-up");
      $(".boxContentFiscal").slideDown();
    }else{
      $(".boxContentFiscal").slideUp();
      $(".etiq").removeClass("fa-sort-up");
      $(".etiq").addClass("fa-sort-down");
    }
  });

  $("#tipo").change(function(){
    $("#boxAnio").hide();
    $("#boxAnio").removeClass("d-none");
    $("#boxMex").hide();
    $("#boxMex").removeClass("d-none");
    var tipo = $(this).val();
    if(tipo!=""){
      $(".boxss").slideUp();
    }
    if(tipo=="1"){
      $("#boxAnio").slideDown();
    }
    if(tipo=="2"){
      $("#boxAnio").slideDown();
      $("#boxMes").slideDown();
    }
  });

  $(".cargar").click(function(){
    var response = validar();
    let ruta = "";
    if(response==true){
      var tipo = $("#tipo").val();
      if(tipo=="1"){
        var anio = $("#anio").val();
        ruta="?route="+$("#route").val()+"&action="+$("#action").val()+"&tipo="+tipo+"&anio="+anio;
      }
      if(tipo=="2"){
        var anio = $("#anio").val();
        var mes = $("#mes").val();
        ruta="?route="+$("#route").val()+"&action="+$("#action").val()+"&tipo="+tipo+"&anio="+anio+"&mes="+mes;
      }
      window.location.href=ruta;
    }
  });

  $(".ActualizarValoresFiscales").click(function(){
    var id = $(this).attr("id");
    var route = $("#route").val();
    var action = $("#action").val();
    var tipo = $("#tipo").val();
    var anio = $("#anio").val();
    var mes = $("#mes").val();

    var anioRegis = $("#anioValue"+id).val();
    var mesRegis = $("#mesValue"+id).val();
    var namecredito = $("#nameCredito"+id).val();
    var namedebito = $("#nameDebito"+id).val();
    var credito=$("#"+namecredito).val();
    var debito=$("#"+namedebito).val();
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
          url: `?route=${route}&action=${action}&tipo=${tipo}&anio=${anio}&mes=${mes}`,
          type: 'POST',
          data: {
            credito: credito,
            debito: debito,
            anio: anioRegis,
            mes: mesRegis,
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonText: "¡Guardar!",
                confirmButtonColor: "#ED2A77"
              }).then(function(){
                window.location = `?route=${route}&action=${action}&tipo=${tipo}&anio=${anio}&mes=${mes}`;
              });
            } 
            if (respuesta == "2"){
              swal.fire({
                type: 'error',
                title: '¡No se pudieron guardar los datos!',
                confirmButtonColor: "#ED2A77",
              });
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
  });

});
  
function validar(){
  var tipo = $("#tipo").val();
  var renviar=false;
  if(tipo!=""){
    if(tipo=="1"){
      var anio = $("#anio").val();
      if(anio!=""){
        renviar=true;
      }else{
        renviar=false;
      }
    }
    if(tipo=="2"){
      var anio = $("#anio").val();
      if(anio!=""){
        var mes = $("#mes").val();
        if(mes!=""){
          renviar=true;
        }else{
          renviar=false;
        }
      }else{
        renviar=false;
      }
    }
  }
  return renviar;
}

</script>
</body>
</html>
