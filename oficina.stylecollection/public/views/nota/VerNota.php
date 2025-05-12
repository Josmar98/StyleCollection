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
        <small><?php if(!empty($action)){echo "Detalle Notas de entrega";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Notas de entrega"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "";} echo " Notas de entrega"; ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?php echo "Notas de entrega"; ?></a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Ver <?php echo "Notas de entrega"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <form action="" method="get" class="form table-responsive" target="_blank">
                <div class="box-body">
                  <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                  <input type="hidden" value="<?=$numero_campana;?>" name="n">
                  <input type="hidden" value="<?=$anio_campana;?>" name="y">
                  <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                  <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                  <input type="hidden" value="Nota" name="route">
                  <input type="hidden" value="Generar" name="action">
                  <input type="hidden" value="<?=$_GET['nota']?>" name="nota">
                  <div class="">
                    <div class="col-xs-12 col-sm-7 text-center">
                      <img src="public/assets/img/logoTipo1.png" style="width:350px;">
                      <br>
                      Rif.: J408497786
                      <br>
                      <div readonly="" maxlength="255" style="border:none;min-width:100%;max-width:100%;min-height:60px;max-height:60px;text-align:center;padding:0;padding-right:10%;padding-left:10%;"><?=$notaentrega['direccion_emision']?></div>
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
                          <input type="text" style="border:none;" readonly="" value="<?=$notaentrega['lugar_emision']?>" maxlength="90">
                        </div>
                        <div class="col-xs-12 col-md-6" style="display:inline-block;">
                          <small>FECHA DE EMISION</small>
                          <br>
                          <input type="date" style="border:none;" readonly="" value="<?=$notaentrega['fecha_emision']?>">
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
                        <input type="number" readonly="" class="form-control" step="1" value="<?=$notaentrega['numero_nota_entrega']?>" onfocusout="$(this).val(parseInt($(this).val()))" style="display:inline-block;font-size:1.6em;float:right;width:85%;margin:0;">
                      </div>
                    </div>
                  </div> 
                  <br>

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
                        Analista: <?=$notaentrega['nombreanalista']?>
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
                          <?php //if($notaentrega['observaciones']!=""){ ?>
                            <tr>
                              <td colspan="3">
                                Observación:
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <span class="box-opt-editar-observacion txt-observacion-txt"><?=$notaentrega['observaciones']; ?></span>
                                <input type="text" class="form-control input-sololectura box-opt-guardar-observacion d-none" style="width:80%;display:inline-block;" id="txt-observaciones" readonly value="<?=$notaentrega['observaciones']; ?>">
                                <input type="hidden" id="txt-observaciones-hidden" value="<?=$notaentrega['observaciones']; ?>">
                              </td>
                              <td colspan="4">
                                <div class="box-opt-editar-observacion">
                                  <span class="opt-editar-observacion editList">Editar</span>
                                </div>
                                <div class="box-opt-guardar-observacion d-none">
                                  <span class="opt-guardar-observacion editList" style='color:<?=$fucsia; ?>;'>Guardar</span>
                                  <span class="opt-cancelar-observacion editList" style="color:#000;">Cancelar</span>
                                </div>
                              </td>
                            </tr>
                          <?php //} ?>
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
                            <th style="text-align:left;width:58%;">Concepto</th>
                            <!-- <th style="text-align:left;width:10%;"></th> -->
                            <!-- <th style="text-align:left;width:10%;"></th> -->
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
                            $faltaDisponible=0;
                            if($notaentrega['estado_nota']==1){
                              // echo $pedido['id_pedido'];
                              // echo $id_pedido;
                              // $id_nota = $_GET['nota'];
                              $facturados = $lider->consultarQuery("SELECT * FROM operaciones, notasentrega WHERE operaciones.id_factura=notasentrega.id_nota_entrega and notasentrega.id_pedido={$id_pedido} and operaciones.modulo_factura='{$moduloFacturacion}' ORDER BY operaciones.id_operacion ASC;");
                              $facturadosDescontar=[];
                              $indexx=0;
                              foreach ($facturados as $facts) {
                                if(!empty($facts['id_pedido'])){
                                  $codFact=$facts['tipo_inventario'].$facts['id_inventario'];
                                  // print_r($facts);
                                  // echo "<br>";
                                  // echo "<br>";
                                  // echo "<br>";
                                  if(!empty($facturadosDescontar[$codFact])){
                                    if($facts['tipo_operacion']=="Salida"){
                                      $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                    }
                                    if($facts['tipo_operacion']=="Entrada"){
                                      $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                    }
                                  }else{
                                    $facturadosDescontar[$codFact]['cantidad']=0;
                                    $facturadosDescontar[$codFact]['tipo_operacion']=$facts['tipo_operacion'];
                                    $facturadosDescontar[$codFact]['tipo_inventario']=$facts['tipo_inventario'];
                                    $facturadosDescontar[$codFact]['id_inventario']=$facts['id_inventario'];
                                    $facturadosDescontar[$codFact]['concepto']=$facts['concepto_factura'];
                                    if($facts['tipo_operacion']=="Salida"){
                                      $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                    }
                                    if($facts['tipo_operacion']=="Entrada"){
                                      $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                    }
                                  }
                                }
                              }
                              // foreach ($facturadosDescontar as $key) {
                              //   print_r($key);
                              // }

                              $num = 1;
                              $premiosNotaEntrega=[];
                              $index=0;
                              foreach ($pedidos as $data){ 
                                if(!empty($data['id_pedido'])){
                                  // ========================== // =============================== // ============================== //
                                  $coleccionesPlanPremioPedido = [];
                                  // ========================== // =============================== // ============================== //
                                  foreach ($pagosRecorridos as $pagosR){
                                    $arrayMostrarNota = [];
                                    $arrayMostrarNota[$pagosR['name']] = [];
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
                                                  if($dataperdidos['id_pedido'] == $data['id_pedido']){
                                                    $comparedPlan = "";
                                                    if($dataperdidos['codigo']=="nombre"){
                                                      $comparedPlan = $data2['nombre_plan'];
                                                    }
                                                    if($dataperdidos['codigo']=="nombreid"){
                                                      $comparedPlan = $data2['id_plan'];
                                                    }
                                                    //if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                    //if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                    if( ($dataperdidos['valor'] == $comparedPlan) ){
                                                      $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                      // ========================== // =============================== // ============================== //
                                                      if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                                        if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                                          $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoResult;
                                                        }
                                                      }
                                                      // ========================== // =============================== // ============================== //
                                                      if($nuevoResult>0){
                                                        foreach ($premios_planes3 as $planstandard){
                                                          if ($planstandard['id_plan_campana']){
                                                            if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
                                                              if ($planstandard['tipo_premio']==$pagosR['name']){ ?>
                                                                  <?php 
                                                                    $planIDACT=$data2['id_plan'];
                                                                    $option = "";
                                                                    foreach ($optNotas as $opt){
                                                                      if(!empty($opt['id_opcion_entrega'])){
                                                                        if($opt['cod']==$planIDACT.$planstandard['id_premio']){
                                                                          $option = $opt['val'];
                                                                        }
                                                                      }
                                                                    }
                                                                  ?>
                                                                  <!-- STANDARD -->
                                                                  <!-- <tr class="codigo<?=$planIDACT;?><?=$planstandard['id_premio']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> > 
                                                                    <td class="col1">
                                                                      <?php echo $nuevoResult; ?>
                                                                    </td>
                                                                    <td class="col2">
                                                                      <?php echo $planstandard['producto']; ?>
                                                                    </td>
                                                                    <td class="col3">
                                                                      Premio de <?=$pagosR['name']; ?> <small style="font-size:.8em;">(Plan <?=$planstandard['nombre_plan']; ?>)</small>
                                                                    </td>
                                                                    <td class="col4">
                                                                    </td>
                                                                    <td class="col5">
                                                                    </td>
                                                                    <td>
                                                                      <select class="opciones" name="<?=$planIDACT;?><?=$planstandard['id_premio']?>">
                                                                        <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                                        <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                                                      </select>
                                                                    </td>
                                                                  </tr> -->
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
                                                              $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$data3['id_premio']}");
                                                              for ($i=0; $i < count($prinv)-1; $i++) { 
                                                                if($prinv[$i]['tipo_inventario']=="Productos"){
                                                                  $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                                }
                                                                if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                                  $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                                }
                                                                foreach ($inventario as $key) {
                                                                  if(!empty($key['elemento'])){
                                                                    $prinv[$i]['elemento']=$key['elemento'];
                                                                  }
                                                                }
                                                              }
                                                              foreach($prinv as $key){
                                                                if(!empty($key['id_premio_inventario'])){

                                                                  $nuevoResult = ($data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'])*$key['unidades_inventario'];
                                                                  // ========================== // =============================== // ============================== //
                                                                  $nuevoTSelected += $nuevoResult;
                                                                  // ========================== // =============================== // ============================== //
                                                                  if($nuevoResult>0){ ?>
                                                                    <?php 
                                                                      $option = "";
                                                                      // foreach ($optNotas as $opt){
                                                                      //   if(!empty($opt['id_opcion_entrega'])){
                                                                      //     if($opt['cod']=="P".$data3['id_plan'].$data3['id_premio']){
                                                                      //       $option = $opt['val'];
                                                                      //     }
                                                                      //   }
                                                                      // }
                                                                      $premiosNotaEntrega[$index]['cantidad']=$nuevoResult;
                                                                      $premiosNotaEntrega[$index]['descripcion']=$key['elemento'];
                                                                      // $premiosNotaEntrega[$index]['concepto']="Premios de ".$pagosR['name'];;
                                                                      $premiosNotaEntrega[$index]['concepto']=$pagosR['name'];;
                                                                      $premiosNotaEntrega[$index]['conceptoadd']=$data3['nombre_plan'];
                                                                      $premiosNotaEntrega[$index]['conceptoaddc']="Planes";
                                                                      $premiosNotaEntrega[$index]['codigo']="codigo".$key['id_premio_inventario'];
                                                                      $premiosNotaEntrega[$index]['id_premio']=$key['id_premio'];
                                                                      $premiosNotaEntrega[$index]['tipo_inventario']=$key['tipo_inventario'];
                                                                      $premiosNotaEntrega[$index]['id_inventario']=$key['id_inventario'];
                                                                      $premiosNotaEntrega[$index]['id_premio_inventario']=$key['id_premio_inventario'];
                                                                      $index++;
                                                                    ?>
                                                                      <!-- PRIMER PAGO -->
                                                                      <!-- <tr class="codigoP<?=$data3['id_plan'].$data3['id_premio']; ?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> >
                                                                        <td class="col1">
                                                                          <?php echo $nuevoResult; ?>
                                                                        </td>
                                                                        <td class="col2">
                                                                          <?php echo $data3['nombre_premio']; ?>
                                                                        </td>
                                                                        <td class="col3">
                                                                          Premio de <?=$pagosR['name']; ?> <small style="font-size:.8em;">(Plan <?=$data3['nombre_plan']; ?>)</small>
                                                                        </td>
                                                                        <td class="col4">
                                                                        </td>
                                                                        <td class="col5"></td>
                                                                        <td>
                                                                          <select class="opciones" name="opts[P<?=$data3['id_plan'].$data3['id_premio']; ?>]" id="P<?=$data3['id_plan'].$data3['id_premio']; ?>">
                                                                            <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                                            <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                                                          </select>
                                                                        </td>
                                                                      </tr> -->
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
                                      foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                        if ($data['id_pedido'] == $data2['id_pedido']){
                                          if ($data2['cantidad_coleccion_plan']>0){
                                            if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                              $opMaxDisp = 1;
                                              $seleccionado = $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'];
                                              $cantidadCols = $data2['cantidad_coleccion'] * $seleccionado;
                                              $premiosDispPlanSeleccion = $controladorPremios[$data2['nombre_plan']][$pagosR['name']];
                                              $multiDisponiblePremiosSeleccion = ($premiosDispPlanSeleccion*$cantidadCols);
                                              $maxDisponiblePremiosSeleccion += $multiDisponiblePremiosSeleccion;
                                              // echo $premiosDispPlanSeleccion."*".$cantidadCols." = ".$multiDisponiblePremiosSeleccion." Cols. de Plan ".$data2['nombre_plan']."<br>";
                                              // if($premiosDispPlanSeleccion==0){
                                              //   $opPlansinPremio = true;
                                              //   $cantidadRestar+=$cantidadCols;
                                              // }
                                            }
                                          }
                                        }
                                      } }
                                      if($opMaxDisp==0){
                                        $maxDisponiblePremiosSeleccion = -1;
                                      }
                                      // ========================== // =============================== // ============================== //
                                      foreach ($premios_perdidos as $dataperdidos) {
                                        if(!empty($dataperdidos['id_premio_perdido'])){
                                          //if(($dataperdidos['valor'] == $pagosR['id']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                          if($dataperdidos['id_pedido'] == $data['id_pedido']){
                                            // $posOrigin = strpos($dataperdidos['valor'], "_pago");
                                            // $posIDPago = strpos($dataperdidos['valor'], "_pago") + strlen("_pago");
                                            if(strtolower($pagosR['name'])=="inicial"){
                                              $posOrigin = strpos($dataperdidos['valor'], "cial");
                                              $posIDPago = strpos($dataperdidos['valor'], "cial") + strlen("cial");
                                            }else{
                                              $posOrigin = strpos($dataperdidos['valor'], "_pago");
                                              $posIDPago = strpos($dataperdidos['valor'], "_pago") + strlen("_pago");
                                            }
                                            $dataNamePerdido = substr($dataperdidos['valor'], 0, $posIDPago);
                                            $dataNamePerdidoIdPlan = substr($dataperdidos['valor'], $posIDPago);
                                            $dataComparar = "";
                                            if($posOrigin==""){
                                              $dataComparar = $dataperdidos['valor'];
                                            }else{
                                              $dataComparar = $dataNamePerdido;
                                            }
                                            if(($dataComparar == $pagosR['id'])){
                                              if($dataNamePerdidoIdPlan==""){
                                                $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
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
                                                if(!empty($dataperdidos['id_premio_perdido'])){
                                                  if($nuevoResult>0){
                                                    foreach ($premios_planes as $planstandard){
                                                      if (!empty($planstandard['id_plan_campana'])){
                                                        if ($planstandard['tipo_premio'] == $pagosR['name']){ 
                                                          $codigoPagoAdd = $pagosR['cod'].$planstandard['id_premio'];
                                                          $option = "";
                                                          foreach ($optNotas as $opt){
                                                            if(!empty($opt['id_opcion_entrega'])){
                                                              if($opt['cod']==$codigoPagoAdd){
                                                                $option = $opt['val'];
                                                              }
                                                            }
                                                          } 
                                                          if(!empty($arrayMostrarNota[$pagosR['name']][$planstandard['producto']])){
                                                            $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]['cantidad']+=($nuevoResult*$data2['cantidad_coleccion']);
                                                            $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]['planes'].=" | ".$data2['nombre_plan'];
                                                          }else{
                                                            $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]=[
                                                              'id'=>$planstandard['id_producto'],
                                                              'nombre'=>$planstandard['producto'],
                                                              'cantidad'=>($nuevoResult*$data2['cantidad_coleccion']),
                                                              'tipo'=>$pagosR['name'],
                                                              'planes'=>$data2['nombre_plan'],
                                                              'cod'=>$codigoPagoAdd,
                                                              'option'=>$option,
                                                            ];
                                                          }
                                                          ?>
                                                            <!-- <tr class="codigo<?=$codigoPagoAdd; ?>" <?php //if ($option=="N"){ ?> style='color:#DDD;' <?php //} ?> >
                                                              <td class="col1">
                                                                <?php //echo ($nuevoResult*$data2['cantidad_coleccion']); ?>
                                                              </td>
                                                              <td class="col2">
                                                                <?php //echo $planstandard['producto']; ?>
                                                              </td>
                                                              <td class="col3">
                                                                Premio de <?php //echo $pagosR['name']; ?>
                                                              </td>
                                                              <td class="col4">
                                                              </td>
                                                              <td class="col5">
                                                              </td>
                                                              <td>
                                                                <select class="opciones" name="<?=$codigoPagoAdd; ?>">
                                                                  <option <?php //if($option=="Y"){ ?> selected <?php  //} ?> value="Y">SI</option>
                                                                  <option <?php //if($option=="N"){ ?> selected <?php  //} ?> value="N">No</option>
                                                                </select>
                                                              </td>
                                                            </tr> -->
                                                          <?php 
                                                        }
                                                      }
                                                    }
                                                  }
                                                }
                                              }else{
                                                foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                                  if ($data['id_pedido'] == $data2['id_pedido']){
                                                    if ($data2['cantidad_coleccion_plan']>0){
                                                      if($dataNamePerdidoIdPlan==$data2['id_plan']){
                                                        if(!empty($dataperdidos['id_premio_perdido'])){
                                                          // echo $data2['cantidad_coleccion_plan']." | ";
                                                          $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
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
                                                          if($nuevoResult>0){
                                                            if(count($premios_planes3)>1){
                                                              foreach ($premios_planes3 as $premiosP) {
                                                                if(!empty($premiosP['nombre_plan'])){
                                                                  if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                                    if($pagosR['name']==$premiosP['tipo_premio']){
                                                                      $codigoPagoAdd = $pagosR['cod'].$premiosP['id_plan']."-".$premiosP['id_premio'];
                                                                      $codigoPagoAdd = $pagosR['cod'].$premiosP['id_premio'];

                                                                      $option = "";
                                                                      foreach ($optNotas as $opt){
                                                                        if(!empty($opt['id_opcion_entrega'])){
                                                                          if($opt['cod']==$codigoPagoAdd){
                                                                            $option = $opt['val'];
                                                                          }
                                                                        }
                                                                      } 

                                                                      if(!empty($arrayMostrarNota[$pagosR['name']][$premiosP['producto']])){
                                                                        $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]['cantidad']+=($nuevoResult*$data2['cantidad_coleccion']);
                                                                        $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]['planes'].=" | ".$premiosP['nombre_plan'];
                                                                      }else{
                                                                        $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]=[
                                                                          'id'=>$premiosP['id_premio'],
                                                                          'nombre'=>$premiosP['producto'],
                                                                          'cantidad'=>($nuevoResult*$data2['cantidad_coleccion']),
                                                                          'tipo'=>$premiosP['tipo_premio'],
                                                                          'planes'=>$premiosP['nombre_plan'],
                                                                          'cod'=>$codigoPagoAdd,
                                                                          'option'=>$option,
                                                                        ];
                                                                      }
                                                                      ?>
                                                                        <!-- <tr class="codigo<?=$codigoPagoAdd; ?>" <?php //if ($option=="N"){ ?> style='color:#DDD;' <?php //} ?> >
                                                                          <td class="col1">
                                                                            <?php //echo ($nuevoResult*$data2['cantidad_coleccion']); ?>
                                                                          </td>
                                                                          <td class="col2">
                                                                            <?php //echo $premiosP['producto']; ?>
                                                                          </td>
                                                                          <td class="col3">
                                                                            Premio de <?php //echo $premiosP['tipo_premio']." P. ".$premiosP['nombre_plan']; ?>
                                                                          </td>
                                                                          <td class="col4">
                                                                          </td>
                                                                          <td class="col5">
                                                                          </td>
                                                                          <td>
                                                                            <select class="opciones" name="<?=$codigoPagoAdd; ?>">
                                                                              <option <?php //if($option=="Y"){ ?> selected <?php  //} ?> value="Y">SI</option>
                                                                              <option <?php //if($option=="N"){ ?> selected <?php  //} ?> value="N">No</option>
                                                                            </select>
                                                                          </td>
                                                                        </tr> -->
                                                                      <?php 
                                                                    }
                                                                  }
                                                                }
                                                              }
                                                            }
                                                            if(count($premios_planes4)>1){
                                                              foreach ($premios_planes4 as $premiosP) {
                                                                // print_r($premiosP);
                                                                if(!empty($premiosP['nombre_plan'])){
                                                                  if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                                    if($pagosR['name']==$premiosP['tipo_premio']){
                                                                      $codigoPagoAdd = $pagosR['cod'].$premiosP['id_plan']."-".$premiosP['id_premio'];
                                                                      $codigoPagoAdd = $pagosR['cod'].$premiosP['id_premio'];


                                                                      $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$premiosP['id_premio']}");
                                                                      for ($i=0; $i < count($prinv)-1; $i++) { 
                                                                        if($prinv[$i]['tipo_inventario']=="Productos"){
                                                                          $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                                        }
                                                                        if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                                          $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                                        }
                                                                        foreach ($inventario as $key) {
                                                                          if(!empty($key['elemento'])){
                                                                            $prinv[$i]['elemento']=$key['elemento'];
                                                                          }
                                                                        }
                                                                      }

                                                                      // print_r($prinv[0]);
                                                                      // echo "<br><br>";
                                                                      foreach ($prinv as $key) {
                                                                        if(!empty($key['id_premio_inventario'])){
                                                                          if(!empty($arrayMostrarNota[$pagosR['name']][$key['id_premio_inventario']])){
                                                                            $arrayMostrarNota[$pagosR['name']][$key['id_premio_inventario']]['cantidad']+=($nuevoResult*$key['unidades_inventario']);
                                                                            $arrayMostrarNota[$pagosR['name']][$key['id_premio_inventario']]['planes'].=" | ".$premiosP['nombre_plan'];
                                                                          }else{
                                                                            $arrayMostrarNota[$pagosR['name']][$key['id_premio_inventario']]=[
                                                                              'id'=>$premiosP['id_premio'],
                                                                              'nombre'=>$premiosP['nombre_premio'],
                                                                              'elemento'=>$key['elemento'],
                                                                              'cantidad'=>($nuevoResult*$key['unidades_inventario']),
                                                                              'tipo'=>$premiosP['tipo_premio'],
                                                                              'planes'=>$premiosP['nombre_plan'],
                                                                              'id_premio_inventario'=>$key['id_premio_inventario'],
                                                                              'id_premio'=>$key['id_premio'],
                                                                              'tipo_inventario'=>$key['tipo_inventario'],
                                                                              'id_inventario'=>$key['id_inventario'],
                                                                              'cod'=>$codigoPagoAdd,
                                                                            ];
                                                                          }
                                                                        }
                                                                      }
                                                                      // echo $codigoPagoAdd."<br>";
                                                                      ?>
                                                                        <!-- <tr class="codigo<?=$codigoPagoAdd; ?>">
                                                                          <td class="col1">
                                                                            <?php //echo ($nuevoResult*$data2['cantidad_coleccion']); ?>
                                                                          </td>
                                                                          <td class="col2">
                                                                            <?php echo $premiosP['producto']; ?>
                                                                          </td>
                                                                          <td class="col3">
                                                                            Premio de <?php //echo $premiosP['tipo_premio']." P. ".$premiosP['nombre_plan']; ?>
                                                                          </td>
                                                                          <td class="col4">
                                                                          </td>
                                                                          <td class="col5">
                                                                          </td>
                                                                          <td>
                                                                            <select class="opciones" name="opts[<?=$codigoPagoAdd; ?>]" id="<?=$codigoPagoAdd; ?>">
                                                                              <option value="Y">SI</option>
                                                                              <option value="N">NO</option>
                                                                            </select>
                                                                          </td>
                                                                        </tr> -->
                                                                      <?php 
                                                                    }
                                                                  }
                                                                }
                                                              }
                                                            }
                                                            //echo "<br>";
                                                            // echo $data2['nombre_plan']." | ".$dataperdidos['id_premio_perdido']." | ".$nuevoResult." | <br>";
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                } }
                                              }
                                            }

                                            
                                          }
                                        }
                                      }


                                      // echo $pagosR['name']."<br>";
                                        // print_r($arrayMostrarNota);
                                        // echo "<br><br>";
                                        foreach ($arrayMostrarNota[$pagosR['name']] as $key) {
                                          // echo $key['nombre']." | ".$codigoPagoAdd." | ".$key['option']."<br>";
                                          $nameTPlan = "";
                                          $posiposi = strpos($key['planes'], "|");
                                          $nameTPlan = ($posiposi=='') ? 'Plan' : 'Planes';
                                          
                                          $premiosNotaEntrega[$index]['cantidad']=$key['cantidad'];
                                          $premiosNotaEntrega[$index]['descripcion']=$key['elemento'];
                                          // $premiosNotaEntrega[$index]['concepto']="Premios de ".$key['tipo'];
                                          $premiosNotaEntrega[$index]['concepto']=$key['tipo'];
                                          $premiosNotaEntrega[$index]['conceptoadd']=$key['planes'];
                                          $premiosNotaEntrega[$index]['conceptoaddc']="Planes";
                                          $premiosNotaEntrega[$index]['codigo']="codigo".$key['id_premio_inventario'];
                                          $premiosNotaEntrega[$index]['id_premio']=$key['id_premio'];
                                          $premiosNotaEntrega[$index]['tipo_inventario']=$key['tipo_inventario'];
                                          $premiosNotaEntrega[$index]['id_inventario']=$key['id_inventario'];
                                          $premiosNotaEntrega[$index]['id_premio_inventario']=$key['id_premio_inventario'];
                                          $index++;
                                          ?>
                                            <!-- <tr class="codigo<?=$key['cod']; ?>" <?php if ($key['option']=="N"){ ?> style='color:#DDD;' <?php } ?>>
                                              <td class="col1">
                                                <?php echo $key['cantidad']; ?>
                                              </td>
                                              <td class="col2">
                                                <?php echo $key['nombre']; ?>
                                              </td>
                                              <td class="col3">
                                                <?php
                                                ?>
                                                Premio de <?=$key['tipo']." <small style='font-size:.8em;'>(".$nameTPlan.": ".$key['planes'].")</small>"; ?>
                                              </td>
                                              <td class="col4">
                                              </td>
                                              <td class="col5">
                                              </td>
                                              <td>
                                                <select class="opciones" name="opts[<?=$key['cod']; ?>]" id="<?=$key['cod']; ?>">
                                                  <option <?php if($key['option']=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                  <option <?php if($key['option']=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                                </select>
                                              </td>
                                            </tr> -->
                                          <?php 
                                        }


                                    }
                                  }
                                  foreach ($retos as $reto){
                                    if (!empty($reto['id_reto'])){
                                      if ($reto['id_pedido']==$data['id_pedido']){
                                        $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$reto['id_premio']}");
                                        for ($i=0; $i < count($prinv)-1; $i++) { 
                                          if($prinv[$i]['tipo_inventario']=="Productos"){
                                            $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                          }
                                          if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                            $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                          }
                                          foreach ($inventario as $key) {
                                            if(!empty($key['elemento'])){
                                              $prinv[$i]['elemento']=$key['elemento'];
                                            }
                                          }
                                        }
                                        if ($reto['cantidad_retos']>0){
                                            foreach ($prinv as $key) {
                                              if(!empty($key['id_premio_inventario'])){

                                                $option = "";
                                                // foreach ($optNotas as $opt){ 
                                                //   if(!empty($opt['id_opcion_entrega'])){ 
                                                //     if($opt['cod']=="R".$reto['id_premio']){
                                                //        $option = $opt['val'];
                                                //     }
                                                //   }
                                                // }
                                                $premiosNotaEntrega[$index]['cantidad']=($reto['cantidad_retos']*$key['unidades_inventario']);
                                                    $premiosNotaEntrega[$index]['descripcion']=$key['elemento'];
                                                    // $premiosNotaEntrega[$index]['concepto']="Premios de Reto Junior";
                                                    $premiosNotaEntrega[$index]['concepto']="Reto Junior";
                                                    $premiosNotaEntrega[$index]['conceptoadd']=$reto['cantidad_coleccion']." colecciones";
                                                    $premiosNotaEntrega[$index]['conceptoaddc']="Por";
                                                    $premiosNotaEntrega[$index]['codigo']="codigo".$key['id_premio_inventario'];
                                                    $premiosNotaEntrega[$index]['id_premio']=$key['id_premio'];
                                                    $premiosNotaEntrega[$index]['tipo_inventario']=$key['tipo_inventario'];
                                                    $premiosNotaEntrega[$index]['id_inventario']=$key['id_inventario'];
                                                    $premiosNotaEntrega[$index]['id_premio_inventario']=$key['id_premio_inventario'];
                                                    $index++; 
                                              ?>
                                                  <!-- retos -->
                                                  <!-- <tr  class="codigoR<?=$reto['id_premio']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> >
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
                                                        <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                        <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                                      </select>
                                                    </td>
                                                  </tr> -->
                                              <?php 
                                              }
                                            }
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
                                          $option = "";
                                          foreach ($optNotas as $opt){ 
                                            if(!empty($opt['id_opcion_entrega'])){ 
                                              if($opt['cod']==$idPromo){
                                                $option = $opt['val'];
                                              }
                                            }
                                          }
                                        ?>
                                          <!-- retos -->
                                          <!-- <tr class="codigo<?=$idPromo; ?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> > 
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
                                              <select class="opciones" name="<?=$idPromo; ?>" id="<?=$idPromo; ?>">
                                                <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                              </select>
                                            </td>
                                          </tr> -->
                                        <?php
                                        }
                                      }
                                    } }
                                  }

                                  foreach ($premios_autorizados_obsequio as $premiosAutorizados){
                                    if (!empty($premiosAutorizados['id_PA'])){
                                      if ($premiosAutorizados['id_pedido']==$data['id_pedido']){
                                        $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$premiosAutorizados['id_premio']}");
                                          for ($i=0; $i < count($prinv)-1; $i++) { 
                                            if($prinv[$i]['tipo_inventario']=="Productos"){
                                              $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                            }
                                            if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                              $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                            }
                                            foreach ($inventario as $key) {
                                              if(!empty($key['elemento'])){
                                                $prinv[$i]['elemento']=$key['elemento'];
                                              }
                                            }
                                          }
                                        if ($premiosAutorizados['cantidad_PA']>0){
                                            foreach ($prinv as $key) {
                                              if(!empty($key['id_premio_inventario'])){

                                                $option = "";
                                                foreach ($optNotas as $opt){ 
                                                  if(!empty($opt['id_opcion_entrega'])){ 
                                                    if($opt['cod']=="PA".$premiosAutorizados['id_PA']){
                                                      $option = $opt['val'];
                                                    }
                                                  }
                                                } 
                                                $concepto = "";
                                                if($premiosAutorizados['descripcion_PA']==""){
                                                  $concepto= $premiosAutorizados['firma_PA'];
                                                }else{
                                                  $concepto= $premiosAutorizados['descripcion_PA'];
                                                }
                                                $premiosNotaEntrega[$index]['cantidad']=($premiosAutorizados['cantidad_PA']*$key['unidades_inventario']);
                                                $premiosNotaEntrega[$index]['descripcion']=$key['elemento'];
                                                // $premiosNotaEntrega[$index]['concepto']="Premios autorizados";
                                                if(!empty($premiosAutorizados['descripcion_PA'])){
                                                  $premiosNotaEntrega[$index]['concepto']=$premiosAutorizados['descripcion_PA'];
                                                }else{
                                                  $premiosNotaEntrega[$index]['concepto']="Premios autorizados";
                                                }
                                                $premiosNotaEntrega[$index]['conceptoadd']=$concepto;
                                                $premiosNotaEntrega[$index]['conceptoaddc']="";
                                                $premiosNotaEntrega[$index]['codigo']="codigo".$key['id_premio_inventario'];
                                                $premiosNotaEntrega[$index]['id_premio']=$key['id_premio'];
                                                $premiosNotaEntrega[$index]['tipo_inventario']=$key['tipo_inventario'];
                                                $premiosNotaEntrega[$index]['id_inventario']=$key['id_inventario'];
                                                $premiosNotaEntrega[$index]['id_premio_inventario']=$key['id_premio_inventario'];
                                                $index++;
                                              ?>
                                                  <!-- retos -->
                                                  <!-- <tr class="codigoPA<?=$premiosAutorizados['id_PA']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> > 
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
                                                        <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                        <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                                      </select>
                                                    </td>
                                                  </tr> -->
                                              <?php 
                                              }
                                            }
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
                                      $arrayt[$numCC]['id_premio'] = $canUnic['id_premio'];
                                      $numCC++;
                                    }
                                  }
                                  foreach ($canjeos as $canje){
                                    if (!empty($canje['id_cliente'])){
                                      if ($canje['id_cliente']==$data['id_cliente']){
                                        for ($i=0; $i < count($arrayt); $i++) { 
                                          if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
                                              $arrayt[$i]['cantidad']+=$canje['unidades'];
                                              // $arrayt[$i]['cantidad']++;
                                          }
                                        }
                                      }
                                    }
                                  }
                                  foreach ($arrayt as $canjeos){
                                    if (!empty($canjeos['id_catalogo'])){
                                        $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$canjeos['id_premio']}");
                                        for ($i=0; $i < count($prinv)-1; $i++) { 
                                          if($prinv[$i]['tipo_inventario']=="Productos"){
                                            $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                          }
                                          if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                            $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                          }
                                          foreach ($inventario as $key) {
                                            if(!empty($key['elemento'])){
                                              $prinv[$i]['elemento']=$key['elemento'];
                                            }
                                          }
                                        }
                                        if($canjeos['id_premio']==-1){
                                          $prinv[0]['elemento']=$canjeos['nombre'];
                                          $prinv[0]['unidades_inventario']=1;
                                          $prinv[0]['id_premio_inventario']=$canjeos['id_catalogo'];
                                          $prinv[0]['id_premio']=$canjeos['id_catalogo'];
                                          $prinv[0]['tipo_inventario']="Catalogos";
                                          $prinv[0]['id_inventario']=$canjeos['id_catalogo'];
                                        }
                                        if ($canjeos['cantidad']>0){
                                          foreach ($prinv as $key) {
                                            if(!empty($key['id_premio_inventario'])){
                                              $option = "";
                                              foreach ($optNotas as $opt){ 
                                                if(!empty($opt['id_opcion_entrega'])){ 
                                                  if($opt['cod']=="CG".$canjeos['id_catalogo']){
                                                    $option = $opt['val'];
                                                  }
                                                }
                                              } 
                                              $premiosNotaEntrega[$index]['cantidad']=($canjeos['cantidad']*$key['unidades_inventario']);
                                                $premiosNotaEntrega[$index]['descripcion']=$key['elemento'];
                                                $premiosNotaEntrega[$index]['concepto']="Premios Canjeados";
                                                $premiosNotaEntrega[$index]['conceptoadd']="";
                                                $premiosNotaEntrega[$index]['conceptoaddc']="";
                                                $premiosNotaEntrega[$index]['codigo']="codigo".$key['id_premio_inventario'];
                                                $premiosNotaEntrega[$index]['id_premio']=$key['id_premio'];
                                                $premiosNotaEntrega[$index]['tipo_inventario']=$key['tipo_inventario'];
                                                $premiosNotaEntrega[$index]['id_inventario']=$key['id_inventario'];
                                                $premiosNotaEntrega[$index]['id_premio_inventario']=$key['id_premio_inventario'];
                                                $index++;
                                            ?>
                                            <!-- canjeoss -->
                                            <!-- <tr class="codigoCG<?=$canjeos['id_catalogo']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?>>
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
                                                  <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                  <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                                </select>
                                              </td>
                                            </tr> -->
                                            <?php 
                                            }
                                          }
                                        }
                                    }
                                  }
                                  $num++;
                                }
                              }
                              $notaResumida = [];
                              $index=0;
                              foreach ($premiosNotaEntrega as $nota) {
                                // print_r($nota['id_premio_inventario']);
                                if(!empty($notaResumida[$nota['tipo_inventario'].$nota['id_inventario']])){
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad']+=$nota['cantidad'];
                                  if($notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['concepto']!=$nota['concepto']){
                                    $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'].=", ".$nota['concepto'];
                                  }
                                  if($notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['conceptoadd']!=$nota['conceptoadd']){
                                    $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['conceptoadd'].=", ".$nota['conceptoadd'];
                                  }
                                }else{
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad']=$nota['cantidad'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion']=$nota['descripcion'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['concepto']=$nota['concepto'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['conceptoadd']=$nota['conceptoadd'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['conceptoaddc']=$nota['conceptoaddc'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['codigo']="codigo".$nota['tipo_inventario'].$nota['id_inventario'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario']=$nota['id_inventario'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario']=$nota['tipo_inventario'];
                                  $notaResumida[$nota['tipo_inventario'].$nota['id_inventario']]['id_premio_inventario']=$nota['id_premio_inventario'];
                                }
                                // print_r($notaResumida);
                              }

                              $mostrarListaNotas=[];
                              $reiterador=0;
                              $limiteDisponibles=[];
                              
                              
                              $mostrarNotasResumidas = [];
                              $yafact=0;
                              $notasFacturadas = $lider->consultarQuery("SELECT id_nota_entrega FROM notasentrega WHERE id_pedido={$id_pedido}");
                              $filterNotasFact="";
                              foreach ($notasFacturadas as $ntfa) {
                                if(!empty($ntfa['id_nota_entrega'])){
                                  if($filterNotasFact!=""){
                                    $filterNotasFact.=", ";
                                  }
                                  $filterNotasFact.=$ntfa['id_nota_entrega'];
                                }
                              }

                                  // print_r($notasFacturadas);
                              foreach ($notaResumida as $nota) {
                                $option = "";
                                foreach ($optNotas as $opt){
                                  if(!empty($opt['id_opcion_entrega'])){ 
                                    // print_r($opt);
                                    // echo "<br><br>";
                                    // echo "COD: ".$opt['cod']."<br>";
                                    if($opt['cod']==$nota['tipo_inventario'].$nota['id_inventario']){
                                      $option = $opt['val'];
                                    }
                                  }
                                }
                                $disponibleOrNot = true;
                                foreach ($productoss as $key) {
                                  if($nota['tipo_inventario']=='Productos'){
                                    if($nota['id_inventario']==$key['id_producto']){
                                      if($nota['cantidad']>$key['stock_disponible']){
                                        if($notaentrega['estado_nota']==1){
                                          $disponibleOrNot=false;
                                        }
                                      }else{
                                        $disponibleOrNot=true;
                                      }
                                    }
                                  }
                                }
      
                                foreach ($mercancias as $key) {
                                  if($nota['tipo_inventario']=='Mercancia'){
                                    if($nota['id_inventario']==$key['id_mercancia']){
                                      // echo $nota['descripcion']." | ".$nota['cantidad']." | ".$key['stock_disponible']."<br><br>";
                                      if($nota['cantidad']>$key['stock_disponible']){
                                        if($notaentrega['estado_nota']==1){
                                          $disponibleOrNot=false;
                                        }
                                      }else{
                                        $disponibleOrNot=true;
                                      }
                                    }
                                  }
                                }
                                // echo "aaaa";
                                // echo $_GET['nota'];
                                $codigoId=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                $notasHabilitadasOInhabilitadas=$lider->consultarQuery("SELECT * FROM notas_habilitadas WHERE id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$codigoId}'");
                                // print_r($notasHabilitadasOInhabilitadas);
                                $habilitadoOrInhabilitado=true;
                                foreach ($notasHabilitadasOInhabilitadas as $habOrInhab) {
                                  if(!empty($habOrInhab['id_pedido'])){
                                    if($habOrInhab['estado']==1){
                                      $habilitadoOrInhabilitado=true;
                                    }
                                    if($habOrInhab['estado']==0){
                                      $habilitadoOrInhabilitado=false;
                                    }
                                  }
                                }
                                $id_unico = $nota['cantidad']."*".$nota['tipo_inventario']."*".$nota['id_inventario'];
                                $notasModificada = $lider->consultarQuery("SELECT * FROM notas_modificada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$id_unico}'");
                                if(count($notasModificada)>1){
                                  foreach ($notasModificada as $notaModif) {
                                    if(!empty($notaModif['id_nota_modificada'])){
                                      // print_r($nota);
                                      // echo "<br><br>";
                                      // print_r($notaModif);
                                      // echo "<br><br>";
                                      
                                      $nota['id_inventario']=$notaModif['id_inventario'];
                                      $nota['cantidad']=$notaModif['stock'];
                                      $nota['tipo_inventario'] = $notaModif['tipo_inventario'];
                                      $nota['delete'] = $notaModif['id_nota_modificada'];
                                      $nota['precio_venta'] = $notaModif['precio_venta'];
                                      $nota['precio_nota'] = $notaModif['precio_nota'];
                                      if($notaModif['tipo_inventario']=="Productos"){
                                        $prinv = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$notaModif['id_inventario']}");
                                        foreach($prinv as $inv){ if(!empty($inv['id_producto'])){
                                          $nota['descripcion'] = $inv['elemento'];
                                        } }
                                      }
                                      if($notaModif['tipo_inventario']=="Mercancia"){
                                        $prinv = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$notaModif['id_inventario']}");
                                        foreach($prinv as $inv){ if(!empty($inv['id_mercancia'])){
                                          $nota['descripcion'] = $inv['elemento'];
                                        } }
                                      }
                                      $disponibleOrNot = true;
                                      foreach ($productoss as $key) {
                                        if($nota['tipo_inventario']=='Productos'){
                                          if($nota['id_inventario']==$key['id_producto']){
                                            if($nota['cantidad']>$key['stock_disponible']){
                                              if($notaentrega['estado_nota']==1){
                                                $disponibleOrNot=false;
                                              }
                                            }else{
                                              $disponibleOrNot=true;
                                            }
                                          }
                                        }
                                      }
                                      
                                      foreach ($mercancias as $key) {
                                        if($nota['tipo_inventario']=='Mercancia'){
                                          if($nota['id_inventario']==$key['id_mercancia']){
                                            // echo $nota['descripcion']." | ".$nota['cantidad']." | ".$key['stock_disponible']."<br><br>";
                                            if($nota['cantidad']>$key['stock_disponible']){
                                              if($notaentrega['estado_nota']==1){
                                                $disponibleOrNot=false;
                                              }
                                            }else{
                                              $disponibleOrNot=true;
                                            }
                                          }
                                        }
                                      }

                                      $codigoId=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                      $notasHabilitadasOInhabilitadas=$lider->consultarQuery("SELECT * FROM notas_habilitadas WHERE id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$codigoId}'");
                                      // print_r($notasHabilitadasOInhabilitadas);
                                      $habilitadoOrInhabilitado=true;
                                      foreach ($notasHabilitadasOInhabilitadas as $habOrInhab) {
                                        if(!empty($habOrInhab['id_pedido'])){
                                          if($habOrInhab['estado']==1){
                                            $habilitadoOrInhabilitado=true;
                                          }
                                          if($habOrInhab['estado']==0){
                                            $habilitadoOrInhabilitado=false;
                                          }
                                        }
                                      }
                                      if(!empty($facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']])){
                                        $comprobar = $facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']];
                                        // if($comprobar['tipo_operacion']=="Salida"){
                                        //   $nota['cantidad']-=$comprobar['cantidad'];
                                        // }
                                        // if($comprobar['tipo_operacion']=="Entrada"){
                                        //   $nota['cantidad']+=$comprobar['cantidad'];
                                        // }
                                        $nota['cantidad']-=$comprobar['cantidad'];
                                      }
                                      if(!$disponibleOrNot){
                                        if($notaentrega['estado_nota']==1){
                                          if($habilitadoOrInhabilitado){
                                            if($nota['cantidad']>0){
                                              $faltaDisponible++;
                                            }
                                          }
                                        }
                                      }

                                      if($nota['tipo_inventario']=="Mercancia"){
                                        if(!empty($limiteDisponibles['cantidadm'.$notaModif['id_inventario']])){
                                          $limiteDisponibles['cantidadm'.$notaModif['id_inventario']]+=$nota['cantidad'];
                                        }else{
                                          $limiteDisponibles['cantidadm'.$notaModif['id_inventario']]=$nota['cantidad'];
                                        }
                                        $limiteDisponibles['descripcionm'.$notaModif['id_inventario']]=$nota['descripcion'];
                                      }else{
                                        if(!empty($limiteDisponibles['cantidad'.$notaModif['id_inventario']])){
                                          $limiteDisponibles['cantidad'.$notaModif['id_inventario']]+=$nota['cantidad'];
                                        }else{
                                          $limiteDisponibles['cantidad'.$notaModif['id_inventario']]=$nota['cantidad'];
                                        }
                                        $limiteDisponibles['descripcion'.$notaModif['id_inventario']]=$nota['descripcion'];
                                      }

                                      $mostrarListaNotas[$reiterador]['cantidad']=$nota['cantidad'];
                                      $mostrarListaNotas[$reiterador]['descripcion']=$nota['descripcion'];
                                      $mostrarListaNotas[$reiterador]['concepto']=$nota['concepto'];
                                      $mostrarListaNotas[$reiterador]['tipo_inventario']=$nota['tipo_inventario'];
                                      $mostrarListaNotas[$reiterador]['id_inventario']=$nota['id_inventario'];
                                      $reiterador++;
                                      


                                      
                                      if($notaentrega['estado_nota']==1){
                                        
                                        if($nota['cantidad']>0){
                                          // $nota['precio_venta']=0;
                                          // $nota['precio_nota']=0;
                                          // foreach ($lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio_inventario={$nota['id_premio_inventario']}") as $priceNota) {
                                          //   if(!empty($priceNota['precio_notas'])){
                                          //     $nota['precio_venta']=$priceNota['precio_inventario'];
                                          //     $nota['precio_nota']=$priceNota['precio_notas'];
                                          //   }
                                          // }
                                          if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                            // $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                          }else{

                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario']; 
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota']; 
                                            $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precio_venta']; 
                                          }
                                          ?>
                                            <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                              <?php
                                                if(!$habilitadoOrInhabilitado){ echo "text-decoration: line-through !important; color:#777 !important"; }else{
                                                  if ($option=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                                  else if($option=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                                  else if($option=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                                }
                                              ?>
                                            '>
                                              <td class="col1">
                                                <?=$nota['cantidad']; ?>
                                              </td>
                                              <td class="col2">
                                                <?=$nota['descripcion']; ?>
                                                <small style='font-size:0.9em;'>
                                                  <br>
                                                  <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precio_venta'],2,',','.').")"; ?>
                                                  <?="(Nota: ".number_format($nota['precio_nota'],2,',','.').")"; ?>
                                                </small>
                                              </td>
                                              <td class="col3">
                                                <?php
                                                  echo "Premios de ".$nota['concepto'];
                                                  $urlBorrarFact = $menuPersonalizado."delete=".$nota['delete'];
                                                  $urlInhabilitar=$menuPersonalizado."inhab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                                  $urlHabilitar=$menuPersonalizado."hab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                                  if($habilitadoOrInhabilitado){
                                                    ?>
                                                      <a href="?<?=$urlInhabilitar; ?>" class="inhabilitarList">
                                                        <span><u>Inhabilitar</u></span>
                                                      </a>
                                                      <a href="?<?=$urlBorrarFact; ?>">
                                                        <span title="<?=$nota['descripcion']; ?>" class='errors BorrarList'>
                                                          Borrar 
                                                        </span>
                                                      </a>
                                                    <?php
                                                  }else{
                                                    ?>
                                                      <a href="?<?=$urlHabilitar; ?>" class="habilitarList">
                                                        <span><u>Habilitar</u></span>
                                                      </a>
                                                    <?php
                                                  }
                                                ?>
                                              </td>
                                              <td>
                                                <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                                  <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                  <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                                </select>
                                              </td>
                                            </tr>
                                          <?php
                                        }
                                      }

                                    }
                                  }
                                } else{
                                  
                                  if($nota['tipo_inventario']=="Mercancia"){
                                    if(!empty($limiteDisponibles['cantidadm'.$nota['id_inventario']])){
                                      $limiteDisponibles['cantidadm'.$nota['id_inventario']]+=$nota['cantidad'];
                                    }else{
                                      $limiteDisponibles['cantidadm'.$nota['id_inventario']]=$nota['cantidad'];
                                    }
                                    $limiteDisponibles['descripcionm'.$nota['id_inventario']]=$nota['descripcion'];
                                  }else{
                                    if(!empty($limiteDisponibles['cantidad'.$nota['id_inventario']])){
                                      $limiteDisponibles['cantidad'.$nota['id_inventario']]+=$nota['cantidad'];
                                    }else{
                                      $limiteDisponibles['cantidad'.$nota['id_inventario']]=$nota['cantidad'];
                                    }
                                    $limiteDisponibles['descripcion'.$nota['id_inventario']]=$nota['descripcion'];
                                  }

                                  if(!empty($facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']])){
                                    $comprobar = $facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']];
                                    // if($comprobar['tipo_operacion']=="Salida"){
                                    //   echo "ANTES 2 :".$nota['cantidad']." | ";
                                    //   $nota['cantidad']-=$comprobar['cantidad'];
                                    //   echo "DESPUES 2 :".$nota['cantidad']." | ";
                                    // }
                                    // if($comprobar['tipo_operacion']=="Entrada"){
                                    //   echo "ANTES 3 :".$nota['cantidad']." | ";
                                    //   $nota['cantidad']+=$comprobar['cantidad'];
                                    //   echo "DESPUES 3 :".$nota['cantidad']." | ";
                                    // }
                                    $nota['cantidad']-=$comprobar['cantidad'];
                                  }

                                  $queryModificadasFacturadas="SELECT * FROM notas_modificada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and codigo_identificador='{$id_unico}' and id_nota_entrega IN ({$filterNotasFact})";
                                  $notasModificadaFacturadas = $lider->consultarQuery($queryModificadasFacturadas);
                                  $busquedaFact=[];
                                  if(count($notasModificadaFacturadas)>1){
                                    $busquedaFact = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$nameModuloFactu}' and id_factura={$notasModificadaFacturadas[0]['id_nota_entrega']} and id_inventario={$notasModificadaFacturadas[0]['id_inventario']} and tipo_inventario='{$notasModificadaFacturadas[0]['tipo_inventario']}'");
                                    if(count($busquedaFact)>1){
                                      $nota['cantidad']=0;
                                    }
                                  }

                                  if(!$disponibleOrNot){
                                    if($notaentrega['estado_nota']==1){
                                      if($habilitadoOrInhabilitado){
                                        if($nota['cantidad']>0){
                                          // if($noFacturadoAun){
                                            $faltaDisponible++;
                                          // }
                                        }
                                      }
                                    }
                                  }
                                  $mostrarListaNotas[$reiterador]['cantidad']=$nota['cantidad'];
                                  $mostrarListaNotas[$reiterador]['descripcion']=$nota['descripcion'];
                                  $mostrarListaNotas[$reiterador]['concepto']=$nota['concepto'];
                                  $mostrarListaNotas[$reiterador]['tipo_inventario']=$nota['tipo_inventario'];
                                  $mostrarListaNotas[$reiterador]['id_inventario']=$nota['id_inventario'];
                                  $mostrarListaNotas[$reiterador]['id_premio_inventario']=$nota['id_premio_inventario'];
                                  $reiterador++;
                                  
                                  if($notaentrega['estado_nota']==1){
                                    
                                    if($nota['cantidad']>0){
                                      // echo $nota['id_premio_inventario']."<br>";
                                      $nota['precio_venta']=0;
                                      $nota['precio_nota']=0;
                                      foreach ($lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio_inventario={$nota['id_premio_inventario']}") as $priceNota) {
                                        if(!empty($priceNota['precio_notas'])){
                                          $nota['precio_venta']=$priceNota['precio_inventario'];
                                          $nota['precio_nota']=$priceNota['precio_notas'];
                                        }
                                      }
                                      if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                        // $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                      }else{
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precio_venta']; 
                                      }
                                      ?>
                                        <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                          <?php
                                            if(!$habilitadoOrInhabilitado){ echo "text-decoration: line-through !important; color:#777 !important"; }else{
                                              if ($option=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                              else if($option=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                              else if($option=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                            }
                                          ?>
                                        '>
                                          <td class="col1">
                                            <?=$nota['cantidad']; ?>
                                          </td>
                                          <td class="col2">
                                            <?=$nota['descripcion']; ?>
                                            <small style='font-size:0.9em;'>
                                              <br>
                                              <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precio_venta'],2,',','.').")"; ?>
                                              <?="(Nota: ".number_format($nota['precio_nota'],2,',','.').")"; ?>
                                            </small>
                                          </td>
                                          <td class="col3">
                                            <?php
                                              echo "Premios de ".$nota['concepto'];
                                              $urlInhabilitar=$menuPersonalizado."inhab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                              $urlHabilitar=$menuPersonalizado."hab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                              if($habilitadoOrInhabilitado){
                                                ?>
                                                <a href="?<?=$urlInhabilitar; ?>" class="inhabilitarList">
                                                  <span><u>Inhabilitar</u></span>
                                                </a>
                                                <?php
                                                if(!$disponibleOrNot){
                                                  $urlEditFact = $menuPersonalizado."&i=".$nota['tipo_inventario']."&e=".$nota['id_inventario']."&pc=".$nota['cantidad']."&prv=".$nota['precio_venta']."&prn=".$nota['precio_nota']; 
                                                  if($notaentrega['estado_nota']==1){
                                                  ?>
                                                  <a href="?<?=$urlEditFact; ?>">
                                                      <span title="<?=$nota['descripcion']; ?>" class='editList'>
                                                          Editar 
                                                          <?php //$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>
                                                      </span>
                                                  </a>

                                                  <?php
                                                  }
                                                }
                                              } else {
                                                ?>
                                                  <a href="?<?=$urlHabilitar; ?>" class="habilitarList">
                                                    <span><u>Habilitar</u></span>
                                                  </a>
                                                <?php
                                              }
                                                ?>
                                          </td>
                                          <td>
                                            <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                              <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                              <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                            </select>
                                          </td>
                                        </tr>
                                      <?php
                                    }
                                  }
                                }
                                
                              }
                              $notasModificada = $lider->consultarQuery("SELECT * FROM notas_modificada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador=''");
                              // print_r($notasModificada);
                              $nota=[];
                              foreach ($notasModificada as $notaModif) {
                                if(!empty($notaModif['id_nota_modificada'])){
                                  $option="Y";
                                  $nota['cantidad']=$notaModif['stock'];
                                  $nota['delete']=$notaModif['id_nota_modificada'];
                                  if($notaModif['tipo_inventario']=="Productos"){
                                    $prinv = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$notaModif['id_inventario']}");
                                    foreach($prinv as $inv){ if(!empty($inv['id_producto'])){
                                      $nota['descripcion'] = $inv['elemento'];
                                    } }
                                  }
                                  if($notaModif['tipo_inventario']=="Mercancia"){
                                    $prinv = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$notaModif['id_inventario']}");
                                    foreach($prinv as $inv){ if(!empty($inv['id_mercancia'])){
                                      $nota['descripcion'] = $inv['elemento'];
                                    } }
                                  }
                                  $nota['concepto'] = "Premios Adicionales";
                                  $nota['conceptoadd'] = "";
                                  $nota['conceptoaddc'] = "";
                                  $nota['codigo'] = "codigo".$notaModif['tipo_inventario'].$notaModif['id_inventario'];
                                  $nota['id_inventario']=$notaModif['id_inventario'];
                                  $nota['tipo_inventario'] = $notaModif['tipo_inventario'];
                                  $nota['delete'] = $notaModif['id_nota_modificada'];
                                  $nota['precio_venta'] = $notaModif['precio_venta'];
                                  $nota['precio_nota'] = $notaModif['precio_nota'];
                                  
                                  $disponibleOrNot = true;
                                  foreach ($productoss as $key) {
                                    if($nota['tipo_inventario']=='Productos'){
                                      if($nota['id_inventario']==$key['id_producto']){
                                        if($nota['cantidad']>$key['stock_disponible']){
                                          if($notaentrega['estado_nota']==1){
                                            $disponibleOrNot=false;
                                          }
                                        }else{
                                          $disponibleOrNot=true;
                                        }
                                      }
                                    }
                                  }
        
                                  foreach ($mercancias as $key) {
                                    if($nota['tipo_inventario']=='Mercancia'){
                                      if($nota['id_inventario']==$key['id_mercancia']){
                                        // echo $nota['descripcion']." | ".$nota['cantidad']." | ".$key['stock_disponible']."<br><br>";
                                        if($nota['cantidad']>$key['stock_disponible']){
                                          if($notaentrega['estado_nota']==1){
                                            $disponibleOrNot=false;
                                          }
                                        }else{
                                          $disponibleOrNot=true;
                                        }
                                      }
                                    }
                                  }
                                  $codigoId=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                  $notasHabilitadasOInhabilitadas=$lider->consultarQuery("SELECT * FROM notas_habilitadas WHERE id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$codigoId}'");
                                  // print_r($notasHabilitadasOInhabilitadas);
                                  $habilitadoOrInhabilitado=true;
                                  foreach ($notasHabilitadasOInhabilitadas as $habOrInhab) {
                                    if(!empty($habOrInhab['id_pedido'])){
                                      if($habOrInhab['estado']==1){
                                        $habilitadoOrInhabilitado=true;
                                      }
                                      if($habOrInhab['estado']==0){
                                        $habilitadoOrInhabilitado=false;
                                      }
                                    }
                                  }
                                  if(!empty($facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']])){
                                    $comprobar = $facturadosDescontar[$nota['tipo_inventario'].$nota['id_inventario']];
                                    $nota['cantidad']-=$comprobar['cantidad'];
                                    // if($comprobar['tipo_operacion']=="Salida"){
                                    //   $nota['cantidad']-=$comprobar['cantidad'];
                                    // }
                                    // if($comprobar['tipo_operacion']=="Entrada"){
                                    //   $nota['cantidad']+=$comprobar['cantidad'];
                                    // }
                                  }
                                  if(!$disponibleOrNot){
                                    if($notaentrega['estado_nota']==1){
                                      if($habilitadoOrInhabilitado){
                                        if($nota['cantidad']>0){
                                          $faltaDisponible++;
                                        }
                                      }
                                    }
                                  }

                                  if($nota['tipo_inventario']=="Mercancia"){
                                    if(!empty($limiteDisponibles['cantidadm'.$notaModif['id_inventario']])){
                                      $limiteDisponibles['cantidadm'.$notaModif['id_inventario']]+=$nota['cantidad'];
                                    }else{
                                      $limiteDisponibles['cantidadm'.$notaModif['id_inventario']]=$nota['cantidad'];
                                    }
                                    $limiteDisponibles['descripcionm'.$notaModif['id_inventario']]=$nota['descripcion'];
                                  }else{
                                    if(!empty($limiteDisponibles['cantidad'.$notaModif['id_inventario']])){
                                      $limiteDisponibles['cantidad'.$notaModif['id_inventario']]+=$nota['cantidad'];
                                    }else{
                                      $limiteDisponibles['cantidad'.$notaModif['id_inventario']]=$nota['cantidad'];
                                    }
                                    $limiteDisponibles['descripcion'.$notaModif['id_inventario']]=$nota['descripcion'];
                                  }

                                  $mostrarListaNotas[$reiterador]['cantidad']=$nota['cantidad'];
                                  $mostrarListaNotas[$reiterador]['descripcion']=$nota['descripcion'];
                                  $mostrarListaNotas[$reiterador]['concepto']=$nota['concepto'];
                                  $mostrarListaNotas[$reiterador]['tipo_inventario']=$nota['tipo_inventario'];
                                  $mostrarListaNotas[$reiterador]['id_inventario']=$nota['id_inventario'];
                                  $reiterador++;
                                  


                                  
                                  if($notaentrega['estado_nota']==1){
                                    
                                    if($nota['cantidad']>0){
                                      if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                      }else{
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota']; 
                                        $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precio_venta']; 
                                      }
                                      ?>
                                        <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                          <?php
                                            if(!$habilitadoOrInhabilitado){ echo "text-decoration: line-through !important; color:#777 !important"; }else{
                                              if ($option=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                              else if($option=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                              else if($option=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                            }
                                            
                                          ?>
                                        '>
                                          <td class="col1">
                                            <?=$nota['cantidad']; ?>
                                          </td>
                                          <td class="col2">
                                            <?=$nota['descripcion']; ?>
                                            <small style='font-size:0.9em;'>
                                              <br>
                                              <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precio_venta'],2,',','.').")"; ?>
                                              <?="(Nota: ".number_format($nota['precio_nota'],2,',','.').")"; ?>
                                            </small>
                                          </td>
                                          <td class="col3">
                                            <?php
                                              echo $nota['concepto'];
                                              // if(!$disponibleOrNot){
                                                $urlBorrarFact = $menuPersonalizado."delete=".$nota['delete'];
                                                $urlInhabilitar=$menuPersonalizado."inhab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                                $urlHabilitar=$menuPersonalizado."hab=".$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario'];
                                                // $urlEditFact = $menuPersonalizado."&i=".$nota['tipo_inventario']."&e=".$nota['id_inventario']."&pc=".$nota['cantidad']; 
                                                if($notaentrega['estado_nota']==1){
                                                  if($habilitadoOrInhabilitado){
                                                    ?>
                                                    <a href="?<?=$urlInhabilitar; ?>" class="inhabilitarList">
                                                      <span><u>Inhabilitar</u></span>
                                                    </a>
                                                    <a href="?<?=$urlBorrarFact; ?>">
                                                      <span title="<?=$nota['descripcion']; ?>" class='errors BorrarList'>
                                                        Borrar 
                                                      </span>
                                                    </a>
                                                    <?php
                                                  } else{
                                                    ?>
                                                    <a href="?<?=$urlHabilitar; ?>" class="habilitarList">
                                                      <span><u>Habilitar</u></span>
                                                    </a>
                                                    <?php
                                                  }
                                                }
                                              // }
                                            ?>
                                          </td>
                                          <td>
                                            <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                              <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                              <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                            </select>
                                          </td>
                                        </tr>
                                      <?php
                                    }
                                  }
                                }
                              }
                              
                              // foreach ($mostrarNotasResumidas as $key) {
                              //   print_r($key);
                              //   echo "<br><br>";
                              // }
                            }
                            if($notaentrega['estado_nota']==0){
                              // print_r($mostrarNotasResumidas);
                              // $mostrarNotasResumidas = $_SESSION['mostrarNotasResumidas'];
                              // $id_nota = $_GET['nota'];
                              // $nameModuloFactu="Notas";
                              $facturados = $lider->consultarQuery("SELECT * FROM operaciones, notasentrega WHERE operaciones.id_factura=notasentrega.id_nota_entrega and notasentrega.id_nota_entrega={$id_nota} and operaciones.id_factura={$id_nota} and operaciones.modulo_factura='{$moduloFacturacion}' ORDER BY operaciones.id_operacion ASC;");
                              // echo count($facturados);
                              $mostrarFacturado = [];
                              $index=0;
                              foreach ($facturados as $facts) {
                                if(!empty($facts['id_factura'])){
                                  $codFacts=$facts['tipo_inventario'].$facts['id_inventario'];
                                  if($facts['tipo_inventario']=="Productos"){
                                    $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$facts['id_inventario']}");
                                  }
                                  if($facts['tipo_inventario']=="Mercancia"){
                                    $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$facts['id_inventario']}");
                                  }
                                  if($facts['tipo_inventario']=="Catalogos"){
                                    $inventario = $lider->consultarQuery("SELECT *, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$facts['id_inventario']}");
                                  }
                                  foreach ($inventario as $inv) {
                                    if(!empty($inv['elemento'])){
                                      if(!empty($mostrarFacturado[$codFacts])){
                                        if($facts['tipo_operacion']=="Salida"){
                                          $mostrarFacturado[$codFacts]['cantidad']+=$facts['stock_operacion'];
                                        }
                                        if($facts['tipo_operacion']=="Entrada"){
                                          $mostrarFacturado[$codFacts]['cantidad']-=$facts['stock_operacion'];
                                        }
                                      }else{
                                        $mostrarFacturado[$codFacts]['cantidad']=0;
                                        $mostrarFacturado[$codFacts]['descripcion']=$inv['elemento'];
                                        $mostrarFacturado[$codFacts]['concepto']=$facts['concepto_factura'];
                                        $mostrarFacturado[$codFacts]['tipo_inventario']=$facts['tipo_inventario'];
                                        $mostrarFacturado[$codFacts]['id_inventario']=$facts['id_inventario'];
                                        $mostrarFacturado[$codFacts]['precio_nota']=$facts['precio_nota'];
                                        if($facts['tipo_operacion']=="Salida"){
                                          $mostrarFacturado[$codFacts]['cantidad']+=$facts['stock_operacion'];
                                        }
                                        if($facts['tipo_operacion']=="Entrada"){
                                          $mostrarFacturado[$codFacts]['cantidad']-=$facts['stock_operacion'];
                                        }
                                      }
                                    }
                                  }
                                  $index++;
                                }
                              }
                              // foreach ($mostrarNotasResumidas as $nota) {
                              foreach ($mostrarFacturado as $nota) {
                                if($nota['cantidad']>0){
                                  $option = "";
                                  foreach ($optNotas as $opt){
                                    if(!empty($opt['id_opcion_entrega'])){ 
                                      // print_r($opt);
                                      // echo "<br><br>";
                                      if($opt['cod']==$nota['tipo_inventario'].$nota['id_inventario']){
                                        $option = $opt['val'];
                                      }
                                    }
                                  }

                                  if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                  }else{
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota']; 
                                  }

                                  $id_unico = $nota['cantidad']."*".$nota['tipo_inventario']."*".$nota['id_inventario'];
                                  ?>
                                    <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                      <td class="col1">
                                        <?=$nota['cantidad']; ?>
                                      </td>
                                      <td class="col2">
                                        <?=$nota['descripcion']; ?>
                                      </td>
                                      <td class="col3">
                                        <?php
                                          echo "Premios de ".$nota['concepto'];
                                        ?>
                                      </td>
                                      <td>
                                        <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                          <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                          <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                        </select>
                                      </td>
                                    </tr>
                                  <?php
                                }
                              }
                            }
                            
                            // $_SESSION['limiteDisponiblesInventarioNota'] = $limiteDisponibles;
                            // $_SESSION['mostrarListaNotasNota'] = $mostrarListaNotas;
                            // $_SESSION['mostrarNotasResumidasNota'] = $mostrarFacturado;
                            // echo "faltaDisponible: ".$faltaDisponible."<br>";
                            $_SESSION['mostrarNotasResumidasNota'.$_GET['nota']] = $mostrarNotasResumidas;
                            // foreach ($mostrarNotasResumidas as $key) {
                            //   print_r($key);
                            //   echo "<br><br><br>";
                            // }
                            
                            
                          ?>
                        </tbody>
                        </table>
                        </div>
                      </div>
                      
                    </div>
                    <div class="box-footer">
                      <?php
                        if($notaentrega['estado_nota']==1){
                          $urlAgregarFact = $menuPersonalizado."nuevo=1";
                          ?>
                          <a href="?<?=$urlAgregarFact; ?>"><span class='btn enviar2'>Agregar</span></a>
                          <br><br><br>
                          <?php
                        }
                        
                        if($faltaDisponible==0 && $notaentrega['estado_nota']==1){
                          $urlCerrarFact = $menuPersonalizado."cerrar=1";
                          ?>
                          <a href="?<?=$urlCerrarFact; ?>"><span class='btn enviar2'>Cerrar Nota </span></a>
                          <br><br>
                          <!-- <button class="btn-enviar d-none" disabled="" >enviar</button> -->
                          <?php
                        }
                        if($notaentrega['estado_nota']==0){
                          $urlAbrirFact = $menuPersonalizado."abrir=1";
                          ?>
                          <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Contable"){ ?>
                            <a href="?<?=$urlAbrirFact; ?>"><span class='btn enviar2'>Abrir Nota </span></a>
                            <br><br>
                          <?php } ?>
                          <button type="submit" class="btn enviar2">Generar PDF Nota</button>
                          <br><br>
                          <button type="submit" class="btn enviar2" name="type" value="CP2">Generar PDF Factura Con Precio</button>
                          <button type="submit" class="btn enviar2" name="type" value="CP1">Generar PDF Factura Con Precio M/C</button>
                          <br><br>
                          <button type="submit" class="btn enviar2" name="type" value="SP2">Generar PDF Factura Sin Precio</button>
                          <button type="submit" class="btn enviar2" name="type" value="SP1">Generar PDF Factura Sin Precio M/C</button>
                          <?php
                        }
                        ?>
                    </div>
              </form>
          </div>

        </div>
        <!--/.col (left) -->
        <?php if( ( !empty($_GET['i']) && !empty($_GET['e'])) || (!empty($_GET['nuevo']))){ ?>
          <?php
              $limiteDisponibles = $_SESSION['limiteDisponiblesInventarioNota'];

          ?>
          <div class="col-sm-12"  style="z-index:1050;display:flex;justify-content: center;align-items: center;position:fixed;top:0;left:0;width:100%;height:100vh;background:rgba(0,0,0,0.5);">
              <div class="box" style="width:80%;">
                  <div class="box-body" style="width:100%;">
                      <a href="?<?=$menu."&route={$_GET['route']}&action={$_GET['action']}&nota={$_GET['nota']}";?>"><span class="btn cerrar_edit_fact" style='background:#ccc;float:right;'>X</span></a>
                      <form action='' method="post" class="form-uptade-factura">
                          <?php 
                              if((!empty($_GET['pc']) && !empty($_GET['i']) && !empty($_GET['e']))){
                                  $id_unico_identificador = $_GET['pc']."*".$_GET['i']."*".$_GET['e'];
                              }else{
                                  $id_unico_identificador = "";
                              }
                              // print_r($limiteDisponibles);

                          ?>
                          <input type="hidden" name="codigo_identificador" value="<?=$id_unico_identificador; ?>">
                          <input type="hidden" id="limiteElementos" name="limiteElementos" value="<?=$limiteElementos; ?>">
                          <h3 id="title_box_edit">
                              <?php 
                                  if((!empty($_GET['pc']) && !empty($_GET['i']) && !empty($_GET['e']))){
                                      if(!empty($_GET['i'])){
                                          $titleid = 'descripcion';
                                          if($_GET['i']=='m'){
                                              $titleid .= 'm';
                                          }
                                          $titleid .= $_GET['e'];
                                          echo "Modificar elemento de nota de entrega ".$limiteDisponibles[$titleid];
                                      }
                                  }else{
                                      echo "Agregar nuevo elemento a nota de entrega";
                                  }
                              ?>
                              
                              <?php
                              ?>
                          </h3>
                          <div class="row" style="padding:0px 17px;">
                              <!-- <div style="width:20%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Cantidad</label>
                              </div>
                              <div style="width:80%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Descripcion</label>
                              </div> -->
                              <div style="width:15%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Cantidad</label>
                              </div>
                              <div style="width:55%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Descripcion</label>
                              </div>
                              <div style="width:15%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Precio de Venta</label>
                              </div>
                              <div style="width:15%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                  <label>Precio de Nota</label>
                              </div>
                          </div>
                          <?php
                              $aux = $_GET;
                              $_GET = [];
                              $_GET[1] = $aux;
                          ?>
                          <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                          <div class="row" style="padding:0px 15px;">
                              <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                              <input type="number" class="form-control" id="stock<?=$z; ?>" min="0" name="stock[]" step="1" placeholder="Cantidad (150)" value="<?php 
                              if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Productos'){ 
                                  if(!empty($_GET[$z]['e'])){ 
                                      // echo $limiteDisponibles['cantidad'.$_GET[$z]['e']]; 
                                  } 
                              }else if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Mercancia'){ 
                                  if(!empty($_GET[$z]['e'])){ 
                                      // echo $limiteDisponibles['cantidadm'.$_GET[$z]['e']]; 
                                  } 
                              } 
                              if(!empty($_GET[$z]['pc'])){
                                  echo $_GET[$z]['pc'];
                              }
                              ?>">
                              <span id="error_stock<?=$z; ?>" class="errors"></span>
                              </div>
                              <div style="width:55%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                  <?php $cantidadLimiteStock = 0; ?>
                                  <select class="form-control select2 inventarios" id="inventario<?=$z; ?>" min="<?=$z;?>" name="inventario[]"  style="width:100%;z-index:100000;">
                                      <option value=""></option>
                                      <?php 
                                        foreach($productoss as $inv){ if(!empty($inv['id_producto'])){ 
                                          $cantidadLimiteStock=$inv['stock_operacion_almacen']-$limiteDisponibles['cantidad'.$inv['id_producto']];
                                          // $cantidadLimiteStock=$inv['stock_operacion_almacen'];
                                          if(($cantidadLimiteStock > 0) || ($_GET[$z]['i']=="Productos" && $_GET[$z]['e']==$inv['id_producto'])){

                                          ?>
                                            <option value="<?=$inv['id_producto']; ?>" <?php if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Productos'){ if(!empty($_GET[$z]['e']) && $_GET[$z]['e']==$inv['id_producto']){ echo "selected"; } } ?>><?="(".$inv['codigo_producto'].") ".$inv['producto']."(".$inv['cantidad'].") ".$inv['marca_producto']." -> (".$cantidadLimiteStock.")"; ?></option>
                                          <?php 
                                          }
                                        } }
                                        foreach($mercancias as $inv){ if(!empty($inv['id_mercancia'])){ 
                                          $cantidadLimiteStock=$inv['stock_operacion_almacen']-$limiteDisponibles['cantidadm'.$inv['id_mercancia']];
                                          if(($cantidadLimiteStock > 0) || ($_GET[$z]['i']=="Mercancia" && $_GET[$z]['e']==$inv['id_mercancia'])){
                                          ?>
                                            <option value="m<?=$inv['id_mercancia']; ?>" <?php if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Mercancia'){ if(!empty($_GET[$z]['e']) && $_GET[$z]['e']==$inv['id_mercancia']){ echo "selected"; } } ?>><?="(".$inv['codigo_mercancia'].") ".$inv['mercancia']."(".$inv['medidas_mercancia'].") ".$inv['marca_mercancia']." -> (".$cantidadLimiteStock.")"; ?></option>
                                          <?php
                                          }
                                        } }
                                      ?>
                                  </select>
                                  <?php //echo json_encode($limiteDisponibles); ?>
                                  <input type="hidden" id="tipo<?=$z; ?>" name="tipos[]" value="<?php if(!empty($_GET[$z]['i'])){ echo $_GET[$z]['i']; } ?>">
                                  <span id="error_inventario<?=$z; ?>" class="errors"></span>
                                  
                              </div>
                              <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                <input type="number" class="form-control" id="precio_venta<?=$z; ?>" min="0" name="precio_venta[]" step="1" placeholder="Cantidad (150)" value="<?php 
                                if(!empty($_GET[$z]['pc']) && !empty($_GET[$z]['prv'])){
                                  // echo ($_GET[$z]['pc']*$_GET[$z]['prv']);
                                  echo ($_GET[$z]['prv']);
                                }
                                ?>">
                                <span id="error_precio_venta<?=$z; ?>" class="errors"></span>
                              </div>
                              <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                <input type="number" class="form-control" id="precio_nota<?=$z; ?>" min="0" name="precio_nota[]" step="1" placeholder="Cantidad (150)" value="<?php 
                                if(!empty($_GET[$z]['pc']) && !empty($_GET[$z]['prn'])){
                                  echo ($_GET[$z]['prn']);
                                  // echo ($_GET[$z]['pc']*$_GET[$z]['prn']);
                                }
                                ?>">
                                <span id="error_precio_nota<?=$z; ?>" class="errors"></span>
                              </div>
                          </div>
                          <div style='width:100%;'>
                              <span style='float:left' id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>"><b>+</b></span>
                              <?php if($z>1){ ?>
                              <span style='float:right' id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger box-inventarios<?=$z; ?> box-inventario d-none"><b>-</b></span>
                              <?php } ?>
                          </div>
                          <?php } ?>
                          <input type="hidden" id="cantidad_elementos" name="cantidad_elementos" value="1">
                          <hr>
                          <input type="reset" class="btn-reset d-none">
                          <span class="btn enviar2 btnEnviarACtualizarFactura">Actualizar</span>
                      </form>
                  </div>
              </div>
          </div>
        <?php } ?>

        
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
  <?php if($response=="11"){ ?>
    <input type="hidden" class="rutas" value="<?=$menuResponse; ?>">
  <?php } ?>
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
.z-index{
    z-index:100000 !important;
}
.addMore, .addMenos{
  border-radius:40px;
  border:1px solid #CCC;
}
.mayus{
    text-transform:uppercase;
}
.none-color{
  color:#DDD !important;
}
.editList:hover{
    cursor: pointer;
    text-decoration:underline;
}
.input-sololectura{
  background:none !important;border:none;
}
.editList{
    float:right;margin-right:20px;color:#04a7c9;
}
.BorrarList{
  float:right;margin-right:20px;color:red;
}
.inhabilitarList{
  float:right;margin-right:20px;color:#EE3232;
}
.habilitarList{
  float:right;margin-right:20px;color:#329932;
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
    if(response == "11"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var rutas = $(".rutas").val();
        var menu = "?"+rutas;
        // alert(menu);
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

  $(".box-opt-guardar-observacion").hide();
  $(".box-opt-guardar-observacion").removeClass("d-none");
  $(".opt-editar-observacion").click(function(){
    $(".box-opt-editar-observacion").hide();
    $("#txt-observaciones").removeAttr("readonly");
    $("#txt-observaciones").removeClass("input-sololectura");
    $(".box-opt-guardar-observacion").show();
  });
  $(".opt-cancelar-observacion").click(function(){
    var ob = $("#txt-observaciones-hidden").val();
    $(".box-opt-guardar-observacion").hide();
    $("#txt-observaciones").val(ob);
    $("#txt-observaciones").attr("readonly","readonly");
    $("#txt-observaciones").addClass("input-sololectura");
    $(".box-opt-editar-observacion").show();
  });
  $(".opt-guardar-observacion").click(function(){
    var nuevaObservacion = $("#txt-observaciones").val();
    $.ajax({
      url: '',
      type: 'POST',
      data: {
        validarData: true,
        observaciones: nuevaObservacion,
      },
      success: function(respuesta){
        // alert(respuesta);
        if (respuesta == "1"){
          swal.fire({
              type: 'success',
              title: '¡Datos guardados correctamente!',
              confirmButtonColor: "#ED2A77",
          }).then(function(){
            $("#txt-observaciones-hidden").val(nuevaObservacion);
            $(".txt-observacion-txt").html(nuevaObservacion);
            $(".box-opt-guardar-observacion").hide();
            $("#txt-observaciones").attr("readonly","readonly");
            $("#txt-observaciones").addClass("input-sololectura");
            $(".box-opt-editar-observacion").show();
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
  });
  
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
      $(".codigo"+cod).removeClass("none-color");
    }
    if(val == "N"){
      $(".codigo"+cod).addClass("none-color");
    }
  });

  $(".box-inventarios").hide();
  $(".box-inventarios").removeClass("d-none");
  $(".addMore").click(function(){
    // var id=$(this).attr('id');
    // var index=$(this).attr('min');
    alimentarFormInventario();
  });
  $(".addMenos").click(function(){
    // var id=$(this).attr('id');
    // var index=$(this).attr('min');
    retroalimentarFormInventario();
  });
  function alimentarFormInventario(){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementos").val());
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant++;
    $(`.box-inventarios${cant}`).show();
    if(cant == limite){
      $("#addMore"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  function retroalimentarFormInventario(){
    var cant = parseInt($("#cantidad_elementos").val());
    $(`.box-inventarios${cant}`).hide();
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant--;
    $("#addMore"+cant).show();
    $("#addMenos"+cant).show();
    if(cant<2){
      $("#addMenos"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  $(".inventarios").on('change', function(){
    var value = $(this).val();
    var index = $(this).attr("min");
    if(value!=""){
      var pos = value.indexOf('m');
      if(pos>=0){ //Mercancia
        $("#tipo"+index).val('Mercancia');
      }else if(pos < 0){ //Productos
        $("#tipo"+index).val('Productos');
      }
    }else{
      $("#tipo"+index).val('');
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
  $(".btnEnviarACtualizarFactura").click(function(){
    var response = validadModal();
    // alert(response);
    if(response == true){
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
                // $(".btn-enviar").removeAttr("disabled");
                // $(".btn-enviar").click();
                $(".form-uptade-factura").submit();
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
function validadModal(){
    var cantidad_elementos = $("#cantidad_elementos").val();
    var rstocks = false;
    var rinventarios = false;
    if(cantidad_elementos==0){
        var rstocks = false;
        var rinventarios = false;
    }else{
        var erroresStock=0;
        var erroresInventario=0;
        for (let i=1; i<=cantidad_elementos;i++) {
            /*===================================================================*/
            var stock = $("#stock"+i).val();
            var rstock = checkInput(stock, numberPattern);
            if( rstock == false ){
                if(stock.length != 0){
                $("#error_stock"+i).html("La cantidad no debe contener letras o caracteres especiales");
                }else{
                $("#error_stock"+i).html("Debe llenar la cantidad");      
                }
            }else{
                $("#error_stock"+i).html("");
            }
            if(rstock==false){ erroresStock++; }
            /*===================================================================*/
            
            /*===================================================================*/
            var inventario = $("#inventario"+i).val();
            var rinventario = false;
            if(inventario==""){
                rinventario=false;
                $("#error_inventario"+i).html("Debe seleccionar el elemento del inventario");
            }else{
                rinventario=true;
                $("#error_inventario"+i).html("");
            }
            if(rinventario==false){ erroresInventario++; }
            /*===================================================================*/

            /*===================================================================*/
            /*===================================================================*/
        }
        if(erroresStock==0){ rstocks=true; }
        if(erroresInventario==0){ rinventarios=true; }
    }
    var response = false;
    if(rstocks==true && rinventarios==true){
        response=true;
    }else{
        response=false;
    }
    return response;
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
