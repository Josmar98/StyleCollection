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
        <?php echo "Mis Pagos"; ?>
        <small><?php echo "Ver Mis Pagos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pagos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "Mis Pagos";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Pagos</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <?php
        $menUU = $menu."&route=".$_GET['route'];
        if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
          $menUU .= "&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
        }
        if(!empty($_GET['Banco'])){
          $menUU .= "&Banco=".$_GET['Banco'];
        }
        if(!empty($_GET['admin'])){
          $menUU .= "&admin=".$_GET['admin'];
        }
        if(!empty($_GET['lider'])){
          $menUU .= "&lider=".$_GET['lider'];
        }
        // echo $menUU;
        // echo "<br><br>";
        // print_r($pagosRecorridos);
        // echo "<br><br>";
        // print_r($promociones);
      ?>

      <div style="background:;position:fixed;top:15%;right:0;z-index:500;background:<?=$fucsia; ?>;padding:3px 2px;border-radius:5px;max-height:45vh;overflow:auto;">
        <span class="btn expandAccess">
          <i style="font-size:1.5em;color:#FFF;" id="idExpandAccess" class="fa fa-chevron-circle-left"></i>
        </span>
        <span id="enlaceAccess" class="d-none" style="background:<?=$fucsia; ?>;color:#FFF;margin-right:2px;">
          <br>
          <?php foreach ($pagosRecorridos as $p1){ ?>
            <br>
            <a class="enlaceOpen" href="?<?=$menUU; ?>#<?=$p1['id']; ?>" style="padding:10px 15px;color:#FFF;"><?=$p1['name']; ?></a>
            <br>
          <?php } ?>
          <?php //foreach ($promociones as $p1){ if(!empty($p1['id_promocion'])){ ?>
            <!-- <br> -->
            <!-- <a class="enlaceOpen" href="?<?=$menUU; ?>#promo_<?=$p1['id_promocion']; ?>" style="padding:10px 15px;color:#FFF;"><?=$p1['nombre_promocion']; ?></a> -->
            <!-- <br> -->
          <?php //} } ?>
          <br>
        </span>
      </div>
      <div class="row">
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


        <div class="col-xs-12">
          <!-- /.box -->
              <?php 
              $exportarPagosLider=0;
              $registropagosboton=0;
              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              foreach ($configuraciones as $config) {
                 if(!empty($config['id_configuracion'])){
                    if($config['clausula']=="Exportarpagoslider"){
                      $exportarPagosLider = $config['valor'];
                    }
                    if($config['clausula']=="Registropagosboton"){
                      $registropagosboton = $config['valor'];
                    }
                 }
              }
              ?>
          <div class="box">
            <?php if($estado_campana=="1"){ ?>
              <?php if ($estado_campana=="1" && $registropagosboton=="1"): ?>
                <a href="?<?=$menu?>&route=Pagos&action=Registrar" style="position:fixed;bottom:7%;right:2%;z-index:300;" class="btn enviar2"><span class="fa fa-arrow-up"></span> <span class="hidden-xs hidden-sm"><u>Registrar Pagos</u></span></a>
              <?php endif; ?>
            <?php } ?>
            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><?php echo "Mis Pagos"; ?></h3>
              <br><br>
              <?php  

                if($exportarPagosLider=="1"){
              ?>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-md-12" style="text-align:right;">
                      <form action="" method="get" target="_blank">
                        <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                        <input type="hidden" value="<?=$numero_campana;?>" name="n">
                        <input type="hidden" value="<?=$anio_campana;?>" name="y">
                        <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                        <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                        <input type="hidden" value="<?=$url;?>" name="route">
                        <input type="hidden" value="Exportar" name="action">
                        <?php if(!empty($_GET['admin'])){ ?>
                        <input type="hidden" value="1" name="admin">
                        <?php } ?>
                        <?php if(!empty($_GET['lider'])){ ?>
                        <input type="hidden" value="<?=$_GET['lider']?>" name="lider">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoI'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoI']?>" name="rangoI">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoF'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoF']?>" name="rangoF">
                        <?php } ?>
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>
                        <button class="btn btn-success"><b>Exportar a Excel  
                          <span class="fa fa-file-excel-o" style="color:#FFF;margin-left:5px;"></span>
                        </b></button>
                          <!-- <img src="public/assets/img/excel_icon.png" style="width:20px;"> -->
                      </form>
                    </div>
                </div>
              <?php 
                }
              ?>

              <style>
                    .text-xs {
                      text-align:right;
                    }
                  @media (max-width: 768px) {
                    .text-xs {
                      text-align:right !important;
                    }
                  }
                </style>
                  <div class="row">
                      <br>
                      <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                        <a href="?<?=$menu?>&route=MisPagosBolivares" style="color:#2A2;" class="btn"><b><u>Ver Solo Bolivares</u></b></a>
                      </div>
                      <br>
                      <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                        <a href="?<?=$menu?>&route=MisPagosDivisas" style="background:#0A0;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Solo Divisas</u></b></a>
                      </div>
                      <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                        <a href="?<?=$menu?>&route=MisPagosBancarios" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Solo Movimientos Bancarios</u></b></a>
                      </div>
                  </div>
                  <a class="" href="?<?=$menu."&route=Pedidos&id=".$pedido['id_pedido']?>" style='font-size:1.1em;'><b><u>Ir al estado de cuentas</u></b></a>
                  <br>
                  <div class="row">
                    <?php
                    $nIndx = 0;
                    $acumuladosTotales = [];
                    $totalesPagosPagar = [];
                    foreach ($cantidadPagosDespachosFild as $key) {
                      foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                        if($pagosD['tipo_pago_despacho']==$key['name']){
                          if($nIndx < $despacho['cantidad_pagos']-1){
                          ?>
                    <div class="col-xs-12 col-md-6">
                      <h3 style="margin:0;padding:0;"><small>Responsabilidad <?=$pagosD['tipo_pago_despacho']; ?></small></h3>
                      <table class="tablee table-hover table-striped text-center" style="border:1px solid #CCC;width:100%">
                        <thead>
                          <tr style="background:#CCC">
                            <th>Plan</th>
                            <th>Cantidad</th>
                            <th></th>
                            <th>Precio</th>
                            <th></th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $acumTotalPrimerPago = 0;
                            $acumuladosTotales[$key['id']] = 0;
                          ?>
                          <?php foreach ($planes as $plans): ?>
                              <?php if (!empty($plans['id_pedido'])): ?>
                                <?php if ($plans['cantidad_coleccion_plan']>0): ?>
                                  <tr>
                                    <td>Plan <?=$plans['nombre_plan']?></td>
                                    <td>
                                      <?php $colecciones = $plans['cantidad_coleccion']*$plans['cantidad_coleccion_plan']; ?>
                                      <?=$colecciones?> Col.</td>
                                    <td>X</td>
                                    <td>$<?=$pagosD['pago_precio_coleccion']; ?></td>
                                    <td>=</td>
                                    <?php $costoTotal = $colecciones*$pagosD['pago_precio_coleccion']; ?>
                                    <td>$<?=$costoTotal; ?></td>
                                    <?php $acumuladosTotales[$key['id']]+=$costoTotal; ?>
                                  </tr>
                                <?php endif ?>
                              <?php endif ?>
                          <?php endforeach ?>
                          <tr style="border-top:1.02px solid #AAA;border-bottom:1.02px solid #AAA">
                            <td></td>
                            <td></td>
                            <td colspan="2"><b>Total</b></td>
                            <td>=</td>
                            <td><b>$<?=$acumuladosTotales[$key['id']]; ?></b></td>
                          </tr>

                          <?php
                            $bonoscontado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = {$pedido['id_pedido']}");
                            $coleccionesContado = 0;
                            $varCont = 0;
                            foreach ($bonoscontado as $bono) {
                              if(!empty($bono['id_bonocontado'])){
                                $coleccionesContado += $bono['colecciones_bono'];
                              }
                            }
                            $varCont = $coleccionesContado * $pagosD['pago_precio_coleccion'];
                          ?>
                          <tr>
                            <td><b>(-)</b> Colecciones de Contado</td>
                            <td><?=$coleccionesContado?> Col.</td>
                            <td>X</td>
                            <td>$<?=$pagosD['pago_precio_coleccion']; ?></td>
                            <td>=</td>
                            <td><b>$<?=$varCont?></b></td>
                          </tr>
                          <?php
                            // $totalPagarPrimerPago = $acumuladosTotales[$key['id']]-$varCont;

                            $totalesPagosPagar[$key['id']] = $acumuladosTotales[$key['id']]-$varCont;
                          ?>
                          <tr style="border-top:1.02px solid #AAA;border-bottom:1.02px solid #AAA">
                            <td></td>
                            <td colspan="3"><b>Total real a Pagar de <?=mb_strtolower($key['name']); ?></b></td>
                            <td>=</td>
                            <td><b>$<?=$totalesPagosPagar[$key['id']]; ?></b></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                          <?php
                          }
                          $nIndx++;
                        }
                      }}
                    }
                  ?>
                  </div>

            </div>

            <!-- /.box-header -->
            
            <div class="box-body">


              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>

              <hr>


              <?php
                $montosPagos = [];
                $equivalenciasPagos = [];
                $equivalenciasAbonadasPagos = [];

                $reportadosPagos = [];
                $diferidosPagos = [];
                $abonadosPagos = [];
                $abonadosPagosPuntuales = [];

                $totalesPagos = [];
              ?>

              <?php foreach ($pagosRecorridos as $pagosR) { ?>
                <hr>
                <div class="box-header"  id="<?=$pagosR['id']; ?>">
                  <?php
                    $montosPagos[$pagosR['id']] = 0;
                    $equivalenciasPagos[$pagosR['id']] = 0;
                    $equivalenciasAbonadasPagos[$pagosR['id']] = 0;

                    $reportadosPagos[$pagosR['id']] = 0;
                    $diferidosPagos[$pagosR['id']] = 0;
                    $abonadosPagos[$pagosR['id']] = 0;
                    $abonadosPagosPuntuales[$pagosR['id']] = 0;

                    if($data['estado']=="Abonado"){
                      $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                      $abonadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                    } else if($data['estado']=="Diferido"){
                      $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                      $diferidosPagos[$pagosR['id']] += $data['equivalente_pago'];
                    }else{
                      $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                    }
                  ?>
                  <h3 class="box-title">
                    <?php echo "Abonos de ".$pagosR['name']; ?>
                    <?php if(!empty($_GET['Diferido'])){ echo "(Diferidos)"; } ?> 
                    <?php if(!empty($_GET['Abonado'])){ echo "(Abonados)"; } ?> 
                  </h3>
                  <br>
                </div>
                <div class="box" style="border-top:none;display:;">
                  <?php
                    $condicionEstado = 0;
                    $opcionEstado = "";
                    if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                      $condicionEstado = 1;
                      $opcionEstado = "Diferido";
                    }else if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Abonado"){
                      $condicionEstado = 1;
                      $opcionEstado = "Abonado";
                    }
                  ?>
                  <div class="box-body table-responsive">
                    <table id="" class="datatable1 table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                      <thead>
                        <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" ): ?>
                        <th>---</th>
                        <?php else: ?>
                        <th>---</th>
                        <?php endif; ?>
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th> 
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          $num = 1;
                          foreach ($pagos as $data){ if(!empty($data['id_pago'])){

                            
                              if(ucwords(mb_strtolower($data['tipo_pago']))==$pagosR['name']){ ?>
                                <?php
                                  if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){ if($data['estado']=="Diferido"){
                                    $montosPagos[$pagosR['id']] += $data['monto_pago'];
                                    $equivalenciasPagos[$pagosR['id']] += $data['equivalente_pago'];
                                  } } else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){ if($data['estado']=="Abonado"){
                                    $montosPagos[$pagosR['id']] += $data['monto_pago'];
                                    $equivalenciasPagos[$pagosR['id']] += $data['equivalente_pago'];
                                  } }else{
                                    $montosPagos[$pagosR['id']] += $data['monto_pago'];
                                    $equivalenciasPagos[$pagosR['id']] += $data['equivalente_pago'];
                                  }
                                  if($data['estado']=="Abonado"){ 
                                    $bgTablePago = "rgba(0,210,0,.5)";
                                    $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                                    $abonadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                                    if($data['fecha_pago'] <= $despacho['fecha_inicial_senior']){
                                      $equivalenciasAbonadasPagos[$pagosR['id']] += $data['equivalente_pago'];
                                    }
                                  }else if($data['estado']=="Diferido"){ 
                                    $bgTablePago = "rgba(210,0,0,.5)";
                                    $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                                    $diferidosPagos[$pagosR['id']] += $data['equivalente_pago'];
                                  }else{
                                    $bgTablePago = "";
                                    $reportadosPagos[$pagosR['id']] += $data['equivalente_pago'];
                                  }
                                  $mostrarRegistroPago = false;
                                  if($condicionEstado==0){
                                    $mostrarRegistroPago = true;
                                  } else if($condicionEstado==1){
                                    if(!empty($_GET['Diferido']) && $_GET['Diferido']==$opcionEstado){
                                      if($data['estado']==$opcionEstado){
                                        $mostrarRegistroPago = true;
                                      }
                                    } else if(!empty($_GET['Abonado']) && $_GET['Abonado']==$opcionEstado){
                                      if($data['estado']==$opcionEstado){
                                        $mostrarRegistroPago = true;
                                      }
                                    }
                                  }
                                  if($mostrarRegistroPago==true){
                                ?>
                                  <tr class='elementos_tr_<?=$pagosR['id']; ?>_<?=$data['id_pago']; ?> tr<?=$data['id_pago']?>' style="background:<?=$bgTablePago; ?>;">
                                    <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                      <td style="width:10%">
                                        <button class="btn modificarBtn " style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&admin=1">
                                          <span class="fa fa-wrench">
                                            
                                          </span>
                                        </button>

                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      </td>
                                    <?php else: ?>
                                      <td style="width:10%">
                                        <?php if($data['fecha_registro']==date('Y-m-d')){ ?>
                                              <?php if ($data['estado']!="Abonado"): ?>
                                              <button class="btn modificarBtn " style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                            <?php endif; ?>

                                        <?php } ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      </td>
                                    <?php endif; ?>


                                    <td style="width:5%">
                                      <span class="contenido2">
                                        <?php echo $num++; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo  $lider->formatFecha($data['fecha_pago']); ?>
                                        <br>
                                        <?php
                                          if(ucwords(mb_strtolower($data['tipo_pago']))==$pagosR['name']){
                                            $restriccion = $pagosR['fecha_pago'];
                                          }
                                          $temporalidad = "";
                                          if($data['fecha_pago'] <= $restriccion){
                                            $temporalidad = "Puntual";
                                            if($data['estado']=="Abonado"){
                                              $abonadosPagosPuntuales[$pagosR['id']] += $data['equivalente_pago'];
                                            }
                                          }else{
                                            $temporalidad = "Impuntual";
                                          }
                                        ?>
                                        <small><?=$temporalidad?></small>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <?php
                                        if($data['forma_pago']=="Transferencia Banco a Banco"){
                                          $forma_pago = "T-BB";
                                        } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                                          $forma_pago = "T-OB";
                                        } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                                          $forma_pago = "PM-BB";
                                        } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                                          $forma_pago = "PM-OB";
                                        }else{
                                          $forma_pago = $data['forma_pago'];
                                        }
                                      ?>
                                      <span class="contenido2">
                                        <?php echo  $forma_pago; ?>
                                      </span>
                                    </td>
                                    <td>
                                      <span class="contenido2">
                                        <?php foreach ($bancos as $bank): ?>
                                            <?php if (!empty($bank['id_banco'])): ?>
                                              <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                                <?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?>
                                              <?php endif ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                      </span>
                                    </td>
                                      
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['referencia_pago']; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],4,',','.'); }else{ echo ""; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['equivalente_pago']!=""){ echo "$".number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['tipo_pago']; ?>
                                      </span>
                                    </td>
                                  </tr>

                                <?php 
                                  }
                              }
                            ?> 
                          <?php } }
                        ?>
                      </tbody>

                      <tfoot>
                        <tr >
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style="padding:0;margin:0;"></th>
                          <?php endif; ?>
                          <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                        </tr>

                        <tr style="background:#CCC;">
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style='padding:0;margin:0;'></th>
                          <?php endif; ?>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'>
                            <h5><b>Premios<br><?=$pagosR['name']; ?>:</b></h5>
                          </th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($pagosR['name']=="Contado"){
                                $precio = $despacho['precio_coleccion'] - $pagosR['precio'];
                              }else{
                                $precio = $pagosR['precio'];
                              }

                              if( $abonadosPagos[$pagosR['id']] != 0){
                                $totalesPagos[$pagosR['id']] = $abonadosPagosPuntuales[$pagosR['id']] / $precio;
                              }else{
                                $totalesPagos[$pagosR['id']] = 0;
                              }

                              echo number_format($totalesPagos[$pagosR['id']],2,',','.'); 

                              // $precioInicial = $despacho['inicial_precio_coleccion'];
                              // if($equivalenciasAbonadasI!=0){
                              //   $totalIniciales = $equivalenciasAbonadasI / $precioInicial;
                              // }else{
                              //   $totalIniciales = 0;
                              // }
                              // echo number_format($totalIniciales,2,',','.'); 

                              //  $precioPrimerP = $despacho['primer_precio_coleccion'];
                              // if($equivalenciasAbonodasP1!=0){
                              //   $totalPrimer = $equivalenciasAbonodasP1 / $precioPrimerP;
                              // }else{
                              //   $totalPrimer = 0;
                              // }
                              // echo number_format($totalPrimer,2,',','.'); 



                            ?>
                            </b></h4>
                          </th>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                          <th style='padding:0;margin:0;'><h4><b><?=number_format($montosPagos[$pagosR['id']],2, ",",".")?></b></h4></th>
                          <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                          <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasPagos[$pagosR['id']],2, ",",".")?></b></h4></th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                              // echo $acumuladosTotales[$pagosR['id']];
                                  if(!empty($acumuladosTotales[$pagosR['id']])){

                                    if($acumuladosTotales[$pagosR['id']] != 0){
                                      $porcentajeDePago[$pagosR['id']] = ($abonadosPagos[$pagosR['id']] * 100) / $totalesPagosPagar[$pagosR['id']];
                                    }else{
                                      $porcentajeDePago[$pagosR['id']] = 0;
                                    }
                                    echo number_format($porcentajeDePago[$pagosR['id']],2,',','.')."%";

                                  }else{
                                    if($nuevoTotal!=0){
                                      $porcentajeRestanteFinal = ($abonado*100)/$nuevoTotal;
                                    }else{
                                      $porcentajeRestanteFinal = 0;
                                    }
                                    echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                  }
                              }
                            ?>
                            </b></h4>
                          </th>
                          <th style='padding:0;margin:0;'></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta;?>">
                        <b style="color:#000 !important">Reportado de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadosPagos[$pagosR['id']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                        <b style="color:#000 !important">Diferido de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidosPagos[$pagosR['id']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadosPagos[$pagosR['id']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                  </div>
                  <br>
                </div>
              <?php } ?>

              <div class="box-header">
                <?php
                  $montosT = 0;
                  $equivalenciasT = 0;
                  foreach ($pagosRecorridos as $pagosR) {
                    $montosT += $montosPagos[$pagosR['id']];
                    $equivalenciasT += $equivalenciasPagos[$pagosR['id']];
                  }
                ?>
                <h3 class="box-title"><?php echo "Total"; ?></h3>
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                    <thead>
                    
                    </thead>
                    <tbody>
                    
                      <tr>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%">
                            <h4>Porcentaje: </h4>
                        </td>
                        <td style="width:8.5%">
                          <h4>
                            <b>
                              <?php 
                                  // echo $nuevoTotal;
                                  if($nuevoTotal!=0){
                                    $porcentajeDeSegundoPago = ($abonado*100)/$nuevoTotal;
                                  }else{
                                    $porcentajeDeSegundoPago = 0;
                                  }
                                  echo number_format($porcentajeDeSegundoPago,2,',','.')."%";
                              ?>
                            </b>
                          </h4>
                        </td>
                        <td><h4>Monto: </h4></td>
                        <td><h4><b><?=number_format($montosT,2, ",",".")?></b></h4></td>


                        <?php if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){ ?>
                            <td><h4 style="color:#DD0000">Total: </h4></td>
                            <td><h4><b style="color:#DD0000">$<?=number_format($nuevoTotal,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){ ?>
                            <td><h4 style="color:#00DD00">Total: </h4></td>
                            <td><h4><b style="color:#00DD00">$<?=number_format($nuevoTotal,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($nuevoTotal,2, ",",".")?></b></h4></td>
                        <?php } else{ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($nuevoTotal,2, ",",".")?></b></h4></td>
                        <?php } ?>


                        <td><h4 style="color:#DD0000">Resta: </h4></td>
                        <td><h4><b style="color:#DD0000">$<?=number_format($nuevoTotal-$abonado,2, ",",".")?></b></h4></td>
                      </tr>
                    </tbody>
                    <tfoot>
                    
                    </tfoot>
                  </table>
                </div>
              </div>

              <hr>

              <?php foreach ($promociones as $promos){ if(!empty($promos['id_promocion'])){ ?>
                <hr>
                <div class="box-header">
                  <?php
                    $montosPagos[$promos['id_promocion']] = 0;
                    $equivalenciasPagos[$promos['id_promocion']] = 0;
                    $equivalenciasAbonadasPagos[$promos['id_promocion']] = 0;

                    $reportadosPagos[$promos['id_promocion']] = 0;
                    $diferidosPagos[$promos['id_promocion']] = 0;
                    $abonadosPagos[$promos['id_promocion']] = 0;
                    $abonadosPagosPuntuales[$promos['id_promocion']] = 0;

                    if($data['estado']=="Abonado"){
                      $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                      $abonadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                    } else if($data['estado']=="Diferido"){
                      $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                      $diferidosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                    }else{
                      $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                    }
                  ?>
                  <h3 class="box-title">
                    <?php echo "Abonos de ".$promos['nombre_promocion']; ?>
                    <?php if(!empty($_GET['Diferido'])){ echo "(Diferidos)"; } ?> 
                    <?php if(!empty($_GET['Abonado'])){ echo "(Abonados)"; } ?> 
                  </h3>
                  <br>
                </div>
                <div class="box" style="border-top:none;display:;">
                  <?php
                    $condicionEstado = 0;
                    $opcionEstado = "";
                    if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                      $condicionEstado = 1;
                      $opcionEstado = "Diferido";
                    }else if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Abonado"){
                      $condicionEstado = 1;
                      $opcionEstado = "Abonado";
                    }
                  ?>
                  <div class="box-body table-responsive">
                    <table id="" class="datatable1 table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                      <thead>
                        <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" ): ?>
                        <th>---</th>
                        <?php else: ?>
                        <th>---</th>
                        <?php endif; ?>
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th> 
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          $num = 1;
                          foreach ($pagos as $data){ if(!empty($data['id_pago'])){

                            
                              if(ucwords(mb_strtolower($data['tipo_pago']))==$promos['nombre_promocion']){ ?>
                                <?php
                                  if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){ if($data['estado']=="Diferido"){
                                    $montosPagos[$promos['id_promocion']] += $data['monto_pago'];
                                    $equivalenciasPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                  } } else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){ if($data['estado']=="Abonado"){
                                    $montosPagos[$promos['id_promocion']] += $data['monto_pago'];
                                    $equivalenciasPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                  } }else{
                                    $montosPagos[$promos['id_promocion']] += $data['monto_pago'];
                                    $equivalenciasPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                  }
                                  if($data['estado']=="Abonado"){ 
                                    $bgTablePago = "rgba(0,210,0,.5)";
                                    $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                    $abonadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                    if($data['fecha_pago'] <= $despacho['fecha_inicial_senior']){
                                      $equivalenciasAbonadasPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                    }
                                  }else if($data['estado']=="Diferido"){ 
                                    $bgTablePago = "rgba(210,0,0,.5)";
                                    $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                    $diferidosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                  }else{
                                    $bgTablePago = "";
                                    $reportadosPagos[$promos['id_promocion']] += $data['equivalente_pago'];
                                  }
                                  $mostrarRegistroPago = false;
                                  if($condicionEstado==0){
                                    $mostrarRegistroPago = true;
                                  } else if($condicionEstado==1){
                                    if(!empty($_GET['Diferido']) && $_GET['Diferido']==$opcionEstado){
                                      if($data['estado']==$opcionEstado){
                                        $mostrarRegistroPago = true;
                                      }
                                    } else if(!empty($_GET['Abonado']) && $_GET['Abonado']==$opcionEstado){
                                      if($data['estado']==$opcionEstado){
                                        $mostrarRegistroPago = true;
                                      }
                                    }
                                  }
                                  if($mostrarRegistroPago==true){
                                ?>
                                  <tr class='elementos_tr_<?=$promos['id_promocion']; ?>_<?=$data['id_pago']; ?> tr<?=$data['id_pago']?>' style="background:<?=$bgTablePago; ?>;">
                                    <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                      <td style="width:10%">
                                        <button class="btn modificarBtn " style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&admin=1">
                                          <span class="fa fa-wrench">
                                            
                                          </span>
                                        </button>

                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      </td>
                                    <?php else: ?>
                                      <td style="width:10%">
                                        <?php if($data['fecha_registro']==date('Y-m-d')){ ?>
                                              <?php if ($data['estado']!="Abonado"): ?>
                                              <button class="btn modificarBtn " style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                            <?php endif; ?>

                                        <?php } ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      </td>
                                    <?php endif; ?>


                                    <td style="width:5%">
                                      <span class="contenido2">
                                        <?php echo $num++; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo  $lider->formatFecha($data['fecha_pago']); ?>
                                        <br>
                                        <?php
                                          if(ucwords(mb_strtolower($data['tipo_pago']))==$promos['nombre_promocion']){
                                            if(!empty($fechasPromociones['fecha_pago_promocion'])){
                                              $restriccion = $fechasPromociones['fecha_pago_promocion'];
                                            }
                                            // $restriccion = $promos['fecha_cierre_promocion'];
                                          }
                                          $temporalidad = "";
                                          if($data['fecha_pago'] <= $restriccion){
                                            $temporalidad = "Puntual";
                                            if($data['estado']=="Abonado"){
                                              $abonadosPagosPuntuales[$promos['id_promocion']] += $data['equivalente_pago'];
                                            }
                                          }else{
                                            $temporalidad = "Impuntual";
                                          }
                                        ?>
                                        <small><?=$temporalidad?></small>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <?php
                                        if($data['forma_pago']=="Transferencia Banco a Banco"){
                                          $forma_pago = "T-BB";
                                        } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                                          $forma_pago = "T-OB";
                                        } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                                          $forma_pago = "PM-BB";
                                        } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                                          $forma_pago = "PM-OB";
                                        }else{
                                          $forma_pago = $data['forma_pago'];
                                        }
                                      ?>
                                      <span class="contenido2">
                                        <?php echo  $forma_pago; ?>
                                      </span>
                                    </td>
                                    <td>
                                      <span class="contenido2">
                                        <?php foreach ($bancos as $bank): ?>
                                            <?php if (!empty($bank['id_banco'])): ?>
                                              <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                                <?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?>
                                              <?php endif ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                      </span>
                                    </td>
                                      
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['referencia_pago']; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],4,',','.'); }else{ echo ""; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php if($data['equivalente_pago']!=""){ echo "$".number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php echo $data['tipo_pago']; ?>
                                      </span>
                                    </td>
                                  </tr>

                                <?php 
                                  }
                              }
                            ?> 
                          <?php } }
                        ?>
                      </tbody>

                      <tfoot>
                        <tr >
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style="padding:0;margin:0;"></th>
                          <?php endif; ?>
                          <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                          <th style="padding:0;margin:0;"></th>
                        </tr>

                        <tr style="background:#CCC;">
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style='padding:0;margin:0;'></th>
                          <?php endif; ?>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'>
                            <h5><b>Premios<br><?=$promos['nombre_promocion']; ?>:</b></h5>
                          </th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($promos['nombre_promocion']=="Contado"){
                                $precio = $despacho['precio_coleccion'] - $promos['precio'];
                              }else{
                                $precio = $promos['precio_promocion'];
                              }

                              if( $abonadosPagos[$promos['id_promocion']] != 0){
                                $totalesPagos[$promos['id_promocion']] = $abonadosPagos[$promos['id_promocion']] / $precio;
                              }else{
                                $totalesPagos[$promos['id_promocion']] = 0;
                              }
                              echo number_format($totalesPagos[$promos['id_promocion']],2,',','.'); 

                              // $precioInicial = $despacho['inicial_precio_coleccion'];
                              // if($equivalenciasAbonadasI!=0){
                              //   $totalIniciales = $equivalenciasAbonadasI / $precioInicial;
                              // }else{
                              //   $totalIniciales = 0;
                              // }
                              // echo number_format($totalIniciales,2,',','.'); 

                              //  $precioPrimerP = $despacho['primer_precio_coleccion'];
                              // if($equivalenciasAbonodasP1!=0){
                              //   $totalPrimer = $equivalenciasAbonodasP1 / $precioPrimerP;
                              // }else{
                              //   $totalPrimer = 0;
                              // }
                              // echo number_format($totalPrimer,2,',','.'); 



                            ?>
                            </b></h4>
                          </th>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                          <th style='padding:0;margin:0;'><h4><b><?=number_format($montosPagos[$promos['id_promocion']],2, ",",".")?></b></h4></th>
                          <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                          <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasPagos[$promos['id_promocion']],2, ",",".")?></b></h4></th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($promos['nombre_promocion']!="Contado" && $promos['nombre_promocion']!="Inicial"){
                              // echo $acumuladosTotales[$promos['id_promocion']];
                                $totalPorPromo[$promos['id_promocion']] = $promos['precio_promocion']*$promos['cantidad_aprobada_promocion'];
                                    if($totalPorPromo[$promos['id_promocion']]!=0){
                                      $porcentajeRestanteFinal = ($abonadosPagos[$promos['id_promocion']]*100)/$totalPorPromo[$promos['id_promocion']];
                                    }else{
                                      $porcentajeRestanteFinal = 0;
                                    }
                                    echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                  
                              }
                            ?>
                            </b></h4>
                          </th>
                          <th style='padding:0;margin:0;'></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta;?>">
                        <b style="color:#000 !important">Reportado de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                        <b style="color:#000 !important">Diferido de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                  </div>
                  <br>
                </div>
              <?php } } ?>

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$url."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

              <!-- <br> -->

                            <!-- <input type="color" name=""> -->
          <?php 
            // $color[0] = "rgb(14, 216, 27)";
            // $color[1] = "rgb(216, 14, 152)";
            // $color[2] = "rgb(105, 14, 216)";
            // $color[3] = "rgb(194, 169, 46)";
            // $color[4] = "rgb(185, 182, 167)";
            // $color[5] = "rgb(140, 218, 238)";
            // $num = 0;
            // foreach ($liderazgos as $data):
            //   if(!empty($data['id_liderazgo'])):
          ?>
              <!-- <div style="border:1px solid #000;background: <?php echo $color[$num] ?>; width: <?php echo ($data['total_descuento'] * 30)."px" ?>; padding:10px;margin-left:5%;"> -->
                <?php 
                  // echo "Líder <b>".$data['nombre_liderazgo']."</b>"; 
                  // echo "<br>";
                  // if($data['maxima_cantidad'] == ""){
                  //   echo "<b>".$data['minima_cantidad']." o más</b>";
                  // }else{
                  //   echo "<b>".$data['minima_cantidad']." - ".$data['maxima_cantidad']."</b>";
                  // }
                  // echo "<br>";
                  // echo "Colecciones";
                ?>    
              <!-- </div> -->
              <?php //$num++; ?>
         <?php //endif; endforeach;?>

            <!-- <br><br> -->




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

    <div class="box-modalFichaDetalle  " style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalFichaDetalle" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <!-- <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3> -->
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>
                  <br>
                  <div class="box-body" style="padding-left:20px;padding-right:20px;">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_fecha"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_tasa"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_forma"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_banco"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_referencia"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_concepto"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_monto"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_equivalente"></span>
                      </div>
                    </div>
                  </div>
                  <br>
                    <!-- <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" name="rol" value="Conciliador">
                    <input type="hidden" class="id_pago_modal" name="id_pago_modal"> -->
       

                  <!-- <div class="container">
                    <span class="text-ficha-detalle"></span>
                  </div> -->
                  <!-- <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalFichaDetalle  ">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalConciliador   d-none" disabled="" >enviar</button>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.expandAccess{
  background:<?=$fucsia; ?>;color:#FFF;margin-top:-2px;
}
.enlaceOpen:hover{
  text-decoration:underline;
  cursor:pointer;
}
</style>
  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<?php endif; ?>
