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
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> <?=$modulo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
            <?php if($accesoPagosR){ ?>
              <?php if ( (!$personalAdmin && $facturaPedidoAp>0) || ($personalAdmin) ){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$url?></a></div>
              <?php } ?>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      <?php 
        $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
        // $ciclo['pago_inicio'] = "2023-08-28";
        // $pagosT['abonado'] = 33.11;
        // echo $fechaActual."<br>";
        // echo $ciclo['pago_inicio']."<br>";
        // echo $pagosT['abonado']."<br>"; 
        // echo $pedido['precio_cuotas']."<br>";
        $operar = 0;
        if($personalExterno){
          if($fechaActual<=$ciclo['pago_inicio']){
            $operar=1;
          }else{
            if($pagosT['abonado']>=$pedido['precio_cuotas']){
              $operar=1;
            }else{
              $operar=0;
            }
          }
        }else{
          $operar=1;
        }
        if ($_SESSION['home']['nombre_rol']=="Administrador" || $_SESSION['home']['nombre_rol']=="Superusuario"){
          $estado_ciclo = "1";
        }
      ?>
      <?php
        // $menUU = $menu."&route=".$_GET['route'];
        // if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
        //   $menUU .= "&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
        // }
        // if(!empty($_GET['Banco'])){
        //   $menUU .= "&Banco=".$_GET['Banco'];
        // }
        // if(!empty($_GET['admin'])){
        //   $menUU .= "&admin=".$_GET['admin'];
        // }
        // if(!empty($_GET['lider'])){
        //   $menUU .= "&lider=".$_GET['lider'];
        // }

        // echo $menUU;
        // echo "<br><br>";
        // print_r($pagosRecorridos);
        // echo "<br><br>";
        // print_r($promociones);
      ?>

      <!-- <div style="background:;position:fixed;top:15%;right:0;z-index:500;background:<?=$fucsia; ?>;padding:3px 2px;border-radius:5px;max-height:45vh;overflow:auto;">
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
      </div> -->

      <div class="row">
        

        <div class="col-xs-12">
          <div class="box"> 
            <?php
              if($estado_ciclo=="1"){
                if ($accesoPagosR=="1"){
                  if($operar==1){
                    if ( (!$personalAdmin && $facturaPedidoAp>0) || ($personalAdmin) ){
                    ?>
                  <a href="?<?=$menu?>&route=Pagos&action=Registrar" style="position:fixed;bottom:7%;right:2%;z-index:300;" class="btn enviar2"><span class="fa fa-arrow-up"></span> <span class="hidden-xs hidden-sm"><u>Registrar Pagos</u></span></a>
                    <?php 
                    }
                  }
                }
              }
            ?>

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url; ?>"><?php echo "".$modulo; ?></a></h3>
              
              <?php if($personalInterno){ ?>
                <?php //if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                  <br><br>
                  <div class="row">
                    <form action="" method="get">
                      <input type="hidden" name="c" value="<?=$_GET['c'];?>" >
                      <input type="hidden" name="n" value="<?=$_GET['n'];?>" >
                      <input type="hidden" name="y" value="<?=$_GET['y'];?>" >
                      <input type="hidden" name="route" value="<?=$_GET['route'];?>" >
                      <?php if(!empty($_GET['filtrar'])){ ?>
                      <input type="hidden" value="<?=$_GET['filtrar']?>" name="filtrar">
                      <?php } ?>
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
                  <!-- <div class="row">
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

                  <!-- <style>
                    .text-xs { text-align:right; }
                    @media (max-width: 768px) {
                      .text-xs { text-align:right !important;}
                    }
                  </style> -->
                  <!-- <div class="row">
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
                  </div> -->
                    
                  

                  <div class="row">
                    <form action="" method="GET" class="form_select_lider">
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="lider">Seleccione al Lider</label>
                        <input type="hidden" name="c" value="<?=$_GET['c'];?>" >
                        <input type="hidden" name="n" value="<?=$_GET['n'];?>" >
                        <input type="hidden" name="y" value="<?=$_GET['y'];?>" >
                        <input type="hidden" name="route" value="<?=$_GET['route'];?>">
                        <?php if(!empty($_GET['filtrar'])){ ?>
                        <input type="hidden" value="<?=$_GET['filtrar']?>" name="filtrar">
                        <?php } ?>
                        <input type="hidden" value="1" name="admin">
                        <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                          <option></option>
                          <?php 
                            foreach ($lideres as $data){ if (!empty($data['id_cliente'])){
                              $permitido = "0";
                              if(!empty($accesosEstructuras)){
                                if(count($accesosEstructuras)>1){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$lid['id_cliente']){
                                        $permitido = 1;
                                      }
                                    }
                                  }
                                }else if($personalInterno){
                                  $permitido = 1;
                                }
                              }

                              if($permitido=="1"){
                                ?>
                                <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                <?php
                              }
                            } }
                          ?>
                        </select>
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
                      </div>
                    </form>

                    <form action="" method="GET" class="form_select_banco">
                      <div class="form-group col-xs-12 col-sm-6">
                        <label for="banco">Seleccione al banco</label>
                        <input type="hidden" name="c" value="<?=$_GET['c'];?>" >
                        <input type="hidden" name="n" value="<?=$_GET['n'];?>" >
                        <input type="hidden" name="y" value="<?=$_GET['y'];?>" >
                        <input type="hidden" name="route" value="<?=$_GET['route'];?>" >
                        <?php if(!empty($_GET['filtrar'])){ ?>
                        <input type="hidden" value="<?=$_GET['filtrar']?>" name="filtrar">
                        <?php } ?>
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
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>
                      </div>
                    </form>
                  </div>
                <?php //} ?>
              <?php } ?>
              <?php if( ($personalInterno && !empty($_GET['lider'])) || ($personalExterno) ){ ?>
                <?php if ( (!$personalAdmin && $facturaPedidoAp>0) || ($personalAdmin) ){ ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="container">
                          <br>
                          <a class="" href="?<?=$menu."&route=Estados&id=".$pedido['id_pedido']; ?>" style='font-size:1.1em;'><b><u>Ir al estado de cuentas</u></b></a>
                          <br>
                        </div>
                      </div>
                    </div>
                <?php } ?>
              <?php } ?>
            </div>


            <?php  
              $ruta = "Pagos";
              $aux="";
              if(!empty($_GET['filtrar'])){
                $aux .= "&filtrar=".$_GET['filtrar'];
              }
              if(!empty($_GET['admin'])){
                $aux .= "&admin=1";
              }
              if(!empty($_GET['lider'])){
                $aux .= "&lider=".$_GET['lider'];
              }
              if(!empty($_GET['rangoI'])){
                $aux .= "&rangoI=".$_GET['rangoI'];
              }
              if(!empty($_GET['rangoF'])){
                $aux .= "&rangoF=".$_GET['rangoF'];
              }
              if(!empty($_GET['Banco'])){
                $aux .= "&Banco=".$_GET['Banco'];
              }
              $ruta.=$aux;
              // echo $ruta."<br>";
              // echo $aux."<br>";
            ?>

            <div class="box-body">
              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado</b>
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
                  $precioCuotas = 0;
                  if( ($personalInterno && !empty($_GET['lider'])) || ($personalExterno) ){
                    if(!empty($pedido)){
                      $aprobado = $pedido['cantidad_aprobada'];
                      $cantidadCiclos = $ciclo['cantidad_cuotas'];
                      $precioCuotas = $aprobado/$cantidadCiclos;
                      // echo "<br><br>";
                      // print_r($pagosCiclos);
                      // echo "<br><br>";
                      // print_r($ciclo);
                      // echo "<br><br>";
                      // echo $precioCuotas;
                      // echo "<br><br>";
                    }
                  }
                ?>
                <?php if( ($personalInterno && !empty($_GET['lider'])) || ($personalExterno) ){ ?>
                  <div class="alert" style="background:#DDDDDD;border:1px solid #CCCCCC;font-size:1.1em">Abonar por cada cuota <?="$".number_format($precioCuotas,2,',','.'); ?></div>
                <?php } ?>
                <h3 class="box-title">
                  <?php echo "Abonos de Ciclo ".$num_ciclo."/".$ano_ciclo; ?>
                  <?php if(!empty($_GET['Diferido'])){ echo "(Diferidos)"; } ?> 
                  <?php if(!empty($_GET['Abonado'])){ echo "(Abonados)"; } ?> 
                </h3>
                <br>
              </div>
              <div class="box" style="border-top:none;display:;">
                <div class="box-body table-responsive">
                  <table id="datatable1" class="table table-bordered table-striped" style="text-align:center;min-width:100%;max-width:100%;">
                    <thead>
                      <tr>
                        <?php if($accesoPagosDetallesC){ ?>
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
                        <?php if($accesoPagosDetallesM){ ?>
                        <th>---</th>
                        <?php } ?>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        $num = 1;
                        $equivalenteGeneral = 0;
                        $totalEquivalente = 0;
                        $totalEquivalenteAb = 0;
                        $totalEquivalenteDf = 0;
                        $totalMonto = 0;
                                      $nMostrar = 0;

                        foreach ($pagos as $data){ if(!empty($data['id_pago'])){
                          $permitido = "0";
                          if(!empty($accesosEstructuras)){
                            if(count($accesosEstructuras)>1){
                              foreach ($accesosEstructuras as $struct) {
                                if(!empty($struct['id_cliente'])){
                                  if($struct['id_cliente']==$lid['id_cliente']){
                                    $permitido = 1;
                                  }
                                }
                              }
                            }else if($personalInterno){
                              $permitido = 1;
                            }
                          }
                          if($personalExterno){
                            if($data['id_cliente']==$id_cliente){
                              $permitido = 1;
                            }
                          }
                          if($permitido=="1"){ ?>
                            <?php
                              $bgTablePago = "";
                              $totalEquivalente += $data['equivalente_pago'];
                              $totalMonto += $data['monto_pago'];
                              if($data['estado']=="Abonado"){ 
                                $totalEquivalenteAb += $data['equivalente_pago'];
                                $bgTablePago="#00D20088"; 
                              }
                              else if($data['estado']=="Diferido"){ 
                                $totalEquivalenteDf += $data['equivalente_pago'];
                                $bgTablePago="#D2000088"; 
                              }
                            ?>
                            <tr class='elementos_tr_<?=$data['id_pago']; ?> tr<?=$data['id_pago']?>' style="background:<?=$bgTablePago; ?>;">
                              <?php if($accesoPagosDetallesC): ?>
                              <td style="width:10%">
                                <?php
                                  $pModificar = false;
                                  $pEliminar = false;
                                  $autorizado=false;
                                  $urlModif = "";
                                  if(
                                    $data['forma_pago'][0]=="A" &&
                                    $data['forma_pago'][1]=="u" &&
                                    $data['forma_pago'][2]=="t" &&
                                    $data['forma_pago'][3]=="o" &&
                                    $data['forma_pago'][4]=="r" &&
                                    $data['forma_pago'][5]=="i" &&
                                    $data['forma_pago'][6]=="z" &&
                                    $data['forma_pago'][7]=="a" &&
                                    $data['forma_pago'][8]=="d" &&
                                    $data['forma_pago'][9]=="o"
                                  ){
                                    $autorizado=true;
                                    $urlModif = "ModificarAutorizados";
                                    if($accesoPagosAutorizadosM){ $pModificar=$accesoPagosAutorizadosM; }
                                    if($accesoPagosAutorizadosE){ $pEliminar=$accesoPagosAutorizadosE; }
                                  }else{
                                    $autorizado=false;
                                    $urlModif = "Modificar";
                                    if(($data['forma_pago']=="Divisas Dolares" || $data['forma_pago']=="Efectivo Bolivares" || $data['forma_pago']=="Divisas Euros")){
                                      // DIVISASS 
                                        if($data['estado']!="Abonado"){
                                          if($fechaActual==$data['fecha_registro']){
                                            if($accesoPagosM){ $pModificar=$accesoPagosM; }
                                            if($accesoPagosE){ $pEliminar=$accesoPagosE; }
                                          }
                                        }else{
                                          if($accesoPagosAdminM){ $pModificar=$accesoPagosAdminM; }
                                          if($accesoPagosAdminE){ $pEliminar=$accesoPagosAdminE; } 
                                          if($accesoPagosAdminC){
                                            if($accesoPagosM){ $pModificar=$accesoPagosM; }
                                            if($accesoPagosE){ $pEliminar=$accesoPagosE; }
                                          }
                                        }
                                      // DIVISASS 
                                    } else{
                                      // PAGOS EN GENERAL DE BANCOS
                                        if($data['estado']!="Abonado"){
                                          if($fechaActual==$data['fecha_registro']){
                                            if($accesoPagosM){ $pModificar=$accesoPagosM; }
                                            if($accesoPagosE){ $pEliminar=$accesoPagosE; }
                                          }
                                        }else{
                                          if($accesoPagosAdminM || $accesoPagosAdminE){
                                            if($accesoPagosAdminM){ $pModificar=$accesoPagosAdminM; }
                                            if($accesoPagosAdminE){ $pEliminar=$accesoPagosAdminE; } 
                                          }
                                        }
                                      // PAGOS EN GENERAL DE BANCOS
                                    }
                                  }
                                ?>
                                <?php if ($operar==1){ ?>
                                  <?php if($pModificar){ ?>
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu; ?>&route=<?=$url;?>&action=<?=$urlModif; ?>&id=<?=$data['id_pago']; ?><?=$aux?>">
                                      <span class="fa fa-wrench"></span>
                                    </button>
                                  <?php } ?>
                                <?php } ?>
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php if ($operar==1){ ?>
                                  <?php if($pEliminar){ ?>
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu; ?>&route=<?=$url;?>&id=<?=$data['id_pago']; ?>&permission=1<?=$aux?>">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php } ?>
                                <?php } ?>
                              </td>
                              <?php endif ?>
                              <td style="width:5%">
                                <span class="contenido2">
                                  <?php echo $num++; ?>
                                </span>
                              </td>
                              <td style="width:10%" class='td_fechas' value="<?=$data['id_pago']?>">
                                <?php
                                  $temporalidad = "";
                                  $nCuota = "";
                                  $cuotasNumber = [];
                                  if( ($personalInterno && !empty($_GET['lider'])) || ($personalExterno) ){
                                    if(!empty($pedido)){
                                      if($data['estado']=="Abonado"){
                                        $equivalenteGeneral+=$data['equivalente_pago'];
                                      }
                                      $i=0;
                                      $pagarLimite = 0;
                                      $coutasxD = [];
                                      
                                      $cuotasPrecioPagos = $equivalenteGeneral;
                                      foreach ($pagosCiclos as $keys){ if(!empty($keys['id_pago_ciclo'])){
                                        $pagarLimite = (($i+1)*$precioCuotas);
                                        $nCuotax = substr($keys['numero_cuota'], 0, strpos($keys['numero_cuota']," "));
                                        $coutasxD = $keys;
                                        if(mb_strtolower($nCuotax)=="inicial"){
                                          $nCuotax = "Cuota ".$nCuotax;
                                        }else{
                                          $nCuotax = $keys['numero_cuota'];
                                        }
                                        // echo $nCuotax."<br>";
                                        // $nCuota .= $nCuotax."<br>";
                                        // $number=1;
                                        // $porcentNumber = 0;
                                        
                                        // echo $cuotasPrecioPagos." | ";
                                        // echo $nCuotax." | ";
                                        $porcentCuotaPago = 0;
                                        if($cuotasPrecioPagos >= $precioCuotas){
                                          $cuotasPrecioPagos -= $precioCuotas;
                                          $porcentCuotaPago = (float) number_format(100,2);
                                        }else{
                                          $porcentCuotaPago = (float) number_format($cuotasPrecioPagos*100/$precioCuotas,2);
                                        }
                                        // echo $porcentCuotaPago."% | ";
                                        // echo "<br><br>";
                                        if(!empty($cuotasNumber[$keys['numero_cuota']])){
                                          unset($cuotasNumber[$keys['numero_cuota']]);
                                          // $cuotasNumber[$keys['numero_cuota']]['porcent']+=$porcentCuotaPago;
                                          // $cuotasNumber[$keys['numero_cuota']]['name']=$nCuotax;
                                        }else{
                                          $cuotasNumber[$keys['numero_cuota']]['name']=$nCuotax;
                                          $cuotasNumber[$keys['numero_cuota']]['porcent']=$porcentCuotaPago;
                                        }



                                        if($equivalenteGeneral <= $pagarLimite){
                                          break;
                                        }
                                        // echo $nCuota;
                                        $i++;
                                      } }
                                      $nCuota = $nCuotax;
                                      // echo $data['equivalente_pago']."<br>";
                                      // echo $precioCuotas."<br>";
                                      // print_r($cuotasNumber);

                                      $restriccion = $coutasxD['fecha_pago_cuota'];
                                      if($data['fecha_pago']<=$coutasxD['fecha_pago_cuota']){
                                        $temporalidad = "Puntual";
                                      }else{
                                        $temporalidad = "Impuntual";
                                      }

                                      // if($fechaActual<=$restriccion){
                                      //   // echo "asd";
                                      // }
                                      // echo $data['fecha_pago']."<br>";
                                      // echo $restriccion."<br>";
                                      // echo "<br>";
                                      // echo $fechaActual;
                                      // echo "<br>";
                                      // print_r($coutasxD['fecha_pago_cuota']);
                                      // echo "<br>";
                                      // echo $nCuota."<br>";
                                    }
                                  }
                                ?>
                                <span class="contenido2">
                                  <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                                  <br>
                                  <?php
                                    // if(ucwords(mb_strtolower($data['tipo_pago']))==$pagosR['name']){
                                    //   $restriccion = $pagosR['fecha_pago'];
                                    // }
                                    // $temporalidad = "";
                                    // if($data['fecha_pago'] <= $restriccion){
                                    //   $temporalidad = "Puntual";
                                    //   if($data['estado']=="Abonado"){
                                    //     $abonadosPagosPuntuales[$pagosR['id']] += $data['equivalente_pago'];
                                    //   }
                                    // }else{
                                    //   $temporalidad = "Impuntual";
                                    // }
                                  ?>
                                  <small class='contenido_temporalidad'><?=$temporalidad; ?></small>
                                </span>
                              </td>
                              <td style="width:10%" class="td_forma_de_pago">
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
                              <td style="width:10%;" class="td_bancos">
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
                              <td style="width:10%" class="td_referencias">
                                <span class="contenido2">
                                  <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                                </span>
                              </td>
                              <td style="width:10%" class="td_monto">
                                <span class="contenido2">
                                  <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                                </span>
                              </td>
                              <td style="width:10%">
                                <span class="contenido2">
                                  <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],4,',','.'); }else{ echo ""; } ?></span>
                                </span>
                              </td>
                              <td style="width:8%" class="td_equivalente">
                                <span class="contenido2">
                                  <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                                </span>
                              </td>
                              <td style="width:25%">

                                <span class="contenido2">
                                  <span class='contenido_tipo_pago'>
                                    <?php 
                                      $nIndexOp = 0;
                                      // echo $nCuota;
                                      // echo count($cuotasNumber);
                                      foreach ($cuotasNumber as $key){
                                        if($nIndexOp>=$nMostrar){
                                          echo "".$key['name']." (".$key['porcent']."%)";
                                          echo "<br>";
                                          if($key['porcent']==100){
                                            $nMostrar++;
                                          }
                                        }
                                        $nIndexOp++;
                                      } 
                                    ?>
                                  </span>
                                </span>
                              </td>
                              <?php if($accesoPagosDetallesM){ ?>
                              <td style="width:5%">
                                <?php
                                  $btnEditar = false;
                                  $btnConciliarM = false;
                                  $btnConciliarE = false;
                                  if($accesoPagosDetallesR){
                                    $btnEditar = true;
                                  }
                                  if($autorizado==false){
                                    if($data['estado']!="Abonado"){
                                      if($accesoPagosConciliarM){ $btnConciliarM = $accesoPagosConciliarM; }
                                      if($accesoPagosConciliarE){ $btnConciliarE = $accesoPagosConciliarE; }
                                    }
                                  }
                                ?>
                                <?php if($btnEditar){ ?>
                                  <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                    <span class="fa fa-pencil"></span>
                                  </button>
                                <?php } ?>
                                <?php if($btnConciliarM){ ?>
                                  <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                    <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                  </button>
                                <?php } ?>
                                <?php if($btnConciliarE){ ?>
                                  <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                    <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                  </button>
                                <?php } ?>
                              </td>
                              <?php } ?>
                            </tr>
                          <?php } ?> 
                        <?php } }
                      ?>
                    </tbody>

                    <tfoot>
                      <!-- <tr >
                        <?php if($accesoPagosDetallesC){ ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php } ?>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <?php if($accesoPagosDetallesM){ ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php } ?>
                      </tr> -->
                      <tr style="background:#CCC;">
                        <?php if($accesoPagosDetallesC){ ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php } ?>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'>
                          <!-- <h5><b>Premios<br><?php //=$pagosR['name']; ?>:</b></h5> -->
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                            // if($pagosR['name']=="Contado"){
                            //   $precio = $despacho['precio_coleccion'] - $pagosR['precio'];
                            // }else{
                            //   $precio = $pagosR['precio'];
                            // }
                            // $premiosAbonadoInn = 0;
                            // if( $abonadosPagos[$pagosR['id']] != 0){
                            //   $totalesPagos[$pagosR['id']] = $abonadosPagosPuntuales[$pagosR['id']] / $precio;
                            //   if($opcionOpcionalInicial=="Y"){
                            //     if(!empty($abonadosPagos['inicial'])){
                            //       $premiosAbonadoInn = $abonadosPagos['inicial'] / $precio;
                            //     }
                            //   }
                            // }else{
                            //   $totalesPagos[$pagosR['id']] = 0;
                            // }

                            // echo number_format($totalesPagos[$pagosR['id']],2,',','.');
                            // // print_r($abonadosPagosPuntuales);
                            // if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                            //   if(!empty($_GET['lider'])){
                            //     if(empty($acumuladosTotales[$pagosR['id']])){
                            //       if($opcionOpcionalInicial=="Y"){
                            //         echo "<br>"; 
                            //         echo " + ";
                            //         echo number_format($premiosAbonadoInn,2,',','.');
                            //         $totalesPagos[$pagosR['id']] += $premiosAbonadoInn;
                            //         echo "<br>"; 
                            //         echo " = ";
                            //         echo number_format($totalesPagos[$pagosR['id']],2,',','.'); 
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
                        <th style='padding:0;margin:0;'>
                          <h4><b>$<?=number_format($totalMonto,2, ",","."); ?></b></h4>
                        </th>
                        <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                            <span>$<?=number_format($totalEquivalente,2, ",","."); ?></span><br>
                            <span style="color:#D50000CC;">$<?=number_format($totalEquivalenteDf,2, ",","."); ?></span><br>
                            <span style="color:#00E500;">$<?=number_format($totalEquivalenteAb,2, ",","."); ?></span><br>
                          </b></h4>
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                              foreach ($cuotasNumber as $key){
                                echo "<small style='color:#000;'>".$key['name']." (".$key['porcent']."%)</small>";
                                echo "<br>";
                              } 

                            // if($pagosR['name']!="Contado" && $pagosR['name']!="Inicial"){
                            //   if(!empty($_GET['lider'])){
                            //     if(!empty($acumuladosTotales[$pagosR['id']])){
                            //       if($acumuladosTotales[$pagosR['id']] != 0){
                            //         $porcentajeDePago[$pagosR['id']] = ($abonadosPagos[$pagosR['id']] * 100) / $totalesPagosPagar[$pagosR['id']];
                            //       }else{
                            //         $porcentajeDePago[$pagosR['id']] = 0;
                            //       }
                            //       echo number_format($porcentajeDePago[$pagosR['id']],2,',','.')."%";
                            //     }else{

                            //       if($nuevoTotal!=0){
                            //         $porcentajeRestanteFinal = ($abonado*100)/$nuevoTotal;
                            //       }else{
                            //         $porcentajeRestanteFinal = 0;
                            //       }
                            //       echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                            //     }
                            //   }
                            // }
                          ?>
                          </b></h4>
                        </th>
                        <?php if($accesoPagosDetallesM){ ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php } ?>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              <div class="box-header">
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
                                  // $porcentajeRestanteFinal = 0;
                                  // if($nuevoTotal!=0){
                                  $porcentajeRestanteFinal = ($abonado*100)/$pedido['cantidad_aprobada'];
                                  // }else{
                                    // $porcentajeRestanteFinal = 0;
                                  // }
                                  echo number_format($porcentajeRestanteFinal,2,',','.')."%";
                                }
                              ?>
                            </b>
                          </h4>
                        </td>
                        <td style="width:8.5%"></td>
                        <td><h4>Monto: </h4></td>
                        <td><h4><b><?=number_format($totalMonto,2, ",",".")?></b></h4></td>
                        
                        <td><h4 style="color:<?=$colorText; ?>">Total: </h4></td>
                        <td><h4><b style="color:<?=$colorText; ?>">$<?=number_format($totalEquivalenteAb,2, ",",".")?></b></h4></td>

                        <?php if(!empty($_GET['lider'])){ ?>
                        <?php
                          $restoTotal = 0;
                          $calcularExcedenteTotal = 0;
                          $restoTotal = $pedido['cantidad_aprobada']-$abonado;
                          $restoTotalNegativo = ($restoTotal*(-1));
                          if($restoTotalNegativo>=0){
                            $calcularExcedenteTotal = $restoTotalNegativo;
                          }
                        ?>
                        <td><h4 style="color:#DD0000">Resta: </h4></td>
                        <td><h4>
                          <b style="color:#DD0000">$<?=number_format($restoTotal,2, ",","."); ?></b>
                          <?php //if($distPagosEqvEx>0){ ?>
                          <!-- <small>
                            <br>
                            <b>-</b> $<?=number_format($distPagosEqvEx,2, ",","."); ?> distribuidos
                            <br>
                            <b> $<?=number_format($mostrarExcedente+$distPagosEqvEx,2, ",","."); ?></b>
                          </small> -->
                          <?php //} ?>

                        </h4></td>
                        <?php }else{ ?>
                        <td></td>
                        <?php } ?>
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
                    <b style="color:#000 !important">Reportado</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado</b>
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
                    <?php if($_SESSION['home']['nombre_rol']=="Superusuario"){ ?>
                      <br>
                      <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="lideresPedidos">Líderes</label>
                          <!-- <input type="date" > -->
                          <select id="lideresPedidos" name="lideresPedidos" class="form-control select2 lideresPedidos" style="width:100%;">
                            <option value=""></option>
                            <?php
                              foreach ($lideres as $lidped) {
                                if(!empty($lidped['id_pedido'])){
                                    ?>
                                  <option id="lidped<?=$lidped['id_pedido']; ?>" value="<?=$lidped['id_pedido']; ?>"><?=$lidped['cedula']." ".$lidped['primer_nombre']." ".$lidped['primer_apellido']." (Ciclo ".$lidped['numero_ciclo'].")"; ?></option>
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
                        <input type="hidden" id="id_pago_modal" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12">
                           <label for="tasa">Tasa del dolar</label>
                           <input type="number" class="form-control tasaModal" value="" step="0.01" min="<?=$limiteFechaMinimo?>" name="tasa" id="tasa" max="<?=date('Y-m-d')?>">
                           <span id="error_tasaModal" class="errors"></span>
                        </div>
                        <input type="hidden" id="id_pedido_temp" class="id_pedido_temp" name="id_pedido_temp">
                    </div>
                    <?php if($_SESSION['home']['nombre_rol']=="Superusuario"){ ?>
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
                           <input type="text" class="form-control firmaAnalistaModal" step="0.01" name="firma" id="firmaAnalista">
                           <span id="error_firmaAnalistaModal" class="errors"></span>
                           <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyendaAnalista">Leyenda</label>
                           <input type="text" class="form-control leyendaAnalistaModal" step="0.01" name="leyenda" id="leyendaAnalista">
                           <span id="error_leyendaAnalistaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar2 enviarModalAprobadoAnalista">Enviar</span>
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
  // $("#enlaceAccess").hide();
  // $("#enlaceAccess").removeClass("d-none");
  // $(".expandAccess").click(function(){
  //   var clas = $("#idExpandAccess").attr("class");
  //   if(clas=="fa fa-chevron-circle-left"){
  //     $("#idExpandAccess").removeClass("fa-chevron-circle-left");
  //     $("#idExpandAccess").addClass("fa-chevron-circle-right");
  //     $("#enlaceAccess").show(300);
  //     $(this).attr("style", "margin-left:2px;border-left:1px solid #FFF");
  //   }
  //   if(clas=="fa fa-chevron-circle-right"){
  //     $("#idExpandAccess").removeClass("fa-chevron-circle-right");
  //     $("#idExpandAccess").addClass("fa-chevron-circle-left");
  //     $("#enlaceAccess").hide(300);
  //     $(this).attr("style", "border-left:none;");
  //   }
  // });
  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?<?=$menu; ?>&route=<?=$url; ?><?=$aux; ?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  }

  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                    confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                        });
                    } 
                });

          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
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
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
            }).then(function(){
              $(".cerrarModalAprobarAnalista").click();
            });
          }
          if(respuesta=="2"){
            swal.fire({
                type: 'error',
                title: '¡Error al realizar la operacion!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              }).then(function(){
                $(".cerrarModalDiferirAnalista").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
          var firma = "";
          var leyenda = "";
          if(data['firma']!=null){ firma = data['firma']; }
          if(data['leyenda']!=null){ leyenda = data['leyenda']; }
          if(firma!=""&&leyenda!=""){
            $(".name_firmayleyenda").html('Por <b>'+firma+':</b> '+leyenda);
          }

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
        // $(".ficha_detalle_concepto").html("<i><b>Concepto: </b></i>"+data['tipo_pago']);
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
        // alert('asd');

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
  $(".enviarModal").click(function(){
    var exec = false;
    $("#error_tipoPagoModal").html("");
    $("#error_tasaModal").html("");
    $("#error_fechaPagoModal2").html("");

    // alert($(".fecha_pago_modal2").val());

    // if($(".tipo_pago").val()=="" || $(".tasaModal").val()=="" || $(".fecha_pago_modal2").val()==""){
    if($(".fecha_pago_modal2").val()==""){
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
      var id_pago_modal = $("#id_pago_modal").val(); 
      var tasa = $("#tasa").val(); 
      $.ajax({
        url:'',
        type:"POST",
        data:{
          fecha_pago: fecha_pago,
          id_pedido_temp: id_pedido_new,
          rol: rol,
          id_pago_modal: id_pago_modal,
          tasa: tasa,
        },
        success: function(respuesta){
          alert(respuesta);
          // console.log(respuesta);
          var data = JSON.parse(respuesta);
          if(data['exec']=="1"){
            // var pago = data['pago'];
            // var despacho = data['despacho'];

            
            // // $(".tr"+id_pago_modal+" .contenido_forma_pago").html(pago['contenido_forma_pago']);
            // // $(".tr"+id_pago_modal+" .contenido_banco").html(pago['fecha_pago_format']);
            // // $(".tr"+id_pago_modal+" .contenido_referencia").html(pago['referencia_pago_format']);
            // // $(".tr"+id_pago_modal+" .contenido_monto").html(pago['monto_pago_format']);
            // var restriccion = "";
            // var temporalidad = "";
            // if(pago['tipo_pago']=="Contado"){
            //   restriccion = despacho['fecha_inicial_senior'];
            // }
            // if(pago['tipo_pago']=="Inicial"){
            //   restriccion = despacho['fecha_inicial_senior'];
            // }
            // if(pago['tipo_pago']=="Primer Pago"){
            //   restriccion = despacho['fecha_primera_senior'];
            // }
            // if(pago['tipo_pago']=="Segundo Pago"){
            //   restriccion = despacho['fecha_segunda_senior'];
            // }

            // if(pago['fecha_pago'] <= restriccion){
            //   temporalidad = "Puntual";
            // }else{
            //   temporalidad = "Impuntual";
            // }
            
            // var year = pago['fecha_pago'].substr(0, 4);
            // var mes = pago['fecha_pago'].substr(5, 2);
            // var dia = pago['fecha_pago'].substr(8, 2);

            // $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);

            // var fecha_modal = $(".tr"+id_pago_modal+" .contenido_fecha_pago").html();
            // var Ndia = fecha_modal.substr(0, 2);
            // var Nmes = fecha_modal.substr(3, 2);
            // var Nyear = fecha_modal.substr(6, 4);
            // var newfecha_modal = Nyear+"-"+Nmes+"-"+Ndia;
            
            // $(".tr"+id_pago_modal+" .contenido_fecha_pago").html(pago['fecha_pago_format']);
            // $(".tr"+id_pago_modal+" .contenido_temporalidad").html(temporalidad);
            // if(pago['tasa_pago']!=null){
            //   $(".tr"+id_pago_modal+" .contenido_tasa").html(pago['tasa_pago_format']);
            //   $(".tasaModal").val(pago['tasa_pago']);
            // }else{
            //   $(".tr"+id_pago_modal+" .contenido_tasa").html("");
            // }
            // var signo = "";
            // if(pago['forma_pago']=="Divisas Euros"){
            //   signo = "€";
            // }else{
            //   signo = "$";
            // }
            // $(".tr"+id_pago_modal+" .contenido_equivalente").html(signo+pago['equivalente_pago_format']);
            // $(".tr"+id_pago_modal+" .contenido_tipo_pago").html(pago['tipo_pago']);

            // if(pago['estado']!="Abonado"){
            //   if(newfecha_modal!=pago['fecha_pago']){
            //     $(".tr"+id_pago_modal).attr("style","background:;");
            //   }
            // }

            swal.fire({
              type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
            }).then(function(){
              $(".cerrarModal").click();
            });
          }
          if(data['exec']=="2"){
            swal.fire({
                type: 'error',
                title: '¡Error al realizar la operacion!',
                confirmButtonColor: "<?=$colorPrimaryAll; ?>",
            }).then(function(){
              // $(".cerrarModal").click();
            });
          }
        }
      });
    }
  });
  $(".cerrarModal").click(function(){
    $(".box-modalEditar").fadeOut(500);
  });
  $("#lideresPedidos").change(function(){
    var idped = $(this).val();
    $("#id_pedido_temp").val(idped);
  });

  // $(".diferirPagoBtnConciliadores").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var json = JSON.parse(response);
  //       var data = json['pedido'];
  //       console.log(data);
  //       if(data['fotoPerfil']==""||data['fotoPerfil']==null){
  //         var foto = "";
  //         if(data['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);   
  //       }else{
  //         $(".modal-img").attr("src",data['fotoPerfil']);
  //       }
  //       $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);
  //       var year = data['fecha_pago'].substr(0, 4);
  //       var mes = data['fecha_pago'].substr(5, 2);
  //       var dia = data['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       // alert(data['firma']);
  //       if(data['firma'] == ""){
  //       }else if(data['firma'] == null){
  //       }else{
  //         // $(".diferirFirmaModal").val(data['firma']);
  //       }

  //       if(data['observacion']=="Repetido"){
  //         $(".optRepetido").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Se solicita comprobante"){
  //         $(".optComprobante").attr("selected","selected");
  //       }
  //       if(data['observacion']=="No realizado a la empresa"){
  //         $(".optOtraEmpresa").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Actualizar fecha"){
  //         $(".optActFecha").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Actualizar banco"){
  //         $(".optActBanco").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Actualizar referencia"){
  //         $(".optActReferencia").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Actualizar monto"){
  //         $(".optActMonto").attr("selected","selected");
  //       }

  //       $(".name_conciliador").html("");
  //       $(".name_observ").html("");
  //       $(".name_leyenda").html("");
  //       if(data['estado']=="Diferido"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Firmado por: "+data['firma']);
  //           // $(".name_observacion").html(" "+data['observacion']);
  //         }
  //       }
  //       if(data['estado']=="Abonado"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Conciliado por: "+data['firma']);
  //           if(data['leyenda']!=null){
  //             $(".name_leyenda").html("<br>"+data['leyenda']);
  //           }
  //         }
  //       }

  //     }
  //   });
  //   $(".box-modalDiferirConcialiador").fadeIn(500);
  // });
  // $(".enviarModalDiferidoConciliadores").click(function(){
  //   var exec = false;
  //   $("#error_diferirFirmaModal").html("");
  //   $("#error_observacionModal").html("");
  //   // alert($(".diferirFirmaModal").val());
  //   // alert($(".observacion").val());
  //   if($(".diferirFirmaModal").val()=="" || $(".observacion").val()==""){
  //     if($(".diferirFirmaModal").val()==""){
  //       $("#error_diferirFirmaModal").html("Debe dejar su firma");
  //     }
  //     if($(".observacion").val()==""){
  //       $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
  //     }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     var estado = $(".box-modalDiferirConcialiador .estado").val();
  //     var firma = $(".box-modalDiferirConcialiador .firma").val();
  //     var newFirma = $(".box-modalDiferirConcialiador .newFirma").val();
  //     var observacion = $(".box-modalDiferirConcialiador .observacion").val();
  //     var id_pago_modal = $(".box-modalDiferirConcialiador .id_pago_modal").val();
  //     // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
  //     // $(".btn-enviar-modalAprobadoConciliadores").click();

  //       $.ajax({
  //         url:'',
  //         type:"POST",
  //         data:{
  //           estado: estado,
  //           firma: firma,
  //           newFirma: newFirma,
  //           observacion: observacion,
  //           id_pago_modal: id_pago_modal,
  //         },
  //         success: function(respuesta){
  //           // console.log(respuesta);
  //           if(respuesta=="1"){
  //             $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
  //             // $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
  //             // $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
  //             // $(".tr"+id_pago_modal+" .modificarBtn").hide();
  //             // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

  //             swal.fire({
  //               type: 'success',
  //                 title: '¡Datos guardados correctamente!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalDiferirConciliadores").click();
  //             });
  //           }
  //           if(respuesta=="2"){
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Error al realizar la operacion!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalDiferirConciliadores").click();
  //             });
  //           }
  //         }
  //       });
  //   }
  // });
  // $(".cerrarModalDiferirConciliadores").click(function(){
  //   $(".box-modalDiferirConcialiador").fadeOut(500);
  // });

  // $(".diferirPagoBtnAnalista").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var json = JSON.parse(response);
  //       var data = json['pedido'];
  //       console.log(data);
  //       if(data['fotoPerfil']==""||data['fotoPerfil']==null){
  //         var foto = "";
  //         if(data['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);   
  //       }else{
  //         $(".modal-img").attr("src",data['fotoPerfil']);
  //       }
  //       $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);
  //       var year = data['fecha_pago'].substr(0, 4);
  //       var mes = data['fecha_pago'].substr(5, 2);
  //       var dia = data['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".diferirFirmaAnalistaModal").val(data['firma']);
  //       if(data['observacion']=="Pendiente Por Entregar"){
  //         $(".optPendienteEntregar").attr("selected","selected");
  //       }
  //       if(data['observacion']=="Billete Devuelto Pendiente por Sustituir"){
  //         $(".optPendienteSustituir").attr("selected","selected");
  //       }
  //       if(data['observacion']=="En mal estado, sustituido por deposito - Dolares"){
  //         $(".optMalEstado").attr("selected","selected");
  //       }
        

  //       $(".name_conciliador").html("");
  //       $(".name_observ").html("");
  //       $(".name_leyenda").html("");
  //       if(data['estado']=="Diferido"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Firmado por: "+data['firma']);
  //           // $(".name_observacion").html(" "+data['observacion']);
  //         }
  //       }
  //       if(data['estado']=="Abonado"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Conciliado por: "+data['firma']);
  //           if(data['leyenda']!=null){
  //             $(".name_leyenda").html("<br>"+data['leyenda']);
  //           }
  //         }
  //       }
        

  //     }
  //   });
  //   $(".box-modalDiferirAnalista").fadeIn(500);
  // });
  // $(".enviarModalDiferidoAnalista").click(function(){
  //   var exec = false;
  //   $("#error_diferirFirmaAnalistaModal").html("");
  //   $("#error_observacionModal").html("");
  //   // alert($(".diferirFirmaAnalistaModal").val());
  //   // alert($(".observacion").val());
  //   if($(".diferirFirmaAnalistaModal").val()=="" || $(".observacion").val()==""){
  //     if($(".diferirFirmaAnalistaModal").val()==""){
  //       $("#error_diferirFirmaAnalistaModal").html("Debe dejar su firma");
  //     }
  //     if($(".observacion").val()==""){
  //       $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
  //     }
  //   }else{
  //     exec=true;
  //   }
  //   if(exec==true){ 
  //     var estado = $(".box-modalDiferirAnalista .estado").val();
  //     var firma = $(".box-modalDiferirAnalista .firma").val();
  //     var observacion = $(".box-modalDiferirAnalista .observacion").val();
  //     var id_pago_modal = $(".box-modalDiferirAnalista .id_pago_modal").val();
  //     // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
  //     // $(".btn-enviar-modalAprobadoAnalista").click();

  //       $.ajax({
  //         url:'',
  //         type:"POST",
  //         data:{
  //           estado: estado,
  //           firma: firma,
  //           observacion: observacion,
  //           id_pago_modal: id_pago_modal,
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           // console.log(respuesta);
  //           if(respuesta=="1"){
  //             $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
  //             // $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
  //             // $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
  //             // $(".tr"+id_pago_modal+" .modificarBtn").hide();
  //             // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

  //             swal.fire({
  //               type: 'success',
  //                 title: '¡Datos guardados correctamente!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalDiferirAnalista").click();
  //             });
  //           }
  //           if(respuesta=="2"){
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Error al realizar la operacion!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalDiferirAnalista").click();
  //             });
  //           }
  //         }
  //       });
  //   }
  // });
  // $(".cerrarModalDiferirAnalista").click(function(){
  //   $(".box-modalDiferirAnalista").fadeOut(500);
  // });

  
  // $(".aprobarPagoBtnConciliadores").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var json = JSON.parse(response);
  //       var data = json['pedido'];
  //       console.log(data);
  //       if(data['fotoPerfil']==""||data['fotoPerfil']==null){
  //         var foto = "";
  //         if(data['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);   
  //       }else{
  //         $(".modal-img").attr("src",data['fotoPerfil']);
  //       }
  //       $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);
  //       var year = data['fecha_pago'].substr(0, 4);
  //       var mes = data['fecha_pago'].substr(5, 2);
  //       var dia = data['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       // $(".firmaModal").val(data['firma']);
  //       if(data['firma'] == ""){
  //       }else if(data['firma'] == null){
  //       }else{
  //         // $(".firmaModal").val(data['firma']);
  //       }
  //       $(".leyendaModal").val(data['leyenda']);
        
  //       $(".name_conciliador").html("");
  //       $(".name_observ").html("");
  //       $(".name_leyenda").html("");
  //       if(data['estado']=="Diferido"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Firmado por: "+data['firma']);
  //           // $(".name_observacion").html(" "+data['observacion']);
  //         }
  //       }
  //       if(data['estado']=="Abonado"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Conciliado por: "+data['firma']);
  //           if(data['leyenda']!=null){
  //             $(".name_leyenda").html("<br>"+data['leyenda']);
  //           }
  //         }
  //       }


  //     }
  //   });
  //   $(".box-modalAprobarConcialiador").fadeIn(500);
  // });
  // $(".enviarModalAprobadoConciliadores").click(function(){
  //   var exec = false;
  //   $("#error_firmaModal").html("");
  //   $("#error_leyendaModal").html("");

  //   // if($(".firmaModal").val()=="" || $(".leyendaModal").val()==""){
  //   if($(".firmaModal").val()==""){
  //     if($(".firmaModal").val()==""){
  //       $("#error_firmaModal").html("Debe dejar su firma");
  //     }
  //     // if($(".leyendaModal").val()==""){
  //     //   $("#error_leyendaModal").html("Debe agregar la leyenda del pago");
  //     // }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     var estado = $(".box-modalAprobarConcialiador .estado").val();
  //     var firma = $(".box-modalAprobarConcialiador .firma").val();
  //     var newFirma = $(".box-modalAprobarConcialiador .newFirma").val();
  //     var leyenda = $(".box-modalAprobarConcialiador .leyenda").val();
  //     var id_pago_modal = $(".box-modalAprobarConcialiador .id_pago_modal").val();
  //     // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
  //     // $(".btn-enviar-modalAprobadoConciliadores").click();


  //       $.ajax({
  //         url:'',
  //         type:"POST",
  //         data:{
  //           estado: estado,
  //           firma: firma,
  //           newFirma: newFirma,
  //           leyenda: leyenda,
  //           id_pago_modal: id_pago_modal,
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           // console.log(respuesta);
  //           if(respuesta=="1"){
  //             $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
  //             $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
  //             $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
  //             $(".tr"+id_pago_modal+" .modificarBtn").hide();
  //             $(".tr"+id_pago_modal+" .eliminarBtn").hide();

  //             swal.fire({
  //               type: 'success',
  //                 title: '¡Datos guardados correctamente!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalAprobarConciliadores").click();
  //             });
  //           }
  //           if(respuesta=="2"){
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Error al realizar la operacion!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalAprobarConciliadores").click();
  //             });
  //           }
  //         }
  //       });
  //   }
  // });
  // $(".cerrarModalAprobarConciliadores").click(function(){
  //   $(".box-modalAprobarConcialiador").fadeOut(500);
  // });

  // $(".aprobarPagoBtnAnalista").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var json = JSON.parse(response);
  //       var data = json['pedido'];
  //       console.log(data);
  //       if(data['fotoPerfil']==""||data['fotoPerfil']==null){
  //         var foto = "";
  //         if(data['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);   
  //       }else{
  //         $(".modal-img").attr("src",data['fotoPerfil']);
  //       }
  //       $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);
  //       var year = data['fecha_pago'].substr(0, 4);
  //       var mes = data['fecha_pago'].substr(5, 2);
  //       var dia = data['fecha_pago'].substr(8, 2);


  //       // alert(data['fecha_pago']);
  //       // $(".fecha_pago_modal2").val(data['fecha_pago']);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".firmaAnalistaModal").val(data['firma']);
  //       $(".leyendaAnalistaModal").val(data['leyenda']);
  //       $(".name_conciliador").html("");
  //       $(".name_observ").html("");
  //       $(".name_leyenda").html("");
  //       if(data['estado']=="Diferido"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Firmado por: "+data['firma']);
  //           // $(".name_observacion").html(" "+data['observacion']);
  //         }
  //       }
  //       if(data['estado']=="Abonado"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Conciliado por: "+data['firma']);
  //           if(data['leyenda']!=null){
  //             $(".name_leyenda").html("<br>"+data['leyenda']);
  //           }
  //         }
  //       }
  //     }
  //   });
  //   $(".box-modalAprobarAnalista").fadeIn(500);
  // });
  // $(".enviarModalAprobadoAnalista").click(function(){
  //   var exec = false;
  //   $("#error_firmaAnalistaModal").html("");
  //   $("#error_leyendaAnalistaModal").html("");

  //   if($(".firmaAnalistaModal").val()=="" || $(".leyendaAnalistaModal").val()==""){
  //     if($(".firmaAnalistaModal").val()==""){
  //       $("#error_firmaAnalistaModal").html("Debe dejar su firma");
  //     }
  //     if($(".leyendaAnalistaModal").val()==""){
  //       $("#error_leyendaAnalistaModal").html("Debe agregar la leyenda del pago");
  //     }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     var estado = $(".box-modalAprobarAnalista .estadoAnalistaModal").val();
  //     var firma = $(".box-modalAprobarAnalista .firmaAnalistaModal").val();
  //     var leyenda = $(".box-modalAprobarAnalista .leyendaAnalistaModal").val();
  //     var id_pago_modal = $(".box-modalAprobarAnalista .id_pago_modal").val();
  //     // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
  //     // $(".btn-enviar-modalAprobadoAnalista").click();

  //       $.ajax({
  //         url:'',
  //         type:"POST",
  //         data:{
  //           estado: estado,
  //           firma: firma,
  //           leyenda: leyenda,
  //           id_pago_modal: id_pago_modal,
  //         },
  //         success: function(respuesta){
  //           // alert(respuesta);
  //           // console.log(respuesta);
  //           if(respuesta=="1"){
  //             $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
  //             $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
  //             $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
  //             $(".tr"+id_pago_modal+" .modificarBtn").hide();
  //             $(".tr"+id_pago_modal+" .eliminarBtn").hide();

  //             swal.fire({
  //               type: 'success',
  //                 title: '¡Datos guardados correctamente!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalAprobarAnalista").click();
  //             });
  //           }
  //           if(respuesta=="2"){
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Error al realizar la operacion!',
  //                 confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //             }).then(function(){
  //               $(".cerrarModalAprobarAnalista").click();
  //             });
  //           }
  //         }
  //       });
  //   }
  // });
  // $(".cerrarModalAprobarAnalista").click(function(){
  //   $(".box-modalAprobarAnalista").fadeOut(500);
  // });


  // $(".cerrarModalConciliador").click(function(){
  //   $(".box-modalEditarConciliador").fadeOut(500);
  // });
  // $(".editarPagoBtnConciliador").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       // alert(response);
  //       var json = JSON.parse(response);
  //       var data = json['pedido'];
  //       console.log(data);
  //       if(data['fotoPerfil']==""||data['fotoPerfil']==null){
  //         var foto = "";
  //         if(data['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);   
  //       }else{
  //         $(".modal-img").attr("src",data['fotoPerfil']);
  //       }
  //       $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);

  //       var year = data['fecha_pago'].substr(0, 4);
  //       var mes = data['fecha_pago'].substr(5, 2);
  //       var dia = data['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);

  //       $(".name_conciliador").html("");
  //       $(".name_observ").html("");
  //       $(".name_leyenda").html("");
  //       if(data['estado']=="Diferido"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Firmado por: "+data['firma']);
  //           // $(".name_observacion").html(" "+data['observacion']);
  //         }
  //       }
  //       if(data['estado']=="Abonado"){
  //         if(data['firma'] != null){
  //           $(".name_conciliador").html("Conciliado por: "+data['firma']);
  //           if(data['leyenda']!=null){
  //             $(".name_leyenda").html("<br>"+data['leyenda']);
  //           }
  //         }
  //       }


  //       var estado = "Reportado";
  //       $(".name_estado").html("");
  //       $(".name_observacion").html("");
  //       if(data['estado']=="Reportado" || data['estado']==null){
  //         estado = "Reportado";
  //         var style = $(".linear_estado").attr("style");
  //         $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,0,165,.65);");
  //         // rgba(0,0,160,.6)
  //         $(".name_estado").html(estado);
  //       }
  //       if(data['estado']=="Diferido"){
  //         estado = "Diferido";
  //         var style = $(".linear_estado").attr("style");
  //         $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(165,0,0,.65);");
  //         $(".name_estado").html(estado);
  //         $(".name_observacion").html(data['observacion']);
  //       }
  //       if(data['estado']=="Abonado"){
  //         estado = "Abonado";
  //         var style = $(".linear_estado").attr("style");
  //         $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,165,0,.65);"); 
  //         $(".name_estado").html(estado);
  //         // $(".name_observacion").html(data['leyenda']);
  //       }


  //       $(".box-modalEditarConciliador").fadeIn(500);
  //     }
  //   });
  // });

  // $(".enviarModalDistribuirEx").click(function(){
  //   var exec = false;
  //   var rcantidad = false;
  //   var cantidad = $("#cantidadDistribucionEx").val();
  //   var rconcepto_pago = false;
  //   var concepto_pago = $(".concepto_pago_cantidadDistribucionEx").val();
  //   var rid_pedido = false;
  //   var id_pedido = $(".id_pedido_cantidadDistribucionEx").val();
  //   $("#error_cantidadDistribucionEx").html("");
    
  //   if(cantidad==""){
  //     $("#error_cantidadDistribucionEx").html("Debe llenar una cantidad para distribuir el descuento");
  //     rcantidad = false;
  //   }else{
  //     if(cantidad < 0){
  //       $("#error_cantidadDistribucionEx").html("Debe llenar una cantidad para distribuir el descuento");
  //       rcantidad = false;
  //     }else{
  //       rcantidad = true;
  //     }
  //   }
  //   if(id_pedido==""){
  //     rid_pedido = false;
  //   }else{
  //     rid_pedido = true;
  //   }
  //   if(concepto_pago==""){
  //     rconcepto_pago = false;
  //   }else{
  //     rconcepto_pago = true;
  //   }
  //   if(rcantidad==true && rid_pedido==true && rconcepto_pago==true){
  //     exec = true;
  //   }else{
  //     exec = false;
  //   }
  //   if(exec==true){
  //     $.ajax({
  //       url:'',
  //       type:"POST",
  //       data:{
  //         cantidadDistribucion: 'cantidadDistribucionEx',
  //         concepto_pago: concepto_pago,
  //         id_pedido: id_pedido,
  //         cantidad: cantidad,
  //       },
  //       success: function(respuesta){
  //         // alert(respuesta);
  //         if(respuesta=="1"){
  //           swal.fire({
  //             type: 'success',
  //               title: '¡Datos guardados correctamente!',
  //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //           }).then(function(){
  //             $(".cerrarModalDistribuir").click();
  //           });
  //         }
  //         if(respuesta=="2"){
  //           swal.fire({
  //             type: 'error',
  //             title: '¡Error al realizar la operacion!',
  //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //           }).then(function(){
  //             // $(".cerrarModal").click();
  //           });
  //         }
  //       }
  //     });
  //   }
  // });
  // $(".distribuirExcedentes").click(function(){
  //   $(".box-modalDistribuirEx").fadeIn(500);
  // });
  // $("#distribucionConceptoEx").change(function(){
  //   // HaciendoCambios
  //   var val = $(this).val();
  //   if(val!=""){
  //     $(".formDistribucionConceptoEx").submit();
  //   }
  // });
  // $("#cantidadDistribucionEx").keyup(function(){
  //   var val = parseFloat($(this).val());
  //   var max = parseFloat($(this).attr("max"));
  //   if(val != NaN){
  //     var nval = 0;
  //     if(val >= 0){
  //       if(val > max){
  //         nval = max;
  //       }else{
  //         nval = val;
  //       }
  //       $(this).val(nval);
  //     }else{
  //       $(this).val("");
  //     }
  //   }else{
  //     $(this).val("");
  //   }
  // });
  // $(".cerrarModalDistribuirEx").click(function(){
  //   $(".box-modalDistribuirEx").fadeOut(500);

  //   $(".cerrarFormDistribucionConceptoEx").delay(500).submit();
  // });
  
  // $(".enviarModalDistribuir").click(function(){
  //   var exec = false;
  //   var rcantidad = false;
  //   var cantidad = $("#cantidadDistribucion").val();
  //   var rconcepto_pago = false;
  //   var concepto_pago = $(".concepto_pago_cantidadDistribucion").val();
  //   var rid_pedido = false;
  //   var id_pedido = $(".id_pedido_cantidadDistribucion").val();
  //   $("#error_cantidadDistribucion").html("");
    
  //   if(cantidad==""){
  //     $("#error_cantidadDistribucion").html("Debe llenar una cantidad para distribuir el descuento");
  //     rcantidad = false;
  //   }else{
  //     if(cantidad < 0){
  //       $("#error_cantidadDistribucion").html("Debe llenar una cantidad para distribuir el descuento");
  //       rcantidad = false;
  //     }else{
  //       rcantidad = true;
  //     }
  //   }
  //   if(id_pedido==""){
  //     rid_pedido = false;
  //   }else{
  //     rid_pedido = true;
  //   }
  //   if(concepto_pago==""){
  //     rconcepto_pago = false;
  //   }else{
  //     rconcepto_pago = true;
  //   }
  //   if(rcantidad==true && rid_pedido==true && rconcepto_pago==true){
  //     exec = true;
  //   }else{
  //     exec = false;
  //   }
  //   if(exec==true){
  //     $.ajax({
  //       url:'',
  //       type:"POST",
  //       data:{
  //         cantidadDistribucion: 'cantidadDistribucion',
  //         concepto_pago: concepto_pago,
  //         id_pedido: id_pedido,
  //         cantidad: cantidad,
  //       },
  //       success: function(respuesta){
  //         // alert(respuesta);
  //         if(respuesta=="1"){
  //           swal.fire({
  //             type: 'success',
  //               title: '¡Datos guardados correctamente!',
  //               confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //           }).then(function(){
  //             $(".cerrarModalDistribuir").click();
  //           });
  //         }
  //         if(respuesta=="2"){
  //           swal.fire({
  //             type: 'error',
  //             title: '¡Error al realizar la operacion!',
  //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
  //           }).then(function(){
  //             // $(".cerrarModal").click();
  //           });
  //         }
  //       }
  //     });
  //   }
  // });
  // $(".distribuirDescuentos").click(function(){
  //   $(".box-modalDistribuir").fadeIn(500);
  // });
  // $("#distribucionConcepto").change(function(){
  //   // formDistribucionConcepto
  //   var val = $(this).val();
  //   if(val!=""){
  //     $(".formDistribucionConcepto").submit();
  //   }
  // });
  // $("#cantidadDistribucion").keyup(function(){
  //   var val = parseFloat($(this).val());
  //   var max = parseFloat($(this).attr("max"));
  //   if(val != NaN){
  //     var nval = 0;
  //     if(val >= 0){
  //       if(val > max){
  //         nval = max;
  //       }else{
  //         nval = val;
  //       }
  //       $(this).val(nval);
  //     }else{
  //       $(this).val("");
  //     }
  //   }else{
  //     $(this).val("");
  //   }
  // });
  // $(".cerrarModalDistribuir").click(function(){
  //   $(".box-modalDistribuir").fadeOut(500);

  //   $(".cerrarFormDistribucionConcepto").delay(500).submit();
  // });
});  
</script>
</body>
</html>
