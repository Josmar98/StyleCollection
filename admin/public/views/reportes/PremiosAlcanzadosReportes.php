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
        <small><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de <?php echo "Premios Alcanzados"; ?></h3>
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
                        <input type="hidden" name="action" value="PremiosAlcanzados">

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
                                        <?php echo "Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana']; ?>
                                      
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
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;">
                          <a href="?route=Reportes&action=GenerarPremiosAlcanzados&id=<?=$id_despacho?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table class="table text-center datatable" id="">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th style="width:10%">Nº</th>
                          <th style="width:20%">Lider</th>
                          <th style="width:17.5%">Colecciones</th>
                          <th style="width:17.5%">Planes Seleccionado</th>
                          <th style="width:35%">Premios Alcanzados</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
                          $premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
                        ?>
                        <?php $num = 1; 
                          $acumColecciones = 0;
                          $nume = 1;
                          $acumPremios[0]['plan'] = "Inicial";
                          $acumPremios[0]['cantidad'] = 0;
                          if(count($planes)>1){
                            foreach ($planes as $plan) {
                              if(!empty($plan['nombre_plan'])){
                                $nume2 = 0;
                                $acumPlanes[$plan['nombre_plan']]=0;
                                $acumPremios[$nume]['plan'] = $plan['nombre_plan'];
                                if($plan['nombre_plan']=='Standard'){
                                  $acumPremios[$nume]['cantidad'] = 0;
                                }

                                if(count($premios)>1){
                                  foreach ($premios as $premio) {
                                    if(!empty($premio['nombre_premio'])){
                                      if($plan['id_plan'] == $premio['id_plan']){
                                        $acumPremios[$nume]['premio'][$nume2]['nombre'] = $premio['nombre_premio'];
                                        $acumPremios[$nume]['premio'][$nume2]['cantidad'] = 0;
                                        $nume2++;
                                      }
                                    }
                                  }
                                }
                                $nume++;
                              }
                            }
                          }
                          $acumPremios[$nume]['plan'] = "Segundo";
                          $acumPremios[$nume]['cantidad'] = 0;
                          $acumRetos;
                          $numb = 0;
                          foreach ($retosCamp as $ret) {
                            if(!empty($ret['id_premio'])){
                              $acumRetos[$numb]['nombre'] = $ret['nombre_premio'];
                              $acumRetos[$numb]['cantidad'] = 0;
                              $numb++;
                            }
                          }
                        ?>

                        <?php $num = 1; ?>
                        <?php foreach ($pedidos as $data): if(!empty($data['id_pedido'])):?>

                          <tr class="elementTR">
                            <td style="width:10%;"><?=$num?></td>
                            <td style="width:20%">
                                <?php 
                                  echo number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']." <br> ".
                                      $data['cantidad_aprobado']." Colecciones Aprobadas";
                                ?>
                            </td>
                            <td style="width:70%;text-align:justify;" colspan="3">
                              <table class='table table-striped table-hover' style='background:none'>
                                <tr>
                                  <td style="text-align:left;">
                                      <?php echo $data['cantidad_aprobado']." Colecciones<br>"; ?>
                                    
                                  </td>
                                  <td style="text-align:left;">
                                      <?php echo $data['cantidad_aprobado']." Premios de Inicial<br>"; ?>
                                  </td>
                                  <td style="width:50%;">
                                    <table class='' style='background:none'> 
                                        <tr>
                                          <td style="text-align:left;">
                                            <?php 
                                            foreach ($premios_perdidos as $dataperdidos) {
                                              if(!empty($dataperdidos['id_premio_perdido'])){
                                                if(($dataperdidos['valor'] == "Inicial") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                  $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
                                                  for ($i=0; $i < count($acumPremios); $i++) { 
                                                    if($acumPremios[$i]['plan'] == $dataperdidos['valor']){
                                                      $acumPremios[$i]['cantidad'] += $nuevoResult;
                                                    }
                                                  }
                                                  foreach ($premios_planes as $planstandard):
                                                    if (!empty($planstandard['id_plan_campana'])):
                                                        if ($dataperdidos['valor'] == $planstandard['tipo_premio']):
                                                        ?>
                                                          <?php
                                                      echo $nuevoResult." ".$planstandard['producto'];
                                                      echo "<br>";
                                                        endif;
                                                    endif;
                                                  endforeach;
                                                  // echo $nuevoResult." Premios de ".$dataperdidos['valor'];
                                                  // echo "<br>";
                                                }
                                              }
                                            }
                                             ?>
                                          </td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>
                            <?php foreach ($planesCol as $data2): if(!empty($data2['id_cliente'])): ?>
                                <?php if ($data['id_pedido'] == $data2['id_pedido']): ?>
                                    <?php if ($data2['cantidad_coleccion_plan']>0): ?>
                                        <tr >
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
                                              $acumPlanes[$data2['nombre_plan']] += $data2['cantidad_coleccion_plan'];
                                            ?>


                                            </td>

                                            <td style="width:50%;">
                                                <table class='' style='background:none'> 
                                                    <tr>
                                                      <td style="text-align:left;">
                                                      <?php 
                                                        foreach ($premios_perdidos as $dataperdidos) {
                                                          if(!empty($dataperdidos['id_premio_perdido'])){
                                                            if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                              // $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                              $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                              for ($i=0; $i < count($acumPremios); $i++) { 
                                                                if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
                                                                  $acumPremios[$i]['cantidad'] += $nuevoResult;
                                                                }
                                                              }
                                                              foreach ($premios_planes as $planstandard):
                                                                if ($planstandard['id_plan_campana']):
                                                                    if ($data2['nombre_plan'] == $planstandard['nombre_plan']):
                                                                      if ($planstandard['tipo_premio']=="Primer"): ?>
                                                                        <?php 
                                                                          echo $nuevoResult." ".$planstandard['producto']."<br>";
                                                                      endif;
                                                                    endif;
                                                                endif;
                                                              endforeach;
                                                              // echo $nuevoResult." Premios de ".$dataperdidos['valor'];
                                                              // echo "<br>";
                                                            }
                                                          }
                                                        }
                                                      ?>

                                                      </td>
                                                    </tr>
                                                    <?php foreach ($premioscol as $data3): if(!empty($data3['id_premio'])): ?>  
                                                      <?php if ($data3['id_plan']==$data2['id_plan']): ?>
                                                        <?php if ($data['id_pedido']==$data3['id_pedido']): ?>
                                                          <?php if($data3['cantidad_premios_plan']>0): ?>
                                                        <tr>
                                                          <td style="text-align:left;">
                                                            
                                                          <?php 
                                                            foreach ($premios_perdidos as $dataperdidos) {
                                                                if(!empty($dataperdidos['id_premio_perdido'])){
                                                                  if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                                    // $perdidos = $dataperdidos['cantidad_premios_perdidos'];
                                                                    $nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                                    for ($i=0; $i < count($acumPremios); $i++) { 
                                                                      if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
                                                                        for ($j=0; $j < count($acumPremios[$i]['premio']); $j++) { 
                                                                          if($acumPremios[$i]['premio'][$j]['nombre']==$data3['nombre_premio']){

                                                                            $acumPremios[$i]['premio'][$j]['cantidad'] += $nuevoResult;
                                                                          }
                                                                        }
                                                                      }
                                                                    }
                                                                    echo $nuevoResult." ".$data3['nombre_premio'];
                                                                    echo "<br>";
                                                                  }
                                                                }
                                                              }
                                                           ?>
                                                          </td>
                                                        </tr>
                                                          <?php endif ?>
                                                        <?php endif ?>
                                                      <?php endif ?>
                                                    <?php endif; endforeach; ?>

                                                    
                                                </table>
                                                <!-- <br> -->
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif; endforeach; ?>
                                <tr>
                                  <td style="text-align:left;">
                                      <?php echo $data['cantidad_aprobado']." Colecciones<br>"; ?>
                                    
                                  </td>
                                  <td style="text-align:left;">
                                      <?php echo $data['cantidad_aprobado']." Premios de Segundo Pago<br>"; ?>
                                  </td>
                                  <td style="text-align:left;">
                                    <table class='' style='background:none'> 
                                        <tr>
                                          <td style="text-align:left;">
                                            <?php 
                                            foreach ($premios_perdidos as $dataperdidos) {
                                              if(!empty($dataperdidos['id_premio_perdido'])){
                                                if(($dataperdidos['valor'] == "Segundo") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                  $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
                                                  for ($i=0; $i < count($acumPremios); $i++) { 
                                                    if($acumPremios[$i]['plan'] == $dataperdidos['valor']){
                                                      $acumPremios[$i]['cantidad'] += $nuevoResult;
                                                    }
                                                  }
                                                  foreach ($premios_planes as $planstandard):
                                                    if ($planstandard['id_plan_campana']):
                                                        if ($dataperdidos['valor'] == $planstandard['tipo_premio']):
                                                      echo $nuevoResult." ".$planstandard['producto'];
                                                      echo "<br>";
                                                        endif;
                                                    endif;
                                                  endforeach;
                                                }
                                              }
                                            }
                                             ?>
                                          </td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-align:left;">
                                    <?=$data['cantidad_aprobado']?> Colecciones
                                  </td>
                                  <td style="text-align:left;">
                                    Retos Solicitados
                                  </td>
                                  <td style="text-align:left;">
                                    <?php foreach ($retos as $reto): ?>
                                      <?php if (!empty($reto['id_reto'])): ?>
                                        <?php if ($reto['id_pedido']==$data['id_pedido']): ?>
                                            <?php if ($reto['cantidad_retos']): ?>
                                              <?php echo $reto['cantidad_retos']." ".$reto['nombre_premio']."<br>"; ?>
                                              <?php 
                                                for ($i=0; $i < count($acumRetos); $i++) {
                                                  if($acumRetos[$i]['nombre']==$reto['nombre_premio']){
                                                    $acumRetos[$i]['cantidad'] += $reto['cantidad_retos'];
                                                  } 
                                                } 
                                              ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                                  </td>
                                </tr>
                                <?php
                                $liddd = 0;
                                foreach ($canjeos as $canje){
                                  if (!empty($canje['id_cliente'])){
                                    if ($canje['id_cliente']==$data['id_cliente']){
                                      $liddd = 1;
                                    }
                                  }
                                }
                                if ($liddd == "1"): ?>
                                  <tr>
                                    <td></td>
                                    <td style="text-align:left;">Premios Canjeados</td>
                                    <td style="text-align:left;">
                                    <?php
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
                                              }
                                            }
                                          }
                                        }
                                      }
                                      foreach ($arrayt as $arr) {
                                        if($arr['cantidad']>0){
                                          echo $arr['cantidad']." ".$arr['nombre']."<br>";
                                        }
                                      }
                                      // print_r($arrayt);
                                    ?>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                              </table>
                          </td>
                        </tr>
                          <?php $num++; ?>
                      <?php endif; endforeach; ?>



                        <tr style="background:#CCc">
                          <td></td>
                          <td></td>
                          <td style="text-align:left;"><?=$acumColecciones?> Colecciones</td>
                          <td colspan="2" style="text-align:left;">
                            <table class="table table-hover" style="width:100%;background:none;">
                                <tr>
                                  <td style="text-align:left;">
                                    <?=$acumColecciones?> Premios de Inicial
                                  </td>
                                  <td style="text-align:left;">
                                    <?php 
                                      foreach ($premios_planes as $planstandard):
                                        if ($planstandard['id_plan_campana']):
                                              // echo "asdasd";
                                            if ($planstandard['tipo_premio']=="Inicial"):
                                              // print_r($planstandard['producto']);
                                              foreach ($acumPremios as $key) {
                                                if($key['plan'] == $planstandard['tipo_premio']){
                                                  if($key['cantidad']>0){
                                                    echo $key['cantidad']." ".$planstandard['producto']."<br>";
                                                  }
                                                }
                                              }
                                            endif;
                                        endif;
                                      endforeach;

                                    ?>
                                  </td>
                                </tr>
                        <?php 
                        foreach ($planes as $plan):
                            if (!empty($plan['nombre_plan'])):
                              if($acumPlanes[$plan['nombre_plan']]>0){ ?>
                                <tr>
                                  <td style="text-align:left;width:31%;">
                                    <?php echo $acumPlanes[$plan['nombre_plan']]." Plan ".$plan['nombre_plan']."<br>"; ?>
                                  </td>
                                  <td style="text-align:left;width:64%;">
                                    <?php if ($plan['nombre_plan']=="Standard"):
                                      foreach ($premios_planes as $planstandard):
                                        if ($planstandard['id_plan_campana']):
                                          if ($plan['nombre_plan'] == $planstandard['nombre_plan']):
                                            if ($planstandard['tipo_premio']=="Primer"):
                                              foreach ($acumPremios as $key) {
                                                if($key['plan'] == $plan['nombre_plan']){
                                                  if($key['cantidad']>0){
                                                    echo $key['cantidad']." ".$planstandard['producto']."<br>";
                                                  }
                                                }
                                              }
                                            endif;
                                          endif;
                                        endif;
                                      endforeach;
                                    else: ?>
                                        <?php foreach ($acumPremios as $prem): ?>
                                          <?php if ($plan['nombre_plan']==$prem['plan']): ?>
                                            <?php foreach ($prem['premio'] as $prem2): ?>
                                              <?php if ($prem2['cantidad']>0): ?>
                                                
                                              <?php echo $prem2['cantidad']." ".$prem2['nombre']."<br>"; ?>
                                              <?php endif; ?>
                                            <?php endforeach ?>
                                          <?php endif; ?>
                                        <?php endforeach ?>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                        <?php }
                            endif;
                        endforeach; ?>
                                <tr>
                                  <td style="text-align:left;">
                                    <?=$acumColecciones?> Premios de Segundo pago
                                  </td>
                                  <td style="text-align:left;">
                                    <?php 
                                      foreach ($premios_planes as $planstandard):
                                        if ($planstandard['id_plan_campana']):
                                            if ($planstandard['tipo_premio']=="Segundo"):
                                              foreach ($acumPremios as $key) {
                                                if($key['plan'] == $planstandard['tipo_premio']){
                                                  if($key['cantidad']>0){
                                                    echo $key['cantidad']." ".$planstandard['producto']."<br>";
                                                  }
                                                }
                                              }
                                            endif;
                                        endif;
                                      endforeach;

                                    ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="text-align:left;">
                                    <table>
                                      <tr>
                                        <td style="text-align:left;width:50%;">
                                          Retos Solicitados
                                        </td>
                                        <td style="text-align:left;width:50%;">
                                          <?php foreach ($acumRetos as $key): ?>
                                            <?php if ($key['cantidad']>0): ?>
                                            <?php echo $key['cantidad']." ".$key['nombre']."<br>"; ?>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-align:left;">Premios Canjeados</td>
                                  <td style="text-align:left;">
                                  <?php
                                    $arrayt2 = [];
                                    $numCC = 0;
                                    foreach ($canjeosUnic as $canUnic) {
                                      if(!empty($canUnic['nombre_catalogo'])){
                                        $arrayt2[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                                        $arrayt2[$numCC]['cantidad'] = 0;
                                        $numCC++;
                                      }
                                    }
                                    foreach ($canjeos as $canje){
                                      if (!empty($canje['id_cliente'])){
                                        for ($i=0; $i < count($arrayt2); $i++) { 
                                          if($canje['nombre_catalogo']==$arrayt2[$i]['nombre']){
                                            $arrayt2[$i]['cantidad']++;
                                          }
                                        }
                                      }
                                    }
                                    foreach ($arrayt2 as $arr) {
                                      if($arr['cantidad']>0){
                                        echo $arr['cantidad']." ".$arr['nombre']."<br>";
                                      }
                                    }
                                  ?>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                    <?php 
                      // print_r($acumPremios); 
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
