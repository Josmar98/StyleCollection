<?php 

// if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
		$num = number_format($_POST['val'],2,',','.');
		echo $num;
	}
	if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
		$id = $_POST['id_pago'];
		$pedido = $lider->consultarQuery("SELECT * FROm pagos, pedidos, clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago = '$id'");
		$data = ['exec_pedido'=>true];
		$data += ['pedido'=>$pedido[0]];
		if($pedido[0]['id_banco']!=""){
			$id_banco = $pedido[0]['id_banco'];
			$data += ['exec_banco'=>true];
			$banco = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco} and estatus = 1");
			$data += ['banco' => $banco[0]];
		}else{
			$data += ['exec_banco'=>false];
		}

		echo json_encode($data);	

		// $pago = $lider->consultarQuery("SELECT * FROM pagos WHERE ")
	}
	if(empty($_POST)){
		$id_cliente = $_SESSION['id_cliente'];

		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}");
		
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$resulttDescuentoNivelLider=0;
		$deudaTotal=0;
	 	$bonoContado1Puntual = 0;
	 	$bonoPago1Puntual = 0;
	 	$bonoCierrePuntual = 0;
	 	$bonoAcumuladoCierreEstructura = 0;
	 	$liquidacion_gemas = 0;
	 	$totalTraspasoRecibido=0;
	 	$totalTraspasoEmitidos=0;
		if(Count($pedidos)>1){
			$pedido = $pedidos[0];	
			$id_pedido = $pedido['id_pedido'];
			$Opttraspasarexcedente = 0;
			$configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
			foreach ($configuraciones as $config) {
				if(!empty($config['id_configuracion'])){
					if($config['clausula']=="Opttraspasarexcedente"){
						$Opttraspasarexcedente = $config['valor'];
					}
				}
			}
			if($Opttraspasarexcedente=="1"){
				$traspasosRecibidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_emisor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_receptor = $id_pedido");
				foreach ($traspasosRecibidos as $traspas){
					if(!empty($traspas['id_traspaso'])){
						$totalTraspasoRecibido += $traspas['cantidad_traspaso'];
					}
				}
				$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id_pedido");
				foreach ($traspasosEmitidos as $traspas){
					if(!empty($traspas['id_traspaso'])){
						$totalTraspasoEmitidos += $traspas['cantidad_traspaso'];
					}
				}
			}
			$bonosContado1 = $lider->consultarQuery("SELECT * FROm bonoscontado WHERE id_pedido = $id_pedido");
	 		if(count($bonosContado1)>1){
	 			foreach ($bonosContado1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoContado1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
			$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id_pedido");
	 		if(count($bonosPago1)>1){
	 			foreach ($bonosPago1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoPago1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
	 		$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id_pedido");
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
	 		
	 		$gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
	 		if(count($gemas_liquidadas)>1){
	 			foreach ($gemas_liquidadas as $liquidadas) {
	 				if(!empty($liquidadas['total_descuento_gemas'])){
	 					$liquidacion_gemas += $liquidadas['total_descuento_gemas'];
	 				}
	 			}
	 		}
			// $total = $pedido['cantidad_total'];
			$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

			$sumatoria_cantidad_aprobado = 0;
			$sumatoria_cantidad_total = 0;
			foreach ($pedidosAcumulados as $keyss) {
				if(!empty($keyss['cantidad_aprobado'])){
					// if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
					// 	$total = $pedido['cantidad_total'];
					// 	$sumatoria_cantidad_total += $keyss['cantidad_total'];
					// }
					// if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
						$total = $pedido['cantidad_aprobado'];
						$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
					// }
				}
			}
			// if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
			// 	$total = $pedido['cantidad_total'];
			// 	$total = $sumatoria_cantidad_total;
			// }
			// if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
				$total = $pedido['cantidad_aprobado'];
				$total = $sumatoria_cantidad_aprobado;
			// }
			
			$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
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
		$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente} and planes_campana.id_despacho = {$id_despacho}");
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

		$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPago1Puntual + $bonoCierrePuntual + $totalTraspasoRecibido + $bonoAcumuladoCierreEstructura + $liquidacion_gemas;
		$nuevoTotal = $deudaTotal-$descuentosTotales + $totalTraspasoEmitidos;
		// echo "Deuda: ".$deudaTotal."<br>";
		// echo "Descuentos: ".$descuentosTotales."<br>";
		// echo "Total: ".$nuevoTotal."<br>";

		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");
		
		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
		$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");

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
					// if(!empty($data['id_pago'])){
					// 	if($data['id_banco']==""){
					// 		if($data['estado']=="Diferido"){
					// 			$diferido += $data['equivalente_pago'];
					// 			$reportado += $data['equivalente_pago'];
					// 		}else if($data['estado']=="Abonado"){
					// 			$abonado += $data['equivalente_pago'];
					// 			$reportado += $data['equivalente_pago'];
					// 		}else{
					// 			$reportado += $data['equivalente_pago'];
					// 		}
					// 	}
					// 	if($data['id_banco']!=""){
					// 		foreach ($movimientos as $mov) {
					// 			if(!empty($mov['id_pago'])){
					// 				if($mov['id_pago']==$data['id_pago']){
					// 					if($mov['fecha_movimiento']==$data['fecha_pago']){
					// 		if($data['estado']=="Diferido"){
					// 			$diferido += $data['equivalente_pago'];
					// 			$reportado += $data['equivalente_pago'];
					// 		}else if($data['estado']=="Abonado"){
					// 			$abonado += $data['equivalente_pago'];
					// 			$reportado += $data['equivalente_pago'];
					// 		}else{
					// 			$reportado += $data['equivalente_pago'];
					// 		}
					// 					}
					// 				}
					// 			}
					// 		}
					// 	}
					// }
				}
			}

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
	}
// }else{
	// require_once 'public/views/error404.php';
// }


?>