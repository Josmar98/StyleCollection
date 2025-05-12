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
        <small><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></li>
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
              <h3 class="box-title">Reporte de <?php echo "Premios Alcanzados por Líderes"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-12">

                    <?php 
                  $campanasDespachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id']; ?>
                        <input type="hidden" name="route" value="Reportes">
                        <input type="hidden" name="action" value="PremiosAlcanzadosResumen">

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
                        <br>
                        <br>
                        <label for="selectedLideres"><b style="color:#000;">Seleccionar Líderes</b></label>
                        <select id="selectedLideres" name="L[]" multiple class="form-control select2" style="width:100%;">
                          <option value="0"></option>
                            <?php 
                              if(count($lideres)>1){
                                foreach ($lideres as $key) {
                                  if(!empty($key['id_cliente'])){                        
                                    ?>
                                    <option 
                                          value="<?=$key['id_cliente']?>" 
                                           <?php foreach ($clientesss as $cl){ if($cl==$key['id_cliente']){ echo "selected"; } } ?>
                                          >
                                      
                                      <?php 
                                        echo "".$key['primer_nombre']." ".$key['segundo_nombre']." ".$key['primer_apellido']." ".$key['segundo_apellido']." (".$key['cedula'].")";
                                      ?>
                                    
                                    </option>
                                    <?php 

                                  }
                                }

                              }
                            ?>
                        </select>
                        <span class="errors error_selected_lider"></span>
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
        <?php if(!empty($_GET['P'])){ 
            ?>
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
                          <?php if($despachos[0]['numero_despacho']!="1"){ echo $despachos[0]['numero_despacho']; } ?>
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
                          <?php
                            $indexL = "";
                            foreach ($clientesss as $key => $value){
                              $indexL .= "&L%5B%5D=".$value;
                              // echo $key."=> ".$value."<br>";
                            }
                            // echo $indexL;
                          ?>
                          <a href="?route=<?=$_GET['route']; ?>&action=Generar<?=$_GET['action']; ?>&id=<?=$id_despacho?><?=$indexL; ?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <?php
                      $planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
                      $premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
                      $acumColecciones = 0;
                      $totalesPremios = [];
                      $acumRetos = [];
                      $numb = 0;
                      foreach ($retosCamp as $ret) {
                        if(!empty($ret['id_premio'])){
                          $acumRetos[$numb]['nombre'] = $ret['nombre_premio'];
                          $acumRetos[$numb]['cantidad'] = 0;
                          $numb++;
                        }
                      }

                      $acumpremioAutorizados = [];
                      $numbPA = 0;
                      foreach ($premios_autorizadosUnic as $pa) {
                        if(!empty($pa['id_premio'])){
                          $acumpremioAutorizados[$numbPA]['nombre'] = $pa['nombre_premio'];
                          $acumpremioAutorizados[$numbPA]['cantidad'] = 0;
                          $numbPA++;
                        }
                      }

                      $acumpremioAutorizadosOBS = [];
                      $numbPAOBS = 0;
                      foreach ($premios_autorizados_obsequioUnic as $pa) {
                        if(!empty($pa['id_premio'])){
                          $acumpremioAutorizadosOBS[$numbPAOBS]['nombre'] = $pa['nombre_premio'];
                          $acumpremioAutorizadosOBS[$numbPAOBS]['cantidad'] = 0;
                          $acumpremioAutorizadosOBS[$numbPAOBS]['descripcion'] = $pa['descripcion_PA'];
                          $numbPAOBS++;
                        }
                      }
                      $arrayt2 = [];
                      $numCC = 0;
                      foreach ($canjeosUnic as $canUnic) {
                        if(!empty($canUnic['nombre_catalogo'])){
                          $arrayt2[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                          $arrayt2[$numCC]['cantidad'] = 0;
                          $numCC++;
                        }
                      }

                      $num = 1;
                      $cantAUX=0;
                      $acumpremioAutorizadosAUX=[];


                      foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
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
                            $coleccionesPlanPremioPedido = [];
                            
                            foreach ($pagosRecorridos as $pagosR){ 
                              if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){ 
                                foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){ 
                                  if ($data['id_pedido'] == $data2['id_pedido']){ 
                                    if ($data2['cantidad_coleccion_plan']>0){
                                      $colss = ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']);
                                      $acumColecciones += $colss;
                                      if(!empty($totalesPremios[$data2['nombre_plan']]['colecciones'])){
                                        $totalesPremios[$data2['nombre_plan']]['colecciones'] += $data2['cantidad_coleccion_plan'];
                                      }else{
                                        $totalesPremios[$data2['nombre_plan']]['colecciones'] = $data2['cantidad_coleccion_plan'];
                                      }
                                      // ========================== // =============================== // ============================== //
                                      $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_seleccionada'] = $data2['cantidad_coleccion_plan'];
                                      $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = 0;
                                      // ========================== // =============================== // ============================== //
                                      $porcentSelected = 0;
                                      $porcentAlcanzado = 0;
                                      $porcentResul = 0;
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
                                            if( ($dataperdidos['valor'] == $comparedPlan) ){
                                              $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                              if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                                if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                                  $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoResult;
                                                }
                                              }
                                              $premios_planes_f=[];
                                              if(count($premios_planes3)>1){
                                                $premios_planes_f=$premios_planes3;
                                                $nameelemento="producto";
                                              }else if(count($premios_planes4)>1){
                                                $premios_planes_f=$premios_planes4;
                                                $nameelemento="nombre_premio";
                                              }
                                              foreach ($premios_planes_f as $planstandard){
                                                if ($planstandard['id_plan_campana']){
                                                  if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
                                                    if ($planstandard['tipo_premio']==$pagosR['name']){ 
                                                      
                                                      $porcentSelected = $data2['cantidad_coleccion_plan'];
                                                      $porcentAlcanzado = $nuevoResult;
                                                      $porcentResul = ($porcentAlcanzado/$porcentSelected)*100;

                                                      if(!empty($totalesPremios[$data2['nombre_plan']][$planstandard[$nameelemento]])){
                                                        $totalesPremios[$data2['nombre_plan']][$planstandard[$nameelemento]]['cantidad'] += $nuevoResult;
                                                      }else{
                                                        $totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
                                                        $totalesPremios[$data2['nombre_plan']][$planstandard[$nameelemento]] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$nuevoResult];
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                      
                                      $nx=0;
                                      $nuevoTSelected = 0;
                                      foreach ($premioscol as $data3){ if(!empty($data3['id_premio'])){ 
                                        if ($data3['id_plan']==$data2['id_plan']){
                                          if ($data['id_pedido']==$data3['id_pedido']){
                                            $totalesPremios[$data2['nombre_plan']]['premios'][$nx] = $data3['nombre_premio'];
                                            $nx++;
                                            if($data3['cantidad_premios_plan']>0){ 
                                              $porcentSelected = 0;
                                              $porcentAlcanzado = 0;
                                              $porcentResul = 0;
                                              foreach ($premios_perdidos as $dataperdidos) {
                                                if(!empty($dataperdidos['id_premio_perdido'])){
                                                  if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                    $nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                    $nuevoTSelected += $nuevoResult;
                                                    
                                                    $porcentSelected = $data3['cantidad_premios_plan'];
                                                    $porcentAlcanzado = $nuevoResult;
                                                    $porcentResul = ($porcentAlcanzado/$porcentSelected)*100;

                                                    if(!empty($totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']])){
                                                      $totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']]['cantidad'] += $nuevoResult;
                                                    }else{
                                                      $totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
                                                      $totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$nuevoResult];
                                                    }
                                                  }
                                                }
                                              }
                                            } 
                                          } 
                                        } 
                                      } }
                                      
                                      if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                        if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                          $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoTSelected;
                                        }
                                      }
                                    } 
                                  }
                                }} 
                              } else {
                                if(!empty($totalesPremios[$pagosR['name']]['colecciones'])){
                                  $totalesPremios[$pagosR['name']]['colecciones'] += $data['cantidad_aprobado'];
                                }else{
                                  $totalesPremios[$pagosR['name']]['colecciones'] = $data['cantidad_aprobado'];
                                }
                                
                                $maxDisponiblePremiosSeleccion = 0;
                                $opMaxDisp = 0;
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
                                      }
                                    }
                                  }
                                } }
                                
                                if($opMaxDisp==0){
                                  $maxDisponiblePremiosSeleccion = -1;
                                }
                                
                                $porcentSelected = 0;
                                $porcentAlcanzado = 0;
                                $porcentResul = 0;
                                foreach ($premios_perdidos as $dataperdidos) {
                                  if(!empty($dataperdidos['id_premio_perdido'])){
                                    if($dataperdidos['id_pedido'] == $data['id_pedido']){
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
                                          if($maxDisponiblePremiosSeleccion>0){
                                            if($nuevoResult>$maxDisponiblePremiosSeleccion){
                                              $nuevoResult = $maxDisponiblePremiosSeleccion;
                                            }
                                          }

                                          foreach ($premios_planes as $planstandard){
                                            if (!empty($planstandard['id_plan_campana'])){
                                              if ($planstandard['tipo_premio'] == $pagosR['name']){
                                                          
                                                $porcentSelected = $data['cantidad_aprobado'];
                                                $porcentAlcanzado = $nuevoResult;
                                                $porcentResul = ($porcentAlcanzado/$porcentSelected)*100;

                                                if(!empty($totalesPremios[$pagosR['name']][$planstandard['producto']])){
                                                  $totalesPremios[$pagosR['name']][$planstandard['producto']]['cantidad'] += $nuevoResult;
                                                  $totalesPremios[$pagosR['name']]['plan'] = $planstandard['nombre_plan'];
                                                }else{
                                                  $totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
                                                  $totalesPremios[$pagosR['name']][$planstandard['producto']] = ['id'=>$pagosR['id'], 'name'=>$pagosR['name'], 'plan'=>$planstandard['nombre_plan'], 'cantidad'=>$nuevoResult];
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
                                                    $nuevoResult = ($data2['cantidad_coleccion_plan']*$data2['cantidad_coleccion']) - $dataperdidos['cantidad_premios_perdidos'];
                                                    if($maxDisponiblePremiosSeleccion>0){
                                                      if($nuevoResult>$maxDisponiblePremiosSeleccion){
                                                        $nuevoResult = $maxDisponiblePremiosSeleccion;
                                                      }
                                                    }
                                                    
                                                    $premios_planes_f=[];
                                                    if(count($premios_planes3)>1){
                                                      $premios_planes_f=$premios_planes3;
                                                      $nameelemento="producto";
                                                    }else if(count($premios_planes4)>1){
                                                      $premios_planes_f=$premios_planes4;
                                                      $nameelemento="nombre_premio";
                                                    }
                                                    foreach ($premios_planes_f as $premiosP) { if(!empty($premiosP['nombre_plan'])){
                                                      if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                        if($pagosR['name']==$premiosP['tipo_premio']){
                                                          $porcentSelected = $data['cantidad_aprobado'];
                                                          $porcentPerdido = $nuevoResult;
                                                          $porcentResul = ($porcentPerdido/$porcentSelected)*100;

                                                          if(!empty($totalesPremios[$pagosR['name']][$premiosP[$nameelemento]])){
                                                            $totalesPremios[$pagosR['name']][$premiosP[$nameelemento]]['cantidad'] += $nuevoResult;
                                                            $totalesPremios[$pagosR['name']]['plan'] = $premiosP['nombre_plan'];
                                                            $totalesPremios[$pagosR['name']][$premiosP[$nameelemento]]['planess'][count($totalesPremios[$pagosR['name']][$premiosP[$nameelemento]]['planess'])] = $premiosP['nombre_plan'];
                                                            $totalesPremios[$pagosR['name']][$premiosP[$nameelemento]]['planes'] .= ", ".$premiosP['nombre_plan'];
                                                          }else{
                                                            $totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
                                                            $totalesPremios[$pagosR['name']][$premiosP[$nameelemento]] = ['id'=>$pagosR['id'], 'name'=>$pagosR['name'], 'plan'=>$premiosP['nombre_plan'], 'planes'=>$premiosP['nombre_plan'], 'planess'=>[$data2['nombre_plan']], 'cantidad'=>$nuevoResult];
                                                          }
                                                        }
                                                      }
                                                    }}
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
                              
                              }
                            }
                            
                            $cantidad_retos_actual = 0;
                            foreach ($retos as $reto){
                              if (!empty($reto['id_reto'])){
                                if ($reto['id_pedido']==$data['id_pedido']){
                                  if ($reto['cantidad_retos']>0){
                                    $cantidad_retos_actual++;
                                  }
                                }
                              }
                            }
                            if ($cantidad_retos_actual>0){ 
                              foreach ($retos as $reto){
                                if (!empty($reto['id_reto'])){
                                  if ($reto['id_pedido']==$data['id_pedido']){
                                    if ($reto['cantidad_retos']>0){
                                      for ($i=0; $i < count($acumRetos); $i++){
                                        if($acumRetos[$i]['nombre']==$reto['nombre_premio']){
                                          $acumRetos[$i]['cantidad'] += $reto['cantidad_retos'];
                                        } 
                                      } 
                                    }
                                  }
                                }
                              }
                            }
                            
                            $cantidad_PA_actual = 0;
                            foreach ($premios_autorizados as $premioAutorizado){
                              if (!empty($premioAutorizado['id_PA'])){
                                if ($premioAutorizado['id_pedido']==$data['id_pedido']){
                                  if ($premioAutorizado['cantidad_PA']>0){
                                    $cantidad_PA_actual++;
                                  }
                                }
                              }
                            }
                            if($cantidad_PA_actual>0){ 
                              foreach ($premios_autorizados as $premioAutorizado){
                                if (!empty($premioAutorizado['id_PA'])){
                                  if ($premioAutorizado['id_pedido']==$data['id_pedido']){
                                    if ($premioAutorizado['cantidad_PA']>0){
                                      for ($i=0; $i < count($acumpremioAutorizados); $i++) {
                                        if($acumpremioAutorizados[$i]['nombre']==$premioAutorizado['nombre_premio']){
                                          $acumpremioAutorizados[$i]['cantidad'] += $premioAutorizado['cantidad_PA'];
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                            
                            $cantidad_PAOBS_actual = 0;
                            foreach ($premios_autorizados_obsequio as $premioAutorizado){
                              if (!empty($premioAutorizado['id_PA'])){
                                if ($premioAutorizado['id_pedido']==$data['id_pedido']){
                                  if ($premioAutorizado['cantidad_PA']>0){
                                    $cantidad_PAOBS_actual++;
                                  }
                                }
                              }
                            }
                            if($cantidad_PAOBS_actual>0){ 
                              // $acumpremioAutorizadosOBS=[];
                              foreach ($premios_autorizados_obsequio as $premioAutorizado){
                                if (!empty($premioAutorizado['id_PA'])){
                                  if ($premioAutorizado['id_pedido']==$data['id_pedido']){
                                    if ($premioAutorizado['cantidad_PA']>0){
                                      // echo "CANTIDAD: ".$cantAUX."<br>";
                                      // $cantAUX = count($acumpremioAutorizadosAUX);
                                      // print_r($premioAutorizado);
                                      // echo "<br>";
                                      // echo " | ";
                                      // print_r($premioAutorizado['cantidad_PA']);
                                      // echo " | ";
                                      // print_r($premioAutorizado['nombre_premio']);
                                      // echo " | ";
                                      // print_r($premioAutorizado['descripcion_PA']);
                                      // echo " | ";
                                      // echo "<br><br><br><br><br>";
                                      $acumpremioAutorizadosAUX[$cantAUX]['id']=$premioAutorizado['id_PA'];
                                      $acumpremioAutorizadosAUX[$cantAUX]['cantidad']=$premioAutorizado['cantidad_PA'];
                                      $acumpremioAutorizadosAUX[$cantAUX]['nombre']=$premioAutorizado['nombre_premio'];
                                      $acumpremioAutorizadosAUX[$cantAUX]['descripcion']=$premioAutorizado['descripcion_PA'];
                                      $cantAUX++;
                                      // for ($i=0; $i < count($acumpremioAutorizadosOBS); $i++){
                                      //   if($acumpremioAutorizadosOBS[$i]['nombre']==$premioAutorizado['nombre_premio']){
                                      //     $acumpremioAutorizadosOBS[$i]['cantidad'] += $premioAutorizado['cantidad_PA'];
                                      //     $acumpremioAutorizadosOBS[$i]['descripcion'] = $premioAutorizado['descripcion_PA'];
                                      //     $acumpremioAutorizadosOBS[$i]['id']=$premioAutorizado['id_PA'];
                                      //   }
                                      // }
                                    }
                                  }
                                }
                              }
                            } 
                            // print_r($acumpremioAutorizadosAUX);
                            
                            $liddd = 0;
                            foreach ($canjeos as $canje){
                              if (!empty($canje['id_cliente'])){
                                if ($canje['id_cliente']==$data['id_cliente']){
                                  $liddd = 1;
                                }
                              }
                            }
                            if ($liddd == "1"){ 
                              $arrayt = [];
                              $numCC = 0;
                              foreach ($canjeosUnic as $canUnic) {
                                if(!empty($canUnic['nombre_catalogo'])){
                                  $arrayt[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                                  $arrayt[$numCC]['cantidad'] = 0;
                                  $numCC++;
                                }
                              }
                              foreach ($canjeos as $canje){
                                if (!empty($canje['id_cliente'])){
                                  if ($canje['id_cliente']==$data['id_cliente']){
                                    for ($i=0; $i < count($arrayt); $i++) { 
                                      if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
                                        $arrayt[$i]['cantidad']++;
                                        $arrayt2[$i]['cantidad']++;
                                      }
                                    }
                                  }
                                }
                              }
                              // foreach ($arrayt as $arr) {
                              //   if($arr['cantidad']>0){
                              //     //echo "(".$arr['cantidad'].") ".$arr['nombre']."<br>";
                              //   }
                              // }
                            }
                            
                            $num++;
                          }
                        }
                      } }

                      $dataAlcanzada = [];
                      $index=0;
                      foreach ($pagosRecorridos as $pagosR){
                        if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
                          foreach ($planes as $plan){
                            if (!empty($plan['nombre_plan'])){
                              if(!empty($totalesPremios[$plan['nombre_plan']]['colecciones'])){
                                if($totalesPremios[$plan['nombre_plan']]['colecciones']>0){
                                      // echo "<br><br><br>";
                                      // echo "<br>";
                                      $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$plan['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
                                      $tempPlanes = $lider->consultarQuery($sql0);
                                      $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                      $namePlanesTemp = $plan['nombre_plan'];
                                      //if ($plan['nombre_plan']=="Standard"){
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
                                                        
                                                      $totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
                                                      $totPerdido = $cantidadMostrar;
                                                      $totResul = ($totPerdido/$totSelected)*100;

                                                      if($planstandard['tipo_premio_producto']=="Productos"){
                                                        $dataAlcanzada[$index]['cantidad']=$cantidadMostrar;
                                                        $dataAlcanzada[$index]['descripcion']=$planstandard['producto'];
                                                        $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                        $dataAlcanzada[$index]['detalles2']="".$plan['nombre_plan'];
                                                        $dataAlcanzada[$index]['facturas']="";
                                                        $index++;
                                                      }
                                                      if($planstandard['tipo_premio_producto']=="Premios"){
                                                        $id_elemento = $planstandard['id_premio'];
                                                        $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                                                        if(count($prinv)>2){
                                                          foreach ($prinv as $inv) {
                                                            if(!empty($inv['id_inventario'])){
                                                              $cantidad_inv = $inv['unidades_inventario'];
                                                              $id_inventario = $inv['id_inventario'];
                                                              if($inv['tipo_inventario']=="Productos"){
                                                                $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                                              }
                                                              if($inv['tipo_inventario']=="Mercancia"){
                                                                $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                                              }
                                                              foreach ($inventarios as $datainv) {
                                                                if(!empty($datainv['id_elemento'])){
                                                                  $dataAlcanzada[$index]['cantidad']=($key['cantidad']*$cantidad_inv);
                                                                  $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                                                  $dataAlcanzada[$index]['detalles']="Premios Canjeados";
                                                                  $dataAlcanzada[$index]['detalles2']="";
                                                                  $dataAlcanzada[$index]['facturas']="";
                                                                  $index++;
                                                                }
                                                              }
                                                            }
                                                          }
                                                        }else{
                                                          $dataAlcanzada[$index]['cantidad']=$cantidadMostrar;
                                                          $dataAlcanzada[$index]['descripcion']=$planstandard['producto'];
                                                          $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                          $dataAlcanzada[$index]['detalles2']="".$plan['nombre_plan'];
                                                          $dataAlcanzada[$index]['facturas']="";
                                                          $index++;
                                                        }
                                                      }
                                                      // print_r($planstandard['id_premio'].$planstandard['tipo_premio_producto']);

                                                      
                                                      // echo "(".$cantidadMostrar.") ".$planstandard['producto'];  //Cantidad + nombre de Premio
                                                      // // echo " | ";
                                                      // // echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                      // echo " | ";
                                                      // echo "Premios de ".$pagosR['name']." Plan ".$plan['nombre_plan']; //Premio de X Plan X
                                                      // echo " | ";
                                                      // echo "<br>";
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
                                                  
                                                  // echo "cantidadMostrar: ".$cantidadMostrar."<br>";
                                                  // echo "ID: ".$id_elemento."<br>";

                                                  //if ($cantidadMostrar>0){
                                                    $totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
                                                    $totPerdido = $cantidadMostrar;
                                                    $totResul = ($totPerdido/$totSelected)*100;

                                                    $premioElement = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio='{$nombrePremio}' and estatus=1");
                                                    $id_elemento=0;
                                                    foreach ($premioElement as $keyss) {
                                                      if(!empty($keyss['id_premio'])){
                                                        $id_elemento = $keyss['id_premio'];
                                                      }
                                                    }
                                                    // print_r($premioElement);
                                                    $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                                                    if(count($prinv)>2){
                                                      foreach ($prinv as $inv) {
                                                        if(!empty($inv['id_inventario'])){
                                                          $cantidad_inv = $inv['unidades_inventario'];
                                                          $id_inventario = $inv['id_inventario'];
                                                          if($inv['tipo_inventario']=="Productos"){
                                                            $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                                          }
                                                          if($inv['tipo_inventario']=="Mercancia"){
                                                            $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                                          }
                                                          foreach ($inventarios as $datainv) {
                                                            if(!empty($datainv['id_elemento'])){
                                                              // echo $datainv['id_elemento']." | ".$datainv['elemento']." | ".$cantidad_inv." | ".$cantidadMostrar."<br>";
                                                              $dataAlcanzada[$index]['cantidad']=($cantidadMostrar*$cantidad_inv);
                                                              $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                                              $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                              $dataAlcanzada[$index]['detalles2']="".$plan['nombre_plan']."";
                                                              $dataAlcanzada[$index]['facturas']="";
                                                              $index++;
                                                            }
                                                          }
                                                        }
                                                      }
                                                    }else{
                                                      $dataAlcanzada[$index]['cantidad']=$cantidadMostrar;
                                                      $dataAlcanzada[$index]['descripcion']=$nombrePremio;
                                                      $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                      $dataAlcanzada[$index]['detalles2']="".$plan['nombre_plan']."";
                                                      $dataAlcanzada[$index]['facturas']="";
                                                      $index++;
                                                    }


                                                    // echo "(".$cantidadMostrar.") ".$nombrePremio;  //Cantidad + nombre de Premio
                                                    // // echo " | ";
                                                    // // echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                    // echo " | ";
                                                    // echo "Premios de ".$pagosR['name']." Plan ".$plan['nombre_plan']; //Premio de X Plan X
                                                    // echo " | ";
                                                    // echo "<br>";
                                                    // echo "<br><br><br><br>";
                                                    //}
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
                        } else { 
                                  // echo "<br>";
                                  $premios_planes_f=[];
                                  if(count($premios_planes3)>1){
                                    $premios_planes_f=$premios_planes3;
                                    $nameelemento="producto";
                                  }else if(count($premios_planes4)>1){
                                    $premios_planes_f=$premios_planes4;
                                    $nameelemento="nombre_premio";
                                  }
                                        // print_r($premios_planes4);
                                  foreach ($premios_planes_f as $planstandard){
                                    if ($planstandard['id_plan_campana']){
                                      if ($planstandard['tipo_premio']==$pagosR['name']){
                                        foreach ($totalesPremios as $key) {
                                            // echo "asd";
                                            // echo $planstandard['tipo_premio']."|";
                                            // print_r($key['name']);
                                            // echo "<br>";
                                            // echo "<br>";
                                            // echo "<br>";
                                            // echo "<br>";
                                            // echo $key['name'];
                                          if(!empty($key['name']) && $key['name'] == $planstandard['tipo_premio']){
                                            if(!empty($key[$planstandard[$nameelemento]])){
                                              if($key[$planstandard[$nameelemento]]['plan']==$planstandard['nombre_plan']){
                      
                      
                                                $cantidadMostrar = $key[$planstandard[$nameelemento]]['cantidad'];
                                                //if($cantidadMostrar>0){
                                                
                                                $totSelected = $acumColecciones;
                                                $totPerdido = $cantidadMostrar;
                                                $totResul = ($totPerdido/$totSelected)*100;
                                                
                                                if($planstandard['tipo_premio_producto']=="Productos"){
                                                  $dataAlcanzada[$index]['cantidad']=$cantidadMostrar;
                                                  $dataAlcanzada[$index]['descripcion']=$planstandard[$nameelemento];
                                                  $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                  $dataAlcanzada[$index]['detalles2']="".$key[$planstandard[$nameelemento]]['plan'];
                                                  $dataAlcanzada[$index]['facturas']="";
                                                  $index++;
                                                }
                                                if($planstandard['tipo_premio_producto']=="Premios"){
                                                  $id_elemento=$planstandard['id_premio'];
                                                  $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                                                  // $conceptos = [];
                                                  // $comparar2=mb_strtolower("premios de");
                                                  // foreach ($detallePlanes as $con) {
                                                  //   $comparar1=mb_strtolower($con);
                                                  //   if(strlen(strpos($comparar1, $comparar2))>0){
                                                  //     $con=substr($con, strlen(mb_strtolower("premios de"))+1);
                                                  //   }
                                                  //   $comparar1=mb_strtolower($con);
                                                  //   if(strlen(strpos($comparar1, $comparar2)) > 0){
                                                  //     $con=substr($con, strlen(mb_strtolower("premios de"))+1);
                                                  //   }
                                                  //   $conceptos[count($conceptos)]=$con;
                                                  // }
                                                  
                                                  $detallePlanes = $key[$planstandard[$nameelemento]]['planess'];
                                                  $detallesPl=[];
                                                  foreach ($detallePlanes as $details) {
                                                    if(empty($detallesPl[$details])){
                                                      $detallesPl[$details]=$details;
                                                    }
                                                  }
                                                  // echo $planstandard['id_premio'];
                                                  // echo "<br>";
                                                  // print_r($detallePlanes);
                                                  // echo "<br>";
                                                  // print_r($detallesPl);
                                                  // echo "<br><br><br>";
                                                  $limiteConceptos=count($detallesPl);
                                                  $indexDetallePl=1;
                                                  $key[$planstandard[$nameelemento]]['planess']="";
                                                  foreach ($detallesPl as $concep) {
                                                    $key[$planstandard[$nameelemento]]['planess'].=$concep;
                                                    if($indexDetallePl<$limiteConceptos){
                                                      $key[$planstandard[$nameelemento]]['planess'].=", ";
                                                    }
                                                    $indexDetallePl++;
                                                  }
                                                  if(count($prinv)>2){
                                                    foreach ($prinv as $inv) {
                                                      if(!empty($inv['id_inventario'])){
                                                        $cantidad_inv = $inv['unidades_inventario'];
                                                        $id_inventario = $inv['id_inventario'];
                                                        if($inv['tipo_inventario']=="Productos"){
                                                          $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                                        }
                                                        if($inv['tipo_inventario']=="Mercancia"){
                                                          $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                                        }
                                                        foreach ($inventarios as $datainv) {
                                                          if(!empty($datainv['id_elemento'])){
                                                            $dataAlcanzada[$index]['cantidad']=($cantidadMostrar*$cantidad_inv);
                                                            $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                                            $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                            $dataAlcanzada[$index]['detalles2']="".$key[$planstandard[$nameelemento]]['planess']."";
                                                            $dataAlcanzada[$index]['facturas']="";
                                                            $index++;
                                                          }
                                                        }
                                                      }
                                                    }
                                                  }else{
                                                    $dataAlcanzada[$index]['cantidad']=$cantidadMostrar;
                                                    $dataAlcanzada[$index]['descripcion']=$planstandard[$nameelemento];
                                                    $dataAlcanzada[$index]['detalles']="Premios de ".$pagosR['name'];
                                                    $dataAlcanzada[$index]['detalles2']="".$key[$planstandard[$nameelemento]]['planess']."";
                                                    $dataAlcanzada[$index]['facturas']="";
                                                    $index++;
                                                  }
                                                }

                                                // echo "(".$cantidadMostrar.") ".$planstandard['producto'];
                                                // // echo " | ";
                                                // // echo "<b>".number_format($totResul,2,',','.')."%</b>";
                                                // echo " | ";
                                                // echo "Premios de ".$pagosR['name']." de Plan ".$key[$planstandard['producto']]['plan']; //Premio de X Plan X
                                                // echo " | ";
                                                // echo "<br>";
                                                //}
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }
                                  }
                        }
                      }
                      // print_r($acumRetos);
                      foreach ($acumRetos as $key){
                        if ($key['cantidad']>0){
                          $premioElement = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio='{$key['nombre']}' and estatus=1");
                          $id_elemento=0;
                          foreach ($premioElement as $keys) {
                            if(!empty($keys['id_premio'])){
                              $id_elemento = $keys['id_premio'];
                            }
                          }
                          $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                          if(count($prinv)>2){
                            foreach ($prinv as $inv) {
                              if(!empty($inv['id_inventario'])){
                                $cantidad_inv = $inv['unidades_inventario'];
                                $id_inventario = $inv['id_inventario'];
                                if($inv['tipo_inventario']=="Productos"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                }
                                if($inv['tipo_inventario']=="Mercancia"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                }
                                foreach ($inventarios as $datainv) {
                                  if(!empty($datainv['id_elemento'])){
                                    $dataAlcanzada[$index]['cantidad']=($key['cantidad']*$cantidad_inv);
                                    $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                    $dataAlcanzada[$index]['detalles']="Retos Solicitados";
                                    $dataAlcanzada[$index]['detalles2']="";
                                    $dataAlcanzada[$index]['facturas']="";
                                    $index++;
                                  }
                                }
                              }
                            }
                          }else{
                            $dataAlcanzada[$index]['cantidad']=$key['cantidad'];
                            $dataAlcanzada[$index]['descripcion']=$key['nombre'];
                            $dataAlcanzada[$index]['detalles']="Retos Solicitados";
                            $dataAlcanzada[$index]['detalles2']="";
                            $dataAlcanzada[$index]['facturas']="";
                            $index++;
                          }
                          // echo "(".$key['cantidad'].") ".$key['nombre'];
                          // echo " | ";
                          // echo "Retos Solicitados";
                          // echo "<br>";
                        }
                      }
                      foreach ($acumpremioAutorizados as $key){
                        if ($key['cantidad']>0){
                          $premioElement = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio='{$key['nombre']}' and estatus=1");
                          $id_elemento=0;
                          foreach ($premioElement as $keys) {
                            if(!empty($keys['id_premio'])){
                              $id_elemento = $keys['id_premio'];
                            }
                          }
                          $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                          if(count($prinv)>2){
                            foreach ($prinv as $inv) {
                              if(!empty($inv['id_inventario'])){
                                $cantidad_inv = $inv['unidades_inventario'];
                                $id_inventario = $inv['id_inventario'];
                                if($inv['tipo_inventario']=="Productos"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                }
                                if($inv['tipo_inventario']=="Mercancia"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                }
                                foreach ($inventarios as $datainv) {
                                  if(!empty($datainv['id_elemento'])){
                                    $dataAlcanzada[$index]['cantidad']=($key['cantidad']*$cantidad_inv);
                                    $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                    $dataAlcanzada[$index]['detalles']="Premios Autorizados";
                                    $dataAlcanzada[$index]['detalles2']="";
                                    $dataAlcanzada[$index]['facturas']="";
                                    $index++;
                                  }
                                }
                              }
                            }
                          }else{
                            $dataAlcanzada[$index]['cantidad']=$key['cantidad'];
                            $dataAlcanzada[$index]['descripcion']=$key['nombre'];
                            $dataAlcanzada[$index]['detalles']="Premios Autorizados";
                            $dataAlcanzada[$index]['detalles2']="";
                            $dataAlcanzada[$index]['facturas']="";
                            $index++;
                          }
                          // echo "(".$key['cantidad'].") ".$key['nombre'];
                          // echo " | ";
                          // echo "Premios Autorizados";
                          // echo "<br>";
                        }
                      }
                      // print_r($acumpremioAutorizadosOBS);
                      $premiosAutorizadosxD=[];
                      $acumpremioAutorizados=[];
                      foreach ($acumpremioAutorizadosAUX as $keyss) {
                        if(!empty($acumpremioAutorizados[$keyss['nombre']])){
                          $acumpremioAutorizados[$keyss['nombre']]['cantidad']+=$keyss['cantidad'];
                        }else{
                          $acumpremioAutorizados[$keyss['nombre']]['cantidad']=$keyss['cantidad'];
                          $acumpremioAutorizados[$keyss['nombre']]['nombre']=$keyss['nombre'];
                          $acumpremioAutorizados[$keyss['nombre']]['descripcion']=$keyss['descripcion'];
                          $acumpremioAutorizados[$keyss['nombre']]['id']=$keyss['id'];
                        }
                      }
                      foreach ($acumpremioAutorizados as $key){
                        if ($key['cantidad']>0){
                          // print_r($key);
                          // echo "<br><br>";

                          // echo $key['descripcion']."<br><br>";
                          // $premioElement = $lider->consultarQuery("SELECT * FROM premios, premios_autorizados WHERE nombre_premio='{$key['nombre']}' and estatus=1");
                          // echo 
                          $premioElement = $lider->consultarQuery("SELECT * FROM premios_autorizados, premios WHERE premios.id_premio=premios_autorizados.id_premio and premios_autorizados.id_PA={$key['id']}");
                          $id_elemento=0;
                          foreach ($premioElement as $keys) {
                            if(!empty($keys['id_premio'])){
                              $id_elemento = $keys['id_premio'];
                            }
                          }
                          // echo "id_elemento: ".$id_elemento."<br>";
                          $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                          // print_r($prinv);
                          if(count($prinv)>2){
                            foreach ($prinv as $inv) {
                              if(!empty($inv['id_inventario'])){
                                $cantidad_inv = $inv['unidades_inventario'];
                                $id_inventario = $inv['id_inventario'];
                                if($inv['tipo_inventario']=="Productos"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                }
                                if($inv['tipo_inventario']=="Mercancia"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                }
                                foreach ($inventarios as $datainv) {
                                  if(!empty($datainv['id_elemento'])){
                                    $dataAlcanzada[$index]['cantidad']=($key['cantidad']*$cantidad_inv);
                                    $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                    $dataAlcanzada[$index]['detalles']="Premios Adicionales";
                                    $dataAlcanzada[$index]['detalles']=$key['descripcion'];
                                    $dataAlcanzada[$index]['detalles2']="";
                                    $dataAlcanzada[$index]['facturas']="";
                                    $index++;
                                  }
                                }
                              }
                            }
                          }else{
                            $dataAlcanzada[$index]['cantidad']=$key['cantidad'];
                            $dataAlcanzada[$index]['descripcion']=$key['nombre'];
                            $dataAlcanzada[$index]['detalles']="Premios Adicionales";
                            $dataAlcanzada[$index]['detalles']=$key['descripcion'];
                            $dataAlcanzada[$index]['detalles2']="";
                            $dataAlcanzada[$index]['facturas']="";
                            $index++;
                          }
                          // echo "(".$key['cantidad'].") ".$key['nombre'];
                          // echo " | ";
                          // echo "Premios Adicionales";
                          // echo "<br>";
                        }
                      }
                      foreach ($arrayt2 as $key) {
                        if($key['cantidad']>0){
                          // $premioElement = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio='{$key['nombre']}' and estatus=1");
                          $premioElement = $lider->consultarQuery("SELECT * FROM catalogos WHERE nombre_catalogo='{$key['nombre']}' and estatus=1");
                          $id_elemento=0;
                          foreach ($premioElement as $keys) {
                            if(!empty($keys['id_premio'])){
                              $id_elemento = $keys['id_premio'];
                            }
                          }
                          // echo $id_elemento." | ";
                          $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$id_elemento} and estatus=1");
                          // print_r($prinv);
                          if(count($prinv)>2){
                            foreach ($prinv as $inv) {
                              if(!empty($inv['id_inventario'])){
                                $cantidad_inv = $inv['unidades_inventario'];
                                $id_inventario = $inv['id_inventario'];
                                if($inv['tipo_inventario']=="Productos"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_producto as id_elemento, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$id_inventario}");
                                }
                                if($inv['tipo_inventario']=="Mercancia"){
                                  $inventarios = $lider->consultarQuery("SELECT *, id_mercancia as id_elemento, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$id_inventario}");
                                }
                                foreach ($inventarios as $datainv) {
                                  if(!empty($datainv['id_elemento'])){
                                    $dataAlcanzada[$index]['cantidad']=($key['cantidad']*$cantidad_inv);
                                    $dataAlcanzada[$index]['descripcion']=$datainv['elemento'];
                                    $dataAlcanzada[$index]['detalles']="Premios Canjeados";
                                    $dataAlcanzada[$index]['detalles2']="";
                                    $dataAlcanzada[$index]['facturas']="";
                                    $index++;
                                  }
                                }
                              }
                            }
                          }else{
                            $dataAlcanzada[$index]['cantidad']=$key['cantidad'];
                            $dataAlcanzada[$index]['descripcion']=$key['nombre'];
                            $dataAlcanzada[$index]['detalles']="Premios Canjeados";
                            $dataAlcanzada[$index]['detalles2']="";
                            $dataAlcanzada[$index]['facturas']="";
                            $index++;
                          }

                          // echo "(".$key['cantidad'].") ".$key['nombre'];
                          // echo " | ";
                          // echo "Premios Canjeados";
                          // echo "<br>";
                        }
                      }

                      ?>
                    <table class="table text-center" id="">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th style="width:10%;text-align:center;">Cant. Unidades</th>
                          <th style="width:35%;text-align:left;">Descripción</th>
                          <th style="width:55%;text-align:left;"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach ($dataAlcanzada as $data) {
                            ?>
                              <tr style='padding:0;margin:0;'>
                                <td style="text-align:center;"><?=$data['cantidad']; ?></td>
                                <td style="text-align:left;"><?=$data['descripcion']; ?></td>
                                <td style="text-align:left;"><?php echo $data['detalles']; if($data['detalles2']!=""){ echo " <small>(".$data['detalles2'].")</small>"; } ?></td>
                              </tr>
                            <?php
                            // print_r($data);
                            // echo "<br>";
                          }
                        ?>
                      </tbody>
                    </table>
                    <?php 
                      $_SESSION['GenerarPremiosAlcanzadosResumen']=$dataAlcanzada;

                      // print_r($acumPremios); 
                      // foreach ($dataAlcanzada as $key) {
                      //   // echo $key['name']." => ";
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

<?php if(!empty($response)){ ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
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
  var lideres = parseInt($("#selectedLideres").val());
  var rlideres = false;
  if(lideres > 0){
    rlideres = true;
    $(".error_selected_lider").html("");
  }else{
    rlideres = false;
    $(".error_selected_lider").html("Debe Seleccionar un Líder");      
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
  if( rselected==true && rlideres==true){
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
