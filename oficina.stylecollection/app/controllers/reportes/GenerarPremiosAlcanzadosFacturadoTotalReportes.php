<?php 
	// $facturas = $lider->consultarQuery("SELECT *, factura_despacho.estatus as estado_factura FROM factura_despacho, pedidos, despachos, clientes WHERE factura_despacho.id_pedido=pedidos.id_pedido and pedidos.id_despacho=despachos.id_despacho and pedidos.id_cliente=clientes.id_cliente ORDER BY factura_despacho.id_factura_despacho ASC;");
	// foreach ($facturas as $key) {
	// 	if(!empty($key['id_factura_despacho'])){
	// 		$id_factura_despacho = $key['id_factura_despacho'];
	// 		$precio_coleccion = $key['precio_coleccion'];
	// 		$cantidad_colecciones = $key['cantidad_aprobado'];
	// 		$total = ($precio_coleccion*$cantidad_colecciones);
	// 		$query = "INSERT INTO factura_ventas(id_factura_ventas, id_factura_despacho, totalVenta, estatus) VALUES (DEFAULT, {$id_factura_despacho}, {$total}, 1)";
	// 		$res = $lider->modificar($query);
	// 		if($res['ejecucion']==1){
	// 			echo "Exitoso: ";
	// 		}else{
	// 			echo "ERRORRR: ";
	// 		}
	// 		echo $query."<br>";
	// 	}
	// }
	// die();

	set_time_limit(320);
	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Writer;
	use PhpOffice\PhpSpreadsheet\Reader;

	if(is_file('app/models/excel.php')){
		require_once'app/models/excel.php';
	}
	if(is_file('../app/models/excel.php')){
		require_once'../app/models/excel.php';
	}

	$file = "./config/temp/pagos.xlsx";
	// die();

	if(!empty($_GET['id'])){
        $id_despacho = $_GET['id'];
        $campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana");
        $campana = $campanas[0];
        $id_campana = $campana['id_campana'];
        
        $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
        $despacho=$despachos[0];

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

        // $filas = ['filI'=> '1', 'filF' => ''];
        $colum = ['colI'=> 'A', 'colF' => 'I'];
        $typeResponse = 1;
    
        $libro = new Excel($file, "Xlsx");
    
        $dat['campana']=$campana;
        $dat['despacho']=$despacho;
        $dat['facturado']=$facturado;
        // foreach ($dat['facturado'] as $key) {
        //     print_r($key);
        //     echo "<br><br>";
        // }
        $libro->exportarAlcanzadoFacturadoTotal($dat, $lider);
    }else{
        require_once 'public/views/error404.php';
    }

	
?>