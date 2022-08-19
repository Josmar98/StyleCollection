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
    $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
    $despacho = $despachos[0];
    $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE bancos.estatus = 1");
	$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
	$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
		$id_cliente = $_SESSION['id_cliente'];
	$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1");
	$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");

	//========================================================================================================== 

				
	//========================================================================================================== 		
		$mostrar = [];
		$n=0;
		foreach ($bancos as $bank) {
			if(!empty($bank['id_banco'])){
				$temp = [];
				$pagoss = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$bank['id_banco']} ");
				$movimientoss = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1 and movimientos.id_banco = {$bank['id_banco']}");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagoss as $pag) {
					// if(!empty($pag['id_pago'])){
					// 	if($pag['estado']=="Abonado"){
					// 		$abonados += $pag['equivalente_pago'];
					// 		$reportados += $pag['equivalente_pago'];
					// 	}else if($pag['estado']=="Diferido"){
					// 		$diferidos += $pag['equivalente_pago'];
					// 		$reportados += $pag['equivalente_pago'];
					// 	}else {
					// 		$reportados += $pag['equivalente_pago'];
					// 	}
					// }
					if(!empty($pag['id_pago'])){
						if($pag['id_banco']==""){
							if($pag['estado']=="Diferido"){
								$diferidos += $pag['equivalente_pago'];
								$reportados += $pag['equivalente_pago'];
							}else if($pag['estado']=="Abonado"){
								$abonados += $pag['equivalente_pago'];
								$reportados += $pag['equivalente_pago'];
							}else{
								$reportados += $pag['equivalente_pago'];
							}
						}
						if($pag['id_banco']!=""){
							foreach ($movimientoss as $mov) {
								if(!empty($mov['id_pago'])){
									if($mov['id_pago']==$pag['id_pago']){
										if($mov['fecha_movimiento']==$pag['fecha_pago']){
							if($pag['estado']=="Diferido"){
								$diferidos += $pag['equivalente_pago'];
								$reportados += $pag['equivalente_pago'];
							}else if($pag['estado']=="Abonado"){
								$abonados += $pag['equivalente_pago'];
								$reportados += $pag['equivalente_pago'];
							}else{
								$reportados += $pag['equivalente_pago'];
							}
										}
									}
								}
							}
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					if($bank['tipo_cuenta']=="Divisas"){
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Depositos ".$bank['tipo_cuenta'].")";
					}else{
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Cuenta ".$bank['tipo_cuenta'].")";
					}
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
			}
		}
	//========================================================================================================== 

				
	//========================================================================================================== 
		$pagossDivisas = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossDivisas as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Divisas Dolares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}

	//========================================================================================================== 


	//========================================================================================================== 
		$pagossBolivares = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Efectivo Bolivares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossBolivares as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Efectivo Bolivares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
	//========================================================================================================== 

				
	//========================================================================================================== 
			$pagossAutorizados = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago LIKE '%Autorizado Por%'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossAutorizados as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Autorizado Por Amarilis Rojas";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
	//========================================================================================================== 
	$mes = date("m");
              switch ($mes) {
                case '01':
                  $mes = "Enero";
                  break;
                case '02':
                  $mes = "Febrero";
                  break;
                case '03':
                  $mes = "Marzo";
                  break;
                case '04':
                  $mes = "Abril";
                  break;
                case '05':
                  $mes = "Mayo";
                  break;
                case '06':
                  $mes = "Junio";
                  break;
                case '07':
                  $mes = "Julio";
                  break;
                case '08':
                  $mes = "Agosto";
                  break;
                case '09':
                  $mes = "Septiembre";
                  break;
                case '10':
                  $mes = "Octubre";
                  break;
                case '11':
                  $mes = "Noviembre";
                  break;
                case '12':
                  $mes = "Diciembre";
                  break;
              }

	$reportado = 0;
	$diferido = 0;
	$abonado = 0;
	$pendienteConciliar = 0;
	if(count($pagos)>1){
		foreach ($pagos as $data) {
	                // if(!empty($data['id_pago'])){
	                //   $reportado += $data['equivalente_pago'];
	                //   if($data['estado']=="Diferido"){
	                //     $diferido += $data['equivalente_pago'];
	                //   }
	                //   if($data['estado']=="Abonado"){
	                //     $abonado += $data['equivalente_pago'];
	                //   }
	                // }
	                if(!empty($data['id_pago'])){
	                	if($data['id_banco']==""){
	                		if($data['estado']=="Diferido"){
	                			$diferido += $data['equivalente_pago'];
	                			$reportado += $data['equivalente_pago'];
	                		}else if($data['estado']=="Abonado"){
	                			$abonado += $data['equivalente_pago'];
	                			$reportado += $data['equivalente_pago'];
	                		}else{
	                			$reportado += $data['equivalente_pago'];
	                		}
	                	}
	                	if($data['id_banco']!=""){
	                		foreach ($movimientos as $mov) {
	                			if(!empty($mov['id_pago'])){
	                				if($mov['id_pago']==$data['id_pago']){
	                					if($mov['fecha_movimiento']==$data['fecha_pago']){
	                			if($data['estado']=="Diferido"){
	                				$diferido += $data['equivalente_pago'];
	                				$reportado += $data['equivalente_pago'];
	                			}else if($data['estado']=="Abonado"){
	                				$abonado += $data['equivalente_pago'];
	                				$reportado += $data['equivalente_pago'];
	                			}else{
	                				$reportado += $data['equivalente_pago'];
	                			}
	                					}
	                				}
								}
							}
						}
					}
				}
	}
	$pendienteConciliar = $reportado-$diferido-$abonado;
	$general['reportado'] = $reportado;
	$general['diferido'] = $diferido;
	$general['abonado'] = $abonado;
	$general['pendiente'] = $pendienteConciliar;

	// $filas = ['filI'=> '1', 'filF' => ''];
	$colum = ['colI'=> 'A', 'colF' => 'I'];
	$typeResponse = 1;


	$libro = new Excel($file, "Xlsx");
	$dat['mostrar'] = $mostrar;
	$dat['mes'] = $mes;
	$dat['general'] = $general;
	$dat['despachos'] = $despacho;
	// $dat['bancos'] = $bancos;
	// $dat['planes'] = $planes;
	// $dat['nuevoTotal'] = $nuevoTotal;
	// print_r($dat);
	$libro->exportarReportedePagosExcel($dat, $lider);

?>