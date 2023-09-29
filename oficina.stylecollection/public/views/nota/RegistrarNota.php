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
        <?php echo "Notas de entrega"; ?>
        <small><?php if(!empty($action)){echo "Realizar Notas de entrega";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Notas de entrega"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Realizar ";} echo " Notas de entrega"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Notas de entrega"; ?></a></div>
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


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Realizar <?php echo "Notas de entrega"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           

            <div class="box-body">
              
                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                  <div class="form-group col-xs-12">
                    <label for="lider">Seleccione al Lider</label>
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="Nota" name="route">
                    <input type="hidden" value="Registrar" name="action">
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
                                          ?>
                                        <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"  <?php //foreach ($premios_perdidos_usados as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?>  <?php //} } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                          <?php 
                                      }
                                    }
                                  }
                                }
                              }else if($accesoBloqueo=="0"){
                                  ?>
                                <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"  <?php //foreach ($premios_perdidos_usados as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?>  <?php //} } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                  <?php
                              }
                            ?>
                            
                      
                          <?php endif ?>
                        <?php endforeach ?>
                    </select>
                  </div>
                  </form>
                </div>
            </div>

            <?php if (!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){ ?>
                <form action="" method="post" class="form table-responsive">
                  <div class="box-body ">
                    <div class="col-xs-12">
                      <div class="col-xs-12 col-sm-7 text-center">
                        <img src="public/assets/img/logoTipo1.png" style="width:350px;">
                        <br>
                        Rif.: J408497786
                        <br>
                        <textarea name="direccion_emision" maxlength="255" style="border:none;min-width:100%;max-width:100%;min-height:60px;max-height:60px;text-align:center;padding:0">AV LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL NRO S/N BARRIO PUEBLO NUEVO <?="\n"?> BARQUISIMETO EDO LARA ZONA POSTAL 3001</textarea>
                        <b style="color:<?=$fucsia?>">
                        </b>
                      </div>
                      <div class="col-xs-12 col-sm-5 text-center">
                        <br class="xs-none">
                        <br class="xs-none">
                        <div style="">
                          <div class="col-xs-12 col-md-6" style="display:inline-block;">
                            <small>LUGAR DE EMISION</small>
                            <br>
                            <input type="text" name="lugar_emision" value="Barquisimeto" maxlength="90">
                          </div>
                          <div class="col-xs-12 col-md-6" style="display:inline-block;">
                            <small>FECHA DE EMISION</small>
                            <br>
                            <input type="date" name="fecha_emision" value="<?=date('Y-m-d')?>">
                          </div>
                        </div>
                        <br><br><br><br>
                        <h4 style="margin-top:0;margin-bottom:0;">
                          <b>
                          NOTA DE ENTREGA
                          </b>
                        </h4>
                        <div style="display:inline-block;width:60%;">
                          <h3 style="display:inline-block;float:left;margin:0;padding:0;width:15%;"><b>N° </b></h3>
                          <!-- <span style="margin-left:10px;margin-right:10px;"></span> -->
                          <input type="number" class="form-control" name="numero" step="1" value="<?=$nume?>" onfocusout="$(this).val(parseInt($(this).val()))" style="display:inline-block;font-size:1.6em;float:right;width:85%;margin:0;">
                        </div>
                      </div>
                      <input type="hidden" name="id_cliente" value="<?=$_GET['lider']?>">
                    </div> 

                    <div class="col-xs-12 text-center">
                      <div class="col-xs-12" style="border-top:1px solid #777;border-bottom:1px solid #777;width:95%;margin-left:2.5%;">
                        <?=mb_strtoupper('Nota de entrega de Premios y Retos'); ?>
                      </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-3" style="font-size:1.1em">
                          Campaña <?=$numero_campana?>/<?=$anio_campana?>
                        </div>
                        <div class="col-xs-5" style="font-size:1.1em">
                          Analista: <input type="text" style="width:60%" placeholder="Nombre del analista" name="nombreanalista" maxlength="50">
                        </div>
                        <div class="col-xs-4" style="font-size:1.2em">
                          <?php if ($numFactura != ""): ?>
                            Factura N°. 
                            <b>
                            <?=$numFactura?> 
                            </b>
                          <?php endif; ?>
                        </div>
                    </div>

                    <div class="">
                      <div class="col-xs-12" >
                        <!-- <div style="border:1px solid <?=$fucsia?>;border-radius:20px !important;padding:0;"> -->
                          <table class="table table-bordered" style="border:none;">
                            <tr>
                              <td colspan="3">
                                NOMBRES Y APELLIDOS:
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <?=$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']?>
                              </td>
                              <td colspan="2">
                                CEDULA:
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <?=number_format($pedido['cedula'],0,'','.')?>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                DIRECCION:
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <?=$pedido['direccion']?>
                              </td>
                              <td colspan="2">
                                TELEFONO: 
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <?php 
                                  echo separateDatosCuentaTel($pedido['telefono']);
                                  if(strlen($pedido['telefono2'])>5){

                                    echo " / ".separateDatosCuentaTel($pedido['telefono2']);
                                  }
                                ?> 
                              </td>
                            </tr>
                          </table>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="">
                      <div class="col-xs-12">
                        <table class="table table-bordered text-left table-striped table-hover" id="">
                          <thead style="background:#DDD;font-size:1.05em;">
                            <tr>
                              <th style="text-align:center;width:4%;">Cantidad</th>
                              <th style="text-align:left;width:38%;">Descripcion</th>
                              <th style="text-align:left;width:38%;">Concepto</th>
                              <th style="text-align:left;width:10%;"></th>
                              <th style="text-align:left;width:10%;"></th>
                            </tr>
                            <style>
                              .col1{text-align:center;}
                              .col2{text-align:left;}
                              .col3{text-align:left;}
                              .col4{text-align:left;}
                              .col5{text-align:left;}
                            </style>
                          </thead>
                          <tbody>
                            <?php
                              $num = 1;
                              foreach ($pedidos as $data){ 
                                if(!empty($data['id_pedido'])){
                                  // ========================== // =============================== // ============================== //
                                  $coleccionesPlanPremioPedido = [];
                                  // ========================== // =============================== // ============================== //
                                  foreach ($pagosRecorridos as $pagosR){
                                    if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
                                      foreach ($planesCol as $data2){
                                        if(!empty($data2['id_cliente'])) { 
                                          if ($data['id_pedido'] == $data2['id_pedido']) { 
                                            if ($data2['cantidad_coleccion_plan']>0) {
                                              // ========================== // =============================== // ============================== //
                                              $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_seleccionada'] = $data2['cantidad_coleccion_plan'];
                                              $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = 0;
                                              // ========================== // =============================== // ============================== //
                                              foreach ($premios_perdidos as $dataperdidos) {
                                                if(!empty($dataperdidos['id_premio_perdido'])){
                                                  if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                    $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                    // ========================== // =============================== // ============================== //
                                                    if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                                      if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                                        $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoResult;
                                                      }
                                                    }
                                                    // ========================== // =============================== // ============================== //
                                                    if($nuevoResult>0){
                                                      foreach ($premios_planes as $planstandard){
                                                        if ($planstandard['id_plan_campana']){
                                                          if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
                                                            if ($planstandard['tipo_premio']==$pagosR['name']){ ?>
                                                                <tr class="codigoS<?=$planstandard['id_premio']?>"  <?php if($data2['opcion']==0){ ?> style='color:#DDD;' <?php } ?>> <!-- STANDARD -->
                                                                  <td class="col1">
                                                                    <?php echo $nuevoResult; ?>
                                                                  </td>
                                                                  <td class="col2">
                                                                    <?php echo $planstandard['producto']; ?>
                                                                  </td>
                                                                  <td class="col3">
                                                                    Premio de <?=$pagosR['name']; ?>. P. <?=$planstandard['nombre_plan'] ?>
                                                                  </td>
                                                                  <td class="col4"></td>
                                                                  <td class="col5">
                                                                  </td>
                                                                  <td>
                                                                    <select class="opciones" name="opts[S<?=$planstandard['id_premio']?>]" id="S<?=$planstandard['id_premio']?>">
                                                                      <option <?php if($data2['opcion']=="1"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                                        <option <?php if($data2['opcion']=="0"){ ?> selected <?php  } ?> value="N">No</option>
                                                                    </select>
                                                                  </td>
                                                                </tr>
                                                              <?php 
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                              // ========================== // =============================== // ============================== //
                                              $nuevoTSelected = 0;
                                              // ========================== // =============================== // ============================== //
                                              foreach ($premioscol as $data3){
                                                if(!empty($data3['id_premio'])){
                                                  if ($data3['id_plan']==$data2['id_plan']){
                                                    if ($data['id_pedido']==$data3['id_pedido']){
                                                      if($data3['cantidad_premios_plan']>0){
                                                        foreach ($premios_perdidos as $dataperdidos) {
                                                          if(!empty($dataperdidos['id_premio_perdido'])){
                                                            if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                              $nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                              // ========================== // =============================== // ============================== //
                                                              $nuevoTSelected += $nuevoResult;
                                                              // ========================== // =============================== // ============================== //
                                                              if($nuevoResult>0){ ?>
                                                                  <tr class="codigoP<?=$data3['id_premio']?>" <?php if($data2['opcion']==0){ ?> style='color:#DDD;' <?php } ?>> <!-- PRIMER PAGO -->
                                                                    <td class="col1">
                                                                      <?php echo $nuevoResult; ?>
                                                                    </td>
                                                                    <td class="col2">
                                                                      <?php echo $data3['nombre_premio']; ?>
                                                                    </td>
                                                                    <td class="col3">
                                                                      Premio de <?=$pagosR['name']; ?>. P. <?=$data3['nombre_plan'] ?>
                                                                    </td>
                                                                    <td class="col4"></td>
                                                                    <td class="col5"></td>
                                                                    <td>
                                                                      <select class="opciones" name="opts[P<?=$data3['id_premio']?>]" id="P<?=$data3['id_premio']?>">
                                                                        <option <?php if($data2['opcion']=="1"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                                        <option <?php if($data2['opcion']=="0"){ ?> selected <?php  } ?> value="N">No</option>
                                                                      </select>
                                                                    </td>
                                                                  </tr>
                                                                <?php 
                                                              }
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                              // ========================== // =============================== // ============================== //
                                              // echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
                                              if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                                if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                                  $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoTSelected;
                                                }
                                              }
                                              // echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
                                              // ========================== // =============================== // ============================== //
                                            }
                                          }
                                        }
                                      }
                                    }else{
                                      // ========================== // =============================== // ============================== //
                                      $maxDisponiblePremiosSeleccion = 0;
                                      $opMaxDisp = 0;
                                      $opPlansinPremio = false;
                                      $cantidadRestar = 0;
                                      // $optOption = 1;
                                      foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                          // echo $data2['nombre_plan']." | ";
                                          // echo $data2['cantidad_coleccion_plan']." | ";
                                          // echo "<br>";
                                        if ($data['id_pedido'] == $data2['id_pedido']){
                                          if ($data2['cantidad_coleccion_plan']>0){
                                            if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                              $opMaxDisp = 1;
                                              $seleccionado = $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'];
                                              $cantidadCols = $data2['cantidad_coleccion'] * $seleccionado;
                                              $premiosDispPlanSeleccion = $controladorPremios[$data2['nombre_plan']][$pagosR['name']];
                                              $multiDisponiblePremiosSeleccion = ($premiosDispPlanSeleccion*$cantidadCols);
                                              $maxDisponiblePremiosSeleccion += $multiDisponiblePremiosSeleccion;
                                              // echo "<br>";
                                              // echo "<br>";
                                              // // print_r($coleccionesPlanPremioPedido);
                                              // echo "<br>";
                                              // echo "<br> | ".$seleccionado." | ".$multiDisponiblePremiosSeleccion." | <br>";
                                              // echo $premiosDispPlanSeleccion."*".$cantidadCols." = ".$multiDisponiblePremiosSeleccion." Cols. de Plan ".$data2['nombre_plan']."<br>";
                                              if($premiosDispPlanSeleccion==0){
                                                $opPlansinPremio = true;
                                                $cantidadRestar+=$cantidadCols;
                                              }
                                              // $optOption = $data2['opcion'];
                                              // echo "OPCION: ".$data2['opcion'];
                                            }
                                          }
                                        }
                                      } }
                                      if($opMaxDisp==0){
                                        $maxDisponiblePremiosSeleccion = -1;
                                      }
                                      // echo "<h1>".$maxDisponiblePremiosSeleccion."</h1>";
                                      // echo "<h1>";
                                      // if($opPlansinPremio==false){
                                      //   echo "0";
                                      // }else{
                                      //   echo "1";
                                      // }
                                      // echo "</h1>";
                                      // ========================== // =============================== // ============================== //
                                            // print_r($pagos_despacho);
                                      foreach ($premios_perdidos as $dataperdidos) {
                                          if(($dataperdidos['valor'] == $pagosR['id']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                            $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
                                        if(!empty($dataperdidos['id_premio_perdido'])){
                                            // ========================== // =============================== // ============================== //
                                            if($opPlansinPremio){
                                              $nuevoResult -= $cantidadRestar;
                                              // if($maxDisponiblePremiosSeleccion>0){
                                              //   if($nuevoResult>$maxDisponiblePremiosSeleccion){
                                              //     $nuevoResult = $maxDisponiblePremiosSeleccion;
                                              //   }
                                              // }
                                            }
                                            // ========================== // =============================== // ============================== //
                                                            // echo "<br>";
                                                            // echo $pagosR['id'];
                                                            // echo "<br>";
                                                            // echo "Aprobado: ".$data['cantidad_aprobado'];
                                                            // echo "<br>";
                                                            // echo "Perdidos: ".$dataperdidos['cantidad_premios_perdidos'];
                                                            // echo "<br>";
                                                            // echo "Resultado: ".$nuevoResult;


                                                            // echo "<br>";
                                            if($nuevoResult>0){
                                              foreach ($premios_planes as $planstandard){
                                                if (!empty($planstandard['id_plan_campana'])){
                                                  if ($planstandard['tipo_premio'] == $pagosR['name']){ ?>
                                                      <tr class="codigo<?=$pagosR['cod']; ?>"> <!-- INICIAL -->
                                                        <td class="col1">
                                                          <?php
                                                          ?>
                                                          <?php echo $nuevoResult; ?>
                                                        </td>
                                                        <td class="col2">
                                                          <?php echo $planstandard['producto']; ?>
                                                        </td>
                                                        <td class="col3">
                                                          Premio de <?=$pagosR['name']; ?>
                                                        </td>
                                                        <td class="col4">
                                                          <?php 
                                                            // echo $optOption; 
                                                          ?>
                                                        </td>
                                                        <td class="col5">
                                                        </td>
                                                        <td>
                                                          <select class="opciones" name="opts[<?=$pagosR['cod']; ?>]" id="<?=$pagosR['cod']; ?>">
                                                            <option value="Y">SI</option>
                                                            <option value="N">No</option>
                                                          </select>
                                                        </td>
                                                      </tr>
                                                    <?php 
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }
                                  }

                                  foreach ($retos as $reto){
                                    if (!empty($reto['id_reto'])){
                                      if ($reto['id_pedido']==$data['id_pedido']){
                                        if ($reto['cantidad_retos']){ ?>
                                              <tr class="codigoR<?=$reto['id_premio']?>"> <!-- retos -->
                                                <td class="col1">
                                                  <?php echo $reto['cantidad_retos']; ?>
                                                </td>
                                                <td class="col2">
                                                  <?php echo $reto['nombre_premio']; ?>
                                                </td>
                                                <td class="col3">
                                                    Premio de Reto Junior
                                                </td>
                                                <td class="col4">
                                                </td>
                                                <td class="col5">
                                                </td>
                                                <td>
                                                  <select class="opciones" name="opts[R<?=$reto['id_premio']?>]" id="R<?=$reto['id_premio']?>">
                                                    <option value="Y">SI</option>
                                                    <option value="N">No</option>
                                                  </select>
                                                </td>
                                              </tr>
                                          <?php 
                                        }
                                      }
                                    }
                                  }

                                  foreach ($abonoCantPromo as $promos) {
                                    foreach($premios_promocion as $premioP){ if(!empty($premioP['id_promocion'])){
                                      if($premioP['id_promocion']==$promos['id']){
                                        $idPromo = 0;
                                        $cantPromo = 0;
                                        $nombrePremioPromo = "";
                                        $nombrePromocion = $promos['promocion'];
                                        if($premioP['tipo_premio']=="Producto"){
                                          foreach ($productos as $pPromo){ if(!empty($pPromo['id_producto'])){
                                            if($pPromo['id_producto']==$premioP['id_premio']){
                                              // $idPromo = $promos['ids'].$premioP['id_premio'];
                                              $idPromo = "PD".$premioP['id_premio'];
                                              $cantPromo = $promos['cantidad'];
                                              $nombrePremioPromo = $pPromo['producto'];
                                            }
                                          }}
                                        }
                                        if($premioP['tipo_premio']=="Premio"){
                                          foreach ($premios as $pPromo){ if(!empty($pPromo['id_premio'])){
                                            if($pPromo['id_premio']==$premioP['id_premio']){
                                              $idPromo = "PR".$premioP['id_premio'];
                                              $cantPromo = $promos['cantidad'];
                                              $nombrePremioPromo = $pPromo['nombre_premio'];
                                            }
                                          }}
                                        }
                                        if($cantPromo>0){
                                        ?>
                                          <tr class="codigo<?=$idPromo; ?>"> <!-- retos -->
                                            <td class="col1">
                                              <?php echo $cantPromo; ?>
                                            </td>
                                            <td class="col2">
                                              <?php echo $nombrePremioPromo; ?>
                                            </td>
                                            <td class="col3">
                                              Premio de <?=$nombrePromocion; ?>
                                            </td>
                                            <td class="col4">
                                            </td>
                                            <td class="col5">
                                            </td>
                                            <td>
                                              <select class="opciones" name="opts[<?=$idPromo; ?>]" id="<?=$idPromo; ?>">
                                                <option value="Y">SI</option>
                                                <option value="N">No</option>
                                              </select>
                                            </td>
                                          </tr>
                                        <?php
                                        }
                                      }
                                    } }
                                  }


                                  foreach ($premios_autorizados as $premiosAutorizados){
                                    if (!empty($premiosAutorizados['id_PA'])){
                                      if ($premiosAutorizados['id_pedido']==$data['id_pedido']){
                                        if ($premiosAutorizados['cantidad_PA']){ ?>
                                              <tr class="codigoPA<?=$premiosAutorizados['id_PA']?>"> <!-- retos -->
                                                <td class="col1">
                                                  <?php echo $premiosAutorizados['cantidad_PA']; ?>
                                                </td>
                                                <td class="col2">
                                                  <?php echo $premiosAutorizados['nombre_premio']; ?>
                                                </td>
                                                <td class="col3">
                                                  <?php
                                                    if($premiosAutorizados['descripcion_PA']==""){
                                                      echo $premiosAutorizados['firma_PA'];
                                                    }else{
                                                      echo $premiosAutorizados['descripcion_PA'];
                                                    }
                                                  ?>
                                                </td>
                                                <td class="col4">
                                                </td>
                                                <td class="col5">
                                                </td>
                                                <td>
                                                  <select class="opciones" name="opts[PA<?=$premiosAutorizados['id_PA']?>]" id="PA<?=$premiosAutorizados['id_PA']?>">
                                                    <option value="Y">SI</option>
                                                    <option value="N">No</option>
                                                  </select>
                                                </td>
                                              </tr>
                                          <?php 
                                        }
                                      }
                                    }
                                  }
                                  foreach ($premios_autorizados_obsequio as $premiosAutorizados){
                                    if (!empty($premiosAutorizados['id_PA'])){
                                      if ($premiosAutorizados['id_pedido']==$data['id_pedido']){
                                        if ($premiosAutorizados['cantidad_PA']){ ?>
                                              <tr class="codigoPA<?=$premiosAutorizados['id_PA']?>"> <!-- retos -->
                                                <td class="col1">
                                                  <?php echo $premiosAutorizados['cantidad_PA']; ?>
                                                </td>
                                                <td class="col2">
                                                  <?php echo $premiosAutorizados['nombre_premio']; ?>
                                                </td>
                                                <td class="col3">
                                                  <?php
                                                    if($premiosAutorizados['descripcion_PA']==""){
                                                      echo $premiosAutorizados['firma_PA'];
                                                    }else{
                                                      echo $premiosAutorizados['descripcion_PA'];
                                                    }
                                                  ?>
                                                </td>
                                                <td class="col4">
                                                </td>
                                                <td class="col5">
                                                </td>
                                                <td>
                                                  <select class="opciones" name="opts[PA<?=$premiosAutorizados['id_PA']?>]" id="PA<?=$premiosAutorizados['id_PA']?>">
                                                    <option value="Y">SI</option>
                                                    <option value="N">No</option>
                                                  </select>
                                                </td>
                                              </tr>
                                          <?php 
                                        }
                                      }
                                    }
                                  }
                                  $arrayt = [];
                                  $numCC = 0;
                                  foreach ($canjeosUnic as $canUnic) {
                                    if(!empty($canUnic['nombre_catalogo'])){
                                      $arrayt[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                                      $arrayt[$numCC]['cantidad'] = 0;
                                      $arrayt[$numCC]['id_catalogo'] = $canUnic['id_catalogo']; 
                                      $numCC++;
                                    }
                                  }
                                  foreach ($canjeos as $canje){
                                    if (!empty($canje['id_cliente'])){
                                      if ($canje['id_cliente']==$data['id_cliente']){
                                        for ($i=0; $i < count($arrayt); $i++) { 
                                          if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
                                            $arrayt[$i]['cantidad']++;
                                          }
                                        }
                                      }
                                    }
                                  }
                                  foreach ($arrayt as $canjeos){
                                    if (!empty($canjeos['id_catalogo'])){
                                        if ($canjeos['cantidad']){  ?>
                                          <tr class="codigoCG<?=$canjeos['id_catalogo']?>"> <!-- canjeoss -->
                                            <td class="col1">
                                              <?php echo $canjeos['cantidad']; ?>
                                            </td>
                                            <td class="col2">
                                              <?php echo $canjeos['nombre']; ?>
                                            </td>
                                            <td class="col3">
                                                Premios Canjeados
                                            </td>
                                            <td class="col4">
                                            </td>
                                            <td class="col5">
                                            </td>
                                            <td>
                                              <select class="opciones" name="opts[CG<?=$canjeos['id_catalogo']?>]" id="CG<?=$canjeos['id_catalogo']?>">
                                                <option value="Y">SI</option>
                                                <option value="N">No</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <?php 
                                        }
                                    }
                                  }
                                  $num++;
                                }
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar">Enviar</span>
                    <button class="btn-enviar d-none" disabled="" >enviar</button>
                  </div>
                </form>
            <?php } ?>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Nota";
        window.location.href=menu;
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
    // alert(select);
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });

  $(".opciones").change(function(){
    var cod = $(this).attr("id");
    var val = $(this).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
    }
  });

  $(".enviar").click(function(){
    var response = validar();
    var response = true;

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

  $("#buscando").keyup(function(){
    $(".elementTR").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".elementTR:not(:contains('"+buscar+"'))").hide();
    }
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

  
});

function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var selected = parseInt($("#selectedPedido").val());
  var rselected = false;
  if(selected > 0){
    rselected = true;
    $(".error_selected_pedido").html("");
  }else{
    rselected = false;
    $(".error_selected_pedido").html("Debe Seleccionar un Pedido");      
  }
  /*===================================================================*/

  /*===================================================================*/

  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //     $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //   $("#error_cantidad").html("");
  // }


  /*===================================================================*/
  var result = false;
  if( rselected==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  // alert(result);
  return result;
}

</script>
</body>
</html>
