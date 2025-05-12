<?php 
$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
    if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Reportes"){
        $amReportes = 1;
        if($access['nombre_permiso'] == "Ver"){
        $amReportesC = 1;
        }
    }
    }
}

// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }
if($amReportesC == 1){
    $clientesss = [];
    if(!empty($_GET['P'])){
        $id_despacho = $_GET['P'];
        $campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana");
        $campana = $campanas[0];
        $id_campana = $campana['id_campana'];
        
        $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
        

        $sqlPedidosSelect="SELECT notasentrega.id_campana, pedidos.id_despacho, pedidos.id_cliente, pedidos.id_pedido, notasentrega.id_nota_entrega FROM pedidos, notasentrega WHERE pedidos.id_pedido=notasentrega.id_pedido and notasentrega.id_campana={$id_campana} and pedidos.id_despacho={$id_despacho}";
        $pedidosSeleccionados = $lider->consultarQuery($sqlPedidosSelect);
        $strPedidos = "";
        $strNotas = "";
        $numeros = 1;
        $numeross = 1;
        foreach ($pedidosSeleccionados as $idPedidos) {
            if(!empty($idPedidos['id_pedido'])){
                $idPedido=$idPedidos['id_pedido'];
                $strPedidos.="".$idPedido;
                if(($numeros) < (count($pedidosSeleccionados)-1)){
                  $strPedidos.=", ";
                }
                $numeros++;

                $idNotas=$idPedidos['id_nota_entrega'];
                $strNotas.="".$idNotas;
                if(($numeross) < (count($pedidosSeleccionados)-1)){
                  $strNotas.=", ";
                }
                $numeross++;
            }
        }
        $nameModuloFactura="Notas";
        $operaciones = $lider->consultarQuery("SELECT id_operacion, tipo_operacion, transaccion, leyenda, id_inventario, tipo_inventario, id_almacen, stock_operacion, modulo_factura, id_factura, concepto_factura FROM operaciones WHERE modulo_factura='{$nameModuloFactura}' and id_factura IN ({$strNotas})");
        $facturado = [];
        foreach ($operaciones as $key) {
            if(!empty($key['id_operacion'])){
                $code = $key['id_inventario'].$key['tipo_inventario'];
                foreach ($lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega={$key['id_factura']}") as $notaentrega) {
                    if(!empty($notaentrega['numero_nota_entrega'])){
                        $key['id_factura']=$notaentrega['numero_nota_entrega'];
                    }
                }
                if(!empty($facturado[$code])){
                    if($key['tipo_operacion']=="Salida"){
                        $facturado[$code]['cantidad']+=$key['stock_operacion'];
                    }
                    if($key['tipo_operacion']=="Entrada"){
                        $facturado[$code]['cantidad']-=$key['stock_operacion'];
                    }
                    $verifFactura=0;
                    foreach ($facturado[$code]['facturas'] as $factss) {
                        if($factss==$key['id_factura']){
                            $verifFactura++;
                        }
                    }
                    if($verifFactura==0){
                        $facturado[$code]['id_factura'].=", ".$key['id_factura'];
                        $facturado[$code]['facturas'][count($facturado[$code]['facturas'])]=$key['id_factura'];
                    }
                    $facturado[$code]['conceptos'][count($facturado[$code]['conceptos'])]=$key['concepto_factura'];
                }else{
                    $facturado[$code]['cantidad']=0;
                    $facturado[$code]['facturas']=[];
                    $facturado[$code]['conceptos']=[];
                    $facturado[$code]['id_factura']=$key['id_factura'];
                    $facturado[$code]['facturas'][count($facturado[$code]['facturas'])]=$key['id_factura'];
                    $facturado[$code]['tipo_inventario']=$key['tipo_inventario'];
                    $facturado[$code]['id_inventario']=$key['id_inventario'];
                    // $facturado[$code]['concepto']=$key['concepto_factura'];
                    $facturado[$code]['conceptos'][count($facturado[$code]['conceptos'])]=$key['concepto_factura'];
                    
                    if($key['tipo_operacion']=="Salida"){
                        $facturado[$code]['cantidad']+=$key['stock_operacion'];
                    }
                    if($key['tipo_operacion']=="Entrada"){
                        $facturado[$code]['cantidad']-=$key['stock_operacion'];
                    }
                }
                if($key['tipo_inventario']=='Productos'){
                    $inventario=$lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$key['id_inventario']}");
                }
                if($key['tipo_inventario']=='Mercancia'){
                    $inventario=$lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$key['id_inventario']}");
                }
                if($key['tipo_inventario']=='Catalogos'){
                    $inventario=$lider->consultarQuery("SELECT *, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$key['id_inventario']}");
                }
                foreach ($inventario as $inv) {
                    if(!empty($inv['elemento'])){
                        if(!empty($facturado[$code])){

                            $facturado[$code]['descripcion']=$inv['elemento'];
                        }
                    }
                }
            }
        }

    }
    $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.estatus=1 ORDER BY id_cliente ASC;");
    // die();
    if(!empty($action)){
      if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
        require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
      }else{
          require_once 'public/views/error404.php';
      }
    }else{
      if (is_file('public/views/'.$url.'.php')) {
        require_once 'public/views/'.$url.'.php';
      }else{
          require_once 'public/views/error404.php';
      }
    }

}else{
  require_once 'public/views/error404.php';
}

?>