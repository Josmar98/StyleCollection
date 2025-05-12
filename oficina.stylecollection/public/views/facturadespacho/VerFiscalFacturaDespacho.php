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
            <?php echo $modulo; ?>
            <small><?php if(!empty($action)){echo "Ver ".$modulo;} echo " "; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
            <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
            <li class="active"><?php if(!empty($action)){echo "";} echo " ".$modulo; ?></li>
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
                        <h3 class="box-title">Ver <?php echo $modulo; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12" style='padding:0px 30px;'>
                                    <span class='numeroFactura <?=$classMayus; ?>' style='position:absolute;right:36.5%;'><br><b><?=$nameFactura; ?></b> 
                                        <span class='numFact'><b style=''><?=$num_factura; ?></b></span>
                                    </span>				
                                    <span class='fecha' style='float:right;'>
                                        <table class='{$classMayus}'>
                                        <tr>
                                            <td>
                                                <b>Emision: </b> 
                                            </td>
                                            <td>
                                                <span class='dates'><?=$lider->formatFecha($factura['fecha_emision']); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Vence: </b>
                                            </td>
                                            <td>
                                                <span class='dates'><?=$lider->formatFecha($factura['fecha_vencimiento']); ?></span>
                                            </td>
                                        </tr>
                                        </table>
                                    </span>
                                    <br>
                                    <br>
                                    <table class='table1 <?=$classMayus; ?>'>
                                        <tr>
                                            <td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'><?=$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']; ?></span></td>
                                            <td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'><?=$factura['cod_rif']."".$factura['rif']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b><?=$factura['direccion']; ?></span></td>
                                            <td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'><?=$factura['telefono']; ?></span></td>
                                        </tr>
                                        <?php if($factura['observacion']!=""){ ?>
                                        <tr>
                                            <td class='celcontent' style='width:75% !important;' colspan='4'><span class='titulo-table'><b class='titulo-table'>Observación: </b><?=$factura['observacion']; ?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    <br>

                                    <?php if($type==1){ ?>
                                    <table class='table2' style='width:100%;border:1px solid #000;'>
                                        <tr>
                                    <?php } ?>
                                    <?php if($type==2){ ?>
                                    <table class='table2' style='width:100%;font-size:1.02em;border:1px solid #000;'>
                                        <tr style='font-size:1.01em;'>
                                    <?php } ?>
                                            <td class='celtitleL'><b><span style='color:rgba(0,0,0,0);'>__</span>Cantidad</b></td>
                                            <td class='celtitleL descrip'><b>Descripcion</b></td>
                                            <td class='celtitleR'><b></b></td>
                                            <td class='celtitleR'><b></b></td>
                                            <td class='celtitleR'><b>Precio</b></td>
                                            <td class='celtitleR'><b>Total<span style='color:rgba(0,0,0,0);'>__</span></b></td>
                                        </tr>
                                        <tr style=''>
                                            <td colspan='6'><span style='width:100%;height:1px;display:block;background:#000;'></span></td>
                                        </tr>
                                        <?php 
                                            $reiterador = 0;

                                            if($factura['estado_factura']==1){
                                                $coleccionesFacturadas = $lider->consultarQuery("SELECT * FROM despachos_facturados WHERE id_pedido={$id_pedido}");
                                                $facturadosDescontar=[];
                                                $facturados = $lider->consultarQuery("SELECT * FROM operaciones, factura_despacho WHERE operaciones.id_factura=factura_despacho.id_factura_despacho and factura_despacho.id_pedido={$id_pedido} and operaciones.modulo_factura='{$moduloFacturacion}' ORDER BY operaciones.id_operacion ASC;");
                                                foreach ($facturados as $facts) {
                                                    if(!empty($facts['id_pedido'])){
                                                        $codFact=$facts['tipo_inventario'].$facts['id_inventario'].$facts['concepto_factura'];
                                                        if(!empty($facturadosDescontar[$codFact])){
                                                            if($facts['tipo_operacion']=="Entrada"){
                                                                $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                                            }
                                                            if($facts['tipo_operacion']=="Salida"){
                                                                $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                                            }
                                                        }else{
                                                            $facturadosDescontar[$codFact]['cantidad']=0;
                                                            $facturadosDescontar[$codFact]['tipo_inventario']=$facts['tipo_inventario'];
                                                            $facturadosDescontar[$codFact]['id_inventario']=$facts['id_inventario'];
                                                            $facturadosDescontar[$codFact]['concepto']=$facts['concepto_factura'];
                                                            if($facts['tipo_operacion']=="Entrada"){
                                                                $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                                            }
                                                            if($facts['tipo_operacion']=="Salida"){
                                                                $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                                            }
                                                        }
                                                    }
                                                }
                                                $facturados = $lider->consultarQuery("SELECT * FROM operaciones, factura_despacho_personalizada WHERE operaciones.id_factura=factura_despacho_personalizada.id_factura_despacho_perso and factura_despacho_personalizada.id_pedido={$id_pedido} and operaciones.modulo_factura='{$moduloFacturacionn}' ORDER BY operaciones.id_operacion ASC;");
                                                foreach ($facturados as $facts) {
                                                    if(!empty($facts['id_pedido'])){
                                                        $codFact=$facts['tipo_inventario'].$facts['id_inventario'].$facts['concepto_factura'];;
                                                        if(!empty($facturadosDescontar[$codFact])){
                                                            if($facts['tipo_operacion']=="Entrada"){
                                                                $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                                            }
                                                            if($facts['tipo_operacion']=="Salida"){
                                                                $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                                            }
                                                        }else{
                                                            $facturadosDescontar[$codFact]['cantidad']=0;
                                                            $facturadosDescontar[$codFact]['tipo_inventario']=$facts['tipo_inventario'];
                                                            $facturadosDescontar[$codFact]['id_inventario']=$facts['id_inventario'];
                                                            $facturadosDescontar[$codFact]['concepto']=$facts['concepto_factura'];
                                                            if($facts['tipo_operacion']=="Entrada"){
                                                                $facturadosDescontar[$codFact]['cantidad']-=$facts['stock_operacion'];
                                                            }
                                                            if($facts['tipo_operacion']=="Salida"){
                                                                $facturadosDescontar[$codFact]['cantidad']+=$facts['stock_operacion'];
                                                            }
                                                        }
                                                    }
                                                }
                  
                                                $coleccionesDevueltas = $lider->consultarQuery("SELECT * FROM orden_devolucion_colecciones WHERE id_pedido={$id}");
                                                foreach ($coleccionesDevueltas as $keys) {
                                                  if(!empty($keys['id_orden_dev_col'])){
                                                    $facturadas[mb_strtolower($keys['nombre_coleccion'])]['cantidad_coleccion']-=$keys['cantidad_colecciones'];
                                                  }
                                                }
                                                // foreach ($facturadosDescontar as $key) {
                                                //     print_r($key);
                                                //     echo "<br><br>";
                                                // }

                                                $sumCantProd = 0;
                                                $sumPrecioProductos = 0;
                                                $numero=1;
                                                $numLim2 = $numLim;
                                                // $extrem *= 2;
                                                if($numerosCols >= (($extrem+1)) && $numerosCols <= $extrem+$numLim2){
                                                    $numLim=($extrem-4+$numLim2);
                                                }else if($numerosCols>($extrem+$numLim)){
                                                    $numLim=($extrem-1+$numLim2);
                                                }
                                                $sumaTotales = 0;
                                                $coleccionesMostrar=[];
                                                
                                                $stocksInventario = [];
                                                foreach ($colecciones as $cols) {
                                                    if(!empty($cols[0])){
                                                        if($procederVariado){
                                                            $cantAprobada = $cols['cantidad_aprobado'];
                                                        }else{
                                                            $cantAprobada = $cols['cantidad_aprobado'];
                                                        }
                                                        if($numero<=$numLim){
                                                            $cantProduct = $cols['cantidad_productos']*$cantAprobada;
                                                            // $cantProduct *= $cifraMultiplo; 
                                                            
                                                            $precioUnidProduct = $cols['precio_producto'];
                                                            // $precioUnidProduct *= $cifraMultiplo;
                
                                                            $total = ($cantProduct*$precioUnidProduct);
                                                            $total *= $cifraMultiplo;
                
                                                            $sumaTotales+=$total;
                                                            
                                                            $mostrarCantProduct = ""; 
                                                            if( strlen($cantProduct) == 1 ){
                                                                $mostrarCantProduct = "0".$cantProduct;
                                                            }else{
                                                                $mostrarCantProduct = $cantProduct;
                                                            }
                
                                                            $sumCantProd += $cantProduct;
                                                            $sumPrecioProductos += $precioUnidProduct;
                                                            $sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
                                                            //font-size:0.98em;
                                                            if($cantProduct>0){
                                                                $tabla="";
                                                                if(!empty($cols['id_coleccion_sec'])){
                                                                    $id_tabla="id_coleccion_sec";
                                                                    $tabla="colecciones_secundarios";
                                                                } else {
                                                                    $id_tabla="id_coleccion";
                                                                    $tabla="colecciones";
                                                                }
                                                                // print_r($cols);
                                                                // echo "<br><br><br>";
                                                                $id_elemento = 0;
                                                                $tabla = "";
                                                                $descripcion = "";
                                                                $stock = 0;
                                                                $disponibleOrNot = "";
                                                                $indexElement = 0;
                                                                $tipoCol=0;
                                                                foreach ($productos as $key){ if(!empty($key[0])){
                                                                    if($cols['tipo_inventario_col']=='Productos'){
                                                                        if($cols['id_producto']==$key['id_producto']){
                                                                            $tabla = $cols['tipo_inventario_col'];
                                                                            $id_elemento = $key['id_producto'];
                                                                            $stock = $key['stock_disponible'];
                                                                            if(!empty($cols['id_coleccion_sec'])){
                                                                                $tipoCol=2;
                                                                                $descripcion = $key['producto'];
                                                                                $despachoSec = $lider->consultarQuery("SELECT * FROM despachos_secundarios, colecciones_secundarios WHERE despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and colecciones_secundarios.id_coleccion_sec={$cols['id_coleccion_sec']}");
                                                                                if(!empty($despachoSec[0])){
                                                                                    // $descripcion.=" <small>(Colección: {$despachoSec[0]['nombre_coleccion_sec']})</small>";
                                                                                }
                                                                            }else{
                                                                                $tipoCol=1;
                                                                                $descripcion = $key['producto'];
                                                                                // $descripcion.=" <small>(Colección: Productos)</small>";
                                                                            }
                                                                            if($stock >= $cantProduct){
                                                                                $disponibleOrNot=true;
                                                                            }else{
                                                                                $disponibleOrNot=false;
                                                                            }
                                                                            if(empty($stocksInventario[$cols['tipo_inventario_col'].$key['id_producto']])){
                                                                                $stocksInventario[$cols['tipo_inventario_col'].$key['id_producto']]=$key['stock_disponible'];
                                                                            }
                                                                            $productos[$indexElement]['stock_disponible'] -= $cantProduct;
                                                                            // // $limiteDisponibles['cantidad'.$key['id_producto']]=$productos[$indexElement]['stock_disponible'];
                                                                            // if(!empty($limiteDisponibles['cantidad'.$key['id_producto']])){
                                                                            //     $limiteDisponibles['cantidad'.$key['id_producto']]+=$cantProduct;
                                                                            //     $limiteDisponibles['total'.$key['id_producto']]+=$total;
                                                                            // }else{
                                                                            //     $limiteDisponibles['cantidad'.$key['id_producto']]=$cantProduct;
                                                                            //     $limiteDisponibles['total'.$key['id_producto']]=$total;
                                                                            // }
                                                                            // $limiteDisponibles['descripcion'.$key['id_producto']]=$descripcion;
                                                                        }
                                                                    }
                                                                    $indexElement++;
                                                                }}
                                                                $indexElement = 0;
                                                                foreach ($mercancia as $key){ if(!empty($key[0])){
                                                                    if($cols['tipo_inventario_col']=='Mercancia'){
                                                                        if($cols['id_producto']==$key['id_mercancia']){
                                                                            $tabla = $cols['tipo_inventario_col'];
                                                                            $id_elemento = $key['id_mercancia'];
                                                                            $stock = $key['stock_disponible'];
                                                                            if(!empty($cols['id_coleccion_sec'])){
                                                                                $tipoCol=2;
                                                                                $descripcion = $key['mercancia'];
                                                                                $despachoSec = $lider->consultarQuery("SELECT * FROM despachos_secundarios, colecciones_secundarios WHERE despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and colecciones_secundarios.id_coleccion_sec={$cols['id_coleccion_sec']}");
                                                                                if(!empty($despachoSec[0])){
                                                                                    // $descripcion.=" <small>(Colección: {$despachoSec[0]['nombre_coleccion_sec']})</small>";
                                                                                }
                                                                            }else{
                                                                                $tipoCol=1;
                                                                                $descripcion = $key['mercancia'];
                                                                                // $descripcion.=" <small>(Colección: Productos)</small>";
                                                                            }
                                                                            if($stock >= $cantProduct){
                                                                                $disponibleOrNot=true;
                                                                            }else{
                                                                                $disponibleOrNot=false;
                                                                            }
                                                                            if(empty($stocksInventario[$cols['tipo_inventario_col'].$key['id_mercancia']])){
                                                                                $stocksInventario[$cols['tipo_inventario_col'].$key['id_mercancia']]=$key['stock_disponible'];
                                                                            }
                                                                            $mercancia[$indexElement]['stock_disponible'] -= $cantProduct;
                                                                            // // $limiteDisponibles['cantidadm'.$key['id_mercancia']]=$mercancia[$indexElement]['stock_disponible'];
                                                                            // if(!empty($limiteDisponibles['cantidadm'.$key['id_mercancia']])){
                                                                            //     $limiteDisponibles['cantidadm'.$key['id_mercancia']]+=$cantProduct;
                                                                            //     $limiteDisponibles['totalm'.$key['id_mercancia']]+=$total;
                                                                            // }else{
                                                                            //     $limiteDisponibles['cantidadm'.$key['id_mercancia']]=$cantProduct;
                                                                            //     $limiteDisponibles['totalm'.$key['id_mercancia']]=$total;
                                                                            // }
                                                                            // $limiteDisponibles['descripcionm'.$key['id_mercancia']]=$descripcion;
                                                                        }
                                                                    }
                                                                    $indexElement++;
                                                                }}

                                                                
                                                                
                                                                // if($cols['tipo_inventario_col']==)
                                                                // echo $cols['tipo_inventario_col']." => ID: ".$cols['id_producto']."<br>";
                                                                // echo "(".$mostrarCantProduct.") ".$tabla.": ".$id_tabla." => ".$cols['id_producto']."<br>";
                                                                $precioUnitarioElemento = $precioUnidProduct*$cifraMultiplo;
                                                                $urlEditFact = $menuPersonalizado."&i=".mb_strtolower($tabla[0])."&e={$id_elemento}";
                                                                // echo $stocksInventario[$cols['tipo_inventario_col'].$id_elemento];
                                                                if(!empty($coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento])){
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['cantidad']+=$cantProduct;
                                                                    // $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['precio']+=$precioUnitarioElemento;
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['total']+=$total;
                                                                }else{
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['id_elemento']=$id_elemento;
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['tipo_inventario']=$cols['tipo_inventario_col'];
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['stock_disponible']=$stocksInventario[$cols['tipo_inventario_col'].$id_elemento];
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['cantidad']=$cantProduct;
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['descripcion']=$descripcion;
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['precio']=$precioUnitarioElemento;
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['total']=$total;
                                                                    if($cols['tipo_inventario_col']=='Productos'){
                                                                        $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['i']='p';
                                                                    }
                                                                    if($cols['tipo_inventario_col']=='Mercancia'){
                                                                        $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['i']='m';
                                                                    }
                                                                    $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['e']=$id_elemento;
                                                                    $stocksInventario[$cols['tipo_inventario_col'].$id_elemento]-=$cantProduct;
                                                                }

                                                                // echo " => ";
                                                                // echo $coleccionesMostrar[$cols['tipo_inventario_col'].$id_elemento.$precioUnitarioElemento]['cantidad'];
                                                                // echo " >= ";
                                                                // echo $stocksInventario[$cols['tipo_inventario_col'].$id_elemento];
                                                                // echo " <br> ";
                                                                ?>
                                                                <!-- <tr <?php if(!$disponibleOrNot){ echo "style='color:red;'"; } ?>>
                                                                    <td style="width:15%;" class='celcontent cantidades'><span class='content-table'>
                                                                        <span style='color:rgba(0,0,0,0);'>__</span>
                                                                        <?=$mostrarCantProduct; ?>
                                                                    </span></td>
                                                                    <td style="width:65%;" class='celcontent descripciones' colspan='3'><span class='content-table'>
                                                                        <?=$descripcion; ?>
                                                                        <?php if(!$disponibleOrNot){ ?>
                                                                            <?php 
                                                                                $urlEditFact = $menuPersonalizado."&i=".mb_strtolower($tabla[0])."&e={$id_elemento}"; 
                                                                            ?>
                                                                            <a href="?<?=$urlEditFact; ?>">
                                                                                <span title="<?=$descripcion; ?>" id="<?=$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>" class='editList'>
                                                                                    Editar 
                                                                                    <?php //$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>
                                                                                </span>
                                                                            </a>
                                                                        <?php } ?>
                                                                    </span></td>
                                                                    <td style="width:15%;" class='celcontentR precios'><span class='content-table'>
                                                                        <?=$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.'); ?>
                                                                    </span></td>
                                                                    <td style="width:15%;" class='celcontentR totales'><span class='content-table'>
                                                                        <?=$simbolo."".number_format($total,2,',','.'); ?>
                                                                    </span></td>
                                                                </tr>
                                                                <tr style=''>
                                                                    <td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
                                                                </tr> -->
                                                                <?php
                                                            }
                                                            $numeroReal++;
                                                        }
                                                        $numero++;
                                                    }
                                                }
                                                // $__SESSION['limiteDisponiblesInventario'] = $limiteDisponibles;
                                                
                                                // print_r($coleccionModificada);
                                                $coleccionModificada = $lider->consultarQuery("SELECT * FROM coleccion_modificada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_factura={$_GET['id']} and codigo_identificador=''");
                                                
                                                $faltaDisponible = 0;
                                                $sumaTotales = 0;
                                                $limiteDisponibles = [];
                                                $mostrarListaFacturacion = [];
                                                
                                                foreach ($coleccionesMostrar as $colec) { if(!empty($colec['cantidad'])){
                                                    // print_r($colec);
                                                    // echo "<br><br>";
                                                    
                                                    
                                                    $id_unico = $colec['cantidad']."*".$colec['tipo_inventario']."*".$colec['id_elemento']."*".$colec['precio']."*".$colec['total'];
                                                    $coleccionModif = $lider->consultarQuery("SELECT * FROM coleccion_modificada WHERE estatus=1 and id_campana={$id_campana} and id_despacho={$id_despacho} and id_factura={$_GET['id']} and codigo_identificador='{$id_unico}'");
                                                    
                                                    
                                                    
                                                    // $sumaTotales+=$colec['total'];
                                                    if(count($coleccionModif)>1){
                                                        foreach($coleccionModif as $colmodif){
                                                            if(!empty($colmodif['id_coleccion_modificada'])){
                                                                $id_inv = 0;
                                                                if($colmodif['tipo_inventario']=="Productos"){
                                                                    $inv = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 and id_producto = {$colmodif['id_inventario']}");
                                                                    if(!empty($inv[0])){
                                                                        $id_inv = $inv[0]['id_producto'];
                                                                        $name_inv = $inv[0]['producto'];
                                                                        // $colmodif['id_inventario']=$inv[0]['id_producto'];
                                                                        // $colmodif['tipo_inventario']="Productos";
                                                                    }
                                                                }
                                                                if($colmodif['tipo_inventario']=="Mercancia"){
                                                                    $inv = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 and id_mercancia = {$colmodif['id_inventario']}");
                                                                    if(!empty($inv[0])){
                                                                        $id_inv = $inv[0]['id_mercancia'];
                                                                        $name_inv = $inv[0]['mercancia'];
                                                                        // $colmodif['id_inventario']=$inv[0]['id_mercancia'];
                                                                        // $colmodif['tipo_inventario']="Mercancia";
                                                                    }
                                                                }


                                                                $existen = $lider->consultarQuery("SELECT * FROM operaciones WHERE tipo_inventario='{$colmodif['tipo_inventario']}' and id_inventario={$colmodif['id_inventario']} and id_almacen={$id_almacen} ORDER BY id_operacion DESC;");
                                                                $colmodif['stock_disponible']=0;
                                                                if(!empty($existen[0])){
                                                                    $colmodif['stock_disponible']=$existen[0]['stock_operacion_almacen'];
                                                                }


                                                                // if($colmodif['stock']>$colec['stock_disponible']){
                                                                if(!empty($facturadosDescontar[$colmodif['tipo_inventario'].$colmodif['id_inventario'].$colmodif['precio_venta']])){
                                                                    $comprobar = $facturadosDescontar[$colmodif['tipo_inventario'].$colmodif['id_inventario'].$colmodif['precio_venta']];
                                                                    $colmodif['stock']-=$comprobar['cantidad'];
                                                                }
                                                                if($colmodif['stock']>$colmodif['stock_disponible']){
                                                                    $disponibleOrNot=false;
                                                                }else{
                                                                    $disponibleOrNot=true;
                                                                }

                                                                if(!$disponibleOrNot){
                                                                    if($factura['estado_factura']==1){
                                                                        $faltaDisponible++;
                                                                    }
                                                                    // echo 'Opcion 1';
                                                                }
                                                                // $sumaTotales+=$colmodif['total_venta'];
                                                                if($colmodif['tipo_inventario']=="Mercancia"){
                                                                    if(!empty($limiteDisponibles['cantidadm'.$colmodif['id_inventario']])){
                                                                        $limiteDisponibles['cantidadm'.$colmodif['id_inventario']]+=$colmodif['stock'];
                                                                        $limiteDisponibles['totalm'.$colmodif['id_inventario']]+=$colmodif['total_venta'];
                                                                    }else{
                                                                        $limiteDisponibles['cantidadm'.$colmodif['id_inventario']]=$colmodif['stock'];
                                                                        $limiteDisponibles['totalm'.$colmodif['id_inventario']]=$colmodif['total_venta'];
                                                                    }
                                                                    $limiteDisponibles['descripcionm'.$colmodif['id_inventario']]=$colmodif['descripcion'];
                                                                }else{
                                                                    if(!empty($limiteDisponibles['cantidad'.$colmodif['id_inventario']])){
                                                                        $limiteDisponibles['cantidad'.$colmodif['id_inventario']]+=$colmodif['stock'];
                                                                        $limiteDisponibles['total'.$colmodif['id_inventario']]+=$colmodif['total_venta'];
                                                                    }else{
                                                                        $limiteDisponibles['cantidad'.$colmodif['id_inventario']]=$colmodif['stock'];
                                                                        $limiteDisponibles['total'.$colmodif['id_inventario']]=$colmodif['total_venta'];
                                                                    }
                                                                    $limiteDisponibles['descripcion'.$colmodif['id_inventario']]=$name_inv;
                                                                }
                                                                
                                                                
                                                                if($factura['estado_factura']==1){
                                                                    if($colmodif['stock']>0){
                                                                        $mostrarListaFacturacion[$reiterador]['cantidad']=$colmodif['stock'];
                                                                        $mostrarListaFacturacion[$reiterador]['descripcion']=$name_inv;
                                                                        $mostrarListaFacturacion[$reiterador]['precio']=$colmodif['precio_venta'];
                                                                        $mostrarListaFacturacion[$reiterador]['total']=$colmodif['total_venta'];
                                                                        $mostrarListaFacturacion[$reiterador]['id_inventario']=$colmodif['id_inventario'];
                                                                        $mostrarListaFacturacion[$reiterador]['tipo_inventario']=$colmodif['tipo_inventario'];
                                                                        $reiterador++;
                                                                    
                                                                        ?>
                                                                            <tr <?php if(!$disponibleOrNot){ echo "style='color:red;'"; } ?>>
                                                                                <td style="width:15%;" class='celcontent cantidades'><span class='content-table'>
                                                                                    <span style='color:rgba(0,0,0,0);'>__</span>
                                                                                    <?=$colmodif['stock']; ?>
                                                                                    <?php 
                                                                                    ?>
                                                                                </span></td>
                                                                                <td style="width:65%;" class='celcontent descripciones' colspan='3'><span class='content-table'>
                                                                                    <?=$name_inv; ?>
                                                                                    <?php 
                                                                                        $urlBorrarFact = $menu."&route={$_GET['route']}&action={$_GET['action']}&id={$_GET['id']}&t={$_GET['t']}&delete={$colmodif['id_coleccion_modificada']}"; 
                                                                                    ?>
                                                                                    <a href="?<?=$urlBorrarFact; ?>">
                                                                                        <span title="<?=$name_inv; ?>" class='BorrarList'>
                                                                                            Borrar
                                                                                            <?php //$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>
                                                                                        </span>
                                                                                    </a>
                                                                                </span></td>
                                                                                <td style="width:15%;" class='celcontentR precios'><span class='content-table'>
                                                                                    <?=$simbolo."".number_format($colmodif['precio_venta'],2,',','.'); ?>
                                                                                </span></td>
                                                                                <td style="width:15%;" class='celcontentR totales'><span class='content-table'>
                                                                                    <?=$simbolo."".number_format($colmodif['total_venta'],2,',','.'); ?>
                                                                                </span></td>
                                                                            </tr>
                                                                            <tr style=''>
                                                                                <td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
                                                                            </tr>
                                                                        <?php
                                                                        $sumaTotales+=$colmodif['total_venta'];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        // if($colmodif['stock']>$colec['stock_disponible']){
                                                        //     $disponibleOrNot=false;
                                                        // }else{
                                                        //     $disponibleOrNot=true;
                                                        // }
                                                        // echo $colec['id_elemento']." | ";
                                                        // echo $colec['tipo_inventario']." | ";
                                                        // echo $colec['stock_disponible']." | ";
                                                        // $colec['stock_disponible']+=24;
                                                        // echo $colec['stock_disponible']."<br>";
                                                        if(!empty($facturadosDescontar[$colec['tipo_inventario'].$colec['id_elemento'].$colec['precio']])){
                                                            $comprobar = $facturadosDescontar[$colec['tipo_inventario'].$colec['id_elemento'].$colec['precio']];
                                                            $colec['cantidad']-=$comprobar['cantidad'];
                                                        }

                                                        $disponibleOrNot = false;
                                                        if($colec['cantidad']>$colec['stock_disponible']){
                                                            $disponibleOrNot=false;
                                                        }else{
                                                            $disponibleOrNot=true;
                                                        }
                                                        

                                                        
                                                        
                                                        if(!$disponibleOrNot){
                                                            if($factura['estado_factura']==1){
                                                                $faltaDisponible++;
                                                            }
                                                            // echo 'Opcion 2';
                                                        }
                                                        if($colec['tipo_inventario']=="Mercancia"){
                                                            if(!empty($limiteDisponibles['cantidadm'.$colec['id_elemento']])){
                                                                $limiteDisponibles['cantidadm'.$colec['id_elemento']]+=$colec['cantidad'];
                                                                $limiteDisponibles['totalm'.$colec['id_elemento']]+=$colec['total'];
                                                            }else{
                                                                $limiteDisponibles['cantidadm'.$colec['id_elemento']]=$colec['cantidad'];
                                                                $limiteDisponibles['totalm'.$colec['id_elemento']]=$colec['total'];
                                                            }
                                                            $limiteDisponibles['descripcionm'.$colec['id_elemento']]=$colec['descripcion'];
                                                        }else{
                                                            if(!empty($limiteDisponibles['cantidad'.$colec['id_elemento']])){
                                                                $limiteDisponibles['cantidad'.$colec['id_elemento']]+=$colec['cantidad'];
                                                                $limiteDisponibles['total'.$colec['id_elemento']]+=$colec['total'];
                                                            }else{
                                                                $limiteDisponibles['cantidad'.$colec['id_elemento']]=$colec['cantidad'];
                                                                $limiteDisponibles['total'.$colec['id_elemento']]=$colec['total'];
                                                            }
                                                            $limiteDisponibles['descripcion'.$colec['id_elemento']]=$colec['descripcion'];
                                                        }
                                                        
                                                        if($factura['estado_factura']==1){
                                                            if($colec['cantidad']>0){
                                                                $mostrarListaFacturacion[$reiterador]['cantidad']=$colec['cantidad'];
                                                                $mostrarListaFacturacion[$reiterador]['descripcion']=$colec['descripcion'];
                                                                $mostrarListaFacturacion[$reiterador]['precio']=$colec['precio'];
                                                                $mostrarListaFacturacion[$reiterador]['total']=$colec['total'];
                                                                $mostrarListaFacturacion[$reiterador]['id_inventario']=$colec['id_elemento'];
                                                                $mostrarListaFacturacion[$reiterador]['tipo_inventario']=$colec['tipo_inventario'];
                                                                $reiterador++;
                                                                ?>
                                                                    <tr <?php if(!$disponibleOrNot){ echo "style='color:red;'"; } ?>>
                                                                        <td style="width:15%;" class='celcontent cantidades'><span class='content-table'>
                                                                            <span style='color:rgba(0,0,0,0);'>__</span>
                                                                            <?=$colec['cantidad']; ?>
                                                                            <?php
                                                                            ?>
                                                                            </span>
                                                                        </td>
                                                                        <td style="width:65%;" class='celcontent descripciones' colspan='3'><span class='content-table'>
                                                                            <?=$colec['descripcion']; ?>
                                                                            <?php if(!$disponibleOrNot){ ?>
                                                                                <?php 
                                                                                    $urlEditFact = $menuPersonalizado."&i=".$colec['tipo_inventario']."&e={$colec['e']}&pc={$colec['cantidad']}&pr={$colec['precio']}&pt={$colec['total']}"; 
                                                                                ?>
                                                                                <a href="?<?=$urlEditFact; ?>">
                                                                                    <span title="<?=$descripcion; ?>" class='editList'>
                                                                                        Editar 
                                                                                        <?php //$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>
                                                                                    </span>
                                                                                </a>
                                                                            <?php } ?>
                                                                        </span></td>
                                                                        <td style="width:15%;" class='celcontentR precios'><span class='content-table'>
                                                                            <?=$simbolo."".number_format($colec['precio'],2,',','.'); ?>
                                                                        </span></td>
                                                                        <td style="width:15%;" class='celcontentR totales'><span class='content-table'>
                                                                            <?=$simbolo."".number_format($colec['total'],2,',','.'); ?>
                                                                        </span></td>
                                                                    </tr>
                                                                    <tr style=''>
                                                                        <td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
                                                                    </tr>
                                                                <?php
                                                                $sumaTotales+=$colec['total'];
                                                            }
                                                        }
                                                    }
                                                } }
                                                foreach ($coleccionModificada as $colmodif) { if(!empty($colmodif[0])){
                                                    if($colmodif['codigo_identificador']==""){
                                                        $id_inv = 0;
                                                        if($colmodif['tipo_inventario']=="Productos"){
                                                            $inv = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 and id_producto = {$colmodif['id_inventario']} ");
                                                            if(!empty($inv[0])){
                                                                $id_inv = $inv[0]['id_producto'];
                                                                $name_inv = $inv[0]['producto'];
                                                            }
                                                        }
                                                        if($colmodif['tipo_inventario']=="Mercancia"){
                                                            $inv = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 and id_mercancia = {$colmodif['id_inventario']} ");
                                                            if(!empty($inv[0])){
                                                                $id_inv = $inv[0]['id_mercancia'];
                                                                $name_inv = $inv[0]['mercancia'];
                                                            }
                                                        }
                                                        
                                                        if(!empty($facturadosDescontar[$colmodif['tipo_inventario'].$colmodif['id_inventario'].$colmodif['precio_venta']])){
                                                            $comprobar = $facturadosDescontar[$colmodif['tipo_inventario'].$colmodif['id_inventario'].$colmodif['precio_venta']];
                                                            $colmodif['stock']-=$comprobar['cantidad'];
                                                        }
                                                        if($colmodif['stock']>$colec['stock_disponible']){
                                                            $disponibleOrNot=false;
                                                        }else{
                                                            $disponibleOrNot=true;
                                                        }

                                                        if(!$disponibleOrNot){
                                                            if($factura['estado_factura']==1){
                                                                $faltaDisponible++;
                                                            }
                                                            // echo 'Opcion 3';
                                                        }
                                                        // $sumaTotales+=$colmodif['total_venta'];
                                                        if($colmodif['tipo_inventario']=="Mercancia"){
                                                            if(!empty($limiteDisponibles['cantidadm'.$colmodif['id_inventario']])){
                                                                $limiteDisponibles['cantidadm'.$colmodif['id_inventario']]+=$colmodif['stock'];
                                                                $limiteDisponibles['totalm'.$colmodif['id_inventario']]+=$colmodif['total_venta'];
                                                            }else{
                                                                $limiteDisponibles['cantidadm'.$colmodif['id_inventario']]=$colmodif['stock'];
                                                                $limiteDisponibles['totalm'.$colmodif['id_inventario']]=$colmodif['total_venta'];
                                                            }
                                                            $limiteDisponibles['descripcionm'.$colmodif['id_inventario']]=$colmodif['descripcion'];
                                                        }else{
                                                            if(!empty($limiteDisponibles['cantidad'.$colmodif['id_inventario']])){
                                                                $limiteDisponibles['cantidad'.$colmodif['id_inventario']]+=$colmodif['stock'];
                                                                $limiteDisponibles['total'.$colmodif['id_inventario']]+=$colmodif['total_venta'];
                                                            }else{
                                                                $limiteDisponibles['cantidad'.$colmodif['id_inventario']]=$colmodif['stock'];
                                                                $limiteDisponibles['total'.$colmodif['id_inventario']]=$colmodif['total_venta'];
                                                            }
                                                            $limiteDisponibles['descripcion'.$colmodif['id_inventario']]=$name_inv;
                                                        }
                                                        
                                                        
                                                        if($factura['estado_factura']==1){
                                                            if($colmodif['stock']>0){
                                                                $mostrarListaFacturacion[$reiterador]['cantidad']=$colmodif['stock'];
                                                                $mostrarListaFacturacion[$reiterador]['descripcion']=$name_inv;
                                                                $mostrarListaFacturacion[$reiterador]['precio']=$colmodif['precio_venta'];
                                                                $mostrarListaFacturacion[$reiterador]['total']=$colmodif['total_venta'];
                                                                $mostrarListaFacturacion[$reiterador]['id_inventario']=$colmodif['id_inventario'];
                                                                $mostrarListaFacturacion[$reiterador]['tipo_inventario']=$colmodif['tipo_inventario'];
                                                                $reiterador++;
                                                                ?>
                                                                    <tr <?php if(!$disponibleOrNot){ echo "style='color:red;'"; } ?>>
                                                                        <td style="width:15%;" class='celcontent cantidades'><span class='content-table'>
                                                                            <span style='color:rgba(0,0,0,0);'>__</span>
                                                                            <?=$colmodif['stock']; ?>
                                                                            <?php 
                                                                            ?>
                                                                        </span></td>
                                                                        <td style="width:65%;" class='celcontent descripciones' colspan='3'><span class='content-table'>
                                                                            <?=$name_inv; ?>
                                                                            <?php 
                                                                                $urlBorrarFact = $menu."&route={$_GET['route']}&action={$_GET['action']}&id={$_GET['id']}&t={$_GET['t']}&delete={$colmodif['id_coleccion_modificada']}"; 
                                                                            ?>
                                                                            <a href="?<?=$urlBorrarFact; ?>">
                                                                                <span title="<?=$name_inv; ?>" class='BorrarList'>
                                                                                    Borrar
                                                                                    <?php //$cols['id_coleccion']."*".$tipoCol."*".$cols['tipo_inventario_col']."*".$id_elemento; ?>
                                                                                </span>
                                                                            </a>
                                                                        </span></td>
                                                                        <td style="width:15%;" class='celcontentR precios'><span class='content-table'>
                                                                            <?=$simbolo."".number_format($colmodif['precio_venta'],2,',','.'); ?>
                                                                        </span></td>
                                                                        <td style="width:15%;" class='celcontentR totales'><span class='content-table'>
                                                                            <?=$simbolo."".number_format($colmodif['total_venta'],2,',','.'); ?>
                                                                        </span></td>
                                                                    </tr>
                                                                    <tr style=''>
                                                                        <td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
                                                                    </tr>
                                                                <?php
                                                                $sumaTotales+=$colmodif['total_venta'];
                                                            }
                                                        }
                                                    }
                                                } }
                                                $mostrarFacturaFinal = [];
                                                foreach($mostrarListaFacturacion as $key){
                                                    if(!empty($mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']])){
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['cantidad']+=$key['cantidad'];
                                                    }else{
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['cantidad']=$key['cantidad'];
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['descripcion']=$key['descripcion'];
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['precio']=$key['precio'];
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['total']=$key['total'];
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['id_inventario']=$key['id_inventario'];
                                                        $mostrarFacturaFinal[$key['tipo_inventario'].$key['id_inventario'].$key['precio']]['tipo_inventario']=$key['tipo_inventario'];
                                                    }
                                                }

                                                for ($i=0; $i < count($listaColecciones); $i++) { 
                                                    foreach ($coleccionesFacturadas as $colFact) {
                                                        if(!empty($colFact['id_despacho_facturado'])){
                                                            if(mb_strtolower($colFact['nombre_coleccion'])==mb_strtolower($listaColecciones[$i]['name'])){
                                                                $listaColecciones[$i]['cant']-=$colFact['cantidad_coleccion'];
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if($factura['estado_factura']==0){

                                                $mostrarFacturaFinal=[];
                                                $facturados = $lider->consultarQuery("SELECT * FROM operaciones, factura_despacho WHERE operaciones.id_factura=factura_despacho.id_factura_despacho and factura_despacho.id_pedido={$id_pedido} and operaciones.modulo_factura='{$moduloFacturacion}' and operaciones.id_factura={$id_factura} ORDER BY operaciones.id_operacion ASC;");
                                                foreach ($facturados as $facts) {
                                                    if(!empty($facts['id_factura'])){
                                                        if($facts['tipo_inventario']=="Productos"){
                                                            $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$facts['id_inventario']}");
                                                        }
                                                        if($facts['tipo_inventario']=="Mercancia"){
                                                            $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$facts['id_inventario']}");
                                                        }
                                                        if($facts['tipo_inventario']=="Catalogos"){
                                                            $inventario = $lider->consultarQuery("SELECT *, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$facts['id_inventario']}");
                                                        }
                                                        $codUnic=$facts['tipo_inventario'].$facts['id_inventario'];
                                                        // $codUnic=$facts['stock_operacion'].$facts['tipo_inventario'].$facts['id_inventario'];
                                                        foreach ($inventario as $inv) {
                                                            if(!empty($inv['elemento'])){
                                                                if(!empty($mostrarFacturaFinal[$codUnic])){
                                                                    if($facts['tipo_operacion']=="Entrada"){
                                                                        $mostrarFacturaFinal[$codUnic]['cantidad']-=$facts['stock_operacion'];
                                                                    }
                                                                    if($facts['tipo_operacion']=="Salida"){
                                                                        $mostrarFacturaFinal[$codUnic]['cantidad']+=$facts['stock_operacion'];
                                                                    }
                                                                }else{
                                                                    $mostrarFacturaFinal[$codUnic]['cantidad']=0;
                                                                    if($facts['tipo_operacion']=="Entrada"){
                                                                        $mostrarFacturaFinal[$codUnic]['cantidad']-=$facts['stock_operacion'];
                                                                    }
                                                                    if($facts['tipo_operacion']=="Salida"){
                                                                        $mostrarFacturaFinal[$codUnic]['cantidad']+=$facts['stock_operacion'];
                                                                    }
                                                                    $mostrarFacturaFinal[$codUnic]['descripcion']=$inv['elemento'];
                                                                    $mostrarFacturaFinal[$codUnic]['precio']=$facts['concepto_factura'];
                                                                    $mostrarFacturaFinal[$codUnic]['id_inventario']=$facts['id_inventario'];
                                                                    $mostrarFacturaFinal[$codUnic]['tipo_inventario']=$facts['tipo_inventario'];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                // print_r($facturadosDescontar);
                                                // foreach
                                                
                                                // $mostrarFacturaFinal = $__SESSION['mostrarFacturaFinal'];
                                                foreach ($mostrarFacturaFinal as $colec) {
                                                    if(!empty($colec['cantidad'])){
                                                        $mostrarListaFacturacion[$reiterador]['cantidad']=$colec['cantidad'];
                                                        $mostrarListaFacturacion[$reiterador]['descripcion']=$colec['descripcion'];
                                                        $mostrarListaFacturacion[$reiterador]['precio']=$colec['precio'];
                                                        $mostrarListaFacturacion[$reiterador]['id_inventario']=$colec['id_inventario'];
                                                        $mostrarListaFacturacion[$reiterador]['tipo_inventario']=$colec['tipo_inventario'];
                                                        $colec['total']=$colec['precio']*$colec['cantidad'];
                                                        $mostrarListaFacturacion[$reiterador]['total']=$colec['total'];
                                                        // $reiterador++;
                                                        ?>
                                                            <tr>
                                                                <td style="width:15%;" class='celcontent cantidades'><span class='content-table'>
                                                                    <span style='color:rgba(0,0,0,0);'>__</span>
                                                                    <?=$colec['cantidad']; ?>
                                                                </span></td>
                                                                <td style="width:65%;" class='celcontent descripciones' colspan='3'><span class='content-table'>
                                                                    <?=$colec['descripcion']; ?>
                                                                </span></td>
                                                                <td style="width:15%;" class='celcontentR precios'><span class='content-table'>
                                                                    <?=$simbolo."".number_format($colec['precio'],2,',','.'); ?>
                                                                </span></td>
                                                                <td style="width:15%;" class='celcontentR totales'><span class='content-table'>
                                                                    <?=$simbolo."".number_format($colec['total'],2,',','.'); ?>
                                                                </span></td>
                                                            </tr>
                                                            <tr style=''>
                                                                <td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
                                                            </tr>
                                                        <?php
                                                        $sumaTotales+=$colec['total'];

                                                    }
                                                }

                                                
                                                $listaColecciones=[];
                                                $coleccionesFacturadas = $lider->consultarQuery("SELECT * FROM despachos_facturados WHERE id_factura={$id_factura} and modulo_facturado='{$moduloFacturacion}'");
                                                $indexCol=0;
                                                foreach ($coleccionesFacturadas as $keys) {
                                                    if(!empty($keys['id_despacho_facturado'])){
                                                        $listaColecciones[$indexCol]=[
                                                            'cant'=>$keys['cantidad_coleccion'],
                                                            'descripcion'=>"Cols. ".$keys['nombre_coleccion'],
                                                            'name'=>$keys['nombre_coleccion'],
                                                        ];
                                                        $indexCol++;
                                                    }
                                                }

                                            }
                                            
                                            // $__SESSION['limiteDisponiblesInventario'] = $limiteDisponibles;
                                            // $__SESSION['mostrarListaFacturacion'] = $mostrarListaFacturacion;
                                            $_SESSION['mostrarFacturaFinal'.$_GET['id']] = $mostrarFacturaFinal;
                                            $_SESSION['listaColecciones'.$_GET['id']] = $listaColecciones;
                                            $ivattt = ($sumaTotales/100)*$valorIva;
                                            $igtf = ($sumaTotales/100)*$valorIgtf;
                                            $igtf = 0;
                                            // $precioFinal = $sumaTotales+$ivattt;
                                            $precioFinal = $sumaTotales+$ivattt+$igtf;

                                            // echo "FALTA: ".$faltaDisponible."<br>";
                                            
                                            // foreach($mostrarFacturaFinal as $key){
                                            //     print_r($key);
                                            //     echo "<br><br>";
                                            // }
                                            // foreach($facturadosDescontar as $key){
                                            //     print_r($key);
                                            //     echo "<br><br>";
                                            // }
                                        ?>
                                    </table>
                                    
                                    <br>
                                    <?php if($factura['estado_factura']==1){ ?>
                                    <a href="?<?=$menuPersonalizado."&nuevo=1";?>"><span class="btn enviar2">Agregar</span></a>
                                    <br><br>
                                    <?php } ?>


                                    <?php
                                        $cantidadDiferentesCols = count($listaColecciones);
                                        $limiteColsLista=6;
                                        if($cantidadDiferentesCols>$limiteColsLista){
                                            $listaColecciones=[];
                                            $listaColecciones[count($listaColecciones)]=['cant'=>$mostrarCantAprobadaTotal, 'descripcion'=>"Cols. Variadas"];
                                        }
                                        $cantidadDiferentesCols = count($listaColecciones);
                                        $complementarListaCols = "";
                                        for ($i=0; $i < ($limiteColsLista-$cantidadDiferentesCols); $i++) { 
                                            $complementarListaCols.="<br>";
                                        }
                                    ?>
                                    <div class='box-content-final-L' style="width:35%;float:left">
                                        <div class='box-content-final-CFL' style='border-bottom:1px solid #434343;'></div>
                                        <table style='width:100%;'>
                                            <tr>
                                                <td class='celtitleL' style='width:40%;'>
                                                    Observaciones: <br>
                                                    <span style='color:white;'>-</span>
                                                    <b>Campaña <?=$numero_campana."-".$anio_campana; ?></b>
                                                </td>
                                                <td class='celcontentR' style='width:60%;'><span class='content-table'>
                                                    <small>
                                                        <br>
                                                    <?php
                                                    $numer=1;
                                                    foreach($listaColecciones as $list){
                                                        if($list['cant']>0){
                                                            echo $list['cant']." ".$list['descripcion'];
                                                            if($numer<count($listaColecciones)){
                                                                echo ", ";
                                                            }
                                                            $numer++;
                                                        }
                                                    }
                                                    ?>
                                                    <br>
                                                    </small>
                                                    <!-- <?=$mostrarCantAprobadaTotal; ?> Colecciones Variadas<br><br> -->
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class='box-content-final-FL' style='border-bottom:1px solid #434343;'></div>
                                    </div>
                                    
                                    <div class='box-content-final-R'  style="width:35%;float:right;text-align:right;">
                                        <div class='box-content-final-CFR' style='border-bottom:1px solid #434343;'></div>
                                        <table style='width:100%;'>
                                            <tr>
                                                <td class='celtitleL'>Total Neto: </td>
                                                <td class='celcontentR' style="text-align:right;">
                                                    <span class='content-table'>
                                                        <?=$simbolo."".number_format($sumaTotales,2,',','.'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='celtitleL'>I.V.A. (<?=$valorIva; ?>%): </td>
                                                <td class='celcontentR' style="text-align:right;">
                                                    <span class='content-table'>
                                                        <?=$simbolo."".number_format($ivattt,2,',','.'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='celtitleL'>I.G.T.F. (<?=$valorIgtf; ?>%): </td>
                                                <td class='celcontentR' style="text-align:right;">
                                                    <span class='content-table'>
                                                        <?=$simbolo."".number_format($igtf,2,',','.'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='celtitleL'><b>Total Operacion: </b></td>
                                                <td class='celcontentR' style="text-align:right;"><b><span class='content-table'><?=$simbolo."".number_format($precioFinal,2,',','.'); ?></span></b></td>
                                            </tr>
                                        </table>
                                        <div class='box-content-final-FR' style='border-bottom:1px solid #434343;'></div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php 
                                        if($factura['estado_factura']==1){ 
                                            if($faltaDisponible==0){
                                            ?>
                                                <br>
                                                <?php $urlCerrarFact = $menuPersonalizado."&cerrar=1"; ?>
                                                <a href="?<?=$urlCerrarFact; ?>"><span class='btn enviar2'>Cerrar Factura</span></a>
                                            <?php 
                                            }
                                        }
                                    ?>

                                    <?php if($factura['estado_factura']==0){ ?>
                                        <br>
                                        <?php $urlAbrirFact = $menuPersonalizado."&abrir=1"; ?>
                                        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Contable"){ ?>
                                            <a href="?<?=$urlAbrirFact; ?>"><span class='btn enviar2'>Abrir Factura</span></a>
                                            <!-- <a href="?<?=$urlAbrirFact; ?>"><span class='btn enviar2'>Abrir Factura</span></a> -->
                                        <?php } ?>
                                    <?php } ?>

                                    <br><br>
                                    <?php if($factura['estado_factura']==0){ ?>
                                        <form action="" method="get" class="form table-responsive" target="_blank">
                                            <div class="box-body">
                                                <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                                                <input type="hidden" value="<?=$numero_campana;?>" name="n">
                                                <input type="hidden" value="<?=$anio_campana;?>" name="y">
                                                <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                                                <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                                                <input type="hidden" value="<?=$_GET['route']; ?>" name="route">
                                                <input type="hidden" value="GenerarFiscal" name="action">
                                                <input type="hidden" value="<?=$_GET['id']?>" name="id">
                                                <input type="hidden" value="<?=$_GET['t']?>" name="t">
                                            </div>
                                            <div class="box-footer">
                                            <button type="submit" class="btn enviar2">Generar PDF</button>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--/.col (left) -->
                <?php if( (!empty($_GET['t']) && !empty($_GET['i']) && !empty($_GET['e'])) || (!empty($_GET['nuevo']))){ ?>
                    <?php
                        $limiteDisponibles = $_SESSION['limiteDisponiblesInventario'];
                    ?>
                    <div class="col-sm-12"  style="z-index:1050;display:flex;justify-content: center;align-items: center;position:fixed;top:0;left:0;width:100%;height:100vh;background:rgba(0,0,0,0.5);">
                        <div class="box" style="width:80%;">
                            <div class="box-body" style="width:100%;">
                                <a href="?<?=$menu."&route={$_GET['route']}&action={$_GET['action']}&id={$_GET['id']}&t={$_GET['t']}";?>"><span class="btn cerrar_edit_fact" style='background:#ccc;float:right;'>X</span></a>
                                <form action='' method="post" class="form-uptade-factura">
                                    <?php 
                                        if((!empty($_GET['t']) && !empty($_GET['i']) && !empty($_GET['e']))){
                                            $id_unico_identificador = $_GET['pc']."*".$_GET['i']."*".$_GET['e']."*".$_GET['pr']."*".$_GET['pt'];
                                        }else{
                                            $id_unico_identificador = "";
                                        }
                                    ?>
                                    <input type="hidden" name="codigo_identificador" value="<?=$id_unico_identificador; ?>">
                                    <input type="hidden" id="limiteElementos" name="limiteElementos" value="<?=$limiteElementos; ?>">
                                    <h3 id="title_box_edit">
                                        <?php 
                                            if((!empty($_GET['t']) && !empty($_GET['i']) && !empty($_GET['e']))){
                                                if(!empty($_GET['i'])){
                                                    $titleid = 'descripcion';
                                                    if($_GET['i']=='m'){
                                                        $titleid .= 'm';
                                                    }
                                                    $titleid .= $_GET['e'];
                                                    echo "Modificar elemento de colección ".$limiteDisponibles[$titleid];
                                                }
                                            }else{
                                                echo "Agregar nuevo elemento a la colección";
                                            }
                                        ?>
                                        
                                        <?php
                                        ?>
                                    </h3>
                                    <div class="row" style="padding:0px 17px;">
                                        <div style="width:20%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                            <label>Cantidad</label>
                                        </div>
                                        <div style="width:60%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                            <label>Descripcion</label>
                                        </div>
                                        <div style="width:20%;float:left" class=" box-inventarios<?=$z; ?> box-inventario">
                                            <label>Precio de Venta</label>
                                        </div>
                                    </div>
                                    <?php
                                        $aux = $_GET;
                                        $_GET = [];
                                        $_GET[1] = $aux;
                                    ?>
                                    <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                                    <div class="row" style="padding:0px 15px;">
                                        <div style="width:20%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
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
                                        <div style="width:60%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                            <?php //$cantidadLimiteStock = 0; ?>
                                            <select class="form-control select2 inventarios" id="inventario<?=$z; ?>" min="<?=$z;?>" name="inventario[]"  style="width:100%;z-index:100000;">
                                                <option value=""></option>
                                                <?php
                                                    foreach($productoss as $inv){ if(!empty($inv['id_producto'])){ 
                                                        $cantidadLimiteStock=$inv['stock_operacion_almacen']-$limiteDisponibles['cantidad'.$inv['id_producto']];
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
                                        <div style="width:20%;float:right;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                                            <input type="number" class="form-control" id="total<?=$z; ?>" name="total[]" step="0.01" placeholder="Precio ($.150)" value="<?php 
                                            if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Productos'){ 
                                                if(!empty($_GET[$z]['e'])){ 
                                                    // echo $limiteDisponibles['total'.$_GET[$z]['e']];
                                                } 
                                            }else if(!empty($_GET[$z]['i']) && $_GET[$z]['i']=='Mercancia'){ 
                                                if(!empty($_GET[$z]['e'])){ 
                                                    // echo $limiteDisponibles['totalm'.$_GET[$z]['e']];
                                                } 
                                            } 
                                            if(!empty($_GET[$z]['pt'])){
                                                echo $_GET[$z]['pt'];
                                            }
                                            ?>">
                                            <span id="error_total<?=$z; ?>" class="errors"></span>
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
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<input type="hidden" class="menupersonalizado" value="<?php echo $menuPersonalizado; ?>">

<?php endif; ?>
<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.d-flex{
  display:flex;
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
.editList:hover{
    cursor: pointer;
}
.editList{
    float:right;margin-right:20px;color:#04a7c9;
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
        // var campaing = $(".campaing").val();
        // var n = $(".n").val();
        // var y = $(".y").val();
        // var dpid = $(".dpid").val();
        // var dp = $(".dp").val();
        // var route = $(".route").val();
        // var action = $(".action").val();
        // var id = $(".id").val();
        // var t = $(".t").val();
        // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route="+route+"&action="+action+"&id="+id+"&t="+t;
        // window.location.href=menu;
        var menupersonalizado = "?"+$(".menupersonalizado").val();
        window.location.href=menupersonalizado;
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
    var cod = $(this).attr("name");
    var val = $(this).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
    }
  });


  $(".box-modal-editFact").removeClass('d-none');
  $(".box-modal-editFact").hide();
  $(".box-modal-editFact").addClass('d-flex');
  $(".select2-results__options").addClass('z-index');

//   $(".editList").click(function(){
//     $(".btn-reset").click();
//     $(".select2-selection__rendered").html("");
//     var id = $(this).attr("id");
//     var txtDescrip = $(this).attr("title");
//     // console.log(txtDescrip);
//     $("#title_box_edit").html("Modificar elemento de coleccion: "+txtDescrip);
//     $("#info_editar_elemento_coleccion").val(id);
//     $(".box-modal-editFact").fadeIn();
//     $(".select2-results__options").addclass('z-index');
//   });
//   $(".cerrar_edit_fact").click(function(){
//     $(".box-modal-editFact").fadeOut();
//     $(".btn-reset").click();
//     $(".select2-selection__rendered").html("");
//     $(".box-inventario").hide();
//     $(".box-inventarios1").show();
//     $(".box-inventario").hide();
//     $(".box-inventarios1").show();
//   });

  
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
    var rtotales = false;
    if(cantidad_elementos==0){
        var rstocks = false;
        var rinventarios = false;
        var rtotales = false;
    }else{
        var erroresStock=0;
        var erroresInventario=0;
        var erroresTotales=0;
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
            var total = $("#total"+i).val();
            var rtotal = checkInput(total, numberPattern2);
            if( rtotal == false ){
            if(total.length != 0){
                $("#error_total"+i).html("El monto total debe ser un valor numerico");
            }else{
                $("#error_total"+i).html("Debe colocar el monto unitario");      
            }
            }else{
            $("#error_total"+i).html("");
            }
            if(rtotal==false){ erroresTotales++; }
            /*===================================================================*/
        }
        if(erroresStock==0){ rstocks=true; }
        if(erroresInventario==0){ rinventarios=true; }
        if(erroresTotales==0){ rtotales=true; }
    }
    var response = false;
    if(rstocks==true && rinventarios==true && rtotales==true){
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
