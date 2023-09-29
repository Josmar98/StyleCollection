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
              <?php if($_SESSION['nombre_rol']!="Vendedor"){$rut = "Pagoss";}else{$rut="MisPagos";} ?>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $rut ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$url?></a></div>
    <!-- Main content -->
    <section class="content">
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

        <?php
          $configs = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $pagoAdmin = 0;
          $pagoAdminAnalista = 0;
          $pagoAdminSuperanalista = 0;
          $vendedorLimiteFechasDivisas = 0;
          $vendedorLimiteFechasDivisasfechas = 0;
          $adminsLimiteFechasDivisas = 0;
          $limitefechasPagos = 0;
          foreach ($configs as $cf) {
            if(!empty($cf['id_configuracion'])){
              if($cf['clausula']=="Pagosadmin"){
                  $pagoAdmin=$cf['valor'];
              }
              if($cf['clausula']=="Pagosadminanalista"){
                  $pagoAdminAnalista=$cf['valor'];
              }
              if($cf['clausula']=="Pagosadminsuperanalista"){
                  $pagoAdminSuperanalista=$cf['valor'];
              }
              if($cf['clausula']=="Vendedorlimdivisas"){
                  $vendedorLimiteFechasDivisas=$cf['valor'];
              }
              if($cf['clausula']=="Venlimdivisasfechas"){
                  $vendedorLimiteFechasDivisasfechas=$cf['valor'];
              }
              if($cf['clausula']=="Adminlimdivisas"){
                  $adminsLimiteFechasDivisas=$cf['valor'];
              }
              if($cf['clausula']=="Limitesfechaspagos"){
                  $limitefechasPagos=$cf['valor'];
              }
            }
          }
          $actualDate = date('Y-m-d');
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
          $abonoT = 0;
          $abonos = [];
          $preciosPagar = [];
          foreach ($cantidadPagosDespachosFild as $cvPagos) {
            $abonos[$cvPagos['id']] = 0;
            $preciosPagar[$cvPagos['id']] = 1;
          }
          $varcont = 0;
          if(!empty($pagos) && count($pagos)>1){
            foreach ($pagos as $pag) {
              if(!empty($pag['equivalente_pago'])){
                if($pag['estado']=="Abonado"){
                  if($pag['tipo_pago']=="Contado"){
                    $contado += $pag['equivalente_pago'];
                  }
                  foreach ($cantidadPagosDespachosFild as $cvPagos) {
                    if($pag['tipo_pago']==$cvPagos['name']){
                      $abonos[$cvPagos['id']] += $pag['equivalente_pago'];
                    }
                  }
                }
              }
            }
          }

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
            foreach ($cantidadPagosDespachosFild as $cvPagos) {
              foreach ($pagos_despacho as $pagosD) {
                if(!empty($pagosD['id_despacho'])){
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

            $precioContadoReal = $despacho['precio_coleccion'] - $despacho['contado_precio_coleccion'];
            $cantidadColeccionesContadoReal = $contado/$precioContadoReal;
            $cantidadColeccionesContadoReal = intval($cantidadColeccionesContadoReal);
            // echo "<br>";
            // echo $coleccionesContado;
            // echo "<br>";
            // echo print_r($abonos);
            // echo "<br>";
            foreach ($pagos_despacho as $pagosD) {
              if(!empty($pagosD['id_despacho'])){
                foreach ($cantidadPagosDespachosFild as $keys) {
                  if($keys['name']==$pagosD['tipo_pago_despacho']){
                  // $precioConsiderar=$pagosD['pago_precio_coleccion']*$cantidadColeccionesContadoReal;
                  $precioConsiderar=$pagosD['pago_precio_coleccion']*$coleccionesContado;
                  $abonos[$keys['id']] += $precioConsiderar; 
                  }
                }
              }
            }
            // echo print_r($abonos);
            // print_r($preciosPagar);
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

        <!-- left column -->
      <?php //if(($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo") || $_SESSION['nombre_rol']=="Vendedor" && $optHabilitarPagos=="1"): ?>
      <?php if(($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo") || $_SESSION['nombre_rol']=="Vendedor" && $estado_campana=="1"): ?>

        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">


            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "".$url; ?></h3>
              <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                  <?php if (empty($_GET['admin'])): ?>
                      <div style="width:100%;margin:0;padding:0;text-align:right;">
                        <?php if (!empty($_GET['fechaPagar'])): ?>
                          <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pagos&action=Registrar&fechaPagar=<?=$_GET['fechaPagar']?>&admin=1&select=0"><b>Realizar pago por Lider</b></a>
                        <?php else:?>
                          <!-- <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pagos&action=Registrar&admin=1&select=0"><b>Realizar pago por Lider</b></a> -->
                        <?php endif; ?>
                      </div>
                  <?php endif; ?>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">

              <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
              <div class="row">
                <div class="col-xs-12 col-sm-6">
                  <button style="background:<?=$fucsia; ?>;color:#FFF;" class="btn btn-sm col-xs-12 guardarDatosPrueba">Guardar Datos Temporales</button>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <button style="background:#999;color:#FFF;" class="btn btn-sm col-xs-12 borrarDatosPrueba">Borrar Datos Temporales</button>
                </div>
                <hr>
                <hr>
              </div>
              <?php } ?>

                <div class="row">
                  <form action="" method="GET" class="form_fecha_pagar">
                    <?php $maxFecha = date('Y-m-d', time()-86400); ?>
                  <div class="form-group col-xs-12">
                    <label for="fechaPagar">Seleccione la fecha de pago </label>
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="Pagos" name="route">
                    <input type="hidden" value="Registrar" name="action">
                    <input type="date" class="form-control fechaPagar" id="fechaPagar" max="<?=$maxFecha?>" name="fechaPagar" <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" <?php } ?> style="width:100%;">
                    <?php if (!empty($_GET['admin']) && !empty($_GET['select'])){ ?>                    
                      <input type="hidden" value="<?=$_GET['admin']; ?>" name="admin">
                      <input type="hidden" value="<?=$_GET['select']; ?>" name="select">
                    <?php } ?>
                    <?php if (!empty($_GET['lider'])){ ?>                    
                      <input type="hidden" value="<?=$_GET['lider']; ?>" name="lider">
                    <?php } ?>
                  </div>
                  </form>
                </div>
                <?php if (!empty($_GET['fechaPagar'])): ?>
                  
                  <?php if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                    <div class="row">
                      <form action="" method="GET" class="form_select_lider">
                        <div class="form-group col-xs-12">
                          <label for="lider">Seleccione al Lider</label>
                          <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                          <input type="hidden" value="<?=$numero_campana;?>" name="n">
                          <input type="hidden" value="<?=$anio_campana;?>" name="y">
                          <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                          <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                          <input type="hidden" value="Pagos" name="route">
                          <input type="hidden" value="Registrar" name="action">
                          <?php if (!empty($_GET['fechaPagar'])): ?>
                          <input type="hidden" value="<?=$_GET['fechaPagar']?>" name="fechaPagar">
                          <?php endif ?>
                          <input type="hidden" value="1" name="admin">
                          <input type="hidden" value="1" name="select">
                          <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                            <option></option>
                              <?php foreach ($lideres as $data): ?>
                                <?php if (!empty($data['id_cliente'])): ?>
                                  <?php
                                    if($accesoBloqueo=="1"){
                                      if(!empty($accesosEstructuras)){
                                        foreach ($accesosEstructuras as $struct) {
                                          if(!empty($struct['id_cliente'])){
                                            if($struct['id_cliente']==$data['id_cliente']){
                                              if($data['cantidad_aprobado']>0){
                                                ?>
                                              
                                              <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                                <?php 
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }else if($accesoBloqueo=="0"){
                                      if($data['cantidad_aprobado']>0){
                                        ?>
                                      <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                        <?php
                                      }
                                    }
                                  ?>
                            
                                <?php endif ?>
                              <?php endforeach ?>
                          </select>
                        </div>
                      </form>
                    </div>
                  <?php } ?>
                  
                  <?php 
                    $fechaTopico = $_GET['fechaPagar'];
                    $idPagoPendienteActual = "";
                    $mostrarPagosFisicos = 0;
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
                            if($abonos[$cvPagos['id']] < $preciosPagar[$cvPagos['id']]){
                              if($idPagoPendienteActual==""){ $idPagoPendienteActual = $cvPagos['name']; }
                            }
                            if($proseguirNoUltimo==0){
                              if($idPagoPendienteActual==""){ $idPagoPendienteActual = $cvPagos['name']; }
                            }
                            if($fechaTopico<= $pagosD['fecha_pago_despacho_senior']){
                              if($idPagoPendienteActual==$pagosD['tipo_pago_despacho']){
                                $mostrarPagosFisicos = 1;
                              }
                            }

                          }
                        }
                      }
                    }
                  ?>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="forma">Forma de pago</label>
                       <select class="form-control select2" id="forma" name="forma" style="width:100%;">
                          <option></option>
                          <?php
                            foreach ($formasPago as $fpagos){
                              if ($limitefechasPagos==1){
                                echo "<option ";
                                if(!empty($_SESSION['dataRegistroTemp'])){
                                  if($_SESSION['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                    echo "selected";
                                  }
                                }
                                echo ">".$fpagos['name']."</option>";
                              }else{
                                if ($fpagos['type']=="banco"){
                                  echo "<option ";
                                  if(!empty($_SESSION['dataRegistroTemp'])){
                                    if($_SESSION['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                      echo "selected";
                                    }
                                  }
                                  echo ">".$fpagos['name']."</option>";
                                }
                                if ($fpagos['type']=="fisico"){
                                  if($mostrarPagosFisicos==1){
                                    echo "<option ";
                                    if($_SESSION['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                      echo "selected";
                                    }
                                    echo ">".$fpagos['name']."</option>";
                                  }
                                }
                              }
                            }
                          ?>
                        </select>
                       <span id="error_forma" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      
                       <label for="bancoPago">Bancos</label>
                       <!-- <?=$_SESSION['dataRegistroTemp']['bancos'] ?> -->
                       
                       <input type="hidden" class="bancosBoxSeleccionada" value="<?php if(!empty($_SESSION['dataRegistroTemp'])){ echo $_SESSION['dataRegistroTemp']['bancosBox']; } ?>">
                       <input type="hidden" class="bancosListaSeleccionada" value="<?php if(!empty($_SESSION['dataRegistroTemp'])){ echo $_SESSION['dataRegistroTemp']['bancos']; } ?>">
                       <input type="hidden" class="boxBancosListaSeleccionada" value="<?php if(!empty($_SESSION['dataRegistroTemp'])){ echo $_SESSION['dataRegistroTemp']['box']; } ?>">
                        <div class="bancosVacio ">
                           <select class="form-control select2 bancoPago bancoPagoV" style="width:100%" name="bancoPago">
                              <option value=""></option>
                           </select>
                        </div>

                        <div style='display:none' class="bancosSelect bancosPM">
                           <select class="form-control select2 bancoPago bancoPagoPM" style="width:100%" name="bancoPago">
                              <option value=""></option>
                              <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Pago Movil" || $data['opcion_pago']=="Ambos"){  ?>
                                <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> 
                                <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                                  <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                </option>
                              <?php } } } ?>
                           </select>
                        </div>

                        <div style='display:none' class="bancosSelect bancosT">
                           <select class="form-control select2 bancoPago bancoPagoT" style="width:100%" name="bancoPago">
                              <option value=""></option>
                              <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Transferencia" || $data['opcion_pago']=="Ambos"){  ?>
                                <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                                  <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                </option>
                              <?php } } } ?>
                           </select>
                        </div>

                        <div style='display:none' class="bancosSelect bancosAll">
                           <select class="form-control select2 bancoPago bancoPagoAll" style="width:100%" name="bancoPago">
                              <option value=""></option>
                              <?php foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['tipo_cuenta']!="Divisas"){  ?>
                                <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                                  <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                </option>
                              <?php } } } ?>
                           </select>
                        </div>

                        <div style='display:none' class="bancosSelect bancosDivisas">
                           <select class="form-control select2 bancoPago bancoPagoD" style="width:100%" name="bancoPago">
                              <option value=""></option>
                              <?php  foreach ($bancos as $data) { if(!empty($data['nombre_banco'])){ if($data['tipo_cuenta']=="Divisas"){  ?>
                                <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                                  <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                                </option>
                              <?php } } } ?>
                           </select>
                        </div>

                        <div style='display:none'  class="bancosEfectivo ">
                           <select class="form-control select2 bancoPago bancoPagoE" style="width:100%" name="bancoPago">
                              <option value="0-Efectivo" <?php if(!empty($_SESSION['dataRegistroTemp'])){ if("0"==$_SESSION['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> >Efectivo</option>
                           </select>
                        </div>
                       <span id="error_bancoPago" class="errors"></span>
                    </div>
                  </div>
                
                <?php endif; ?>

                <?php 
                  $pagoAbierto = "0";
                  if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                      if($pagoAdmin=="1"){
                        $pagoAbierto = "1";
                      }
                    }
                    if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
                      if($pagoAdminSuperanalista=="1"){
                        $pagoAbierto = "1";
                      }
                    }
                    if($_SESSION['nombre_rol']=="Analista"){
                      if($pagoAdminAnalista=="1"){
                        $pagoAbierto = "1";
                      }
                    }
                  }
                  
                  // $pagoAbierto = 0;
                  if($pagosObligatorios=="Y"){
                    $limitefechasPagos = 0;
                  }
                  
                  // echo "Limite?: ".$limitefechasPagos."<br>";
                  // echo $pagos_despacho[0]['tipo_pago_despacho'];
                  // echo " ".$pagos_despacho[0]['fecha_pago_despacho_senior'];
                  // $limitefechasPagos = 0;
                  // $unique = "2023-02-10";
                  // $unique = "2023-02-10";
                  // $fechaActual = $unique;
                  // $_GET['fechaPagar'] = $unique;
                ?>
            </div>
            
            <?php if( (empty($_GET['admin']) && !isset($_GET['select']) && !empty($_GET['fechaPagar'])) || (!empty($_GET['admin']) && isset($_GET['select']) && !empty($_GET['fechaPagar'])) || (!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==1  && !empty($_GET['fechaPagar'])) ){ ?>
                <?php if (!empty($_GET['fechaPagar']) && (!empty($tasaHoy) && count($tasaHoy)>1 )): ?>
                  <input type="hidden" id="opcionTasaDisponible" value="1">
                <?php else: ?>
                  <input type="hidden" id="opcionTasaDisponible" value="0">
                <?php endif; ?>
                
                <div class="box-footer SiPagar"
                  <?php if (!empty($_GET['fechaPagar']) && (!empty($tasaHoy) && count($tasaHoy)>1 )): ?>
                  <?php else: ?>
                    style="display:none;"
                  <?php endif; ?>
                >
                  <span type="submit" class="btn btn-default enviar2 color-button-sweetalert" style='background:#ED2A77;color:#fff'>Cargar</span>
                  <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                </div>

                <div class="box-footer NoPagar"
                  <?php if (!empty($_GET['fechaPagar']) && (!empty($tasaHoy) && count($tasaHoy)<2 )): ?>
                  <?php else: ?>
                    style="display:none;"
                  <?php endif; ?>
                >
                  <center>
                    <span style="color:red"><i>No hay tasa de pago cargada a la fecha <?=$lider->formatFecha($_GET['fechaPagar'])?>. Vuelva a intentarlo mas tarde, o al siguiente dia habil.</i></span>
                  </center>
                </div>

            <?php } ?>

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

            <!-- 
            if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
             -->
            
            <div class="boxForm boxFormTransferencia" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?> name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?> id="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ 
                                if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ 
                                  echo " selected ";
                                }
                              }
                              echo " >".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ ?> selected <?php } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ ?> selected <?php } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                       <input type="text" class="form-control" id="referencia" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" name="referencia" minlength="6" maxlength="6" placeholder="00000001">
                       <span id="error_referencia" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                         <label for="monto">Monto</label>
                         <div class="input-group">
                           <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                           <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){ echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                         </div>
                         <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                         <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                         <span class="input-group-addon" style="background:#EEE">$</span> 
                         <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormTransferenciaProvincial" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ ?> selected <?php } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ ?> selected <?php } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <label for="cedula">Cedula</label>
                      <div class="row">
                        <div class="col-xs-12">
                        <select class="form-control" style="width:20%;float:left;" id="tipo_cedula" name="tipo_cedula">
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                        </select> 
                        <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['dataRegistroTemp']['cedula'])){  echo $_SESSION['dataRegistroTemp']['cedula']; } ?>" minlength="7" maxlength="9"  id="cedula" name="cedula">
                        </div>
                      </div>
                      <div style="clear:both;"></div>
                      <span id="error_cedula" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormPagoMovil" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" class="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <input type="text" class="form-control" id="referencia" name="referencia" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" minlength="6" maxlength="6">
                      <span id="error_referencia" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="monto">Monto</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                        <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
                      </div>
                      <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
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

            <div class="boxForm boxFormPagoMovilProvincial1" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" class="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <label for="cedula">Cedula <small>(Pago Movil)</small></label>
                      <div class="row">
                        <div class="col-xs-12">
                          <select class="form-control" style="width:20%;float:left;" id="tipo_cedula" name="tipo_cedula">
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                          </select> 
                          <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['dataRegistroTemp']['cedula'])){  echo $_SESSION['dataRegistroTemp']['cedula']; } ?>" minlength="7" id="cedula" minlength="7" maxlength="9"  name="cedula">
                        </div>
                      </div>
                      <div style="clear:both;"></div>
                      <span id="error_cedula" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="monto">Monto</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                        <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormPagoMovilProvincial2" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" class="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <label for="telefono">Telefono <small>(Pago Movil)</small></label>
                      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php if(!empty($_SESSION['dataRegistroTemp']['telefono'])){  echo $_SESSION['dataRegistroTemp']['telefono']; } ?>" minlength="11" maxlength="11" >
                      <span id="error_telefono" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="monto">Monto</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                        <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormDepositoDivisas" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                          echo "<option";
                                          if(!empty($_SESSION['dataRegistroTemp'])){ if("Contado"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                          echo ">Contado</option>";
                                        }
                                      }
                                      if($inObligatoria=="Y"){
                                        if($pagosD['tipo_pago_despacho']=="Inicial"){
                                          // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            //echo "<option>Contado</option>";
                                            echo "<option class='opcionInicialReport'";
                                            if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                            echo ">Inicial</option>";
                                          }
                                        } 
                                      }
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" name="serial" max="10">
                      <span id="error_serial" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
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

            <div class="boxForm boxFormDepositoBolivaresProvincial" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <label for="cedula">Cedula</label>
                      <div class="row">
                        <div class="col-xs-12">
                        <select class="form-control" style="width:20%;float:left;"  id="tipo_cedula" name="tipo_cedula">
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                          <option <?php if(!empty($_SESSION['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                        </select> 
                        <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['dataRegistroTemp']['cedula'])){  echo $_SESSION['dataRegistroTemp']['cedula']; } ?>" id="cedula" name="cedula">
                        </div>
                      </div>
                      <div style="clear:both;"></div>
                      <span id="error_cedula" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="monto">Monto</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                        <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormDepositoBolivares" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $_GET['fechaPagar'];
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
                ?>
                <div class="box-body">
                  <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasa" <?php if(!empty($_GET['fechaPagar'])){ if(!empty($tasaHoy)){ if(count($tasaHoy)>1){ ?> value="<?=$tasaHoy[0]['monto_tasa']?>" <?php  } } } ?>  id="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <input type="text" class="form-control" id="referencia" name="referencia" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" maxlength="35" placeholder="00000001">
                      <span id="error_referencia" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="monto">Monto</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                       <input type="number"  step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number"  step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
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

            <div class="boxForm boxFormEfectivoBolivares" style="display:none">
              <center>
                <span><i>El pago del efectivo en bolivares, se tomara a la fecha en que se esta reportando, la fecha <?=$lider->formatFecha(date('Y-m-d'))?></i></span>
              </center>
              <?php if ($tasaMontarReal!=""): ?>
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $actualDate;
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
                ?>
                <div class="box-body">
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <!-- <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>"> -->
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" readonly name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tasa">Tasa</label>
                      <input type="number" step="0.01" class="form-control tasabs" <?php if($tasaMontarReal!=""){ ?> value="<?=$tasaMontarReal;?>" <?php } ?>  id="tasa" name="tasa" readonly="">
                      <span id="error_tasa" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    //echo "<option>Contado</option>";
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                if($inObligatoria=="Y"){
                                  if($pagosD['tipo_pago_despacho']=="Inicial"){
                                    // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                    if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //echo "<option>Contado</option>";
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  } 
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                        <input type="number" step="0.01" class="form-control montobs montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['monto'])){  echo $_SESSION['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                      </div>
                      <span id="error_monto" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number"  step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
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
              <?php else: ?>
                <div class="row">
                  <center>
                    <span style="color:red;"><i>No hay tasa de pago cargada a la fecha <?=$lider->formatFecha(date('Y-m-d'))?>. Vuelva a intentarlo mas tarde, o al siguiente dia habil.</i></span>
                    <br><br>
                  </center>
                </div>
              <?php endif; ?>
            </div>

            <div class="boxForm boxFormDivisasDolares" style="display:none">
              <center>
                <span>
                  <i>
                    El pago de divisas en dolares, se tomara a la fecha en que se esta reportando, la fecha <?=$lider->formatFecha(date('Y-m-d'))?>
                  </i>
                </span>
              </center>
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $actualDate;
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
                ?>
                <div class="box-body">
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" readonly name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    echo "<option";
                                    if(!empty($_SESSION['dataRegistroTemp'])){ if("Contado"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                    echo ">Contado</option>";

                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }
                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      if($pagosD['tipo_pago_despacho']==$cantidadPagosDespachosFild[0]['name']){
                                        if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                          echo "<option";
                                          if(!empty($_SESSION['dataRegistroTemp'])){ if("Contado"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                          echo ">Contado</option>";
                                        }
                                      }
                                      // if($inObligatoria=="Y"){
                                      //   if($pagosD['tipo_pago_despacho']=="Inicial"){
                                      //     // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                      //     if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                      //       //echo "<option>Contado</option>";
                                      //       echo "<option class='opcionInicialReport'>Inicial</option>";
                                      //     }
                                      //   } 
                                      // }
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <label for="serial">Serial de billete en dolar</label>
                      <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" name="serial">
                      <span id="error_serial" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">$</span> 
                        <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
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

            <div class="boxForm boxFormDivisasEuros" style="display:none">
              <form action="" method="post" role="form" class="form_register">
                <input type="hidden" name="valForma" class="valForma">
                <input type="hidden" name="valBanco" class="valBanco">
                <?php 
                  $fechaEscogida = $actualDate;
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
                ?>
                <div class="box-body">
                  <hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="fechaPago">Fecha de Pago</label>
                      <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  <?php if(!empty($_GET['fechaPagar'])){ ?> value="<?=$_GET['fechaPagar']?>" readonly <?php } ?>  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                      <span id="error_fechaPago" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                      <br>
                      <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                        <option></option>
                        <?php 
                          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
                            if($pagoAbierto==1){
                              echo "<option";
                              if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                              echo ">".$pagosD['tipo_pago_despacho']."</option>";
                            }else{
                              if($pagosObligatorios=="N"){
                                if($pagosD['tipo_pago_despacho']=="Inicial"){
                                  if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                    echo "<option";
                                    if(!empty($_SESSION['dataRegistroTemp'])){ if("Contado"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                    echo ">Contado</option>";
                                    
                                    if($opInicial=="Y"){
                                      echo "<option class='opcionInicialReport'";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">Inicial</option>";
                                    }

                                  }
                                }
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }
                              if($pagosObligatorios=="Y"){
                                foreach ($cantidadPagosDespachosFild as $cvPagos){
                                  if($pagosD['tipo_pago_despacho'] == $cvPagos['name']){
                                    if ($idPagoPendiente==$cvPagos['id']){
                                      if($pagosD['tipo_pago_despacho']=="Inicial"){
                                        if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                          echo "<option";
                                          if(!empty($_SESSION['dataRegistroTemp'])){ if("Contado"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                          echo ">Contado</option>";
                                        }
                                      }
                                      if($inObligatoria=="Y"){
                                        if($pagosD['tipo_pago_despacho']=="Inicial"){
                                          // $pagosD['fecha_pago_despacho_senior'] = "2023-04-22";
                                          if($fechaEscogida <= $pagosD['fecha_pago_despacho_senior']){
                                            //echo "<option>Contado</option>";
                                            echo "<option class='opcionInicialReport'";
                                            if(!empty($_SESSION['dataRegistroTemp'])){ if("Inicial"==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                            echo ">Inicial</option>";
                                          }
                                        } 
                                      }
                                      echo "<option";
                                      if(!empty($_SESSION['dataRegistroTemp'])){ if($pagosD['tipo_pago_despacho']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } }
                                      echo ">".$pagosD['tipo_pago_despacho']."</option>";
                                    }
                                  }
                                }
                              }

                            }
                          } }
                          foreach ($promociones as $promoPagos) {
                            if(!empty($promoPagos['id_promocion'])){
                              if($promoPagos['cantidad_aprobada_promocion']>0){
                                if(count($fechasPromociones)>0){
                                  if($fechaEscogida<=$fechasPromociones['fecha_pago_promocion']){ ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <option <?php if($pago['tipo_pago']==$promoPagos['nombre_promocion']){ ?> selected <?php } ?> <?php if(!empty($_SESSION['dataRegistroTemp'])){ if($promoPagos['nombre_promocion']==$_SESSION['dataRegistroTemp']['tipoPago']){ echo " selected "; } } ?> ><?=$promoPagos['nombre_promocion'] ?></option>
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
                      <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['dataRegistroTemp']['referencia'])){  echo $_SESSION['dataRegistroTemp']['referencia']; } ?>" name="serial">
                      <span id="error_serial" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6 col-md-6">
                      <label for="equivalente">Equivalente</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="background:#EEE">€</span> 
                        <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['dataRegistroTemp']['equivalente'])){  echo $_SESSION['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
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

      <?php else: ?>

        <div class="col-xs-12"> 
          <div class="box"> 
            <div class="box-header with-border"> 
              <h3 class="box-title">Agregar <?php echo "".$url; ?></h3>
            </div>
            <div class="box-body"> 
              <b style="font-size:1.1em;">
                &nbsp&nbsp&nbsp
              Esta es la <span style="color:<?=$fucsia?>">Campaña <?=$numero_campana?>/<?=$anio_campana?></span> la misma ya se encuentra cerrada para los abonos de los pagos. Dirigase a la campaña actual para abonar sus pagos
              </b>
            </div>
            <div class="box-footer"> 
            </div>
          </div>
        </div>

      <?php endif; ?>
        <!--/.col (left) -->
        <span class="d-none infoPromos"><?=json_encode($infoPromos); ?></span>
        
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
<?php if (!empty($despacho['fecha_inicial_senior'])): ?>
  <input type="hidden" class="fecha_inicial_senior" value="<?=$despacho['fecha_inicial_senior']?>">
<?php endif; ?>
<?php if (!empty($despacho['fecha_primera_senior'])): ?>
  <input type="hidden" class="fecha_primera_senior" value="<?=$despacho['fecha_primera_senior']?>">
<?php endif; ?>
<?php if (!empty($despacho['fecha_segunda_senior'])): ?>
  <input type="hidden" class="fecha_segunda_senior" value="<?=$despacho['fecha_segunda_senior']?>">
<?php endif; ?>
  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">

<?php if(!empty($_SESSION['dataRegistroTemp'])){ ?>
  
  <input type="hidden" class="guardarDatosTemporalmente" value="<?=$_SESSION['dataRegistroTemp']['guardarDatosTemporalmente']; ?>">
  <input type="hidden" class="bancosSelectTemporalmente" value="<?=$_SESSION['dataRegistroTemp']['bancosBox']; ?>">
  <input type="hidden" class="guardarDatosTemporalmente" value="<?=$_SESSION['dataRegistroTemp']['guardarDatosTemporalmente']; ?>">

<?php } ?>

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
  if($(".guardarDatosTemporalmente").val() == "true"){
    $(".bancosVacio").hide();
    var banca = $(".bancosSelectTemporalmente").val();
    $("."+banca).show();
  }
  $(".guardarDatosPrueba").click(function(){

    var campaing = $(".campaing").val();
    var n = $(".n").val();
    var y = $(".y").val();
    var dpid = $(".dpid").val();
    var dp = $(".dp").val();

    var fecha = $(".fechaPagar").val();
    var formaPago = $("#forma").val();
    if(formaPago!=""){
      var opcionTasaDisponible = $("#opcionTasaDisponible").val();
      var bancosBox = $(".bancosBoxSeleccionada").val();
      var bancos = $(".bancosListaSeleccionada").val();
      var bancosSelect = $("."+bancos).val();
      var posicion = bancosSelect.indexOf("Provincial");
      var poss = bancosSelect.indexOf("-");
      bancosSelect = bancosSelect.slice(0, poss);
      var box = $(".boxBancosListaSeleccionada").val();

      var fecha2 = $(box+" #fechaPago").val();
      var tasa = $(box+" #tasa").val();
      var tipoPago = $(box+" #tipoPago").val();
      if(posicion == -1){
        if(formaPago=="Deposito En Dolares"){
          var referencia = $(box+" #serial").val();
        }else if(formaPago=="Divisas Dolares"){
          var referencia = $(box+" #serial").val();
        }else if(formaPago=="Divisas Euros"){
          var referencia = $(box+" #serial").val();
        }else {
          var referencia = $(box+" #referencia").val();
        }
      }else{
        if(formaPago=="Pago Movil de Otros Bancos"){
          // alert("asdasd");
          var telefono = $(box+" #telefono").val();
        }else{
          var tipo_cedula = $(box+" #tipo_cedula").val();
          var cedula = $(box+" #cedula").val();
        }
      }

      var monto = $(box+" #monto").val();
      var equivalente = $(box+" #equivalente").val();

      if(posicion == -1){
        $.ajax({
          url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
          type: 'POST',
          data: {
            guardarDatosTemporalmente: true,
            fecha: fecha,
            formaPago: formaPago,
            opcionTasaDisponible: opcionTasaDisponible,
            bancosBox: bancosBox,
            bancos: bancos,
            box: box,
            bancosSelect: bancosSelect,
            posicion: posicion,
            fecha2: fecha2,
            tasa: tasa,
            tipoPago: tipoPago,
            referencia: referencia,
            monto: monto,
            equivalente: equivalente,
          },
          success: function(respuesta){
            swal.fire({
              type: 'success',
              title: '¡Datos guardados temporalmente!',
              confirmButtonText: "¡Aceptar!",
              confirmButtonColor: "#ED2A77"
            });
          }
        });
      }
      else{
        if(formaPago=="Pago Movil de Otros Bancos"){
          $.ajax({
            url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
            type: 'POST',
            data: {
              guardarDatosTemporalmente: true,
              fecha: fecha,
              formaPago: formaPago,
              opcionTasaDisponible: opcionTasaDisponible,
              bancosBox: bancosBox,
              bancos: bancos,
              box: box,
              bancosSelect: bancosSelect,
              posicion: posicion,
              fecha2: fecha2,
              tasa: tasa,
              tipoPago: tipoPago,
              telefono: telefono,
              monto: monto,
              equivalente: equivalente,
            },
            success: function(respuesta){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados temporalmente!',
                confirmButtonText: "¡Aceptar!",
                confirmButtonColor: "#ED2A77"
              });
            }
          });
        }
        else{
          $.ajax({
            url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
            type: 'POST',
            data: {
              guardarDatosTemporalmente: true,
              fecha: fecha,
              formaPago: formaPago,
              opcionTasaDisponible: opcionTasaDisponible,
              bancosBox: bancosBox,
              bancos: bancos,
              box: box,
              bancosSelect: bancosSelect,
              posicion: posicion,
              fecha2: fecha2,
              tasa: tasa,
              tipoPago: tipoPago,
              tipo_cedula: tipo_cedula,
              cedula: cedula,
              monto: monto,
              equivalente: equivalente,
            },
            success: function(respuesta){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados temporalmente!',
                confirmButtonText: "¡Aceptar!",
                confirmButtonColor: "#ED2A77"
              });
            }
          });
        }
        
      }
      
    }
  });

  $(".borrarDatosPrueba").click(function(){
    var campaing = $(".campaing").val();
    var n = $(".n").val();
    var y = $(".y").val();
    var dpid = $(".dpid").val();
    var dp = $(".dp").val();

    $.ajax({
      url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
      type: 'POST',
      data: {
        borrarDatosTemporalmente: true,
      },
      success: function(respuesta){
        if(respuesta=="1"){
          swal.fire({
            type: 'success',
            title: '¡Datos temporales borrados!',
            confirmButtonText: "¡Aceptar!",
            confirmButtonColor: "#ED2A77"
          });
        }
      }
    });
  });

  var response = $(".responses").val();
  if(response==undefined){
  }else{    
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "";
        <?php if(!empty($_GET['admin'])&&!empty($_GET['lider'])){ ?>
          menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&admin="+<?=$_GET['admin']?>+"&lider="+<?=$_GET['lider']?>;
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
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro Repetido!',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    if(response == "912"){
      swal.fire({
          type: 'warning',
          title: '¡Registro No Encontrado, puede haber ingresado mal algun dato!',
          text: 'Verifique los datos con su comprobante de pago o comuniquese con su Analista.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    if(response == "911"){
      swal.fire({
          type: 'warning',
          title: '¡Registro No Encontrado, puede haber ingresado mal algun dato!',
          text: 'Verifique los datos con su comprobante de pago o comuniquese con su Analista.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    if(response == "92"){
      swal.fire({
          type: 'warning',
          title: '¡Los Registros Bancarios <br>no han sido cargados!<br>Espere al siguiente dia habil.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    <?php if(!empty($response) && $response=="951"){ ?>
    if(response == "951"){
      var sistema = '<?=$dataEncontrado['sistema'];?>';
      var sexo = '<?=$dataEncontrado['sexo'];?>';
      var nombre = '<?=$dataEncontrado['primer_nombre'].' '.$dataEncontrado['primer_apellido']; ?>';
      var dataCiclo = 'Ciclo <?=$dataEncontrado['numero_ciclo'].'/'.$dataEncontrado['ano_ciclo']; ?>';
      var pedi=' el';
      var lid = 'lider';
      if(sexo=='Femenino'){
        lid = 'la lider';
      }
      if(sexo=='Masculino'){
        lid = 'el lider';
      }
      swal.fire({
          type: 'warning',
          title: '¡Registro de pago repetido<br> cargado en '+sistema+' a la factura de <br> '+lid+' '+nombre+'<br> En '+pedi+' '+dataCiclo,
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    <?php } ?>
    <?php if(!empty($response) && $response=="952"){ ?>
    if(response == "952"){
      var sistema = '<?=$dataEncontrado['sistema'];?>';
      var sexo = '<?=$dataEncontrado['sexo'];?>';
      var nombre = '<?=$dataEncontrado['primer_nombre'].' '.$dataEncontrado['primer_apellido']; ?>';
      var dataCampana = 'Campaña <?=$dataEncontrado['numero_campana'].'/'.$dataEncontrado['anio_campana']; ?>';
      var despacho = '<?=$dataEncontrado['numero_despacho']; ?>';
      var pedi=' la';
      if(despacho>1){
        var numdesp = '';
        if(despacho==2){ numdesp = '2do'; 
        }else if(despacho==3){ numdesp = '3er'; 
        }else if(despacho==4){ numdesp = '4to'; 
        }else if(despacho==5){ numdesp = '5to'; 
        }else if(despacho==6){ numdesp = '6to'; 
        }else if(despacho==7){ numdesp = '7mo'; 
        }else if(despacho==8){ numdesp = '8vo'; 
        }else if(despacho==9){ numdesp = '9no';
        }else{ numdesp=''; }
        pedi = ' el '+numdesp+' Pedido de la ';
      }
      var lid = 'lider';
      if(sexo=='Femenino'){
        lid = 'la lider';
      }
      if(sexo=='Masculino'){
        lid = 'el lider';
      }
      swal.fire({
          type: 'warning',
          title: '¡Registro de pago repetido<br> cargado en '+sistema+' a la factura de <br> '+lid+' '+nombre+'<br> En '+pedi+' '+dataCampana,
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
    <?php } ?>
    
  }
  
  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".fechaPagar").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_fecha_pagar").submit();
    }
  });
  
  $(".bancosSelect").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");
  });

  $("#forma").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");
    var opcionTasaDisponible = $("#opcionTasaDisponible").val();
    $(".SiPagar").hide();
    $(".SiPagar").attr("style","display:;");

    var forma = $("#forma").val();
    $(".bancosVacio").show();
    $(".bancosPM").hide();
    $(".bancosAll").hide();
    $(".bancosT").hide();
    $(".bancosDivisas").hide();
    $(".bancosEfectivo").hide();
    $(".bancosListaSeleccionada").val("bancosVacio");

    if(forma=="Transferencia Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosT");
      $(".bancosListaSeleccionada").val("bancoPagoT");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Transferencia de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosT");
      $(".bancosListaSeleccionada").val("bancoPagoT");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Pago Movil Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosPM");
      $(".bancosListaSeleccionada").val("bancoPagoPM");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Pago Movil de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosEfectivo").hide();
      $(".bancosDivisas").hide();
      $(".bancosBoxSeleccionada").val("bancosPM");
      $(".bancosListaSeleccionada").val("bancoPagoPM");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Efectivo Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Divisas Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      $(".NoPagar").hide();
      $(".SiPagar").show();
    }
    if(forma=="Deposito En Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").show();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosDivisas");
      $(".bancosListaSeleccionada").val("bancoPagoD");

      $(".NoPagar").hide();
      $(".SiPagar").show();
    }
    if(forma=="Deposito En Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").show();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosAll");
      $(".bancosListaSeleccionada").val("bancoPagoAll");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Divisas Euros"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      $(".NoPagar").hide();
      $(".SiPagar").show();
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
    var $var = "";
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
      $var = ".boxFormEfectivoBolivares";
    }
    if(formaPago=="Divisas Dolares"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasDolares").show();
      $var = ".boxFormDivisasDolares";
    }
    if(formaPago=="Divisas Euros"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasEuros").show();
      $var = ".boxFormDivisasEuros";
    }
    $(".boxBancosListaSeleccionada").val($var);
    $(".valForma").val(formaPago);
    $(".valBanco").val(idBanco);

  });

  $(".fechaPago").change(function(){
    var fecha = $(this).val();
    $(".fechaPago").val(fecha);
    var limiInicial = $(".fecha_inicial_senior").val();
    //alert(fecha);
    // alert(limiInicial);
    if(fecha > limiInicial){
      // alert($("option.opcionInicialReport").html());
      $("option.opcionInicialReport").hide();
    }else{
      // alert($("option.opcionInicialReport").html());
      $("option.opcionInicialReport").show();
    }
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
    // alert("Todo menos BS: "+tasa);
    var eqv2 = monto / tasa;
    var eqv = eqv2.toFixed(2);
    if(eqv=='NaN'){eqv = 0; eqv = eqv.toFixed(2); eqv2 = 0;  eqv2 = eqv2.toFixed(2);}
    $(".equivalente").val(eqv);
    $(".equivalente2").val(eqv2);
  });

  $(".montobs").keyup(function(){
    var monto = parseFloat($(this).val());
    var tasa = parseFloat($(".tasabs").val());
    // alert(tasa);
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

  $("#tipoPago").change(function(){
    var nameTipo = $(this).val();
    var infoPromos = $(".infoPromos").html();
    var json = JSON.parse(infoPromos);
    var nombrePromo = "";
    var precioPromo = 0;
    var cantidadPromo = 0;
    var totalPromo = 0;
    for(var i = 0; i < json.length; i++){
      if(json[i]['nombre'] == nameTipo){
        nombrePromo = json[i]['nombre'];
        precioPromo = json[i]['precio'];
        cantidadPromo = json[i]['cantidad'];
        totalPromo = json[i]['total'];
        break;
      }
    }
    // alert(nombrePromo+" "+precioPromo+" "+cantidadPromo+" "+totalPromo);
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
    }
    else if(tipoced=="J"){
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
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago movil");      
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
      $("."+id+" #error_cedula").html("Debe llenar la cedula del deposito");      
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
