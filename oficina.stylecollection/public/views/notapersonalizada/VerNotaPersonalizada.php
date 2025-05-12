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
        <small><?php if(!empty($action)){echo "Detalle Notas de entrega personalizada";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Notas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Detalle ";} echo " Notas de entrega personalizada"; ?></li>
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
              <h3 class="box-title">Ver <?php echo "Notas de entrega Personalizada"; ?></h3>
            </div>
            <form action="" method="get" class="form table-responsive" target="_blank">
              <div class="box-body ">
                <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                <input type="hidden" value="<?=$numero_campana;?>" name="n">
                <input type="hidden" value="<?=$anio_campana;?>" name="y">
                <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                <input type="hidden" value="<?=$_GET['route']; ?>" name="route">
                <input type="hidden" value="Generar" name="action">
                <input type="hidden" value="<?=$_GET['nota']?>" name="nota">
                <div class="">
                    <div class="col-xs-12 col-sm-7 text-center">
                      <img src="public/assets/img/logoTipo1.png" style="width:350px;">
                      <br>
                      Rif.: J408497786
                      <br>
                      <div readonly="" maxlength="255" style="border:none;min-width:100%;max-width:100%;min-height:60px;max-height:60px;text-align:center;padding:0;padding-right:10%;padding-left:10%;"><?=$notaP['direccion_emision']?></div>
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
                          <input type="text" style="border:none;" readonly="" value="<?=$notaP['lugar_emision']?>" maxlength="90">
                        </div>
                        <div class="col-xs-12 col-md-6" style="display:inline-block;">
                          <small>FECHA DE EMISION</small>
                          <br>
                          <input type="date" style="border:none;" readonly="" value="<?=$notaP['fecha_emision']?>">
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
                        <input type="number" readonly="" class="form-control" step="1" value="<?=$notaP['numero_nota_entrega']?>" onfocusout="$(this).val(parseInt($(this).val()))" style="display:inline-block;font-size:1.6em;float:right;width:85%;margin:0;">
                      </div>
                    </div>
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
                      Analista: <?=$nombreanalista; ?>
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
                          <td colspan="3" style="width:70%;">
                            <?php if($notaP['leyenda']=="Credito Style"){ ?>
                              EMPLEADO:
                            <?php }else{ ?>
                                CLIENTE:
                            <?php } ?>
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=$persona['primer_nombre']." ".$persona['segundo_nombre']." ".$persona['primer_apellido']." ".$persona['segundo_apellido']?>
                          </td>
                          <td colspan="2">
                            C.I / R.I.F.:
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=number_format($persona['cedula'],0,'','.')?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            DIRECCION:
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?=$persona['direccion']?>
                          </td>
                          <td colspan="2">
                            NRO. TLF.: 
                            <span style="margin-left:10px;margin-right:10px;"></span>
                            <?php 
                              echo separateDatosCuentaTel($persona['telefono']);
                              if(strlen($persona['telefono2'])>5){

                                echo " / ".separateDatosCuentaTel($persona['telefono2']);
                              }
                            ?> 
                          </td>
                        </tr>
                        <?=$notaP['observacion']?>
                        <?php //if($notaP['observacion']!=""){ ?>
                            <tr>
                              <td colspan="3">
                                Observación:
                                <span style="margin-left:10px;margin-right:10px;"></span>
                                <span class="box-opt-editar-observacion txt-observacion-txt"><?=$notaP['observacion']; ?></span>
                                <input type="text" class="form-control input-sololectura box-opt-guardar-observacion d-none" style="width:80%;display:inline-block;" id="txt-observaciones" readonly value="<?=$notaP['observacion']; ?>">
                                <input type="hidden" id="txt-observaciones-hidden" value="<?=$notaP['observacion']; ?>">
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
                    <span><b style="color:<?=$fucsia; ?>;">Nota:</b> <b>Deberá llenar todas las opciones del renglón, de lo contrario no se guardará el registro.</b></span>
                    <div class="table-responsive">
                      <table class="table table-bordered text-left table-striped table-hover" id="">
                        <thead style="background:#DDD;font-size:1.05em;">
                          <tr>
                            <th style="text-align:center;width:4%;">Cantidad</th>
                            <th style="text-align:left;width:38%;">Descripcion</th>
                            <th style="text-align:left;width:58%;">Concepto</th>
                            <th style="text-align:left;width:10%;"></th>
                          </tr>
                          <style>
                            .col1{text-align:center;}
                            .col2{text-align:left;}
                            .col3{text-align:left;}
                            .col4{text-align:left;}
                          </style>
                        </thead>
                        <tbody>
                          <?php 
                            $faltaDisponible=0;
                            $mostrarListaNotas=[];
                            $reiterador=0;
                            $facturados = $lider->consultarQuery("SELECT * FROM operaciones, notasentrega WHERE operaciones.id_factura=notasentrega.id_nota_entrega and notasentrega.id_nota_entrega={$id_nota} and operaciones.id_factura={$id_nota} and operaciones.modulo_factura='{$moduloFacturacion}' ORDER BY operaciones.id_operacion ASC;");
                            
                            $calcular=false;
                            if(count($facturados)>1){
                              $calcular=false;
                            }else{
                              if($notaP['estado_nota_personalizada']==0){
                                $calcular=true;
                              }
                            }
                            if($calcular==true || $notaP['estado_nota_personalizada']==1){
                              $limiteDisponibles=[];
                              $mostrarNotasResumidas = [];
                              foreach($opcionesEntregas as $nota){ 
                                if(!empty($nota['id_opcion_entrega_personalizada'])){ 

                                  $disponibleOrNot = true;
                                  foreach ($productoss as $key) {
                                    if($nota['tipo_inventario']=='Productos'){
                                      if($nota['id_inventario']==$key['id_producto']){
                                        $nota['descripcion']=$key['producto'];
                                        if($nota['cantidad']>$key['stock_disponible']){
                                          if($notaP['estado_nota_personalizada']==1){
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
                                        $nota['descripcion']=$key['mercancia'];
                                        if($nota['cantidad']>$key['stock_disponible']){
                                          if($notaP['estado_nota_personalizada']==1){
                                            $disponibleOrNot=false;
                                          }
                                        }else{
                                          $disponibleOrNot=true;
                                        }
                                      }
                                    }
                                  }

                                  // $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$nota['id_inventario']}");
                                  // for ($i=0; $i < count($prinv)-1; $i++) { 
                                  //   if($prinv[$i]['tipo_inventario']=="Productos"){
                                  //     $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                  //   }
                                  //   if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                  //     $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                  //   }
                                  //   foreach ($inventario as $key) {
                                  //     if(!empty($key['elemento'])){
                                  //       $prinv[$i]['elemento']=$key['elemento'];
                                  //     }
                                  //   }
                                  // }
                                    $opcionTemp=$nota['opcion']; 
                                  ?>
                                  <!-- <tr class="codigo<?=$nota['id_opcion_entrega_personalizada']; ?>" <?php if($opcionTemp=="N"){ ?> style="color:#DDD"; <?php } ?>>
                                      <td class="col1">
                                        <?=$nota['cantidad']; ?>
                                      </td>
                                      <td class="col3">
                                        <?php
                                          $premio_producto = [];
                                          $id_p = "";                              
                                          $name_p = "";                              
                                          if($nota['tipo']=="Productos"){
                                            $premio_producto = $productosAll;
                                            $id_p = "id_producto";
                                            $name_p = "producto";
                                          }
                                          if($nota['tipo']=="Mercancia"){
                                            $premio_producto = $mercanciaAll;
                                            $id_p = "id_mercancia";
                                            $name_p = "mercancia";
                                          }
                                          foreach ($premio_producto as $premio) {
                                            if(!empty($premio[$id_p])){
                                              if($premio[$id_p]==$nota['id_inventario']){
                                                echo $premio[$name_p];
                                              }
                                            }
                                          }
                                        ?>
                                      </td>
                                      <td class="col4">
                                        <?=$nota['concepto']; ?>
                                      </td>
                                      <td></td>
                                      <td></td>
                                      <td>
                                        <select class="opciones opcion<?=$nota['id_opcion_entrega_personalizada']; ?>" name="P<?=$nota['id_opcion_entrega_personalizada']; ?>">
                                          <option <?php if(!empty($opcionTemp) && $opcionTemp!=""){ if($opcionTemp=="Y"){ ?> selected <?php } } ?> value="Y">SI</option>
                                          <option <?php if(!empty($opcionTemp) && $opcionTemp!=""){ if($opcionTemp=="N"){ ?> selected <?php } } ?> value="N">No</option>
                                        </select>
                                      </td>
                                    </tr> -->
                                  <?php

                                  $id_unico = $nota['cantidad']."*".$nota['tipo_inventario']."*".$nota['id_inventario'];
                                  $notasModificada = $lider->consultarQuery("SELECT * FROM notas_modificada_personalizada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_nota_entrega_personalizada={$_GET['nota']} and codigo_identificador='{$id_unico}'");
                                  if(count($notasModificada)>1){
                                    foreach ($notasModificada as $notaModif) {
                                      if(!empty($notaModif['id_nota_modificada_personalizada'])){
                                        // echo "asd";
                                        $nota['id_inventario']=$notaModif['id_inventario'];
                                        $nota['cantidad']=$notaModif['stock'];
                                        $nota['tipo_inventario'] = $notaModif['tipo_inventario'];
                                        $nota['precio_venta'] = $notaModif['precio_venta'];
                                        $nota['precio_nota'] = $notaModif['precio_nota'];
                                        $nota['delete'] = $notaModif['id_nota_modificada_personalizada'];
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
                                                if($notaP['estado_nota_personalizada']==1){
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
                                                if($notaP['estado_nota_personalizada']==1){
                                                  $disponibleOrNot=false;
                                                }
                                              }else{
                                                $disponibleOrNot=true;
                                              }
                                            }
                                          }
                                        }
                                        if(!$disponibleOrNot){
                                          if($notaP['estado_nota_personalizada']==1){
                                            $faltaDisponible++;
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
                                        $mostrarListaNotas[$reiterador]['precio_venta']=$nota['precio_venta'];
                                        $mostrarListaNotas[$reiterador]['precio_nota']=$nota['precio_nota'];
                                        $reiterador++;
                                        


                                        if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                          // $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                        }else{
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario'];
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precio_venta'];
                                          $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota'];
                                        }

                                        if($notaP['estado_nota_personalizada']==1){
                                          ?>
                                            <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                              <?php
                                                if ($opcionTemp=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                                else if($opcionTemp=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                                else if($opcionTemp=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                              ?>
                                            '>
                                              <td class="col1">
                                                <?=$nota['cantidad']; ?>
                                              </td>
                                              <td class="col2">
                                                <?=$nota['descripcion']; ?>
                                                <small style='font-size:0.9em;'>
                                                  <br>
                                                  <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precios_venta'],2,',','.').")"; ?>
                                                  <?="(Nota: ".number_format($nota['precios_nota'],2,',','.').")"; ?>
                                                </small>
                                              </td>
                                              <td class="col3">
                                                <?php
                                                  echo "Premios de ".$nota['concepto'];
                                                    $urlBorrarFact = $menuPersonalizado."delete=".$nota['delete']; 
                                                    
                                                    ?>
                                                    <a href="?<?=$urlBorrarFact; ?>">
                                                      <span title="<?=$nota['descripcion']; ?>" class='errors BorrarList'>
                                                        Borrar 
                                                      </span>
                                                    </a>
                                              </td>
                                              <td>
                                                <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                                  <option <?php if($opcionTemp=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                                  <option <?php if($opcionTemp=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                                </select>
                                              </td>
                                            </tr>
                                          <?php
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
                                    if(!$disponibleOrNot){
                                      if($nota['estado_nota_personalizada']==1){
                                        $faltaDisponible++;
                                      }
                                    }
                                    $mostrarListaNotas[$reiterador]['cantidad']=$nota['cantidad'];
                                    $mostrarListaNotas[$reiterador]['descripcion']=$nota['descripcion'];
                                    $mostrarListaNotas[$reiterador]['concepto']=$nota['concepto'];
                                    $mostrarListaNotas[$reiterador]['tipo_inventario']=$nota['tipo_inventario'];
                                    $mostrarListaNotas[$reiterador]['id_inventario']=$nota['id_inventario'];
                                    $reiterador++;
                                    
                                    
                                    if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                      // $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                    }else{
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario'];  
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precios_venta']; 
                                      $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precios_nota']; 
                                    }

                                    if($nota['estado_nota_personalizada']==1){
                                      ?>
                                        <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                          <?php
                                            if ($opcionTemp=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                            else if($opcionTemp=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                            else if($opcionTemp=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                          ?>
                                        '>
                                          <td class="col1">
                                            <?=$nota['cantidad']; ?>
                                          </td>
                                          <td class="col2">
                                            <?=$nota['descripcion']; ?>
                                            <small style='font-size:0.9em;'>
                                              <br>
                                              <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precios_venta'],2,',','.').")"; ?>
                                              <?="(Nota: ".number_format($nota['precios_nota'],2,',','.').")"; ?>
                                            </small>
                                          </td>
                                          <td class="col3">
                                            <?php
                                              echo "Premios de ".$nota['concepto'];
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
                                              if(!$disponibleOrNot){
                                                $urlEditFact = $menuPersonalizado."&i=".$nota['tipo_inventario']."&e=".$nota['id_inventario']."&pc=".$nota['cantidad']."&prv=".$nota['precios_venta']."&prn=".$nota['precios_nota']; 
                                                if($nota['estado_nota_personalizada']==1){
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
                                            ?>
                                          </td>
                                          <td>
                                            <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                              <option <?php if($opcionTemp=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                              <option <?php if($opcionTemp=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                            </select>
                                          </td>
                                        </tr>
                                      <?php
                                    }
                                  }

                                  
                                  
                                  
                                }
                              }
                                
                              $notasModificada = $lider->consultarQuery("SELECT * FROM notas_modificada_personalizada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_nota_entrega_personalizada={$_GET['nota']} and codigo_identificador=''");
                              // print_r($notasModificada);
                              $nota=[];
                              foreach ($notasModificada as $notaModif) {
                                if(!empty($notaModif['id_nota_modificada_personalizada'])){
                                  $optionTemp="Y";
                                  $nota['delete']=$notaModif['id_nota_modificada_personalizada'];
                                  $nota['cantidad']=$notaModif['stock'];
                                  if($notaModif['tipo_inventario']=="Productos"){
                                    $prinv = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE estatus=1 and id_producto={$notaModif['id_inventario']}");
                                    foreach($prinv as $inv){ if(!empty($inv['id_producto'])){
                                      $nota['descripcion'] = $inv['elemento'];
                                    } }
                                  }
                                  if($notaModif['tipo_inventario']=="Mercancia"){
                                    $prinv = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE estatus=1 and id_mercancia={$notaModif['id_inventario']}");
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
                                  $nota['precio_venta'] = $notaModif['precio_venta'];
                                  $nota['precio_nota'] = $notaModif['precio_nota'];
                                  
                                  $disponibleOrNot = true;
                                  foreach ($productoss as $key) {
                                    if($nota['tipo_inventario']=='Productos'){
                                      if($nota['id_inventario']==$key['id_producto']){
                                        if($nota['cantidad']>$key['stock_disponible']){
                                          if($notaP['estado_nota_personalizada']==1){
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
                                          if($notaP['estado_nota_personalizada']==1){
                                            $disponibleOrNot=false;
                                          }
                                        }else{
                                          $disponibleOrNot=true;
                                        }
                                      }
                                    }
                                  }
                                  if(!$disponibleOrNot){
                                    if($notaP['estado_nota_personalizada']==1){
                                      $faltaDisponible++;
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
                                  $mostrarListaNotas[$reiterador]['precio_venta']=$nota['precio_venta'];
                                  $mostrarListaNotas[$reiterador]['precio_nota']=$nota['precio_nota'];
                                  $reiterador++;
                                  

                                  if(!empty($mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']])){
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] += $nota['cantidad'];
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] .= ", ".$nota['concepto'];
                                  }else{
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['cantidad'] = $nota['cantidad']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['descripcion'] = $nota['descripcion']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['concepto'] = $nota['concepto'];
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['id_inventario'] = $nota['id_inventario']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['tipo_inventario'] = $nota['tipo_inventario']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_venta'] = $nota['precio_venta']; 
                                    $mostrarNotasResumidas[$nota['tipo_inventario'].$nota['id_inventario']]['precio_nota'] = $nota['precio_nota']; 
                                  }

                                  if($notaP['estado_nota_personalizada']==1){
                                    ?>
                                      <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                        <?php
                                          if ($optionTemp=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                          else if($optionTemp=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                          else if($optionTemp=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                        ?>
                                      '>
                                        <td class="col1">
                                          <?=$nota['cantidad']; ?>
                                        </td>
                                        <td class="col2">
                                          <?=$nota['descripcion']; ?>
                                          <?="&nbsp&nbsp&nbsp(Venta: ".number_format($nota['precio_venta'],2,',','.').")"; ?>
                                          <?="(Nota: ".number_format($nota['precio_nota'],2,',','.').")"; ?>
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
                                            $urlBorrarFact = $menuPersonalizado."delete=".$nota['delete']; 
                                                    
                                            if($notaP['estado_nota_personalizada']==1){
                                              ?>
                                                <a href="?<?=$urlBorrarFact; ?>">
                                                  <span title="<?=$nota['descripcion']; ?>" class='errors BorrarList'>
                                                    Borrar 
                                                  </span>
                                                </a>
                                              <?php
                                            }
                                          ?>
                                        </td>
                                        <td>
                                          <select class="opciones" name="opts[<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>]" id="<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>">
                                            <option <?php if($optionTemp=="Y"){ ?> selected <?php  } ?> value="Y">SI</option>
                                            <option <?php if($optionTemp=="N"){ ?> selected <?php  } ?> value="N">NO</option>
                                          </select>
                                        </td>
                                      </tr>
                                    <?php
                                  }
                                }
                              }
                                
                            }
                            if($notaP['estado_nota_personalizada']==0){
                              // print_r($mostrarNotasResumidas);
                              // $mostrarNotasResumidas = $_SESSION['mostrarNotasResumidas'];
                              if($calcular==false){
                                foreach ($facturados as $facts) {
                                  if(!empty($facts['id_factura'])){
                                    $codigoIndex=$facts['tipo_inventario'].$facts['id_inventario'];
                                    if(!empty($mostrarNotasResumidas[$codigoIndex])){
                                      if($facts['tipo_operacion']=="Entrada"){
                                        $mostrarNotasResumidas[$codigoIndex]['cantidad']-=$facts['stock_operacion'];
                                      }
                                      if($facts['tipo_operacion']=="Salida"){
                                        $mostrarNotasResumidas[$codigoIndex]['cantidad']+=$facts['stock_operacion'];
                                      }
                                    }else{
                                      $mostrarNotasResumidas[$codigoIndex]['cantidad']=0;
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
                                          $mostrarNotasResumidas[$codigoIndex]['descripcion']=$inv['elemento'];
                                          $mostrarNotasResumidas[$codigoIndex]['concepto']=$facts['concepto_factura'];
                                          $mostrarNotasResumidas[$codigoIndex]['tipo_inventario']=$facts['tipo_inventario'];
                                          $mostrarNotasResumidas[$codigoIndex]['id_inventario']=$facts['id_inventario'];
                                          if($facts['tipo_operacion']=="Entrada"){
                                            $mostrarNotasResumidas[$codigoIndex]['cantidad']-=$facts['stock_operacion'];
                                          }
                                          if($facts['tipo_operacion']=="Salida"){
                                            $mostrarNotasResumidas[$codigoIndex]['cantidad']+=$facts['stock_operacion'];
                                          }
                                        }
                                      }
                                      // $index++;
                                    }
                                  }
                                }
                              }
                              foreach ($mostrarNotasResumidas as $nota) {
                                $option = "";
                                foreach ($opcionesEntregas as $opt){
                                  if(!empty($opt['id_opcion_entrega_personalizada'])){ 
                                    $opt['cod']=$opt['tipo'].$opt['producto_premio'];
                                    $opt['val']=$opt['opcion'];
                                    // print_r($opt);
                                    // echo "<br><br>";
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
                                        if($notaP['estado_nota_personalizada']==1){
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
                                        if($notaP['estado_nota_personalizada']==1){
                                          $disponibleOrNot=false;
                                        }
                                      }else{
                                        $disponibleOrNot=true;
                                      }
                                    }
                                  }
                                }
                                
                                $id_unico = $nota['cantidad']."*".$nota['tipo_inventario']."*".$nota['id_inventario'];

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
                                  if(!$disponibleOrNot){
                                    if($notaentrega['estado_nota']==1){
                                      $faltaDisponible++;
                                    }
                                  }
                                  $mostrarListaNotas[$reiterador]['cantidad']=$nota['cantidad'];
                                  $mostrarListaNotas[$reiterador]['descripcion']=$nota['descripcion'];
                                  $mostrarListaNotas[$reiterador]['concepto']=$nota['concepto'];
                                  $mostrarListaNotas[$reiterador]['tipo_inventario']=$nota['tipo_inventario'];
                                  $mostrarListaNotas[$reiterador]['id_inventario']=$nota['id_inventario'];
                                  $reiterador++;
                                  
                                  
                                  

                                  ?>
                                    <tr class="codigo<?=$nota['cantidad'].$nota['tipo_inventario'].$nota['id_inventario']; ?>" style='
                                      <?php
                                        if ($option=="N" && !$disponibleOrNot){ echo "color:#DDD;"; } 
                                        else if($option=="Y" && !$disponibleOrNot){ echo "color:red;"; }
                                        else if($option=="N" && $disponibleOrNot){ echo "color:blue;"; }
                                      ?>
                                    '>
                                      <td class="col1">
                                        <?=$nota['cantidad']; ?>
                                      </td>
                                      <td class="col2">
                                        <?=$nota['descripcion']; ?>
                                      </td>
                                      <td class="col3">
                                        <?php
                                          // echo "Premios de ".$nota['concepto'];
                                          echo $nota['concepto'];
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
                            // $_SESSION['limiteDisponiblesInventarioNotaPerso'] = $limiteDisponibles;
                            // $_SESSION['mostrarListaNotasNotaPerso'] = $mostrarListaNotas;
                            $_SESSION['mostrarNotasResumidasNotaPerso'.$_GET['nota']] = $mostrarNotasResumidas;

                            // foreach ($mostrarNotasResumidas as $key) {
                            //   print_r($key);
                            //   // echo number_format($key['precio_venta']+0.5+5000,2,'.','');
                            //   echo "<br><br>";
                            // }
                          ?>
                        </tbody>
                      </table>
                      <?php //echo "faltaDisponible: ".$faltaDisponible; ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="box-footer">
                <span type="submit" class="btn enviar">Generar PDF</span>
                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div> -->
              <?php if($faltaDisponible==0 && $notaP['estado_nota_personalizada']==1){ ?>
                <div class="box-footer">
                  <?php $urlAgregarFact = $menuPersonalizado."nuevo=1";  ?>
                  <a href="?<?=$urlAgregarFact; ?>"><span class='btn enviar2'>Agregar</span></a>
                  <br><br><br>

                  <?php $urlCerrarFact = $menuPersonalizado."cerrar=1"; ?>
                  <a href="?<?=$urlCerrarFact; ?>"><span class='btn enviar2'>Cerrar Nota </span></a>

                  <br><br>
                  <!-- <button class="btn-enviar d-none" disabled="" >enviar</button> -->
                </div>
              <?php } ?>
              <?php if($faltaDisponible==0 && $notaP['estado_nota_personalizada']==0){ ?>
                <div class="box-footer">
                <?php $urlAbrirFact = $menuPersonalizado."abrir=1"; ?>
                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Contable"){ ?>
                  <a href="?<?=$urlAbrirFact; ?>"><span title="<?=$nota['descripcion']; ?>" class='btn enviar2'>Abrir Nota </span></a>
                  <br><br>
                <?php } ?>
                  <button type="submit" class="btn enviar2">Generar PDF Nota</button>
                  <br>
                  <br>
                  <button type="submit" class="btn enviar2" name="type" value="CP2">Generar PDF Factura Con Precio</button>
                  <button type="submit" class="btn enviar2" name="type" value="CP1">Generar PDF Factura Con Precio M/C</button>
                  <br>
                  <br>
                  <button type="submit" class="btn enviar2" name="type" value="SP2">Generar PDF Factura Sin Precio</button>
                  <button type="submit" class="btn enviar2" name="type" value="SP1">Generar PDF Factura Sin Precio M/C</button>
                </div>
              <?php } ?>
            </form>
          </div>

        </div>
        <!--/.col (left) -->

        <?php if( ( !empty($_GET['i']) && !empty($_GET['e'])) || (!empty($_GET['nuevo']))){ ?>
          <?php
              $limiteDisponibles = $_SESSION['limiteDisponiblesInventarioNotaPerso'];
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
                                    echo ($_GET[$z]['pc']*$_GET[$z]['prv']);
                                }
                                ?>">
                                <span id="error_precio_venta<?=$z; ?>" class="errors"></span>
                              </div>
                              <div style="width:15%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                <input type="number" class="form-control" id="precio_nota<?=$z; ?>" min="0" name="precio_nota[]" step="1" placeholder="Cantidad (150)" value="<?php 
                                if(!empty($_GET[$z]['pc']) && !empty($_GET[$z]['prn'])){
                                    echo ($_GET[$z]['pc']*$_GET[$z]['prn']);
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
  display:hidden;
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
}
.editList{
    float:right;margin-right:20px;color:#04a7c9;
}
.input-sololectura{
  background:none !important;border:none;
}
.BorrarList{
    float:right;margin-right:20px;color:red;
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
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=NotaPersonalizada";
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
  // $(".productos").hide();
  // $(".premios").hide();

  $(".selectLider").change(function(){
    var select = $(this).val();
    // alert(select);
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".tipos").change(function(){
    var id = $(this).attr("id");
    var val = $(this).val();
    $(".ids"+id).hide();
    $(".box-producto"+id).hide();
    $(".box-premio"+id).hide();
    if(val==""){
      $(".ids"+id).show();
    }
    if(val=="Productos"){
      $(".box-producto"+id).show();
    }
    if(val=="Premios"){
      $(".box-premio"+id).show();
    }
  });
  $(".cargarCantidad").click(function(){
    console.clear();
    var cant = $("#cant").val();
    var cantDefault = 5;
    if(cant==""){
      $("#cant").val(cantDefault);
    }
    cant = $("#cant").val();
    var cantidades = Array();
    var tipos = Array();
    var productos = Array();
    var premios = Array();
    var conceptos = Array();
    var opciones = Array();
    for (var i = 0; i < cant; i++) {
      cantidades[i] = $(".cantidad"+i).val();
      tipos[i] = $(".tipo"+i).val();
      productos[i] = $(".producto"+i).val();
      premios[i] = $(".premio"+i).val();
      conceptos[i] = $(".concepto"+i).val();
      opciones[i] = $(".opcion"+i).val();
    }
    $.ajax({
      url: "",
      type: "POST",
      data: {
        refrescandoCantidades: true,
        cantidades: cantidades,
        tipos: tipos,
        productos: productos,
        premios: premios,
        conceptos: conceptos,
        opciones: opciones,
      },
      success: function(response){
        if(response=="1"){
          $(".form_select_cantidad").submit();
        }
      }
    });
    // alert(cantidades);
    // console.log(cantidades);
  });

  var cant = $("#cant").val();
  var cantDefault = 5;
  if(cant==""){
    $("#cant").val(cantDefault);
  }
  cant = $("#cant").val();
  for (var i = 0; i < cant; i++) {
    var cod = i;
    var val = $(".opcion"+cod).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
      $(".texts"+cod).attr("style", "");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
      $(".texts"+cod).attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
    }
  }

  $(".opciones").change(function(){
    // var cod = $(this).attr("id");
    // var val = $(this).val();
    // if(val == "Y"){
    //   $(".codigo"+cod).attr("style", "");
    //   $(".texts"+cod).attr("style", "");
    //   $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
    //   $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
    // }
    // if(val == "N"){
    //   $(".codigo"+cod).attr("style", "color:#DDD;");
    //   $(".texts"+cod).attr("style", "color:#DDD;background:#FEFEFE;");
    //   $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
    //   $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
    // }
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
function validadModal(){
    var cantidad_elementos = $("#cantidad_elementos").val();
    var rstocks = false;
    var rinventarios = false;
    var rprecios_ventas = false;
    var rprecios_notas = false;
    if(cantidad_elementos==0){
        var rstocks = false;
        var rinventarios = false;
        var rprecios_ventas = false;
        var rprecios_notas = false;
    }else{
        var erroresStock=0;
        var erroresInventario=0;
        var erroresPrecioVenta=0;
        var erroresPrecioNota=0;
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
            var precio_venta = $("#precio_venta"+i).val();
            var rprecio_venta = checkInput(precio_venta, numberPattern2);
            if( rprecio_venta == false ){
                if(precio_venta.length != 0){
                $("#error_precio_venta"+i).html("La cantidad no debe contener letras o caracteres especiales");
                }else{
                $("#error_precio_venta"+i).html("Debe llenar el precio de venta");      
                }
            }else{
                $("#error_precio_venta"+i).html("");
            }
            if(rprecio_venta==false){ erroresPrecioVenta++; }
            /*===================================================================*/

            /*===================================================================*/
            var precio_nota = $("#precio_nota"+i).val();
            var rprecio_nota = checkInput(precio_nota, numberPattern2);
            if( rprecio_nota == false ){
                if(precio_nota.length != 0){
                $("#error_precio_nota"+i).html("La cantidad no debe contener letras o caracteres especiales");
                }else{
                $("#error_precio_nota"+i).html("Debe llenar el precio de la nota");      
                }
            }else{
                $("#error_precio_nota"+i).html("");
            }
            if(rprecio_nota==false){ erroresPrecioNota++; }
            /*===================================================================*/

            /*===================================================================*/
            /*===================================================================*/
        }
        if(erroresStock==0){ rstocks=true; }
        if(erroresInventario==0){ rinventarios=true; }
        if(erroresPrecioVenta==0){ rprecios_ventas=true; }
        if(erroresPrecioNota==0){ rprecios_notas=true; }
    }
    var response = false;
    if(rstocks==true && rinventarios==true && rprecios_ventas==true && rprecios_notas==true){
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
