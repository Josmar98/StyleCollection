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
        <small><?php if(!empty($action)){echo "Editar Notas de entrega";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Notas de entrega"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Notas de entrega"; ?></li>
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
              <h3 class="box-title">Editar <?php echo "Notas de entrega"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <form action="" method="post" class="form table-responsive">
                <div class="box-body">
                  <div class="">
                    <div class="col-xs-12 col-sm-7 text-center">
                      <img src="public/assets/img/logoTipo1.png" style="width:350px;">
                      <br>
                      Rif.: J408497786
                      <br>
                      <textarea maxlength="255" name="direccion_emision" style="min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:center;padding:0"><?=$notaentrega['direccion_emision']?></textarea>
                    </div>
                    <div class="col-xs-12 col-sm-5 text-center">
                      <br class="xs-none">
                      <br class="xs-none">
                      <div style="">
                        <div class="col-xs-12 col-md-6" style="display:inline-block;">
                          <small>LUGAR DE EMISION</small>
                          <br>
                          <input type="text" name="lugar_emision" value="<?=$notaentrega['lugar_emision']?>" maxlength="90">
                        </div>
                        <div class="col-xs-12 col-md-6" style="display:inline-block;">
                          <small>FECHA DE EMISION</small>
                          <br>
                          <input type="date" name="fecha_emision" value="<?=$notaentrega['fecha_emision']?>">
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
                        <input type="number" readonly="" name="numero" class="form-control" step="1" value="<?=$notaentrega['numero_nota_entrega']?>" onfocusout="$(this).val(parseInt($(this).val()))" style="display:inline-block;font-size:1.6em;float:right;width:85%;margin:0;">
                      </div>
                    </div>
                    <input type="hidden" name="id_cliente" value="<?=$notaentrega['id_cliente']?>">
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
                        Analista: <input type="text" style="width:60%" placeholder="Nombre del analista" name="nombreanalista" value="<?=$notaentrega['nombreanalista']?>" maxlength="50">
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
                            <td colspan="3">
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
                          <tr>
                            <td colspan='5'>
                              <label for="almacen">Almacen</label>
                              <select class="form-control almacenes" name="almacen" id="almacen">
                                <option value=""></option>
                                <?php foreach($almacenes as $alm){ if(!empty($alm['id_almacen'])){ ?>
                                  <option value="<?=$alm['id_almacen']; ?>" <?php if($notaentrega['id_almacen']==$alm['id_almacen']){ echo "selected"; } ?>><?=$alm['nombre_almacen']; ?></option>
                                <?php } } ?>
                              </select>
                              <span class="errors error_almacen"></span>
                            </td>
                          </tr>
                          <tr>
                              <td colspan='5'>
                                <label for="observacion">Observación</label>
                                <textarea class="form-control" name="observacion" id="observacion" maxlength="200" style='max-width:100%;min-width:100%;max-height:60px;min-height:60px;'><?=$notaentrega['observaciones'];?></textarea>
                                <span class="errors error_observacion"></span>
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
                                                                <tr class="codigo<?=$planIDACT;?><?=$planstandard['id_premio']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> > <!-- STANDARD -->
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
                                                                    <select class="opciones" name="opts[<?=$planIDACT;?><?=$planstandard['id_premio']?>]" id="<?=$planIDACT;?><?=$planstandard['id_premio']?>">
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
                                                                    $premiosNotaEntrega[$index]['concepto']="Premios de ".$pagosR['name'];;
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
                                          // if(($dataperdidos['valor'] == $pagosR['id'])){
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
                                                              <select class="opciones" name="opts[<?=$codigoPagoAdd; ?>]" id="<?=$codigoPagoAdd; ?>">
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
                                                                    // $codigoPagoAdd = $pagosR['cod'].$premiosP['id_plan']."-".$premiosP['id_premio'];
                                                                    $codigoPagoAdd = $pagosR['cod'].$premiosP['id_premio'];
                                                                    // echo $codigoPagoAdd." | ";
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
                                                                    <!-- <tr class="codigo<?=$codigoPagoAdd; ?>"  <?php //if ($option=="N"){ ?> style='color:#DDD;' <?php //} ?> >
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
                                                                        <select class="opciones" name="opts[<?=$codigoPagoAdd; ?>]" id="<?=$codigoPagoAdd; ?>">
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



                                    // echo $pagosR['name'];
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
                                        $premiosNotaEntrega[$index]['concepto']="Premios de ".$key['tipo'];;
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
                                                  $premiosNotaEntrega[$index]['concepto']="Premios de Reto Junior";
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
                                        <tr class="codigo<?=$idPromo; ?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?> > <!-- retos -->
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
                                              <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                              <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">No</option>
                                            </select>
                                          </td>
                                        </tr>
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
                                        $prinv[0]['tipo_inventario']="Catalagos";
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
                                // print_r($nota);
                                // echo "<br><br>";
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
                                }
                                // print_r($notaResumida);
                              }

                              foreach ($notaResumida as $nota) {
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
                                  ?>
                                  <tr class="<?=$nota['codigo']?>" <?php if ($option=="N"){ ?> style='color:#DDD;' <?php } ?>>
                                    <td class="col1">
                                      <?=$nota['cantidad']; ?>
                                    </td>
                                    <td class="col2">
                                      <?=$nota['descripcion']; ?>
                                    </td>
                                    <td class="col3">
                                      <?php
                                        echo $nota['concepto'];
                                        // if($nota['conceptoaddc']!="" || $nota['conceptoadd']!=""){
                                        //   echo " (";
                                        //   if($nota['conceptoaddc']!=""){
                                        //     echo $nota['conceptoaddc'].": ";
                                        //   }
                                        //   if($nota['conceptoadd']!=""){
                                        //     echo $nota['conceptoadd'];
                                        //   }
                                        //   echo ")";
                                        // }
                                      ?>
                                    </td>
                                    <td>
                                      <select class="opciones" name="opts[<?=$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                        <option <?php if($option=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                        <option <?php if($option=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                      </select>
                                    </td>
                                  </tr>
                                <?php
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
    // var response = true;

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
  var almacen = $("#almacen").val();
  var ralmacen = false;
  if(almacen!=""){
    ralmacen = true;
    $(".error_almacen").html("");
  }else{
    ralmacen = false;
    $(".error_almacen").html("Debe Seleccionar un almacen");      
  }

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
  if( ralmacen==true){
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
