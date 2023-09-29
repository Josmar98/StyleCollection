<?php 
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

	$id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];
    $id_despacho = $_GET['dpid'];
    $numero_despacho = $_GET['dp'];
    $admin = "";
 // pagos.forma_pago = 'Divisas Dolares'
    $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
		if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
			$id_cliente = $_GET['lider'];
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				if(!empty($_GET['Diferido'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Diferido' and campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				
				}else if(!empty($_GET['Abonado'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Abonado' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				}
			}else{
				if(!empty($_GET['Diferido'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Diferido' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				} else if(!empty($_GET['Abonado'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Abonado' and campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				}
			}
		}else{
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				if(!empty($_GET['Diferido'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Diferido' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				}else if(!empty($_GET['Abonado'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Abonado' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
				}
			}else{
				if(!empty($_GET['Diferido'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Diferido' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				}else if(!empty($_GET['Abonado'])){
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE pagos.estado = 'Abonado' and  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares' ORDER BY fecha_pago asc");
				}
			}
			$id_cliente = $_SESSION['id_cliente'];
		}

		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1");
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$resulttDescuentoNivelLider=0;
		$deudaTotal=0;
	 	$bonoPago1Puntual = 0;
	 	$bonoCierrePuntual = 0;
	 	$bonoAcumuladoCierreEstructura = 0;
		if(Count($pedidos)>1){
			$pedido = $pedidos[0];	
			$id_pedido = $pedido['id_pedido'];
			$bonosPago1 = $lider->consultarQuery("SELECT * FROm bonosPagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id_pedido");
	 		if(count($bonosPago1)>1){
	 			foreach ($bonosPago1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoPago1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
	 		$bonosCierre = $lider->consultarQuery("SELECT * FROm bonosPagos WHERE tipo_bono = 'Cierre' and id_pedido = $id_pedido");
	 		if(count($bonosCierre)>1){
	 			foreach ($bonosCierre as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoCierrePuntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
	 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id_pedido");
	 		if(count($bonosCierreEstructura)>1){
	 			foreach ($bonosCierreEstructura as $bono) {
	 				if(!empty($bono['totales_bono_cierre'])){
	 					$bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre'];
	 				}
	 			}
	 		}
			$total = $pedido['cantidad_total'];
			$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad");
			if(count($liderazgos)>1){
				$lidera = $liderazgos[0];
				foreach ($liderazgosAll as $data) {
					if(!empty($data['id_liderazgo'])){
						if ($lidera['id_liderazgo'] >= $data['id_liderazgo']){
							$resultNLider = $data['descuento_coleccion']*$pedido['cantidad_aprobado'];
							$resulttDescuentoNivelLider += $resultNLider;
						}
					}
				}
			}
			$totalAprobado = $pedido['cantidad_aprobado'];
			$deudaTotal += $totalAprobado * $pedido['precio_coleccion'];
		}
		$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");
		$resulttDescuentoDirecto=0;
		foreach ($colss as $col) {
			if(!empty($col['id_plan_campana'])){
				if(!empty($col['descuento_directo']) && $col['descuento_directo']>0){
					$multi = $col['cantidad_coleccion']*$col['cantidad_coleccion_plan'];
					$resultt = $multi*$col['descuento_directo'];
					$resulttDescuentoDirecto+=$resultt;
				}
			}
		}
		$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoPago1Puntual + $bonoCierrePuntual + $bonoAcumuladoCierreEstructura;
		$nuevoTotal = $deudaTotal-$descuentosTotales;


		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");

		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
		$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$despacho = $despachos[0];

		if($pagos['ejecucion']==1){
			$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			if(count($pagos)){
              foreach ($pagos as $data) {
                if(!empty($data['id_pago'])){
                  $reportado += $data['equivalente_pago'];
                  if($data['estado']=="Diferido"){
                    $diferido += $data['equivalente_pago'];
                  }
                  if($data['estado']=="Abonado"){
                    $abonado += $data['equivalente_pago'];
                  }
                }
              }
			}
		}
	

	// $filas = ['filI'=> '1', 'filF' => ''];
	$colum = ['colI'=> 'A', 'colF' => 'I'];
	$typeResponse = 1;

	$libro = new Excel($file, "Xlsx");
	$dat['pagos'] = $pagos;
	$dat['bancos'] = $bancos;
	$dat['despachos'] = $despacho;
	$dat['planes'] = $planes;
	$dat['nuevoTotal'] = $nuevoTotal;
	if(!empty($_GET['lider'])){
		$dat['clientes'] = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 and id_cliente = {$_GET['lider']}"); 
		$dat['pedido'] = $pedido;
		$bonoscontado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = {$pedido['id_pedido']}");
		$dat['bonoscontado'] = $bonoscontado;
	}
	$libro->exportarPagosExcel($dat, $lider);

	
	// echo "<script>open('".$file."')</script>";
	// echo "<script>window.close()</script>";

?>