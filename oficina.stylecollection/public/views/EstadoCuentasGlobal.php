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
          // if($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario"){
          // }else{
            // echo "Colecciones Aprobacion";
          // }
          $n_despacho = "";
          if($num_despacho > 1){
            if($num_despacho==2){ $n_despacho = "2do Pedido de "; }
            if($num_despacho==3){ $n_despacho = "3ero Pedido de "; }
            if($num_despacho==4){ $n_despacho = "4to Pedido de "; }
            if($num_despacho==5){ $n_despacho = "5to Pedido de "; }
            if($num_despacho==6){ $n_despacho = "6to Pedido de "; }
            if($num_despacho==7){ $n_despacho = "7mo Pedido de "; }
            if($num_despacho==8){ $n_despacho = "8vo Pedido de "; }
            if($num_despacho==9){ $n_despacho = "9no Pedido de "; }
          }
          echo "Estado de cuentas - ".$n_despacho."Campaña ".$numero_campana."/".$anio_campana;
        ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedidos"; ?></a></li>
        <li class="active"><?php echo "Pedido"; ?></li>
      </ol>
    </section>
    <?php 
      $reclamargemasporcentaje = 0;
      $Opttraspasarexcedente = 0;
      $supervisorPlanesYPremiosPermitidos = 0;
      $analistaPlanesYPremiosPermitidos = 0;
      $administrativoPlanesYPremiosPermitidos = 0;
      $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
      foreach ($configuraciones as $config) {
        if(!empty($config['id_configuracion'])){
          
          if($config['clausula']=="Reclamargemasporcentaje"){
            $reclamargemasporcentaje = $config['valor'];
          }
          if($config['clausula']=="Opttraspasarexcedente"){
            $Opttraspasarexcedente = $config['valor'];
          }
          if($config['clausula']=="Supervisorplanesypremiospermitidos"){
            $supervisorPlanesYPremiosPermitidos = $config['valor'];
          }
          if($config['clausula']=="Analistasplanesypremiospermitidos"){
            $analistaPlanesYPremiosPermitidos = $config['valor'];
          }
          if($config['clausula']=="Administrativoplanesypremiospermitidos"){
            $administrativoPlanesYPremiosPermitidos = $config['valor'];
          }
        }
      }
    ?>
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
                  <a href="?<?=$menu?>&route=Homing2" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                    <i class="fa fa-arrow-left" style="font-size:2em"></i>
                  </a>

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
                $id_cliente_personal_cliente = $pedido['id_cliente'];

                $canjeosPersonalesCliente = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_cliente_personal_cliente} and canjeos.estatus = 1");
                foreach ($canjeosPersonalesCliente as $canje) {
                  if(!empty($canje['cantidad_gemas'])){
                    $gemasCanjeadasCliente += $canje['cantidad_gemas'];
                  }
                }

                $canjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_cliente = {$id_cliente_personal_cliente} and canjeos_gemas.estatus = 1");
                foreach ($canjeosGemasCliente as $canje) {
                  if(!empty($canje['cantidad'])){
                    $canjeoGemasCliente += $canje['cantidad'];
                  }
                }

                $nombramientoAdquiridoCliente = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente_personal_cliente} and estatus = 1");
                foreach ($nombramientoAdquiridoCliente as $data) {
                  if(!empty($data['id_nombramiento'])){
                    $gemasAdquiridasNombramientoCliente += $data['cantidad_gemas'];
                  }
                }

                $obsequiosAdquiridoCliente = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE id_cliente = {$id_cliente_personal_cliente} and estatus = 1");
                foreach ($obsequiosAdquiridoCliente as $data) {
                  if(!empty($data['id_obsequio_gema'])){
                    $gemasObsequiosAdquiridoCliente += $data['cantidad_gemas'];
                  }
                }

                $gemasAdquiridasCliente = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_cliente = {$id_cliente_personal_cliente} and gemas.estatus = 1");
                foreach ($gemasAdquiridasCliente as $data) {
                  if(!empty($data['id_gema'])){
                    $gemasBonosCliente += $data['cantidad_gemas'];
                    if($data['estado']=="Bloqueado"){
                      $gemasAdquiridasBloqueadasCliente += $data['cantidad_gemas'];
                    }
                    if($data['estado']=="Disponible"){
                      $gemasAdquiridasDisponiblesCliente += $data['activas'];
                    }


                    if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
                      $gemasAdquiridasFacturaCliente += $data['cantidad_gemas'];
                      if($data['estado']=="Bloqueado"){
                        $gemasAdquiridasFacturaClienteBloqueadasCliente += $data['cantidad_gemas'];
                      }
                      if($data['estado']=="Disponible"){
                        $gemasAdquiridasFacturaClienteDisponiblesCliente += $data['cantidad_gemas'];
                      }
                    }
                    if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
                      $gemasAdquiridasBonosCliente += $data['cantidad_gemas'];
                    }
                  }
                }
                $fotoGema = "public/assets/img/gemas/gema1.1.png";
                $fotoGemaBloqueadas = "public/assets/img/gemas/gema1.2.png";
                
                $cantidad_gemas_liquidadas = 0;
                $gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
                if(count($gemas_liquidadas_disponibles)>1){
                  foreach ($gemas_liquidadas_disponibles as $keyT) {
                    if(!empty($keyT['id_descuento_gema'])){
                      $cantidad_gemas_liquidadas += $keyT['cantidad_descuento_gemas'];
                      // echo $keyT['cantidad_descuento_gemas']." | ";
                    }
                  }
                  // $liquidacionGemas = $gemas_liquidadas_disponibles[0];
                  // $cantidad_gemas_liquidadas = $liquidacionGemas['cantidad_descuento_gemas'];
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
              


              <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                <?php if($pedido['cantidad_aprobado']==0){ ?>
                <div class="row">
                  <div class="col-xs-12">
                    <span style="color:#000;font-size:2em">Aprobacion de Pedidos</span>
                  </div>
                </div>

                <?php } ?>
              <?php } ?>
                <div class="post" style="padding:10px">
                  <br>
                  <?php
                    if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista"){
                      ?>
                      <div style="text-align:right;padding-right:30px;">
                        <b><u><a href="?<?=$menu?>&route=Pedidos&id=<?=$id; ?>">
                          Ver estado de cuentas individual
                        </a></u></b>
                      </div>
                      <br>
                      <?php                      
                    }
                  ?>
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="<?=$fotoPerfilCliente?>" alt="user image">
                        <span class="username">
                          <?php if($cliente['id_cliente']==$_SESSION['id_cliente']){ ?>
                          <a href="?route=Perfil">
                            <?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido']; ?>  
                          </a>
                        <?php }else{ ?>
                          <a href="?route=Clientes&action=Detalles&id=<?php echo $cliente['id_cliente']; ?>">
                            <?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido']; ?>  
                          </a>
                        <?php } ?>

                          <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
                        </span>
                    <span class="description">
                      Pedido solicitado - <?php echo $pedido['fecha_pedido'] ?> a las <?php echo $pedido['hora_pedido']; ?>
                        <?php
                          if(strlen($pedido['fecha_aprobado'])>0){
                        ?> 
                       |  Pedido aprobado - <?php echo $pedido['fecha_aprobado'] ?> a las <?php echo $pedido['hora_aprobado']; 
                          if($pedido['visto_cliente']==0){
                            $query = "UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = $id";
                            $lider->modificar($query);
                          }
                       ?>
                       
                          <br>
                          <?php 
                            //echo $desp['apertura_seleccion_plan']." - ".$desp['limite_seleccion_plan'];
                            // if(date('Y-m-d') >= $desp['apertura_seleccion_plan'] && date('Y-m-d') <= $desp['limite_seleccion_plan']){
                            //   echo "S";
                            // }else{
                            //   echo "N";
                            // }
                          ?>

                        <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"  || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): if($seleccionAdmin==1): ?>
                          <br>
                          <?php $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$cliente['id_cliente']}"); 
                          $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$cliente['id_cliente']}");
                          ?>
                            <?php if($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                              <?php if($limittteee=="1" || ($_SESSION['nombre_rol']=="Analista Supervisor" && $supervisorPlanesYPremiosPermitidos=="1") || ($_SESSION['nombre_rol']=="Analista" && $analistaPlanesYPremiosPermitidos=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $administrativoPlanesYPremiosPermitidos=="1")  ): ?>
                                <div class="row">
                                  <div class="col-xs-12 col-sm-6" style="text-align:left;">
                                      <?php if(count($planesCol)>1){ ?>
                                        <b><u>
                                          <a href="?<?=$menu?>&route=PlanCol&admin=1&id=<?=$cliente['id_cliente']?>">Ver Planes</a>
                                        </u></b>
                                      <?php } ?>
                                      <?php if(count($planesCol)<2){ ?>
                                        <b><u>
                                          <a href="?<?=$menu?>&route=PlanCol&action=Registrar&admin=1&id=<?=$cliente['id_cliente']?>" <?php if($estado_campana=="0"){ echo "disabled"; } ?> >Seleccionar Planes</a>
                                        </u></b>
                                      <?php } ?>
                                    
                                  </div>
                                  <div class="col-xs-12 col-sm-6" style="text-align:right;">
                                      <?php if(count($premioscol)>1){ ?>
                                        <b><u>
                                          <a href="?<?=$menu?>&route=PremioCol&admin=1&id=<?=$cliente['id_cliente']?>">Ver Premios</a>
                                        </u></b>
                                      <?php }else if(count($planesCol)>1){ ?>
                                        <b><u>
                                          <a href="?<?=$menu?>&route=PremioCol&action=Registrar&admin=1&id=<?=$cliente['id_cliente']?>" <?php if($estado_campana=="0"){ echo "disabled"; } ?> >Seleccionar Premios</a>
                                        </u></b>
                                      <?php } ?>
                                    
                                  </div>
                                </div>
                              <?php endif; ?>
                            <?php else: ?>
                              <div class="row">
                                <div class="col-xs-12 col-sm-6" style="text-align:left;">
                                    <?php if(count($planesCol)>1){ ?>
                                      <b><u>
                                        <a href="?<?=$menu?>&route=PlanCol&admin=1&id=<?=$cliente['id_cliente']?>">Ver Planes</a>
                                      </u></b>
                                    <?php } ?>
                                    <?php if(count($planesCol)<2){ ?>
                                      <b><u>
                                        <a href="?<?=$menu?>&route=PlanCol&action=Registrar&admin=1&id=<?=$cliente['id_cliente']?>" <?php if($estado_campana=="0"){ echo "disabled"; } ?> >Seleccionar Planes</a>
                                      </u></b>
                                    <?php } ?>
                                  
                                </div>
                                <div class="col-xs-12 col-sm-6" style="text-align:right;">
                                    <?php if(count($premioscol)>1){ ?>
                                      <b><u>
                                        <a href="?<?=$menu?>&route=PremioCol&admin=1&id=<?=$cliente['id_cliente']?>">Ver Premios</a>
                                      </u></b>
                                    <?php }else if(count($planesCol)>1){ ?>
                                      <b><u>
                                        <a href="?<?=$menu?>&route=PremioCol&action=Registrar&admin=1&id=<?=$cliente['id_cliente']?>" <?php if($estado_campana=="0"){ echo "disabled"; } ?> >Seleccionar Premios</a>
                                      </u></b>
                                    <?php } ?>
                                  
                                </div>
                              </div>
                            <?php endif; ?>

                          
                        <?php endif; endif; ?>



                        <?php 
                              $lidSenior = [];
                              foreach ($liderazgosAll as $lide){
                                if (!empty($lide['id_liderazgo'])){
                                  if ($lide['nombre_liderazgo']=="SENIOR"){
                                    $lidSenior = $lide; 
                                  }
                                } 
                              }
                         ?>
                        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                          <br>
                          <div class="row">
                            <?php 
                              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus=1");
                              $configbonoContado = 0;
                              $configbonoPrimerPago = 0;
                              $configbonoSegundoPago = 0;
                              $configbonoCierreEstructura = 0;

                              $analistabonoContado = 0;
                              $analistabonoPagosPuntuales = 0;
                              // $analistabonoPrimerPago = 0;
                              // $analistabonoSegundoPago = 0;
                              $analistabonoCierreEstructura = 0;

                              $superanalistabonoContado = 0;
                              $superanalistabonoPagosPuntuales = 0;
                              // $superanalistabonoPrimerPago = 0;
                              // $superanalistabonoSegundoPago = 0;
                              $superanalistabonoCierreEstructura = 0;
                              foreach ($configuraciones as $config) {
                                if(!empty($config['id_configuracion'])){
                                  if($config['clausula']=="Bonocontado"){
                                    $configbonoContado = $config['valor'];
                                  }
                                  if($config['clausula']=="Bonoprimerpago"){
                                    $configbonoPrimerPago = $config['valor'];
                                  }
                                  if($config['clausula']=="Bonosegundopago"){
                                    $configbonoSegundoPago = $config['valor'];
                                  }
                                  if($config['clausula']=="Bonocierreestructura"){
                                    $configbonoCierreEstructura = $config['valor'];
                                  }
                                  
                                  if($config['clausula']=="Analistabonocontado"){
                                    $analistabonoContado = $config['valor'];
                                  }
                                  if($config['clausula']=="Analistabonopagospuntuales"){
                                    $analistabonoPagosPuntuales = $config['valor'];
                                  }
                                  // if($config['clausula']=="Analistabonoprimerpago"){
                                  //   $analistabonoPrimerPago = $config['valor'];
                                  // }
                                  // if($config['clausula']=="Analistabonosegundopago"){
                                  //   $analistabonoSegundoPago = $config['valor'];
                                  // }
                                  if($config['clausula']=="Analistabonocierreestructura"){
                                    $analistabonoCierreEstructura = $config['valor'];
                                  }

                                  if($config['clausula']=="Superanalistabonocontado"){
                                    $superanalistabonoContado = $config['valor'];
                                  }
                                  if($config['clausula']=="Superanalistabonopagospuntuales"){
                                    $superanalistabonoPagosPuntuales = $config['valor'];
                                  }
                                  // if($config['clausula']=="Superanalistabonoprimerpago"){
                                  //   $superanalistabonoPrimerPago = $config['valor'];
                                  // }
                                  // if($config['clausula']=="Superanalistabonosegundopago"){
                                  //   $superanalistabonoSegundoPago = $config['valor'];
                                  // }
                                  if($config['clausula']=="Superanalistabonocierreestructura"){
                                    $superanalistabonoCierreEstructura = $config['valor'];
                                  }
                                }
                              }
                            ?>
                            <div class="col-xs-12 col-sm-6" style="text-align:left;">
                              <?php if($estado_campana=="1"){ ?>

                                <?php
                                  $opcionBonosContado = 0;
                                  if($configbonoContado=="1"){
                                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                      $opcionBonosContado = 1;
                                    }
                                    if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
                                      if ($superanalistabonoContado=="1"){
                                        $opcionBonosContado = 1;
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista"){
                                      if ($analistabonoContado=="1"){
                                        $opcionBonosContado = 1;
                                      }
                                    }
                                  }
                                ?>
                                <?php if ($opcionBonosContado == 1): ?>
                                  <!-- <b><u>
                                    <a class="asignarDescuentoContado" style="cursor:pointer"><span style="font-size:1.4em">+</span> Descuentos Por Colección de Contado</a>
                                  </u></b> 
                                  <br> -->
                                <?php endif ?>
                                      

                                <?php 
                                  $opcionBonosPagosPuntuales = 0;
                                  if($configbonoPrimerPago=="1"){
                                    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                      $opcionBonosPagosPuntuales = 1;
                                    }
                                    if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
                                      if ($superanalistabonoPagosPuntuales=="1"){
                                        $opcionBonosPagosPuntuales = 1;
                                      }
                                    }
                                    if($_SESSION['nombre_rol']=="Analista"){
                                      if ($analistabonoPagosPuntuales=="1"){
                                        $opcionBonosPagosPuntuales = 1;
                                      }
                                    }
                                  }
                                ?>
                                <?php if ($opcionBonosPagosPuntuales == 1): ?>
                                  <!-- <br>
                                  <b><u>
                                      <a class="asignarBonosPagosPuntuales" style="cursor:pointer"><span style="font-size:1.4em">+</span> Descuentos Por Pagos Puntuales</a>
                                  </u></b> 
                                  <br> -->
                                <?php endif; ?>

                              <?php } ?>

                            </div>
                            <?php if($estado_campana=="1"){ ?>
                                <?php 
                                  $opcionBonosEstructura = "0";
                                  if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
                                    $opcionBonosEstructura = "1";
                                  }

                                  if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
                                    if ($superanalistabonoCierreEstructura=="1"){
                                      $opcionBonosEstructura = "1";
                                    }
                                  }
                                  if($_SESSION['nombre_rol']=="Analista"){
                                    if ($analistabonoCierreEstructura=="1"){
                                      $opcionBonosEstructura = "1";
                                    }
                                  }
                                ?>

                                <?php if ($opcionBonosEstructura=="1"): ?>
                                  <?php 
                                    if(!empty($estructuraLideres)){
                                      if(count($estructuraLideres) > 0){
                                        // if($pedido['cantidad_aprobado']>0){
                                        if($total>0){
                                          if($configbonoCierreEstructura=="1"):
                                            if($lidera['id_liderazgo'] > $lidSenior['id_liderazgo']){ ?>
                                              <!-- <div class="col-xs-12 col-sm-6" style="text-align:right;">
                                                <br>
                                                <b><u>
                                                    <a class="asignarDescuentoCierreEstructura" style="cursor:pointer"><span style="font-size:1.4em">+</span> Descuentos por cierre de estructura</a>
                                                </u></b>                              
                                              </div> -->
                                          <?php 
                                            }
                                          endif; 
                                        } 
                                      }
                                    }
                                  ?>
                                <?php endif; ?>


                            <?php  } ?>

                          </div>
                        <?php endif; ?>




                        <?php
                          }
                        ?>
                    </span>
                  </div>
                  <!-- /.user-block -->
                    <?php if($pedido['cantidad_aprobado']==0){ ?>
                      <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>

                  <span style="color:#000;margin-left:15px;font-size:1.1em">
                    Ha solicitado un pedido con una cantidad de <b style="color:<?php echo $color_btn_sweetalert ?>"><?php echo $pedido['cantidad_pedido'] ?></b> colecciones para esta campaña <?=$numero_campana."/".$anio_campana?>

                  </span>
                    <?php   // echo ;
                      $vecesVal = 4;
                      $numMax = $pedido['cantidad_pedido']*$vecesVal;

                      $liderazgosTempxD = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1");

                      $liderazgoTempxd = []; 
                      foreach ($liderazgosTempxD as $l){
                        if(!empty($l['nombre_liderazgo'])){
                          if($l['nombre_liderazgo']=='JUNIOR'){
                            $liderazgoTempxd = $l; 
                          }
                        }
                      }
                    ?>
                  <br><br>

                  <form action="" method="POST" role="form" class="form_register">
                    <div class="row">
                      <div class="col-xs-12">

                        <input type="hidden" class="maxOculto" value="<?php echo $numMax; ?>">
                        <input class="form-control" id="cantidad" step="1" name="cantidad" min="<?=$liderazgoTempxd['minima_cantidad']; ?>" max="<?php echo $numMax; ?>" type="number" value="<?php echo $pedido['cantidad_pedido'] ?>" placeholder="Cantidad de coleccion para aprobar" <?php if($_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Analista Supervisor2"){}else{echo "readonly";} ?> <?php if($estado_campana=="0"){ echo "disabled"; } ?> >
                        <span id="error_cantidad" class="errors"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12">
                        <!-- <button class="form-control" style="background:<?php echo $color_btn_sweetalert ?>;color:#FFF;">Enviar</button> -->  
                        <?php if ($_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Analista Supervisor2"): ?>
                          
                        <span type="submit" <?php if($estado_campana=="1"){ echo 'class="btn enviar"'; } ?>  <?php if($estado_campana=="0"){ echo "disabled class='btn enviar2'"; } ?>>Aprobar</span>
                        <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                        <button class="btn-enviar d-none" disabled="" >aprobar</button>

                        <?php endif ?>
                      </div>
                    </div>
                  </form>


                        <?php }  ?>
                    <?php }else{ ?>

                   <!-- <b><span style="color:#000;margin-left:15px;font-size:1.1em">
                    Al pedido solicitado para una cantidad de <b style="color:<?php echo $color_btn_sweetalert ?>"><?php echo $pedido['cantidad_pedido'] ?></b> colecciones, les fueron aprobadas exitosamente <u><b style="font-size:1.2em;color:#7C4"><?php echo $pedido['cantidad_aprobado'] ?></b> colecciones</u>.
                  </span></b> --> 
                  <?php
                    $ruta = "Pagos";
                    if($_SESSION['id_cliente']==$pedido['id_cliente']){
                      $ruta = "MisPagos";
                    }else{
                      $ruta = "Pagos&admin=1&lider=".$pedido['id_cliente'];
                    }
                  ?>

                  <hr>
                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta.""?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Reportado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado,2, ",",".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido"?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Diferido</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido,2, ",",".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado"?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Abonado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado,2, ",",".")?></b></h4>
                      </a>
                    </div>
                  </div>

                  <div class="" style="background:<?=$color_liderazgo?>33;border:1px solid #EFEFEF;color:#444;width:100%;padding:15px 30px 0px 30px;border-radius:5px">
                    <?php  if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                      <b style="float:left;"><u><a href="?<?php echo $menu ?>&route=Pedidos&action=Eliminar&id=<?php echo $pedido['id_pedido'] ?>&admin=1"><i>Eliminar Colecciones Aprobadas</i></a></u></b>
                    <?php } ?>
                    <?php //if(Count($colss)<2): ?>
                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                        <!-- <div class="hidden-md hidden-sm hidden-lg"><br></div> -->
                        <div class="hidden-md hidden-sm hidden-lg"><br><br></div>
                        <b style="float:right;"><u><a href="?<?php echo $menu ?>&route=Pedidos&action=Modificar&id=<?php echo $pedido['id_pedido'] ?>&admin=1"><i>Editar Colecciones Aprobadas</i></a></u></b>
                        <br>
                      <?php } ?>
                    <?php //endif; ?>

                    <div class="box-header">
                      <div class="container" style="width:100%;margin-top:0px;">

                        <div class="row">
                            <!-- <div class="col-md-4 text-left">
                              <br>
                              <span style="font-size:1.2em;color:#000;"><b>Precio Coleccion: </b></span>
                              <span style="font-size:1.4em;color:#0C0;"><b><?php if(!empty($precio_coleccion)){ echo number_format($precio_coleccion,2,',','.'); } ?>$</b></span>
                            </div> -->
                            <div class="col-md-4 text-left">
                              <br>
                              <table>
                              <?php
                                $query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and campanas.id_campana = {$id_campana} and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido ASC";
                                $clientesPedidosS = $lider->consultarQuery($query); 
                                $total_costo = 0;
                                foreach ($clientesPedidosS as $pedidoCol) {
                                  if(!empty($pedidoCol['id_pedido'])){
                                    $precioColeccion = $pedidoCol['precio_coleccion'];
                                    $cantColeccion = $pedidoCol['cantidad_aprobado_individual'];
                                    $precioColGen = ($precioColeccion*$cantColeccion);
                                    $total_costo+=$precioColGen;
                                    ?>
                                    <tr>
                                      <td colspan="2">
                                        <span style="font-size:1.1em;color:#000;"><b>Precio Coleccion: </b></span><br>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>Productos: </b>
                                      </td>
                                      <td>
                                        <!-- <span style="font-size:1.2em;color:#0C0;margin-left:5px;"><b><?php if(!empty($precioColeccion)){ echo "$".number_format($precioColeccion,2,',','.'); } ?> * <?php echo "(".$cantColeccion.") = "."$".number_format($precioColGen,2,',','.'); ?></b></span><br> -->
                                        <b><span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php if(!empty($precioColeccion)){ echo "$".number_format($precioColeccion,2,',','.'); } ?></span> * <?php echo "(".$cantColeccion.") = "; ?> <span style="font-size:1.2em;color:#0C0;margin-left:5px;"><?php echo "$".number_format($precioColGen,2,',','.'); ?></span></b><br>
                                      </td>
                                    </tr>
                                    <?php
                                    $pedidosSecund = $lider->consultarQuery("SELECT * FROM pedidos_secundarios as pedSec, despachos_secundarios as desSec WHERE pedSec.id_despacho_sec=desSec.id_despacho_sec and pedSec.estatus=1 and pedSec.id_pedido = {$pedidoCol['id_pedido']}");
                                    foreach ($pedidosSecund as $pedSec) {
                                      if(!empty($pedSec['id_pedido_sec'])){
                                        $precioColeccionSec = $pedSec['precio_coleccion_sec'];
                                        $cantColeccionSec = $pedSec['cantidad_aprobado_sec'];
                                        $precioColGen = ($precioColeccionSec*$cantColeccionSec);
                                        $total_costo+=$precioColGen;
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
                                  }
                                }

                              ?>
                              </table>
                            </div>

                            <div class="col-md-4 text-left">
                              <!-- <span style="font-size:1.1em;color:#000;"><b>Colecciones aprobadas: </b></span> -->
                              <!-- <span style="font-size:1.3em;color:#7C4;"><b><?php echo $cantidad_aprobado ?></b></span> -->
                            </div>

                            <div class="col-md-4 text-right">
                              <span style="font-size:1.1em;color:#000;"><b>Colecciones totales: </b></span>
                              <span style="font-size:1.1em;color:;"><b><?php echo $total ?></b></span>
                              <br>
                              <span style="font-size:1.1em;color:#000;"><b>Colecciones acumuladas: </b></span>
                              <span style="font-size:1.1em;color:;"><b><?php echo $cantidad_total ?></b></span>
                              <br>
                              <span style="font-size:1.2em;color:#000;"><b>Colecciones aprobadas: </b></span>
                              <span style="font-size:1.5em;color:<?php echo $color_btn_sweetalert ?>;"><b><?php if(!empty($cantidad_aprobado)){echo $cantidad_aprobado; } ?></b></span>
                            </div>
                        </div>

                      </div>
                    </div>


                    <div class="row" style="border-radius:50%;text-align:right;margin-bottom:-3%;display:inline-block;float:right;padding:5px 20px 20px 20px;">
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
                    </div>
                    <div style="clear:both;"></div>
                    <?php if($_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"): ?>
                      <div class="row" style="text-align:center;">
                        <div class="hidden-xs hidden-sm col-md-4"></div>
                        <div class="hidden-xs hidden-sm col-md-4"></div>
                        <div class="col-md-4">
                          <br>
                          <style>.descontarGemasModal:hover{cursor:pointer;}</style>
                          <?php if (count($precio_gema)>1): ?>
                          <a class="descontarGemasModal"><b><u>Liquidación de Gemas</u></b></a>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php  endif; ?>
                    <?php 
                      if (count($precio_gema)>1){
                        $precio_gema = $precio_gema[0]['precio_gema'];
                      }
                    ?>



                    <hr>
                    <div class="box-body">
                        <?php  if(!empty($clientesPedidos)){ ?>
                      <div class="container text-center" style="width:100%;">
                          <div class="row">
                            <div class="col-md-4 ">
                              <span style="font-size:1.1em;color:#000;"><b>Líder</b></span>
                                <br>
                              <span style="font-size:1.8em;color:<?php echo $color_btn_sweetalert ?>">
                                <!-- <u style="color:<?=$color_liderazgo?>;text-shadow:0px 0px 1px <?=$color_liderazgo?>"><?php echo $nombre_liderazgo; ?></u> -->
                                <!-- <img src="public/assets/img/liderazgos/{$nombre_liderazgo}.jpg" style="width:30px">    -->
                                  <img src="public/assets/img/liderazgos/<?=$nombre_liderazgo?>logo.png" style="width:40px;">        
                                  <img src="public/assets/img/liderazgos/<?=$nombre_liderazgo?>txt.png" style="width:80px;">  
                                  
                                <!-- <?php echo $nombre_liderazgo; ?> -->
                              </span>
                            </div>

                            <div class="col-md-4">
                              <span style="font-size:1.1em;color:#000;"><b>Total Costo</b></span>    
                                <br>
                              <span style="font-size:1.5em;">
                                <u><b>$<?php echo number_format($total_costo,2,',','.') ?></b></u>
                              </span>
                            </div>

                            <br>

                            <div class="col-md-4">
                              <span style="font-size:1.1em;color:#000;"><b>Descuento por nivel de Liderazgo</b></span>    
                                <table class="col-xs-12" style="font-size:0.9em;">
                                  <?php $totalAp=0; ?>
                                  <?php foreach ($liderazgosAll as $data): if (!empty($data['id_liderazgo'])): ?>
                                    <?php if ($lidera['id_liderazgo'] >= $data['id_liderazgo']): ?>
                                      <tr>
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
                                          <b style="color:#ED2A77">
                                            <?php echo $cantidad_aprobado; ?>  <small>Col.</small>
                                          </b>
                                        </td>
                                        <td> <span style="padding-right:5px;padding-left:5px">=</span> </td>
                                        <td>
                                          <b style="color:#0c0;">
                                            <?php 
                                              $t = $data['descuento_coleccion']*$cantidad_aprobado; 
                                              echo "$".number_format($t,2,',','.');
                                              $totalAp+=$t;
                                            ?>
                                          </b>
                                        </td>
                                      
                                      </tr>
                                    <?php endif ?>
                                  <?php endif; endforeach ?>
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
                                        <b>$<?php echo number_format($total_descuento_distribucion,2,',','.') ?></b>
                                      </span>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                          </div>

                          <br>

                          <div class="row">
                              <!-- <input type="color" name=""> -->
                            <div class="col-xs-12 col-md-8" style="margin-bottom:20px;">
                              <!-- <pre> -->
                              <table class="table-stripped table_liderazgos_pedidos" style="text-align:center;font-size:.9em;margin-top:0;margin-top:-2%;">
                                  <thead>
                                  
                                  <tr>
                                    <!-- <th></th> -->
                                    <th style="font-size:1em;background:#FFFFFF33">Liderazgo</th>
                                    <th style="font-size:1em;background:#DDDDDD33">Colecciones</th>
                                    <th style="font-size:1em;background:#FFFFFF33">Descuento coleccion</th>
                                    <th style="font-size:1em;background:#DDDDDD33">Descuento Acumulado</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                      <?php $num = 1; foreach ($liderazgosAll as $data): if(!empty($data['id_liderazgo'])): ?>
                                    <tr style="background:<?=$data['color_liderazgo']?>33;">
                                      <td style="width:20%;padding:5px 0px;">
                                        <span class="contenido2" >
                                            <b style="color:<?=$data['color_liderazgo']?>;text-shadow:0px 0px 1px <?=$data['color_liderazgo']?>">
                                              <!-- <img src="public/assets/img/liderazgos/<?=$data['nombre_liderazgo']?>logo.png" style="width:30px">          -->
                                               <img src="public/assets/img/liderazgos/<?=$data['nombre_liderazgo']?>txt.png" style="width:70px">         
                                               <!-- <?php echo $data['nombre_liderazgo']; ?>  -->
                                            </b>

                                            <!-- <h4><?php echo "Líder <b>".$data['nombre_liderazgo']."</b>";?></h4> -->
                                        </span>
                                      </td>
                                      <td style="width:20%">
                                        <span class="contenido2">
                                            <?php if($data['maxima_cantidad']==0){
                                             echo $data['minima_cantidad']." - ". $data['minima_cantidad']."+"; 
                                            }else{
                                             echo $data['minima_cantidad']." - ". $data['maxima_cantidad']; 
                                            } ?>
                                        </span>
                                      </td>
                                      <td style="width:20%">
                                        <span class="contenido2"><?php echo "$". number_format($data['descuento_coleccion'],2,',','.'); ?></span>
                                      </td>
                                      <td style="width:20%">
                                        <span class="contenido2"><?php echo "$". number_format($data['total_descuento'],2,',','.'); ?></span>
                                      </td>
                                    </tr>
                                      <?php $num++; endif; endforeach; ?>

                                  </tbody>
                              </table>
                              <!-- </pre> -->
                            </div>

                            
                            <div class="col-md-4">
                              <span style="font-size:1.1em;color:#000;"><b>Descuentos Por Colecciones de Contado</b></span>
                              <br>
                              <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                <tbody>
                                <?php $num = 1; $resulttDescuentoContado=0;  
                                  //foreach ($colss as $col): if(!empty($col['id_plan_campana'])): if(!empty($col['primer_descuento']) && $col['primer_descuento']>0){ ?>
                                      <tr>
                                        <?php
                                          $multi = 0;
                                          $resultt = 0;
                                          if(count($bonosContado)>1){
                                            foreach ($bonosContado as $bono) {
                                              if(!empty($bono['id_bonocontado'])){

                                                  $descuento_bono = $bono['descuentos_bono'];
                                                  $multi = $bono['colecciones_bono'];
                                                  $resultt = $multi * $descuento_bono;
                                                  // if(($multi * $despacho['contado_precio_coleccion']) == $bono['totales_bono']){
                                                  //   $resultt = $bono['totales_bono'];
                                                  // }else{
                                                  //   $resultt = $multi * $despacho['contado_precio_coleccion'];
                                                  // }
                                                  // echo $despacho['contado_precio_coleccion'];
                                        ?>
                                        <td><b>Contado</b></td>
                                        <td><b> <?php echo "$".number_format($descuento_bono,2,',','.'); ?></b></td>
                                        <td><?php echo " x "; ?></td>
                                        <td><b style="color:#ED2A77;"><?php echo $multi; ?> <small>Col.</small></b></td>
                                        <td><?php echo " = "; ?></td>
                                        <td><b style="color:#0c0;">
                                          <?php $resulttDescuentoContado+=$resultt; ?>
                                          <?php echo "$".number_format($resultt,2,',','.'); ?>
                                        </b></td>
                                      </tr>
                                        <?php //$num++; 
                                              } 
                                            }
                                          }
                                        ?>
                                        <?php 
                                  //} endif; endforeach ?>
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
                                            <b>$<?php echo number_format($resulttDescuentoContado,2,',','.') ?></b>
                                          </span>
                                        </td>
                                      </tr>

                                </tbody>
                              </table>

                              <br><span style="font-size:1.1em;color:#000;"><b>Descuento Directos</b></span>
                              <br>
                              <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                <tbody>
                                <?php 
                                $num = 1; $resulttDescuentoDirecto=0;
                                  // echo count($colss);
                                foreach ($colss as $col){
                                  if(!empty($col['id_plan_campana'])){
                                    if(!empty($col['descuento_directo']) && $col['descuento_directo']>0){
                                      ?>
                                      <tr>
                                        <?php $multi = $col['cantidad_coleccion']*$col['cantidad_coleccion_plan']; ?>
                                        <?php $resultt = $multi*$col['descuento_directo']; ?>
                                        <td><b><?php echo "Plan ".$col['nombre_plan']; ?></b></td>
                                        <td><b> <?php echo "$".number_format($col['descuento_directo'],2,',','.'); ?></b></td>
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
                                            <b>$<?php echo number_format($resulttDescuentoDirecto,2,',','.') ?></b>
                                          </span>
                                        </td>
                                      </tr>

                                </tbody>
                              </table>

                              <?php $resultadoDescuentosPagosPuntual = []; ?>
                              <?php foreach ($cantidadPagosDespachosFild as $key): ?>
                                <br>
                                <span style="font-size:1.1em;color:#000;"><b>Descuentos Por <?=$key['name']; ?> Puntual</b></span>
                                <br>
                                <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                    <tbody>
                                    <?php 
                                      $num = 1; 
                                      $resultadoDescuentosPagosPuntual[$key['id']] = 0;
                                      foreach ($colss as $col){ if(!empty($col['id_plan_campana'])){
                                        foreach ($pagos_planes_campana as $pagosPlanesCamp){ if(!empty($pagosPlanesCamp['id_plan_campana'])){
                                          if($col['id_plan_campana']==$pagosPlanesCamp['id_plan_campana']){
                                            if($pagosPlanesCamp['tipo_pago_plan_campana']==$key['name']){
                                              if(!empty($pagosPlanesCamp['descuento_pago_plan_campana']) && $pagosPlanesCamp['descuento_pago_plan_campana']>0){ ?>
                                                <tr>
                                                  <?php
                                                    $multi = 0;
                                                    $resultt = 0;
                                                    foreach ($bonosPagos as $bono) {
                                                      if(!empty($bono['id_plan_campana'])){
                                                        if($bono['id_plan_campana']==$col['id_plan_campana']){
                                                          if($bono['tipo_bono']==$key['name']){
                                                            $multi = $bono['colecciones_bono'];

                                                            $resultt = $bono['descuentos_bono'] * $multi;
                                                            // $resultt = $pagosPlanesCamp['descuento_pago_plan_campana'] * $multi;
                                                            // $resultt = $bono['totales_bono'];
                                                            ?>
                                                            <td><b><?php echo "Plan ".$col['nombre_plan']; ?></b></td>
                                                            <td><b> <?php echo "$".number_format($bono['descuentos_bono'],2,',','.'); ?></b></td>
                                                            <td><?php echo " x "; ?></td>
                                                            <td><b style="color:#ED2A77;"><?php echo $multi; ?> <small>Col.</small></b></td>
                                                            <td><?php echo " = "; ?></td>
                                                            <td><b style="color:#0c0;">
                                                              <?php $resultadoDescuentosPagosPuntual[$key['id']]+=$resultt; ?>
                                                              <?php echo "$".number_format($resultt,2,',','.'); ?>
                                                            </b></td>
                                                          </tr>
                                                            <?php
                                                          }
                                                        }
                                                      } 
                                                    }
                                                   $num++; 
                                              }
                                            }
                                          }
                                        }}
                                      }}
                                    ?>
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
                                          <b>$<?php echo number_format($resultadoDescuentosPagosPuntual[$key['id']],2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>

                                  </tbody>
                                </table>
                              <?php endforeach; ?>

                              <?php
                                $resulttDescuentoPagosPuntuales = 0;
                                foreach ($resultadoDescuentosPagosPuntual as $bonoPuntual) {
                                  $resulttDescuentoPagosPuntuales+=$bonoPuntual;
                                }

                                $resulttDescuentoCierreEstructura = 0;
                              ?>
                              <?php if($lidera['id_liderazgo'] > $lidSenior['id_liderazgo']){ if(count($estructuraLideres) > 0){ ?>
                                <br>
                                <style>.detallarModalCierre:hover{cursor:pointer;}</style>
                                <span class="detallarModalCierre" style="font-size:1.1em;color:#000;"><u><b>Descuentos por cierre de estructura</b></u></span>
                                <br>
                                <table class="col-xs-12" style="font-size:0.9em;">
                                  <?php  foreach ($liderazgosAll as $data): if (!empty($data['id_liderazgo'])): if($data['nombre_liderazgo']!="JUNIOR"&&$data['nombre_liderazgo']!="SENIOR"): ?>
                                    <?php if ($lidera['id_liderazgo'] >= $data['id_liderazgo']): ?>
                                      <tr>
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
                                          <?php
                                          $acumColeccionesBonoCierre = 0;
                                          if(count($bonoCierreEstructura)>1){
                                            foreach ($bonoCierreEstructura as $cEstruc) {
                                              if(!empty($cEstruc['id_liderazgo'])){
                                                if($data['id_liderazgo']==$cEstruc['id_liderazgo']){
                                                  $acumColeccionesBonoCierre += $cEstruc['colecciones_bono_cierre'];
                                                }
                                              }
                                            }
                                          }
                                            //echo $acumColeccionesBonoCierre;
                                          ?>
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
                                    <?php endif ?>
                                  <?php endif; endif; endforeach ?>
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
                                        <b>$<?php echo number_format($resulttDescuentoCierreEstructura,2,',','.') ?></b>
                                      </span>
                                    </td>
                                  </tr>
                                </table>
                              <?php } } ?>


                              <?php
                                $Opttraspasarexcedente=="1";
                                $totalTraspasoRecibido=0; 
                                if ($Opttraspasarexcedente=="1"): if(count($traspasosRecibidos)>1):
                                  ?>
                                  <br>
                                  <span style="font-size:1.1em;color:#000;"><b>Traspasos Recibidos</b></span>
                                  <br>
                                  <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                    <tbody>
                                    <?php $num = 1;   
                                      foreach ($traspasosRecibidos as $traspas): 
                                        if(!empty($traspas['id_traspaso'])):?>
                                          <tr>
                                            <?php  ?>
                                            <td><b><?php echo "Líder ".$traspas['primer_nombre']." ".$traspas['primer_apellido']." (".$traspas['numero_despacho'].")"; ?></b></td>
                                            <td></td>
                                            <td><b style="color:#ED2A77;">Traspaso</b></td>
                                            <td><?php echo " = "; ?></td>
                                            <td><b style="color:#0C0;">
                                              <?php $totalTraspasoRecibido+=$traspas['cantidad_traspaso']; ?>
                                              <?php echo "$".number_format($traspas['cantidad_traspaso'],2,',','.'); ?>
                                            </b></td>
                                          </tr>
                                            <?php $num++; 
                                       endif; endforeach ?>
                                        <tr>
                                            <td colspan="6" style="border-bottom:1px solid #777"></td>
                                          </tr>
                                          <tr>
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
                                              <span style="font-size:1.5em;color:#0C0">
                                                <b>$<?php echo number_format($totalTraspasoRecibido,2,',','.') ?></b>
                                              </span>
                                            </td>
                                          </tr>

                                    </tbody>
                                  </table>
                                <?php endif; endif;
                              ?>

                                <hr>
                                <br>
                                <hr>
                              <?php 
                                $resultLiquidacionGemas = 0;
                                if(count($liquidacion_gemas)>1){
                                  $liquidacionGemas = $liquidacion_gemas[0];
                                  $resulttDescuentoLiquidacion = 0; 
                              ?>
                                <br>
                                <span style="font-size:1.1em;color:#000;"><b>Descuentos Por Liquidación de gemas</b></span>
                                <br>
                                <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                  <tbody>
                                    <tr>
                                      <td><b><?php echo "Liquidación "; ?></b></td>
                                      <td><b> <?php echo "$".number_format($precio_gema,2,',','.'); ?></b></td>
                                      <td><?php echo " x "; ?></td>
                                      <td><b style="color:#ED2A77;"><?php echo number_format($liquidacionGemas['cantidad_descuento_gemas'],2,',','.');; ?> <small>Gemas.</small></b></td>
                                      <td><?php echo " = "; ?></td>
                                      <td><b style="color:#0c0;">
                                        <?php $resultLiquidacionGemas = $liquidacionGemas['total_descuento_gemas']; ?>
                                        <?php $resulttDescuentoLiquidacion+=$resultLiquidacionGemas; ?>
                                        <?php echo "$".number_format($resultLiquidacionGemas,2,',','.'); ?>
                                      </b></td>
                                    </tr>
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
                                          <b>$<?php echo number_format($resultLiquidacionGemas,2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              <?php
                                }
                              ?>



                              <br>
                              <?php
                                $totalDescuentoVendedor = $total_descuento_distribucion + 
                                                          $resulttDescuentoContado +
                                                          $resulttDescuentoDirecto + 

                                                          $resulttDescuentoPagosPuntuales+

                                                          $totalTraspasoRecibido +
                                                          $resulttDescuentoCierreEstructura +
                                                          $resultLiquidacionGemas;
                              ?>

                               <span style="font-size:1.3em"><b>Total Descuento = </b><b style="color:#0c0"><?php  echo"$".number_format($totalDescuentoVendedor,2,',','.'); ?></b></span>

                              <?php
                                $totalTraspasoEmitido = 0;
                                if ($Opttraspasarexcedente=="1"):
                                  if(count($traspasosEmitidos)>1):
                                
                                  ?>
                                  <br><br>
                                  <span style="font-size:1.1em;color:#000;"><b>Traspasos Realizados</b></span>
                                  <br>
                                  <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                    <tbody>
                                    <?php $num = 1;   
                                      foreach ($traspasosEmitidos as $traspas): 
                                        if(!empty($traspas['id_traspaso'])):?>
                                          <tr>
                                            <?php
                                              // $totalTraspasoEmitido = 0;
                                              // $multi = 0;
                                              // $resultt = 0;
                                              // foreach ($bonosPago1 as $bono) {
                                              //   if(!empty($bono['id_plan_campana'])){
                                              //     if($bono['id_plan_campana']==$col['id_plan_campana']){
                                              //       $multi = $bono['colecciones_bono'];
                                              //       $resultt = $bono['totales_bono'];
                                              //     }
                                              //   } 
                                              // }
                                            ?>
                                            <?php  ?>
                                            <td><b><?php echo "Líder ".$traspas['primer_nombre']." ".$traspas['primer_apellido']." (".$traspas['numero_despacho'].")"; ?></b></td>
                                            <td></td>
                                            <td><b style="color:#ED2A77;">Traspaso</b></td>
                                            <td><?php echo " = "; ?></td>
                                            <td><b style="color:#C00;">
                                              <?php $totalTraspasoEmitido+=$traspas['cantidad_traspaso']; ?>
                                              <?php echo "$".number_format($traspas['cantidad_traspaso'],2,',','.'); ?>
                                            </b></td>
                                          </tr>
                                            <?php $num++; 
                                       endif; endforeach ?>
                                        <tr>
                                            <td colspan="6" style="border-bottom:1px solid #777"></td>
                                          </tr>
                                          <tr>
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
                                              <span style="font-size:1.5em;color:#C00">
                                                <b>$<?php echo number_format($totalTraspasoEmitido,2,',','.') ?></b>
                                              </span>
                                            </td>
                                          </tr>

                                    </tbody>
                                  </table>
                                <?php endif; endif;
                              ?>

                              <br>
                              <?php  if(count($promocionesFull)>1){ ?>
                                <br>
                                <span style="font-size:1.1em;color:#000;"><b>(-) Promociones adquiridas</b></span>
                                <br>
                                <table class="table-stripped" style="text-align:center;width:100%;font-size:.9em;">
                                  <tbody>
                                    <?php 
                                      foreach ($promocionesFull as $promo){ if(!empty($promo['id_promociones'])){ ?>
                                      <tr>
                                        <td><b><?php echo $promo['nombre_promocion']; ?></b></td>
                                        <td><b> <?php echo "$".number_format($promo['precio_promocion'],2,',','.'); ?></b></td>
                                        <td><?php echo " x "; ?></td>
                                        <td><b style="color:#ED2A77;"><?php echo number_format($promo['cantidad_aprobada_promocion'],2,',','.'); ?></b></td>
                                        <td><?php echo " = "; ?></td>
                                        <td><b style="color:#C00;">
                                          <?php
                                            $deudaPorPromocion = $promo['precio_promocion']*$promo['cantidad_aprobada_promocion'];
                                            $resultDeudaPorPromociones += $deudaPorPromocion;
                                            echo "$".number_format($deudaPorPromocion,2,',','.');
                                          ?>
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
                                        <span style="font-size:1.5em;color:#C00">
                                          <b>$<?php echo number_format($resultDeudaPorPromociones,2,',','.') ?></b>
                                        </span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br>
                              <?php } ?>
                            </div>
                          </div>
                          <br>

                          <!-- $traspasosEmitidos -->
                          <!-- $traspasosRecibidos -->
                          <div>
                            
                          </div>

                          <div class="row">
                            <?php 
                              $bg_debe_haber = "#"; 
                              $cantidad_excedente = 0;
                              $excedentes = $lider->consultarQuery("SELECT * FROM excedentes WHERE id_pedido = {$_GET['id']} and estatus = 1");
                              // if(count($excedentes)>1){
                              //   $excedent = $excedentes[0];
                              //   $cantidad_excedente = $excedent['cantidad_excedente'];
                              //   $descripcion_excedente = $excedent['descripcion_excedente'];
                              // }
                              $excedente_cantidad = [];
                              $excedente_descripcion = [];
                              $iterador = 0;
                              foreach ($excedentes as $exced) {
                                if(!empty($exced['id_excedente'])){
                                  $cantidad_excedente += $exced['cantidad_excedente'];
                                  $excedente_cantidad[$iterador]['id'] = $exced['id_excedente'];
                                  $excedente_cantidad[$iterador]['cantidad'] = $exced['cantidad_excedente'];
                                  $excedente_descripcion[$iterador]['id'] = $exced['id_excedente'];
                                  $excedente_descripcion[$iterador]['descripcion'] = $exced['descripcion_excedente'];
                                  $iterador++;
                                }
                              }


                                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;
                                $total_responsabilidad = $total_costo - $totalDescuentoVendedor + $resultDeudaPorPromociones;
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
                              <br>
                                <?php 
                                  // echo $cantidad_excedente;
                                  // echo "<br>";
                                  // echo $restaTotalResponsabilidad;
                                  // echo "<br>";
                                    $restaTotalResponsabilidad += $totalTraspasoEmitido;
                                    $restaTotalResponsabilidadBackup = 0;
                                    $newRestaTotalResponsabilidad = 0;
                                    $newRestaTotalRespPositive = 0;
                                    $restaTotalResponsabilidadBackupPositive = 0;
                                    if($totalDistribucionDescuentos > $totalDescuentoVendedor){
                                      $newRestaTotalResponsabilidad = $totalDescuentoVendedor-$totalDistribucionDescuentos;
                                      if($newRestaTotalResponsabilidad>=$restaTotalResponsabilidad){
                                        $restaTotalResponsabilidadBackup = $restaTotalResponsabilidad;
                                        $restaTotalResponsabilidad -= $newRestaTotalResponsabilidad;
                                      }
                                    }
                                    if( $newRestaTotalResponsabilidad != 0 ){
                                      if($newRestaTotalResponsabilidad < 0){
                                        $newRestaTotalRespPositive = ($newRestaTotalResponsabilidad*(-1));
                                        $restaTotalResponsabilidadBackupPositive = ($restaTotalResponsabilidadBackup*(-1));
                                      }else{
                                        $newRestaTotalRespPositive = $newRestaTotalResponsabilidad;
                                        $restaTotalResponsabilidadBackupPositive = $restaTotalResponsabilidadBackup;
                                      }
                                    }
                                    // if($cantidad_excedente>0){
                                    //   $restaTotalResponsabilidad += $cantidad_excedente;
                                    // }
                                ?>
                              <span style="font-size:1.3em;color:#222;"><b><u>Resta</u></b></span>    
                              <br>
                                <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                                  <span style="color:#000;font-size:1em;width:100%;display:block;">
                                  <?php
                                    if( $newRestaTotalResponsabilidad != 0 ){
                                      echo "<b>Observación: </b><br>";
                                      echo "Excedente: <b>$".number_format($restaTotalResponsabilidadBackupPositive,2,',','.').
                                      " - $".number_format($newRestaTotalRespPositive,2,',','.')."</b> distribuidos.<br>Quedan:";
                                    }
                                  ?>
                                  </span>
                                <?php } ?>

                              <span style="font-size:2em;color:#C00;">
                                <b>$<?php echo number_format($restaTotalResponsabilidad,2,',','.') ?></b>
                              </span>
                              <br>
                              <?php
                                // echo $restaTotalResponsabilidad;
                              ?>
                              <br>
                              <?php if($estado_campana=="1"){ ?>
                              <?php
                                if ($Opttraspasarexcedente=="1"):
                                  $restoDisponible = ($restaTotalResponsabilidad*(-1));
                                  $newrestoDisponible = number_format($restoDisponible,2);
                                  $newrestoDisponibleNegativo = number_format($restaTotalResponsabilidad,2);
                                  if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                                    <?php if ($newrestoDisponible > 0 ): ?>
                                      <br>
                                      <style>.traspasar:hover{cursor:pointer;}</style>
                                      <span class="modalTraspasar" style="color:#C00;"><u class="traspasar"><b>Traspasar</b></u></span>
                                    <?php endif ?>
                                <?php 
                                  }else{
                                    if($newrestoDisponible > 0 ): ?>
                                      <?php if ($cliente['id_cliente'] == $cuenta['id_cliente']): ?>
                                        <br>
                                        <style>.traspasar:hover{cursor:pointer;}</style>
                                        <!-- <span class="modalTraspasar" style="color:#C00;"><u class="traspasar"><b>Traspasar</b></u></span> -->
                                      <?php endif ?>
                                    <?php endif;
                                  }
                              ?>
                              <?php endif; ?>
                              <?php } ?>

                              <br>
                              <?php
                                if($cantidad_excedente>0){
                                  echo "<span style='color:#000;' class='modalDescripcionExcedente'><b>Excedente pagado $".number_format($cantidad_excedente,2,',','.')."</b></span>";
                                }
                              ?>
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
                          <?php
                            $porcentajeAbonadoPuntual = ($abonado_lider_gemas*100)/$total_responsabilidad;
                            // echo $abonado_lider_gemas;
                            // echo $porcentajeAbonadoPuntual;
                            $coleccionesPuntuales = ($pedido['cantidad_aprobado']/100)*$porcentajeAbonadoPuntual;
                            // ============================== // ================================== // ============================== //
                            // echo $abonado_lider_gemas."<br>";
                            // echo $pedido['cantidad_aprobado']." Cols => 100%<br>";
                            // echo $coleccionesPuntuales." Cols => ".$porcentajeAbonadoPuntual."%<br>";
                            // ============================== // ================================== // ============================== //
                          ?>
                          <?php if (date('Y-m-d') >= $fechaPagoLimiteFinal || ( number_format($restaTotalResponsabilidad,1,',','.') <= 0 )): ?>
                            <span style="text-align:right;position:absolute;right:0px;margin-top:-15px">
                              <small>
                                Abonado hasta la fecha <?php echo $lider->formatFecha($fechaPagoLimiteFinal).": $".number_format($abonado_lider_gemas,2,',','.'); ?>
                                <?php 
                                  echo " (".number_format($porcentajeAbonadoPuntual,2,',','.')."%)";
                                ?>
                              </small>
                            </span>
                          <?php endif; ?>
                            </div>
                          </div>

                        <?php
                          if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"  || $_SESSION['nombre_rol']=="Administrativo"){
                            // echo $newrestoDisponible = $newrestoDisponible-0.00;
                            // echo $newrestoDisponible;
                            // echo "<br>";
                            // echo $newrestoDisponibleNegativo;
                            if($newrestoDisponible > 0){
                        ?>
                            <br>                              
                            <button class="btn enviar2 btncerrarExcedente" style="background:#c00 !important;">Pagar excedente</button>
                        <?php
                            }
                          }
                        ?>


                        <?php
                          $restaTotalGemas = $total_responsabilidad - $abonado_lider_gemas;
                          // echo $abonado_lider_gemas;
                          // $restaTotalGemas = 0;
                          // echo $restaTotalGemas;
                          // echo $restaTotalResponsabilidad;

                          // $restaTotalResponsabilidad = 0;

                          // echo "Cantidad de pagos: ".(count($pagosGemas)-1)."<br>";
                          // echo "Pedido: ".$id."<br>";
                          // echo "YO : ".$_SESSION['id_cliente']."<br>";
                          // echo "Cliente: ".$pedido['id_cliente']."<br>";
                          // echo "Campaña: ".$id_campana."<br>";
                          // echo "Fecha cierre: ".$despacho['fecha_segunda_senior']."<br>";
                          // echo "Fecha de ultimo Pago del lider: ".$fecha_pago_cierre_lider."<br>";
                          // echo "Responsabilidad: ".number_format($total_responsabilidad,2,',','.')."<br>";
                          // echo "<br>";
                          // echo "Abonado actual: ".number_format($abonado,2,',','.')."<br>";
                          // echo "Resta actual: ".number_format($restaTotalResponsabilidad,2,',','.')."<br>";

                          // echo "<br>";
                          // echo "Responsabilidad: ".number_format($total_responsabilidad,2,',','.')."<br>";
                          // echo "Abonado por Lider Puntual Cierre: ".number_format($abonado_lider_gemas,2,',','.')."<br>";
                          // echo "Resta Gemas: ".number_format($restaTotalGemas,2,',','.')."<br>";


                          // echo "Resta actual: ".number_format($restaTotalResponsabilidad,1,',','.')."<br>";
                          // echo "Resta Gemas: ".number_format($restaTotalGemas,1,',','.')."<br>";
                          // $reclamargemasporcentaje = 0;
                          if (count($gemasReclamar)>1){
                            $gemaReclamar = $gemasReclamar[0];
                            $gemasAReclamar = $gemaReclamar['cantidad_gemas'];
                            if($porcentajeAbonadoPuntual <= 100){
                            }else{
                              $porcentajeAbonadoPuntual = 100;
                            }
                            //echo $porcentajeAbonadoPuntual;
                            // $restaTotalResponsabilidad-=0.08;
                            // echo "<br><h1>".$reclamargemasporcentaje."<br>".number_format($restaTotalResponsabilidad,2,'.',',')."</h1><br>";

                            $gemasAReclamarPorcentaje = ($gemaReclamar['cantidad_gemas']/100)*$porcentajeAbonadoPuntual;
                            if($cantidad_acumuladaVer >= $varMinimaColeccionesParaGemas){
                              if ($reclamargemasporcentaje=="0") {
                                if( ($fecha_pago_cierre_lider <= $despacho['fecha_segunda_senior']) && (number_format($restaTotalGemas,1,',','.') <= 0) ){ ?>
                                  <?php if ($_SESSION['id_cliente'] == $pedido['id_cliente']): ?>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12" style="border:1px solid #CCC;">
                                          <div>
                                            <input type="hidden" id="cantidad_gemas_lider" value="<?=number_format($gemasAReclamar,2,',','.')?>">
                                            <button class="btn enviar2 reclamarGemasBtn col-xs-12" value="?<?=$menu?>&route=<?=$url?>&id=<?=$id?>&reclamar=1&gema=<?=$gemaReclamar['id_gema']?>">
                                              <span class="fa fa-diamond"></span>
                                              Reclamar Gemas Totat
                                              <span class="fa fa-diamond"></span>
                                            </button>
                                          </div>
                                      </div>
                                    </div>
                                    <br>
                                  <?php else: ?>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12" style="border:1px solid #CCC;">
                                          <div>
                                            <input type="hidden" value="<?=number_format($gemasAReclamar,2,',','.')?>">
                                            <input type="hidden" value="<?=number_format($gemasAReclamarPorcentaje,2,',','.')?>">
                                            <button class="btn col-xs-12" style="background:#999;color:#fff">
                                              <span class="fa fa-diamond"></span>
                                              Reclamar Gemas Porcent
                                              <span class="fa fa-diamond"></span>
                                            </button>
                                          </div>
                                      </div>
                                    </div>
                                    <br>
                                  <?php endif; ?>
                                  <?php  
                                }
                              }

                              if ($reclamargemasporcentaje=="1") {
                                // echo $restaTotalResponsabilidad;
                                // echo "<br>";
                                // echo number_format($restaTotalResponsabilidad,2,'.','');
                                if( number_format($restaTotalResponsabilidad,2,'.','') <= 0.01 ){

                                  if ($_SESSION['id_cliente'] == $pedido['id_cliente']){ ?>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12" style="border:1px solid #CCC;">
                                          <div>
                                            <input type="hidden" id="cantidad_gemas_lider_porcent" value="<?=number_format($gemasAReclamar,2,',','.')?>">
                                            <input type="hidden" id="porcentaje_gemas_lider" value="<?=number_format($gemasAReclamarPorcentaje,2,',','.')?>">

                                            <button class="btn enviar2 reclamarGemasPorcentajeBtn col-xs-12" value="?<?=$menu?>&route=<?=$url?>&id=<?=$id?>&reclamarporcentaje=1&gema=<?=$gemaReclamar['id_gema'];?>&porcentaje=<?=$gemasAReclamarPorcentaje;?>&porcentPago=<?=number_format($porcentajeAbonadoPuntual,2,'.',''); ?>">
                                              <span class="fa fa-diamond"></span>
                                              Reclamar Gemas 
                                              <span class="fa fa-diamond"></span>
                                            </button>
                                          </div>
                                      </div>
                                    </div>
                                    <br>
                                  <?php } else { ?>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12" style="border:1px solid #CCC;">
                                          <div>
                                            <input type="hidden" value="<?=number_format($gemasAReclamar,2,',','.')?>">
                                            <input type="hidden" value="<?=number_format($gemasAReclamarPorcentaje,2,',','.')?>">
                                            <button class="btn col-xs-12" style="background:#999;color:#fff">
                                              <span class="fa fa-diamond"></span>
                                              Reclamar Gemas 
                                              <span class="fa fa-diamond"></span>
                                            </button>
                                          </div>
                                      </div>
                                    </div>
                                    <br>
                                  <?php }
                                }
                              } 
                            }
                          }

                        ?>

                      </div>

                        <?php
                          // echo "Total Precio de Coleccion: ".number_format($precio_coleccion,2,',','.')."$<br>";
                          // echo "Cantidad Total de Coleccion aprobadas: ".$cantidad_aprobado." Colecciones <br>";
                          // echo "Costo Generado por $cantidad_aprobado Colecciones a ".number_format($precio_coleccion,2,',','.')."$: ".number_format($total_costo,2,',','.')."$<br>";
                          // echo "Descuento acumulado por liderazgo <b>$nombre_liderazgo</b>: ".number_format($descuentoXColeccion,2,',','.')."$ por cada Coleccion<br>";
                          // echo "Genera un Descuento de: <b>".number_format($descuento_total,2,',','.')."$</b> por las $cantidad_aprobado colecciones<br>";
                          // echo "DESCUENTO ADICIONAL DE: <b>".number_format($descuentoAdicional,2,',','.')."$</b> Por vendedoras Hijas<br>";
                          // echo "<br>";
                          // echo "TOTAL GENERAL DE COLECCIONES: ".$cantidad_total."<br>";
                          // echo "CANTIDAD TOTAL DE: ".$total_cantidad_hijas." Colecciones de Vendedoras <br>";
                          // echo "<br>";
                          // echo "<br>";


                          // echo "descuento por coleccion: ".$descuentoXColeccion."$<br>";
                          // echo "cantidad personal de colecciones: ".$cantidad_aprobado." colecciones<br>";
                          // echo "descuento personal: ".$descuento_total."$<br><br>";
                          // echo "cantidad colecciones total: ".$cantidad_total." colecciones<br><br>";
                          // echo "cantidad de colecciones de vendedores: ".$total_cantidad_hijas." colecciones<br>";
                          // echo "descuento de vendedores: ".$descuentoAdicional."$<br>";
                          // echo "descuento acumulado por vendedores: ".$descuento_distribucion_real."$<br><br>";
                          // echo "descuento Real acumulado: ( SUMA de: $descuento_total$ + $descuento_distribucion_real$ ) = ".$total_descuento_distribucion."$<br>";
                          // echo "Total Responsabilidad: ( $cantidad_aprobado col. * $precio_coleccion$ de C/U col ) = ".$total_costo."$<br>";
                          // echo "resto total: ( $total_costo$ - $total_descuento_distribucion$) = ".$total_responsabilidad."$<br>";

                          }
                        ?>
                      
                    </div>
                  </div>

                  <div class="row text-center" style="padding:10px 20px;">
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta.""?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Reportado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado,2, ",",".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido"?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Diferido</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido,2, ",",".")?></b></h4>
                      </a>
                    </div>
                    <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <?php if ($accesoSinPostPago=="1"): ?>
                      <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado"?>">
                      <?php else: ?>
                      <a>
                      <?php endif; ?>
                        <b style="color:#000 !important">Abonado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado,2, ",",".")?></b></h4>
                      </a>
                    </div>
                  </div>


                    <?php } ?>
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


  <div class="box-modalDescuentoGemas" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:9000;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDescuentoGemas" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Liquidar gemas para obtener descuento de lider</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <table class="text-center" style="width:90%;">
                        <thead>
                          <th>Liquidacion</th>
                          <th>Precio</th>
                          <th></th>
                          <th>Gemas</th>
                          <th></th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php //foreach ($colss as $col): if(!empty($col['id_plan_campana'])): if($col['primer_descuento']>0): ?>
                            <tr>
                              <td style="width:50%">Liquidación de Gemas</td>
                              <td style="width:10%"><input type="number" class="form-control" id="precioGema" value="<?=$precio_gema; ?>" readonly style='background:none;' name="precioGema"></td>
                              <td style="width:3.3%">x</td>
                              <td style="width:10%"><input type="number" <?php if(count($liquidacion_gemas)>1){ foreach ($liquidacion_gemas as $liquidacion) {
                                if(!empty($liquidacion['cantidad_descuento_gemas'])){ ?>
                                    value="<?=$liquidacion['cantidad_descuento_gemas']?>"
                                  <?php
                                }
                              } } ?> placeholder="0" class="form-control valoresLiquidacion" max="<?=$gemasAdquiridasDisponiblesCliente?>" id="<?=$col['id_plan_campana']?>" step="1" name="valoresLiquidacion"></td>
                              <td style="width:3.3%">=</td>
                              <td style="width:15%"><input type="number" <?php if(count($liquidacion_gemas)>1){ foreach ($liquidacion_gemas as $liquidacion) {
                                if(!empty($liquidacion['cantidad_descuento_gemas'])){ ?>
                                    value="<?=$liquidacion['cantidad_descuento_gemas']*$precio_gema; ?>"
                                  <?php
                                }
                              } } ?> placeholder="0" class="form-control" step="1" id="totalesLiquidacion" name="totalesLiquidacion" readonly style='background:none;'></td>
                            </tr>
                          <?php //endif; endif; endforeach; ?>
                          <input type="hidden" class="id_pedido_modal" value="<?=$pedido['id_pedido']?>" name="id_pedido_modal">
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalLiquidacionGemas">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalLiquidacionGemas d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="box-modalDetalleCierre" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:9000;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid" >
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarDetalleModalCierre" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h4 class="box-title">Descuentos por Cierre de Estructura </h4>
                  </div>
                  <style type="text/css">
                    .fontmodal {
                      font-size:1.2em;
                    }
                    @media (max-width: 768px) {
                      .fontmodal {
                        font-size:1em;
                      }
                    }
                  </style>
                  <div class="box-body" style="max-height:50vh;overflow:auto;width:auto;">
                    <div >
                      <?php foreach ($liderazgosAll as $col): if(!empty($col['id_liderazgo'])): if(($col['nombre_liderazgo']!="JUNIOR")&&($col['nombre_liderazgo']!="SENIOR")): if($col['id_liderazgo'] <= $lidera['id_liderazgo']): ?>
                          <div class="col-xs-12" style="background:<?=$col['color_liderazgo']?>33">
                            <br>
                            <span style="" class="fontmodal">
                              <b>
                              Nivel 
                              <img style="width:30px;position:relative;top:-5px;" src="public/assets/img/liderazgos/<?=$col['nombre_liderazgo'];?>logo.png">
                              <?=$col['nombre_liderazgo'];?> 
                              </b>
                            </span>
                          </div>
                          <div class="col-xs-12" style="background:<?=$col['color_liderazgo']?>33">
                           <table class="text-center fontmodal" style="width:90%;width:100%;">
                              <thead>
                                <th>Líder</th>
                                <th>Descuento</th>
                                <th></th>
                                <th>Colecciones</th>
                                <th></th>
                                <th>Total</th>
                              </thead>
                              <tbody>
                                <?php 
                                  $acumColeccionesBono = 0;
                                  $acumTotalesbonos = 0;

                                ?>
                                <?php foreach ($detallesEstructura as $detalle): ?>
                                  <?php if (!empty($detalle['id_cliente'])): ?>
                                    <?php if ($detalle['id_liderazgo']==$col['id_liderazgo']): ?>
                                      <?php if ($detalle['colecciones_bono_cierre']>0): ?>
                                        
                                      <tr>
                                        <td><?=$detalle['primer_nombre']." ".$detalle['primer_apellido']?></td>
                                        <td>$<?=number_format($col['descuento_coleccion'],2,',','.');?></td>
                                        <td>X</td>
                                        <td><?=$detalle['colecciones_bono_cierre'];?> Col.</td>
                                        <td>=</td>
                                        <td>$<?=number_format($detalle['totales_bono_cierre'],2,',','.');?></td>
                                      </tr>
                                      <?php
                                        $acumColeccionesBono += $detalle['colecciones_bono_cierre'];
                                        $acumTotalesbonos += $detalle['totales_bono_cierre'];
                                      ?>
                                      <?php endif; ?>
                                    <?php endif ?>
                                  <?php endif ?>
                                <?php endforeach ?>
                                      <tr style="border-top:0.5px solid #000">
                                        <td><b>Total de nivel <?=$col['nombre_liderazgo'];?></b></td>
                                        <td><b>$<?=number_format($col['descuento_coleccion'],2,',','.');?></b></td>
                                        <td><b>X</b></td>
                                        <td><b><?=$acumColeccionesBono;?> Col.</b></td>
                                        <td><b>=</b></td>
                                        <td><b>$<?=number_format($acumTotalesbonos,2,',','.');?></b></td>
                                      </tr>
                              </tbody>
                            </table>
                            <br>
                          </div>
                          <?php  endif; endif; endif; endforeach; ?>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalDescuentoContado" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:9000;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDescuentoContado" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Descuentos de Colecciones de Contado </h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <table class="text-center" style="width:90%;">
                        <thead>
                          <th>Contado</th>
                          <th>Descuento</th>
                          <th></th>
                          <th>Colecciones</th>
                          <th></th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php //foreach ($colss as $col): if(!empty($col['id_plan_campana'])): if($col['primer_descuento']>0): ?>
                            <tr>
                              <td style="width:50%">Colecciones de Contado </td>
                              <td style="width:10%"><input type="number" class="form-control" id="descuentoContado" value="<?=$despacho['contado_precio_coleccion']?>" readonly style='background:none;' name="descuentoContado"></td>
                              <td style="width:3.3%">x</td>
                              <td style="width:10%"><input type="number" <?php if(count($bonosContado)>1){ foreach ($bonosContado as $bono) {
                                if(!empty($bono['id_bonocontado'])){ ?>
                                    value="<?=$bono['colecciones_bono']?>"
                                  <?php
                                }
                              } } ?> placeholder="0" class="form-control valoresContado" max="<?=$cantidad_aprobado?>" id="<?=$col['id_plan_campana']?>" step="1" name="valoresContado"></td>
                              <td style="width:3.3%">=</td>
                              <td style="width:15%"><input type="number" <?php if(count($bonosContado)>1){ foreach ($bonosContado as $bono) {
                                if(!empty($bono['id_bonocontado'])){ ?>
                                    value="<?=$bono['totales_bono']?>"
                                  <?php
                                }
                              } } ?> placeholder="0" class="form-control" step="1" id="totalContado" name="totalesContado" readonly style='background:none;'></td>
                            </tr>
                          <?php //endif; endif; endforeach; ?>
                          <input type="hidden" class="id_pedido_modal" value="<?=$pedido['id_pedido']?>" name="id_pedido_modal">
                          <input type="hidden" class="tipo_bono" value="Contado" name="tipo_bono">
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDescuentoContado">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDescuentoContado d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


  <div class="box-modalBonoPagosPuntuales" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:9000;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalBonoPagosPuntuales" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                  </div>

                  <div class="box-body" style="max-height:50vh;overflow:auto;">
                  <?php foreach ($cantidadPagosDespachosFild as $keys){ ?>
                    <div class="col-xs-12">
                      <h4 class="box-title">Descuentos de <?=$keys['name']; ?> Puntual </h4>
                      <table class="text-center" style="width:90%;">
                        <thead>
                          <th>Plan</th>
                          <th></th>
                          <th>Descuento</th>
                          <th></th>
                          <th>Colecciones</th>
                          <th></th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php
                            foreach ($colss as $col){ if(!empty($col['id_plan_campana'])){ 
                              foreach ($pagos_planes_campana as $pagosPlanesCamp){ if(!empty($pagosPlanesCamp['id_plan_campana'])){
                                if($col['id_plan_campana']==$pagosPlanesCamp['id_plan_campana']){
                                  if($pagosPlanesCamp['tipo_pago_plan_campana']==$keys['name']){
                                    if(!empty($pagosPlanesCamp['descuento_pago_plan_campana']) && $pagosPlanesCamp['descuento_pago_plan_campana']>0){
                                        $bonoColeccion = 0;
                                        $totalBono = 0;
                                        if(count($bonosPagos)>1){ foreach ($bonosPagos as $bono) {
                                          if(!empty($bono['id_bonoPago'])){
                                            if($bono['id_plan_campana']==$col['id_plan_campana']){
                                              if ($bono['tipo_bono']==$keys['name']){
                                                $bonoColeccion = $bono['colecciones_bono'];
                                                $totalBono = $pagosPlanesCamp['descuento_pago_plan_campana'] * $bonoColeccion;
                                                // $totalBono = $bono['totales_bono'];
                                              }
                                            }
                                          }
                                        }}
                                      ?> 
                                      <tr>
                                        <td style="width:30%">Plan <?=$col['nombre_plan']?></td>
                                        <td style="width:3.3%"><input type="hidden" value="<?=$col['id_plan_campana']?>" name="id[<?=$keys['name'] ?>][]" readonly></td>
                                        <td style="width:10%"><input type="number" class="form-control" id="descuento<?=$keys['id'].$col['id_plan_campana']?>" value="<?=$pagosPlanesCamp['descuento_pago_plan_campana']; ?>" readonly style='background:none;' name="descuentos[<?=$keys['name'] ?>][]"></td>
                                        <td style="width:3.3%">x</td>
                                        <td style="width:10%"><input type="number" 
                                        placeholder="0" class="form-control valores" max='<?=$col['cantidad_coleccion_plan']?>' id="<?=$keys['id'].$col['id_plan_campana'];?>" value="<?=$bonoColeccion; ?>" step="1" name="valores[<?=$keys['name'] ?>][]"></td>
                                        <td style="width:3.3%">=</td>
                                        <td style="width:15%"><input type="number" value="<?=$totalBono; ?>" placeholder="0" class="form-control" step="1" id="total<?=$keys['id'].$col['id_plan_campana']?>" name="totales[<?=$keys['name'] ?>][]" readonly style='background:none;'></td>
                                      </tr>
                                    <?php 
                                    }
                                  }
                                }
                              }}
                            }}
                          ?>
                          <input type="hidden" class="tipo_bono" value="<?=$keys['name']; ?>" name="tipo_bono[]">
                        </tbody>
                      </table>
                      <hr>
                    </div>

                  <?php } ?>
                  </div>
                  <input type="hidden" class="id_pedido_modal" value="<?=$pedido['id_pedido']?>" name="id_pedido_modal">


                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalBonoPagosPuntuales">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalBonoPagosPuntuales d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


  <?php if(!empty($_GET['liderEstruct'])){ ?>
  <div class="box-modalDescuentoCierreEstructura" style="background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
    <?php } else { ?>
  <div class="box-modalDescuentoCierreEstructura" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
    <?php } ?>
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDescuentoCierreEstructura" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Descuentos de Cierre Puntual </h3>
                  </div>

                <form action="" method="GET" class="form">
                  <div class="box-body">
                    <?php 
                      // if(!empty($_GET['liderEstruct'])){
                      //   $liderEstruct = explode("-", $_GET['liderEstruct']);
                      //   $pedidoHijoActual = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_cliente = {$liderEstruct[0]} and pedidos.id_pedido = {$liderEstruct[1]}");
                      //   $pedidoHijoActual = $pedidoHijoActual[0];
                      // }
                    ?>
                    <div class="row">
                      <input type="hidden" value="<?=$_GET['campaing']?>" name="campaing">
                      <input type="hidden" value="<?=$_GET['n']?>" name="n">
                      <input type="hidden" value="<?=$_GET['y']?>" name="y">
                      <input type="hidden" value="<?=$_GET['dpid']?>" name="dpid">
                      <input type="hidden" value="<?=$_GET['dp']?>" name="dp">
                      <input type="hidden" value="<?=$_GET['route']?>" name="route">
                      <input type="hidden" value="<?=$_GET['id']?>" name="id">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="liderEstruct">Por Cierre de Lider</label><style type="text/css">.select2{z-index:990000"}</style>
                           <select class="form-control liderEstruct select2" id="liderEstruct"  name="liderEstruct" style="width:100%;z-index:990000">
                             <option></option>
                               <?php foreach ($estructuraLideres as $lid): ?>
                                 <?php if (!empty($lid['id_cliente'])): ?>
                                  <?php if(!empty($_GET['liderEstruct']) && $_GET['liderEstruct']==$lid['id_cliente']){ ?>
                                    <?php $pedidoHijoActual = $lid; ?>
                                  <?php } ?>
                                  <?php if($lid['cantidad_aprobado']>0){ ?>
                              <option <?php if(!empty($_GET['liderEstruct']) && $_GET['liderEstruct']==$lid['id_cliente']){ ?> selected <?php } ?> value="<?=$lid['id_cliente'];?>"><?php echo $lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']." - ".$lid['cantidad_acumulada']." cols."; ?></option>
                                  <?php } ?>
                              <!-- <option <?php if(!empty($liderEstruct) && $pedidoHijoActual['id_cliente']==$lid['id_cliente'] && $pedidoHijoActual['id_pedido']==$lid['id_pedido']){ ?> selected <?php } ?> value="<?=$lid['id_cliente']."-".$lid['id_pedido'];?>"><?php echo $lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']." - ".$lid['cantidad_aprobado']." cols."; if($countDespachos>1){ echo " Pedido ".$lid['numero_despacho']."-C".$_GET['n']."/".$_GET['y']; } ?></option> -->
                                 <?php endif ?>   
                               <?php endforeach ?>

                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php // print_r($liderazgosAll[5]); ?>
                    </div>
                  </div>
                    <button class="btn-enviar-modalDescuentoCierreEstructuraget d-none" disabled="" >enviar</button>
                </form>
                <?php //print_r($lidera); ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                <?php if (!empty($_GET['liderEstruct'])): ?>

                <?php //print_r($bonosEstructura); ?>
                <form action="" method="POST" class="form">
                    <input type="hidden" value="<?=$_GET['liderEstruct']?>" class="id_cliente" name="id_cliente">
                  
                    <div class="row">
                      <table class="text-center" style="width:90%;">
                        <thead>
                          <th>Niveles</th>
                          <th></th>
                          <th>Descuento</th>
                          <th></th>
                          <th>Colecciones</th>
                          <th></th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php foreach ($liderazgosAll as $col): if(!empty($col['id_liderazgo'])): if(($col['nombre_liderazgo']!="JUNIOR")&&($col['nombre_liderazgo']!="SENIOR")): if($col['id_liderazgo'] <= $lidera['id_liderazgo']): ?>
                            <tr>
                              <td style="width:50%">Nivel <?=$col['nombre_liderazgo']?></td>
                              <td style="width:3.3%"><input type="hidden" value="<?=$col['id_liderazgo']?>" name="id[]" readonly></td>
                              <td style="width:10%"><input type="number" class="form-control" id="descuentoDesc<?=$col['id_liderazgo']?>" value="<?=$col['descuento_coleccion']?>" readonly style='background:none;' name="descuentos[]"></td>
                              <td style="width:3.3%">x</td>
                              <td style="width:10%"><input type="number" <?php foreach ($bonosEstructura as $bono) {
                                if(!empty($bono['id_bonocierre'])){
                                  if($bono['id_liderazgo']==$col['id_liderazgo']){ ?>
                                    value="<?=$bono['colecciones_bono_cierre']?>"
                                  <?php }
                                }
                              } ?> placeholder="0" class="form-control valoresDesc" id="<?=$col['id_liderazgo']?>" max="<?=$pedidoHijoActual['cantidad_acumulada'];?>" step="1" name="valores[]"></td>
                              <!-- max="<?=$pedidoHijoActual['cantidad_aprobado'];?>" -->
                              <td style="width:3.3%">=</td>
                              <td style="width:15%"><input type="number" <?php foreach ($bonosEstructura as $bono) {
                                if(!empty($bono['id_bonocierre'])){
                                  if($bono['id_liderazgo']==$col['id_liderazgo']){?>
                                    value="<?=$bono['totales_bono_cierre']?>"
                                  <?php }
                                }
                              } ?> placeholder="0" class="form-control" step="1" id="totalDesc<?=$col['id_liderazgo']?>" name="totales[]" readonly style='background:none;'></td>
                            </tr>
                          <?php  endif; endif; endif; endforeach; ?>
                          <input type="hidden" class="id_pedido_modal" value="<?=$pedido['id_pedido']?>" name="id_pedido_modal">
                          <!-- <input type="hidden" class="tipo_bono" value="Cierre" name="tipo_bono"> -->
                        </tbody>
                      </table>
                    </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDescuentoCierreEstructura">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDescuentoCierreEstructura d-none" disabled="" >enviar</button>
                  </div>
                </form>
              <?php endif ?>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

    <?php if(!empty($_GET['liderTraspaso'])){ ?>
  <div class="box-modalTraspaso" style="background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
    <?php } else { ?>
  <div class="box-modalTraspaso" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
    <?php } ?>
      <div class="content">
        <div class="row">
          <?php
            $pedidosDisponibles = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.id_campana = {$id_campana}");
            $lideresActivas = $lider->consultarQuery("SELECT * FROM clientes, despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and despachos.id_campana = {$id_campana}");

          ?>
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalTraspaso" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Traspaso de Excendente </h3>
                  </div>
                <form action="" method="GET" class="form">
                  <div class="box-body">
                    <?php //print_r($lideres); ?>
                    <div class="row">
                      <input type="hidden" value="<?=$_GET['campaing']?>" name="campaing">
                      <input type="hidden" value="<?=$_GET['n']?>" name="n">
                      <input type="hidden" value="<?=$_GET['y']?>" name="y">
                      <input type="hidden" value="<?=$_GET['dpid']?>" name="dpid">
                      <input type="hidden" value="<?=$_GET['dp']?>" name="dp">
                      <input type="hidden" value="<?=$_GET['route']?>" name="route">
                      <input type="hidden" value="<?=$_GET['id']?>" name="id">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="liderTraspaso">Por Cierre de Lider</label><style type="text/css">.select2{z-index:990000"}</style>
                           <select class="form-control liderTraspaso select2" id="liderTraspaso"  name="liderTraspaso" style="width:100%;z-index:990000">
                             <option></option>
                               <?php 
                                foreach ($lideresActivas as $lid){
                                  if (!empty($lid['id_cliente'])){
                                    if($lid['cantidad_aprobado']>0){
                                      ?>
                              <option <?php if(!empty($_GET['liderTraspaso']) && $_GET['liderTraspaso']==$lid['id_pedido']){ ?> selected <?php } ?> value="<?=$lid['id_pedido']?>"><?=$lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']." (Pedido ".$lid['numero_despacho'].")"; ?></option>
                                      <?php
                                    }
                                  }
                                }
                               ?>

                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php // print_r($liderazgosAll[5]); ?>
                    </div>
                  </div>
                    <button class="btn-enviar-modalTraspasoget d-none" disabled="" >enviar</button>
                </form>
                <?php //print_r($lidera); ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                <?php if(!empty($_GET['liderTraspaso'])): ?>

                <form action="" method="POST" class="form">
                    <div class="row">
                      <table class="text-center" style="width:90%;">
                        <thead>
                          <th>Líder</th>
                          <th>Excedente</th>
                          <th>Concepto</th>
                          <th>Cantidad</th>
                        </thead>
                        <tbody>
                            <tr>
                              <td style="width:25%"><?=$liderEmisor['primer_nombre']." ".$liderEmisor['primer_apellido']?></td>
                              <?php if (count($traspasoEmitido)>1):
                                $traspasoEmitido1 = $traspasoEmitido[0];
                                if ($traspasoEmitido1['cantidad_traspaso'] != 0) {
                                  $restoDisponible += $traspasoEmitido1['cantidad_traspaso'];
                                }
                              endif; ?>
                              <td style="width:25%">$<?=number_format($restoDisponible,2,',','.');?></td>
                              <td style="width:25%">Traspasar</td>
                              <td style="width:25%">
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="number" max="<?=$restoDisponible?>" class="form-control cantidadTraspaso" min="0" <?php if (count($traspasoEmitido)>1): $traspasoEmitido2 = $traspasoEmitido[0]; if ($traspasoEmitido2['cantidad_traspaso']!="0") { ?> value="<?=$traspasoEmitido2['cantidad_traspaso'];?>" <?php }else{ ?> value='0.00' <?php } else: ?> value='0.00' <?php endif; ?> value='0.00' id="cantidadTraspaso" step="0.01" name="cantidadTraspaso">
                                    
                                </div>
                              </td>
                            </tr>

                          <input type="hidden" value="<?=$restoDisponible?>" class="restoDisponible" name="restoDisponible">
                          <input type="hidden" value="<?=$liderEmisor['id_cliente']?>" class="id_cliente_receptor" name="id_cliente_receptor">
                          <input type="hidden" value="<?=$liderEmisor['id_pedido']?>" class="id_pedido_receptor" name="id_pedido_receptor">
                          <input type="hidden" value="<?=$pedido['id_cliente']?>" class="id_cliente_emisor" name="id_cliente_emisor">
                          <input type="hidden" value="<?=$pedido['id_pedido']?>" class="id_pedido_emisor" name="id_pedido_emisor">

                        </tbody>
                      </table>
                    </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalTraspaso">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalTraspaso d-none" disabled="" >enviar</button>
                  </div>
                </form>
                <?php endif ?>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalExcedente" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalExcedente" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Pago de Excendente </h3>
                  </div>

           
                <div action="" method="POST" class="form">
                    <div class="row">
                      <div class="col-xs-12" style="padding:1% 5%;font-size:1.3em;">
                          Se va a realizar la devolución de excedentes a
                          <?php if($cliente['sexo']=="Femenino"){ ?> a la <?php } ?>
                          <?php if($cliente['sexo']=="Masculino"){ ?> al <?php } ?>
                          líder <?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?>
                          <br>
                          Por precio total de: 
                          <?php 
                            // $restopositivo = ($restaTotalResponsabilidad * (-1));
                            $restoDisponiblePositivo = number_format($restoDisponible,2,',','.');
                            // echo $restoDisponiblePositivo;
                          ?>

                          <b>$<?=$restoDisponiblePositivo;?></b>
                          <!-- <b>$<?=number_format($restopositivo,2,',','.');?></b> -->
                      </div>
                      <input type="hidden" class="id_pedido_excedente" value="<?=$_GET['id']; ?>">
                      <input type="hidden" class="cantidad_excedente_max" value="<?=$restoDisponible; ?>">
                      <div class="col-xs-12">
                        <div class="form-group">
                          <label for="cantidad_excedente" style="width:95%;min-width:95%;max-width:95%;margin-left:5%;">Monto: </label>
                          <input type="number" id="cantidad_excedente" class="form-control cantidad_excedente" min="0" max="<?=$restoDisponible; ?>" style="width:95%;min-width:95%;max-width:95%;margin:auto;" step="0.01" value="">
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <div class="form-group">
                          <label for="descripcion_excedente" style="width:95%;min-width:95%;max-width:95%;margin-left:5%;">Descripcion: </label>
                          <textarea id="descripcion_excedente" class="form-control descripcion_excedente" style="width:95%;min-width:95%;max-width:95%;margin:auto;height:5em;min-height:5em;max-height:5em;" maxlength="355"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="box-footer">
                      <span type="submit" class="btn enviar enviarModalExcedente">Enviar</span>
                      <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                      <button class="btn-enviar-modalExcedente d-none" disabled="" >enviar</button>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>  

  <div class="box-modalDescripcionExcedente" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDescripcionExcedente" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Descripcion del pago de Excendente </h3>
                  </div>

           
                <div action="" method="POST" class="form">
                    <div class="row">
                      <div class="col-xs-12" style="padding:1% 5%;font-size:1.3em;">
                          Se realizo el pago de excedentes
                          <?php if($cliente['sexo']=="Femenino"){ ?> a la <?php } ?>
                          <?php if($cliente['sexo']=="Masculino"){ ?> al <?php } ?>
                          lider <?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?>
                          <br>
                          Por precio total de: 
                          <?php 
                            // $restopositivo = ($restaTotalResponsabilidad * (-1));
                            $excedenteDisponiblePositivo = number_format($cantidad_excedente,2,',','.');
                            // echo $excedenteDisponiblePositivo;
                          ?>

                          <b>$<?=$excedenteDisponiblePositivo;?></b>
                        <div class="form-group">
                            <small><i>Detalle: </i></small>
                          <div class="" style="border:1px solid #DDD;padding:1%;font-size:.9em;">
                            <b>
                              <span class="contenido2">
                                <?php
                                  $limiteCantidadIntento = count($excedente_cantidad);
                                  $intentosCantidad = 0;
                                  foreach ($excedente_cantidad as $excantidad) {
                                    if(!empty($excantidad['id'])){
                                      foreach ($excedente_descripcion as $exdescripcion) {
                                        if(!empty($exdescripcion['id'])){
                                          if($excantidad['id']==$exdescripcion['id']){
                                            $intentosCantidad++;
                                            $excantidadCantidad = number_format($excantidad['cantidad'],2,',','.');
                                            echo "Monto: $".$excantidadCantidad."<br>";
                                            echo "Descripción: ".$exdescripcion['descripcion']."<br>";
                                            if($intentosCantidad < $limiteCantidadIntento){
                                              echo "<div style='background:#CCC; width:102%; height:1px; padding:-1%; margin:1% -1%; '></div>";
                                            }
                                          }
                                        }
                                      }
                                    }
                                  }
                                ?>
                              </span>
                            </b>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="box-footer">
                      <!-- <span type="submit" class="btn enviar enviarModalDescripcionExcedente">Enviar</span> -->
                      <!-- <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>"> -->
                      <!-- <button class="btn-enviar-modalExcedente d-none" disabled="" >enviar</button> -->
                    </div>
                </div>

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

<!-- jQuery 3 -->
  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response; ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">

<?php if (!empty($responseGema)): ?>
<input type="hidden" class="responseGema" value="<?php echo $responseGema; ?>">
<input type="hidden" class="gemasdisponibles" value="<?=$gemasAdquiridasDisponiblesCliente;?>">
<input type="hidden" class="gemasbloqueadas" value="<?=$gemasAdquiridasBloqueadasCliente;?>">
<?php endif; ?>

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
  $(".descontarGemasModal").click(function(){
    $(".box-modalDescuentoGemas").fadeIn(500);
  });
  $(".cerrarModalDescuentoGemas").click(function(){
    $(".box-modalDescuentoGemas").fadeOut(500);
  });

  $(".valoresLiquidacion").keyup(function(){
    // var id = $(this).attr("id");
    var max = $(this).attr("max");
    var val = parseFloat($(this).val());
    if(val > max){ $(this).val(max); }
    var val = parseFloat($(this).val());
    var precio = parseFloat($("#precioGema").val());
    var total = precio*val;
    $("#totalesLiquidacion").val(total);
  });

  $(".enviarModalLiquidacionGemas").click(function(){
    $(".btn-enviar-modalLiquidacionGemas").removeAttr("disabled","0");
    $(".btn-enviar-modalLiquidacionGemas").click();
  });





  $(".modalDescripcionExcedente").click(function(){
    $(".box-modalDescripcionExcedente").fadeIn(500);
  });
  $(".cerrarModalDescripcionExcedente").click(function(){
    $(".box-modalDescripcionExcedente").fadeOut(500);
  });


  $(".reclamarGemasPorcentajeBtn").click(function(){
    var cantidadGemas = $("#cantidad_gemas_lider_porcent").val();
    var porcentajeGemas = $("#porcentaje_gemas_lider").val();
     swal.fire({ 
          title: "¿Desea reclamar sus gemas? <br> Puede reclamar "+porcentajeGemas+" de sus "+cantidadGemas+" gemas?",
          text: "Sus gemas reclamadas pasarán a estar disponibles. ¿Desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Reclamar Gemas!",
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
  $(".reclamarGemasBtn").click(function(){
    var cantidadGemas = $("#cantidad_gemas_lider").val();
     swal.fire({ 
          title: "¿Desea reclamar sus "+cantidadGemas+" gemas?",
          text: "Sus gemas reclamadas pasarán a estar disponibles. ¿Desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Reclamar Gemas!",
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

  $(".liderEstruct").change(function(){
    $(".btn-enviar-modalDescuentoCierreEstructuraget").removeAttr("disabled","0");
    $(".btn-enviar-modalDescuentoCierreEstructuraget").click();
  });

  $(".liderTraspaso").change(function(){
    $(".btn-enviar-modalTraspasoget").removeAttr("disabled","0");
    $(".btn-enviar-modalTraspasoget").click();
  });

  $(".btncerrarExcedente").click(function(){
    $(".box-modalExcedente").fadeIn(500);
  });
  $(".cerrarModalExcedente").click(function(){
    $(".box-modalExcedente").fadeOut(500);
  });
  $(".cantidad_excedente").on("input", function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(".cantidad_excedente_max").val());
    if(val > max){
      $(this).val(max);
    }
    if(val < 0){
      $(this).val(0);
    }
  });
  $(".enviarModalExcedente").click(function(){
    var id = $(".id_pedido_excedente").val();
    var cantidad = $(".cantidad_excedente").val();
    var description = $(".descripcion_excedente").val();
    // alert(id);
    cantidad = parseFloat(cantidad)
    // alert(cantidad);  

    swal.fire({ 
      title: "¿Desea guardar la cantidad ("+cantidad+") como excedente pagado?<br>¿Desea continuar?",
      text: "Se guardaran estos cambios y se actualizará el excedente por pagar.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Confirmar!",
      cancelButtonText: "Cancelar", 
      closeOnConfirm: false,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        // $(".btn-enviar").removeAttr("disabled");
        // $(".btn-enviar").click();
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              cerrarExcedenteLider: true,
              cantidad_excedente: cantidad,
              descripcion_excedente: description,
            },
            success: function(respuesta){
              // alert(respuesta);
              if (respuesta == "1"){
                swal.fire({
                    type: 'success',
                    title: '¡Excedente pagado correctamente!',
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
              if (respuesta == "2"){
                swal.fire({
                    type: 'error',
                    title: '¡No se pudo guardar el cambio!',
                    text: 'Vuelva a intentar, si el error persiste comuniquese con el soporte',
                    confirmButtonColor: "#ED2A77",
                });
              }
              if (respuesta == "9"){
                swal.fire({
                    type: 'warning',
                    title: '¡El excedente ya fue pagado!',
                    text: 'Ya existe un excedente aplicado a esta factura',
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

  $(".cerrarDetalleModalCierre").click(function(){
    $(".box-modalDetalleCierre").fadeOut(500);
  });

  $(".detallarModalCierre").click(function(){
    $(".box-modalDetalleCierre").fadeIn(500);
  });

  $(".asignarDescuentoContado").click(function(){
    $(".box-modalDescuentoContado").fadeIn(500);
  });
  $(".cerrarModalDescuentoContado").click(function(){
    <?php if(!empty($_GET['liderEstruct'])){ ?>
      var url  = "?campaing=<?=$_GET['campaing']?>&n=<?=$_GET['n']?>&y=<?=$_GET['y']?>&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=<?=$_GET['route']?>&id=<?=$_GET['id']?>";
      location.href = url;
    <?php } else { ?>
      $(".box-modalDescuentoContado").fadeOut(500);
    <?php } ?>
  });
  $(".enviarModalDescuentoContado").click(function(){
    $(".btn-enviar-modalDescuentoContado").removeAttr("disabled","0");
    $(".btn-enviar-modalDescuentoContado").click();
  });
  $(".valoresContado").keyup(function(){
    // var id = $(this).attr("id");
    var max = $(this).attr("max");
    var val = parseFloat($(this).val());
    if(val > max){ $(this).val(max); }
    var val = parseFloat($(this).val());
    var descuento = parseFloat($("#descuentoContado").val());
    var total = val*descuento;
    $("#totalContado").val(total);
  });


  $(".modalTraspasar").click(function(){
    $(".box-modalTraspaso").fadeIn(500);
  });
  $(".cerrarModalTraspaso").click(function(){
    <?php if(!empty($_GET['liderTraspaso'])){ ?>
      var url  = "?campaing=<?=$_GET['campaing']?>&n=<?=$_GET['n']?>&y=<?=$_GET['y']?>&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=<?=$_GET['route']?>&id=<?=$_GET['id']?>";
      location.href = url;
    <?php } else { ?>
      $(".box-modalTraspaso").fadeOut(500);
    <?php } ?>
  });
  $(".enviarModalTraspaso").click(function(){
    $(".btn-enviar-modalTraspaso").removeAttr("disabled","0");
    $(".btn-enviar-modalTraspaso").click();
  });
  $(".cantidadTraspaso").focusin(function(){
    var val = parseFloat($(this).val());
    if(val==0){
      $(this).val("");
    }
  });
  $(".cantidadTraspaso").keyup(function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(".restoDisponible").val());
    // alert(val);
    // alert(max);
    if(val > max){
      $(this).val(max);
    }else if(val < 0){
      $(this).val(0);
    }
  });
  $(".cantidadTraspaso").focusout(function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(".restoDisponible").val());
    if(val > max){
      $(this).val(max);
    }else if(val < 0){
      $(this).val(0);
    }
  });


  $(".asignarDescuentoCierreEstructura").click(function(){
    $(".box-modalDescuentoCierreEstructura").fadeIn(500);
  });
  $(".cerrarModalDescuentoCierreEstructura").click(function(){
    <?php if(!empty($_GET['liderEstruct'])){ ?>
      var url  = "?campaing=<?=$_GET['campaing']?>&n=<?=$_GET['n']?>&y=<?=$_GET['y']?>&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=<?=$_GET['route']?>&id=<?=$_GET['id']?>";
      location.href = url;
    <?php } else { ?>
      $(".box-modalDescuentoCierreEstructura").fadeOut(500);
    <?php } ?>
  });
  $(".enviarModalDescuentoCierreEstructura").click(function(){
    $(".btn-enviar-modalDescuentoCierreEstructura").removeAttr("disabled","0");
    $(".btn-enviar-modalDescuentoCierreEstructura").click();
  });
  $(".valoresDesc").keyup(function(){
    var id = $(this).attr("id");
    var max = $(this).attr("max");
    // alert(id);
    // alert(max);
    var val = parseFloat($(this).val());
    // alert(max);
    // alert(id);
    if(val > max){ $(this).val(max); }
    if(val < 0){ $(this).val(0); }
    var val = parseFloat($(this).val());
    // alert(val);
    var descuento = parseFloat($("#descuentoDesc"+id).val());
    var total = val*descuento;
    $("#totalDesc"+id).val(total);
  });
  

  $(".valores").keyup(function(){
    var id = $(this).attr("id");
    var max = $(this).attr("max");
    var val = parseFloat($(this).val());
    if(val > max){ $(this).val(max); }
    var val = parseFloat($(this).val());
    var descuento = parseFloat($("#descuento"+id).val());
    var total = val*descuento;
    $("#total"+id).val(total);
  });

  
  $(".asignarBonosPagosPuntuales").click(function(){
    $(".box-modalBonoPagosPuntuales").fadeIn(500);
  });
  $(".cerrarModalBonoPagosPuntuales").click(function(){
    $(".box-modalBonoPagosPuntuales").fadeOut(500);
  });
  $(".enviarModalBonoPagosPuntuales").click(function(){
    $(".btn-enviar-modalBonoPagosPuntuales").removeAttr("disabled","0");
    $(".btn-enviar-modalBonoPagosPuntuales").click();
  });
  
  $("#cantidad").change(function(){
    var x = parseInt($(this).val());
    $(this).val(x);
  });
  $("#cantidad").focusout(function(){
    var x = parseInt($(this).val());
    $(this).val(x);
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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         cantidad: $("#cantidad").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
              //             $(".btn-enviar").removeAttr("disabled");
              //             $(".btn-enviar").click();
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡No se pudo aprobar el pedido!',
              //               text: 'Debe numerar una cantidad posible para la aprobacion',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //       }
              //   });
              
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
  var cantidad = $("#cantidad").val();
  var max = parseInt($(".maxOculto").val());

  var rcantidad = false;
  if(cantidad.length == 0){
    $("#error_cantidad").html("Debe llenar una cantidad de colecciones");
    rcantidad = false;
  }else{
    if(cantidad <= max){
      $("#error_cantidad").html("");
      rcantidad = true;
    }else{
      $("#error_cantidad").html("Debe seleccionar maximo "+max+" colecciones");
      rcantidad = false;
    }

  }

  /*===================================================================*/
  var result = false;

  if( rcantidad==true){
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
