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
        <?php echo "".$url; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "".$url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "".$url;} ?></li>
      </ol>
    </section>
          <br>
            <?php if($_SESSION['nombre_rol']!="Vendedor"){$rut = "Pagos";}else{$rut="MisPagos";} ?>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $rut ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$url?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
              <?php
                if(isset($_GET['aux'])){
                  $aux = $_GET['aux'];
                }else{
                  $aux = $url;
                }
                if(isset($_GET['lider'])){
                  $aux.="&admin=1&lider=".$_GET['lider'];
                }
                if(isset($_GET['Banco'])){
                  $aux.="&Banco=".$_GET['Banco'];
                }
                if(isset($_GET['rangoI']) && isset($_GET['rangoF'])){
                  $aux.="&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
                }
                if(isset($_GET['Abonado'])){
                  $aux.="&Abonado=".$_GET['Abonado'];
                }
                if(isset($_GET['Diferido'])){
                  $aux.="&Diferido=".$_GET['Diferido'];
                }
                if($aux==$url){
                  $aux = "Pagoss";
                }
              ?>

            <?php 
              $configs = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              $diasAdicionales = 0;
              $pagoAdmin = 0;
              $pagoAdminAnalista = 0;
              $pagoAdminSuperanalista = 0;

              $limitefechasPagos = 0;
              foreach ($configs as $cf) {
                if(!empty($cf['id_configuracion'])){
                  if($cf['clausula']=="Diasaddpagounotres"){
                    if($cf['valor']>0){
                      $diasAdicionales=3;
                    }
                  }
                  if($cf['clausula']=="Diasaddpagounocinco"){
                    if($cf['valor']>0){
                      $diasAdicionales=5;
                    }
                  }
                  if($cf['clausula']=="Pagosadmin"){
                      $pagoAdmin=$cf['valor'];
                  }
                  if($cf['clausula']=="Pagosadminanalista"){
                      $pagoAdminAnalista=$cf['valor'];
                  }
                  if($cf['clausula']=="Pagosadminsuperanalista"){
                      $pagoAdminSuperanalista=$cf['valor'];
                  }
                  if($cf['clausula']=="Limitesfechaspagos"){
                      $limitefechasPagos=$cf['valor'];
                  }
                }
              }
              // echo $diasAdicionales;
              $actualDate = date('Y-m-d');
              $days = ((60*60)*24)*$diasAdicionales;
              $newFecha = date('Y-m-d', time()-$days);


              if(!empty($pedido) && count($pedido)>1){
                $bonoscontado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = {$pedido['id_pedido']}");
                $coleccionesContado = 0;
                foreach ($bonoscontado as $bono) {
                  if(!empty($bono['id_bonocontado'])){
                    $coleccionesContado += $bono['colecciones_bono'];
                  }
                }
              }

              $contado = 0;
              $abonos = 0;
              $primerPago = 1;
              $varcont = 0;
              // print_r($pagos);
              if(!empty($pagos) && count($pagos)>1){
                foreach ($pagos as $pag) {
                  if(!empty($pag['equivalente_pago'])){
                    if($pag['estado']=="Abonado"){
                      if($pag['tipo_pago']=="Contado"){
                        $contado += $pag['equivalente_pago'];
                      }
                      if($pag['tipo_pago']=="Primer Pago"){
                        $abonos += $pag['equivalente_pago'];
                      }                  
                    }
                  }
                }
              }

              if(!empty($pedido) && count($pedido)>1){
                $primerPago = $pedido['cantidad_aprobado'] * $pedido['primer_precio_coleccion'];
                $varcont = $pedido['primer_precio_coleccion'] * $coleccionesContado;
                if($varcont < $contado){
                  $primerPago -= $varcont;
                }
              }

              // echo $varcont."<br>";
              // echo $contado."<br>";
              // echo $abonos."<br>";
              // echo $primerPago."<br>";
            ?>

        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "".$url; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php
                  // $actualDate = '2022-04-17';
                  // echo $actualDate."<br>";
                  // echo $despacho['fecha_primera_senior']."<br>";
                  // $abonos = 3599;
                  // echo $abonos."<br>";
                  // echo $primerPago."<br>";
                ?>
                <div class="row">
                <?php if($pago['id_banco']!=""){ ?>
                  <div class="form-group col-xs-12 col-sm-6">
                     <label for="forma">Forma de pago</label>
                     <select class="form-control select2" id="forma" name="forma" style="width:100%;">
                        <option></option>
                        <option <?php if($pago['forma_pago']=="Transferencia Banco a Banco"){?> selected <?php } ?>>Transferencia Banco a Banco</option>
                        <option <?php if($pago['forma_pago']=="Transferencia de Otros Bancos"){?> selected <?php } ?>>Transferencia de Otros Bancos</option>
                        <option <?php if($pago['forma_pago']=="Pago Movil Banco a Banco"){?> selected <?php } ?>>Pago Movil Banco a Banco</option>
                        <option <?php if($pago['forma_pago']=="Pago Movil de Otros Bancos"){?> selected <?php } ?>>Pago Movil de Otros Bancos</option>
                        <option <?php if($pago['forma_pago']=="Deposito En Dolares"){?> selected <?php } ?>>Deposito En Dolares</option>
                        <!-- <option <?php if($pago['forma_pago']=="Deposito En Bolivares"){?> selected <?php } ?>>Deposito En Bolivares</option> -->
                        <!-- <option>Divisas Dolares</option> -->
                        <!-- <option>Divisas Euros</option> -->
                        <!-- <option>Efectivo Bolivares</option> -->
                        <!-- <option>Zelle</option> -->
                     </select>
                     <span id="error_forma" class="errors"></span>
                  </div>
                <?php } ?>

                  <div class="form-group col-xs-12 col-sm-6">
                      
                      <?php if($pago['id_banco']>0){ ?>
                     <label for="bancoPago">Bancos</label>
                      <?php } ?>
                      
                      <?php //if($pago['id_banco']=="0"){ ?>
                      <div style="display:none" class="bancosVacio">
                         <select class="form-control select2 bancoPago bancoPagoV" style="width:100%" name="bancoPago">
                            <option value=""></option>
                         </select>
                      </div>
                      <?php //} ?>

                        <?php if($pago['forma_pago']=="Pago Movil Banco a Banco"||$pago['forma_pago']=="Pago Movil de Otros Bancos"){ ?>
                      <div style='display:;' class="bancosSelect bancosPM">
                      <?php }else{ ?>
                      <div style='display:none;' class="bancosSelect bancosPM">
                        <?php } ?>
                         <select class="form-control select2 bancoPago bancoPagoPM" style="width:100%" name="bancoPago">
                            <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Pago Movil" || $data['opcion_pago']=="Ambos"){  ?>
                              <option <?php if($pago['id_banco']==$data['id_banco']){?> selected <?php } ?> value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" 
                                    <?php //foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                      //if ($data['id_pedido'] == $key['id_pedido']): 
                                        //disabled
                                    ?>
                                         
                                    <?php //endif; endif; endforeach; ?> 
                              ><!-- Aqui cierra el Option de apertura  -->
                                    <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                
                              </option>
                          <?php  } }  } ?>
                         </select>
                      </div>

                        <?php if($pago['forma_pago']=="Transferencia Banco a Banco"||$pago['forma_pago']=="Transferencia de Otros Bancos"){ ?>
                      <div style='display:;' class="bancosSelect bancosT">
                        <?php }else{ ?>
                      <div style='display:none;' class="bancosSelect bancosT">
                        <?php } ?>
                         <select class="form-control select2 bancoPago bancoPagoT" style="width:100%" name="bancoPago">
                            <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Transferencia" || $data['opcion_pago']=="Ambos"){  ?>
                              <option <?php if($pago['id_banco']==$data['id_banco']){?> selected <?php } ?> value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" 
                                    <?php //foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                      //if ($data['id_pedido'] == $key['id_pedido']): 
                                        //disabled
                                    ?>
                                         
                                    <?php //endif; endif; endforeach; ?> 
                              ><!-- Aqui cierra el Option de apertura  -->
                                    <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                
                              </option>
                          <?php  } }  } ?>
                         </select>
                      </div>

                      <?php if($pago['forma_pago']=="Deposito En Bolivares"){ ?>
                      <div style='display:;' class="bancosSelect bancosAll">
                        <?php }else{ ?>
                      <div style='display:none;' class="bancosSelect bancosAll">
                        <?php } ?>
                         <select class="form-control select2 bancoPago bancoPagoT" style="width:100%" name="bancoPago">
                            <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['tipo_cuenta']!="Divisas"){  ?>
                              <option <?php if($pago['id_banco']==$data['id_banco']){?> selected <?php } ?> value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" 
                                    <?php //foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                      //if ($data['id_pedido'] == $key['id_pedido']): 
                                        //disabled
                                    ?>
                                         
                                    <?php //endif; endif; endforeach; ?> 
                              ><!-- Aqui cierra el Option de apertura  -->
                                    <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                
                              </option>
                          <?php  } }  } ?>
                         </select>
                      </div>

                        <?php if($pago['forma_pago']=="Deposito En Dolares"){ ?>
                      <div style='display:' class="bancosSelect bancosDivisas">
                        <?php }else{ ?>
                      <div style='display:none' class="bancosSelect bancosDivisas">
                         <select class="form-control select2 bancoPago bancoPagoD" style="width:100%" name="bancoPago">
                            <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['nombre_banco'])){ if($data['tipo_cuenta']=="Divisas"){  ?>
                              <option <?php if($pago['id_banco']==$data['id_banco']){?> selected <?php } ?> value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" 
                                    <?php //foreach ($facturas as $key): if (!empty($key['id_pedido'])):
                                      //if ($data['id_pedido'] == $key['id_pedido']): 
                                        //disabled
                                    ?>
                                         
                                    <?php //endif; endif; endforeach; ?> 
                              ><!-- Aqui cierra el Option de apertura  -->
                                    <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                
                              </option>
                          <?php  } }  } ?>
                         </select>
                      </div>
                        <?php } ?>

                        <?php if($pago['id_banco']=="0"){ ?>
                      <div style='display:none'  class="bancosEfectivo ">
                         <select class="form-control select2 bancoPago bancoPagoE" style="width:100%" name="bancoPago">
                            <option value="0-Efectivo">Efectivo</option>
                         </select>
                      </div>
                        <?php } ?>
                      
                     <span id="error_bancoPago" class="errors"></span>
                  </div>

                </div>
            </div>

            <?php if($pago['id_banco']!=""){ //if( (empty($_GET['admin']) && !isset($_GET['select'])) || (!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==1) ){ ?>
            <div class="box-footer">
              <span type="submit" class="btn btn-default enviar2 color-button-sweetalert" style='background:#ED2A77;color:#fff'>Cargar</span>
              <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
            </div>
            <?php }//} ?>


            <?php 

            $cantidadPagosDespachosFildCount = [];
          // echo "COUNT: ".count($cantidadPagosDespachosFild);
          if(!empty($pedido) && count($pedido)>1){
            $nnCount = 0;
            foreach ($cantidadPagosDespachosFild as $cvPagos) {
              if($nnCount < ($despacho['cantidad_pagos']-1) ){
                $cantidadPagosDespachosFildCount[$nnCount] = $cvPagos;
                $nnCount++;
              }
            }

            // print_r($preciosPagar);
            $varcont = $pedido['primer_precio_coleccion'] * $coleccionesContado;
            $fechaOP = "";
            foreach ($cantidadPagosDespachosFild as $cvPagos) {
              foreach ($pagos_despacho as $pagosD) {
                if(!empty($pagosD['id_despacho'])){
                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                    $fechaOP = $pagosD['fecha_pago_despacho_senior'];
                  }
                  if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                    // echo "<br>";
                    // echo $cvPagos['id']."<br>";
                    // echo $cvPagos['name']."<br>";
                    // echo $pedido['cantidad_aprobado']."<br>";
                    // echo $pagosD['pago_precio_coleccion']."<br>";
                    // echo "<br>";
                    $preciosPagar[$cvPagos['id']] = $pedido['cantidad_aprobado'] * $pagosD['pago_precio_coleccion'];

                    if($varcont < $contado){
                      $preciosPagar[$cvPagos['id']] -= $varcont;                      
                    }
                  }
                }
              }
            }
            // echo "<br>";
            // print_r($preciosPagar);
            // echo "<br>";
            if($pagosObligatorios=="Y"){
              $limitefechasPagos = 0;
            }
            // echo "<br>";
            // echo "Pagar De contado: ".$varcont."<br>";
            // echo "ABONOS CONTADO: ".$contado."<br>";
            // $primerPago = $pedido['cantidad_aprobado'] * $pedido['primer_precio_coleccion'];
            
            // echo "Abonar Primer Pago: ".$primerPago."<br>";
            // echo "Se restan: ".$varcont." del contado<br>";
            // if($varcont < $contado){
            //   $primerPago -= $varcont;
            // }
            // echo "Total Abonar Primer Pago: ".$primerPago."<br>";



          }


            ?>        
            <?php 
              $infoPromos = [];
              $valIndex = 0;
              foreach ($promociones as $promoPagos) {
                if(!empty($promoPagos['id_promocion'])){
                  if($promoPagos['cantidad_aprobada_promocion']>0){
                    $ResultActPromoPago = 0;
                    $ResultActPromoPago = $promoPagos['precio_promocion']*$promoPagos['cantidad_aprobada_promocion'];
                    $infoPromos[$valIndex]['nombre'] = $promoPagos['nombre_promocion'];
                    $infoPromos[$valIndex]['precio'] = $promoPagos['precio_promocion'];
                    $infoPromos[$valIndex]['cantidad'] = $promoPagos['cantidad_aprobada_promocion'];
                    $infoPromos[$valIndex]['total'] = $ResultActPromoPago;
                    // print_r($promoPagos);
                    // echo $promoPagos['nombre_promocion'].": ";
                    // echo $promoPagos['id_promociones'].": ";
                    // echo $promoPagos['precio_promocion']."*".$promoPagos['cantidad_aprobada_promocion']." = ";
                    // echo $ResultActPromoPago;
                    ?>
                      <!-- <input type="hidden" value="<?=$promoPagos['id_promociones'] ?>"> -->
                      <!-- <input type="hidden" value="<?=$ResultActPromoPago ?>" id="MaximoAbono<?=$promoPagos['id_promociones']; ?>" name=""> -->
                    <?php
                    // echo $promoPagos['nombre_promocion'];
                    // echo "<br><br>";
                    $valIndex++;
                  }
                }
              }
             ?>            

                <?php $bancoSelect = ""; ?>
                <?php if ($pago['id_banco']!=""): ?>
                  <?php foreach ($bancos as $banks): ?>
                    <?php if (!empty($banks['id_banco'])): ?>
                      <?php if ($banks['id_banco']==$pago['id_banco']): ?>
                        <?php $bancosSelect = $banks; ?>
                      <?php endif ?>
                    <?php endif ?>
                  <?php endforeach ?>
                <?php endif ?>

                  <?php if(($pago['forma_pago']=="Transferencia Banco a Banco" || $pago['forma_pago']=="Transferencia de Otros Bancos") && $bancosSelect['nombre_banco']!="Provincial"){ ?>
              <div class="boxForm boxFormTransferencia" style="display:;">
                  <?php } else { ?>
              <div class="boxForm boxFormTransferencia" style="display:none">
                  <?php } ?>
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                      <hr>
                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=$pago['fecha_pago']?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <label for="tipoPago">Tipo de pago <small>Ej. (Contado / Inicial / Primer Pago, etc.)</small></label>
                            <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }

                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="referencia">Referencia del movimiento</label>
                             <input type="text" class="form-control" id="referencia" value="<?=$pago['referencia_pago']?>" name="referencia" maxlength="35" placeholder="00000001">
                             <span id="error_referencia" class="errors"></span>
                          </div>

                      </div>

                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){ ?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormTransferencia">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormTransferencia d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>


                  <?php if(($pago['forma_pago']=="Transferencia Banco a Banco" || $pago['forma_pago']=="Transferencia de Otros Bancos") && $bancosSelect['nombre_banco']=="Provincial"){ ?>
              <div class="boxForm boxFormTransferenciaProvincial" style="display:">
                  <?php } else { ?>
              <div class="boxForm boxFormTransferenciaProvincial" style="display:none">
                  <?php } ?>
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <?php
                              $pos = strpos($pago['referencia_pago'], "-");
                              $tipo_pago = substr($pago['referencia_pago'], 0, $pos);
                              if($pos!=0){
                                $cedula = substr($pago['referencia_pago'], $pos+1);
                              }else{
                                $cedula = substr($pago['referencia_pago'], $pos);                              
                              }
                            ?>
                             <label for="cedula">Cedula</label>
                             <div class="row">
                              <div class="col-xs-12">
                              <select class="form-control" style="width:20%;float:left;" name="tipo_cedula">
                                <option <?php if($tipo_pago=="V"){ ?> selected <?php } ?>>V</option>
                                <option <?php if($tipo_pago=="J"){ ?> selected <?php } ?>>J</option>
                                <option <?php if($tipo_pago=="E"){ ?> selected <?php } ?>>E</option>
                              </select> 
                              <input type="text" class="form-control" value="<?=$cedula?>" style="width:80%;float:left;" id="cedula" name="cedula">
                              </div>
                            </div>
                            <div style="clear:both;"></div>
                             <!-- <input type="text" class="form-control"  id="cedula" name="cedula"> -->
                             <span id="error_cedula" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?>  value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormTransferenciaProvincial">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormTransferenciaProvincial d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>


                  <?php if(($pago['forma_pago']=="Pago Movil Banco a Banco" || $pago['forma_pago']=="Pago Movil de Otros Bancos") && $bancosSelect['nombre_banco']!="Provincial"){ ?>
              <div class="boxForm boxFormPagoMovil" style="display:">
                  <?php }else{ ?>
              <div class="boxForm boxFormPagoMovil" style="display:none">
                  <?php } ?> 
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" class="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="referencia">Numero de movimiento</label>
                             <input type="text" class="form-control" id="referencia" value="<?=$pago['referencia_pago']?>" name="referencia" maxlength="35">
                             <span id="error_referencia" class="errors"></span>
                          </div>
                      </div>

                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                              <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">$</span> 
                               <input type="number" value="0.00" step="0.01" class="form-control equivalente" id="equivalente" class="equivalente" name="equivalente" readonly="">
                              </div>
                             <input type="number" <?php if($pago['equivalente_pago']!=""){?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovil">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormPagoMovil d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>


                  <?php if($pago['forma_pago']=="Pago Movil Banco a Banco" && $bancosSelect['nombre_banco']=="Provincial"){ ?>
              <div class="boxForm boxFormPagoMovilProvincial1" style="display:">
                  <?php }else{ ?>
              <div class="boxForm boxFormPagoMovilProvincial1" style="display:none">
                  <?php } ?>

                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" class="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <?php
                              $pos = strpos($pago['referencia_pago'], "-");
                              $tipo_pago = substr($pago['referencia_pago'], 0, $pos);
                              if($pos!=0){
                                $cedula = substr($pago['referencia_pago'], $pos+1);
                              }else{
                                $cedula = substr($pago['referencia_pago'], $pos);                              
                              }
                            ?>
                             <label for="cedula">Cedula</label>
                             <div class="row">
                              <div class="col-xs-12">
                              <select class="form-control" style="width:20%;float:left;" name="tipo_cedula">
                                <option <?php if($tipo_pago=="V"){ ?> selected <?php } ?>>V</option>
                                <option <?php if($tipo_pago=="J"){ ?> selected <?php } ?>>J</option>
                                <option <?php if($tipo_pago=="E"){ ?> selected <?php } ?>>E</option>
                              </select> 
                              <input type="text" class="form-control" value="<?=$cedula?>" style="width:80%;float:left;" id="cedula" name="cedula">
                              </div>
                            </div>
                            <div style="clear:both;"></div>
                             <!-- <input type="text" class="form-control"  id="cedula" name="cedula"> -->
                             <span id="error_cedula" class="errors"></span>
                          </div>


                      </div>

                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" class="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovilProvincial1">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormPagoMovilProvincial1 d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>


                  <?php if($pago['forma_pago']=="Pago Movil de Otros Bancos" && $bancosSelect['nombre_banco']=="Provincial"){ ?>
              <div class="boxForm boxFormPagoMovilProvincial2" style="display:">
                  <?php }else{ ?>
              <div class="boxForm boxFormPagoMovilProvincial2" style="display:none">
                  <?php } ?>
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" class="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                                
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                      <!-- </div> -->
                      <!-- <div class="row"> -->

                          <!-- <div class="form-group col-xs-12"> -->
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="telefono">Telefono <small>(Pago Movil)</small></label>
                             <input type="text" class="form-control" id="telefono" value="<?=$pago['referencia_pago']?>" name="telefono">
                             <span id="error_telefono" class="errors"></span>
                          </div>

                      </div>

                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){ ?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" class="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovilProvincial2">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormPagoMovilProvincial2 d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>


              

                <?php if ($pago['forma_pago']=="Deposito En Dolares"){ ?>
              <div class="boxForm boxFormDepositoDivisas" style="display:">
                <?php }else{ ?>                  
              <div class="boxForm boxFormDepositoDivisas" style="display:none">
                <?php } ?>      
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>

                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                                <option></option>
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php
                                    $pagoAbierto = "0";
                                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                      if($pagoAdmin=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                      if($pagoAdminSuperanalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista"){
                                      if($pagoAdminAnalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                  ?>

                                  <?php 
                                    if($pagoAbierto==1){
                                      echo "<option ";
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "selected";
                                      }
                                      echo " >Contado</option>";
                                    }else{

                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }

                                    }

                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){


                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }


                                        }
                                      }
                                    } }
                                  ?>
                                <?php else: ?>
                                    <?php
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }
                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    } }
                                    ?>
                                <?php endif; ?>
                                <?php 
                                  foreach ($promociones as $promoPagos) {
                                    if(!empty($promoPagos['id_promocion'])){
                                      if($promoPagos['cantidad_aprobada_promocion']>0){
                                        if(count($fechasPromociones)>0){
                                          if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                            <?php
                                          }
                                        }else{
                                          ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                          <?php
                                        }
                                      }
                                    }
                                  }
                                ?>
                            </select>
                            <span id="error_tipoPago" class="errors"></span>
                          </div>

                      </div>

                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="serial">Referencia del deposito</label>
                             <input type="text" class="form-control" value="<?=$pago['referencia_pago']?>" id="serial" name="serial" max="10">
                             <span id="error_serial" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente montoDinero" id="equivalente" class="equivalente" name="equivalente">
                            </div>
                             <span id="error_equivalente" class="errors"></span>
                          </div>
                      </div>

                    </div>


                      
                    <div class="box-footer">
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoDivisas">Enviar</span>
                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormDepositoDivisas d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>

                
                <?php if(($pago['forma_pago']=="Deposito En Bolivares") && $bancosSelect['nombre_banco']!="Provincial"){ ?>
              <div class="boxForm boxFormDepositoBolivares" style="display:">
                  <?php } else { ?>
              <div class="boxForm boxFormDepositoBolivares" style="display:none">
                  <?php } ?>     
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                      <hr>
                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=$pago['fecha_pago']?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Contado / Inicial / Primer Pago, etc.)</small></label>
                             <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="referencia">Referencia del movimiento</label>
                             <input type="text" class="form-control" id="referencia" value="<?=$pago['referencia_pago']?>" name="referencia" maxlength="35" placeholder="00000001">
                             <span id="error_referencia" class="errors"></span>
                          </div>

                      </div>

                      <div class="row">
                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){ ?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoBolivares">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormDepositoBolivares d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>



                  <?php if(($pago['forma_pago']=="Deposito En Bolivares") && $bancosSelect['nombre_banco']=="Provincial"){ ?>
              <div class="boxForm boxFormDepositoBolivaresProvincial" style="display:">
                  <?php } else { ?>
              <div class="boxForm boxFormDepositoBolivaresProvincial" style="display:none">
                  <?php } ?>       
                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                      <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tasa">Tasa</label>
                             <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" name="tasa" readonly="">
                             <span id="error_tasa" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <?php
                              $pos = strpos($pago['referencia_pago'], "-");
                              $tipo_pago = substr($pago['referencia_pago'], 0, $pos);
                              if($pos!=0){
                                $cedula = substr($pago['referencia_pago'], $pos+1);
                              }else{
                                $cedula = substr($pago['referencia_pago'], $pos);                              
                              }
                            ?>
                             <label for="cedula">Cedula</label>
                             <div class="row">
                              <div class="col-xs-12">
                              <select class="form-control" style="width:20%;float:left;" name="tipo_cedula">
                                <option <?php if($tipo_pago=="V"){ ?> selected <?php } ?>>V</option>
                                <option <?php if($tipo_pago=="J"){ ?> selected <?php } ?>>J</option>
                                <option <?php if($tipo_pago=="E"){ ?> selected <?php } ?>>E</option>
                              </select> 
                              <input type="text" class="form-control" value="<?=$cedula?>" style="width:80%;float:left;" id="cedula" name="cedula">
                              </div>
                            </div>
                            <div style="clear:both;"></div>
                             <!-- <input type="text" class="form-control"  id="cedula" name="cedula"> -->
                             <span id="error_cedula" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="monto">Monto</label>
                             <div class="input-group">
                               <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                               <input type="number" <?php if($pago['monto_pago']!=""){?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                             </div>
                             <span id="error_monto" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">$</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?>  value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" name="equivalente" readonly="">
                            </div>
                             <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>
                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoBolivaresProvincial">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormDepositoBolivaresProvincial d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>
              
                <?php if ($pago['forma_pago']=="Efectivo Bolivares"){ ?>
              <div class="boxForm boxFormEfectivoBolivares" style="display:">
                <?php }else{ ?>
              <div class="boxForm boxFormEfectivoBolivares" style="display:none">
                <?php } ?>
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                  <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                  <?php 
                      $fechaEscogida = $pago['fecha_pago'];
                      // $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                  <div class="box-body">
                      <hr>
                    <div class="row">

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="fechaPago">Fecha de Pago</label>
                           <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                           <span id="error_fechaPago" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tasa">Tasa</label>
                           <input type="number" step="0.01" class="form-control tasa" value="<?=$pago['tasa_pago']?>" id="tasa" name="tasa" readonly="">
                           <span id="error_tasa" class="errors"></span>
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                          <label for="tipoPago">Tipo de pago. <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                          <br>
                          <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                            <option></option>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                <?php
                                $pagoAbierto = "0";
                                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                  if($pagoAdmin=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                  if($pagoAdminSuperanalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                                if($_SESSION['nombre_rol']=="Analista"){
                                  if($pagoAdminAnalista=="1"){
                                    $pagoAbierto = "1";
                                  }
                                }
                              ?>

                              <?php 
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosObligatorios=="N"){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " class='opcionInicialReport'>Inicial</option>";
                                        }else{
                                            if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }
                                        }
                                      }
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                    if($pagosObligatorios=="Y"){
                                      foreach ($cantidadPagosDespachosFild as $cvPagos){
                                        if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }else{
                                            if ($idPagoPendiente==$cvPagos['id']){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                            }
                                          }
                                        }
                                      }
                                    }

                                  }
                                } }
                              ?>
                            <?php else: ?>
                                <?php
                                foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                  if($pagoAbierto==1){
                                    echo "<option ";
                                    if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                      echo "selected";
                                    }
                                    echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                  }else{
                                    if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " class='opcionInicialReport'>Inicial</option>";
                                      }else{
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " class='opcionInicialReport'>Inicial</option>";
                                          }
                                      }
                                    }
                                    foreach ($cantidadPagosDespachosFild as $cvPagos){
                                      if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "<option ";
                                          if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                            echo "selected";
                                          }
                                          echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                        }else{
                                          if ($idPagoPendiente==$cvPagos['id']){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                              echo "selected";
                                            }
                                            echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                          }
                                        }
                                      }
                                    }
                                  }
                                } }
                                ?>
                            <?php endif; ?>
                            <?php 
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){
                                    if(count($fechasPromociones)>0){
                                      if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                      <?php
                                    }
                                  }
                                }
                              }
                            ?>
                          </select>
                          <span id="error_tipoPago" class="errors"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="monto">Monto</label>
                           <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                             <input type="number" <?php if($pago['monto_pago']!=""){ ?> value="<?=$pago['monto_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control monto montoDinero" id="monto" placeholder="0,00" name="monto">
                           </div>
                           <span id="error_monto" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="equivalente">Equivalente</label>
                          <div class="input-group">
                           <span class="input-group-addon" style="background:#EEE">$</span> 
                           <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente" id="equivalente" name="equivalente" readonly="">
                          </div>
                           <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                           <span id="error_equivalente" class="errors"></span>
                        </div>
                    </div>

                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormEfectivoBolivares">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormEfectivoBolivares d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>


                <?php if ($pago['forma_pago']=="Divisas Dolares"){ ?>
              <div class="boxForm boxFormDivisasDolares" style="display:">
                <?php }else{ ?>                  
              <div class="boxForm boxFormDivisasDolares" style="display:none">
                <?php } ?>     
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                  <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                  <div class="box-body">
                  <?php 
                    $fechaEscogida = $actualDate;
                    // $fechaEscogida = "2023-02-15";
                    // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                    // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                    // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                    // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                    // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                    $idPagoPendiente = "";
                    foreach ($cantidadPagosDespachosFild as $cvPagos) {
                      $proseguirNoUltimo = 0;
                      foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                        if($cvPagos['id']==$cvPagos2['id']){
                          $proseguirNoUltimo = 1;
                        }
                      }
                      foreach ($pagos_despacho as $pagosD) {
                        if(!empty($pagosD['id_despacho'])){
                          if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                            if($limitefechasPagos == "1"){
                              if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }
                            }else{
                              if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }

                            if($proseguirNoUltimo==0){
                              if($idPagoPendiente==""){
                                $idPagoPendiente = $cvPagos['id'];
                              }
                            }
                          }
                        }
                      }
                    }
                    // echo $idPagoPendiente;
                  ?>
                    <hr>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="fechaPago">Fecha de Pago</label>
                          <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>" readonly>
                          <span id="error_fechaPago" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                          <br>
                          <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                                <option></option>
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php
                                    $pagoAbierto = "0";
                                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                      if($pagoAdmin=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                      if($pagoAdminSuperanalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista"){
                                      if($pagoAdminAnalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                  ?>

                                  <?php 
                                    if($pagoAbierto==1){
                                      echo "<option ";
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "selected";
                                      }
                                      echo " >Contado</option>";
                                    }else{

                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }

                                    }

                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){


                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }


                                        }
                                      }
                                    } }
                                  ?>
                                <?php else: ?>
                                    <?php
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }
                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    } }
                                    ?>
                                <?php endif; ?>
                                <?php 
                                  foreach ($promociones as $promoPagos) {
                                    if(!empty($promoPagos['id_promocion'])){
                                      if($promoPagos['cantidad_aprobada_promocion']>0){
                                        if(count($fechasPromociones)>0){
                                          if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                            <?php
                                          }
                                        }else{
                                          ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                          <?php
                                        }
                                      }
                                    }
                                  }
                                ?>
                          </select>
                          <span id="error_tipoPago" class="errors"></span>
                          <?php 
                            // echo "Abonos: ".$abonos."<br>";
                            // echo "Primer: ".$primerPago."<br>";
                            // echo "<br><br>";
                            // echo "Actual: ".$actualDate."<br>";
                            // echo "Primera Senior: ".$despacho['fecha_primera_senior']."<br>";
                          ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="serial">Serial de billete en dolar</label>
                           <input type="text" class="form-control" value="<?=$pago['referencia_pago']?>" id="serial" name="serial">
                           <span id="error_serial" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="equivalente">Equivalente</label>
                          <div class="input-group">
                           <span class="input-group-addon" style="background:#EEE">$</span> 
                           <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente montoDinero" id="equivalente" class="equivalente" name="equivalente">
                          </div>
                           <span id="error_equivalente" class="errors"></span>
                        </div>
                    </div>

                  </div>


                    
                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDivisasDolares">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDivisasDolares d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>


              <?php if ($pago['forma_pago']=="Divisas Euros"){ ?>
              <div class="boxForm boxFormDivisasEuros" style="display:">
                <?php }else{ ?>                  
              <div class="boxForm boxFormDivisasEuros" style="display:none">
                <?php } ?>

                  <form action="" method="post" role="form" class="form_register">
                    <input type="hidden" name="valForma" class="valForma" value="<?=$pago['forma_pago']?>">
                    <input type="hidden" name="valBanco" class="valBanco" value="<?=$pago['id_banco']?>">
                    <?php 
                      $fechaEscogida = $actualDate;
                      // $fechaEscogida = "2023-02-15";
                      // echo $pagos_despacho[0]['tipo_pago_despacho'].": ".$pagos_despacho[0]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[1]['tipo_pago_despacho'].": ".$pagos_despacho[1]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[2]['tipo_pago_despacho'].": ".$pagos_despacho[2]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[3]['tipo_pago_despacho'].": ".$pagos_despacho[3]['fecha_pago_despacho_senior']."<br>";
                      // echo $pagos_despacho[4]['tipo_pago_despacho'].": ".$pagos_despacho[4]['fecha_pago_despacho_senior']."<br>";
                      $idPagoPendiente = "";
                      foreach ($cantidadPagosDespachosFild as $cvPagos) {
                        $proseguirNoUltimo = 0;
                        foreach ($cantidadPagosDespachosFildCount as $cvPagos2) {
                          if($cvPagos['id']==$cvPagos2['id']){
                            $proseguirNoUltimo = 1;
                          }
                        }
                        foreach ($pagos_despacho as $pagosD) {
                          if(!empty($pagosD['id_despacho'])){
                            if($pagosD['tipo_pago_despacho']==$cvPagos['name']){
                              if($limitefechasPagos == "1"){
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    if($idPagoPendiente==""){
                                      $idPagoPendiente = $cvPagos['id'];
                                    }
                                  }
                                }
                              }else{
                                if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                                  if($idPagoPendiente==""){
                                    $idPagoPendiente = $cvPagos['id'];
                                  }
                                }
                              }

                              if($proseguirNoUltimo==0){
                                if($idPagoPendiente==""){
                                  $idPagoPendiente = $cvPagos['id'];
                                }
                              }
                            }
                          }
                        }
                      }
                      // echo $idPagoPendiente;
                    ?>
                    <div class="box-body">
                        <hr>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="fechaPago">Fecha de Pago</label>
                             <input type="date" class="form-control fechaPago" value="<?=$pago['fecha_pago']?>" min="<?=$limiteFechaMinimo?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                             <span id="error_fechaPago" class="errors"></span>
                          </div>

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                             <br>
                                
                            <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                                <option></option>
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php
                                    $pagoAbierto = "0";
                                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                      if($pagoAdmin=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista Supervisor"){
                                      if($pagoAdminSuperanalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista"){
                                      if($pagoAdminAnalista=="1"){
                                        $pagoAbierto = "1";
                                      }
                                    }
                                  ?>

                                  <?php 
                                    if($pagoAbierto==1){
                                      echo "<option ";
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "selected";
                                      }
                                      echo " >Contado</option>";
                                    }else{

                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }

                                    }

                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){


                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }


                                        }
                                      }
                                    } }
                                  ?>
                                <?php else: ?>
                                    <?php
                                      if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                          echo "selected";
                                        }
                                        echo " >Contado</option>";
                                      }else{
                                        if($fechaOP!=""){
                                          if($fechaEscogida <= $fechaOP){
                                            echo "<option ";
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Contado"){
                                              echo "selected";
                                            }
                                            echo " >Contado</option>";
                                          }
                                        }
                                      }
                                    foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                                      if($pagoAbierto==1){
                                        echo "<option ";
                                        if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                          echo "selected";
                                        }
                                        echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                      }else{
                                        if($pagosObligatorios=="N"){
                                          if($pagosD['tipo_pago_despacho']=="Inicial"){
                                            if(ucwords(mb_strtolower($pago['tipo_pago']))=="Inicial"){
                                              echo "<option ";
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "selected";
                                              }
                                              echo " class='opcionInicialReport'>Inicial</option>";
                                            }else{
                                                if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " class='opcionInicialReport'>Inicial</option>";
                                                }
                                            }
                                          }
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                        if($pagosObligatorios=="Y"){
                                          foreach ($cantidadPagosDespachosFild as $cvPagos){
                                            if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                              if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                echo "<option ";
                                                if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                  echo "selected";
                                                }
                                                echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                              }else{
                                                if ($idPagoPendiente==$cvPagos['id']){
                                                  echo "<option ";
                                                  if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosD['tipo_pago_despacho']){
                                                    echo "selected";
                                                  }
                                                  echo " >".$pagosD['tipo_pago_despacho']."</option>";
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    } }
                                    ?>
                                <?php endif; ?>
                                <?php 
                                  foreach ($promociones as $promoPagos) {
                                    if(!empty($promoPagos['id_promocion'])){
                                      if($promoPagos['cantidad_aprobada_promocion']>0){
                                        if(count($fechasPromociones)>0){
                                          if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                            <?php
                                          }
                                        }else{
                                          ?>
                                            <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?>  ><?=$promoPagos['nombre_promocion'] ?></option>
                                          <?php
                                        }
                                      }
                                    }
                                  }
                                ?>
                          </select>
                             <span id="error_tipoPago" class="errors"></span>
                          </div>

                      </div>
                      <div class="row">

                          <div class="form-group col-xs-12 col-sm-6 col-md-6">

                             <label for="serial">Serial de billete euro</label>
                             <input type="text" class="form-control" value="<?=$pago['referencia_pago']?>" id="serial" name="serial">
                             <span id="error_serial" class="errors"></span>
                          </div>


                          <div class="form-group col-xs-12 col-sm-6 col-md-6">
                             <label for="equivalente">Equivalente</label>
                            <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">€</span> 
                             <input type="number" <?php if($pago['equivalente_pago']!=""){ ?> value="<?=$pago['equivalente_pago']?>" <?php  }else{ ?> value="0.00" <?php } ?> step="0.01" class="form-control equivalente montoDinero" id="equivalente" class="equivalente" name="equivalente">
                            </div>
                             <span id="error_equivalente" class="errors"></span>
                          </div>

                      </div>

                    </div>

                    <div class="box-footer">
                      
                      <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDivisasEuros">Enviar</span>

                      <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar btn-enviar-boxFormDivisasEuros d-none" disabled="">enviar</button>
                    </div>
                  </form>
              </div>

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
  

  <?php //require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
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
  }else{    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "";
        <?php if(!empty($_GET['aux'])){ ?>
          menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=<?=$aux?>";
        <?php }else{ ?>
          menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=MisPagos";
        <?php } ?>
        window.location.href=menu;
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
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro Repetido!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos";
        window.location.href=menu;
      });
    }
  }
  
  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".bancosSelect").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");
  });

  $("#forma").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");

    var forma = $("#forma").val();
    // alert(forma);

    $(".bancosVacio").hide();
    $(".bancosPM").hide();
    $(".bancosAll").hide();
    $(".bancosT").hide();
    $(".bancosDivisas").hide();
    $(".bancosEfectivo").hide();
    if(forma=="Transferencia Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
    }
    if(forma=="Transferencia de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();

    }
    if(forma=="Pago Movil Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
    }
    if(forma=="Pago Movil de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosEfectivo").hide();
      $(".bancosDivisas").hide();
    }
    if(forma=="Efectivo Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
    }
    if(forma=="Divisas Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
    }
    if(forma=="Deposito En Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").show();
      $(".bancosEfectivo").hide();
    }
    if(forma=="Deposito En Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").show();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();

    }
    if(forma=="Divisas Euros"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
    }
  });
  $(".montoDinero").focusin(function(){
    $(this).val("");
  });
  $(".montoDinero").focusout(function(){
    var x = $(this).val();
    if(x==""){
      $(this).val("0.00");
    }
    else if(x==0){
      $(this).val("0.00");
    }else {
      // alert('asd');
    }
  });
  $(".enviar2").click(function(){
    var formaPago = $("#forma").val();
    var bancoPago = "";
    $(".boxForm").hide();
    if(formaPago=="Transferencia Banco a Banco"){
      bancoPago = $(".bancoPagoT").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormTransferenciaProvincial").show();
          $var = ".boxFormTransferenciaProvincial";
        }else{
          $(".boxFormTransferencia").show();
          $var = ".boxFormTransferencia";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Transferencia de Otros Bancos"){
      bancoPago = $(".bancoPagoT").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormTransferenciaProvincial").show();
          $var = ".boxFormTransferenciaProvincial";
        }else{
          $(".boxFormTransferencia").show();
          $var = ".boxFormTransferencia";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Pago Movil Banco a Banco"){
      bancoPago = $(".bancoPagoPM").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormPagoMovilProvincial1").show();
          $var = ".boxFormPagoMovilProvincial1";
          // $(".boxFormPagoMovil").show();
        }else{
          $(".boxFormPagoMovil").show();
          $var = ".boxFormPagoMovil";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Pago Movil de Otros Bancos"){
      bancoPago = $(".bancoPagoPM").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormPagoMovilProvincial2").show();
          $var = ".boxFormPagoMovilProvincial2";
          // $(".boxFormPagoMovil").show();
        }else{
          $(".boxFormPagoMovil").show();
          $var = ".boxFormPagoMovil";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Deposito En Dolares"){
      // bancoPago = $(".bancoPagoE").val();
      bancoPago = $(".bancoPagoD").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormDepositoDivisas").show();
          $var = ".boxFormDepositoDivisas";
        }else{
          $(".boxFormDepositoDivisas").show();
          $var = ".boxFormDepositoDivisas";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
      // $(".boxFormDepositoDivisas").show();
    }
    if(formaPago=="Deposito En Bolivares"){
      // bancoPago = $(".bancoPagoE").val();
      bancoPago = $(".bancoPagoAll").val();
      // alert(bancoPago);
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormDepositoBolivaresProvincial").show();
          $var = ".boxFormDepositoBolivaresProvincial";
          // $(".boxFormDepositoBolivares").show();
        }else{
          $(".boxFormDepositoBolivares").show();
          $var = ".boxFormDepositoBolivares";
        }
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        $.ajax({
            url: menu,
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
      // $(".boxFormDepositoDivisas").show();
    }
    if(formaPago=="Efectivo Bolivares"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormEfectivoBolivares").show();
    }
    if(formaPago=="Divisas Dolares"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasDolares").show();
    }
    if(formaPago=="Divisas Euros"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasEuros").show();
    }

    $(".valForma").val(formaPago);
    $(".valBanco").val(idBanco);
  });

  $(".fechaPago").change(function(){
    var fecha = $(this).val();
    $(".fechaPago").val(fecha);
    var campaing = $(".campaing").val();
    var n = $(".n").val();
    var y = $(".y").val();
    var dpid = $(".dpid").val();
    var dp = $(".dp").val();
    $.ajax({
        url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
        type: 'POST',
        data: {
          encontrarTasa: true,
          fecha: fecha,
        },
        success: function(respuesta){
          // alert(respuesta);
          var data =JSON.parse(respuesta);
          if(data['ejecucion']==true){
            if(data['elementos']=="1"){
              data = data[0];
              $(".tasa").val(data['monto_tasa']);
              $(".monto").val("");
              // $(".monto").removeAttr("readonly","0");
            }else{
              $(".tasa").val("");
              $(".monto").val("0.00");
              // $(".monto").attr("readonly","1");
            }
          }
        }
    });
  });

  $(".monto").keyup(function(){
    var monto = parseFloat($(this).val());
    var tasa = parseFloat($(".tasa").val());
    var eqv2 = monto / tasa;
    var eqv = eqv2.toFixed(2);
    if(eqv=='NaN'){eqv = 0; eqv = eqv.toFixed(2); eqv2 = 0;  eqv2 = eqv2.toFixed(2);}
    $(".equivalente").val(eqv);
    $(".equivalente2").val(eqv2);
  });

  $("#descuento_coleccion").keyup(function(){
    var max = parseFloat($(".max_total_descuento").val());
    var descuento = parseFloat($(this).val());
    var total = (max+descuento).toFixed(2);
    $("#total_descuento").val(total);
  });

  $(".enviar").click(function(){
    var response = false;
    var id = $(this).attr("id");
    if(id=="boxFormTransferencia"){
      response = validarFromTransferencia(id);
    }
    if(id=="boxFormTransferenciaProvincial"){
      response = validarFormTransferenciaProvincial(id);
    }
    if(id=="boxFormPagoMovil"){
      response = validarFormPagoMovil(id);
    }
    if(id=="boxFormPagoMovilProvincial1"){
      response = validarFormPagoMovilProvincial1(id);
    }
    if(id=="boxFormPagoMovilProvincial2"){
      response = validarFormPagoMovilProvincial2(id);
    }
    if(id=="boxFormEfectivoBolivares"){
      response = validarFormEfectivoBolivares(id);
    }
    if(id=="boxFormDivisasDolares"){
      response = validarFormDivisasDolares(id);
    }
    if(id=="boxFormDepositoDivisas"){
      response = validarFormDepositoDivisasDolares(id);
    }
    if(id=="boxFormDepositoBolivares"){
      response = validarFromDepositoBolivares(id);
    }
    if(id=="boxFormDepositoBolivaresProvincial"){
      response = validarFromDepositoBolivaresProvincial(id);
    }
    if(id=="boxFormDivisasEuros"){
      response = validarFormDivisasEuros(id);
    }
    var btn = "btn-enviar-"+id;

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



        // var formaPago = $("#forma").val();
        // var bancoPago = "";
        // var btn = "";
        // if(formaPago=="Transferencia Banco a Banco"){
        //   bancoPago = $(".bancoPagoT").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormTransferenciaProvincial";
        //     }else{
        //       btn = "btn-enviar-boxFormTransferencia";
        //     }
        //   }
        // }
        // if(formaPago=="Transferencia de Otros Bancos"){
        //   bancoPago = $(".bancoPagoT").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormTransferenciaProvincial";
        //     }else{
        //       btn = "btn-enviar-boxFormTransferencia";
        //     }
        //   }
        // }
        // if(formaPago=="Pago Movil Banco a Banco"){
        //   bancoPago = $(".bancoPagoPM").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormPagoMovilProvincial1";
        //       // $(".boxFormPagoMovil").show();
        //     }else{
        //       btn = "btn-enviar-boxFormPagoMovil";
        //     }
        //   }
        // }
        // if(formaPago=="Pago Movil de Otros Bancos"){
        //   bancoPago = $(".bancoPagoPM").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormPagoMovilProvincial2";
        //       // $(".boxFormPagoMovil").show();
        //     }else{
        //       btn = "btn-enviar-boxFormPagoMovil";
        //     }
        //   }
        // }
        // if(formaPago=="Efectivo Bolivares"){
        //   btn = "btn-enviar-boxFormEfectivoBolivares";
        // }
        // if(formaPago=="Divisas Dolares"){
        //   btn = "btn-enviar-boxFormDivisasDolares";
        // }
        // if(formaPago=="Divisas Euros"){
        //   btn = "btn-enviar-boxFormDivisasEuros";
        // }


        $("."+btn).removeAttr("disabled");
        $("."+btn).click();
              
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

function validarFromTransferencia(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del pago");      
    }
  }else{
      if(referencia.length > 6 || referencia.length < 6){
        $("."+id+" #error_referencia").html("La referencia debe contener 6 digitos");
        rreferencia = false;
      }else{
        $("."+id+" #error_referencia").html("");
        rreferencia = true;
      }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormTransferenciaProvincial(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }else if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovil(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del pago");      
    }
  }else{
      if(referencia.length > 6 || referencia.length < 6){
        $("."+id+" #error_referencia").html("La referencia debe contener 6 digitos");
        rreferencia = false;
      }else{
        $("."+id+" #error_referencia").html("");
        rreferencia = true;
      }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovilProvincial1(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }else if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovilProvincial2(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var telefono = $("."+id+" #telefono").val();
  var rtelefono = checkInput(telefono, numberPattern);
  if( rtelefono == false ){
    if(telefono.length != 0){
      $("."+id+" #error_telefono").html("El telefono solo acepta numeros");
    }else{
      $("."+id+" #error_telefono").html("Debe llenar telefono del pago movil");      
    }
  }else{
    $("."+id+" #error_telefono").html("");
    if(telefono.length >= 11 && telefono.length <= 13){
      $("."+id+" #error_telefono").html("");
      rtelefono = true;      
    }else{
      $("."+id+" #error_telefono").html("El telefono debe tener entre 11");
      rtelefono = false;      
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rtelefono==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormEfectivoBolivares(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDivisasDolares(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del billete solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar el serial del billete");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del billete");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rserial==true && requivalente==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDepositoDivisasDolares(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del vauche solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar la referencia del deposito");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del deposito");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rserial==true && requivalente==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFromDepositoBolivares(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del deposito");      
    }
  }else{
    $("."+id+" #error_referencia").html("");
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del deposito");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFromDepositoBolivaresProvincial(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del deposito");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDivisasEuros(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del billete solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar el serial del billete");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del billete");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rserial==true && requivalente==true){
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
