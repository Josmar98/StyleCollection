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
  <script src="public/vendor/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="public/vendor/plugins/select2/js/select2.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      // $("body").hide("500");
      $('.select2').select2();
    });
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo "Premios Perdidos";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Perdidos";} echo " "; ?></li>
      </ol>
    </section>
          <br>

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
              <h3 class="box-title">Reporte de <?php echo "Premios Perdidos"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-12">

                      <?php 
                        $campanasDespachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id'];]
                      ?>
                      <input type="hidden" name="route" value="Reportes">
                      <input type="hidden" name="action" value="PremiosPerdidos">
                      <label for="selectedPedido"><b style="color:#000;">Seleccionar Pedido de Campaña</b></label>
                      <select id="selectedPedido" name="P" class="form-control select2" style="width:100%;">
                          <option value="0"></option>
                            <?php 
                              if(count($campanasDespachos)>1){
                                foreach ($campanasDespachos as $key) {
                                  if(!empty($key['id_campana'])){                        
                                    ?>
                                    <option 
                                          value="<?=$key['id_despacho']?>" 
                                          <?php if(!empty($id_despacho)){if($key['id_despacho']==$id_despacho){echo "selected='1'";}} ?>    >
                                      <?php
                                        $ndp = "";
                                        if($key['numero_despacho']=="1"){ $ndp = "1er"; }
                                        if($key['numero_despacho']=="2"){ $ndp = "2do"; }
                                        if($key['numero_despacho']=="3"){ $ndp = "3er"; }
                                        if($key['numero_despacho']=="4"){ $ndp = "4to"; }
                                        if($key['numero_despacho']=="5"){ $ndp = "5to"; }
                                        if($key['numero_despacho']=="6"){ $ndp = "6to"; }
                                        if($key['numero_despacho']=="7"){ $ndp = "7mo"; }
                                        if($key['numero_despacho']=="8"){ $ndp = "8vo"; }
                                        if($key['numero_despacho']=="9"){ $ndp = "9no"; }
                                      ?>
                                      <?php 
                                        if($key['numero_despacho']!="1"){
                                          // echo $key['numero_despacho'];
                                          echo $ndp;
                                        }
                                        echo " Pedido ";
                                        echo " de Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana'];
                                      ?>
                                    
                                    </option>
                                    <?php 

                                  }
                                }

                              }
                            ?>
                      </select>
                      <span class="errors error_selected_pedido"></span>
                    </div>
              
                  </div>
                  
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>
            </form>
        <?php if(!empty($_GET['P'])){ ?>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                  
                    <br>
                    <hr style="border-bottom:1px solid #bbb">
                </div>
              </div>
            </div>
            <div class="box-body"> 
              <div class="row">
                <div class="col-xs-12">


                    <div class="row">
                      <div class="col-xs-10 col-xs-offset-1">
                        <h4 style="font-size:1.7em;margin:0;padding:0;">
                          <b>
                          Pedido 
                          <?php if($despachos[0]['numero_despacho']!="1"): echo $despachos[0]['numero_despacho']; endif; ?>
                           de Campana 
                            <?=$despachos[0]['numero_campana']."/".$despachos[0]['anio_campana']; ?>
                          -
                            <?=$despachos[0]['nombre_campana']; ?>
                          </b>
                        </h3>
                      </div>
                    </div>
                    <br>

                    
                    <div class="row">
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;">
                          <a href="?route=Reportes&action=GenerarPremiosPerdidos&id=<?=$id_despacho?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table class="table text-center datatable" id="">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th style="width:10%">Nº</th>
                          <th style="width:20%">Lider</th>
                          <th style="width:17.5%">Colecciones</th>
                          <th style="width:17.5%">Planes Seleccionado</th>
                          <th style="width:35%">Premios Perdidos</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC;");
                          $premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
                        ?>
                        <?php 
                          $acumColecciones = 0;
                          $totalesPremios = [];
                          // $nume = 0;
                          // foreach ($pagosRecorridos as $pagosR){
                          //   if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
                          //     if(count($planes)>1){
                          //       foreach ($planes as $plan) {
                          //         if(!empty($plan['nombre_plan'])){
                          //           $nume2 = 0;
                          //           $acumPlanes[$plan['nombre_plan']]=0;
                          //           $acumPremios[$nume]['plan'] = $plan['nombre_plan'];
                          //           if($plan['nombre_plan']=='Standard'){
                          //             $acumPremios[$nume]['cantidad'] = 0;
                          //           }

                          //           if(count($premios)>1){
                          //             foreach ($premios as $premio) {
                          //               if(!empty($premio['nombre_premio'])){
                          //                 if($plan['id_plan'] == $premio['id_plan']){
                          //                   $acumPremios[$nume]['premio'][$nume2]['nombre'] = $premio['nombre_premio'];
                          //                   $acumPremios[$nume]['premio'][$nume2]['cantidad'] = 0;
                          //                   $nume2++;
                          //                 }
                          //               }
                          //             }
                          //           }
                          //           $nume++;
                          //         }
                          //       }
                          //     }
                          //   }else{
                          //     $acumPremios[$nume]['plan'] = $pagosR['name'];
                          //     $acumPremios[$nume]['cantidad'] = 0;
                          //     $nume++;   
                          //   }
                          // }
                          $num = 1;
                        ?>

                        <?php foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){ ?>
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
                            if($permitido=="1"){
                              if($data['cantidad_aprobado']>0){
                              ?>
                              <tr class="elementTR">
                                <td style="width:10%;"><?=$num?></td>
                                <td style="width:20%">
                                  <?php 
                                    echo number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']." <br> ".
                                        $data['cantidad_aprobado']." Colecciones Aprobadas";
                                  ?>
                                </td>
                                <td style="width:70%;text-align:justify;" colspan="3">
                                  <table class='table table-striped table-hover' style='background:none;width:100%;'>
                                    <?php foreach ($pagosRecorridos as $pagosR){ ?>
                                      <?php if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){ ?>
                                        <?php foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){ ?>
                                          <?php if ($data['id_pedido'] == $data2['id_pedido']){ ?>
                                            <?php if ($data2['cantidad_coleccion_plan']>0){ ?>
                                              <tr>
                                                <td style="text-align:left;width:25%">
                                                  <?php 
                                                    $colss = ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']);
                                                    $acumColecciones += $colss;
                                                    echo $colss." Colecciones ";
                                                  ?>
                                                </td>
                                                <td style="text-align:left;width:25%">
                                                  <?php 
                                                    echo $data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."<br>"; 
                                                    if(!empty($totalesPremios[$data2['nombre_plan']]['colecciones'])){
                                                      $totalesPremios[$data2['nombre_plan']]['colecciones'] += $data2['cantidad_coleccion_plan'];
                                                    }else{
                                                      $totalesPremios[$data2['nombre_plan']]['colecciones'] = $data2['cantidad_coleccion_plan'];
                                                    }
                                                  ?>
                                                </td>
                                                <td style="width:50%;">
                                                  <table style='width:100%;background:none'> 
                                                    <tr>
                                                      <?php 
                                                        $porcentSelected = 0;
                                                        $porcentPerdido = 0;
                                                        $porcentResul = 0;
                                                      ?>
                                                      <td style="text-align:left;">
                                                        <?php 
                                                          foreach ($premios_perdidos as $dataperdidos) {
                                                            if(!empty($dataperdidos['id_premio_perdido'])){
                                                              if($dataperdidos['id_pedido'] == $data['id_pedido']){
                                                                // if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                                $comparedPlan = "";
                                                                if($dataperdidos['codigo']=="nombre"){
                                                                  $comparedPlan = $data2['nombre_plan'];
                                                                }
                                                                if($dataperdidos['codigo']=="nombreid"){
                                                                  $comparedPlan = $data2['id_plan'];
                                                                }
                                                                if( ($dataperdidos['valor'] == $comparedPlan) ){
                                                                  $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                                  // for ($i=0; $i < count($acumPremios); $i++) { 
                                                                  //   if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
                                                                  //     $acumPremios[$i]['cantidad'] += $perdidos;
                                                                  //   }
                                                                  // }
                                                                  // print_r($premios_planes);
                                                                  foreach ($premios_planes3 as $planstandard){
                                                                    if ($planstandard['id_plan_campana']){
                                                                      if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
                                                                        if ($planstandard['tipo_premio']==$pagosR['name']){ ?>
                                                                            <table style="width:100%;">
                                                                              <tr>
                                                                                <td style="text-align:left;">
                                                                                  <?php echo "(".$perdidos.") ".$planstandard['producto']; ?>
                                                                                </td>
                                                                                <td style="text-align:right;">
                                                                                  <?php 
                                                                                    $porcentSelected = $data2['cantidad_coleccion_plan'];
                                                                                    $porcentPerdido = $perdidos;
                                                                                    $porcentResul = ($porcentPerdido/$porcentSelected)*100;

                                                                                    if(!empty($totalesPremios[$data2['nombre_plan']][$planstandard['producto']])){
                                                                                      $totalesPremios[$data2['nombre_plan']][$planstandard['producto']]['cantidad'] += $perdidos;
                                                                                    }else{
                                                                                      $totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
                                                                                      $totalesPremios[$data2['nombre_plan']][$planstandard['producto']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$perdidos];
                                                                                    }
                                                                                    echo "<b>".number_format($porcentResul,2,',','.')."%</b>";
                                                                                  ?>
                                                                                </td>
                                                                              </tr>
                                                                            </table>
                                                                          <?php 
                                                                        }
                                                                      }
                                                                    }
                                                                  }
                                                                }
                                                              }
                                                            }
                                                          }
                                                        ?>
                                                      </td>
                                                      <td></td>
                                                    </tr>
                                                    <?php $nx=0; ?>
                                                    <?php foreach ($premioscol as $data3){ if(!empty($data3['id_premio'])){ ?>  
                                                      <?php if ($data3['id_plan']==$data2['id_plan']){ ?>
                                                        <?php if ($data['id_pedido']==$data3['id_pedido']){ ?>
                                                          <?php 
                                                            $totalesPremios[$data2['nombre_plan']]['premios'][$nx] = $data3['nombre_premio'];
                                                            $nx++;
                                                          ?>
                                                          <?php if($data3['cantidad_premios_plan']>0){ ?>
                                                            <tr>
                                                              <?php 
                                                                $porcentSelected = 0;
                                                                $porcentPerdido = 0;
                                                                $porcentResul = 0;
                                                              ?>
                                                              <td style="text-align:left;">
                                                              <?php 
                                                                
                                                                foreach ($premios_perdidos as $dataperdidos) {
                                                                    if(!empty($dataperdidos['id_premio_perdido'])){
                                                                      if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                                        $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                                        // for ($i=0; $i < count($acumPremios); $i++) { 
                                                                        //   if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
                                                                        //     for ($j=0; $j < count($acumPremios[$i]['premio']); $j++) { 
                                                                        //       if($acumPremios[$i]['premio'][$j]['nombre']==$data3['nombre_premio']){

                                                                        //         $acumPremios[$i]['premio'][$j]['cantidad'] += $perdidos;
                                                                        //       }
                                                                        //     }
                                                                        //   }
                                                                        // }
                                                                        ?>
                                                                        <table style="width:100%;">
                                                                          <tr>
                                                                            <td style="text-align:left;">
                                                                              <?php echo "(".$perdidos.") ".$data3['nombre_premio']; ?>
                                                                            </td>
                                                                            <td style="text-align:right;">
                                                                              <?php
                                                                                $porcentSelected = $data3['cantidad_premios_plan'];
                                                                                $porcentPerdido = $perdidos;
                                                                                $porcentResul = ($porcentPerdido/$porcentSelected)*100;

                                                                                if(!empty($totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']])){
                                                                                  $totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']]['cantidad'] += $perdidos;
                                                                                }else{
                                                                                  $totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
                                                                                  $totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$perdidos];
                                                                                }
                                                                                echo "<b>".number_format($porcentResul,2,',','.')."%</b>";
                                                                              ?>
                                                                            </td>
                                                                          </tr>
                                                                        </table>
                                                                        <?php 
                                                                      }
                                                                    }
                                                                  }
                                                               ?>
                                                              </td>
                                                            </tr>
                                                          <?php } ?>
                                                        <?php } ?>
                                                      <?php } ?>
                                                    <?php } }  ?>

                                                        
                                                  </table>
                                                </td>
                                              </tr>
                                            <?php } ?>
                                          <?php } ?>
                                        <?php }} ?>
                                      <?php } else { ?>
                                        <tr>
                                          <td style="text-align:left;">
                                            <?php echo $data['cantidad_aprobado']." Colecciones<br>"; ?>
                                          </td>
                                          <td style="text-align:left;">
                                            <?php echo $data['cantidad_aprobado']." Premios de ".$pagosR['name']."<br>"; ?>
                                            <?php
                                              if(!empty($totalesPremios[$pagosR['name']]['colecciones'])){
                                                $totalesPremios[$pagosR['name']]['colecciones'] += $data['cantidad_aprobado'];
                                              }else{
                                                $totalesPremios[$pagosR['name']]['colecciones'] = $data['cantidad_aprobado'];
                                              }
                                            ?>
                                          </td>
                                          <td style="width:50%;">
                                            <table class='' style='width:100%;background:none'> 
                                              <tr>
                                                <?php 
                                                  $porcentSelected = 0;
                                                  $porcentPerdido = 0;
                                                  $porcentResul = 0;
                                                ?>
                                                <td style="text-align:left;">
                                                  <?php 
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
                                                        // echo $dataNamePerdido." - ";
                                                        // echo "*".$dataNamePerdidoIdPlan."*<br>";
                                                        $dataComparar = "";
                                                        if($posOrigin==""){
                                                          $dataComparar = $dataperdidos['valor'];
                                                        }else{
                                                          $dataComparar = $dataNamePerdido;
                                                        }
                                                        if(($dataComparar == $pagosR['id'])){
                                                          if($dataNamePerdidoIdPlan==""){
                                                            $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                            foreach ($premios_planes as $planstandard){
                                                              if ($planstandard['id_plan_campana']){
                                                                if ($planstandard['tipo_premio'] == $pagosR['name']){
                                                                  ?>
                                                                  <table style="width:100%;">
                                                                    <tr>
                                                                      <td style="text-align:left;">
                                                                        <?php echo "(".$perdidos.") ".$planstandard['producto']; ?>
                                                                      </td>
                                                                      <td style="text-align:right;">
                                                                        <?php 
                                                                          $porcentSelected = $data['cantidad_aprobado'];
                                                                          $porcentPerdido = $perdidos;
                                                                          $porcentResul = ($porcentPerdido/$porcentSelected)*100;

                                                                          echo "<b>".number_format($porcentResul,2,',','.')."%</b>";

                                                                          if(!empty($totalesPremios[$pagosR['name']][$planstandard['producto']])){
                                                                            $totalesPremios[$pagosR['name']][$planstandard['producto']]['cantidad'] += $perdidos;
                                                                          }else{
                                                                            $totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
                                                                            $totalesPremios[$pagosR['name']][$planstandard['producto']] = ['id'=>$pagosR['id'], 'plan'=>$planstandard['nombre_plan'], 'name'=>$pagosR['name'], 'premio'=>$planstandard['producto'], 'cantidad'=>$perdidos];
                                                                          }
                                                                        ?>
                                                                      </td>
                                                                    </tr>
                                                                  </table>
                                                                  <?php
                                                                }
                                                              }
                                                            }
                                                          } else {
                                                            foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                                              if ($data['id_pedido'] == $data2['id_pedido']){
                                                                if ($data2['cantidad_coleccion_plan']>0){
                                                                  if($dataNamePerdidoIdPlan==$data2['id_plan']){
                                                                    if(!empty($dataperdidos['id_premio_perdido'])){
                                                                      $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                                      // if($perdidos>0){
                                                                        foreach ($premios_planes3 as $premiosP) { if(!empty($premiosP['nombre_plan'])){
                                                                          if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                                            if($pagosR['name']==$premiosP['tipo_premio']){
                                                                              // $codigoPagoAdd = $pagosR['cod'].$premiosP['id_plan']."-".$premiosP['id_premio'];
                                                                              ?>
                                                                              <table style="width:100%;">
                                                                                <tr>
                                                                                  <td style="width:60%;text-align:left;">
                                                                                    <?php echo "(".$perdidos.") ".$premiosP['producto']; ?>
                                                                                  </td>
                                                                                  <td style="width:25%;text-align:left;padding-left:5px;">
                                                                                    <?php echo " (".$data2['nombre_plan'].")"; ?>
                                                                                  </td>
                                                                                  <td style="width:15%;text-align:right;">
                                                                                    <?php 
                                                                                      $porcentSelected = $data['cantidad_aprobado'];
                                                                                      $porcentPerdido = $perdidos;
                                                                                      $porcentResul = ($porcentPerdido/$porcentSelected)*100;

                                                                                      echo "<b>".number_format($porcentResul,2,',','.')."%</b>";

                                                                                      if(!empty($totalesPremios[$pagosR['name']][$premiosP['producto']])){
                                                                                        $totalesPremios[$pagosR['name']][$premiosP['producto']]['cantidad'] += $perdidos;
                                                                                      }else{
                                                                                        $totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
                                                                                        $totalesPremios[$pagosR['name']][$premiosP['producto']] = ['id'=>$pagosR['id'], 'plan'=>$data2['nombre_plan'], 'name'=>$pagosR['name'], 'premio'=>$premiosP['producto'], 'cantidad'=>$perdidos];
                                                                                      }
                                                                                    ?>
                                                                                  </td>
                                                                                </tr>
                                                                              </table>
                                                                              <?php
                                                                            }
                                                                          }
                                                                        }}

                                                                      // }
                                                                    }

                                                                  }
                                                                }
                                                              }
                                                            }}
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                   ?>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      <?php } ?>
                                    <?php } ?>
                                  </table>
                                </td>
                              </tr>
                              <?php $num++; ?>
                              <?php
                              }
                            }
                          ?>
                        <?php } } ?>

                          <tr style="background:#CCC">
                            <td style="width:10%;"></td>
                            <td style="width:20%;"></td>
                            <td style="width:17.5%;text-align:left;"><?=$acumColecciones; ?> Colecciones</td>
                            <td colspan="2" style="text-align:left;width:60%;">
                              <table class="table table-hover" style="width:100%;background:none;">
                                <?php foreach ($pagosRecorridos as $pagosR){ ?>
                                  <?php if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){ ?>
                                    <?php 
                                      foreach ($planes as $plan){
                                        if (!empty($plan['nombre_plan'])){
                                          if(!empty($totalesPremios[$plan['nombre_plan']]['colecciones'])){
                                            if($totalesPremios[$plan['nombre_plan']]['colecciones']>0){
                                            ?>
                                            <tr>
                                              <td style="text-align:left;width:31%;">
                                                <?php echo $totalesPremios[$plan['nombre_plan']]['colecciones']." Plan ".$plan['nombre_plan']."<br>"; ?>
                                              </td>
                                              <td style="text-align:left;width:64%;">
                                                <?php 
                                                  $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$plan['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
                                                  $tempPlanes = $lider->consultarQuery($sql0);
                                                  $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                                  $namePlanesTemp = $plan['nombre_plan'];
                                                  if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){
                                                    foreach ($premios_planes3 as $planstandard){
                                                      if ($planstandard['id_plan_campana']){
                                                        if ($plan['nombre_plan'] == $planstandard['nombre_plan']){
                                                          if ($planstandard['tipo_premio']==$pagosR['name']){
                                                            foreach ($totalesPremios as $key) {
                                                              if(!empty($key['name']) && $key['name'] == $plan['nombre_plan']){
                                                                if(!empty($key[$planstandard['producto']])){
                                                                  $cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
                                                                  //if($cantidadMostrar>0){
                                                                    ?>
                                                                    <table style="width:100%;">
                                                                      <tr>
                                                                        <td style="text-align:left;">
                                                                          <?php echo "(".$cantidadMostrar.") ".$planstandard['producto']; ?>
                                                                        </td>
                                                                        <td style="text-align:right;">
                                                                          <?php
                                                                            $totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
                                                                            $totPerdido = $cantidadMostrar;
                                                                            $totResul = ($totPerdido/$totSelected)*100;
                                                                            echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                                          ?>
                                                                        </td>
                                                                      </tr>
                                                                    </table>
                                                                    <?php 
                                                                  //}
                                                                }
                                                              }
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }
                                                  } else {
                                                    foreach ($totalesPremios as $key){
                                                      if (!empty($key['name']) && $plan['nombre_plan']==$key['name']){
                                                        if(!empty($key['premios'])){
                                                          $premios = $key['premios'];
                                                          foreach ($premios as $nombrePremio){
                                                            if(!empty($key[$nombrePremio])){
                                                              $cantidadMostrar = $key[$nombrePremio]['cantidad'];
                                                              //if ($cantidadMostrar>0){
                                                                ?>
                                                                <table style="width:100%;">
                                                                  <tr>
                                                                    <td style="text-align:left;">
                                                                      <?php echo "(".$cantidadMostrar.") ".$nombrePremio; ?>
                                                                    </td>
                                                                    <td style="text-align:right;">
                                                                      <?php
                                                                        $totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
                                                                        $totPerdido = $cantidadMostrar;
                                                                        $totResul = ($totPerdido/$totSelected)*100;
                                                                        echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                                      ?>
                                                                    </td>
                                                                  </tr>
                                                                </table>
                                                                <?php 
                                                              //}
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }
                                                ?>
                                              </td>
                                            </tr>
                                            <?php
                                            }
                                          }
                                        }
                                      } 
                                    ?>
                                  <?php } else { ?>
                                    <tr>
                                      <td style="text-align:left;">
                                        <?=$acumColecciones?> Premios de <?=$pagosR['name']; ?>
                                      </td>
                                      <td style="text-align:left;">
                                        <?php 
                                          foreach ($premios_planes3 as $planstandard){
                                            if ($planstandard['id_plan_campana']){
                                              if ($planstandard['tipo_premio']==$pagosR['name']){
                                                //echo "<br><br>".$planstandard['tipo_premio']."(".$planstandard['nombre_plan'].") -> ";

                                                // print_r($totalesPremios);
                                                // echo "<br><br><br>";

                                                foreach ($totalesPremios as $key) {
                                                  // if(!empty($key['name']) && $key['name'] == $pagosR['name']){
                                                  if(!empty($key['name']) && $key['name'] == $planstandard['tipo_premio']){
                                                    // print_r($key);
                                                    // echo "<br><br><br>";
                                                    if(!empty($key[$planstandard['producto']])){


                                                      if($key[$planstandard['producto']]['plan']==$planstandard['nombre_plan']){
                                                        $cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
                                                        //echo $cantidadMostrar." | ";
                                                        //if($cantidadMostrar>0){ ?>
                                                          <table style="width:100%;">
                                                            <tr>
                                                              <td style="width:60%;text-align:left;">
                                                                <?php echo "(".$cantidadMostrar.") ".$planstandard['producto']; ?>
                                                              </td>
                                                              <td style="width:25%;text-align:left;">
                                                                <?php echo "(".$key[$planstandard['producto']]['plan'].")"; ?>
                                                              </td>
                                                              <td style="width:15%;text-align:right;">
                                                                <?php
                                                                  $totSelected = $acumColecciones;
                                                                  $totPerdido = $cantidadMostrar;
                                                                  $totResul = ($totPerdido/$totSelected)*100;
                                                                  echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                                ?>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                          <?php
                                                        //}

                                                      }
                                                    }
                                                  }
                                                }



                                              }
                                            }
                                          }

                                        ?>
                                      </td>
                                    </tr>
                                  <?php } ?>
                                <?php } ?>
                              </table>
                            </td>
                          </tr>

                      </tbody>
                    </table>
                    <?php 
                      // print_r($totalesPremios); 

                      // foreach ($totalesPremios as $key) {
                      //   echo $key['name']." => ";
                      //   print_r($key);
                      //   echo "<br><br>";
                      // }
                    ?>
                </div>
              </div>
            </div>
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
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Configuraciones";
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
