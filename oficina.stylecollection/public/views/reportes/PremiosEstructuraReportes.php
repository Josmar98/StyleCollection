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
        <small><?php if(!empty($action)){echo "Planes y Premios Por Estructura";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Planes y Premios Por Estructura";} echo " "; ?></li>
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
              <h3 class="box-title">Reporte de <?php echo "Planes y Premios Por Estructura"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-12">

                        <?php 
                        $pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id']; ?>
                        <input type="hidden" name="route" value="Reportes">
                        <input type="hidden" name="action" value="PremiosEstructura">
                        <label for="selectedPedido"><b style="color:#000;">Seleccionar Pedido de Campaña</b></label>
                        <select id="selectedPedido" name="P" class="form-control select2" style="width:100%;">
                            <option value="0"></option>
                              <?php 
                                if(count($pedidos)>1){
                                  foreach ($pedidos as $key) {
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

                    <div class="form-group col-sm-12">
                        <label for="clienteSelected"><b style="color:#000;">Seleccione Líder</b></label>
                        <select id="clienteSelected" name="L" class="form-control select2" style="width:100%;">
                          <option value="0"></option>
                          <?php foreach ($clientess as $data):
                            if(!empty($data['id_cliente'])){ ?>
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
                              <option value="<?=$data['id_cliente']?>"
                                <?php if(!empty($id_cliente)){if($data['id_cliente']==$id_cliente){echo "selected";}} ?>
                                    >
                                      <?php echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']; ?>
                                    </option>
                              <?php endif; ?>
                           <?php }  
                           endforeach; ?>
                        </select>
                        <span class="errors error_clienteSelected"></span>
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
                          <a href="?route=Reportes&action=GenerarPremiosEstructura&id=<?=$id_despacho?>&lider=<?=$id_cliente?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table class="table text-center " id="">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th style="width:10%">Nº</th>
                          <th style="width:20%">Lider</th>
                          <th style="width:17.5%">Colecciones</th>
                          <th style="width:17.5%">Planes Seleccionado</th>
                          <th style="width:35%">Premios Seleccionado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
                          // $premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
                        ?>
                        <?php $num = 1; 
                          $acumColecciones = 0;
                          $nume = 0;
                          $nameTipoPago = "";
                          foreach ($pagosRecorridos as $pagosR){
                            if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
                              $nameTipoPago = $pagosR['name'];
                            }
                          }
                          if(count($planes)>1){
                            foreach ($planes as $plan) {
                              if(!empty($plan['nombre_plan'])){
                                $nume2 = 0;
                                $acumPlanes[$plan['nombre_plan']]=0;
                                $acumPremios[$nume]['plan'] = $plan['nombre_plan'];
                                $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$plan['id_plan']} and premios_planes_campana.tipo_premio='{$nameTipoPago}'";
                                $tempPlanes = $lider->consultarQuery($sql0);
                                if(!empty($tempPlanes[0])){
                                  $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                  $namePlanesTemp = $plan['nombre_plan'];
                                  $sql1 = "";
                                  $nameTxtPrem = "";
                                  if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){
                                    $sql1 = "SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = '{$nameTPlanesTemp}' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and premios_planes_campana.tipo_premio='{$nameTipoPago}'";
                                    $nameTxtPrem = "producto";
                                  }
                                  if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Premios")){
                                    $sql1 = "SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio, planes_campana.opcion_plan FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.nombre_plan='{$plan['nombre_plan']}'";
                                    $nameTxtPrem = "nombre_premio";
                                  }
                                  $premios = $lider->consultarQuery($sql1);

                                  if(count($premios)>1){
                                    foreach ($premios as $premio) {
                                      if(!empty($premio[$nameTxtPrem])){
                                      // if(!empty($premio['nombre_premio'])){
                                        if($plan['id_plan'] == $premio['id_plan']){
                                          // $acumPremios[$nume]['premio'][$nume2]['nombre'] = $premio['nombre_premio'];
                                          $acumPremios[$nume]['premio'][$nume2]['nombre'] = $premio[$nameTxtPrem];
                                          $acumPremios[$nume]['premio'][$nume2]['cantidad'] = 0;
                                          if(!empty($premio['opcion_plan']) && $premio['opcion_plan']==1){
                                            $acumPremios[$nume]['premio'][$nume2]['opcion_plan'] = $premio['opcion_plan'];
                                          }else{
                                            $acumPremios[$nume]['premio'][$nume2]['opcion_plan'] = 0;
                                          }
                                          if(!empty($premio['opcion_plan']) && $premio['opcion_plan']==1){
                                            $acumPremios[$nume]['premio_seg'][$nume2]['nombre'] = $premio[$nameTxtPrem];
                                            $acumPremios[$nume]['premio_seg'][$nume2]['cantidad'] = 0;
                                          }
                                          $nume2++;
                                        }
                                      }
                                    }
                                  }
                                  $nume++;
                                }
                              }
                            }
                            
                            // foreach ($acumPremios as $key) {
                              // print_r($key);
                              // echo "<br><br>";
                            // }
                            // print_r($acumPremios);

                          }
                          $nameTipoPagoSeleccion = "";
                        ?>
                        <?php foreach ($pedidosClientes as $data){ if(!empty($data['id_pedido'])){ ?>
                          <?php foreach ($nuevosClientes as $data2){ if(!empty($data2['id_cliente'])){ ?>
                            <?php if($data['id_cliente'] == $data2['id_cliente']){ ?>

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
                                      echo number_format($data2['cedula'],0,'','.')." ".$data2['primer_nombre']." ".$data2['primer_apellido']." <br> ".
                                          $data['cantidad_aprobado']." Colecciones Aprobadas";
                                    ?>
                                </td>
                                <td style="width:70%;text-align:justify;" colspan="3">
                                  <table class='table table-striped table-hover' style='background:none'>
                                    <?php foreach ($pagosRecorridos as $pagosR){ ?>
                                      <?php if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){ ?>
                                            <?php foreach ($planesCol as $data3): if(!empty($data3['id_cliente'])): ?>
                                                <?php if ($data['id_pedido'] == $data3['id_pedido']): ?>
                                                    <?php if ($data3['cantidad_coleccion_plan']>0): ?>
                                                        <tr >
                                                            <td style="text-align:left;width:25%">
                                                              <?php 
                                                                $colsss = ($data3['cantidad_coleccion']*$data3['cantidad_coleccion_plan']); 
                                                                $acumColecciones += $colsss;
                                                                echo $colsss." Colecciones ";
                                                              ?>
                                                            </td>
                                                            <td style="text-align:left;width:25%">
                                                            <?php echo $data3['cantidad_coleccion_plan']." Plan ".$data3['nombre_plan']."<br>"; 
                                                              $acumPlanes[$data3['nombre_plan']] += $data3['cantidad_coleccion_plan'];
                                                            ?>
                                                            </td>

                                                            <td style="width:50%;">
                                                              <?php //echo $data3['id_plan']." ".$data3['nombre_plan']."<br>"; ?>
                                                                <table class='' style='background:none;width:100%;'> 
                                                                  <?php
                                                                    $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$data3['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
                                                                    $tempPlanes = $lider->consultarQuery($sql0);
                                                                    // print_r($tempPlanes);
                                                                    $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                                                    $namePlanesTemp = $data3['nombre_plan'];
                                                                    //echo $pagosR['name']." ". $data3['id_plan']." - ".$namePlanesTemp." - (".$colsss.") ".$nameTPlanesTemp." - ".$data['id_pedido']."<br>";
                                                                    $sql1 = "";
                                                                    $sql2 = "";
                                                                    $cantTxtPrem = 0;
                                                                    $namecantTxtPrem = "";
                                                                    $nameTxtPrem = "";
                                                                    // echo $nameTPlanesTemp;
                                                                    if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){
                                                                      $sql1 = "SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = '{$nameTPlanesTemp}' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
                                                                      // $cantTxtPrem = $colsss;
                                                                      $nameTxtPrem = "producto";
                                                                    }
                                                                    if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Premios")){
                                                                      $sql1 = "SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_pedido = {$data['id_pedido']}";


                                                                      $sql2 = "SELECT * FROM premio_coleccion_opcion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion_opcion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion_opcion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_pedido = {$data['id_pedido']}";
                                                                      // $premioscol = $lider->consultarQuery($sql1);
                                                                      //echo "<br><br>";
                                                                      $namecantTxtPrem = "cantidad_premios_plan";
                                                                      $nameTxtPrem = "nombre_premio";
                                                                    }
                                                                    if($sql1!=""){
                                                                      $premios_planes_seleccionados = $lider->consultarQuery($sql1);
                                                                      if($sql2!=""){
                                                                        $premioscolSegunda = $lider->consultarQuery($sql2);
                                                                        for ($x=0; $x < count($premios_planes_seleccionados)-1; $x++) { 
                                                                          if($premios_planes_seleccionados[$x]['opcion_plan']){
                                                                            foreach ($premioscolSegunda as $opciones) {
                                                                              if( ($premios_planes_seleccionados[$x]['id_tipo_coleccion'] == $opciones['id_tipo_coleccion']) && ($premios_planes_seleccionados[$x]['id_tppc'] == $opciones['id_tppc']) && ($premios_planes_seleccionados[$x]['id_ppc'] == $opciones['id_ppc']) && ($premios_planes_seleccionados[$x]['id_tipo_coleccion'] == $opciones['id_tipo_coleccion']) && ($premios_planes_seleccionados[$x]['id_plan_campana'] == $opciones['id_plan_campana']) && ($premios_planes_seleccionados[$x]['id_premio'] == $opciones['id_premio']) ){
                                                                                $premios_planes_seleccionados[$x]['segunda_'.'cantidad_premios_plan']=$opciones['cantidad_premios_plan'];
                                                                                $premios_planes_seleccionados[$x]['segunda_'.'id_premio']=$opciones['id_premio'];
                                                                                $premios_planes_seleccionados[$x]['segunda_'.'nombre_premio']=$opciones['nombre_premio'];
                                                                                $premios_planes_seleccionados[$x]['segunda_'.'opcion_plan']=$opciones['opcion_plan'];
                                                                                $premios_planes_seleccionados[$x]['segunda_'.'nombre_plan']=$opciones['nombre_plan'];
                                                                              }
                                                                            }
                                                                          }
                                                                        }
                                                                      }
                                                                      foreach ($premios_planes_seleccionados as $dataPrem) {
                                                                        if(!empty($dataPrem['id_plan_campana'])){
                                                                          if($namecantTxtPrem==""){
                                                                            $cantTxtPrem = $colsss;
                                                                          }else{
                                                                            $cantTxtPrem = $dataPrem[$namecantTxtPrem];
                                                                          }
                                                                          for ($i=0; $i < count($acumPremios); $i++) { 
                                                                            if($acumPremios[$i]['plan'] == $data3['nombre_plan']){
                                                                              if(!empty($acumPremios[$i]['premio'])){
                                                                                for ($j=0; $j < count($acumPremios[$i]['premio']); $j++) { 
                                                                                  if($acumPremios[$i]['premio'][$j]['nombre']==$dataPrem[$nameTxtPrem]){
                                                                                    $acumPremios[$i]['premio'][$j]['cantidad'] += $cantTxtPrem;
                                                                                  }
                                                                                }
                                                                              }
                                                                            }
                                                                          }
                                                                          if($cantTxtPrem>0){
                                                                          ?>
                                                                            <tr>
                                                                              <td style="text-align:left;">
                                                                                <?php echo "(".$cantTxtPrem.") ".$dataPrem[$nameTxtPrem]."<br>"; ?>
                                                                              </td>
                                                                            </tr>
                                                                          <?php
                                                                          }
                                                                          //echo "(".$cantTxtPrem.") ".$dataPrem[$nameTxtPrem]." - <br>";
                                                                        }
                                                                      }

                                                                      if($data3['opcion_plan']==1 && count($premios_planes_seleccionados)>1){
                                                                        ?>
                                                                          <tr style="background:#CCCCCC55;width:100%;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;">
                                                                            <th style="text-align:center;">
                                                                              <span style="font-size:1.2em;">Segunda Opción</span>
                                                                            </th>
                                                                          </tr>
                                                                        <?php
                                                                        foreach ($premios_planes_seleccionados as $dataPrem) {
                                                                          if(!empty($dataPrem['id_plan_campana'])){
                                                                            $cantTxtPremSec = "";
                                                                            if($namecantTxtPrem==""){
                                                                              $cantTxtPrem = $colsss;
                                                                            }else{
                                                                              $cantTxtPrem = $dataPrem[$namecantTxtPrem];
                                                                              if($dataPrem['opcion_plan']==1){
                                                                                $cantTxtPremSec=$dataPrem['segunda_'.$namecantTxtPrem];
                                                                              }
                                                                            }
                                                                            for ($i=0; $i < count($acumPremios); $i++) { 
                                                                              if($acumPremios[$i]['plan'] == $data3['nombre_plan']){
                                                                                if(!empty($acumPremios[$i]['premio_seg'])){
                                                                                  for ($j=0; $j < count($acumPremios[$i]['premio_seg']); $j++) { 

                                                                                    if($acumPremios[$i]['premio_seg'][$j]['nombre']==$dataPrem[$nameTxtPrem]){
                                                                                      $acumPremios[$i]['premio_seg'][$j]['cantidad'] += $cantTxtPremSec;
                                                                                    }

                                                                                  }
                                                                                }
                                                                              }
                                                                            }
                                                                            if($cantTxtPremSec>0){
                                                                            ?>
                                                                              <tr style="width:100%;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;">
                                                                                <td style="text-align:left;padding-left:10px;padding-right:10px;">
                                                                                  <?php echo "(".$cantTxtPremSec.") ".$dataPrem[$nameTxtPrem]."<br>"; ?>
                                                                                </td>
                                                                              </tr>
                                                                            <?php
                                                                            }
                                                                            //echo "(".$cantTxtPrem.") ".$dataPrem[$nameTxtPrem]." - <br>";
                                                                          }
                                                                        }
                                                                      }
                                                                      // echo $sql1."<br><br>";
                                                                      // print_r($premios_planes_seleccionados[0][$nameTxtPrem]); echo "<br><br>";
                                                                    }

                                                                    ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif; endforeach; ?>
                                      <?php } ?>
                                    <?php } ?>
                                  </table>
                                </td>
                              </tr>

                              <?php $num++; ?>
                                <?php } ?>
                              <?php } ?>

                            <?php } ?>
                          <?php } } ?>
                        <?php } } ?>
                          <tr style="background:#CCc">
                            <td></td>
                            <td></td>
                            <td style="text-align:left;"><?=$acumColecciones?> Colecciones</td>
                            <td colspan="2" style="text-align:left;">
                              <table class="table table-hover" style="width:100%;background:none;">
                              <?php 
                                foreach ($planes as $plan){
                                  if (!empty($plan['nombre_plan'])){
                                    if($acumPlanes[$plan['nombre_plan']]>0){ ?>
                                      <tr>
                                        <td style="text-align:left;width:31%;">
                                          <?php echo $acumPlanes[$plan['nombre_plan']]." Plan ".$plan['nombre_plan']."<br>"; ?>
                                        </td>
                                        <td style="text-align:left;width:64%;">
                                          <?php 
                                            $opcion_plan = 0;
                                            foreach ($acumPremios as $prem){
                                              if ($plan['nombre_plan']==$prem['plan']){
                                                foreach ($prem['premio'] as $prem2){
                                                  $opcion_plan = $prem2['opcion_plan'];
                                                  //if($prem2['cantidad']>0){
                                                    echo "(".$prem2['cantidad'].") ".$prem2['nombre']."<br>";
                                                  // }
                                                }
                                              }
                                            }

                                            if($opcion_plan==1){
                                              echo "<div style='border:1px solid #000;'>";
                                              echo "<span style='display:block;width:100%;text-align:center;background:#DCDCDC;'><b>Segunda Opción</b></span>";
                                              echo "<span style='display:block;width:100%;padding-left:10px;padding-right:10px;'>";
                                              foreach ($acumPremios as $prem){
                                                if ($plan['nombre_plan']==$prem['plan']){
                                                    foreach ($prem['premio_seg'] as $prem3){
                                                      //if($prem3['cantidad']>0){
                                                        echo "(".$prem3['cantidad'].") ".$prem3['nombre']."<br>";
                                                      // }
                                                    }
                                                }
                                              }
                                              echo "</span>";
                                              echo "</div>";
                                            }
                                          ?>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                  }
                                }
                              ?>
                              </table>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                    <?php 
                      // print_r($acumPremios[0]);
                      // echo "<br><br><br>";
                      // foreach ($acumPremios as $key){
                        // print_r($key);
                        // echo "<br><br>";
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

  var cliente = parseInt($("#clienteSelected").val());
  var rcliente = false;
  if(cliente > 0){
    rcliente = true;
    $(".error_clienteSelected").html("");
  }else{
    rcliente = false;
    $(".error_clienteSelected").html("Debe Seleccionar un Líder");      
  }

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
  if( rselected==true && rcliente==true){
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
