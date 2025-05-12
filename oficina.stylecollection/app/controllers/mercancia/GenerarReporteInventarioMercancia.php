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
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 ORDER BY mercancia asc;");
	$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    for ($i=0; $i < count($mercancia)-1; $i++) { 
        $mer = $mercancia[$i];
        $sumaTotal = 0;
        foreach($almacenes as $alm){
            if(!empty($alm['id_almacen'])){
                $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$mer['id_mercancia']} and id_almacen={$alm['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
                if(count($operacionesInv)>1){
                    $mercancia[$i]['stock_almacen'.$alm['id_almacen']]=$operacionesInv[0]['stock_operacion_almacen'];
                    $sumaTotal+=$operacionesInv[0]['stock_operacion_almacen'];
                }else{
                    $mercancia[$i]['stock_almacen'.$alm['id_almacen']]=0;
                    $sumaTotal+=0;
                }
                
            }
        }
        $mercancia[$i]['stock_total']=$sumaTotal;
    }

    // $filas = ['filI'=> '1', 'filF' => ''];
    $colum = ['colI'=> 'A', 'colF' => 'I'];
    $typeResponse = 1;

    $libro = new Excel($file, "Xlsx");

    $dat['mercancia']=$mercancia;
    $dat['almacenes']=$almacenes;
    // foreach ($dat['mercancia'] as $key) {
    //     print_r($key);
    //     echo "<br><br>";
    // }
    $libro->exportarInventarioMercancia($dat, $lider);

	
?>