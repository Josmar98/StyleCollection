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
        <?php 
          echo "Estado de cuentas - Campaña ".$numero_campana."/".$anio_campana;
        ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li> -->
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "EstadoCuentas" ?>"><?php echo "Estado de Cuentas"; ?></a></li>
        <li class="active"><?php echo "Estado de Cuentas"; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"): ?>
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        </div>
        <?php endif; ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>
        
      <div class="row">
        <!-- /.col -->
        <div class=" col-md-12">
          <div class="box nav-tabs-custom">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                  <!-- <a href="?<?=$menu?>&route=Homing2" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                    <i class="fa fa-arrow-left" style="font-size:2em"></i>
                  </a> -->

              <?php
                $gemasCanjeadasCliente = 0;
                $canjeoGemasCliente = 0;
                $gemasAdquiridasNombramientoCliente = 0;
                $gemasObsequiosAdquiridoCliente = 0;

                $gemasAdquiridasBloqueadasCliente = 0;
                $gemasAdquiridasDisponiblesCliente = 0;
                $gemasAdquiridasFacturaCliente = 0;
                $gemasAdquiridasFacturaClienteBloqueadasCliente = 0;
                $gemasAdquiridasFacturaClienteDisponiblesCliente = 0;
                $gemasAdquiridasBonosCliente = 0;
                $gemasBonosCliente = 0;
                // $id_cliente_personal_cliente = $pedido['id_cliente'];

                $canjeosPersonalesCliente = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1");
                foreach ($canjeosPersonalesCliente as $canje) {
                  if(!empty($canje['cantidad_gemas'])){
                    $gemasCanjeadasCliente += $canje['cantidad_gemas'];
                  }
                }
                $canjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE canjeos_gemas.estatus = 1");
                foreach ($canjeosGemasCliente as $canje) {
                  if(!empty($canje['cantidad'])){
                    $canjeoGemasCliente += $canje['cantidad'];
                  }
                }
                $nombramientoAdquiridoCliente = $lider->consultarQuery("SELECT * FROM nombramientos WHERE estatus = 1");
                foreach ($nombramientoAdquiridoCliente as $data) {
                  if(!empty($data['id_nombramiento'])){
                    $gemasAdquiridasNombramientoCliente += $data['cantidad_gemas'];
                  }
                }
                $obsequiosAdquiridoCliente = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE estatus = 1");
                foreach ($obsequiosAdquiridoCliente as $data) {
                  if(!empty($data['id_obsequio_gema'])){
                    $gemasObsequiosAdquiridoCliente += $data['cantidad_gemas'];
                  }
                }

                $gemasAdquiridasCliente = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1");
                foreach ($gemasAdquiridasCliente as $data) {
                  if(!empty($data['id_gema'])){
                    $gemasBonosCliente += $data['cantidad_gemas'];
                    if($data['estado']=="Bloqueado"){
                      $gemasAdquiridasBloqueadasCliente += $data['inactivas'];
                    }
                    if($data['estado']=="Disponible"){
                      $gemasAdquiridasDisponiblesCliente += $data['activas'];
                    }

                    if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
                      $gemasAdquiridasFacturaCliente += $data['cantidad_gemas'];
                      if($data['estado']=="Bloqueado"){
                        $gemasAdquiridasFacturaClienteBloqueadasCliente += $data['inactivas'];
                      }
                      if($data['estado']=="Disponible"){
                        $gemasAdquiridasFacturaClienteDisponiblesCliente += $data['activas'];
                      }
                    }
                    if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
                      $gemasAdquiridasBonosCliente += $data['activas'];
                    }
                  }
                }

                $fotoGema = "public/assets/img/gemas/gema1.1.png";
                $fotoGemaBloqueadas = "public/assets/img/gemas/gema1.2.png";
                
                $cantidad_gemas_liquidadas = 0;
                $gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM despachos, pedidos, descuentos_gemas WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = descuentos_gemas.id_pedido and pedidos.estatus = 1 and despachos.estatus = 1 and descuentos_gemas.estatus = 1");
                if(count($gemas_liquidadas_disponibles)>1){
                  foreach ($gemas_liquidadas_disponibles as $liquidacionGemas) {
                    $cantidad_gemas_liquidadas += $liquidacionGemas['cantidad_descuento_gemas'];
                  }
                }
                $gemasAdquiridasDisponiblesCliente += $gemasAdquiridasNombramientoCliente;
                $gemasAdquiridasDisponiblesCliente += $gemasObsequiosAdquiridoCliente;

                $gemasAdquiridasDisponiblesCliente -= $gemasCanjeadasCliente;
                $gemasAdquiridasDisponiblesCliente -= $cantidad_gemas_liquidadas;
                $gemasAdquiridasDisponiblesCliente -= $canjeoGemasCliente;
                
              ?> 


              <!-- <div class="row" style="background:<?=$color_liderazgo?>33;border-radius:50%;text-align:right;margin-right:5%;margin-bottom:-3%;display:inline-block;float:right;padding:5px 20px 20px 20px;">
                <div style="text-align:center;width:100%;color:#FFF;text-shadow:0px 0px 3px #000;">Gemas</div>
                <div style="display:inline-block;">
                  <span style="text-align:left;">
                      <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-right:50px;"><small>Disponibles</small></span>
                      <br>
                      <div class="" style="background:#FFF;border-radius:100%;display:inline-block;rotate:50;">
                        <img style="width:70px;padding:0;margin:0;position:relative;left:-10px;top:3px;" src="<?=$fotoGema?>">
                        <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px">
                          <b style="font-size:1.5em">
                          <?php 
                            echo number_format($gemasAdquiridasDisponiblesCliente,2,',','.'); 
                          ?>
                          </b>
                        </span>
                      </div>
                  </span>
                </div>
                <div style="display:inline-block;">
                  <span style="text-align:right;">
                      <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-left:30px"><small>Bloqueadas</small></span>
                      <br>
                      <div class="" style="background:#FFF;border-radius:100%;display:inline-block;">
                        <img style="width:30px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>">
                        <span style="color:#00000055;position:relative;top:3px;left:-12px">
                          <b style="font-size:1em">
                          <?php 
                            echo number_format($gemasAdquiridasBloqueadasCliente,2,',','.'); 
                          ?>
                          </b>
                        </span>
                      </div>
                  </span>
                </div>
                
              </div>
              <div style="clear:both;"></div> -->
              
                <div class="post" style="padding:10px">
                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                        <b style="color:#000 !important">Reportado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado,2, ",",".")?></b></h4>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                        <b style="color:#000 !important">Diferido</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido,2, ",",".")?></b></h4>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                        <b style="color:#000 !important">Abonado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado,2, ",",".")?></b></h4>
                    </div>
                  </div>

                  <div class="" style="background:<?=$color_liderazgo?>33;border:1px solid #EFEFEF;color:#444;width:100%;padding:15px 30px 0px 30px;border-radius:5px">
                    <div class="box-header">
                      <div class="container" style="width:100%;margin-top:0px;">

                        <div class="row">
                            <div class="col-md-8 text-left">
                              <br>
                              <table>
                              <?php

                                $totalesCostos = [];
                                $precio_coleccion = 0;
                                foreach ($totalesDeudas as $key) {
                                  $totalesCostos[$key['numero_pedido']]['precioCol'] = 0;
                                  $precioColAct = $key['precio_coleccion'];
                                  $cantidad_colecciones = $key['cantidad_aprobado_individual'];
                                  $precioColGen = ($precioColAct*$cantidad_colecciones);
                                  // $precioColeccion+=$precioColAct;
                                  $precio_coleccion+=$precioColGen;
                                  $totalesCostos[$key['numero_pedido']]['precioCol']+=$precioColGen;
                                  ?>
                                  <tr>
                                    <td colspan="2">
                                      <span style="font-size:1em;color:#000;"><b>Precio Colección Pedido <?=$key['numero_pedido']; ?>: </b></span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <b>Productos: </b>
                                    </td>
                                    <td>
                                      
                                  <b><span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php if(!empty($precioColAct)){ echo "$".number_format($precioColAct,2,',','.'); } ?></span> * <?php echo "(".$cantidad_colecciones.") = "; ?> <span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php echo "$".number_format($precioColGen,2,',','.'); ?></span></b><br>
                                    </td>
                                  </tr>
                                  <!-- <span style="font-size:1.2em;color:#0C0;"><b><?php if(!empty($precioColAct)){ echo number_format($precioColAct,2,',','.'); } ?>$</b></span> -->


                                  <br>
                                  <?php
                                  $pedidosSecund = $lider->consultarQuery("SELECT * FROM pedidos_secundarios as pedSec, despachos_secundarios as desSec WHERE pedSec.id_despacho_sec=desSec.id_despacho_sec and pedSec.estatus=1 and desSec.id_despacho = {$key['id_despacho']}");
                                  // print_r($pedidosSecund);
                                    foreach ($pedidosSecund as $pedSec) {
                                      if(!empty($pedSec['id_pedido_sec'])){
                                        $precioColeccionSec = $pedSec['precio_coleccion_sec'];
                                        $cantColeccionSec = $pedSec['cantidad_aprobado_sec'];
                                        $precioColGen = ($precioColeccionSec*$cantColeccionSec);
                                        $precio_coleccion+=$precioColGen;
                                        $totalesCostos[$key['numero_pedido']]['precioCol']+=$precioColGen;
                                        ?>
                                        <tr>
                                          <td>
                                            <b><?=$pedSec['nombre_coleccion_sec'] ?>: </b>
                                          </td>
                                          <td>
                                            <b><span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php if(!empty($precioColeccionSec)){ echo "$".number_format($precioColeccionSec,2,',','.'); } ?></span> * <?php echo "(".$cantColeccionSec.") = "; ?> <span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php echo "$".number_format($precioColGen,2,',','.'); ?></span></b><br>
                                            <!-- <span style="font-size:1.2em;color:#0C0;margin-left:5px;"><b><?php if(!empty($precioColeccionSec)){ echo "$".number_format($precioColeccionSec,2,',','.'); } ?> * <?php echo "(".$cantColeccionSec.") = "."$".number_format($precioColGen,2,',','.'); ?></b></span><br> -->
                                          </td>
                                        </tr>
                                      <?php
                                      }
                                    }
                                  // $clientesPedidosS = $lider->consultarQuery($query);
                                  // foreach ($clientesPedidosS as $pedidoCol) {
                                    // if(!empty($pedidoCol['id_pedido'])){
                                    // }
                                  // }

                                }
                              ?>
                              <tr>
                                <td colspan="2">
                                  <span style="font-size:1.2em;color:#000;"><b>Precio Colección Total: </b></span>
                                  <span style="font-size:1.4em;color:#0C0;"><b><?php if(!empty($precio_coleccion)){ echo number_format($precio_coleccion,2,',','.'); } ?>$</b></span>
                                </td>
                              </tr>
                              </table>

                            </div>

                            <!-- <div class="col-md-4 text-left"> -->
                              <!-- <span style="font-size:1.1em;color:#000;"><b>Colecciones aprobadas: </b></span> -->
                              <!-- <span style="font-size:1.3em;color:#7C4;"><b><?php echo $cantidad_aprobado ?></b></span> -->
                            <!-- </div> -->

                            <div class="col-md-4 text-right">
                              <?php
                                $total = 0;
                                foreach ($totalesDeudas as $key) {
                                  $precioColAct = $key['precio_coleccion'];
                                  $cantidad_colecciones_act = $key['cantidad_aprobado'];
                                  $total+=$cantidad_colecciones_act;
                                  ?>
                                  <span style="font-size:1em;color:#000;"><b>Colecciones Pedido <?=$key['numero_pedido']; ?>: </b></span>

                                  <span style="font-size:1em;color:;"><b><?php echo $cantidad_colecciones_act ?></b></span>
                                  <br>
                                  <?php
                                }
                              ?>
                              <span style="font-size:1.1em;color:#000;"><b>Colecciones totales: </b></span>
                              <span style="font-size:1.1em;color:;"><b><?php echo $total; ?></b></span>
                              <?php $cantidad_aprobado = $total; ?>
                            </div>
                        </div>

                      </div>
                    </div>


                    <!-- <div class="row" style="border-radius:50%;text-align:right;margin-bottom:-3%;display:inline-block;float:right;padding:5px 20px 20px 20px;">
                      <div style="text-align:center;width:100%;color:#FFF;text-shadow:0px 0px 3px #000;"><b>Gemas</b></div>
                      <div style="display:inline-block;">
                        <span style="text-align:left;">
                            <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-right:50px;"><small><b>Disponibles</b></small></span>
                            <br>
                            <div class="" style="background:#FFF;border-radius:100px;display:inline-block;rotate:50;">
                              <img style="width:70px;padding:0;margin:0;position:relative;left:-10px;top:3px;" src="<?=$fotoGema?>">
                              <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px">
                                <b style="font-size:1.5em">
                                <?php  
                                  echo number_format($gemasAdquiridasDisponiblesCliente,2,',','.'); 
                                ?>
                                </b>
                              </span>
                            </div>
                        </span>
                      </div>
                      <div style="display:inline-block;">
                        <span style="text-align:right;">
                            <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-left:30px"><small><b>Bloqueadas</b></small></span>
                            <br>
                            <div class="" style="background:#FFF;border-radius:100px;display:inline-block;">
                              <img style="width:30px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>">
                              <span style="color:#00000055;position:relative;top:3px;left:-12px">
                                <b style="font-size:1em">
                                <?php 
                                  echo number_format($gemasAdquiridasBloqueadasCliente,2,',','.'); 
                                ?>
                                </b>
                              </span>
                            </div>
                        </span>
                      </div>
                    </div> -->
                    <div style="clear:both;"></div>
                    <?php
                      if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
                          ?>
                        <!-- <div class="row" style="text-align:center;">
                          <div class="hidden-xs hidden-sm col-md-4"></div>
                          <div class="hidden-xs hidden-sm col-md-4"></div>
                          <div class="col-md-4">
                            <br>
                            <style>.descontarGemasModal:hover{cursor:pointer;}</style>
                            <?php if (count($precio_gema)>1): ?>
                            <a class="descontarGemasModal"><b><u>Liquidación de Gemas</u></b></a>
                            <?php endif; ?>
                          </div>
                        </div> -->
                          <?php
                      }
                    ?>
                    <?php 
                      if (count($precio_gema)>1){
                        $precio_gema = $precio_gema[0]['precio_gema'];
                      }
                    ?>



                    <hr>
                    <div class="box-body">
                      <div class="container text-center" style="width:100%;">
                          <div class="row">
                            <div class="col-md-4 ">
                              <span style="font-size:1.1em;color:#000;"><b>Líder</b></span>
                              <br>
                              <span style="font-size:1.8em;color:<?php echo $color_btn_sweetalert ?>">
                                <img src="public/assets/img/liderazgos/<?=$nombre_liderazgo?>logo.png" style="width:40px;">        
                                <img src="public/assets/img/liderazgos/<?=$nombre_liderazgo?>txt.png" style="width:80px;">  
                              </span>
                            </div>

                            <div class="col-md-3">
                              <?php
                                $total_costo = 0;
                                foreach ($totalesCostos as $key) {
                                  // $precioColAct = $key['precio_coleccion'];
                                  // $cantidad_colecciones_act = $key['cantidad_aprobado'];
                                  // $resulCosto = ($precioColAct * $cantidad_colecciones_act);
                                  $resulCosto = $key['precioCol'];
                                  // $total_costo+=$key['precioCol'];
                                  $total_costo+=$resulCosto;
                                  ?>
                                  <span style="font-size:1.1em;color:#000;"><b>Costo: </b></span>
                                  <span style="font-size:1.1em;color:;"><b>$<?php echo number_format($resulCosto,2,',','.'); ?></b></span>
                                  <br>
                                  <?php
                                }
                              ?>
                              <span style="font-size:1.1em;color:#000;"><b>Total Costo</b></span>    
                                <br>
                              <span style="font-size:1.5em;">
                                <u><b>$<?php echo number_format($total_costo,2,',','.'); ?></b></u>
                              </span>
                            </div>

                            <div class="col-md-5">
                              <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">
                              <?php
                                $gemasDisponibles = $lider->consultarQuery("SELECT * FROM gemas WHERE id_campana={$id_campana}");
                                $sumatoriaGemasOtorgada=0;
                                $sumatoriaGemasDisponibles=0;
                                $sumatoriaGemasBloqueadas=0;
                                foreach ($gemasDisponibles as $gemaDis) {
                                  if(!empty($gemaDis)){
                                    $sumatoriaGemasOtorgada+=$gemaDis['cantidad_gemas'];
                                    $sumatoriaGemasDisponibles+=$gemaDis['activas'];
                                    $sumatoriaGemasBloqueadas+=$gemaDis['inactivas'];
                                  }
                                }
                                // echo " | ".$sumatoriaGemasOtorgada." | ".
                                //            $sumatoriaGemasDisponibles." | ".
                                //            $sumatoriaGemasBloqueadas." | ";
                                $configGemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE id_configgema=1");
                                foreach ($configGemas as $conffig) {
                                  if(!empty($conffig['id_configgema'])){
                                    $cantidadGemasCorrespondiente = $conffig['cantidad_correspondiente'];
                                    $totalDescuentoEnGemas=0;
                                    $resultt=($cantidad_aprobado/$cantidadGemasCorrespondiente);
                                  ?>
                                  <span style="font-size:1.1em;color:#000;"><b>Cantidad de Gemas</b></span>
                                  <br>
                                  <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                    <tbody>
                                      <tr>
                                        <td><b>Gemas Otorgadas</b></td>
                                        <td><b style="color:#ED2A77;"><?php echo $cantidad_aprobado; ?> <small>Col.</small></b></td>
                                        <td><?php echo " / "; ?></td>
                                        <td><b> <?php echo "$".number_format($cantidadGemasCorrespondiente,2,',','.'); ?></b></td>
                                        <td><?php echo " = "; ?></td>
                                        <td><b style="color:#0c0;">
                                          <?php $totalDescuentoEnGemas+=$resultt; ?>
                                          <?php echo "$".number_format($resultt,2,',','.'); ?>
                                        </b></td>
                                      </tr>
                                      <tr>
                                        <td colspan="7" style="border-bottom:1px solid #777"></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2">
                                          <span style="font-size:1.2em">
                                            <b>Total</b>
                                          </span>
                                        </td>
                                        <td> 
                                          <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                            <b>=</b>
                                          </span> 
                                        </td>
                                        <td colspan="">
                                          <span style="font-size:1.5em;color:#00C">
                                            <b>$<?php echo number_format($totalDescuentoEnGemas,2,',','.') ?></b>
                                          </span>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                              <?php                         
                                  }
                                }
                              ?>
                              </div>
                            </div>
                          </div>

                          <br>

                          <div class="row">
                              <!-- <input type="color" name=""> -->
                            <div class="col-xs-12 col-md-7" style="margin-bottom:20px;">
                              <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">
                                
                              <span style="font-size:1.1em;color:#000;"><b>Descuento por nivel de Liderazgo</b></span>    
                              <table class="col-xs-12" style="font-size:0.9em;">
                                <?php $total_descuento_distribucion = 0; ?>
                                <?php foreach ($liderazgosAll as $data): if (!empty($data['id_liderazgo'])): ?>
                                  <?php if ($lidera['id_liderazgo'] >= $data['id_liderazgo']): ?>
                                    <?php
                                      $numDesp = "";
                                      $totalColecciones = 0;
                                      foreach ($totalesDeudas as $key) {
                                        if($data['id_despacho'] == $key['id_despacho']){
                                          $precioColAct = $key['precio_coleccion'];
                                          $cantidad_colecciones_act = $key['cantidad_aprobado'];
                                          $totalColecciones = $cantidad_colecciones_act;
                                          $numDesp = $key['numero_pedido'];
                                        }
                                      }
                                    ?>
                                    <tr>
                                      <td>
                                        <b>
                                          <?php echo "N° ".$numDesp; ?>
                                        </b>
                                      </td>
                                      <td>
                                        <b>
                                          <?php echo $data['nombre_liderazgo']; ?>
                                        </b>
                                      </td>
                                      <td style="padding-left:10px;">
                                        <b >
                                          <?php echo "$".number_format($data['descuento_coleccion'],2,',','.'); ?>
                                        </b> 
                                      </td>
                                      <td> <span style="padding-right:5px;padding-left:5px">x</span> </td>
                                      <td>
                                        <b style="color:#ED2A77">
                                          <?php echo $totalColecciones; ?>  <small>Col.</small>
                                        </b>
                                      </td>
                                      <td> <span style="padding-right:5px;padding-left:5px">=</span> </td>
                                      <td>
                                        <b style="color:#0c0;">
                                          <?php 
                                            $t = $data['descuento_coleccion']*$totalColecciones; 
                                            echo "$".number_format($t,2,',','.');
                                            $total_descuento_distribucion += $t;
                                          ?>
                                        </b>
                                      </td>
                                    </tr>
                                  <?php endif ?>
                                <?php endif; endforeach ?>
                                <tr>
                                  <td colspan="7" style="border-bottom:1px solid #777"></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td colspan="3">
                                    <span style="font-size:1.2em">
                                      <b>Total</b>
                                    </span>
                                  </td>
                                  <td> 
                                    <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                      <b>=</b>
                                    </span> 
                                  </td>
                                  <td colspan="">
                                    <span style="font-size:1.5em;color:#0C0">
                                      <b>$<?php echo number_format($total_descuento_distribucion,2,',','.') ?></b>
                                    </span>
                                  </td>
                                </tr>
                              </table>
                              <!-- <pre> -->
                              </div>

                            </div>

                            
                            <div class="col-md-5">
                              <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">
                                <span style="font-size:1.1em;color:#000;"><b>Descuentos Por Colecciones de Contado</b></span>
                                <br>
                                <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                  <tbody>
                                    <?php 
                                      $num = 1;
                                      $multi = 0;
                                      $resultt = 0;
                                      $resulttDescuentoContado=0;
                                      if(count($bonosContados)>0){
                                        // print_r($bonosContados);
                                        foreach ($bonosContados as $bono) {
                                          $descuento_contado = $bono['descuentos'];
                                          $multi = $bono['colecciones'];
                                          $resultt = $multi * $descuento_contado;
                                          ?>
                                          <tr>
                                            <td><b>N° <?=$bono['numero_despacho']; ?></b></td>
                                            <td><b>Contado</b></td>
                                            <td><b> <?php echo "$".number_format($descuento_contado,2,',','.'); ?></b></td>
                                            <td><?php echo " x "; ?></td>
                                            <td><b style="color:#ED2A77;"><?php echo $multi; ?> <small>Col.</small></b></td>
                                            <td><?php echo " = "; ?></td>
                                            <td><b style="color:#0c0;">
                                              <?php $resulttDescuentoContado+=$resultt; ?>
                                              <?php echo "$".number_format($resultt,2,',','.'); ?>
                                            </b></td>
                                          </tr>
                                          <?php
                                        }
                                      }
                                    ?>
                                    <tr>
                                      <td colspan="7" style="border-bottom:1px solid #777"></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td colspan="3">
                                        <span style="font-size:1.2em">
                                          <b>Total</b>
                                        </span>
                                      </td>
                                      <td> 
                                        <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                          <b>=</b>
                                        </span> 
                                      </td>
                                      <td colspan="">
                                        <span style="font-size:1.5em;color:#0C0">
                                          <b>$<?php echo number_format($resulttDescuentoContado,2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                </div>
                              <br>
                              <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">
                                <span style="font-size:1.1em;color:#000;"><b>Descuento Directos</b></span>
                                <br>
                                <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                  <tbody>
                                    <?php 
                                      $num = 1;
                                      $resulttDescuentoDirecto=0;
                                      foreach ($colss as $col){
                                        $planesDirectos = $col['planes'];
                                        foreach ($planesDirectos as $plan) {
                                          if(!empty($col[$plan['nombre_plan']]['descuento_directo']) && $col[$plan['nombre_plan']]['descuento_directo']>0){
                                            ?>
                                            <tr>
                                              <?php $multi = $col[$plan['nombre_plan']]['cantidad_coleccion']*$col[$plan['nombre_plan']]['cantidad_coleccion_plan']; ?>
                                              <?php $resultt = $multi*$col[$plan['nombre_plan']]['descuento_directo']; ?>
                                              <td><b>N° <?=$col['numero_despacho']; ?></b></td>
                                              <td><b><?php echo "Plan ".$plan['nombre_plan']; ?></b></td>
                                              <td><b> <?php echo "$".number_format($col[$plan['nombre_plan']]['descuento_directo'],2,',','.'); ?></b></td>
                                              <td><?php echo " x "; ?></td>
                                              <td><b style="color:#ED2A77;"><?php echo $multi; ?> <small>Col.</small></b></td>
                                              <td><?php echo " = "; ?></td>
                                              <td><b style="color:#0c0;">
                                                <?php $resulttDescuentoDirecto+=$resultt; ?>
                                                <?php echo "$".number_format($resultt,2,',','.'); ?>
                                              </b></td>
                                            </tr>
                                            <?php 
                                            $num++;
                                          }
                                        }
                                      }
                                    ?>
                                    <tr>
                                      <td colspan="7" style="border-bottom:1px solid #777"></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td colspan="3">
                                        <span style="font-size:1.2em">
                                          <b>Total</b>
                                        </span>
                                      </td>
                                      <td> 
                                        <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                          <b>=</b>
                                        </span> 
                                      </td>
                                      <td colspan="">
                                        <span style="font-size:1.5em;color:#0C0">
                                          <b>$<?php echo number_format($resulttDescuentoDirecto,2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>

                                  </tbody>
                                </table>
                              </div>

                              <br>
                              <?php $resultadoDescuentosPagosPuntual = []; ?>
                                <?php foreach ($cantidadPagosDespachosFild as $key): ?>
                                  <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">
                                    <span style="font-size:1.1em;color:#000;"><b>Descuentos Por <?=$key['name']; ?> Puntual</b></span>
                                    <br>
                                    <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                      <tbody>
                                        <?php 
                                          $num = 1; 
                                          $resultadoDescuentosPagosPuntual[$key['id']] = 0;
                                          foreach ($colss as $col){
                                            $planesDirectos = $col['planes'];
                                            foreach ($planesDirectos as $plan) {
                                              if(!empty($col[$plan['nombre_plan']])){
                                                if(!empty($col[$plan['nombre_plan']][$key['name']]) && $col[$plan['nombre_plan']][$key['name']]>0){
                                                  ?>
                                                  <tr>
                                                    <?php
                                                      $multi = 0;
                                                      $resultt = 0;
                                                      foreach ($bonosPagos as $bono) {
                                                        if($bono['id_despacho']==$col['id_despacho']){
                                                          $descuentoss = $bono[$key['name']]['descuentos'];
                                                          $multi = $bono[$key['name']]['colecciones'];
                                                          $resultt = $col[$plan['nombre_plan']][$key['name']] * $multi;
                                                        }
                                                      }
                                                    ?>
                                                    <td><b>N° <?=$col['numero_despacho']; ?></b></td>
                                                    <td><b><?php echo "Plan ".$plan['nombre_plan']; ?></b></td>
                                                    <td><b> <?php echo "$".number_format($col[$plan['nombre_plan']][$key['name']],2,',','.'); ?></b></td>
                                                    <td><?php echo " x "; ?></td>
                                                    <td><b style="color:#ED2A77;"><?php echo $multi; ?> <small>Col.</small></b></td>
                                                    <td><?php echo " = "; ?></td>
                                                    <td><b style="color:#0c0;">
                                                      <?php $resultadoDescuentosPagosPuntual[$key['id']]+=$resultt; ?>
                                                      <?php echo "$".number_format($resultt,2,',','.'); ?>
                                                    </b></td>
                                                  </tr>
                                                  <?php $num++; 
                                                }
                                              }

                                            }
                                          }
                                        ?>
                                        <tr>
                                          <td colspan="7" style="border-bottom:1px solid #777"></td>
                                        </tr>
                                        <tr>
                                          <td></td>
                                          <td></td>
                                          <td colspan="3">
                                            <span style="font-size:1.2em">
                                              <b>Total</b>
                                            </span>
                                          </td>
                                          <td> 
                                            <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                              <b>=</b>
                                            </span> 
                                          </td>
                                          <td colspan="">
                                            <span style="font-size:1.5em;color:#0C0">
                                              <b>$<?php echo number_format($resultadoDescuentosPagosPuntual[$key['id']],2,',','.') ?></b>
                                            </span>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <br>
                                <?php endforeach; ?>

                              <?php
                                $resulttDescuentoPagosPuntuales = 0;
                                foreach ($resultadoDescuentosPagosPuntual as $bonoPuntual) {
                                  $resulttDescuentoPagosPuntuales+=$bonoPuntual;
                                }
                                $resulttDescuentoCierreEstructura = 0;
                                if($lidera['id_liderazgo'] > $lidSenior['id_liderazgo']){
                                    ?>
                                  <div style="border:1px solid #434343;padding:5px;width:100%;" class="container">

                                  <span style="font-size:1.1em;color:#000;"><b>Descuentos por cierre de estructura</b></span>
                                  <br>
                                  <table class="col-xs-12" style="font-size:0.9em;">
                                    <?php  
                                      foreach ($liderazgosAll as $data){ if (!empty($data['id_liderazgo'])){ if($data['nombre_liderazgo']!="JUNIOR"&&$data['nombre_liderazgo']!="SENIOR"){
                                        $numDesp = "";
                                        $acumColeccionesBonoCierre = 0;
                                        if(count($bonoCierreEstructura)>1){
                                          foreach ($bonoCierreEstructura as $cEstruc) {
                                            if(!empty($cEstruc['id_liderazgo'])){
                                              if($data['id_liderazgo']==$cEstruc['id_liderazgo']){
                                                if($data['id_despacho']==$cEstruc['id_despacho']){
                                                  // echo $data['id_despacho']." | ";
                                                  // echo $cEstruc['id_despacho']." | ";
                                                  // echo "<br>";
                                                  $numDesp = $cEstruc['numero_despacho'];
                                                  $acumColeccionesBonoCierre += $cEstruc['colecciones_bono_cierre'];
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if ($acumColeccionesBonoCierre > 0){
                                          ?>
                                          <tr>
                                            <td style="padding-right:10px">
                                              <b>
                                                <?php echo "N° ".$numDesp; ?>
                                              </b>
                                            </td>
                                            <td style="padding-right:10px">
                                              <b>
                                                <?php echo $data['nombre_liderazgo']; ?>
                                              </b>
                                            </td>
                                            <td style="padding-left:10px;">
                                              <b >
                                                <?php echo "$".number_format($data['descuento_coleccion'],2,',','.'); ?>
                                              </b> 
                                            </td>
                                            <td> <span style="padding-right:5px;padding-left:5px">x</span> </td>
                                            <td>
                                              <?php //echo $data['id_liderazgo'] ?>
                                              <?php //print_r($bonoCierreEstructura[0]['id_liderazgo']); ?>
                                              <?php //foreach ($bonoCierreEstructura as $cierreEstructura): ?>
                                                
                                              <?php //endforeach ?>
                                              <b style="color:#ED2A77">
                                                <?php echo $acumColeccionesBonoCierre; ?> <small>Col.</small>
                                              </b>
                                            </td>
                                            <td> <span style="padding-right:5px;padding-left:5px">=</span> </td>
                                            <td>
                                              <b style="color:#0c0;">
                                                <?php 
                                                  $resulttDescuentoCierreEstructura += $data['descuento_coleccion']*$acumColeccionesBonoCierre;
                                                  $t = $data['descuento_coleccion']*$acumColeccionesBonoCierre; 
                                                  echo "$".number_format($t,2,',','.');
                                                ?>
                                              </b>
                                            </td>
                                          
                                          </tr>
                                          <?php
                                        }
                                      } } }
                                    ?>
                                    <tr>
                                      <td colspan="7" style="border-bottom:1px solid #777"></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td colspan="3">
                                        <span style="font-size:1.2em">
                                          <b>Total</b>
                                        </span>
                                      </td>
                                      <td> 
                                        <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                          <b>=</b>
                                        </span> 
                                      </td>
                                      <td colspan="">
                                        <span style="font-size:1.5em;color:#00C">
                                          <b>$<?php echo number_format($resulttDescuentoCierreEstructura,2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>
                                  </table>

                                  </div>
                                  <?php
                                }
                              ?>


                              <!-- <hr> -->
                              <!-- <br> -->
                              <!-- <hr> -->
                              <!-- <br> -->
                              <hr>
                              <?php 
                                $resultLiquidacionGemas = 0;
                                if(count($liquidacion_gemas)>1){
                                  $resulttDescuentoLiquidacion = 0; 
                                  ?>
                                  <br>
                                  <span style="font-size:1.1em;color:#000;"><b>Descuentos Por Liquidación de gemas</b></span>
                                  <br>
                                  <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                    <tbody>
                                      <?php foreach ($liquidacion_gemas as $liquid){ if(!empty($liquid['cantidad_descuento_gemas'])){ ?>
                                      <tr>
                                        <td><b><?php echo "Liquidación "; ?></b></td>
                                        <td><b> <?php echo "$".number_format($precio_gema,2,',','.'); ?></b></td>
                                        <td><?php echo " x "; ?></td>
                                        <td><b style="color:#ED2A77;"><?php echo number_format($liquid['cantidad_descuento_gemas'],2,',','.');; ?> <small>Gemas.</small></b></td>
                                        <td><?php echo " = "; ?></td>
                                        <td><b style="color:#0c0;">
                                          <?php $resultLiquidacionGemas = $liquid['total_descuento_gemas']; ?>
                                          <?php $resulttDescuentoLiquidacion+=$resultLiquidacionGemas; ?>
                                          <?php echo "$".number_format($resultLiquidacionGemas,2,',','.'); ?>
                                        </b></td>
                                      </tr>
                                      <?php } } ?>
                                      <tr>
                                        <td colspan="6" style="border-bottom:1px solid #777"></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td colspan="3">
                                          <span style="font-size:1.2em">
                                            <b>Total</b>
                                          </span>
                                        </td>
                                        <td> 
                                          <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                            <b>=</b>
                                          </span> 
                                        </td>
                                        <td colspan="">
                                          <span style="font-size:1.5em;color:#0C0">
                                            <b>$<?php echo number_format($resulttDescuentoLiquidacion,2,',','.') ?></b>
                                          </span>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <?php
                                }
                                $totalDescuentoVendedor = $total_descuento_distribucion + 
                                                          $resulttDescuentoContado +
                                                          $resulttDescuentoDirecto + 
                                                          $resulttDescuentoPagosPuntuales+
                                                          // $resulttDescuentoCierreEstructura +
                                                          $resultLiquidacionGemas;
                              ?>
                              <br>
                              <span style="font-size:1.3em"><b>Total Descuento = </b><b style="color:#0c0"><?php  echo"$".number_format($totalDescuentoVendedor,2,',','.'); ?></b></span>
                            </div>
                          </div>
                          <br>



                          <div class="row">
                            <?php 
                              $bg_debe_haber = "#"; 
                              $cantidad_excedente = 0;

                              $excedente_cantidad = [];
                              $excedente_descripcion = [];
                              $iterador = 0;

                                $total_responsabilidad = $total_costo - $totalDescuentoVendedor;
                                $restaTotalResponsabilidad = $total_responsabilidad-$abonado + $cantidad_excedente;
                            ?>
                            <div class="col-md-4" style="background:<?php echo $bg_debe_haber; ?>;position:relative;top:5px">
                              <br>
                              <span style="font-size:1.3em;color:#222;"><b><u>Total a pagar</u></b></span>    
                              <br>

                              <span style="font-size:2em;color:#00C;">
                                <b>$<?php echo number_format($total_responsabilidad,2,',','.') ?></b>
                              </span>

                            </div>
                            
                            <div class="col-md-4" style="background:<?php echo $bg_debe_haber; ?>;position:relative;top:5px">
                              <?php
                                $inff = $lider->consultarQuery("SELECT * FROM excedentes, pedidos, despachos WHERE excedentes.id_pedido=pedidos.id_pedido and pedidos.estatus=1 and pedidos.id_despacho=despachos.id_despacho and despachos.id_campana={$id_campana}");
                                // echo count($inff);
                                $excedentePagado = 0;
                                foreach ($inff as $excedent) {
                                  if(!empty($excedent['cantidad_excedente'])){
                                    $excedentePagado+= (float) $excedent['cantidad_excedente'];
                                  }
                                }
                                // echo $restaTotalResponsabilidad;
                                // echo $restaTotalResponsabilidad."+".$excedentePagado;
                                // echo "=".($restaTotalResponsabilidad+$excedentePagado);
                              ?>
                              <br>
                              <span style="font-size:1.3em;color:#222;"><b><u>Resta</u></b></span>    
                              <br>
                              <span style="font-size:2em;color:#C00;">
                              <!-- <b>$<?php //echo number_format($restaTotalResponsabilidad,2,',','.') ?></b> -->
                              <b>$<?php echo number_format(($restaTotalResponsabilidad+$excedentePagado),2,',','.') ?></b>
                              </span>
                              <br>
                              <b>
                                $<?php echo number_format($excedentePagado,2,',','.') ?>
                                <br>
                                Pagados de Excedentes 
                              </b>
                              <br>
                            </div>

                            <div class="col-md-4" style="background:<?php echo $bg_debe_haber; ?>;position:relative;top:5px">
                              <br>
                              <span style="font-size:1.3em;color:#222;"><b><u>Abonado</u></b></span>    
                              <br>
                              <span style="font-size:2em;color:#0C0;">
                                <b>$<?php echo number_format($abonado,2,',','.') ?></b>
                              </span>
                            <br>
                            <br>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Reportado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado,2, ",",".")?></b></h4>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Diferido</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido,2, ",",".")?></b></h4>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Abonado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado,2, ",",".")?></b></h4>
                    </div>
                  </div>
                  <br>
                </div>
                <!-- /.post -->
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- <?php echo $response; ?> -->
    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
  <?php require_once 'public/views/assets/footered.php'; ?>

<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.modalDescripcionExcedente:hover{
  /*background:red;*/
  border-bottom:1px solid #000;
}
</style>
<script>
$(document).ready(function(){
  var responseGema = $(".responseGema").val();
  if(responseGema==undefined){

  }else{
    if(responseGema=="1"){
      var dispo = $(".gemasdisponibles").val();
      var bloqe = $(".gemasbloqueadas").val();
        swal.fire({
            type: 'success',
            title: "<p style='color:#00C'>Gemas Disponibles: "+dispo+"</p> <br> <p style='color:#C00'>Gemas Bloqueadas: "+bloqe+"</p>",
            text: '¡Ya sus Gemas han sido reclamadas con exito!',
            confirmButtonColor: "#ED2A77",
        }).then(function(){
          var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pedidos&id=<?=$_GET['id']?>";
        });
    }
  }

  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pedidos&id=<?=$_GET['id']?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    // if(response == "5"){
    //   swal.fire({
    //       type: 'error',
    //       title: '¡Error al realizar la operacion!',
    //       confirmButtonColor: "#ED2A77",
    //   });
    // }
  }
</script>

</body>
</html>
