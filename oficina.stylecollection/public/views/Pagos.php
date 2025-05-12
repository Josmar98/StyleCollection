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
        <?php echo $url.""; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo $url.""; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo $url."";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$url?></a></div>
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
          <?php foreach ($promociones as $p1){ if(!empty($p1['id_promocion'])){ if($p1['cantidad_aprobada_promocion']>0){ ?>
            <br>
            <a class="enlaceOpen" href="?<?=$menUU; ?>#promo_<?=$p1['id_promocion']; ?>" style="padding:10px 15px;color:#FFF;"><?=$p1['nombre_promocion']; ?></a>
            <br>
          <?php } } } ?>
          <br>
        </span>
      </div>
      <div class="row">

        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}
          if($_SESSION['nombre_rol']=="Administrativo"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }

        ?>

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"){ ?>
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        <?php } ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>

        <div class="col-xs-12">
          <?php 
            $registropagosboton=0;
            $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
            foreach ($configuraciones as $config) {
               if(!empty($config['id_configuracion'])){
                  if($config['clausula']=="Registropagosboton"){
                    $registropagosboton = $config['valor'];
                  }
               }
            }
          ?>
          <div class="box"> 
            <?php if($estado_campana=="1"){ ?>
              <?php if ($registropagosboton=="1"): ?>
                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){ ?>
                  <a href="?<?=$menu?>&route=Pagos&action=Registrar" style="position:fixed;bottom:7%;right:2%;z-index:300;" class="btn enviar2"><span class="fa fa-arrow-up"></span> <span class="hidden-xs hidden-sm"><u>Registrar Pagos</u></span></a>
                <?php } ?>
              <?php endif; ?>
            <?php } ?>

            <?php
              $aux = $url;
              $aux2 = "";
              if(isset($_GET['lider'])){
                $aux.="&admin=1&lider=".$_GET['lider'];
                $aux2.="&admin=1&lider=".$_GET['lider'];
              }
              if(isset($_GET['Banco'])){
                $aux.="&Banco=".$_GET['Banco'];
                $aux2.="&Banco=".$_GET['Banco'];
              }
              if(isset($_GET['rangoI']) && isset($_GET['rangoF'])){
                $aux.="&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
                $aux2.="&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
              }
              if(isset($_GET['Abonado'])){
                $aux.="&Abonado=".$_GET['Abonado'];
                $aux2.="&Abonado=".$_GET['Abonado'];
              }
              if(isset($_GET['Diferido'])){
                $aux.="&Diferido=".$_GET['Diferido'];
                $aux2.="&Diferido=".$_GET['Diferido'];
              }
              if($aux==$url){
                $aux = "Pagoss";
              }
              if($aux2==""){
                $aux = "Pagoss";
              }
              // echo $aux2;
            ?>

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "".$url; ?></a></h3>
              
              <?php //if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <br><br>
                <div class="row">
                  <form action="" method="get">
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="<?=$url;?>" name="route">
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
                        <?php if(!empty($_GET['Banco'])){ ?>
                        <input type="hidden" value="<?=$_GET['Banco']?>" name="Banco">
                        <?php } ?>
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>

                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                      <br>
                      <button class="btn enviar ">Enviar</button>
                    </div>
                  </form>
                </div>
                
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
                      <?php if(!empty($_GET['Banco'])){ ?>
                      <input type="hidden" value="<?=$_GET['Banco']?>" name="Banco">
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

                <style>
                  .text-xs { text-align:right; }
                  @media (max-width: 768px) {
                    .text-xs { text-align:right !important;}
                  }
                </style>
                <div class="row">
                  <?php if ($_SESSION['nombre_rol']!="Conciliador"): ?>
                    <br>
                    <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                      <?php if ($aux2 != ""): ?>
                      <a href="?<?=$menu?>&route=PagosBolivares<?=$aux2?>" style="color:#2A2;" class="btn"><b><u>Ver Bolivares con filtro</u></b></a>
                      <?php else: ?>
                      <a href="?<?=$menu?>&route=PagosBolivares" style="color:#2A2;" class="btn"><b><u>Ver Solo Bolivares</u></b></a>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                  <?php if ($_SESSION['nombre_rol']!="Conciliador"): ?>
                    <br>
                    <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                      <?php if ($aux2 != ""): ?>
                      <a href="?<?=$menu?>&route=PagosDivisas<?=$aux2?>" style="background:#0A0;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Divisas con filtro</u></b></a>
                      <?php else: ?>
                      <a href="?<?=$menu?>&route=PagosDivisas" style="background:#0A0;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Solo Divisas</u></b></a>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                  <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                    <?php if ($aux2 != ""): ?>
                    <a href="?<?=$menu?>&route=PagosBancarios<?=$aux2?>" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Movimientos Bancarios con filtro</u></b></a>
                    <?php else: ?>
                    <a href="?<?=$menu?>&route=PagosBancarios" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Solo Movimientos Bancarios</u></b></a>
                    <?php endif; ?>
                  </div>
                </div>
                  
                <?php if(!empty($_GET['lider'])){ ?>
                  <a class="" href="?<?=$menu."&route=Pedidos&id=".$pedido['id_pedido']?>" style='font-size:1.1em;'><b><u>Ir al estado de cuentas</u></b></a>
                  <br>
                  <div class="row">
                  <?php
                    $nIndx = 0;
                    $acumuladosTotales = [];
                    $totalesPagosPagar = [];
                    $bonoscontado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = {$pedido['id_pedido']}");
                    $coleccionesContado = 0;
                    $varCont = 0;
                    foreach ($bonoscontado as $bono) {
                      if(!empty($bono['id_bonocontado'])){
                        $coleccionesContado += $bono['colecciones_bono'];
                      }
                    }
                    foreach ($cantidadPagosDespachosFild as $key) {
                      foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                        if(mb_strtolower($pagosD['tipo_pago_despacho'])==mb_strtolower($key['name'])){
                          // print_r($pagosD['pago_precio_coleccion']);

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
                            // echo "Precio de Coleccion: ".$despacho['precio_coleccion']."<br>";
                            // echo "Colecciones: ".$pedido['cantidad_aprobado']."<br>";
                            // echo "Precio de ".$key['name'].": ".$pagosD['pago_precio_coleccion']."<br>";
                            $acumTotalPrimerPago = 0;
                            $acumuladosTotales[$key['id']] = 0;
                            // echo $key['id'];
                            // print_r($acumuladosTotales);
                            // print_r($planes);
                          ?>
                          <?php 
                            foreach ($planes as $plans){
                              if (!empty($plans['id_pedido'])){
                                if ($plans['cantidad_coleccion_plan']>0){
                                  ?>
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
                                  <?php 
                                }
                              } else {
                                $acumuladosTotales[$key['id']] = $pagosD['pago_precio_coleccion']*$pedido['cantidad_aprobado'];
                              }
                            }
                            // print_r($acumuladosTotales);
                          ?>
                          <tr style="border-top:1.02px solid #AAA;border-bottom:1.02px solid #AAA">
                            <td></td>
                            <td></td>
                            <td colspan="2"><b>Total</b></td>
                            <td>=</td>
                            <td><b>$<?=$acumuladosTotales[$key['id']]; ?></b></td>
                          </tr>

                          <?php
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
                <?php } ?>

                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="lider">Seleccione al Lider</label>
                      <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                      <input type="hidden" value="<?=$numero_campana;?>" name="n">
                      <input type="hidden" value="<?=$anio_campana;?>" name="y">
                      <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                      <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                      <input type="hidden" value="Pagos" name="route">
                      <?php if(!empty($_GET['rangoI'])){ ?>
                          <input type="hidden" value="<?=$_GET['rangoI']?>" name="rangoI">
                          <?php } ?>
                          <?php if(!empty($_GET['rangoF'])){ ?>
                          <input type="hidden" value="<?=$_GET['rangoF']?>" name="rangoF">
                          <?php } ?>
                          <?php if(!empty($_GET['Banco'])){ ?>
                          <input type="hidden" value="<?=$_GET['Banco']?>" name="Banco">
                          <?php } ?>
                          <?php if(!empty($_GET['Diferido'])){ ?>
                          <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                          <?php } ?>
                          <?php if(!empty($_GET['Abonado'])){ ?>
                          <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                          <?php } ?>

                      <!-- <input type="hidden" value="Registrar" name="action"> -->
                      <input type="hidden" value="1" name="admin">
                      <!-- <input type="hidden" value="1" name="select"> -->
                      <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                        <option></option>
                        <?php foreach ($lideres as $data): ?>
                          <?php if (!empty($data['id_cliente'])): ?>
                            <?php
                            $permitido = "0";
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$data['id_cliente']){
                                      $permitido = "1";
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                              $permitido = "1";
                            }


                            if($permitido=="1"):
                            ?>
                              <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                            <?php endif; ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </form>

                  <form action="" method="GET" class="form_select_banco">
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="banco">Seleccione al banco</label>
                      <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                      <input type="hidden" value="<?=$numero_campana;?>" name="n">
                      <input type="hidden" value="<?=$anio_campana;?>" name="y">
                      <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                      <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                      <input type="hidden" value="Pagos" name="route">
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

                      <!-- <input type="hidden" value="Registrar" name="action"> -->
                      <!-- <input type="hidden" value="1" name="select"> -->
                      <select class="form-control select2 selectbanco" id="banco" name="Banco" style="width:100%;">
                        <option></option>
                        <?php foreach ($bancos as $data): ?>
                          <?php if (!empty($data['id_banco'])): ?>
                          <option <?php if (!empty($_GET['Banco'])): if($data['id_banco']==$_GET['Banco']): ?>
                              selected="selected"
                          <?php endif; endif; ?> value="<?=$data['id_banco']?>"><?=$data['nombre_banco']." - ".$data['nombre_propietario']." ".$data['cedula_cuenta']." (Cuenta ".$data['tipo_cuenta'].")";?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </form>
                </div>
              <?php //} ?>
            </div>


            <?php  
              $superopcionconcilio = 0;
              $adminopcionconcilio = 0;
              $superopcionpago = 0;
              $adminopcionpago = 0;

              $superoppagodiviauto = 0;
              $adminoppagodiviauto = 0;

              $analistaeditarpago = 0;
              $analistaborrarpago = 0;
              $superanalistaborrarpago = 0;
              $superanalistaeditarpago = 0;

              $superanalistaaccesorapido = 0;
              $analistaaccesorapido = 0;
              $adminborrarpago = 0;
              $superadminborrarpago = 0;
              $tablasdatatable = 0;

              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              foreach ($configuraciones as $config) {
                if(!empty($config['id_configuracion'])){
                  if($config['clausula']=="Superopcionpago"){
                    $superopcionpago = $config['valor'];
                  }
                  if($config['clausula']=="Adminopcionpago"){
                    $adminopcionpago = $config['valor'];
                  }

                  if($config['clausula']=="Superoppagodiviauto"){
                    $superoppagodiviauto = $config['valor'];
                  }
                  if($config['clausula']=="Adminoppagodiviauto"){
                    $adminoppagodiviauto = $config['valor'];
                  }


                  if($config['clausula']=="Analistaeditarpago"){
                    $analistaeditarpago = $config['valor'];
                  }
                  if($config['clausula']=="Analistaborrarpago"){
                    $analistaborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaborrarpago"){
                    $superanalistaborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaeditarpago"){
                    $superanalistaeditarpago = $config['valor'];
                  }
                  if($config['clausula']=="Adminborrarpago"){
                    $adminborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superadminborrarpago"){
                    $superadminborrarpago = $config['valor'];
                  }
                  

                  if($config['clausula']=="Superanalistaaccesorapido"){
                    $superanalistaaccesorapido = $config['valor'];
                  }
                  if($config['clausula']=="Analistaaccesorapido"){
                    $analistaaccesorapido = $config['valor'];
                  }
                  if($config['clausula']=="Pagosdatatable"){
                    $tablasdatatable = $config['valor'];
                  }
                  if($config['clausula']=="Superopcionconcilio"){
                    $superopcionconcilio = $config['valor'];
                  }
                  if($config['clausula']=="Adminopcionconcilio"){
                    $adminopcionconcilio = $config['valor'];
                  }
                }
              }


              $ruta = "Pagos";
              // if(!empty($_GET['admin']) && !empty($_GET['lider'])){
              //   $ruta = "Pagos&admin=1&lider=".$_GET['lider'];                      
              // } else if($_SESSION['id_cliente']==$id_cliente){
              //   $ruta = "Pagos";
              // }else{
              //   $ruta = "Pagos&admin=1&lider=".$id_cliente;                      
              // }

              if(!empty($_GET['admin']) && !empty($_GET['lider'])){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){
                    $ruta = "Pagos&admin=1&lider=".$_GET['lider']."&Banco=".$_GET['Banco']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }else{
                    $ruta = "Pagos&admin=1&lider=".$_GET['lider']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){
                    $ruta = "Pagos&admin=1&lider=".$_GET['lider']."&Banco=".$_GET['Banco'];                      
                  }else{
                    $ruta = "Pagos&admin=1&lider=".$_GET['lider'];                      
                  }
                }
              } else if($_SESSION['id_cliente']==$id_cliente){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){
                    $ruta = "Pagos&Banco=".$_GET['Banco']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }else{
                    $ruta = "Pagos&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){
                    $ruta = "Pagos&Banco=".$_GET['Banco'];
                  }else{
                    $ruta = "Pagos";
                  }
                }
              }else{
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){

                  }else{
                    $ruta = "Pagos&admin=1&lider=".$id_cliente."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){

                  }else{
                    $ruta = "Pagos&admin=1&lider=".$id_cliente;                      
                  }
                }
              }
            ?>

            <div class="box-body">

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>
              
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
                      <?php if ($tablasdatatable=="1"): ?>
                    <table class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                      <?php else: ?>
                    <table class="table table-bordered table-striped datatablee table_contado" style="text-align:center;min-width:100%;max-width:100%;">
                      <?php endif ?>

                      <thead>
                        <tr>
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                          <th>---</th>
                          <?php } ?>
                          <th>Nº</th>
                          <th>Fechas</th>
                          <th>Forma de Pago</th>
                          <th>Bancos</th>
                          <th>Referencia Bancaria</th>
                          <th>Monto</th>
                          <th>Tasa</th>
                          <th>Equivalencia</th>
                          <th>Concepto</th>
                          <th>---</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          $num = 1;
                          foreach ($pagos as $data){ if(!empty($data['id_pago'])){
                            $permitido = "0";
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$data['id_cliente']){
                                      $permitido = "1";
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                              $permitido = "1";
                            }
                            if($permitido=="1"){
                              if(mb_strtolower($data['tipo_pago'])==mb_strtolower($pagosR['name'])){ ?>
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
                                    <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                                    <td style="width:10%">
                                      <?php 
                                        if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                          <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                          
                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench"></span>
                                              </button>
                                            <?php endif; ?>
                                          
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                        
                                            <?php if($estado_campana=="1"){ ?>
                                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                <span class="fa fa-trash"></span>
                                              </button>
                                            <?php } ?>
                                          
                                          <?php }else{ ?>
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                          <?php } ?>
                                              
                                          <?php 
                                        }else{
                                          if( (($_SESSION['nombre_rol']=="Superusuario" && $superoppagodiviauto=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminoppagodiviauto=="1")) && ($data['forma_pago']=="Divisas Dolares" || $data['forma_pago']=="Efectivo Bolivares" || $data['forma_pago']=="Divisas Euros")){ ?>
                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                            <?php endif; ?>

                                              <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                <span class="fa fa-trash"></span>
                                              </button>
                                            <?php endif; ?>
                                              
                                            <?php
                                          }else if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                              <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                              <?php endif; ?>
                                            <?php endif ?>
                                            
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                            <?php if($estado_campana=="1"): ?>
                                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                  <span class="fa fa-trash"></span>
                                                </button>
                                              <?php endif; ?>
                                            <?php endif; ?>
                                          <?php }else{
                                            if($data['estado']!="Abonado"){ ?>
                                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                  <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $superanalistaeditarpago=="1")): ?>
                                                    <?php if($estado_campana=="1"): ?>
                                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                      <span class="fa fa-wrench">
                                                      </span>
                                                    </button>
                                                    <?php endif; ?>
                                                  <?php endif; ?>                                  
                                                  
                                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                                  <?php if($estado_campana=="1"): ?>
                                                    <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $superanalistaborrarpago=="1")): ?>
                                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                      <span class="fa fa-trash"></span>
                                                    </button>
                                                    <?php endif; ?>
                                                  <?php endif; ?>
                                                <?php else: ?>
                                                  <?php if($estado_campana=="1"): ?>
                                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                      <span class="fa fa-wrench">
                                                      </span>
                                                    </button>
                                                  <?php endif; ?>
                                                  
                                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                                  <?php if($estado_campana=="1"): ?>
                                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                        <span class="fa fa-trash"></span>
                                                      </button>
                                                      <?php endif; ?>
                                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                        <span class="fa fa-trash"></span>
                                                      </button>
                                                      <?php endif; ?>
                                                  <?php endif; ?>
                                                <?php endif; ?>
                                              <?php else: ?>
                                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                              <?php endif; ?>
                                              <?php 
                                            }else{ ?>
                                              <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                            <?php }
                                          } 
                                        } 
                                      ?>
                                    </td>
                                    <?php endif ?>
                                    <td style="width:5%">
                                      <span class="contenido2">
                                        <?php echo $num++; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                                      <span class="contenido2">
                                        <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                                        <br>
                                        <?php
                                          if(mb_strtolower($data['tipo_pago'])==mb_strtolower($pagosR['name'])){
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
                                        <small class='contenido_temporalidad'><?=$temporalidad?></small>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_forma_de_pago">
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
                                        <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                                      </span>
                                    </td>
                                    <td class="td_bancos">
                                      <span class="contenido2">
                                        <?php
                                          foreach ($bancos as $bank){ if (!empty($bank['id_banco'])){
                                            if ($bank['id_banco']==$data['id_banco']){ ?>
                                              <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                                <?php
                                            }
                                          } }
                                        ?>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_referencias">
                                      <span class="contenido2">
                                        <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_monto">
                                      <span class="contenido2">
                                        <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],4,',','.'); }else{ echo ""; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_equivalente">
                                      <span class="contenido2">
                                        <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <?php if($estado_campana=="1"){ ?>

                                        <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                                        <?php if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                          <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                          <?php } ?>
                                        <?php }else{ ?>
                                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                              <?php if ($_SESSION['nombre_rol']=="Analista"){ ?>
                                                    <?php if ($analistaaccesorapido=="1"){ ?>
                                                        <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                          <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <?php } ?> 
                                              <?php } else if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                                                    <?php if ($superanalistaaccesorapido=="1"){ ?>
                                                        <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                          <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <?php } ?>
                                              <?php } else if($_SESSION['nombre_rol']=="Conciliador"){ ?>
                                                    <?php if($data['id_banco']!=""){ ?>
                                                  <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-pencil"></span>
                                                  </button>
                                                    <?php } ?>
                                              <?php } else{ ?>
                                                  <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-pencil"></span>
                                                  </button>
                                              <?php } ?>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                                <?php if($data['id_banco']!=""){ ?>
                                                  <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php } ?>

                                                <?php if($data['id_banco']==""){ ?>
                                                  <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php } ?>

                                        <?php }else{ ?>
                                            <?php  if($data['estado']!="Abonado"){  ?>
                                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador" || $_SESSION['nombre_rol']=="Administrativo"){ if($data['id_banco']!=""){ ?>
                                                  <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php }} ?>

                                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ if($data['id_banco']==""){ ?>
                                                  <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php }} ?>
                                            <?php } ?>

                                        <?php } ?>
                                      <?php } ?>
                                    </td>
                                  </tr>
                                <?php 
                                  }
                              }
                            } ?> 
                          <?php } }
                        ?>
                      </tbody>

                      <tfoot>
                        <tr >
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"|| $_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
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
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style='padding:0;margin:0;'></th>
                          <?php endif; ?>
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
                              $premiosAbonadoInn = 0;
                              if( $abonadosPagos[$pagosR['id']] != 0){
                                $totalesPagos[$pagosR['id']] = $abonadosPagosPuntuales[$pagosR['id']] / $precio;
                                if($opcionOpcionalInicial=="Y"){
                                  if(!empty($abonadosPagos['inicial'])){
                                    $premiosAbonadoInn = $abonadosPagos['inicial'] / $precio;
                                  }
                                }
                              }else{
                                $totalesPagos[$pagosR['id']] = 0;
                              }

                              echo number_format($totalesPagos[$pagosR['id']],4,',','.');
                              // print_r($abonadosPagosPuntuales);
                              if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                                if(!empty($_GET['lider'])){
                                  if(!isset($acumuladosTotales[$pagosR['id']])){
                                    if($opcionOpcionalInicial=="Y"){
                                      echo "<br>"; 
                                      echo " + ";
                                      echo number_format($premiosAbonadoInn,2,',','.');
                                      $totalesPagos[$pagosR['id']] += $premiosAbonadoInn;
                                      echo "<br>"; 
                                      echo " = ";
                                      echo number_format($totalesPagos[$pagosR['id']],2,',','.'); 
                                    }
                                  }
                                }
                              }

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
                          <th style='padding:0;margin:0;'><h4><b>
                            <?php 
                              echo "$".number_format($equivalenciasPagos[$pagosR['id']],2, ",",".");
                              if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                                if(!empty($_GET['lider'])){
                                  if(!isset($acumuladosTotales[$pagosR['id']])){
                                    if($opcionOpcionalInicial=="Y"){
                                      if(!empty($abonadosPagos['inicial'])){
                                        echo "<br>";
                                        echo " + ";
                                        echo "$".number_format($abonadosPagos['inicial'],2, ",",".");
                                        $equivalenciasPagos[$pagosR['id']] += $abonadosPagos['inicial'];
                                        echo "<br>";
                                        echo " = ";
                                        echo "$".number_format($equivalenciasPagos[$pagosR['id']],2, ",",".");
                                      }
                                    }
                                  }
                                }
                              }
                            ?>


                          </b></h4></th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                                if(!empty($_GET['lider'])){
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
                              }
                            ?>
                            </b></h4>
                          </th>
                          <th style='padding:0;margin:0;'></th>
                        </tr>
                        <?php
                          $totalesDistribucion[$pagosR['id']] = 0;
                          $totalporcentajesDistribucion[$pagosR['id']] = 0;
                          $cantidadDistribucion[$pagosR['id']] = 0;
                          $cantidadDistribucionPremio[$pagosR['id']] = 0;
                          if(!empty($_GET['lider'])){
                            foreach ($distribucionPagos as $pagosDist) {
                              if(!empty($pagosDist['id_distribucion_pagos'])){
                                if($pagosDist['tipo_distribucion']==$pagosR['name']){
                                  $cantidadDistribucion[$pagosR['id']] = $pagosDist['cantidad_distribucion'];
                                }
                              }
                            }
                          }
                          if($cantidadDistribucion[$pagosR['id']]>0){
                            ?>
                            <tr style="background:#CCC;">
                              <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                              <th style='padding:0;margin:0;'></th>
                              <?php endif; ?>
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
                                  if(!empty($acumuladosTotales[$pagosR['id']])){

                                    if( $cantidadDistribucion[$pagosR['id']] != 0){
                                      $totalesDistribucion[$pagosR['id']] = $cantidadDistribucion[$pagosR['id']] / $precio;
                                    }else{
                                      $totalesDistribucion[$pagosR['id']] = 0;
                                    }
                                    $cantidadDistribucionPremio[$pagosR['id']] = $totalesPagos[$pagosR['id']] + $totalesDistribucion[$pagosR['id']];
                                    // echo number_format($totalesPagos[$pagosR['id']],2,',','.'); 
                                    echo " + ";
                                    echo number_format($totalesDistribucion[$pagosR['id']],2,',','.'); 
                                    echo "<br>";
                                    echo " = ";
                                    echo number_format($cantidadDistribucionPremio[$pagosR['id']],2,',','.'); 
                                  }else{
                                    if( $cantidadDistribucion[$pagosR['id']] != 0){
                                      $totalesDistribucion[$pagosR['id']] = $cantidadDistribucion[$pagosR['id']] / $precio;
                                      
                                    }else{
                                      $totalesDistribucion[$pagosR['id']] = 0;
                                    }
                                    $cantidadDistribucionPremio[$pagosR['id']] = $totalesPagos[$pagosR['id']] + $totalesDistribucion[$pagosR['id']];
                                    // echo number_format($totalesPagos[$pagosR['id']],2,',','.'); 
                                    echo " + ";
                                    echo number_format($totalesDistribucion[$pagosR['id']],2,',','.'); 
                                    echo "<br>";
                                    echo " = ";
                                    echo number_format($cantidadDistribucionPremio[$pagosR['id']],2,',','.'); 

                                  }
                                ?>
                                </b></h4>
                              </th>
                              <th style='padding:0;margin:0;'></th>
                              <th style='padding:0;margin:0;'><h4></h4></th>
                              <th style='padding:0;margin:0;'><h4></b></h4></th>
                              <th style='padding:0;margin:0;'><h4>Distribuido: </h4></th>
                              <th style='padding:0;margin:0;'><h4><b>
                                <?php 
                                  $equivalenteDistribucion = $equivalenciasPagos[$pagosR['id']] + $cantidadDistribucion[$pagosR['id']];
                                ?>
                                + $<?=number_format($cantidadDistribucion[$pagosR['id']],2, ",",".")?>
                                <br>
                                = $<?=number_format($equivalenteDistribucion,2, ",",".")?>
                              </b></h4></th>
                              <th style='padding:0;margin:0;'>
                                <h4><b>
                                <?php
                                  if($pagosR['name']!="Inicial"){
                                    if(!empty($_GET['lider'])){

                                      if(!empty($acumuladosTotales[$pagosR['id']])){
                                        if($acumuladosTotales[$pagosR['id']] != 0){
                                          $porcentajesDistribucion[$pagosR['id']] = ($cantidadDistribucion[$pagosR['id']] * 100) / $totalesPagosPagar[$pagosR['id']];
                                        }else{
                                          $porcentajesDistribucion[$pagosR['id']] = 0;
                                        }
                                        $totalporcentajesDistribucion[$pagosR['id']] = $porcentajeDePago[$pagosR['id']] + $porcentajesDistribucion[$pagosR['id']];
                                        // echo number_format($porcentajeDePago[$pagosR['id']],2,',','.')."%";
                                        echo " + ";
                                        echo number_format($porcentajesDistribucion[$pagosR['id']],2,',','.')."%";
                                        echo "<br>";
                                        echo " = ";
                                        echo number_format($totalporcentajesDistribucion[$pagosR['id']],2,',','.')."%";
                                        
                                      }else{

                                        // echo "<br>";
                                        // echo $nuevoTotal;
                                        // echo "<br>";
                                        // echo $cantidadDistribucion[$pagosR['id']];
                                        // echo "<br>";
                                        // echo $totalesPagosPagar[$pagosR['id']];
                                        // echo "<br>";
                                        
                                        if($nuevoTotal!=0){
                                          $porcentajesDistribucion[$pagosR['id']] = ($cantidadDistribucion[$pagosR['id']] * 100) / $nuevoTotal;
                                        }else{
                                          $porcentajesDistribucion[$pagosR['id']] = 0;
                                        }
                                        $totalporcentajesDistribucion[$pagosR['id']] = $porcentajeRestanteFinal + $porcentajesDistribucion[$pagosR['id']];
                                        
                                        // echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                        // echo " + ";
                                        // echo number_format($porcentajesDistribucion[$pagosR['id']],2,',','.')."%";
                                        // echo " = ";
                                        // echo number_format($totalporcentajesDistribucion[$pagosR['id']],2,',','.')."%";
                                      }
                                    }
                                  }
                                ?>
                                </b></h4>
                              </th>
                              <th style='padding:0;margin:0;'></th>
                            </tr>
                            <?php 
                          }
                        ?>
                      </tfoot>
                    </table>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta;?>">
                        <b style="color:#000 !important">Reportado de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadosPagos[$pagosR['id']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                        <b style="color:#000 !important">Diferido de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidosPagos[$pagosR['id']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado de<br><?=$pagosR['name']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
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
                  <?php 
                    $colorText = "";
                    if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                      $colorText = "#DD0000";
                    }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                      $colorText = "#00DD00";
                    }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                      $colorText = "#0000DD";
                    } else{
                      $colorText = "#0000DD";
                    }
                  ?>
                  <table id="" class="table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                    <thead>
                    
                    </thead>
                    <tbody>
                    
                      <tr>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%">
                          <?php if(!empty($_GET['lider'])){ ?>
                            <h4>Porcentaje: </h4>
                          <?php } ?>
                        </td>
                        <td style="width:8.5%">
                          <h4>
                            <b>
                              <?php 
                            
                                if(!empty($_GET['lider'])){
                                  // echo "Nuevo: ".$nuevoTotal."<br>";
                                  // echo "Abonado: ".$abonado."<br>";
                                  if($nuevoTotal!=0){
                                    $porcentajeRestanteFinal = ($abonado*100)/$nuevoTotal;
                                  }else{
                                    $porcentajeRestanteFinal = 0;
                                  }
                                  echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                }
                              ?>
                            </b>
                          </h4>
                        </td>
                        <td style="width:8.5%"></td>
                        <td><h4>Monto: </h4></td>
                        <td><h4><b><?=number_format($montosT,2, ",",".")?></b></h4></td>
                        
                        <td><h4 style="color:<?=$colorText; ?>">Total: </h4></td>
                        <td><h4><b style="color:<?=$colorText; ?>">$<?=number_format($abonado,2, ",",".")?></b></h4></td>

                        <?php if($nuevoTotal!=0 && !empty($_GET['lider'])){ ?>
                        <?php
                          $calcularExcedenteTotal = 0;
                          $mostrarExcedente = $nuevoTotal-$abonado;
                          if($totalExcedentesPagados>0){
                            $mostrarExcedente+=$totalExcedentesPagados;
                          }
                          $calcularExcedenteNegativo = ($mostrarExcedente*(-1));
                          if($calcularExcedenteNegativo>=0){
                            $calcularExcedenteTotal = $calcularExcedenteNegativo;
                            // $calcularExcedenteTotal = number_format($calcularExcedenteNegativo,2,',','.');
                          }
                        ?>
                        <td><h4 style="color:#DD0000">Resta: </h4></td>
                        <td><h4>
                          <b style="color:#DD0000">$<?=number_format($mostrarExcedente,2, ",","."); ?></b>
                          <?php if($distPagosEqvEx>0){ ?>
                          <small>
                            <br>
                            <b>-</b> $<?=number_format($distPagosEqvEx,2, ",","."); ?> distribuidos
                            <br>
                            <b> $<?=number_format($mostrarExcedente+$distPagosEqvEx,2, ",","."); ?></b>
                          </small>
                          <?php } ?>

                        </h4></td>
                        <?php }else{ ?>
                        <td></td>
                        <?php } ?>
                      </tr>
                    
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                  <hr>
                  <table id="" class="table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                    <thead></thead>
                    <tbody>
                      <?php 
                        if(!empty($_GET['lider'])){ 
                          // $nuevoTotal." | ".$abonado." | ".$descuentosTotales;
                          $distDisponible = $descuentosTotales-$distPagosEqv;
                          // $distDisponible = 0.1;
                        ?>
                        <tr>
                          <!-- <td style="width:8.5%"></td> -->
                          <td style="width:8.5%"></td>
                          <td><h4 style="color:/*#00DD00*/">Descuento total: <b style="color:/*#00DD00*/">$<?=number_format($descuentosTotales,2, ",",".")?></b></h4></td>
                          <td><h4 style="color:/*#00DD00;*/">Abonado: <b style="color:/*#00DD00;*/">$<?=number_format($abonado,2, ",",".")?></b></h4></td>
                          <td><h4 style="color:/*#00DD00*/">Descuento: <b style="color:#00DD00">$<?=number_format($descuentosTotales,2, ",",".")?></b></h4></td>
                          <td><h4 style="color:/*#DD0000*/">Distribuido: <b style="color:#DD0000">$<?=number_format($distPagosEqv,2, ",",".")?></b></h4></td>
                          <td colspan="2"><h4 style="color:/*#00DD00*/">Disponible: <b style="color:#00DD00">$<?=number_format($distDisponible,2, ",",".")?></b></h4></td>
                        </tr>
                        <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista2"){ ?>
                        <tr>
                          <td style="width:8.5%" colspan="7">
                            <a class="distribuirDescuentos">
                              <b><u style="color:<?=$fucsia; ?>;cursor:pointer;">Distribuir descuentos</u></b>
                            </a>
                          </td>
                        </tr>
                        <?php if((count($promociones)-1)>0 && $calcularExcedenteTotal > 0){ ?>
                        <tr>
                          <td style="width:8.5%" colspan="7">
                            <br><br><br>
                            <a class="distribuirExcedentes">
                              <b><u style="color:#DD0000;cursor:pointer;">Distribuir Excedentes</u></b>
                            </a>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php
                        }
                      ?>
                    </tbody>
                    <tfoot></tfoot>
                  </table>
                </div>
              </div>

              <hr>

              <?php foreach ($promociones as $promos){ if(!empty($promos['id_promocion'])){ ?>
                <?php if($promos['cantidad_aprobada_promocion']>0){ ?>
                <hr>
                <div class="box-header" id="promo_<?=$promos['id_promocion']; ?>">
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
                      <?php if ($tablasdatatable=="1"): ?>
                    <table  class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                      <?php else: ?>
                    <table  class="table table-bordered table-striped datatablee table_contado" style="text-align:center;min-width:100%;max-width:100%;">
                      <?php endif ?>

                      <thead>
                        <tr>
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                          <th>---</th>
                          <?php } ?>
                          <th>Nº</th>
                          <th>Fechas</th>
                          <th>Forma de Pago</th>
                          <th>Bancos</th>
                          <th>Referencia Bancaria</th>
                          <th>Monto</th>
                          <th>Tasa</th>
                          <th>Equivalencia</th>
                          <th>Concepto</th>
                          <th>---</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          $num = 1;
                          foreach ($pagos as $data){ if(!empty($data['id_pago'])){
                            $permitido = "0";
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$data['id_cliente']){
                                      $permitido = "1";
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                              $permitido = "1";
                            }
                            if($permitido=="1"){
                              if( mb_strtolower($data['tipo_pago']) == mb_strtolower($promos['nombre_promocion']) ){ 
                                ?>
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
                                    <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                                    <td style="width:10%">
                                      <?php 
                                        if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                          <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                          
                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench"></span>
                                              </button>
                                            <?php endif; ?>
                                          
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                        
                                            <?php if($estado_campana=="1"){ ?>
                                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                <span class="fa fa-trash"></span>
                                              </button>
                                            <?php } ?>
                                          
                                          <?php }else{ ?>
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                          <?php } ?>
                                              
                                          <?php 
                                        }else{
                                          if( (($_SESSION['nombre_rol']=="Superusuario" && $superoppagodiviauto=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminoppagodiviauto=="1")) && ($data['forma_pago']=="Divisas Dolares" || $data['forma_pago']=="Efectivo Bolivares" || $data['forma_pago']=="Divisas Euros")){ ?>
                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                            <?php endif; ?>

                                              <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                            <?php if($estado_campana=="1"): ?>
                                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                <span class="fa fa-trash"></span>
                                              </button>
                                            <?php endif; ?>
                                              
                                            <?php
                                          }else if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                              <?php if($estado_campana=="1"): ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                <span class="fa fa-wrench">
                                                  
                                                </span>
                                              </button>
                                              <?php endif; ?>
                                            <?php endif ?>
                                            
                                            <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                            <?php if($estado_campana=="1"): ?>
                                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                  <span class="fa fa-trash"></span>
                                                </button>
                                              <?php endif; ?>
                                            <?php endif; ?>
                                          <?php }else{
                                            if($data['estado']!="Abonado"){ ?>
                                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                                  <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $superanalistaeditarpago=="1")): ?>
                                                    <?php if($estado_campana=="1"): ?>
                                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                      <span class="fa fa-wrench">
                                                      </span>
                                                    </button>
                                                    <?php endif; ?>
                                                  <?php endif; ?>                                  
                                                  
                                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                                  <?php if($estado_campana=="1"): ?>
                                                    <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $superanalistaborrarpago=="1")): ?>
                                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                      <span class="fa fa-trash"></span>
                                                    </button>
                                                    <?php endif; ?>
                                                  <?php endif; ?>
                                                <?php else: ?>
                                                  <?php if($estado_campana=="1"): ?>
                                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                                      <span class="fa fa-wrench">
                                                      </span>
                                                    </button>
                                                  <?php endif; ?>
                                                  
                                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                                  <?php if($estado_campana=="1"): ?>
                                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                        <span class="fa fa-trash"></span>
                                                      </button>
                                                      <?php endif; ?>
                                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                                        <span class="fa fa-trash"></span>
                                                      </button>
                                                      <?php endif; ?>
                                                  <?php endif; ?>
                                                <?php endif; ?>
                                              <?php else: ?>
                                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                              <?php endif; ?>
                                              <?php 
                                            }else{ ?>
                                              <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                            <?php }
                                          } 
                                        } 
                                      ?>
                                    </td>
                                    <?php endif ?>
                                    <td style="width:5%">
                                      <span class="contenido2">
                                        <?php echo $num++; ?>
                                      </span>
                                    </td>
                                    <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                                      <span class="contenido2">
                                        <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                                        <br>
                                        <?php
                                          if(trim(mb_strtolower($data['tipo_pago']))==trim(mb_strtolower($promos['nombre_promocion']))){
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
                                        <small class='contenido_temporalidad'><?=$temporalidad; ?></small>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_forma_de_pago">
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
                                        <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                                      </span>
                                    </td>
                                    <td class="td_bancos">
                                      <span class="contenido2">
                                        <?php
                                          foreach ($bancos as $bank){ if (!empty($bank['id_banco'])){
                                            if ($bank['id_banco']==$data['id_banco']){ ?>
                                              <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                                <?php
                                            }
                                          } }
                                        ?>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_referencias">
                                      <span class="contenido2">
                                        <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_monto">
                                      <span class="contenido2">
                                        <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],4,',','.'); }else{ echo ""; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%" class="td_equivalente">
                                      <span class="contenido2">
                                        <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <?php if($estado_campana=="1"){ ?>

                                        <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                                        <?php if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                          <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                          <?php } ?>
                                        <?php }else{ ?>
                                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                              <?php if ($_SESSION['nombre_rol']=="Analista"){ ?>
                                                    <?php if ($analistaaccesorapido=="1"){ ?>
                                                        <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                          <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <?php } ?> 
                                              <?php } else if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                                                    <?php if ($superanalistaaccesorapido=="1"){ ?>
                                                        <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                          <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <?php } ?>
                                              <?php } else if($_SESSION['nombre_rol']=="Conciliador"){ ?>
                                                    <?php if($data['id_banco']!=""){ ?>
                                                  <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-pencil"></span>
                                                  </button>
                                                    <?php } ?>
                                              <?php } else{ ?>
                                                  <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-pencil"></span>
                                                  </button>
                                              <?php } ?>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                                <?php if($data['id_banco']!=""){ ?>
                                                  <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php } ?>

                                                <?php if($data['id_banco']==""){ ?>
                                                  <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php } ?>

                                        <?php }else{ ?>
                                            <?php  if($data['estado']!="Abonado"){  ?>
                                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador" || $_SESSION['nombre_rol']=="Administrativo"){ if($data['id_banco']!=""){ ?>
                                                  <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php }} ?>

                                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ if($data['id_banco']==""){ ?>
                                                  <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                                  </button>
                                                  <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                                  </button>
                                                <?php }} ?>
                                            <?php } ?>

                                        <?php } ?>
                                      <?php } ?>
                                    </td>
                                  </tr>
                                <?php 
                                  }
                              }
                            } ?> 
                          <?php } }
                        ?>
                      </tbody>

                      <tfoot>
                        <tr >
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"|| $_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
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
                          <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                          <th style='padding:0;margin:0;'></th>
                          <?php endif; ?>
                          <th style='padding:0;margin:0;'></th>
                          <th style='padding:0;margin:0;'>
                            <h5><b>Premios<br><?=$promos['nombre_promocion']; ?>:</b></h5>
                          </th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              $precio = $promos['precio_promocion'];
                                // echo "<br><br>";
                                // print_r($abonadosPagosPuntuales[$promos['id_promocion']]);
                                // echo "<br><br>";
                              if( $abonadosPagos[$promos['id_promocion']] != 0){
                                $premiosAbonadoInn = "";
                                $totalesPagos[$promos['id_promocion']] = $abonadosPagos[$promos['id_promocion']] / $precio;
                                // if($opcionOpcionalInicial=="Y"){
                                //   if(!empty($abonadosPagos['inicial'])){
                                //     $premiosAbonadoInn = $abonadosPagos['inicial'] / $precio;
                                //   }
                                // }
                              }else{
                                $totalesPagos[$promos['id_promocion']] = 0;
                              }
                              echo number_format($totalesPagos[$promos['id_promocion']],4,',','.');
                              // print_r($abonadosPagosPuntuales);
                              // if($promos['nombre_promocion']!="Contado" && $promos['nombre_promocion']!="Inicial"){
                              //   if(!empty($_GET['lider'])){
                              //     if(empty($acumuladosTotales[$promos['id_promocion']])){
                              //       if($opcionOpcionalInicial=="Y"){
                              //         echo "<br>"; 
                              //         echo " + ";
                              //         echo number_format($premiosAbonadoInn,2,',','.');
                              //         $totalesPagos[$promos['id_promocion']] += $premiosAbonadoInn;
                              //         echo "<br>"; 
                              //         echo " = ";
                              //         echo number_format($totalesPagos[$promos['id_promocion']],2,',','.'); 
                              //       }
                              //     }
                              //   }
                              // }

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
                          <th style='padding:0;margin:0;'><h4><b>
                            <?php 
                              echo "$".number_format($equivalenciasPagos[$promos['id_promocion']],2, ",",".");
                              // if($promos['nombre_promocion']!="Contado" && $promos['nombre_promocion']!="Inicial"){
                              //   if(!empty($_GET['lider'])){
                              //     if(empty($acumuladosTotales[$promos['id_promocion']])){
                              //       if($opcionOpcionalInicial=="Y"){
                              //         echo "<br>";
                              //         echo " + ";
                              //         echo "$".number_format($abonadosPagos['inicial'],2, ",",".");
                              //         $equivalenciasPagos[$promos['id_promocion']] += $abonadosPagos['inicial'];
                              //         echo "<br>";
                              //         echo " = ";
                              //         echo "$".number_format($equivalenciasPagos[$promos['id_promocion']],2, ",",".");
                              //       }
                              //     }
                              //   }
                              // }
                            ?>


                          </b></h4></th>
                          <th style='padding:0;margin:0;'>
                            <h4><b>
                            <?php
                              if($promos['nombre_promocion']!="Contado" && $promos['nombre_promocion']!="Inicial"){
                                if(!empty($_GET['lider'])){
                                    $totalPorPromo[$promos['id_promocion']] = $promos['precio_promocion']*$promos['cantidad_aprobada_promocion'];
                                    //print_r($equivalenciasPagos);
                                    // echo $equivalenciasPagos[$promos['id_promocion']];
                                    if($totalPorPromo[$promos['id_promocion']]!=0){
                                      $porcentajeRestanteFinal = ($abonadosPagos[$promos['id_promocion']]*100)/$totalPorPromo[$promos['id_promocion']];
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
                        <?php
                          $totalesDistribucion[$promos['id_promocion']] = 0;
                          $totalporcentajesDistribucion[$promos['id_promocion']] = 0;
                          $cantidadDistribucion[$promos['id_promocion']] = 0;
                          $cantidadDistribucionPremio[$promos['id_promocion']] = 0;
                          if(!empty($_GET['lider'])){
                            foreach ($distribucionPromos as $pagosDist) {
                              if(!empty($pagosDist['id_distribucion_pagos'])){
                                if($pagosDist['tipo_distribucion']==$promos['nombre_promocion']){
                                  $cantidadDistribucion[$promos['id_promocion']] = $pagosDist['cantidad_distribucion'];
                                }
                              }
                            }
                          }
                          if($cantidadDistribucion[$promos['id_promocion']]>0){
                            ?>
                            <tr style="background:#CCC;">
                              <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" ||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                              <th style='padding:0;margin:0;'></th>
                              <?php endif; ?>
                              <th style='padding:0;margin:0;'></th>
                              <th style='padding:0;margin:0;'>
                                <h5><b>Premios<br><?=$promos['nombre_promocion']; ?>:</b></h5>
                              </th>
                              <th style='padding:0;margin:0;'>
                                <h4><b>
                                <?php

                                  $precio = $promos['precio_promocion'];
                                  if(!empty($acumuladosTotales[$promos['id_promocion']])){

                                    if( $cantidadDistribucion[$promos['id_promocion']] != 0){
                                      $totalesDistribucion[$promos['id_promocion']] = $cantidadDistribucion[$promos['id_promocion']] / $precio;
                                    }else{
                                      $totalesDistribucion[$promos['id_promocion']] = 0;
                                    }
                                    $cantidadDistribucionPremio[$promos['id_promocion']] = $totalesPagos[$promos['id_promocion']] + $totalesDistribucion[$promos['id_promocion']];
                                    // echo number_format($totalesPagos[$promos['id_promocion']],2,',','.'); 
                                    echo " + ";
                                    echo number_format($totalesDistribucion[$promos['id_promocion']],2,',','.'); 
                                    echo "<br>";
                                    echo " = ";
                                    echo number_format($cantidadDistribucionPremio[$promos['id_promocion']],2,',','.'); 
                                  }else{
                                    if( $cantidadDistribucion[$promos['id_promocion']] != 0){
                                      $totalesDistribucion[$promos['id_promocion']] = $cantidadDistribucion[$promos['id_promocion']] / $precio;
                                      
                                    }else{
                                      $totalesDistribucion[$promos['id_promocion']] = 0;
                                    }
                                    $cantidadDistribucionPremio[$promos['id_promocion']] = $totalesPagos[$promos['id_promocion']] + $totalesDistribucion[$promos['id_promocion']];
                                    // echo number_format($totalesPagos[$promos['id_promocion']],2,',','.'); 
                                    echo " + ";
                                    echo number_format($totalesDistribucion[$promos['id_promocion']],2,',','.'); 
                                    echo "<br>";
                                    echo " = ";
                                    echo number_format($cantidadDistribucionPremio[$promos['id_promocion']],2,',','.'); 

                                  }
                                ?>
                                </b></h4>
                              </th>
                              <th style='padding:0;margin:0;'></th>
                              <th style='padding:0;margin:0;'><h4></h4></th>
                              <th style='padding:0;margin:0;'><h4></b></h4></th>
                              <th style='padding:0;margin:0;'><h4>Distribuido: </h4></th>
                              <th style='padding:0;margin:0;'><h4><b>
                                <?php 
                                  $equivalenteDistribucion = $equivalenciasPagos[$promos['id_promocion']] + $cantidadDistribucion[$promos['id_promocion']];
                                ?>
                                + $<?=number_format($cantidadDistribucion[$promos['id_promocion']],2, ",",".")?>
                                <br>
                                = $<?=number_format($equivalenteDistribucion,2, ",",".")?>
                              </b></h4></th>
                              <th style='padding:0;margin:0;'>
                                <h4><b>
                                <?php
                                  if($promos['nombre_promocion']!="Inicial"){
                                    if(!empty($_GET['lider'])){

                                      if(!empty($acumuladosTotales[$promos['id_promocion']])){
                                        if($acumuladosTotales[$promos['id_promocion']] != 0){
                                          $porcentajesDistribucion[$promos['id_promocion']] = ($cantidadDistribucion[$promos['id_promocion']] * 100) / $totalesPagosPagar[$promos['id_promocion']];
                                        }else{
                                          $porcentajesDistribucion[$promos['id_promocion']] = 0;
                                        }
                                        $totalporcentajesDistribucion[$promos['id_promocion']] = $porcentajeDePago[$promos['id_promocion']] + $porcentajesDistribucion[$promos['id_promocion']];
                                        // echo number_format($porcentajeDePago[$promos['id_promocion']],2,',','.')."%";
                                        echo " + ";
                                        echo number_format($porcentajesDistribucion[$promos['id_promocion']],2,',','.')."%";
                                        echo "<br>";
                                        echo " = ";
                                        echo number_format($totalporcentajesDistribucion[$promos['id_promocion']],2,',','.')."%";
                                        
                                      }else{

                                        // echo "<br>";
                                        // echo $nuevoTotal;
                                        // echo "<br>";
                                        // echo $cantidadDistribucion[$promos['id_promocion']];
                                        // echo "<br>";
                                        // echo $totalesPagosPagar[$promos['id_promocion']];
                                        // echo "<br>";
                                        
                                        if($nuevoTotal!=0){
                                          $porcentajesDistribucion[$promos['id_promocion']] = ($cantidadDistribucion[$promos['id_promocion']] * 100) / $nuevoTotal;
                                        }else{
                                          $porcentajesDistribucion[$promos['id_promocion']] = 0;
                                        }
                                        $totalporcentajesDistribucion[$promos['id_promocion']] = $porcentajeRestanteFinal + $porcentajesDistribucion[$promos['id_promocion']];
                                        
                                        // echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                        // echo " + ";
                                        // echo number_format($porcentajesDistribucion[$promos['id_promocion']],2,',','.')."%";
                                        // echo " = ";
                                        // echo number_format($totalporcentajesDistribucion[$promos['id_promocion']],2,',','.')."%";
                                      }
                                    }
                                  }
                                ?>
                                </b></h4>
                              </th>
                              <th style='padding:0;margin:0;'></th>
                            </tr>
                            <?php 
                          }
                        ?>
                      </tfoot>
                    </table>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta;?>">
                        <b style="color:#000 !important">Reportado de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                        <b style="color:#000 !important">Diferido de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado de<br><?=$promos['nombre_promocion']; ?></b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadosPagos[$promos['id_promocion']], 2, ",", ".")?></b></h4>
                      </a>
                    </div>
                  </div>
                  <br>
                </div>
                <?php } ?>
              <?php } } ?>

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>

              <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
              <span class="jsonPagos d-none"><?=json_encode($pagosRecorridos); ?></span>
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

  <div class="box-modalFichaDetalle" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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
                      <!-- <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3> -->
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                    <i><span class="name_firmayleyenda"></span></i>
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


                    <div class="row boxMarca" style="border-top:1px solid #EEE;display:none;">
                      <div class="col-xs-12" style="text-align:right;margin-top:0;padding-top:0;"> 
                        <small><i><span style="font-size:1.3em" class="ficha_detalle_marca"></span></i></small>
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

  <div class="box-modalEditar" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModal" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>

                  <div class="box-body">
                    <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                      <br>
                        <div class="col-xs-12" style="text-align:right;display:inline;margin-top:-20px;">
                          <?php 
                            $newRoute = "";
                            foreach ($_REQUEST as $key => $value) {
                              if($newRoute!=""){
                                $newRoute .= "&";  
                              }
                              if($key!="facturas"){
                                $newRoute .= $key."=".$value;
                              }
                            }
                          ?>
                          <?php if(empty($_GET['facturas'])){ $labeled = "Líderes"; ?>
                            <a href="?<?=$newRoute."&facturas=All"; ?>"><label><u>Todas las facturas</u></label></a>
                          <?php } ?>
                          <?php if(!empty($_GET['facturas']) && $_GET['facturas']=="All"){  $labeled = "Líderes de todas las campañas"; ?>
                            <a href="?<?=$newRoute; ?>"><label><u>Solo facturas de la campaña</u></label></a>
                          <?php } ?>
                        </div>
                      <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="lideresPedidos"><?=$labeled; ?></label>
                          <!-- <input type="date" > -->
                          <select id="lideresPedidos" name="lideresPedidos" class="form-control select2 lideresPedidos" style="width:100%;">
                            <option value=""></option>
                            <?php
                              foreach ($lideresPedidos as $lidped) {
                                if(!empty($lidped['id_pedido'])){
                                  if(!empty($_GET['facturas']) && $_GET['facturas']=="All"){
                                    $varMostrarLidPed = $lidped['cedula']." ".$lidped['primer_nombre']." ".$lidped['primer_apellido']." (Factura ".$lidped['numero_despacho']." ) ( ".$lidped['numero_campana']."/".$lidped['anio_campana']." )";
                                  }else{
                                    $varMostrarLidPed = $lidped['cedula']." ".$lidped['primer_nombre']." ".$lidped['primer_apellido']." (Factura ".$lidped['numero_despacho'].")";
                                  }
                                    ?>
                                  <option id="lidped<?=$lidped['id_pedido']; ?>" value="<?=$lidped['id_pedido']; ?>"><?=$varMostrarLidPed; ?></option>
                                    <?php
                                }
                              }
                            ?>
                          </select>
                          <span id="error_lideresPedidos" class="errors"></span>
                        </div>
                      </div>
                    <?php } ?>

                    <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2" readonly="">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" id="rol" name="rol" value="Analistas">
                    <div class="row">
                        <?php //print_r($pagosRecorridos); ?>
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="tipo_pago">Concepto de pago</label>
                          <select class="form-control tipo_pago" id="tipo_pago"  name="tipo_pago" style="width:100%;z-index:91000">
                            <option></option>
                            <?php foreach ($pagosRecorridos as $pagosR): ?>
                              <option class="opt_<?=$pagosR['id']; ?>"><?=$pagosR['name']; ?></option>
                            <?php endforeach ?>
                            <?php foreach ($promociones as $promos){ if(!empty($promos['id_promocion'])){ ?>
                              <?php if($promos['cantidad_aprobada_promocion']>0){ ?>
                                <option class="opt_<?=$promos['id_promocion']; ?>"><?=$promos['nombre_promocion']; ?></option>
                              <?php } ?>
                            <?php } } ?>
                             <!-- <option class="optContado">Contado</option> -->
                             <!-- <option class="optInicial">Inicial</option> -->
                             <!-- <option class="optPrimer">Primer Pago</option> -->
                             <!-- <option class="optCierre">Segundo Pago</option> -->
                           </select>
                           <span id="error_tipoPagoModal" class="errors"></span>
                        </div>
                        <input type="hidden" id="id_pago_modal" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tasa">Tasa del dolar asdasdassd</label>
                           <input type="number" class="form-control tasaModal" value="" step="0.01" min="<?=$limiteFechaMinimo?>" name="tasa" id="tasa" max="<?=date('Y-m-d')?>">
                           <span id="error_tasaModal" class="errors"></span>
                        </div>
                        <input type="hidden" id="id_pedido_temp" class="id_pedido_temp" name="id_pedido_temp">
                    </div>
                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <span class="col-xs-12 codigo_pago" style="font-weight:bold;"></span>
                    <?php } ?>
                  </div>

                  <div>
                    <div class="form-group col-xs-12" style="text-align:right;">
                      <span class="name_conciliador"></span>
                      <span class="name_leyenda"></span>
                      <span class="name_observ"></span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModal">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modal d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <?php 
    $displayDistribuir = "";
    if (!empty($_GET['distribucionConcepto'])){ 
      $displayDistribuir = "";
    }else{
      $displayDistribuir = "display:none;";
    }
  ?>
  <div class="box-modalDistribuir" style="<?=$displayDistribuir;?>;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDistribuir" style="background:#CCC"><b>X</b></span></div>
                    <form action="" method="GET" class="form cerrarFormDistribucionConcepto">
                      <input type="hidden" name="campaing" value="<?=$_GET['campaing'];?>">
                      <input type="hidden" name="n" value="<?=$_GET['n'];?>">
                      <input type="hidden" name="y" value="<?=$_GET['y'];?>">
                      <input type="hidden" name="dpid" value="<?=$_GET['dpid'];?>">
                      <input type="hidden" name="dp" value="<?=$_GET['dp'];?>">
                      <input type="hidden" name="route" value="<?=$_GET['route'];?>">
                      <input type="hidden" name="admin" value="<?=$_GET['admin'];?>">
                      <input type="hidden" name="lider" value="<?=$_GET['lider'];?>">
                    </form>


                    <div class="user-block">
                      <?php
                        // print_r($cliente);
                        if($cliente['fotoPerfil'] == ""){
                          $fotoPerfilClienteTemp = "public/assets/img/profile/";
                          if($cliente['sexo']=="Femenino"){$fotoPerfilClienteTemp .= "Femenino.png";}
                          if($cliente['sexo']=="Masculino"){$fotoPerfilClienteTemp .= "Masculino.png";} 
                          $cliente['fotoPerfil'] = $fotoPerfilClienteTemp;
                        }
                      ?>
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm" src="<?=$cliente['fotoPerfil'];?>" alt="user image">
                      <span class="username">
                        <h4><span><?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido']; ?></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Distribucion de descuentos</h3>
                  </div>
                  <div class="">
                    <?php
                      $cantidadDistDisponible = $distDisponible;
                      $cantidadDist = "";
                      if(!empty($_GET['distribucionConcepto']) && $_GET['distribucionConcepto']!=""){
                        if(count($busquedaDist)>1){
                          $cantidadDist = $busquedaDist[0]['cantidad_distribucion'];
                          $cantidadDistDisponible += $cantidadDist;
                        }
                      }
                      // echo " | ".$calcularExcedenteTotal." | ".$cantidadDist." | ".$cantidadDistDisponible." | ";
                      // echo $descuentosTotales."<br>";
                      // echo $calcularExcedenteTotal."<br>";
                      
                      // if($calcularExcedenteTotal >= 0){
                      //   $descuentosTotales += $calcularExcedenteTotal;
                      //   $distDisponible += $calcularExcedenteTotal;
                      //   $cantidadDistDisponible += $calcularExcedenteTotal;
                      // }
                      
                      if(number_format($cantidadDistDisponible,2)==0.0){
                        $cantidadDistDisponible = 0;
                      }
                      if ($cantidadDistDisponible>0){
                        $backg = "#00DD0088";
                      }else if ($cantidadDistDisponible==0){
                        $backg = "#0000CC88";
                      }else if ($cantidadDistDisponible<0){
                        $backg = "#CC000088";
                      }
                    ?>
                    <div class="form-group col-xs-12" style="text-align:right;padding-left:1%;padding-right:1%;">
                    <b><span class="name_estado" style="display:block;width:100%;background:<?=$backg; ?>;color:#545454;font-size:1.3em;padding:0px 30px">$<?=number_format($cantidadDistDisponible,2,',','.'); ?></span></b>
                    <span class="name_estado" style="display:block;width:100%;background:#CCC;color:#545454;font-size:1.3em;padding:0px 30px">
                      <table style="width:100%;text-align:center;">
                        <tr>
                          <td style="width:30%;">Total: <b>$<?=number_format($descuentosTotales,2,',','.'); ?></b></td>
                          <td style="width:5%;">|</td>
                          <td style="width:30%;">Distribuido: <b>$<?=number_format($distPagosEqv,2,',','.'); ?></b></td>
                          <td style="width:5%;">|</td>
                          <td style="width:30%;">Restante: <b>$<?=number_format($distDisponible,2,',','.'); ?></b></td>
                        </tr>
                      </table>
                    </span>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <?php 
                        $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");

                      ?>
                      <div class="form-group col-xs-12">
                        <?php
                          $conceptoPagoId = "";
                          $conceptoPago = "";
                          if(!empty($_GET['distribucionConcepto']) && $_GET['distribucionConcepto']!=""){
                            foreach ($pagosRecorridos as $pagosR){
                              if ($pagosR['id'] == $_GET['distribucionConcepto']){
                                $conceptoPago = $pagosR['name'];
                                $conceptoPagoId = $pagosR['id'];
                              }
                            }
                          }
                        ?>

                        <form action="" method="GET" class="form formDistribucionConcepto">
                          <input type="hidden" name="campaing" value="<?=$_GET['campaing'];?>">
                          <input type="hidden" name="n" value="<?=$_GET['n'];?>">
                          <input type="hidden" name="y" value="<?=$_GET['y'];?>">
                          <input type="hidden" name="dpid" value="<?=$_GET['dpid'];?>">
                          <input type="hidden" name="dp" value="<?=$_GET['dp'];?>">
                          <input type="hidden" name="route" value="<?=$_GET['route'];?>">
                          <input type="hidden" name="admin" value="<?=$_GET['admin'];?>">
                          <input type="hidden" name="lider" value="<?=$_GET['lider'];?>">
                          <label for="distribucionConcepto">Concepto de Pago</label>
                          <select class="form-control concepto_pago select2" id="distribucionConcepto"  name="distribucionConcepto" style="width:100%;z-index:91000">
                            <option></option>
                            <?php foreach ($pagosRecorridos as $pagosR){ if ($pagosR['name']!="Contado"){ ?>
                              <option value="<?=$pagosR['id']; ?>" class="opt_<?=$pagosR['id']; ?>" <?php if($conceptoPagoId==$pagosR['id']){ echo "selected"; } ?>><?=$pagosR['name']; ?></option>
                            <?php } } ?>
                          </select>
                          <span id="error_concepto_pago" class="errors"></span>
                        </form>

                      </div>
                    </div>
                    <input type="hidden" name="id_pedido" class="id_pedido_cantidadDistribucion" value="<?=$pedido['id_pedido']; ?>">
                    <input type="hidden" name="concepto_pago" class="concepto_pago_cantidadDistribucion"  value="<?=$conceptoPago; ?>">

                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="cantidadDistribucion">Distribución</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="number" class="form-control cantidadDistribucion" value="<?=$cantidadDist; ?>" placeholder="0" step="0.01" name="cantidadDistribucion" id="cantidadDistribucion" max="<?=$cantidadDistDisponible; ?>">
                        </div>
                        <span id="error_cantidadDistribucion" class="errors"></span>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <?php 
                      if(!empty($_GET['distribucionConcepto']) && $_GET['distribucionConcepto']!=""){
                    ?>
                    <span type="submit" class="btn enviar enviarModalDistribuir">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDistribuir d-none" disabled="" >enviar</button>
                    <?php 
                      }
                    ?>
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


    <?php 
    $displayDistribuirEx = "";
    if (!empty($_GET['distribucionConceptoEx'])){ 
      $displayDistribuirEx = "";
    }else{
      $displayDistribuirEx = "display:none;";
    }
    // HaciendoCambios
  ?>
  <div class="box-modalDistribuirEx" style="<?=$displayDistribuirEx;?>;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDistribuirEx" style="background:#CCC"><b>X</b></span></div>
                    <form action="" method="GET" class="form cerrarFormDistribucionConceptoEx">
                      <input type="hidden" name="campaing" value="<?=$_GET['campaing'];?>">
                      <input type="hidden" name="n" value="<?=$_GET['n'];?>">
                      <input type="hidden" name="y" value="<?=$_GET['y'];?>">
                      <input type="hidden" name="dpid" value="<?=$_GET['dpid'];?>">
                      <input type="hidden" name="dp" value="<?=$_GET['dp'];?>">
                      <input type="hidden" name="route" value="<?=$_GET['route'];?>">
                      <input type="hidden" name="admin" value="<?=$_GET['admin'];?>">
                      <input type="hidden" name="lider" value="<?=$_GET['lider'];?>">
                    </form>


                    <div class="user-block">
                      <?php
                        // print_r($cliente);
                        if($cliente['fotoPerfil'] == ""){
                          $fotoPerfilClienteTemp = "public/assets/img/profile/";
                          if($cliente['sexo']=="Femenino"){$fotoPerfilClienteTemp .= "Femenino.png";}
                          if($cliente['sexo']=="Masculino"){$fotoPerfilClienteTemp .= "Masculino.png";} 
                          $cliente['fotoPerfil'] = $fotoPerfilClienteTemp;
                        }
                      ?>
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm" src="<?=$cliente['fotoPerfil'];?>" alt="user image">
                      <span class="username">
                        <h4><span><?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido']; ?></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Distribucion de excedentes</h3>
                  </div>
                  <div class="">
                    <?php 
                        #$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");

                      ?>
                    <?php
                      // $PromosTomarEnCuenta = "";
                      // $numberIndex2 = 0;
                      // foreach ($promociones as $promoPagos){ if(!empty($promoPagos['id_promocion'])){
                      //   $PromosTomarEnCuenta .= "'".$promoPagos['nombre_promocion']."'";
                      //   if($numberIndex2<=(count($promociones)-3) ){
                      //     $PromosTomarEnCuenta .= ", ";
                      //   }
                      //   $numberIndex2++;
                      // } }
                      // echo $PromosTomarEnCuenta."<br>";
                      // $distribucionPromos = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$pedido['id_pedido']} and tipo_distribucion in ($PromosTomarEnCuenta)");
                      // $distPagosEqvEx = 0;
                      // foreach ($distribucionPromos as $key) { if(!empty($key['id_distribucion_pagos'])){
                      //   $distPagosEqvEx += $key['cantidad_distribucion'];
                      // } }
                      // print_r($distribucionPromos);


                      $descuentosTotalesEx = $calcularExcedenteTotal;
                      $distDisponibleEx = $calcularExcedenteTotal;
                      $cantidadDistDisponibleEx = $distDisponibleEx;
                      $cantidadDistDisponibleEx -= $distPagosEqvEx;
                      $distDisponibleEx -= $distPagosEqvEx;
                      
                      // echo "TOTAL: ".$descuentosTotalesEx."<br>";
                      // echo "Utilizado: ".$distPagosEqvEx."<br>";
                      // echo "TOTAL - Utilizado: ".$cantidadDistDisponibleEx."<br>";
                      // echo "RESTANTE: ".$distDisponibleEx."<br>";
                      

                      $cantidadDistEx = "";
                      if(!empty($_GET['distribucionConceptoEx']) && $_GET['distribucionConceptoEx']!=""){
                        if(count($busquedaDist)>1){
                          $cantidadDistEx = $busquedaDist[0]['cantidad_distribucion'];
                          $cantidadDistDisponibleEx += $cantidadDistEx;
                        }
                      }
                      // echo " | ".$calcularExcedenteTotal." | ".$cantidadDist." | ".$cantidadDistDisponible." | ";
                      // echo $descuentosTotales."<br>";
                      // echo $calcularExcedenteTotal."<br>";

                      if(number_format($cantidadDistDisponibleEx,2)==0.0){
                        $cantidadDistDisponibleEx = 0;
                      }
                      if ($cantidadDistDisponibleEx>0){
                        $backg = "#00DD0088";
                      }else if ($cantidadDistDisponibleEx==0){
                        $backg = "#0000CC88";
                      }else if ($cantidadDistDisponibleEx<0){
                        $backg = "#CC000088";
                      }
                    ?>
                    <div class="form-group col-xs-12" style="text-align:right;padding-left:1%;padding-right:1%;">
                    <b><span class="name_estado" style="display:block;width:100%;background:<?=$backg; ?>;color:#545454;font-size:1.3em;padding:0px 30px">$<?=number_format($cantidadDistDisponibleEx,2,',','.'); ?></span></b>
                    <span class="name_estado" style="display:block;width:100%;background:#CCC;color:#545454;font-size:1.3em;padding:0px 30px">
                      <table style="width:100%;text-align:center;">
                        <tr>
                          <td style="width:30%;">Total: <b>$<?=number_format($descuentosTotalesEx,2,',','.'); ?></b></td>
                          <td style="width:5%;">|</td>
                          <td style="width:30%;">Distribuido: <b>$<?=number_format($distPagosEqvEx,2,',','.'); ?></b></td>
                          <td style="width:5%;">|</td>
                          <td style="width:30%;">Restante: <b>$<?=number_format($distDisponibleEx,2,',','.'); ?></b></td>
                        </tr>
                      </table>
                    </span>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      
                      <div class="form-group col-xs-12">
                        <?php
                          $conceptoPagoId = "";
                          $conceptoPago = "";
                          if(!empty($_GET['distribucionConceptoEx']) && $_GET['distribucionConceptoEx']!=""){
                            // foreach ($pagosRecorridos as $pagosR){
                            //   if ($pagosR['id'] == $_GET['distribucionConcepto']){
                            //     $conceptoPago = $pagosR['name'];
                            //     $conceptoPagoId = $pagosR['id'];
                            //   }
                            // }
                            foreach ($promociones as $promoPagos) {
                              if(!empty($promoPagos['id_promocion'])){
                                if ($promoPagos['id_promocion'] == $_GET['distribucionConceptoEx']){
                                  $conceptoPago = $promoPagos['nombre_promocion'];
                                  $conceptoPagoId = $promoPagos['id_promociones'];
                                }
                              }
                            }
                          }
                        ?>

                        <form action="" method="GET" class="form formDistribucionConceptoEx">
                          <input type="hidden" name="campaing" value="<?=$_GET['campaing'];?>">
                          <input type="hidden" name="n" value="<?=$_GET['n'];?>">
                          <input type="hidden" name="y" value="<?=$_GET['y'];?>">
                          <input type="hidden" name="dpid" value="<?=$_GET['dpid'];?>">
                          <input type="hidden" name="dp" value="<?=$_GET['dp'];?>">
                          <input type="hidden" name="route" value="<?=$_GET['route'];?>">
                          <input type="hidden" name="admin" value="<?=$_GET['admin'];?>">
                          <input type="hidden" name="lider" value="<?=$_GET['lider'];?>">
                          <label for="distribucionConceptoEx">Concepto de Pago</label>
                          <select class="form-control concepto_pago select2" id="distribucionConceptoEx"  name="distribucionConceptoEx" style="width:100%;z-index:91000">
                            <option></option>
                            <?php
                              foreach ($promociones as $promoPagos) {
                                if(!empty($promoPagos['id_promocion'])){
                                  if($promoPagos['cantidad_aprobada_promocion']>0){ ?> 
                                    <option value="<?=$promoPagos['id_promociones']; ?>" class="opt_<?=$promoPagos['id_promocion'];  ?>" <?php if($conceptoPagoId==$promoPagos['id_promociones']){ echo "selected"; } ?>><?=$promoPagos['nombre_promocion']; ?></option>
                                    <?php
                                  }
                                }
                              }
                            ?>
                          </select>
                          <span id="error_concepto_pago" class="errors"></span>
                        </form>

                      </div>
                    </div>
                    <input type="hidden" name="id_pedido" class="id_pedido_cantidadDistribucionEx" value="<?=$pedido['id_pedido']; ?>">
                    <input type="hidden" name="concepto_pago" class="concepto_pago_cantidadDistribucionEx"  value="<?=$conceptoPago; ?>">

                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="cantidadDistribucionEx">Distribución</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="number" class="form-control cantidadDistribucionEx" value="<?=$cantidadDistEx; ?>" placeholder="0" step="0.01" name="cantidadDistribucionEx" id="cantidadDistribucionEx" max="<?=$cantidadDistDisponibleEx; ?>">
                        </div>
                        <span id="error_cantidadDistribucionEx" class="errors"></span>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <?php 
                      if(!empty($_GET['distribucionConceptoEx']) && $_GET['distribucionConceptoEx']!=""){
                    ?>
                    <span type="submit" class="btn enviar enviarModalDistribuirEx">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDistribuirEx d-none" disabled="" >enviar</button>
                    <?php 
                      }
                    ?>
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


  <div class="box-modalEditarConciliador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalConciliador" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>
                

                  <div>
                    <div class="form-group col-xs-12" style="text-align:right;font-size:1.2em;">
                      <span class="name_conciliador"></span>
                      <span class="name_leyenda"></span>
                      <span class="name_observ"></span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <!-- <span type="submit" class="btn enviar enviarModal">Enviar</span> -->
                    <!-- <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>"> -->
                    <!-- <button class="btn-enviar-modal d-none" disabled="" >enviar</button> -->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalAprobarConcialiador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalAprobarConciliadores" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php
                          $primer_nombre = $_SESSION['cuenta']['primer_nombre']; 
                          $primer_apellido = $_SESSION['cuenta']['primer_apellido'];
                        ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firma">Firma</label>
                           <input type="hidden" value="<?=$primer_nombre." ".$primer_apellido?>" class="newFirma" name="newFirma">
                           <input type="text" class="form-control firmaModal firma" step="0.01" value="<?=$primer_nombre." ".$primer_apellido?>" name="firma" id="firma" readonly>
                           <span id="error_firmaModal" class="errors"></span>
                            <span class="name_conciliador"></span>
                        </div>
                        <!-- <div> -->
                          <!-- <div class="form-group col-xs-12" style="text-align:right;"> -->
                          <!-- </div> -->
                        <!-- </div> -->
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyenda">Leyenda</label>
                           <input type="text" class="form-control leyendaModal leyenda" step="0.01" min="<?=$limiteFechaMinimo?>" name="leyenda" id="leyenda" max="<?=date('Y-m-d')?>">
                           <span id="error_leyendaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalAprobadoConciliadores">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalAprobadoConciliadores d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalDiferirConcialiador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDiferirConciliadores" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php
                          $primer_nombre = $_SESSION['cuenta']['primer_nombre']; 
                          $primer_apellido = $_SESSION['cuenta']['primer_apellido'];
                        ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirma">Firma</label>
                           <input type="hidden" value="<?=$primer_nombre." ".$primer_apellido?>" class="newFirma" name="newFirma">
                           <input type="text" class="form-control diferirFirmaModal firma" step="0.01" value="<?=$primer_nombre." ".$primer_apellido?>" name="firma" id="diferirFirma" readonly>
                           <span id="error_diferirFirmaModal" class="errors"></span>
                            <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacion">Motivo</label>
                           <select class="form-control observacion" id="observacion"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optComprobante">Se solicita comprobante</option>
                             <option class="optActFecha">Actualizar fecha</option>
                             <option class="optActBanco">Actualizar banco</option>
                             <option class="optActReferencia">Actualizar referencia</option>
                             <option class="optActMonto">Actualizar monto</option>
                             <option class="optRepetido">Repetido</option>
                             <option class="optOtraEmpresa">No realizado a la empresa</option>
                           </select>
                           <span id="error_observacionModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDiferidoConciliadores">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDiferidoConciliadores d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalAprobarAnalista" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalAprobarAnalista" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estadoAnalistaModal" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firmaAnalista">Firma</label>
                           <input type="text" class="form-control firmaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="firmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_firmaAnalistaModal" class="errors"></span>
                           <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyendaAnalista">Leyenda</label>
                           <input type="text" class="form-control leyendaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="leyenda" id="leyendaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_leyendaAnalistaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalAprobadoAnalista">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalAprobadoAnalista d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalDiferirAnalista" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDiferirAnalista" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirmaAnalista">Firma</label>
                           <input type="text" class="form-control diferirFirmaAnalistaModal firma" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="diferirFirmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_diferirFirmaAnalistaModal" class="errors"></span>
                           <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacionAnalista">Motivo</label>
                           <select class="form-control observacionAnalista observacion" id="observacionAnalista"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optPendienteEntregar">Pendiente Por Entregar</option>
                             <option class="optPendienteSustituir">Billete Devuelto Pendiente por Sustituir</option>
                             <option class="optMalEstado">En mal estado, sustituido por deposito - Dolares</option>
                           </select>
                           <span id="error_observacionAnalistaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDiferidoAnalista">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDiferidoAnalista d-none" disabled="" >enviar</button>
                  </div>
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
<!-- 
  fa-calendar-times-o
  fa-calendar-check-o
