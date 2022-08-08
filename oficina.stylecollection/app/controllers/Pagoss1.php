<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	

	if(empty($_POST)){
		// $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
		if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
			$id_cliente = $_GET['lider'];
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				if(!empty($_GET['Banco'])){
					$id_banco = $_GET['Banco'];
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$id_banco} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF' and movimientos.id_banco = {$id_banco} and movimientos.estatus = 1");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF' and movimientos.estatus = 1");
				}
			}else{
				if(!empty($_GET['Banco'])){
					$id_banco = $_GET['Banco'];
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$id_banco} ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.id_banco = {$id_banco} and movimientos.estatus = 1");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
				}
			}
		}else{
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				if(!empty($_GET['Banco'])){
					$id_banco = $_GET['Banco'];
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$id_banco} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF' and movimientos.id_banco = {$id_banco} and movimientos.estatus = 1");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF' and movimientos.estatus = 1");
				}
			}else{
				if(!empty($_GET['Banco'])){
					$id_banco = $_GET['Banco'];
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$id_banco} ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.id_banco = {$id_banco} and movimientos.estatus = 1");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
					$movimientos = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
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
		// echo $descuentosTotales;
		// echo "Deuda: ".$deudaTotal."<br>";
		// echo "Descuentos: ".$descuentosTotales."<br>";
		// echo "Total: ".$nuevoTotal."<br>";

		//$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and planes.estatus = 1 and pedidos.estatus = 1");
		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");

		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
		$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$despacho = $despachos[0];

		if($pagos['ejecucion']==1){
			$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			if(count($pagos)){
				$conBancos = 0; // asdasd
				$sinBancos = 0; // asdasd
				$conBancosCorrectos = 0; // asdasd
				$conBancosAlterados = 0; // asdasd
				$eqvSinBanco = 0; // asdasd
				$eqvConBanco = 0; // asdasd
				$eqvConBancoCorrectos = 0; // asdasd
				$eqvConBancoAlterados = 0; // asdasd
              foreach ($pagos as $data) {
                if(!empty($data['id_pago'])){
                  if($data['id_banco']==""){
                  	$sinBancos++; // asdasd
						if($data['estado']=="Diferido"){
							$diferido += $data['equivalente_pago'];
							$reportado += $data['equivalente_pago'];
						}else if($data['estado']=="Abonado"){
							$abonado += $data['equivalente_pago'];
							$reportado += $data['equivalente_pago'];
							$eqvSinBanco += $data['equivalente_pago']; // asdasd
						}else{
							$reportado += $data['equivalente_pago'];
						}
                  }
                  if($data['id_banco']!=""){
                  	foreach ($movimientos as $mov) {
                  		if(!empty($mov['id_pago'])){
                  			if($mov['id_pago']==$data['id_pago']){
                  				$conBancos++;  // asdasd
                  				if($mov['fecha_movimiento']==$data['fecha_pago']){
                  					$conBancosCorrectos++; // asdasd

						if($data['estado']=="Diferido"){
							$diferido += $data['equivalente_pago'];
							$reportado += $data['equivalente_pago'];
						}else if($data['estado']=="Abonado"){
							$abonado += $data['equivalente_pago'];
							$reportado += $data['equivalente_pago'];
                  			$eqvConBancoCorrectos += $data['equivalente_pago']; // asdasd
						}else{
							$reportado += $data['equivalente_pago'];
						}
                  				}else{ // asdasd
                  					if($data['estado']=='Abonado'){
                  						$conBancosAlterados++;// asdasd
                  						$eqvConBancoAlterados += $data['equivalente_pago']; // asdasd
                  					}
                  				}

                  			$eqvConBanco += $data['equivalente_pago']; // asdasd
                  			}
                  		}
                  	}
                  }
                }
              }
				// echo "Movimientos Totales: ".(count($movimientos)-1)."<br>"; // asdasd
				// echo "Pagos Totales: ".(count($pagos)-1)."<br>"; // asdasd
				// echo "Sin Bancos: ".$sinBancos."<br>"; // asdasd
				// echo "Con Bancos: ".$conBancos."<br>"; // asdasd
				// echo "Con Bancos Correctos: ".$conBancosCorrectos."<br>"; // asdasd
				// echo "Con Bancos Alterados: ".$conBancosAlterados."<br>"; // asdasd
				// echo "Equivalente_pago Sin Bancos: ".$eqvSinBanco." === ".number_format($eqvSinBanco,2,',','.')." <br>"; // asdasd
				// echo "Equivalente_pago CON Bancos y MOVIMIENTOS: ".$eqvConBanco." === ".number_format($eqvConBanco,2,',','.')." <br>"; // asdasd
				// echo "Equivalente_pago CON Bancos y MOVIMIENTOS CORRECTOS: ".$eqvConBancoCorrectos." === ".number_format($eqvConBancoCorrectos,2,',','.')." <br>"; // asdasd
				// echo "Equivalente_pago CON Bancos y MOVIMIENTOS ALTERADOS: ".$eqvConBancoAlterados." === ".number_format($eqvConBancoAlterados,2,',','.')." <br>"; // asdasd
				// echo "Equivalente_pago MOVIMIENTOS Correctos: ".($eqvConBancoAlterados+$eqvSinBanco)." === ".number_format(($eqvConBancoAlterados+$eqvSinBanco),2,',','.')." <br>"; // asdasd


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