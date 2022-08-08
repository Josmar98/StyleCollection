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
        <?php echo "Pagos"; ?>
        <small><?php echo "Ver Pagos (Efectivo Bolivares)"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pagos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "Pagos Bolivares";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Pagos</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
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
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>


        
        <div class="col-xs-12">
          <!-- /.box -->
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
                  <a href="?<?=$menu?>&route=Pagos&action=Registrar" style="position:fixed;bottom:2%;right:2%;z-index:300;" class="btn enviar2"><span class="fa fa-arrow-up"></span> <span class="hidden-xs hidden-sm"><u>Registrar Pagos</u></span></a>
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
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "Pagos (Bolivares)"; ?></a></h3>

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
                <!-- <br>
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
                      </form>
                    </div>
                </div> -->
                <br>
                <!-- <div class="row">
                    <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                      <a href="?<?=$menu?>&route=Pagos" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver todos los pagos</u></b></a>
                    </div>
                </div> -->
                  <div class="row">
                      <br>
                      <div class="col-xs-12 col-md-12" style="text-align:right;margin-bottom:15px;">
                        <?php if ($aux2 != ""): ?>
                        <a href="?<?=$menu?>&route=Pagos<?=$aux2?>" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver Pagos con filtro</u></b></a>
                        <?php else: ?>
                        <a href="?<?=$menu?>&route=Pagoss" style="background:#099;color:#FFF;border-radius:7px !important;" class="btn"><b><u>Ver todos los pagos</u></b></a>
                        <?php endif; ?>
                      </div>
                    
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
                    <div class="col-xs-12 col-md-6">
                      <h3 style="margin:0;padding:0;"><small>Responsabilidad Primer Pago</small></h3>
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
                        <?php $acumTotalPrimerPago = 0; ?>
                      <?php foreach ($planes as $plans): ?>
                          <?php if (!empty($plans['id_pedido'])): ?>
                            <?php if ($plans['cantidad_coleccion_plan']>0): ?>
                              <tr>
                                <td>Plan <?=$plans['nombre_plan']?></td>
                                <td>
                                  <?php $colecciones = $plans['cantidad_coleccion']*$plans['cantidad_coleccion_plan']; ?>
                                  <?=$colecciones?> Col.</td>
                                <td>X</td>
                                <td>$<?=$plans['primer_precio_coleccion']?></td>
                                <td>=</td>
                                <?php $acumTotalPrimerPago += $colecciones*$plans['primer_precio_coleccion'] ?>
                                <td>$<?=$colecciones*$plans['primer_precio_coleccion']?></td>
                              </tr>
                            <?php endif ?>
                          <?php endif ?>
                      <?php endforeach ?>
                              <tr style="border-top:1.02px solid #AAA;border-bottom:1.02px solid #AAA;">
                                <td></td>
                                <td></td>
                                <td colspan="2"><b>Total</b></td>
                                <td>=</td>
                                <td><b>$<?=$acumTotalPrimerPago?></b></td>
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
                                $varCont = $coleccionesContado * $pedido['primer_precio_coleccion'];
                              ?>
                                <tr>
                                  <td><b>(-)</b> Colecciones de Contado</td>
                                  <td><?=$coleccionesContado?> Col.</td>
                                  <td>X</td>
                                  <td>$<?=$pedido['primer_precio_coleccion']?></td>
                                  <td>=</td>
                                  <td><b>$<?=$varCont?></b></td>
                                </tr>
                              <?php
                                  $totalPagarPrimerPago = $acumTotalPrimerPago-$varCont;
                              ?>
                                <tr style="border-top:1.02px solid #AAA;border-bottom:1.02px solid #AAA">
                                  <td></td>
                                  <td colspan="3"><b>Total real a Pagar de primer pago</b></td>
                                  <td>=</td>
                                  <td><b>$<?=$totalPagarPrimerPago?></b></td>
                                </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-xs-12 col-md-6" style="text-align:right;">
                  </div>
                <?php } ?>
                

                <div class="row">
                  <div class="col-xs-12">
                    
                    <form action="" method="GET" class="form_select_lider">
                    <div class="form-group col-xs-12">
                      <label for="lider">Seleccione al Lider</label>
                      <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                      <input type="hidden" value="<?=$numero_campana;?>" name="n">
                      <input type="hidden" value="<?=$anio_campana;?>" name="y">
                      <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                      <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                      <input type="hidden" value="PagosBolivares" name="route">
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
                      <input type="hidden" value="1" name="admin">
                      <!-- <input type="hidden" value="1" name="select"> -->
                      <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                        <option></option>
                        <?php foreach ($lideres as $data): ?>
                          <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?>
                              selected="selected"
                          <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    </form>

                    <!-- <form action="" method="GET" class="form_select_banco">
                    <div class="form-group col-xs-6">
                      <label for="banco">Seleccione al banco</label>
                      <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                      <input type="hidden" value="<?=$numero_campana;?>" name="n">
                      <input type="hidden" value="<?=$anio_campana;?>" name="y">
                      <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                      <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                      <input type="hidden" value="PagosBolivares" name="route">
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
                    </form> -->

                  </div>
                </div>
                <?php //} ?>
            </div>
            <!-- /.box-header -->


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


              $ruta = "PagosBolivares";
              // if(!empty($_GET['admin']) && !empty($_GET['lider'])){
              //   $ruta = "PagosBolivares&admin=1&lider=".$_GET['lider'];                      
              // } else if($_SESSION['id_cliente']==$id_cliente){
              //   $ruta = "PagosBolivares";
              // }else{
              //   $ruta = "PagosBolivares&admin=1&lider=".$id_cliente;                      
              // }
              if(!empty($_GET['admin']) && !empty($_GET['lider'])){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){
                    $ruta = "PagosBolivares&admin=1&lider=".$_GET['lider']."&Banco=".$_GET['Banco']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }else{
                    $ruta = "PagosBolivares&admin=1&lider=".$_GET['lider']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){
                    $ruta = "PagosBolivares&admin=1&lider=".$_GET['lider']."&Banco=".$_GET['Banco'];                      
                  }else{
                    $ruta = "PagosBolivares&admin=1&lider=".$_GET['lider'];                      
                  }
                }
              } else if($_SESSION['id_cliente']==$id_cliente){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){
                    $ruta = "PagosBolivares&Banco=".$_GET['Banco']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }else{
                    $ruta = "PagosBolivares&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){
                    $ruta = "PagosBolivares&Banco=".$_GET['Banco'];
                  }else{
                    $ruta = "PagosBolivares";
                  }
                }
              }else{
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  if(!empty($_GET['Banco'])){

                  }else{
                    $ruta = "PagosBolivares&admin=1&lider=".$id_cliente."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                  }
                }else{
                  if(!empty($_GET['Banco'])){

                  }else{
                    $ruta = "PagosBolivares&admin=1&lider=".$id_cliente;                      
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


              

              <hr>




              <div class="box-header">
                <?php
                  $montosContado=0;
                  $equivalenciasContado=0;
                  $equivalenciasAbonadasContado=0;
                ?>
                <h3 class="box-title"><?php echo "Contado"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_contado">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                  

                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_contado" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>  

                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
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
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"):

                              if($data['id_banco']==""):

                              
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];

                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasContado += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }

                              endif;



                              if($data['id_banco']!=""):
                                foreach ($movimientos as $mov) {
                                  if(!empty($mov['id_pago'])){
                                    if($mov['id_pago']==$data['id_pago']){
                                      // echo $mov['fecha_movimiento']." // ".$data['fecha_pago'];
                                      // if($mov['fecha_movimiento']==$data['fecha_pago']){
                                      //   echo " - IGUALES";
                                      // }else{
                                      //   echo " - DIFERENTES XD - ".$data['equivalente_pago'];
                                      // }
                                      // echo "<br>";
                                      if($mov['fecha_movimiento']==$data['fecha_pago']){


                              
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];

                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasContado += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }
                                    }
                                  }
                                }
                              }
                              endif;

                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr >
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
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
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'>
                          <h4>Contados:</h4>
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                              $precioCol = $despacho['precio_coleccion'];
                              $descuentoContado = $despacho['contado_precio_coleccion'];
                            if($equivalenciasAbonadasContado!=0){
                              $totalContado = $equivalenciasAbonadasContado / ($precioCol - $descuentoContado);
                            }else{
                              $totalContado = 0;
                            }
                            echo number_format($totalContado,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b><?=number_format($montosContado,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasContado,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoContado=0;
                  $diferidoContado=0;
                  $abonadoContado=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Contado"):
                            if($data['estado']=="Abonado"){
                              $reportadoContado += $data['equivalente_pago'];
                              $abonadoContado += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoContado += $data['equivalente_pago'];
                              $diferidoContado += $data['equivalente_pago'];
                            }else{
                              $reportadoContado += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado Contado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoContado, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido Contado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoContado, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado Contado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoContado, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>




              <div class="box-header">
                <?php
                  $montosI=0;
                  $equivalenciasI=0;
                  $equivalenciasAbonadasI=0;
                ?>
                <h3 class="box-title"><?php echo "Iniciales"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_inicial">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">

                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_inicial" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>

                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
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
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"):

                            if($data['id_banco']==""):
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                            $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>                       
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }
                            endif; 
                            


                            if($data['id_banco']!=""):
                              foreach ($movimientos as $mov) {
                                if(!empty($mov['id_pago'])){
                                  if($mov['id_pago']==$data['id_pago']){
                                    // echo $mov['fecha_movimiento']." // ".$data['fecha_pago'];
                                    // if($mov['fecha_movimiento']==$data['fecha_pago']){
                                    //   echo " - IGUALES";
                                    // }else{
                                    //   echo " - DIFERENTES XD - ".$data['equivalente_pago'];
                                    // }
                                    // echo "<br>";
                                    if($mov['fecha_movimiento']==$data['fecha_pago']){

                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                            $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>                       
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }

                                    }
                                  }
                                }
                              }
                            endif; 

                            endif;
                          endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr >
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
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
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'>
                          <h4>Iniciales:</h4>
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                              $precioInicial = $despacho['inicial_precio_coleccion'];
                            if($equivalenciasAbonadasI!=0){
                              $totalIniciales = $equivalenciasAbonadasI / $precioInicial;
                            }else{
                              $totalIniciales = 0;
                            }
                            echo number_format($totalIniciales,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b><?=number_format($montosI,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasI,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoInicial=0;
                  $diferidoInicial=0;
                  $abonadoInicial=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Inicial"):
                            if($data['estado']=="Abonado"){
                              $reportadoInicial += $data['equivalente_pago'];
                              $abonadoInicial += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoInicial += $data['equivalente_pago'];
                              $diferidoInicial += $data['equivalente_pago'];
                            }else{
                              $reportadoInicial += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado Inicial</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoInicial, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido Inicial</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoInicial, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado Inicial</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoInicial, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>



              <div class="box-header">
                <?php
                  $montosP1=0;
                  $equivalenciasP1=0;
                  $equivalenciasAbonodasP1=0;
                ?>
                <h3 class="box-title"><?php echo "Primer Pago"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_primer">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                  
                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>

                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
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
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"):

                                if($data['id_banco']==""):



                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                          <?php if($data['estado']=="Abonado"){ 
                              if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                                
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }
                              endif;


                              if($data['id_banco']!=""):
                              foreach ($movimientos as $mov) {
                                if(!empty($mov['id_pago'])){
                                  if($mov['id_pago']==$data['id_pago']){
                                    // echo $mov['fecha_movimiento']." // ".$data['fecha_pago'];
                                    // if($mov['fecha_movimiento']==$data['fecha_pago']){
                                    //   echo " - IGUALES";
                                    // }else{
                                    //   echo " - DIFERENTES XD - ".$data['equivalente_pago'];
                                    //   $cantidades += $data['equivalente_pago'];
                                    //   echo " ====== ".$cantidades;
                                    // }
                                    // echo "<br>";
                                    if($mov['fecha_movimiento']==$data['fecha_pago']){



                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                          <?php if($data['estado']=="Abonado"){ 
                              if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                                
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }




                                    }
                                  }
                                }
                              }
                            endif; 



                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
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
                      </tr>
                      <tr style="background:#CCC">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;">
                          <h4>(P.P) Premios: </h4>
                        </th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php
                              $precioPrimerP = $despacho['primer_precio_coleccion'];
                            if($equivalenciasAbonodasP1!=0){
                              $totalPrimer = $equivalenciasAbonodasP1 / $precioPrimerP;
                            }else{
                              $totalPrimer = 0;
                            }
                            echo number_format($totalPrimer,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"><h4>Monto:</h4></th>
                        <th style="padding:0;margin:0;"><h4><b><?=number_format($montosP1,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;"><h4>Eqv:</h4></th>
                        <th style="padding:0;margin:0;"><h4><b>$<?=number_format($equivalenciasP1,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php 
                            if(!empty($_GET['lider'])){

                              if($acumTotalPrimerPago!=0){
                                $porcentajeDePrimerPago = ($equivalenciasAbonodasP1*100)/$totalPagarPrimerPago;
                              }else{
                                $porcentajeDePrimerPago = 0;
                              }
                              echo number_format($porcentajeDePrimerPago,2,',','.')."%";
                            }
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoPrimer=0;
                  $diferidoPrimer=0;
                  $abonadoPrimer=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Primer Pago"):
                            if($data['estado']=="Abonado"){
                              $reportadoPrimer += $data['equivalente_pago'];
                              $abonadoPrimer += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoPrimer += $data['equivalente_pago'];
                              $diferidoPrimer += $data['equivalente_pago'];
                            }else{
                              $reportadoPrimer += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado 1er.P</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido 1er.P</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado 1er.P</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>



              <div class="box-header">
                <?php
                  $montosC=0;
                  $equivalenciasC=0;
                ?>
                <h3 class="box-title"><?php echo "Segundo Pago"; ?></h3>
                <br>
                <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                    <div class="input-group">
                        <label for="buscando">Buscar: </label>&nbsp
                        <input type="text" id="buscar_table_cierre">
                    </div>
                    <br>
                </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                      
                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_cierre" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_cierre" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>
                    <thead>
                      <tr>
                        <?php if(  $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
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
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"):


                              if($data['id_banco']==""):

                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                      ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              } else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }

                              endif;

                              if($data['id_banco']!=""):
                                foreach ($movimientos as $mov) {
                                if(!empty($mov['id_pago'])){
                                  if($mov['id_pago']==$data['id_pago']){
                                    // echo $mov['fecha_movimiento']." // ".$data['fecha_pago'];
                                    // if($mov['fecha_movimiento']==$data['fecha_pago']){
                                    //   echo " - IGUALES";
                                    // }else{
                                    //   echo " - DIFERENTES XD - ".$data['equivalente_pago'];
                                    //   $cantidades += $data['equivalente_pago'];
                                    //   echo " ====== ".$cantidades;
                                    // }
                                    // echo "<br>";
                                    if($mov['fecha_movimiento']==$data['fecha_pago']){



                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                      ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              } else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                          <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                              
                              <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
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
                                <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                  <?php if($estado_campana=="1"): ?>
                                  <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                    <span class="fa fa-wrench">
                                      
                                    </span>
                                  </button>
                                  <?php endif; ?>
                                <?php endif ?>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <?php if($estado_campana=="1"): ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php
                              }else{
                                if($data['estado']!="Abonado"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                        <?php if($estado_campana=="1"): ?>
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                          <span class="fa fa-wrench">
                                          </span>
                                        </button>
                                        <?php endif; ?>
                                      <?php endif; ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                      <?php if($estado_campana=="1"): ?>
                                        <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
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
                                }else{ 
                                  ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php 
                                }
                              } 
                            } 
                          ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
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
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
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
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
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
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
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
                          <?php if($estado_campana=="1"): ?>

                            <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                            <?php 
                            if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                              <span class="fa fa-pencil"></span>
                            </button>
                              <?php } ?>
                            <?php }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Analista"): ?>
                                        <?php if ($analistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?> 
                                  <?php elseif($_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                        <?php if ($superanalistaaccesorapido=="1"): ?>
                                            <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                              <span class="fa fa-pencil"></span>
                                            </button>
                                        <?php endif; ?>
                                  <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                        <?php if($data['id_banco']!=""){ ?>
                                      <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                        <?php } ?>
                                  <?php else: ?>
                                      <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-pencil"></span>
                                      </button>
                                  <?php endif; ?>
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
                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                      <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>

                                    <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                      <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                      </button>
                                      <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                        <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                      </button>
                                    <?php }} ?>
                                <?php } ?>

                            <?php } ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                        <?php
                              }


                                    }
                                  }
                                }
                              }
                              endif;

                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
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
                      <tr style="background:#CCC">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" ): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"><h4>Monto: </h4></th>
                        <th style="padding:0;margin:0;"><h4><b><?=number_format($montosC,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;"><h4>Eqv: </h4></th>
                        <th style="padding:0;margin:0;"><h4><b>$<?=number_format($equivalenciasC,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php 
                            if(!empty($_GET['lider'])){
                              // echo $nuevoTotal;
                              if($nuevoTotal!=0){
                                $porcentajeDeSegundoPago = ($abonado*100)/$nuevoTotal;
                              }else{
                                $porcentajeDeSegundoPago = 0;
                              }
                              echo number_format($porcentajeDeSegundoPago,2,',','.')."%";
                            }
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoSegundo=0;
                  $diferidoSegundo=0;
                  $abonadoSegundo=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Segundo Pago"):
                            if($data['estado']=="Abonado"){
                              $reportadoSegundo += $data['equivalente_pago'];
                              $abonadoSegundo += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoSegundo += $data['equivalente_pago'];
                              $diferidoSegundo += $data['equivalente_pago'];
                            }else{
                              $reportadoSegundo += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado 2do.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido 2do.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado 2do.P.</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>



              <div class="box-header">
                <?php
                  $montosT=$montosI+$montosP1+$montosC;
                  $equivalenciasT=$equivalenciasI+$equivalenciasP1+$equivalenciasC;
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
                          <?php if(!empty($_GET['lider'])){ ?>
                            <h4>Porcentaje: </h4>
                          <?php } ?>
                        </td>
                        <td style="width:8.5%">
                          <h4>
                            <b>
                              <?php 
                                if(!empty($_GET['lider'])){
                                  // echo $nuevoTotal;
                                  if($nuevoTotal!=0){
                                    $porcentajeDeSegundoPago = ($abonado*100)/$nuevoTotal;
                                  }else{
                                    $porcentajeDeSegundoPago = 0;
                                  }
                                  echo number_format($porcentajeDeSegundoPago,2,',','.')."%";
                                }
                              ?>
                            </b>
                          </h4>
                        </td>
                        <td style="width:8.5%"></td>
                        <td><h4>Monto: </h4></td>
                        <td><h4><b><?=number_format($montosT,2, ",",".")?></b></h4></td>

                        <?php if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){ ?>
                            <td><h4 style="color:#DD0000">Total: </h4></td>
                            <td><h4><b style="color:#DD0000">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){ ?>
                            <td><h4 style="color:#00DD00">Total: </h4></td>
                            <td><h4><b style="color:#00DD00">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php } else{ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php } ?>


                        <?php if($nuevoTotal!=0 && !empty($_GET['lider']) && $_GET['route']=="Pagos"){ ?>
                        <td><h4 style="color:#DD0000">Resta: </h4></td>
                        <td><h4><b style="color:#DD0000">$<?=number_format($nuevoTotal-$abonado,2, ",",".")?></b></h4></td>
                        <?php }else{ ?>
                          <td></td>
                        <?php } ?>
                        <!-- <td><h4 style="color:#DD0000">Resta: </h4></td> -->
                        <!-- <td><h4><b style="color:#DD0000">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td> -->
                      </tr>
                    
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div>
              </div>


              <hr>


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


  <div class="box-modalFichaDetalle  " style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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
                    <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" id="rol" name="rol" value="Analistas">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tipo_pago">Concepto de pago</label>
                           <select class="form-control tipo_pago" id="tipo_pago"  name="tipo_pago" style="width:100%;z-index:91000">
                             <option></option>
                             <option class="optContado">Contado</option>
                             <option class="optInicial">Inicial</option>
                             <option class="optPrimer">Primer Pago</option>
                             <option class="optCierre">Segundo Pago</option>
                           </select>
                           <span id="error_tipoPagoModal" class="errors"></span>
                        </div>
                        <input type="hidden" id="id_pago_modal" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tasa">Tasa del dolar</label>
                           <input type="number" class="form-control tasaModal" value="" step="0.01" min="<?=$limiteFechaMinimo?>" name="tasa" id="tasa" max="<?=date('Y-m-d')?>">
                           <span id="error_tasaModal" class="errors"></span>
                        </div>
                    </div>
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=PagosBolivares";
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


      
  $("#buscar_table_contado").keyup(function(){
    var complement = "contado";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);

    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_inicial").keyup(function(){
    var complement = "inicial";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_primer").keyup(function(){
    var complement = "primer";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_cierre").keyup(function(){
    var complement = "cierre";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });


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
            rol: rol,
            tipo_pago: tipo_pago,
            id_pago_modal: id_pago_modal,
            tasa: tasa,
          },
          success: function(respuesta){
            // alert(respuesta);
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
                restriccion = despacho['fecha_inicial'];
              }
              if(pago['tipo_pago']=="Inicial"){
                restriccion = despacho['fecha_inicial'];
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
        // alert(response);
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
        if(data['tasa_pago']!=null){
          $(".tasaModal").attr("value",data['tasa_pago']);
        }else{
          $(".tasaModal").attr("value","");
          $(".tasaModal").attr("placeholder","0.00");
        }
        if(data['tipo_pago']=="Contado"){
          $(".optContado").attr("selected","selected");
        }
        if(data['tipo_pago']=="Inicial"){
          $(".optInicial").attr("selected","selected");
        }
        if(data['tipo_pago']=="Primer Pago"){
          $(".optPrimer").attr("selected","selected");
        }
        if(data['tipo_pago']=="Segundo Pago"){
          $(".optCierre").attr("selected","selected");
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