-->
<script>
function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
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
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=Pagoss";
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

  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".selectbanco").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_banco").submit();
    }
  });
  
  $(".diferirPagoBtnConciliadores").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        // alert(data['firma']);
        if(data['firma'] == ""){
        }else if(data['firma'] == null){
        }else{
          // $(".diferirFirmaModal").val(data['firma']);
        }

        if(data['observacion']=="Repetido"){
          $(".optRepetido").attr("selected","selected");
        }
        if(data['observacion']=="Se solicita comprobante"){
          $(".optComprobante").attr("selected","selected");
        }
        if(data['observacion']=="No realizado a la empresa"){
          $(".optOtraEmpresa").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar fecha"){
          $(".optActFecha").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar banco"){
          $(".optActBanco").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar referencia"){
          $(".optActReferencia").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar monto"){
          $(".optActMonto").attr("selected","selected");
        }

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }

      }
    });
    $(".box-modalDiferirConcialiador").fadeIn(500);
  });
  $(".enviarModalDiferidoConciliadores").click(function(){
    var exec = false;
    $("#error_diferirFirmaModal").html("");
    $("#error_observacionModal").html("");
    // alert($(".diferirFirmaModal").val());
    // alert($(".observacion").val());
    if($(".diferirFirmaModal").val()=="" || $(".observacion").val()==""){
      if($(".diferirFirmaModal").val()==""){
        $("#error_diferirFirmaModal").html("Debe dejar su firma");
      }
      if($(".observacion").val()==""){
        $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){ 
      var estado = $(".box-modalDiferirConcialiador .estado").val();
      var firma = $(".box-modalDiferirConcialiador .firma").val();
      var newFirma = $(".box-modalDiferirConcialiador .newFirma").val();
      var observacion = $(".box-modalDiferirConcialiador .observacion").val();
      var id_pago_modal = $(".box-modalDiferirConcialiador .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoConciliadores").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            newFirma: newFirma,
            observacion: observacion,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
              // $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
              // $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
              // $(".tr"+id_pago_modal+" .modificarBtn").hide();
              // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirConciliadores").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirConciliadores").click();
              });
            }
          }
        });
    }
  });
  $(".cerrarModalDiferirConciliadores").click(function(){
    $(".box-modalDiferirConcialiador").fadeOut(500);
  });

  $(".diferirPagoBtnAnalista").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".diferirFirmaAnalistaModal").val(data['firma']);
        if(data['observacion']=="Pendiente Por Entregar"){
          $(".optPendienteEntregar").attr("selected","selected");
        }
        if(data['observacion']=="Billete Devuelto Pendiente por Sustituir"){
          $(".optPendienteSustituir").attr("selected","selected");
        }
        if(data['observacion']=="En mal estado, sustituido por deposito - Dolares"){
          $(".optMalEstado").attr("selected","selected");
        }
        

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }
        

      }
    });
    $(".box-modalDiferirAnalista").fadeIn(500);
  });
  $(".enviarModalDiferidoAnalista").click(function(){
    var exec = false;
    $("#error_diferirFirmaAnalistaModal").html("");
    $("#error_observacionModal").html("");
    // alert($(".diferirFirmaAnalistaModal").val());
    // alert($(".observacion").val());
    if($(".diferirFirmaAnalistaModal").val()=="" || $(".observacion").val()==""){
      if($(".diferirFirmaAnalistaModal").val()==""){
        $("#error_diferirFirmaAnalistaModal").html("Debe dejar su firma");
      }
      if($(".observacion").val()==""){
        $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
      }
    }else{
      exec=true;
    }
    if(exec==true){ 
      var estado = $(".box-modalDiferirAnalista .estado").val();
      var firma = $(".box-modalDiferirAnalista .firma").val();
      var observacion = $(".box-modalDiferirAnalista .observacion").val();
      var id_pago_modal = $(".box-modalDiferirAnalista .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoAnalista").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            observacion: observacion,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
              // $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
              // $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
              // $(".tr"+id_pago_modal+" .modificarBtn").hide();
              // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirAnalista").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirAnalista").click();
              });
            }
          }
        });
    }
  });
  $(".cerrarModalDiferirAnalista").click(function(){
    $(".box-modalDiferirAnalista").fadeOut(500);
  });

  
  $(".aprobarPagoBtnConciliadores").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        // $(".firmaModal").val(data['firma']);
        if(data['firma'] == ""){
        }else if(data['firma'] == null){
        }else{
          // $(".firmaModal").val(data['firma']);
        }
        $(".leyendaModal").val(data['leyenda']);
        
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


      }
    });
    $(".box-modalAprobarConcialiador").fadeIn(500);
  });
  $(".enviarModalAprobadoConciliadores").click(function(){
    var exec = false;
    $("#error_firmaModal").html("");
    $("#error_leyendaModal").html("");

    // if($(".firmaModal").val()=="" || $(".leyendaModal").val()==""){
    if($(".firmaModal").val()==""){
      if($(".firmaModal").val()==""){
        $("#error_firmaModal").html("Debe dejar su firma");
      }
      // if($(".leyendaModal").val()==""){
      //   $("#error_leyendaModal").html("Debe agregar la leyenda del pago");
      // }
    }else{
      exec=true;
    }

    if(exec==true){ 
      var estado = $(".box-modalAprobarConcialiador .estado").val();
      var firma = $(".box-modalAprobarConcialiador .firma").val();
      var newFirma = $(".box-modalAprobarConcialiador .newFirma").val();
      var leyenda = $(".box-modalAprobarConcialiador .leyenda").val();
      var id_pago_modal = $(".box-modalAprobarConcialiador .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoConciliadores").click();


        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            newFirma: newFirma,
            leyenda: leyenda,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
              $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
              $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
              $(".tr"+id_pago_modal+" .modificarBtn").hide();
              $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarConciliadores").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarConciliadores").click();
              });
            }
          }
        });
    }
  });
  $(".cerrarModalAprobarConciliadores").click(function(){
    $(".box-modalAprobarConcialiador").fadeOut(500);
  });

  $(".aprobarPagoBtnAnalista").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);


        // alert(data['fecha_pago']);
        // $(".fecha_pago_modal2").val(data['fecha_pago']);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".firmaAnalistaModal").val(data['firma']);
        $(".leyendaAnalistaModal").val(data['leyenda']);
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }
      }
    });
    $(".box-modalAprobarAnalista").fadeIn(500);
  });
  $(".enviarModalAprobadoAnalista").click(function(){
    var exec = false;
    $("#error_firmaAnalistaModal").html("");
    $("#error_leyendaAnalistaModal").html("");

    if($(".firmaAnalistaModal").val()=="" || $(".leyendaAnalistaModal").val()==""){
      if($(".firmaAnalistaModal").val()==""){
        $("#error_firmaAnalistaModal").html("Debe dejar su firma");
      }
      if($(".leyendaAnalistaModal").val()==""){
        $("#error_leyendaAnalistaModal").html("Debe agregar la leyenda del pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){ 
      var estado = $(".box-modalAprobarAnalista .estadoAnalistaModal").val();
      var firma = $(".box-modalAprobarAnalista .firmaAnalistaModal").val();
      var leyenda = $(".box-modalAprobarAnalista .leyendaAnalistaModal").val();
      var id_pago_modal = $(".box-modalAprobarAnalista .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoAnalista").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            leyenda: leyenda,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
              $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
              $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
              $(".tr"+id_pago_modal+" .modificarBtn").hide();
              $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarAnalista").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarAnalista").click();
              });
            }
          }
        });
    }
  });
  $(".cerrarModalAprobarAnalista").click(function(){
    $(".box-modalAprobarAnalista").fadeOut(500);
  });


  $(".cerrarModalConciliador").click(function(){
    $(".box-modalEditarConciliador").fadeOut(500);
  });
  $(".editarPagoBtnConciliador").click(function(){
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

        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


        var estado = "Reportado";
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,0,165,.65);");
          // rgba(0,0,160,.6)
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(165,0,0,.65);");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,165,0,.65);"); 
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
        }


        $(".box-modalEditarConciliador").fadeIn(500);
      }
    });
  });


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
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,0,165,.65);");
          $(".name_firmayleyenda").html("");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(165,0,0,.65);"); 
          $(".name_estado").html(estado);
          $(".name_firmayleyenda").html("");
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,165,0,.65);");
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
          $(".name_observacion").html("");
          $(".name_firmayleyenda").html('Por <b>'+data['firma']+':</b> '+data['leyenda']);

        }

        if(data['marca']!=null){
          $(".boxMarca").show();
          $(".ficha_detalle_marca").html("Cargado por: "+data['marca']);
        }else{
          $(".boxMarca").hide();
          $(".ficha_detalle_marca").html("");
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


  $(".cerrarModal").click(function(){
    $(".box-modalEditar").fadeOut(500);
  });
  $(".enviarModal").click(function(){
    var exec = false;
    $("#error_tipoPagoModal").html("");
    $("#error_tasaModal").html("");
    $("#error_fechaPagoModal2").html("");

    // alert($(".fecha_pago_modal2").val());

    // if($(".tipo_pago").val()=="" || $(".tasaModal").val()=="" || $(".fecha_pago_modal2").val()==""){
    if($(".tipo_pago").val()=="" || $(".fecha_pago_modal2").val()==""){
      if($(".tipo_pago").val()==""){
        $("#error_tipoPagoModal").html("Debe seleccionar un concepto de pago");
      }
      // if($(".tasaModal").val()==""){
      //   $("#error_tasaModal").html("Debe agregar la tasa del dolar");
      // }
      if($(".fecha_pago_modal2").val()==""){
        $("#error_fechaPagoModal2").html("Debe agregar la fecha del pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){
      var id_pedido_new = $("#id_pedido_temp").val();
      var fecha_pago = $("#fecha_pago").val(); 
      var rol = $("#rol").val(); 
      var tipo_pago = $("#tipo_pago").val(); 
      var id_pago_modal = $("#id_pago_modal").val(); 
      var tasa = $("#tasa").val();
      
        $.ajax({
          url:'',
          type:"POST",
          data:{
            fecha_pago: fecha_pago,
            id_pedido_temp: id_pedido_new,
            rol: rol,
            tipo_pago: tipo_pago,
            id_pago_modal: id_pago_modal,
            tasa: tasa,
          },
          success: function(respuesta){
            alert(respuesta);
            // console.log(respuesta);
            var data = JSON.parse(respuesta);
            if(data['exec']=="1"){
              var pago = data['pago'];
              var despacho = data['despacho'];

              
              // $(".tr"+id_pago_modal+" .contenido_forma_pago").html(pago['contenido_forma_pago']);
              // $(".tr"+id_pago_modal+" .contenido_banco").html(pago['fecha_pago_format']);
              // $(".tr"+id_pago_modal+" .contenido_referencia").html(pago['referencia_pago_format']);
              // $(".tr"+id_pago_modal+" .contenido_monto").html(pago['monto_pago_format']);
              var restriccion = "";
              var temporalidad = "";
              if(pago['tipo_pago']=="Contado"){
                restriccion = despacho['fecha_inicial_senior'];
              }
              if(pago['tipo_pago']=="Inicial"){
                restriccion = despacho['fecha_inicial_senior'];
              }
              if(pago['tipo_pago']=="Primer Pago"){
                restriccion = despacho['fecha_primera_senior'];
              }
              if(pago['tipo_pago']=="Segundo Pago"){
                restriccion = despacho['fecha_segunda_senior'];
              }

              if(pago['fecha_pago'] <= restriccion){
                temporalidad = "Puntual";
              }else{
                temporalidad = "Impuntual";
              }
              
              var year = pago['fecha_pago'].substr(0, 4);
              var mes = pago['fecha_pago'].substr(5, 2);
              var dia = pago['fecha_pago'].substr(8, 2);

              $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);

              var fecha_modal = $(".tr"+id_pago_modal+" .contenido_fecha_pago").html();
              var Ndia = fecha_modal.substr(0, 2);
              var Nmes = fecha_modal.substr(3, 2);
              var Nyear = fecha_modal.substr(6, 4);
              var newfecha_modal = Nyear+"-"+Nmes+"-"+Ndia;
              
              $(".tr"+id_pago_modal+" .contenido_fecha_pago").html(pago['fecha_pago_format']);
              $(".tr"+id_pago_modal+" .contenido_temporalidad").html(temporalidad);
              if(pago['tasa_pago']!=null){
                $(".tr"+id_pago_modal+" .contenido_tasa").html(pago['tasa_pago_format']);
                $(".tasaModal").val(pago['tasa_pago']);
              }else{
                $(".tr"+id_pago_modal+" .contenido_tasa").html("");
              }
              var signo = "";
              if(pago['forma_pago']=="Divisas Euros"){
                signo = "€";
              }else{
                signo = "$";
              }
              $(".tr"+id_pago_modal+" .contenido_equivalente").html(signo+pago['equivalente_pago_format']);
              $(".tr"+id_pago_modal+" .contenido_tipo_pago").html(pago['tipo_pago']);

              if(pago['estado']!="Abonado"){
                if(newfecha_modal!=pago['fecha_pago']){
                  $(".tr"+id_pago_modal).attr("style","background:;");
                }
              }

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModal").click();
              });
            }
            if(data['exec']=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                // $(".cerrarModal").click();
              });
            }

            // alert(id_pago_modal);
            // $(".tr"+id_pago_modal).attr();
            // $(".tr"+id_pago_modal).attr("style","background:purple");
            // $("#fecha_pago").val(fecha_pago); 
            // $("#tipo_pago").val(tipo_pago); 
            // $("#tasa").val(tasa); 
          }
          });



      // $(".btn-enviar-modal").removeAttr("disabled","");
      // $(".btn-enviar-modal").click();
    }
  });
  $("#lideresPedidos").change(function(){
    var idped = $(this).val();
    $("#id_pedido_temp").val(idped);
  });
  $(".editarPagoBtn").click(function(){
    var id = $(this).val();
    // alert(id);
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var json = JSON.parse(response);
        var data = json['pedido'];
        // console.log(data);
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
        // alert(data['id_pedido']);
        $("#lidped"+data['id_pedido']).attr("selected", "selected");
        var lidpedTXT = $("#lidped"+data['id_pedido']).html();
        $(".select2-selection__rendered").attr("title",lidpedTXT);
        $(".select2-selection__rendered").html(lidpedTXT);
        $("#id_pedido_temp").val(data['id_pedido']);

        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        // alert(data['fecha_pago']);
        $(".fecha_pago_modal2").val(data['fecha_pago']);
        // alert(data['estado']);
        if(data['estado']=="Abonado"){
          $(".fecha_pago_modal2").attr("readonly","readonly");
        }
        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
          // alert(data['tasa_pago']);
        $(".id_pago_modal").val(id);
        $(".codigo_pago").html(id);
        if(data['tasa_pago']!=null){
          $(".tasaModal").attr("value",data['tasa_pago']);
        }else{
          $(".tasaModal").attr("value","");
          $(".tasaModal").attr("placeholder","0.00");
        }

        var pagosR = JSON.parse($(".jsonPagos").html());
        for (var i = 0; i < pagosR.length; i++) {
          if(data['tipo_pago']==pagosR[i]['name']){
            $(".opt_"+pagosR[i]['id']).attr("selected","selected");
          }
        }
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


        var estado = "Reportado";
        // alert(data['estado']);
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,0,165,.65);");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(165,0,0,.65);");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,165,0,.65);");
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
        }


        $(".box-modalEditar").fadeIn(500);
      }
    });
  });

  $(".enviarModalDistribuirEx").click(function(){
    var exec = false;
    var rcantidad = false;
    var cantidad = $("#cantidadDistribucionEx").val();
    var rconcepto_pago = false;
    var concepto_pago = $(".concepto_pago_cantidadDistribucionEx").val();
    var rid_pedido = false;
    var id_pedido = $(".id_pedido_cantidadDistribucionEx").val();
    $("#error_cantidadDistribucionEx").html("");
    
    if(cantidad==""){
      $("#error_cantidadDistribucionEx").html("Debe llenar una cantidad para distribuir el descuento");
      rcantidad = false;
    }else{
      if(cantidad < 0){
        $("#error_cantidadDistribucionEx").html("Debe llenar una cantidad para distribuir el descuento");
        rcantidad = false;
      }else{
        rcantidad = true;
      }
    }
    if(id_pedido==""){
      rid_pedido = false;
    }else{
      rid_pedido = true;
    }
    if(concepto_pago==""){
      rconcepto_pago = false;
    }else{
      rconcepto_pago = true;
    }
    if(rcantidad==true && rid_pedido==true && rconcepto_pago==true){
      exec = true;
    }else{
      exec = false;
    }
    if(exec==true){
      $.ajax({
        url:'',
        type:"POST",
        data:{
          cantidadDistribucion: 'cantidadDistribucionEx',
          concepto_pago: concepto_pago,
          id_pedido: id_pedido,
          cantidad: cantidad,
        },
        success: function(respuesta){
          // alert(respuesta);
          if(respuesta=="1"){
            swal.fire({
              type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "#ED2A77",
            }).then(function(){
              $(".cerrarModalDistribuir").click();
            });
          }
          if(respuesta=="2"){
            swal.fire({
              type: 'error',
              title: '¡Error al realizar la operacion!',
              confirmButtonColor: "#ED2A77",
            }).then(function(){
              // $(".cerrarModal").click();
            });
          }
        }
      });
    }
  });
  $(".distribuirExcedentes").click(function(){
    $(".box-modalDistribuirEx").fadeIn(500);
  });
  $("#distribucionConceptoEx").change(function(){
    // HaciendoCambios
    var val = $(this).val();
    if(val!=""){
      $(".formDistribucionConceptoEx").submit();
    }
  });
  $("#cantidadDistribucionEx").keyup(function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(this).attr("max"));
    if(val != NaN){
      var nval = 0;
      if(val >= 0){
        if(val > max){
          nval = max;
        }else{
          nval = val;
        }
        $(this).val(nval);
      }else{
        $(this).val("");
      }
    }else{
      $(this).val("");
    }
  });
  $(".cerrarModalDistribuirEx").click(function(){
    $(".box-modalDistribuirEx").fadeOut(500);

    $(".cerrarFormDistribucionConceptoEx").delay(500).submit();
  });
  
  $(".enviarModalDistribuir").click(function(){
    var exec = false;
    var rcantidad = false;
    var cantidad = $("#cantidadDistribucion").val();
    var rconcepto_pago = false;
    var concepto_pago = $(".concepto_pago_cantidadDistribucion").val();
    var rid_pedido = false;
    var id_pedido = $(".id_pedido_cantidadDistribucion").val();
    $("#error_cantidadDistribucion").html("");
    
    if(cantidad==""){
      $("#error_cantidadDistribucion").html("Debe llenar una cantidad para distribuir el descuento");
      rcantidad = false;
    }else{
      if(cantidad < 0){
        $("#error_cantidadDistribucion").html("Debe llenar una cantidad para distribuir el descuento");
        rcantidad = false;
      }else{
        rcantidad = true;
      }
    }
    if(id_pedido==""){
      rid_pedido = false;
    }else{
      rid_pedido = true;
    }
    if(concepto_pago==""){
      rconcepto_pago = false;
    }else{
      rconcepto_pago = true;
    }
    if(rcantidad==true && rid_pedido==true && rconcepto_pago==true){
      exec = true;
    }else{
      exec = false;
    }
    if(exec==true){
      $.ajax({
        url:'',
        type:"POST",
        data:{
          cantidadDistribucion: 'cantidadDistribucion',
          concepto_pago: concepto_pago,
          id_pedido: id_pedido,
          cantidad: cantidad,
        },
        success: function(respuesta){
          // alert(respuesta);
          if(respuesta=="1"){
            swal.fire({
              type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "#ED2A77",
            }).then(function(){
              $(".cerrarModalDistribuir").click();
            });
          }
          if(respuesta=="2"){
            swal.fire({
              type: 'error',
              title: '¡Error al realizar la operacion!',
              confirmButtonColor: "#ED2A77",
            }).then(function(){
              // $(".cerrarModal").click();
            });
          }
        }
      });
    }
  });
  $(".distribuirDescuentos").click(function(){
    $(".box-modalDistribuir").fadeIn(500);
  });
  $("#distribucionConcepto").change(function(){
    // formDistribucionConcepto
    var val = $(this).val();
    if(val!=""){
      $(".formDistribucionConcepto").submit();
    }
  });
  $("#cantidadDistribucion").keyup(function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(this).attr("max"));
    if(val != NaN){
      var nval = 0;
      if(val >= 0){
        if(val > max){
          nval = max;
        }else{
          nval = val;
        }
        $(this).val(nval);
      }else{
        $(this).val("");
      }
    }else{
      $(this).val("");
    }
  });
  $(".cerrarModalDistribuir").click(function(){
    $(".box-modalDistribuir").fadeOut(500);

    $(".cerrarFormDistribucionConcepto").delay(500).submit();
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
