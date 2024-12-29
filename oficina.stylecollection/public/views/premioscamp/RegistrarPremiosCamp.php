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
        <?php echo "Premios de la campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Premios"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Premios"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Premios de la campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Premios a la campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <input type="hidden" id="opInicial" value="<?=$despacho['opcion_inicial']; ?>">
                  <input type="hidden" id="cantPagos" value="<?=$despacho['cantidad_pagos']; ?>">
                  <input type="hidden" id="cantPagosMax" value="<?=count($cantidadPagosDespachos); ?>">
                  <span class="d-none json_pagos"><?php echo json_encode($cantidadPagosDespachosFild); ?></span>
                  <span class="d-none json_planes"><?php echo json_encode($planesss); ?></span>

                  <div class="row">
                    <div class="col-sm-12">
                      <h3 class="box-title">
                        <div class="row col-xs-12">
                          <div class="form-group col-xs-12">
                            <label>Plan</label>
                            <br>
                            <select name="plan" id="plan" class="select2" style="width:100%">
                              <option value=""></option>
                              <?php foreach ($planes as $data): if(!empty($data['id_plan_campana'])): ?>
                              <option <?php foreach ($planesya as $keya) { if(!empty($keya['id_plan_campana'])){ if($data['id_plan_campana'] == $keya['id_plan_campana']){ echo "disabled"; } } } ?> value="<?php echo $data['id_plan_campana'] ?>"><?php echo $data['nombre_plan']; ?></option>
                              <?php endif; endforeach; ?>
                            </select>
                            <span id="error_plan" class="errors" style="font-size:0.7em;"></span>
                          </div>
                        </div>
                      </h3>
                    </div>
                  </div>
                    <!-- <input type="hidden" name="id_plan" value="titulo"> -->
                  <?php if ($despacho['opcion_inicial']=="Y"){ ?>
                    <div class="row col-xs-12">
                      <hr>
                      <div class="form-group col-xs-12">
                        <div style="width:100%;">
                          <label style="font-size:1.3em;"><u>Inicial</u></label>
                          <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="Inicial" name="tipos_premios[inicial]" id="tipos_premios_inicial">
                          <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="inicial" name="tipos_premios_id[inicial]" id="tipos_premios_inicial">
                        </div>
                        <?php
                          $planes_de_campana = $lider->consultarQuery("SELECT * FROM planes_campana WHERE estatus = 1 and id_campana={$id_campana} and id_despacho={$id_despacho} ORDER BY id_plan_campana ASC;");
                          $coleccionesXDefault = 1;
                          if(count($planes_de_campana)>1){
                            $planOne = $lider->consultarQuery("SELECT * FROM planes WHERE id_plan = {$planes_de_campana[0]['id_plan']}");
                            if(!empty($planOne[0])){
                              $coleccionesXDefault = $planOne[0]['cantidad_coleccion'];
                            }
                            $id_plan_campana = $planes_de_campana[0]['id_plan_campana'];
                            $tppcs = $lider->consultarQuery("SELECT * FROM premios_planes_campana, tipos_premios_planes_campana, premios WHERE premios.id_premio=tipos_premios_planes_campana.id_premio and premios_planes_campana.id_plan_campana = {$id_plan_campana} and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and premios_planes_campana.tipo_premio='Inicial'"); 
                          }
                          $limiteMinimoElementos=1;
                          if((count($tppcs)>1)){
                            $opcionsMostrar = (count($tppcs)-1);
                          }else{
                            $opcionsMostrar = 1;
                          }
                        ?>
                        <?php for($x=1; $x<=$limitesOpciones; $x++){ ?>
                          <div class="row box_opciones box_opciones_inicial <?php if($x>$opcionsMostrar){ echo "d-none"; } ?>" id="box_opcionesinicial<?=$x; ?>">
                            <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                              <br>
                              <label for="name_opcion_inicial<?=$x; ?>" style="font-size:1.3em;width:14%;float:left;"><u>Opcion #<?=$x; ?></u></label>
                              <input type="text" class="form-control" style="width:84%;float:right;" id="name_opcion_inicial<?=$x; ?>" name="name_opcion[inicial][]" placeholder="Coloque nombre de premio a la opcion #<?=$x; ?>"  value="<?php if(!empty($tppcs[($x-1)])){ echo $tppcs[($x-1)]['nombre_premio']; }; ?>">
                              <span id="error_name_opcion_inicial<?=$x; ?>" class="errors"></span>
                              <div style="clear:both;"></div>
                              <br>
                              <?php
                                $elementosMostrar=1;
                                if(!empty($tppcs[($x-1)])){
                                  // echo $tppcs[($x-1)]['id_premio'];
                                  // echo $tppcs[($x-1)]['nombre_premio'];
                                  $premiosInv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$tppcs[($x-1)]['id_premio']}");
                                  // print_r($premiosInv);
                                  if(count($premiosInv)>1){
                                    $elementosMostrar = count($premiosInv)-1;
                                  }else{
                                    $elementosMostrar=1;
                                  }
                                }
                              ?>
                              <?php for($z=1; $z<=$limitesElementos; $z++){ ?>
                                <div style="width:100%;" id="box_tipoinicial<?=$x.$z; ?>" class="box_inventario_tipo box_inventario_tipo_inicial <?php if($z>$elementosMostrar){ echo "d-none"; } ?>">
                                  <?php
                                    if(!empty($premiosInv[($z-1)])){
                                      // echo $premiosInv[($z-1)]['tipo_inventario'];
                                      // echo $premiosInv[($z-1)]['id_premio_inventario'];
                                      if($premiosInv[($z-1)]['tipo_inventario']=="Productos"){
                                        $nameTabla = "Productos";
                                        $idTabla = "id_producto";
                                      }
                                      if($premiosInv[($z-1)]['tipo_inventario']=="Mercancia"){
                                        $nameTabla = "Mercancia";
                                        $idTabla = "id_mercancia";
                                      }
                                      $inventario = $lider->consultarQuery("SELECT * FROM premios_inventario, {$nameTabla} WHERE premios_inventario.estatus=1 and premios_inventario.id_premio={$premiosInv[($z-1)]['id_premio']} and premios_inventario.id_premio_inventario={$premiosInv[($z-1)]['id_premio_inventario']} and {$nameTabla}.{$idTabla} = premios_inventario.id_inventario");
                                      // print_r($inventario);
                                    }else{
                                      $inventario = [];
                                    }
                                  ?>
                                  <div class="" style="width:15%;float:left;">
                                    <!-- <label for="unidad_inicial<?=$x.$z; ?>">Cantidad de Unidades #<?=$z; ?></label>                       -->
                                    <input type="number" class="form-control unidades_inicial"  id="unidad_inicial<?=$x.$z; ?>" name="unidades[inicial][]" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['unidades_inventario']*$coleccionesXDefault); } ?>">
                                    <input type="hidden" id="uunidad_inicial<?=$x.$z; ?>" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['unidades_inventario']*$coleccionesXDefault); } ?>">
                                    <span id="error_unidad_inicial<?=$x.$z; ?>" class="errors"></span>
                                  </div>
                                  <div class="" style="width:84%;float:right;">    
                                    <!-- <label for="seleccioninicial<?=$x.$z; ?>">Seleccionar de Inventarios #<?=$z; ?></label>                       -->
                                    <select class="select2 seleccion_inventario" min="inicial<?=$x.$z; ?>" style="width:100%;" id="seleccioninicial<?=$x.$z; ?>" name="inventarios[inicial][]">
                                      <option value=""></option>
                                      <?php $tipoInvOP=""; ?>
                                      <?php foreach ($productos as $data){ if( !empty($data['id_producto']) ){ ?>
                                        <option value="<?=$data['id_producto'] ?>"
                                        <?php
                                          if(!empty($inventario[0])){
                                            if($inventario[0]['tipo_inventario']=="Productos"){
                                              if($inventario[0]['id_producto']==$data['id_producto']){
                                                echo "selected";
                                                $tipoInvOP="Productos";
                                              }
                                            }
                                          }
                                        ?>
                                        >Productos: <?php echo $data['producto']." - (".$data['cantidad'].")"; ?></option>
                                      <?php } } ?>
                                      <?php foreach ($mercancia as $data){ if( !empty($data['id_mercancia']) ){ ?>
                                        <option value="m<?=$data['id_mercancia'] ?>"
                                        <?php
                                          if(!empty($inventario[0])){
                                            if($inventario[0]['tipo_inventario']=="Mercancia"){
                                              if($inventario[0]['id_mercancia']==$data['id_mercancia']){
                                                echo "selected";
                                                $tipoInvOP="Mercancia";
                                              }
                                            }
                                          }
                                        ?>
                                        >Mercancia: <?php echo $data['mercancia']." - (".$data['medidas_mercancia'].")"; ?></option>
                                      <?php } } ?>
                                    </select>
                                    <input type="hidden" id="tipoinicial<?=$x.$z; ?>" name="tipos[inicial][]" value="<?=$tipoInvOP; ?>">
                                    <span id="error_seleccioninicial<?=$x.$z; ?>" class="errors"></span>
                                  </div>
                                  <div style="clear:both;"></div>
                                  <div class="form-group col-xs-12 w-100" style="position:relative;margin-top:-10px;margin-left:90%;">
                                    <?php if($z<$limitesElementos){ ?>
                                      <span id="addMoreinicial<?=$x.$z; ?>" min="inicial" max="<?=$x; ?>" class="addMore btn btn-success" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>+</b></span>
                                    <?php  } ?>
                                    <?php if($z>=2){ ?>
                                      <span id="addMenosinicial<?=$x.$z; ?>" min="inicial" max="<?=$x; ?>" class="addMenos btn btn-danger" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>-</b></span>
                                    <?php  } ?>
                                  </div>
                                </div>
                              <?php } ?>
                              <input type="hidden" name="cantidad_elementos[inicial][]" id="cantidad_elementosOpinicial<?=$x; ?>" value="<?=$elementosMostrar; ?>">
                            </div>
                            <br>
                            <div class="form-group col-xs-12 w-100 <?php if($adicionalesSoloPagoDeSeleccion){ echo "d-none"; } ?>">
                              <?php if($x<$limitesOpciones){ ?>
                                <span id="addMoreOpinicial<?=$x; ?>" min="inicial" max="<?=$x; ?>" class="addMoreOp btn btn-success"><b>+</b></span>
                              <?php  } ?>
                              <?php if($x>=2){ ?>
                                <span id="addMenosOpinicial<?=$x; ?>" min="inicial" max="<?=$x; ?>" class="addMenosOp btn btn-danger"><b>-</b></span>
                              <?php  } ?>
                            </div>
                          </div>
                        <?php } ?>
                        <input type="hidden" name="cantidad_opciones[inicial]" id="cantidad_opciones_inicial" value="<?=$opcionsMostrar; ?>">
                      </div>
                    </div>
                    
                  <?php } ?>

                  <?php
                    $indexPg = 0;
                    foreach ($cantidadPagosDespachosFild as $pagosDFill){
                      foreach ($pagos_despacho as $pagosD){
                        if ($pagosDFill['name']==$pagosD['tipo_pago_despacho']){ ?>
                          
                          <div class="row col-xs-12">
                            <hr>
                            <div class="form-group col-xs-12">
                              <div style="width:100%;">
                                <label for="tipos_premios_<?=$pagosDFill['id'];?>" style="font-size:1.3em;"><u><?=$pagosDFill['name'];?></u></label>
                                <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['name'];?>" name="tipos_premios[<?=$pagosDFill['id'];?>]" id="tipos_premios_<?=$pagosDFill['id'];?>">
                                <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['id'];?>" name="tipos_premios_id[<?=$pagosDFill['id'];?>]" id="tipos_premios_<?=$pagosDFill['id'];?>">
                              </div>
                              <?php
                                $planes_de_campana = $lider->consultarQuery("SELECT * FROM planes_campana WHERE estatus = 1 and id_campana={$id_campana} and id_despacho={$id_despacho} ORDER BY id_plan_campana ASC;");
                                if(count($planes_de_campana)>1){
                                  $id_plan_campana = $planes_de_campana[0]['id_plan_campana'];
                                  $tppcs = $lider->consultarQuery("SELECT * FROM premios_planes_campana, tipos_premios_planes_campana, premios WHERE premios.id_premio=tipos_premios_planes_campana.id_premio and premios_planes_campana.id_plan_campana = {$id_plan_campana} and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and premios_planes_campana.tipo_premio='{$pagosDFill['name']}'"); 
                                }
                                $limiteMinimoElementos=1;
                                if((count($tppcs)>1)){
                                  $opcionsMostrar = (count($tppcs)-1);
                                }else{
                                  $opcionsMostrar = 1;
                                } 
                              ?>
                              <?php for($x=1; $x<=$limitesOpciones; $x++){ ?>
                                <div class="row box_opciones box_opciones_<?=$pagosDFill['id'];?> <?php if($x>$opcionsMostrar){ echo "d-none"; } ?>" id="box_opciones<?=$pagosDFill['id'];?><?=$x; ?>">
                                  <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                                    <br>
                                    <label for="name_opcion_<?=$pagosDFill['id'];?><?=$x; ?>" style="font-size:1.3em;width:15%;float:left;"><u>Opcion #<?=$x; ?></u></label>
                                    <input type="text" class="form-control" style="width:84%;float:right;" id="name_opcion_<?=$pagosDFill['id'];?><?=$x; ?>" name="name_opcion[<?=$pagosDFill['id'];?>][]" placeholder="Coloque nombre de premio a la opcion #<?=$x; ?>" value="<?php if(!empty($tppcs[($x-1)])){ echo $tppcs[($x-1)]['nombre_premio']; } ?>">
                                    <span id="error_name_opcion_<?=$pagosDFill['id'];?><?=$x; ?>" class="errors"></span>
                                    <div style="clear:both;"></div>
                                    <br>
                                    <?php
                                      if(!empty($tppcs[($x-1)])){
                                        // echo $tppcs[($x-1)]['id_premio'];
                                        // echo $tppcs[($x-1)]['nombre_premio'];
                                        $premiosInv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$tppcs[($x-1)]['id_premio']}");
                                        // print_r($premiosInv);
                                        if(count($premiosInv)>1){
                                          $elementosMostrar = count($premiosInv)-1;
                                        }else{
                                          $elementosMostrar=1;
                                        }
                                      }
                                    ?>                                 
                                    <?php for($z=1; $z<=$limitesElementos; $z++){ ?>
                                      <div style="width:100%;" id="box_tipo<?=$pagosDFill['id'];?><?=$x.$z; ?>" class="box_inventario_tipo box_inventario_tipo_<?=$pagosDFill['id'];?> <?php if($z>$elementosMostrar){ echo "d-none"; } ?>">
                                        <?php
                                          if(!empty($premiosInv[($z-1)])){
                                            // echo $premiosInv[($z-1)]['tipo_inventario'];
                                            // echo $premiosInv[($z-1)]['id_premio_inventario'];
                                            if($premiosInv[($z-1)]['tipo_inventario']=="Productos"){
                                              $nameTabla = "Productos";
                                              $idTabla = "id_producto";
                                            }
                                            if($premiosInv[($z-1)]['tipo_inventario']=="Mercancia"){
                                              $nameTabla = "Mercancia";
                                              $idTabla = "id_mercancia";
                                            }
                                            $inventario = $lider->consultarQuery("SELECT * FROM premios_inventario, {$nameTabla} WHERE premios_inventario.estatus=1 and premios_inventario.id_premio={$premiosInv[($z-1)]['id_premio']} and premios_inventario.id_premio_inventario={$premiosInv[($z-1)]['id_premio_inventario']} and {$nameTabla}.{$idTabla} = premios_inventario.id_inventario");
                                          }else{
                                            $inventario = [];
                                          }
                                        ?>
                                        <div class="" style="width:15%;float:left;">
                                          <!-- <label for="unidad_<?=$pagosDFill['id'];?><?=$x.$z; ?>">Cantidad de Unidades #<?=$z; ?></label> -->
                                          <input type="number" class="form-control unidades_<?=$pagosDFill['id'];?>"  id="unidad_<?=$pagosDFill['id'];?><?=$x.$z; ?>" name="unidades[<?=$pagosDFill['id'];?>][]" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['unidades_inventario']*$coleccionesXDefault); } ?>">
                                          <input type="hidden" id="uunidad_<?=$pagosDFill['id'];?><?=$x.$z; ?>" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['unidades_inventario']*$coleccionesXDefault); } ?>">
                                          <span id="error_unidad_<?=$pagosDFill['id'];?><?=$x.$z; ?>" class="errors"></span>
                                        </div>
                                        <div class="" style="width:84%;float:right;">    
                                          <!-- <label for="seleccion<?=$pagosDFill['id'];?><?=$x.$z; ?>">Seleccionar de Inventarios #<?=$z; ?></label>                       -->
                                          <select class="select2 seleccion_inventario" min="<?=$pagosDFill['id'];?><?=$x.$z; ?>" style="width:100%;" id="seleccion<?=$pagosDFill['id'];?><?=$x.$z; ?>" name="inventarios[<?=$pagosDFill['id'];?>][]">
                                            <option value=""></option>
                                            <?php $tipoInvOP=""; ?>
                                            <?php foreach ($productos as $data){ if( !empty($data['id_producto']) ){ ?>
                                              <option value="<?=$data['id_producto'] ?>"
                                              <?php
                                                if(!empty($inventario[0])){
                                                  if($inventario[0]['tipo_inventario']=="Productos"){
                                                    if($inventario[0]['id_producto']==$data['id_producto']){
                                                      echo "selected";
                                                      $tipoInvOP="Productos";
                                                    }
                                                  }
                                                }
                                              ?>
                                              >Productos: <?php echo $data['producto']." - (".$data['cantidad'].")"; ?></option>
                                            <?php } } ?>
                                            <?php foreach ($mercancia as $data){ if( !empty($data['id_mercancia']) ){ ?>
                                              <option value="m<?=$data['id_mercancia'] ?>"
                                              <?php
                                                if(!empty($inventario[0])){
                                                  if($inventario[0]['tipo_inventario']=="Mercancia"){
                                                    if($inventario[0]['id_mercancia']==$data['id_mercancia']){
                                                      echo "selected";
                                                      $tipoInvOP="Mercancia";
                                                    }
                                                  }
                                                }
                                              ?>
                                              >Mercancia: <?php echo $data['mercancia']." - (".$data['medidas_mercancia'].")"; ?></option>
                                            <?php } } ?>
                                          </select>
                                          <input type="hidden" id="tipo<?=$pagosDFill['id'];?><?=$x.$z; ?>" name="tipos[<?=$pagosDFill['id'];?>][]" value="<?=$tipoInvOP; ?>">
                                          <span id="error_seleccion<?=$pagosDFill['id'];?><?=$x.$z; ?>" class="errors"></span>
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div class="form-group col-xs-12 w-100" style="position:relative;margin-top:-10px;margin-left:90%;">
                                          <?php if($z<$limitesElementos){ ?>
                                            <span id="addMore<?=$pagosDFill['id'];?><?=$x.$z; ?>" min="<?=$pagosDFill['id'];?>" max="<?=$x; ?>" class="addMore btn btn-success" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>+</b></span>
                                          <?php  } ?>
                                          <?php if($z>=2){ ?>
                                            <span id="addMenos<?=$pagosDFill['id'];?><?=$x.$z; ?>" min="<?=$pagosDFill['id'];?>" max="<?=$x; ?>" class="addMenos btn btn-danger" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>-</b></span>
                                          <?php  } ?>
                                        </div>
                                      </div>
                                    <?php } ?>
                                    <input type="hidden" name="cantidad_elementos[<?=$pagosDFill['id'];?>][]" id="cantidad_elementosOp<?=$pagosDFill['id'];?><?=$x; ?>" value="<?=$elementosMostrar; ?>">
                                  </div>
                                  <br>
                                  <div class="form-group col-xs-12 w-100 <?php if($adicionalesSoloPagoDeSeleccion){ if($pagosD['asignacion_pago_despacho']!="seleccion_premios"){ echo "d-none"; } } ?>">
                                    <?php if($x<$limitesOpciones){ ?>
                                      <span id="addMoreOp<?=$pagosDFill['id'];?><?=$x; ?>" min="<?=$pagosDFill['id'];?>" max="<?=$x; ?>" class="addMoreOp btn btn-success"><b>+</b></span>
                                    <?php  } ?>
                                    <?php if($x>=2){ ?>
                                      <span id="addMenosOp<?=$pagosDFill['id'];?><?=$x; ?>" min="<?=$pagosDFill['id'];?>" max="<?=$x; ?>" class="addMenosOp btn btn-danger"><b>-</b></span>
                                    <?php  } ?>
                                  </div>
                                </div>
                              <?php } ?>
                              <input type="hidden" name="cantidad_opciones[<?=$pagosDFill['id'];?>]" id="cantidad_opciones_<?=$pagosDFill['id'];?>" value="<?=$opcionsMostrar; ?>">
                            </div>



                            <!-- <div class="form-group col-xs-12">
                              <div>
                                <label for="seleccion_<?=$pagosDFill['id'];?>"><?=$pagosDFill['name']; ?></label>
                                <select class="form-control select2 tipos_seleccion" style="width:100%;" name="tipos[<?=$pagosDFill['id']; ?>]" id="tipo_<?=$pagosDFill['id']; ?>">
                                  <option value=""></option>
                                  <option>Productos</option>
                                  <?php
                                  foreach ($pagos_despacho as $key) {
                                    if($key['tipo_pago_despacho']==$pagosDFill['name']){
                                      if($key['asignacion_pago_despacho']=="seleccion_premios"){ ?>
                                        <option>Premios</option>
                                      <?php }
                                    }
                                  }
                                  ?>
                                </select>
                                <span id="error_tipo_<?=$pagosDFill['id']; ?>" class="errors"></span>
                              </div>

                              <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['name']; ?>" name="tipos_premios[<?=$pagosDFill['id']; ?>]" id="tipos_premios_<?=$pagosDFill['id']; ?>">
                              <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['id']; ?>" name="tipos_premios_id[<?=$pagosDFill['id']; ?>]" id="tipos_premios_<?=$pagosDFill['id']; ?>">

                              <div class="box_tipo_<?=$pagosDFill['id']; ?> box_productos_tipo_<?=$pagosDFill['id']; ?> d-none">
                                <label for="seleccion_productos_<?=$pagosDFill['id'];?>">Seleccionar Productos</label>
                                <select class="select2" style="width:100%" id="seleccion_productos_<?=$pagosDFill['id'];?>" placeholder="" multiple="multiple" name="productos_<?=$pagosDFill['id'];?>[]">
                                  <option value=""></option>
                                  <option value="0">Ninguna</option>
                                  <?php foreach ($productos as $data): if( !empty($data['id_producto']) ): ?>
                                    <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option>
                                  <?php endif; endforeach; ?>
                                </select>
                                <span id="error_seleccion_productos_<?=$pagosDFill['id'];?>" class="errors"></span>
                              </div>

                              <div class="box_tipo_<?=$pagosDFill['id']; ?> box_premios_tipo_<?=$pagosDFill['id']; ?> d-none">
                                <label for="seleccion_premios_<?=$pagosDFill['id'];?>">Seleccionar Premios</label>
                                <select class="select2" style="width:100%" id="seleccion_premios_<?=$pagosDFill['id'];?>" placeholder="premios" multiple="multiple" name="premios_<?=$pagosDFill['id'];?>[]">
                                  <option value=""></option>
                                  <option value="0">Ninguna</option>
                                  <?php foreach ($premios as $data): if( !empty($data['id_premio']) ): ?>
                                    <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option>
                                  <?php endif; endforeach; ?>
                                </select>
                                <span id="error_seleccion_premios_<?=$pagosDFill['id'];?>" class="errors"></span>
                              </div>                        

                            </div> -->
                          </div>
                          
                        <?php
                          $indexPg++;
                        }
                      }
                    }
                  ?>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <input type="hidden" id="limiteElementos" value="<?=$limitesElementos; ?>">
              <input type="hidden" id="limiteOpciones" value="<?=$limitesOpciones; ?>">
              <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

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
<?php endif; ?>
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">


