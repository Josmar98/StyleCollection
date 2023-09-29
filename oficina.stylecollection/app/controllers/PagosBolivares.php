<?php 
$_SESSION['tomandoEnCuentaLiderazgo'] = "1";

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


	$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
	$accesoBloqueo = "0";
	$superAnalistaBloqueo="1";
	$analistaBloqueo="1";
	foreach ($configuraciones as $config) {
		if(!empty($config['id_configuracion'])){
			if($config['clausula']=='Analistabloqueolideres'){
				$analistaBloqueo = $config['valor'];
			}
			if($config['clausula']=='Superanalistabloqueolideres'){
				$superAnalistaBloqueo = $config['valor'];
			}
		}
	}
	if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
	if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}
	if($accesoBloqueo=="0"){
		// echo "Acceso Abierto";
	}
	if($accesoBloqueo=="1"){
		// echo "Acceso Restringido";
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
	}

	if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
		$num = number_format($_POST['val'],2,',','.');
		echo $num;
	}

	if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['observacion'])){
		$id_pago = $_POST['id_pago_modal'];
		$estado = $_POST['estado'];
		$firma = $_POST['firma'];
		if(!empty($_POST['newFirma'])){
			$firma = ucwords(mb_strtolower($_POST['newFirma']));
		}
		$observacion = $_POST['observacion'];
		$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', observacion='{$observacion}', estado='{$estado}' WHERE id_pago='$id_pago'");
		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2";
		}
		echo $response;
	}

	if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  isset($_POST['leyenda'])){
		$id_pago = $_POST['id_pago_modal'];
		$estado = $_POST['estado'];
		$firma = $_POST['firma'];
		if(!empty($_POST['newFirma'])){
			$firma = ucwords(mb_strtolower($_POST['newFirma']));
		}
		$leyenda = $_POST['leyenda'];
		$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', leyenda='{$leyenda}', estado='{$estado}' WHERE id_pago='$id_pago'");
		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2";
		}
		echo $response;
	}

	if(!empty($_POST['id_pago_modal']) && !empty($_POST['fecha_pago']) && !empty($_POST['rol']) && $_POST['rol']=="Analistas" && !empty($_POST['tipo_pago']) && isset($_POST['tasa'])){
		$id_pago = $_POST['id_pago_modal'];
		$tasa = $_POST['tasa'];
		$fecha = $_POST['fecha_pago'];
		$tasass = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '{$fecha}'");

		$pago = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago='$id_pago'");
		$pago=$pago[0];
		$equivalente_pago = "";
		$tipo_pago = ucwords(mb_strtolower($_POST['tipo_pago']));
		if($tasa!=""){
			if($pago['forma_pago']=="Divisas Dolares" || $pago['forma_pago']=="Divisas Euros" || $pago['forma_pago']=="Deposito En Dolares"){
				if($pago['estado']=="Abonado"){
					$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago='', tipo_pago='{$tipo_pago}' WHERE id_pago='$id_pago'");
				}else{
					if($fecha == $pago['fecha_pago']){
						$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago=null, tipo_pago='{$tipo_pago}' WHERE id_pago='$id_pago'");
					}else{
						$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago=null, tipo_pago='{$tipo_pago}', estado = '' WHERE id_pago='$id_pago'");
					}
				}
			}else{
				if(count($tasass)>1){
					$tassa = $tasass[0]['monto_tasa'];
					if($tasa != $tassa){
						$tasa = $tassa;
					}
				}
				$equivalente_pago = $pago['monto_pago']/$tasa;
				$equivalente_pago = number_format($equivalente_pago,2);

				if($pago['estado']=="Abonado"){
					$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago='{$tasa}', tipo_pago='{$tipo_pago}', equivalente_pago='{$equivalente_pago}' WHERE id_pago='$id_pago'");
				}else{
					if($fecha == $pago['fecha_pago']){
						$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago='{$tasa}', tipo_pago='{$tipo_pago}', equivalente_pago='{$equivalente_pago}' WHERE id_pago='$id_pago'");
					}else{
						$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tasa_pago='{$tasa}', tipo_pago='{$tipo_pago}', equivalente_pago='{$equivalente_pago}', estado = '' WHERE id_pago='$id_pago'");
					}
				}
			}
		}else{
			if($pago['estado']=="Abonado"){
				$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tipo_pago='{$tipo_pago}' WHERE id_pago='$id_pago'");
			}else{
				if($fecha == $pago['fecha_pago']){
					$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tipo_pago='{$tipo_pago}' WHERE id_pago='$id_pago'");
				}else{
					$exec = $lider->modificar("UPDATE pagos SET fecha_pago = '{$fecha}', tipo_pago='{$tipo_pago}', estado = '' WHERE id_pago='$id_pago'");
				}
			}
		}

		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2";
		}

		$paggo = $lider->consultarQuery("SELECT * FROM bancos, pagos WHERE pagos.id_pago='{$id_pago}'");
		$despp = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.id_despacho = {$id_despacho}");
		$return['exec'] = $response;
		if(count($despp)>1){
			$return['despacho'] = $despp[0];
		}
		if(count($paggo)>1){
			$return['pago'] = $paggo[0];
			$return['pago']['fecha_pago_format'] = $lider->formatFecha($paggo[0]['fecha_pago']);
			$return['pago']['tasa_pago_format'] = number_format($paggo[0]['tasa_pago'],4,',','.');
			$return['pago']['monto_pago_format'] = number_format($paggo[0]['monto_pago'],2,',','.');
			$return['pago']['equivalente_pago_format'] = number_format($paggo[0]['equivalente_pago'],2,',','.');
		}
		echo json_encode($return);
	}

	if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
		$id = $_POST['id_pago'];
		$pedido = $lider->consultarQuery("SELECT * FROm pagos, pedidos, clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago='$id'");
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

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE pagos SET estatus = 0 WHERE id_pago='$id'";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pagos', 'Borrar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}

		$reportado = 0;
		$diferido = 0;
		$abonado = 0;

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

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$sqlPagos = "SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}";
		$sqlMovimientos = "SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1";
		$fechasPromociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE estatus = 1 and id_campana = {$id_campana}");
		if(count($fechasPromociones)>1){
			$fechasPromociones = $fechasPromociones[0];
		}
		$sqlPromociones = "SELECT * FROM promocion WHERE promocion.id_campana = {$id_campana} and promocion.estatus = 1";
		if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
			$id_cliente = $_GET['lider'];
			$sqlPagos .= " and pedidos.id_cliente = {$id_cliente}";
			$sqlPromociones = "SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}";
			$sqlPromociones .= " and promociones.id_cliente = {$id_cliente}";
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
		$sqlPagos .= " and pagos.forma_pago = 'Efectivo Bolivares' ORDER BY pagos.fecha_pago ASC;";
		$pagos = $lider->consultarQuery($sqlPagos);
		$movimientos = $lider->consultarQuery($sqlMovimientos);
		$promociones = $lider->consultarQuery($sqlPromociones);

		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}");

		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");

		$resulttDescuentoNivelLider=0;
		$deudaTotal=0;
	 	$bonoContado1Puntual = 0;
	 	$bonoPagosPuntuales = 0;
	 	// $bonoPago1Puntual = 0;
	 	// $bonoCierrePuntual = 0;
	 	$bonoAcumuladoCierreEstructura = 0;
	 	$liquidacion_gemas = 0;
	 	$totalTraspasoRecibido=0;
	 	$totalTraspasoEmitidos=0;

	 	$resultDeudaPorPromociones = 0;
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
				foreach ($traspasosRecibidos as $traspas){ if(!empty($traspas['id_traspaso'])){ $totalTraspasoRecibido += $traspas['cantidad_traspaso']; } }

				$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id_pedido");
				foreach ($traspasosEmitidos as $traspas){ if(!empty($traspas['id_traspaso'])){ $totalTraspasoEmitidos += $traspas['cantidad_traspaso']; } }
			}
			$bonosContado1 = $lider->consultarQuery("SELECT * FROm bonoscontado WHERE id_pedido = $id_pedido");
	 		if(count($bonosContado1)>1){
	 			foreach ($bonosContado1 as $bono){ if(!empty($bono['totales_bono'])){ $bonoContado1Puntual += $bono['totales_bono']; } }
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
	 			foreach ($bonosCierreEstructura as $bono){ if(!empty($bono['totales_bono_cierre'])){ $bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre']; } }
	 		}
	 		$gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = $id_pedido and id_cliente = {$id_cliente}");
	 		if(count($gemas_liquidadas)>1){
	 			foreach ($gemas_liquidadas as $liquidadas){ if(!empty($liquidadas['total_descuento_gemas'])){ $liquidacion_gemas += $liquidadas['total_descuento_gemas']; } }
	 		}
	 		
			// $total = $pedido['cantidad_total'];
	 		// $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

			// $sumatoria_cantidad_aprobado = 0;
			// $sumatoria_cantidad_total = 0;
			// foreach ($pedidosAcumulados as $keyss) {
			// 	if(!empty($keyss['cantidad_aprobado'])){
			// 		// if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
			// 			// $total = $pedido['cantidad_total'];
			// 			// $sumatoria_cantidad_total += $keyss['cantidad_total'];
			// 		// }
			// 		// if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
			// 			$total = $pedido['cantidad_aprobado'];
			// 			$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
			// 		// }
			// 	}
			// }
			// // if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
			// 	// $total = $pedido['cantidad_total'];
			// 	// $total = $sumatoria_cantidad_total;
			// // }
			// // if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
			// 	$total = $pedido['cantidad_aprobado'];
			// 	$total = $sumatoria_cantidad_aprobado;
			// // }

			$sumatoria_cantidad_total_real = 0;
			$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
			foreach ($pedidosAcumulados as $keyss) {
				if(!empty($keyss['cantidad_total_alcanzada'])){
					$sumatoria_cantidad_total_real += $keyss['cantidad_total_alcanzada'];
				}
			}
			if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
				$total = $pedido['cantidad_total'];
				// $total = $sumatoria_cantidad_total;
				$total = $sumatoria_cantidad_total_real;
			}
			if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
				$total = $pedido['cantidad_aprobado'];
				$total = $sumatoria_cantidad_aprobado;
			}


			$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
			if(count($liderazgos)>1){
				$lidera = $liderazgos[0];
				foreach ($liderazgosAll as $data){ if(!empty($data['id_liderazgo'])){
					if ($lidera['id_liderazgo'] >= $data['id_liderazgo']){
						$resultNLider = $data['descuento_coleccion']*$pedido['cantidad_aprobado'];
						$resulttDescuentoNivelLider += $resultNLider;
					}
				} }
			}
			$totalAprobado = $pedido['cantidad_aprobado'];
			$deudaTotal += $totalAprobado * $pedido['precio_coleccion'];
			

			$promocionesFull = $lider->consultarQuery("SELECT * FROM clientes, pedidos, promocion, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1 and promociones.id_cliente = {$id_cliente} and promociones.id_pedido = {$id_pedido}");
			$resultDeudaPorPromociones = 0;
			foreach ($promocionesFull as $promo){ if(!empty($promo['id_promociones'])){
				$deudaPorPromocion = $promo['precio_promocion']*$promo['cantidad_aprobada_promocion'];
				$resultDeudaPorPromociones += $deudaPorPromocion;
			} }

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
		//echo $resultDeudaPorPromociones;
		$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPagosPuntuales + $totalTraspasoRecibido + $bonoAcumuladoCierreEstructura + $liquidacion_gemas;
		$nuevoTotal = $deudaTotal-$descuentosTotales + $totalTraspasoEmitidos + $resultDeudaPorPromociones;

		// echo $descuentosTotales;
		// echo "Deuda: ".$deudaTotal."<br>";
		// echo "Descuentos: ".$descuentosTotales."<br>";
		// echo "Total: ".$nuevoTotal."<br>";

		//$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and planes.estatus = 1 and pedidos.estatus = 1");

		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
		$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$despacho = $despachos[0];

		if($pagos['ejecucion']==1){
			$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			$pagosAux = [];
			$nnIndexAux = 0;
			if(count($pagos)){
				foreach ($pagos as $data){ if(!empty($data['id_pago'])){
					$permitido = "0";
					if($accesoBloqueo=="1"){
						if(!empty($accesosEstructuras)){
							foreach ($accesosEstructuras as $struct) { if(!empty($struct['id_cliente'])){
								if($struct['id_cliente']==$data['id_cliente']){
									$permitido = "1";
								}
							} }
						}
					}else if($accesoBloqueo=="0"){
						$permitido = "1";
					}

					if($permitido=="1"){
						if(!empty($_GET['Diferido'])){
							if($data['estado']=="Diferido"){
								$pagosAux[$nnIndexAux] = $data;
								$nnIndexAux++;
							}
						}
						if(!empty($_GET['Abonado'])){
							if($data['estado']=="Abonado"){
								$pagosAux[$nnIndexAux] = $data;
								$nnIndexAux++;
							}
						}
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
				} }
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