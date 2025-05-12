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
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo "Pedidos Aprobados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Pedidos Aprobados";} echo " "; ?></li>
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
              <h3 class="box-title">Reporte de <?php echo "Pedidos Aprobados"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">
              <!-- BUSQUEDA GUARDADA -->
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <?php
                      $name_reporte = $_GET['action'];
                      $rutaURL = $_SERVER['QUERY_STRING'];
                      $campanasAbiertas = $lider->consultarQuery("SELECT * FROM campanas WHERE estado_campana=1 and estatus=1");
                      $stringIdCampanas = "";
                      $limiteCampanasAbiertas=count($campanasAbiertas)-1;
                      $indexCampAbiertas=1;
                      foreach ($campanasAbiertas as $camps) {
                        if(!empty($camps['id_campana'])){
                          $stringIdCampanas.=$camps['id_campana'];
                          if($indexCampAbiertas<$limiteCampanasAbiertas){
                            $stringIdCampanas.=", ";
                          }
                          $indexCampAbiertas++;
                        }
                      }
                      $busquedasG = $lider->consultarQuery("SELECT * FROM historial_busqueda_reportes WHERE historial_busqueda_reportes.name_reporte='{$name_reporte}' and historial_busqueda_reportes.id_campana IN ({$stringIdCampanas})");
                      // foreach ($busquedasG as $busqGuardada) {
                      //   if(!empty($busqGuardada['id_campana'])){
                      //     print_r($busqGuardada);
                      //     echo "<br><br>";
                      //   }
                      // }
                    ?>
                    <label for="busquedasguardadas">Busquedas Guardadas</label>
                    <select class="form-control select2" id="busquedasguardadas">
                      <option value=""></option>
                      <?php
                        foreach ($busquedasG as $busqGuardada) {
                          if(!empty($busqGuardada['id_campana'])){
                            ?>
                            <option <?php if($rutaURL==$busqGuardada['rutaURL']){ echo "selected"; } ?> value="<?=$busqGuardada['rutaURL']; ?>"><?=$busqGuardada['fecha_guardado']." ".$busqGuardada['hora_guardado']." - Ruta ".$busqGuardada['nombre_ruta']; ?></option>
                            <?php
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-xs-12">
                    <span class="btn enviar2 cargarBusqueda">Cargar busqueda</span>
                  </div>
                </div>
                <hr>
              </div>
              <!-- BUSQUEDA GUARDADA -->


              <div class="box-body">
                    
                  <div class="row">

                    <?php 
                      $pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id']; 
                    ?>
                    <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                    <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                    
                    
                    <div class="form-group col-sm-12">
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
                    
                    <div class="form-group col-sm-4">
                      <label for="conductor">Nombre del Conductor: </label>
                      <input type="text" class="form-control conductor" id="conductor" name="conductor" value="<?php if(isset($_GET['conductor'])){ echo $_GET['conductor']; } ?>" required>
                      <span class="errors error_conductor"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="cedula">Cedula del Conductor: </label>
                      <input type="text" class="form-control cedula" id="cedula" name="cedula" value="<?php if(isset($_GET['cedula'])){ echo $_GET['cedula']; } ?>" required>
                      <span class="errors error_cedula"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="tlf">Telefono del Conductor: </label>
                      <input type="text" maxlength="12" class="form-control tlf" id="tlf" name="tlf" value="<?php if(isset($_GET['tlf'])){ echo $_GET['tlf']; } ?>" required>
                      <span class="errors error_tlf"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="vehiculo">Tipo de Vehículo: </label>
                      <input type="text" class="form-control vehiculo" id="vehiculo" name="vehiculo" value="<?php if(isset($_GET['vehiculo'])){ echo $_GET['vehiculo']; } ?>" required>
                      <span class="errors error_vehiculo"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="placa">Placa del Vehículo: </label>
                      <input type="text" class="form-control placa" id="placa" name="placa" value="<?php if(isset($_GET['placa'])){ echo $_GET['placa']; } ?>" required>
                      <span class="errors error_placa"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="ruta">Nombre de la Ruta: </label>
                      <input type="text" class="form-control ruta" id="ruta" name="ruta" value="<?php if(isset($_GET['ruta'])){ echo $_GET['ruta']; } ?>" required>
                      <span class="errors error_ruta"></span>
                    </div>
                    

                    <!-- <div class="form-group col-sm-12">
                        <label for="selectedLideres"><b style="color:#000;">Seleccionar Líderes</b></label>
                        <select id="selectedLideres" name="L[]" class="form-control select2" style="width:100%;">
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
                    </div> -->

                    
                    
                  </div>
                  <input type="hidden" id="limiteElementos" value="<?=$limiteElementos; ?>">
                  <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                  <div class="row" style="padding:0px 15px;">
                    <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                      <input type="text" class="form-control zonas" title="<?=$z; ?>" id="zona<?=$z; ?>" name="zona[]" placeholder="Oeste | Centro" value="<?php echo $zonasss[($z-1)]; ?>">
                      <span id="error_zona<?=$z; ?>" class="errors"></span>
                    </div>
                    <div style="width:85%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                      <select class="form-control select2 lideres" id="lider<?=$z; ?>" name="L[]"  style="width:100%">
                        <option value=""></option>
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
                      <span id="error_lider<?=$z; ?>" class="errors"></span>
                    </div>
  
                    
                  </div>
                  <div style='width:100%;'>
                    <span style='float:left' id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>"><b>+</b></span>
                    <span style='float:right' id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger box-inventarios<?=$z; ?> box-inventario d-none"><b>-</b></span>
                  </div>
                <?php } ?>
                
                <input type="hidden" id="cantidad_elementos" name="cantidad_elementos" value="1">
                  
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
                    <div class="col-xs-12 text-right">
                      <button class="btn enviar2 guardarUrl" value="<?php echo $_SERVER['QUERY_STRING']; ?>">Guardar Busqueda</button>
                    </div>
                  </div>
                </div>
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
                          <?php
                            $indexL = "";
                            foreach ($clientesss as $key => $value){
                              $indexL .= "&L%5B%5D=".$value;
                            }
                            $routePDF = "route=".$_GET['route']."&action=Generar".substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], "action=")+strlen("action="));
                          ?>
                          <a href="?<?=$routePDF; ?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table style="width:100%;">
                      <tr>
                        <td style="width:25%;"><b>Conductor: </b></td>
                        <td style="width:40%;"><?=$_GET['conductor']; ?></td>
                        <td style="width:35%;"><u><?=$_GET['ruta']; ?></u></td>
                      </tr>
                      <tr>
                        <td><b>C.I.: </b></td>
                        <td><?=$_GET['cedula']; ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><b>Nro. Tlf. Contacto.: </b></td>
                        <td><?=$_GET['tlf']; ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><b>Tipo de Vehiculo: </b></td>
                        <td><?=$_GET['vehiculo']; ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><b>Placa: </b></td>
                        <td><?=$_GET['placa']; ?></td>
                        <td></td>
                      </tr>
                    </table>
                    <br><br>
                    <?php
                      // print_r($listaPromociones);
                    ?>
                    <table class="table table-bordered table-striped text-center" style="font-size:1.1em;">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                            <th></th>
                            <th colspan="2">Líderes</th>
                            <th colspan="<?=count($tipoColecciones); ?>">Colecciones</th>
                            <th colspan="<?=count($listaPromociones); ?>">Promociones</th>
                        </tr>
                        <tr>
                          <th style=''>Nº</th>
                          <th style=''>Nombre y Apellido</th>
                          <th style=''>Zona</th>
                          <?php
                            foreach ($tipoColecciones as $tipoCol) {
                              ?>
                              <th style='width:10%;'><?=$tipoCol['name']; ?></th>
                              <?php
                            }
                            foreach ($listaPromociones as $listPromo) {
                              ?>
                              <th style='width:10%;'><?=$listPromo['name']; ?></th>
                              <?php
                            }
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <form action="">

                        <?php 
                          $num = 1;
                          $resumenTotal=[];
                          foreach ($tipoColecciones as $tipoCol) {
                            $total_colecciones[$tipoCol['name']]=0;
                          }
                          foreach ($listaPromociones as $listPromo) {
                            $total_colecciones[$listPromo['name']]=0;
                          }
                          $index=0;
                          // for ($i=0; $i < 5; $i++) { 
                          foreach ($zonasClientes as $zone) {
                            foreach ($facturados as $pedido) {
                              if($pedido['id_cliente']==$zone['id_cliente']){

                                $resumenTotal[$index]['cliente']=$pedido['cliente'];
                                $resumenTotal[$index]['zona']=$zone['zona'];
                                ?>
                                  <tr>
                                    <td style='width:10%;'><?=$num++; ?></td>
                                    <td><?=$pedido['cliente']; ?></td>
                                    <td><?=$zone['zona']; ?></td>
                                    <?php
                                      foreach ($tipoColecciones as $tipoCol) {
                                        if(empty($pedido[$tipoCol['name']])){
                                          $pedido[$tipoCol['name']]=0;
                                        }
                                        $resumenTotal[$index][$tipoCol['name']]=$pedido[$tipoCol['name']];
                                        $total_colecciones[$tipoCol['name']]+=$pedido[$tipoCol['name']];
                                        ?>
                                          <td><?=$pedido[$tipoCol['name']]." Cols."; ?></td>
                                        <?php
                                      }
                                      foreach ($listaPromociones as $listPromo) {
                                        if(empty($pedido[$listPromo['name']])){
                                          $pedido[$listPromo['name']]=0;
                                        }
                                        $resumenTotal[$index][$listPromo['name']]=$pedido[$listPromo['name']];
                                        $total_colecciones[$listPromo['name']]+=$pedido[$listPromo['name']];
                                        ?>
                                          <td><?=$pedido[$listPromo['name']]." Promo."; ?></td>
                                        <?php
                                      }
                                    ?>
                                  </tr>
                                <?php
                                $index++;
                              }
                            }
                          }
                          // }
                        ?>
                            </form>

                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <?php
                            foreach ($tipoColecciones as $tipoCol) {
                              ?>
                              <th><?=$total_colecciones[$tipoCol['name']]." Cols."; ?></th>
                              <?php
                            }
                            foreach ($listaPromociones as $listPromo) {
                              ?>
                              <th><?=$total_colecciones[$listPromo['name']]." Promo."; ?></th>
                              <?php
                            }
                          ?>
                        </tr>
                      </tbody>
                    </table>
                    <table style="width:100%;">
                        <tr>
                            <td><b>Despachado Por: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                            <td><b>Conductor: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                        </tr>
                        <tr>
                            <td><b>Nombre y Apellido: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                            <td><b>Nombre y Apellido: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                        </tr>
                        <tr>
                            <td><b>C.I.: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                            <td><b>C.I.: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                        </tr>
                        <tr>
                            <td><b>Firma: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                            <td><b>Firma: </b></td>
                            <td><span style='color:transparent;border-bottom:1px solid #878787;'>___________________________________</span></td>
                        </tr>
                    </table>
                    <?php
                      $_SESSION['resumenTotalSalidaAlmacenColecciones']=$resumenTotal;
                      $_SESSION['resumenTotalSalidaAlmacenColeccionestc']=$tipoColecciones;
                      $_SESSION['resumenTotalSalidaAlmacenColeccioneslp']=$listaPromociones;
                    //   foreach($resumenTotal as $key){
                    //     print_r($key);
                    //   }
                    //   echo "<br>";
                    //   echo "<br>";
                    //   print_r($_SERVER['QUERY_STRING']);
                    //   echo "<br>";
                    //   echo "<br>";
                    //   print_r($_SERVER);
                      
                    ?>

                    <!-- <table class="table table-bordered table-striped text-center" style="font-size:1.1em;">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th>Nº</th>
                          <th>Lider</th>
                          <th>Pedido Solicitado</th>
                          <th>Pedido Solicitado Colecciones</th>
                          <th>Pedido Aprobado </th>
                          <th>Pedido Aprobado Colecciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num = 1; 
                          $cantidadPedido = 0;
                          $cantidadAprobado = 0;

                          $sumatorias = [];
                          $sumatoriasPed = [];

                          for ($i=0; $i < count($pedidosClientes)-1; $i++) {
                            $ped = $pedidosClientes[$i];
                            $sum = 0;
                            $sum=$ped['cantidad_pedido'];
                            $pedSec = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido = {$ped['id_pedido']}");
                            foreach ($pedSec as $key) {
                              if(!empty($key['id_pedido_sec'])){
                                $sum+=$key['cantidad_pedido_sec'];
                              }
                            }
                            $pedidosClientes[$i]['cantidad_pedido_total']=$sum;
                            $ped = $pedidosClientes[$i];
                          }
                        ?>
                        <?php foreach ($pedidosClientes as $data): if(!empty($data['id_pedido'])):?>
                          <?php foreach ($clientess as $data2): if(!empty($data2['id_cliente'])): ?>
                            <?php if($data['id_cliente'] == $data2['id_cliente']): ?>
                             
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
                                  $query2 = "SELECT * FROM despachos_secundarios, pedidos_secundarios WHERE despachos_secundarios.id_despacho_sec=pedidos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho={$_GET['P']} and pedidos_secundarios.id_despacho={$_GET['P']} and pedidos_secundarios.id_cliente={$data['id_cliente']}";
                                  $pedSec = $lider->consultarQuery($query2);
                                  // echo $query2."<br><br>";
                              ?>

                                <tr class="elementTR">
                                  <td><?=$num;?></td>
                                  <td>
                                      <?php 
                                        echo number_format($data2['cedula'],0,'','.')." ".$data2['primer_nombre']." ".$data2['primer_apellido'];
                                      ?>
                                  </td>
                                  <td>
                                      <?php 
                                        echo $data['cantidad_pedido_total']." Colecciones";
                                        $cantidadPedido += $data['cantidad_pedido_total'];
                                      ?>
                                  </td>
                                  <td>
                                    <?php 
                                      echo $data['cantidad_pedido']." Cols. Productos<br>";
                                      if(!empty($sumatorias['Productos'])){
                                        $sumatorias['Productos']['cantidad']+=$data['cantidad_pedido'];
                                      }else{
                                        $sumatorias['Productos']['cantidad']=$data['cantidad_pedido'];
                                        $sumatorias['Productos']['name']="Productos";
                                      }

                                      $sum = 0;
                                      foreach ($pedSec as $key) {
                                        if(!empty($key['id_pedido_sec'])){
                                          echo $key['cantidad_pedido_sec']." Cols. ".$key['nombre_coleccion_sec']."<br>";
                                          if(!empty($sumatorias[$key['nombre_coleccion_sec']])){
                                            $sumatorias[$key['nombre_coleccion_sec']]['cantidad']+=$key['cantidad_pedido_sec'];
                                          }else{
                                            $sumatorias[$key['nombre_coleccion_sec']]['cantidad']=$key['cantidad_pedido_sec'];
                                            $sumatorias[$key['nombre_coleccion_sec']]['name']=$key['nombre_coleccion_sec'];
                                          }
                                        }
                                      }
                                    ?>
                                  </td>
                                  <td>
                                      <?php 
                                        echo $data['cantidad_aprobado']." Colecciones";
                                        $cantidadAprobado += $data['cantidad_aprobado'];
                                      ?>
                                  </td>
                                  <td>
                                      <?php 
                                        echo $data['cantidad_aprobado_individual']." Cols. Productos<br>";
                                        if(!empty($sumatoriasPed['Productos'])){
                                          $sumatoriasPed['Productos']['cantidad']+=$data['cantidad_aprobado_individual'];
                                        }else{
                                          $sumatoriasPed['Productos']['cantidad']=$data['cantidad_aprobado_individual'];
                                          $sumatoriasPed['Productos']['name']="Productos";
                                        }

                                        foreach ($pedSec as $key) {
                                          if(!empty($key['id_pedido_sec'])){
                                            echo $key['cantidad_aprobado_sec']." Cols. ".$key['nombre_coleccion_sec']."<br>";
                                            if(!empty($sumatoriasPed[$key['nombre_coleccion_sec']])){
                                              $sumatoriasPed[$key['nombre_coleccion_sec']]['cantidad']+=$key['cantidad_aprobado_sec'];
                                            }else{
                                              $sumatoriasPed[$key['nombre_coleccion_sec']]['cantidad']=$key['cantidad_aprobado_sec'];
                                              $sumatoriasPed[$key['nombre_coleccion_sec']]['name']=$key['nombre_coleccion_sec'];
                                            }
                                          }
                                        }
                                      ?>
                                  </td>
                                </tr>
                        
                              <?php $num++; ?>

                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; endforeach; ?>
                        <?php endif; endforeach; ?>
                          <tr style="background:#eee;">
                            <td></td>
                            <td><b>Total: </b></td>
                            <td>
                              <b>
                                  <?php 
                                      echo $cantidadPedido." Colecciones"; 
                                  ?>
                              </b>
                            </td>
                            <td>
                              <b>
                                <?php 
                                  foreach ($sumatorias as $keys) {
                                    echo $keys['cantidad']." Cols. ".$keys['name']."<br>";
                                  }
                                ?>
                              </b>
                            </td>
                            <td>
                              <b>
                                  <?php 
                                      echo $cantidadAprobado." Colecciones"; 
                                  ?>
                              </b>
                            </td>
                            <td>
                              <b>
                                <?php 
                                  foreach ($sumatoriasPed as $keys) {
                                    echo $keys['cantidad']." Cols. ".$keys['name']."<br>";
                                  }
                                ?>
                              </b>
                            </td>
                          </tr>
                      </tbody>
                    </table> -->
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
.addMore, .addMenos{
  border-radius:40px;
  border:1px solid #CCC;
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

  $(".numberss").on('input', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  
  $(".cargarBusqueda").click(function(){
    swal.fire({
      title: "¿Desea cargar la busqueda?",
      text: "Los datos guardados de la busqueda van a precargar el formulario, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Cargar!",
      cancelButtonText: "Cancelar", 
      closeOnConfirm: true,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        var rutaURL=$("#busquedasguardadas").val();
        window.location = "?"+rutaURL;
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "#ED2A77",
        });
      }
    });
  });
  $(".guardarUrl").click(function(){
    swal.fire({ 
      title: "¿Desea guardar los datos?",
      text: "Los datos guardados podrán visualizarse mas adelante, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Guardar!",
      cancelButtonText: "Cancelar", 
      closeOnConfirm: true,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        var ruta = $(this).val();
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            validarData: true,
            ruta: ruta,
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "2"){
              swal.fire({
                type: 'error',
                title: '¡Error al guardar la informacion!',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "3"){
              swal.fire({
                type: 'warning',
                title: '¡Busqueda ya guardada !',
                confirmButtonColor: "#ED2A77",
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
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "#ED2A77",
        });
      }
    });
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

  

  $(".addMore").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    // var tpInv=$("#tipoInv").val();
    // var inventarios = "";
    // if(tpInv=="Productos"){
      // inventarios = $(".json_productos").html();
    // }
    // if(tpInv=="Mercancia"){
      // inventarios = $(".json_mercancia").html();
    // }
    // alert(index);
    $("#addMore"+index).hide();
    $("#addMenos"+index).hide();
    alimentarFormInventario();
  });

  $(".addMenos").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    var tpInv=$("#tipoInv").val();
    var inventarios = "";
    if(tpInv=="Productos"){
      inventarios = $(".json_productos").html();
    }
    if(tpInv=="Mercancia"){
      inventarios = $(".json_mercancia").html();
    }
    // alert(index);
    $("#addMore"+index).hide();
    $("#addMenos"+index).hide();
    var cant = parseInt($("#cantidad_elementos").val());
    cant--;
    $("#addMore"+cant).show();
    $("#addMenos"+cant).show();
    retroalimentarFormInventario(tpInv,inventarios);
  });

  function alimentarFormInventario(){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementos").val());
    // alert(cant);
    cant++;
    // alert(cant);
    $(`.box-inventarios${cant}`).show();
    if(cant == limite){
      $("#addMore"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  function retroalimentarFormInventario(inv, inventarios){
    var cant = parseInt($("#cantidad_elementos").val());
    $(`.box-inventarios${cant}`).hide();
    cant--;
    if(cant<2){
      $("#addMenos"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }


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
  var conductor = $("#conductor").val();
  var rconductor = false;
  if(conductor!=""){
    rconductor=true;
    $(".error_conductor").html("");
  }else{
    $(".error_conductor").html("Ingrese la información del conductor");
    rconductor=false;
  }

  var cedula = $("#cedula").val();
  var rcedula = false;
  if(cedula!=""){
    rcedula=true;
    $(".error_cedula").html("");
  }else{
    $(".error_cedula").html("Ingrese la cedula del conductor");
    rcedula=false;
  }

  var tlf = $("#tlf").val();
  var rtlf = false;
  if(tlf!=""){
    rtlf=true;
    $(".error_tlf").html("");
  }else{
    $(".error_tlf").html("Ingrese el telefono del conductor");
    rtlf=false;
  }

  var vehiculo = $("#vehiculo").val();
  var rvehiculo = false;
  if(vehiculo!=""){
    rvehiculo=true;
    $(".error_vehiculo").html("");
  }else{
    $(".error_vehiculo").html("Ingrese la información del vehículo");
    rvehiculo=false;
  }

  var placa = $("#placa").val();
  var rplaca = false;
  if(placa!=""){
    rplaca=true;
    $(".error_placa").html("");
  }else{
    $(".error_placa").html("Ingrese la placa del vehículo");
    rplaca=false;
  }

  var ruta = $("#ruta").val();
  var rruta = false;
  if(ruta!=""){
    rruta=true;
    $(".error_ruta").html("");
  }else{
    $(".error_ruta").html("Ingrese la ruta del recorrido");
    rruta=false;
  }

  var elementos = $("#cantidad_elementos").val();
  // alert(elementos);
  var erroresZonas = false;
  var erroresLideres = false; 
  for(var z = 1; z <= elementos; z++){
    // alert(z);
    var zona = $("#zona"+z).val();
    var rzona = false;
    if(zona!=""){
      rzona=true;
      $("#error_zona"+z).html("");
    }else{
      $("#error_zona"+z).html("Ingrese la zona del líder");
      rzona=false;
    }
    if(rzona==false){ erroresZonas++; }

    var lider = $("#lider"+z).val();
    var rlider = false;
    if(lider!=""){
      rlider=true;
      $("#error_lider"+z).html("");
    }else{
      $("#error_lider"+z).html("Seleccione al o a la líder");
      rlider=false;
    }
    if(rlider==false){ erroresLideres++; }
  }
  var rzonas = false;
  var rlideres = false;
  if(erroresZonas==0){ rzonas=true; }
  if(erroresLideres==0){ rlideres=true; }
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
  if( rselected==true && rconductor==true && rcedula==true && rtlf==true && rvehiculo==true && rplaca==true && rruta==true && rzonas==true && rlideres==true ){
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
