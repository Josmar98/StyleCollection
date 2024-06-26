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

	$digitosParaCodigo = 6;
	$digitosParaCodigo2 = 8;
	$cantidadIVA = 16;


	$meses = ['01'=>"Enero", '02'=>"Febrero", '03'=>"Marzo", '04'=>"Abril", '05'=>"Mayo", '06'=>"Junio", '07'=>"Julio", '08'=>"Agosto", '09'=>"Septiembre", '10'=>"Octubre", '11'=>"Noviembre", '12'=>"Diciembre"];
	$range = ['01'=>31,'02'=>28,'03'=>31,'04'=>30,'05'=>31,'06'=>30,'07'=>31,'08'=>31,'09'=>30,'10'=>31,'11'=>30,'12'=>31];
	if(!empty($_GET['anio'])){
		if( ($_GET['anio']%4)==0 ){ $range['02']=29; }
	}

	$excedenteCreditosFiscalesPendienteAnterior = 0;
	$debitosFiscalesPendienteAnterior = 0;
	$operacionMostrarInformacion = false;

	if( 
		(!empty($_GET['tipo']) && $_GET['tipo']=="1") && (!empty($_GET['anio'])) ||
		(!empty($_GET['tipo']) && $_GET['tipo']=="2") && ( !empty($_GET['anio']) && !empty($_GET['mes']) )
	){
		$operacionMostrarInformacion = true;
		$tipo=$_GET['tipo'];
		if( !empty($_GET['mes']) ){
			$inicioFecha = $_GET['anio']."-".$_GET['mes']."-01";
			$finFecha = $_GET['anio']."-".$_GET['mes']."-".$range[$_GET['mes']];
			$compras=$lider->consultarQuery("SELECT * FROM proveedores_compras, factura_compras WHERE proveedores_compras.id_proveedor_compras = factura_compras.id_proveedor_compras and factura_compras.estatus=1 and factura_compras.periodoAnio='{$_GET['anio']}' and factura_compras.periodoMes='{$_GET['mes']}' ORDER BY factura_compras.periodoAnio DESC, factura_compras.periodoMes DESC, factura_compras.fechaFactura ASC;");
			$actualAnio = $_GET['anio'];
			$actualMes = $_GET['mes'];

			if($actualMes=="01"){
				$anteriorMes="12";
				$anteriorAnio=$actualAnio-1;
			}else{
				$anteriorAnio=$actualAnio;
				if(strlen($actualMes-1)==1){
					$anteriorMes="0";
					$anteriorMes.=($actualMes-1);
				}else{
					$anteriorMes=$actualMes-1;
				}
			}
			$resumenCompra = $lider->consultarQuery("SELECT * FROM resumen_compras WHERE periodoAnio='{$anteriorAnio}' and periodoMes='{$anteriorMes}'");
			foreach ($resumenCompra as $resumenes) {
				if(!empty($resumenes['id_resumen_compra'])){
					$excedenteCreditosFiscalesPendienteAnterior+=$resumenes['creditoFiscal'];
					$debitosFiscalesPendienteAnterior+=$resumenes['debitoFiscal'];
				}
			}

		} else {
			$inicioFecha = $_GET['anio']."-"."01"."-01";
			$finFecha = $_GET['anio']."-"."12"."-".$range['12'];
			$compras=$lider->consultarQuery("SELECT * FROM proveedores_compras, factura_compras WHERE proveedores_compras.id_proveedor_compras = factura_compras.id_proveedor_compras and factura_compras.estatus=1 and factura_compras.periodoAnio='{$_GET['anio']}' ORDER BY factura_compras.periodoAnio DESC, factura_compras.fechaFactura ASC;");

			$actualAnio = $_GET['anio'];
			$anteriorAnio=$actualAnio-1;
			$resumenCompra = $lider->consultarQuery("SELECT * FROM resumen_compras WHERE periodoAnio='{$actualAnio}'");
			foreach ($resumenCompra as $resumenes) {
				if(!empty($resumenes['id_resumen_compra'])){
					$excedenteCreditosFiscalesPendienteAnterior+=$resumenes['creditoFiscal'];
					$debitosFiscalesPendienteAnterior+=$resumenes['debitoFiscal'];
				}
			}
		}
		// $query="SELECT *, factura_despacho.estatus as estado_factura FROM factura_despacho, pedidos, despachos, clientes WHERE factura_despacho.id_pedido=pedidos.id_pedido and pedidos.id_despacho=despachos.id_despacho and pedidos.id_cliente=clientes.id_cliente and factura_despacho.fecha_emision BETWEEN '{$inicioFecha}' AND '{$finFecha}' ORDER BY factura_despacho.fecha_emision ASC;";
		$query="SELECT *, factura_despacho.estatus as estado_factura FROM factura_ventas, factura_despacho, pedidos, despachos, clientes WHERE factura_ventas.id_factura_despacho = factura_despacho.id_factura_despacho and factura_despacho.id_pedido=pedidos.id_pedido and pedidos.id_despacho=despachos.id_despacho and pedidos.id_cliente=clientes.id_cliente and factura_despacho.fecha_emision BETWEEN '{$inicioFecha}' AND '{$finFecha}' ORDER BY factura_despacho.fecha_emision, factura_despacho.numero_factura ASC;";
		$facturasFiscales = $lider->consultarQuery($query);

	}

	// $filas = ['filI'=> '1', 'filF' => ''];
	$colum = ['colI'=> 'A', 'colF' => 'I'];
	$typeResponse = 1;

	$libro = new Excel($file, "Xlsx");

	$dat['digitosParaCodigo']=$digitosParaCodigo;
	$dat['digitosParaCodigo2']=$digitosParaCodigo2;
	$dat['cantidadIVA']=$cantidadIVA;
	$dat['meses'] = $meses;
	$dat['range'] = $range;
	$dat['operacionMostrarInformacion'] = $operacionMostrarInformacion;
	if(!empty($_GET['mes'])){
		$dat['actualMes'] = $actualMes;
		$dat['anteriorMes'] = $anteriorMes;
	}
	$dat['actualAnio'] = $actualAnio;
	$dat['anteriorAnio'] = $anteriorAnio;

	$dat['inicioFecha'] = $inicioFecha;
	$dat['finFecha'] = $finFecha;

	$dat['compras'] = $compras;
	$dat['resumenCompra'] = $resumenCompra;
	$dat['facturasFiscales'] = $facturasFiscales;
	$dat['excedenteCreditosFiscalesPendienteAnterior'] = $excedenteCreditosFiscalesPendienteAnterior;
	$dat['debitosFiscalesPendienteAnterior'] = $debitosFiscalesPendienteAnterior;
	// print_r($dat);
	$libro->exportarReporteExcelLibroIva($dat, $lider);
?>