<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.addMore, .addMenos, .addMoreOp, .addMenosOp{
  border-radius:40px;
  border:1px solid #CCC;
}
.addMore, .addMenos{
  margin-top:15px;
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosCamp";
        window.location = menu;
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

  $(".box_inventario_tipo.d-none").hide();
  $(".box_inventario_tipo.d-none").removeClass("d-none");

  $(".box_opciones.d-none").hide();
  $(".box_opciones.d-none").removeClass("d-none");
  
  // $("#box_tipoinicial2").show();
  $(".addMoreOp").click(function(){
    var id = $(this).attr('id');
    var index = $(this).attr('min');
    var num = $(this).attr('max');
    alimentarBoxTipo(index, num);
  });

  $(".addMenosOp").click(function(){
    var id = $(this).attr('id');
    var index = $(this).attr('min');
    var num = $(this).attr('max');
    retroalimentarBoxTipo(index, num);
  });

  function alimentarBoxTipo(index, num){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_opciones_"+index).val());
    $("#addMoreOp"+index+cant).hide();
    $("#addMenosOp"+index+cant).hide();
    cant++;
    $("#box_opciones"+index+cant).show();
    $("#cantidad_opciones_"+index).val(cant);
  }

  function retroalimentarBoxTipo(index, num){
    var cant = parseInt($("#cantidad_opciones_"+index).val());
    $("#box_opciones"+index+cant).hide();
    cant--;
    $("#addMoreOp"+index+cant).show();
    $("#addMenosOp"+index+cant).show();
    $("#cantidad_opciones_"+index).val(cant);
  }
  $(".addMore").click(function(){
      var id=$(this).attr('id');
    var index=$(this).attr('min');
    var num=$(this).attr('max');
    alimentarFormInventario(index, num);
  });

  $(".addMenos").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    var num=$(this).attr('max');
    retroalimentarFormInventario(index, num);
  });

  function alimentarFormInventario(index, num){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementosOp"+index+num).val());
    $("#addMore"+index+num+cant).hide();
    $("#addMenos"+index+num+cant).hide();
    cant++;
    $("#box_tipo"+index+num+cant).show();
    $("#cantidad_elementosOp"+index+num).val(cant);
  }
  function retroalimentarFormInventario(index, num){
    var cant = parseInt($("#cantidad_elementosOp"+index+num).val());
    $("#box_tipo"+index+num+cant).hide();
    cant--;
    $("#addMore"+index+num+cant).show();
    $("#addMenos"+index+num+cant).show();
    $("#cantidad_elementosOp"+index+num).val(cant);
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      plan: $("#plan").val(),
                      // nombre_producto: $("#nombre_producto").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
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

    } //Fin condicion

  }); // Fin Evento


  // $(".box_tipo_inicial").hide();
  // $(".box_tipo_inicial").removeClass("d-none");
  $(".seleccion_inventario").on('change', function(){
    var value = $(this).val();
    var index = $(this).attr('min');
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

  $("#plan").on('change', function(){
    var id_plan_camp = $(this).val();
    var json_planes = $(".json_planes").html();
    var dataPlanes = JSON.parse(json_planes);
    // alert(cantCols);
    // console.log(dataPlanes.length);
    var cantCols = 0;
    if(id_plan_camp!=""){
      for (let i=0;i<dataPlanes.length;i++) {
        const element = dataPlanes[i];
        if(element['id_plan_campana']==id_plan_camp){
          cantCols = element['cantidad_coleccion'];
        }
      }
    }
    if(cantCols==0){
      cantCols=1;
    }
    cantCols = parseInt(cantCols);
    var opInicial = $("#opInicial").val();
    if(opInicial=="Y"){
      var id = "inicial";
      var name = "Inicial";
      var opciones = $("#cantidad_opciones_"+id).val();
      for (let x=1; x<=opciones; x++) {
        var elementos = $("#cantidad_elementosOp"+id+x).val();
        for (let z=1; z<=elementos; z++) {
          var stock = parseInt($("#unidad_"+id+x+z).val());
          if(id_plan_camp!=""){
            $("#unidad_"+id+x+z).val((stock*cantCols));
          }else{
            var stockh = $("#uunidad_"+id+x+z).val();
            $("#unidad_"+id+x+z).val((stockh));
          }
        }
      }
    }


    var pagos_despachos = $(".json_pagos").html();
    var json_pagos = JSON.parse(pagos_despachos);
    for (var i = 0; i < json_pagos.length; i++) {
      var id = json_pagos[i]['id'];
      var name = json_pagos[i]['name'];
      var opciones = $("#cantidad_opciones_"+id).val();
      for (let x=1; x<=opciones; x++) {
        var elementos = $("#cantidad_elementosOp"+id+x).val();
        for (let z=1; z<=elementos; z++) {
          var stock = $("#unidad_"+id+x+z).val();
          if(id_plan_camp!=""){
            $("#unidad_"+id+x+z).val((stock*cantCols));
          }else{
            var stockh = $("#uunidad_"+id+x+z).val();
            $("#unidad_"+id+x+z).val((stockh));
          }
        }
      }
    }
  });

});
function validar(){
  $(".btn-enviar").attr("disabled");
  // var limiteElementos = $("#limiteElementos").val();
  // var limiteOpciones = $("#limiteOpciones").val();
  /*===================================================================*/
  var plan = $("#plan").val();
  var rplan = false;
  if(plan == ""){
    rplan = false;
    $("#error_plan").html("Debe seleccionar el plan para seleccionar los premios");
  }else{
    rplan = true;
    $("#error_plan").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // Inicial
  /*===================================================================*/
  var opInicial = $("#opInicial").val();
  if(opInicial=="Y"){
    var id = "inicial";
    var name = "Inicial";
    var rInicial = false;
    var opciones = $("#cantidad_opciones_"+id).val();
    var errores = 0;
    for (let x=1; x<=opciones; x++) {
      var nombre = $("#name_opcion_"+id+x).val();
      if(nombre==""){
        errores++;
        $("#error_name_opcion_"+id+x).html("Debe agregar un nombre para la opción #"+x+" de "+name);
      }else{
        $("#error_name_opcion_"+id+x).html("");
      }

      var elementos = $("#cantidad_elementosOp"+id+x).val();
      for (let z=1; z<=elementos; z++) {
        var stock = $("#unidad_"+id+x+z).val();
        if(stock==""){
          errores++;
          $("#error_unidad_"+id+x+z).html("Debe agregar la cantidad de unidades #"+z+" del inventario");
        }else{
          $("#error_unidad_"+id+x+z).html("");
        }
        var inventario = $("#seleccion"+id+x+z).val();
        if(inventario==""){
          errores++;
          $("#error_seleccion"+id+x+z).html("Debe seleccionar el elemento del inventario #"+z);
        }else{
          $("#error_seleccion"+id+x+z).html("");
        }
      }
    }
    if(errores==0){
      rInicial=true;
    }else{
      rInicial=false;
    }
  }else{
    var rInicial = true;
  }
  /*===================================================================*/
  
  /*===================================================================*/
      // Premios de los PAGOS
  /*===================================================================*/
  var pagos_despachos = $(".json_pagos").html();
  // alert(pagos_despachos);
  var json_pagos = JSON.parse(pagos_despachos);
  var rPremios = false;
  var erroresP = 0;
  for (var i = 0; i < json_pagos.length; i++) {
    var id = json_pagos[i]['id'];
    var name = json_pagos[i]['name'];
    var opciones = $("#cantidad_opciones_"+id).val();
    for (let x=1; x<=opciones; x++) {
      var nombre = $("#name_opcion_"+id+x).val();
      if(nombre==""){
        erroresP++;
        $("#error_name_opcion_"+id+x).html("Debe agregar un nombre para la opción #"+x+" de "+name);
      }else{
        $("#error_name_opcion_"+id+x).html("");
      }

      var elementos = $("#cantidad_elementosOp"+id+x).val();
      for (let z=1; z<=elementos; z++) {
        var stock = $("#unidad_"+id+x+z).val();
        if(stock==""){
          erroresP++;
          $("#error_unidad_"+id+x+z).html("Debe agregar la cantidad de unidades #"+z+" del inventario");
        }else{
          $("#error_unidad_"+id+x+z).html("");
        }
        var inventario = $("#seleccion"+id+x+z).val();
        if(inventario==""){
          erroresP++;
          $("#error_seleccion"+id+x+z).html("Debe seleccionar el elemento del inventario #"+z);
        }else{
          $("#error_seleccion"+id+x+z).html("");
        }
      }
    }
  }
  if(erroresP==0){
    rPremios=true;
  }else{
    rPremios=false;
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rplan==true && rInicial==true && rPremios==true){
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
