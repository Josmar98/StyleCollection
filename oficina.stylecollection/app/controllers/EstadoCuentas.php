<?php 
	$configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones");
	$seleccionAdmin = 0;
	if(Count($configuraciones)>1){
		foreach ($configuraciones as $keys) {
			if(!empty($keys['id_configuracion'])){
				if($keys['clausula']=="Seleccion Admin"){
					$seleccionAdmin = $keys['valor'];
				}
			}
		}
	}

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$menu2 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&";

	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana}");
	$cantidadPagos = 0;
	foreach ($despachos as $key) {
		if(!empty($key['id_despacho'])){
			if($key['cantidad_pagos'] > $cantidadPagos){
				$cantidadPagos = $key['cantidad_pagos'];
			}
		}
	}
	$cantidadPagosDespachosFild = [];

	for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
		$key = $cantidadPagosDespachos[$i];
		if($key['cantidad'] <= $cantidadPagos){
			$cantidadPagosDespachosFild[$i] = $key;
		}
	}
	$_SESSION['tomandoEnCuentaLiderazgo'] = "1"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
	$_SESSION['tomandoEnCuentaDistribucion'] = "0"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
$pedidos = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.id_campana = {$id_campana}");
$permitir = "1";
if($permitir=="1"){
	if(empty($_POST)){	
		$bonosContado = $lider->consultarQuery("SELECT * FROM despachos, pedidos, bonoscontado WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = bonoscontado.id_pedido and despachos.id_campana = {$id_campana} ORDER BY despachos.id_despacho ASC;");
		$bonosContados = [];
		foreach ($bonosContado as $key) {
			if(!empty($key['id_bonocontado'])){
				if(!empty($bonosContados[$key['id_despacho']])){
					$bonosContados[$key['id_despacho']]['colecciones'] += $key['colecciones_bono'];
				}else{
					$bonosContados[$key['id_despacho']]['id_despacho'] = $key['id_despacho'];
					$bonosContados[$key['id_despacho']]['numero_despacho'] = $key['numero_despacho'];
					$bonosContados[$key['id_despacho']]['descuentos'] = $key['descuentos_bono'];
					$bonosContados[$key['id_despacho']]['colecciones'] = $key['colecciones_bono'];
				}
			}
		}

		$bonosPago = $lider->consultarQuery("SELECT * FROM despachos, pedidos, bonospagos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = bonospagos.id_pedido and despachos.id_campana = {$id_campana}");
		$bonosPagos = [];
		foreach ($bonosPago as $key) {
			if(!empty($key['id_bonoPago'])){
				foreach ($cantidadPagosDespachosFild as $key2) {
					if($key['tipo_bono']==$key2['name']){
						if(!empty($bonosPagos[$key['id_despacho']][$key2['name']])){
							$bonosPagos[$key['id_despacho']][$key2['name']]['colecciones'] += $key['colecciones_bono'];
						}else{
							$bonosPagos[$key['id_despacho']]['id_despacho'] = $key['id_despacho'];
							$bonosPagos[$key['id_despacho']]['numero_despacho'] = $key['numero_despacho'];
							$bonosPagos[$key['id_despacho']][$key2['name']]['descuentos'] = $key['descuentos_bono'];
							$bonosPagos[$key['id_despacho']][$key2['name']]['colecciones'] = $key['colecciones_bono'];
						}
					}
				}
			}
		}

		$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM despachos, pedidos, bonoscierres WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = bonoscierres.id_pedido and despachos.id_campana = {$id_campana}");

	 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas, despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = descuentos_gemas.id_pedido and despachos.id_campana = {$id_campana}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");

		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1 ORDER BY liderazgos.id_liderazgo ASC;";

		$liderazgosAll = $lider->consultarQuery($query);

		if(count($pedidos)>1){
			if($pedidos['ejecucion']==1){
				$cierresEstructura = 0;
				$pedido = $pedidos[0];
				if(strlen($pedido['fecha_aprobado'])>0){
					$colss = [];
					$colss2 = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = {$id_campana} and planes_campana.id_despacho = despachos.id_despacho ORDER BY despachos.id_despacho ASC");
					$pagos_planes_campana=$lider->consultarQuery("SELECT * FROM planes_campana, pagos_planes_campana WHERE planes_campana.id_plan_campana = pagos_planes_campana.id_plan_campana and planes_campana.id_campana = pagos_planes_campana.id_campana and planes_campana.id_despacho = pagos_planes_campana.id_despacho and pagos_planes_campana.id_campana = {$id_campana} and planes_campana.estatus = 1 and pagos_planes_campana.estatus = 1");
					$nxx = 0;
					foreach ($colss2 as $key) {
						if(!empty($key['id_despacho'])){
							if(!empty($colss[$key['id_despacho']][$key['nombre_plan']])){
								// $colss[$key['id_despacho']][$key['nombre_plan']]['descuento_directo'] += $key['descuento_directo'];
								$colss[$key['id_despacho']][$key['nombre_plan']]['cantidad_coleccion_plan'] += $key['cantidad_coleccion_plan'];
							}else{
								// $colss[$key['id_despacho']]['planes'][$nxx] = $key['nombre_plan'];
								$colss[$key['id_despacho']]['id_despacho'] = $key['id_despacho'];
								$colss[$key['id_despacho']]['numero_despacho'] = $key['numero_despacho'];
								$colss[$key['id_despacho']]['planes'][$nxx]['id_plan'] = $key['id_plan'];
								$colss[$key['id_despacho']]['planes'][$nxx]['id_plan_campana'] = $key['id_plan_campana'];
								$colss[$key['id_despacho']]['planes'][$nxx]['nombre_plan'] = $key['nombre_plan'];
								$colss[$key['id_despacho']][$key['nombre_plan']]['descuento_directo'] = $key['descuento_directo'];
								$colss[$key['id_despacho']][$key['nombre_plan']]['cantidad_coleccion'] = $key['cantidad_coleccion'];
								$colss[$key['id_despacho']][$key['nombre_plan']]['cantidad_coleccion_plan'] = $key['cantidad_coleccion_plan'];
								foreach ($pagos_planes_campana as $key2) {
									if(!empty($key2['id_plan_campana'])){
										if($key['id_despacho']==$key2['id_despacho']){
											if($key['id_plan_campana']==$key2['id_plan_campana']){
												if($key['id_plan']==$key2['id_plan']){

													// echo $key2['tipo_pago_plan_campana'];
													// echo " | ";
													$colss[$key['id_despacho']][$key['nombre_plan']][$key2['tipo_pago_plan_campana']] = $key2['descuento_pago_plan_campana'];
												}
											}
										}
									}
								}
								$nxx++;
							}
						}
					}

					$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana}");

					$sumatoria_cantidad_aprobado = 0;
					$sumatoria_cantidad_total = 0;
					foreach ($pedidosAcumulados as $keyss) {
						if(!empty($keyss['cantidad_aprobado'])){
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$sumatoria_cantidad_total += $keyss['cantidad_total'];
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
							}
						}
					}

					$sumatoria_cantidad_total_real = 0;
					foreach ($pedidos as $keyss) {
						if(!empty($keyss['cantidad_aprobado'])){
							$sumatoria_cantidad_total_real += $keyss['cantidad_aprobado'];
						}
					}
					
					if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
						$total = $pedido['cantidad_total'];
						$total = $sumatoria_cantidad_total;
						$total = $sumatoria_cantidad_total_real;
					}
					if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
						$total = $pedido['cantidad_aprobado'];
						$total = $sumatoria_cantidad_aprobado;
					}

					$maxima = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana ORDER BY liderazgos_campana.minima_cantidad DESC;");
					if(count($maxima)>1){
						$maxmax = $maxima[0];
						if($maxmax['minima_cantidad'] <= $total){
							$id_liderazgoTemp = $maxmax['id_liderazgo'];
							$minima_cantidadTemp = $maxmax['minima_cantidad'];
							$maxima_cantidadTemp = $maxmax['minima_cantidad']*10;
							$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos.id_liderazgo = {$id_liderazgoTemp} and $total > minima_cantidad");
						}else{

							$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad");
						}
					}
					$despachosCampanas = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.id_campana = {$id_campana}");
					$cantidadMinima = $total;
					foreach ($liderazgosAll as $lid) {
						if($lid['id_liderazgo']){
							if($cantidadMinima>$lid['minima_cantidad']){
								$cantidadMinima = $lid['minima_cantidad'];
							}
						}
					}
					$liderazgosMinimo = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $cantidadMinima BETWEEN minima_cantidad and maxima_cantidad");
					$liderazgosMinimo = $liderazgosMinimo[0];
					$cantidadSenior = $liderazgosMinimo['maxima_cantidad']+1;
					$liderazgoSenior = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $cantidadSenior BETWEEN minima_cantidad and maxima_cantidad");

					if(count($liderazgos)>1){
						$lidera = $liderazgos[0];
						$lidSenior = $liderazgoSenior[0];
						$totalesDeudas = [];
						foreach ($pedidos as $key) {
							if(!empty($key['id_despacho'])){
								if(!empty($totalesDeudas[$key['id_despacho']])){
									$totalesDeudas[$key['id_despacho']]['cantidad_aprobado']+=$key['cantidad_aprobado'];
									$totalesDeudas[$key['id_despacho']]['cantidad_aprobado_individual']+=$key['cantidad_aprobado_individual'];
								}else{
									$totalesDeudas[$key['id_despacho']]['id_despacho'] = $key['id_despacho'];
									$totalesDeudas[$key['id_despacho']]['precio_coleccion']=$key['precio_coleccion'];
									$totalesDeudas[$key['id_despacho']]['cantidad_aprobado']=$key['cantidad_aprobado'];
									$totalesDeudas[$key['id_despacho']]['cantidad_aprobado_individual']=$key['cantidad_aprobado_individual'];
									$totalesDeudas[$key['id_despacho']]['numero_pedido']=$key['numero_despacho'];
								}
							}
						}
		                $color_liderazgo = $lidera['color_liderazgo'];
		                $nombre_liderazgo = $lidera['nombre_liderazgo'];

						$abonado = 0;

		                
		            }
				}
				$pagos = $lider->consultarQuery("SELECT pagos.id_pago, pagos.estado, pagos.equivalente_pago FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana}");
				$reportado = 0;
				$diferido = 0;
				$abonado = 0;


				$lideres = $lider->consultar("clientes");
				$despachosDisponiblesAcutales = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = {$id_campana}");
				$countDespachos = 0;
				foreach ($despachosDisponiblesAcutales as $key) {
					if(!empty($key['id_despacho'])){
						$countDespachos++;
					}
				}

				$number = 1;
				if(count($pagos)>1){
					foreach ($pagos as $data) {
						if(!empty($data['equivalente_pago'])){
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

				$fechaPagoLimiteFinal = "";
				if($total>0){
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
			require_once 'public/views/error404.php';
		}

	}
}else{
	require_once 'public/views/error404.php';
}

?>