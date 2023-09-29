<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	
	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
	$despacho = $despachos[0];
	
	$pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];
	$iterRecor = 1;
	foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
		if($pagosD['tipo_pago_despacho']=="Inicial"){
			$pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
			$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
			$iterRecor++;
		}
	} }
	
	$cantidadPagosDespachosFild = [];

	for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
		$key = $cantidadPagosDespachos[$i];
		if($key['cantidad'] <= $despacho['cantidad_pagos']){
			$cantidadPagosDespachosFild[$i] = $key;
			foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
				if($pagosD['tipo_pago_despacho']==$key['name']){
					if($i < $despacho['cantidad_pagos']-1){
						$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
						$iterRecor++;
					}
					if($i == $despacho['cantidad_pagos']-1){
						$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
						$iterRecor++;
					}
				}
			}}
		}
	}

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE pagos SET estatus = 1 WHERE id_pago = '{$id}'";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pagos', 'Restaurar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}

		if(!empty($action)){
			if (is_file('public/views/' .strtolower($url).'/'.$action.'Pagoss.php')) {
				require_once 'public/views/' .strtolower($url).'/'.$action.'Pagoss.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}else{
			if (is_file('public/views/Pagoss.php')) {
				require_once 'public/views/Pagoss.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}
		die();
	}

	if(empty($_POST)){

		$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
		$sqlPagos = "SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}";
		$sqlMovimientos = "SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1";
		if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
			$id_cliente = $_GET['lider'];
			$sqlPagos .= " and pedidos.id_cliente = {$id_cliente}";
		}else{
			$id_cliente = $_SESSION['id_cliente'];
		}
		if(!empty($_GET['Banco'])){
			$id_banco = $_GET['Banco'];
			$sqlPagos .= " and pagos.id_banco = {$id_banco}";
			$sqlMovimientos .= " and movimientos.id_banco = {$id_banco}";
		}
		if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
			$rangoI = $_GET['rangoI'];
			$rangoF = $_GET['rangoF'];
			$sqlPagos .= " and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF'";
			$sqlMovimientos .= " and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF'";
		}
		$sqlPagos .= " ORDER BY pagos.fecha_pago ASC;";
		$pagos = $lider->consultarQuery($sqlPagos);
		$movimientos = $lider->consultarQuery($sqlMovimientos);

		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}");
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");
		$resulttDescuentoNivelLider=0;
		$deudaTotal=0;
	 	$bonoContado1Puntual = 0;
	 	$bonoPagosPuntuales = 0;
	 	// $bonoPago1Puntual = 0;
	 	// $bonoCierrePuntual = 0;
	 	$bonoAcumuladoCierreEstructura = 0;
		if(Count($pedidos)>1){
			$pedido = $pedidos[0];	
			$id_pedido = $pedido['id_pedido'];
			$bonosContado1 = $lider->consultarQuery("SELECT * FROm bonoscontado WHERE id_pedido = $id_pedido");
	 		if(count($bonosContado1)>1){
	 			foreach ($bonosContado1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoContado1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
			$bonosPagos = $lider->consultarQuery("SELECT * FROM bonospagos WHERE id_pedido = $id_pedido");
			if(count($bonosPagos)>1){
	 			foreach ($bonosPagos as $bono){ if(!empty($bono['totales_bono'])){ $bonoPagosPuntuales += $bono['totales_bono']; } }
	 		}
	 		// echo "Bono> ".$bonoPagosPuntuales;
			// $bonosPago1 = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id_pedido");
	 		// if(count($bonosPago1)>1){
	 			// foreach ($bonosPago1 as $bono){ if(!empty($bono['totales_bono'])){ $bonoPago1Puntual += $bono['totales_bono']; } }
	 		// }
	 		// $bonosCierre = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id_pedido");
	 		// if(count($bonosCierre)>1){
	 			// foreach ($bonosCierre as $bono){ if(!empty($bono['totales_bono'])){ $bonoCierrePuntual += $bono['totales_bono']; } }
	 		// }
	 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id_pedido");
	 		if(count($bonosCierreEstructura)>1){
	 			foreach ($bonosCierreEstructura as $bono) {
	 				if(!empty($bono['totales_bono_cierre'])){
	 					$bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre'];
	 				}
	 			}
	 		}
			$total = $pedido['cantidad_total'];
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
		$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPagosPuntuales + $bonoAcumuladoCierreEstructura;
		$nuevoTotal = $deudaTotal-$descuentosTotales;
		// echo "Deuda: ".$deudaTotal."<br>";
		// echo "Descuentos: ".$descuentosTotales."<br>";
		// echo "Total: ".$nuevoTotal."<br>";

		//$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and planes.estatus = 1 and pedidos.estatus = 1");
		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");
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
}else{
	require_once 'public/views/error404.php';
}


?>