<script>
$(document).ready(function(){ 
  $("#enlaceAccess").hide();
    $("#enlaceAccess").removeClass("d-none");
    $(".expandAccess").click(function(){
      var clas = $("#idExpandAccess").attr("class");
      if(clas=="fa fa-chevron-circle-left"){
        $("#idExpandAccess").removeClass("fa-chevron-circle-left");
        $("#idExpandAccess").addClass("fa-chevron-circle-right");
        $("#enlaceAccess").show(300);
        $(this).attr("style", "margin-left:2px;border-left:1px solid #FFF");
      }
      if(clas=="fa fa-chevron-circle-right"){
        $("#idExpandAccess").removeClass("fa-chevron-circle-right");
        $("#idExpandAccess").addClass("fa-chevron-circle-left");
        $("#enlaceAccess").hide(300);
        $(this).attr("style", "border-left:none;");
      }
    });
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=MisPagos";
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

  $(".btnFichaDetalle").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        // alert(response);
        var json = JSON.parse(response);
        var data = json['pedido'];
        var banco = {};
        if(json['exec_banco']){
          banco = json['banco'];
        }
        console.log(data);
        if(data['fotoPerfil']==""||data['fotoPerfil']==null){
          var foto = "";
          if(data['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data['fotoPerfil']);
        }
        $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);

        var estado = "Reportado";
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:#0000AAAA;");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:#AA0000AA;");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:#00AA00AA;");
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
        }



        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);
        $(".ficha_detalle_fecha").html("<i><b>Fecha: </b></i>"+dia+"/"+mes+"/"+year);
        if(data['tasa_pago']!=null){
          $(".ficha_detalle_tasa").html("<i><b>Tasa: </b></i>Bs. "+data['tasa_pago']);
        }else{
          $(".ficha_detalle_tasa").html("");          
        }
        $(".ficha_detalle_forma").html(data['forma_pago']);
        if(json['exec_banco']){
          $(".ficha_detalle_banco").html("Banco "+banco['nombre_banco']+" <small>("+banco['nombre_propietario']+")</small>");
        }else{
          $(".ficha_detalle_banco").html("");
        }
        if(data['referencia_pago']!=null){
          $(".ficha_detalle_referencia").html("<i><b>Ref.</b></i> "+data['referencia_pago']);
        }else{
          $(".ficha_detalle_referencia").html("");          
        }
        $(".ficha_detalle_concepto").html("<i><b>Concepto: </b></i>"+data['tipo_pago']);
        if(data['monto_pago']!=null){
          $.ajax({
            url:'',
            type:"POST",
            data:{
              val: data['monto_pago'],
              formatNumber: true, 
            },
            success: function(monto){
              $(".ficha_detalle_monto").html("<i><b>Monto = </b></i> Bs. "+monto);
            }
          });
        }else{
          $(".ficha_detalle_monto").html("");          
        }
        if(data['equivalente_pago']!=null){
          $.ajax({
            url:'',
            type:"POST",
            data:{
              val: data['equivalente_pago'],
              formatNumber: true, 
            },
            success: function(equivalente){
              // $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> $"+data['equivalente_pago']);
              if(data['forma_pago']=="Divisas Euros"){
                $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> €"+equivalente);
              }else{
                $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> $"+equivalente);
              }
            }
          });
        }else{
          $(".ficha_detalle_equivalente").html("");          
        }

        $(".box-modalFichaDetalle").fadeIn(500);
      }
    });
  });
  $(".cerrarModalFichaDetalle").click(function(){
    $(".box-modalFichaDetalle").fadeOut(500);
  });


  $(".editarBtn").click(function(){
    var id = $(this).val();
    $(".box-modalEditar").show();

  });

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
});  
</script>
</body>
</html>
