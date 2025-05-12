<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
	$_SESSION['tomandoEnCuentaLiderazgo'] = "1";

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


	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){
	if(!empty($_POST['validarData'])){
		$id_liderazgo = $_POST['id_liderazgo'];
		$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1";
		$res1 = $lider->consultarQuery($query);
		if($res1['ejecucion']==true){
			if(Count($res1)>1){
				$response = "9"; //echo "Registro ya guardado.";
			  // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
		   //    if($res2['ejecucion']==true){
		   //      if(Count($res2)>1){
		   //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
		   //        if($res3['ejecucion']==true){
		   //          $response = "1";
		   //        }
		   //      }else{
		   //        $response = "9"; //echo "Registro ya guardado.";
		   //      }
		   //    }


			}else{
				$response = "1";
			}
		}else{
			$response = "5"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	if(!empty($_POST['cantidad_plan']) && !empty($_POST['id_pedido'])){
		// print_r($_POST);

		$id_pedido = $_POST['id_pedido'];
		$id_cliente = $_POST['id_cliente'];
		$cantidad_plan = $_POST['cantidad_plan'];
		$id_reto_campana = $_POST['id_reto_campana'];
		$max = count($id_reto_campana);

		// echo "/";
		// echo $id_pedido;
		// echo "<br>";
		// print_r($cantidad_plan);
		// echo "<br>";
		// print_r($id_plan_campana);

		// $forma_pago = ucwords(mb_strtolower($_POST['forma']));
		// $fecha_emision = $_POST['fecha1'];
		// $fecha_vencimiento = $_POST['fecha2'];
		// $query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho";
		// $pedidos = $lider->consultarQuery($query);
		// $numero_factura = Count($pedidos);
		
		$lider->consultarQuery("DELETE FROM retos WHERE id_cliente = {$id_cliente} and id_campana = {$id_campana}");

		// $lider->consultarQuery("DELETE FROM retos WHERE id_pedido = {$id_pedido} and id_cliente = {$id_cliente} and id_campana = {$id_campana}");
		$i=0;
		$responses = [];
		foreach ($id_reto_campana as $id_reto_campana) {
			$buscar = $lider->consultarQuery("SELECT * FROM retos WHERE id_reto_campana = $id_reto_campana and id_pedido = {$id_pedido} and id_cliente = {$id_cliente} and cantidad_coleccion = {$cantidad_plan[$i]}");
			if($buscar['ejecucion'] == 1 && Count($buscar)>1){
				$responses[$i] = "1";
			}else{
				$query = "INSERT INTO retos (id_reto, id_reto_campana, id_pedido, id_cliente, id_campana, cantidad_retos, estatus) VALUES (DEFAULT, $id_reto_campana, {$id_pedido}, {$id_cliente}, {$id_campana}, {$cantidad_plan[$i]}, 1)";
				$exec = $lider->registrar($query, "retos", "id_reto");
				if($exec['ejecucion']==true){
					$responses[$i] = "1";
				}else{
					$responses[$i] = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}
			$i++;
		}
		$sum = 0;
		foreach ($responses as $key) {
			$sum += $key;
		}
		if($sum==$max){
			$response = "1";
		}else{
			$response = "2";
		}

		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista Supervisor")){
			$id = $_GET['lider'];
		}else{
			$id = $_SESSION['id_cliente'];
		}
		// $pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		$pedido = $lider->consultarQuery("SELECT * FROM despachos, pedidos, clientes WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$id}");
		$cantidad_colecciones = 0;
		if(Count($pedido)>1){
			$retos = $lider->consultarQuery("SELECT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} ORDER BY retos_campana.cantidad_coleccion ASC");
			// print_r($retos);
			foreach ($pedido as $keys) {
				if(!empty($keys['id_pedido'])){
					$cantidad_colecciones += $keys['cantidad_aprobado'];
				}
			}
			$pedido = $pedido[0];

			$id_pedido = $pedido['id_pedido'];
			// ======================================= // ======================================== // =================================== //
				$resulttDescuentoNivelLider=0;
				$deudaTotal=0;
			 	$bonoContado1Puntual = 0;
			 	$bonoPagosPuntuales = 0;
			 	$bonoAcumuladoCierreEstructura = 0;
			 	$liquidacion_gemas = 0;
			 	$totalTraspasoRecibido=0;
			 	$totalTraspasoEmitidos=0;
				$abonado_lider_gemas = 0;
				$fechaPagoLimiteFinal = $pagosRecorridos[count($pagosRecorridos)-1]['fecha_pago'];
				$fecha_pago_cierre_lider = "";
				// foreach ($pagosRecorridos as $pagosR) {
				// 	$fechaPagoConceptoAct = $pagosR['fecha_pago'];
				// 	$conceptoPagoConceptoAct = $pagosR['name'];
				// 	$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id_pedido} and estado = 'Abonado' and tipo_pago = '{$conceptoPagoConceptoAct}' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
				// 	if(count($pagosGemas)>1){
				// 		$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
				// 		foreach ($pagosGemas as $key) {
				// 			if(!empty($key['fecha_pago'])){
				// 				$abonado_lider_gemas += $key['equivalente_pago']; 
				// 			}
				// 		}
				// 	}
				// }
				foreach ($pagosRecorridos as $pagosR) {
					$fechaPagoConceptoAct = $pagosR['fecha_pago'];
				}
				$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id_pedido} and estado = 'Abonado' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
				if(count($pagosGemas)>1){
					$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
					foreach ($pagosGemas as $key) {
						if(!empty($key['fecha_pago'])){
							$abonado_lider_gemas += $key['equivalente_pago']; 
						}
					}
				}


				$totalAprobado = $pedido['cantidad_aprobado'];
				$deudaTotal += $totalAprobado * $pedido['precio_coleccion'];
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
		 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id_pedido");
		 		if(count($bonosCierreEstructura)>1){
		 			foreach ($bonosCierreEstructura as $bono){ if(!empty($bono['totales_bono_cierre'])){ $bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre']; } }
		 		}
		 		$gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id}");
		 		if(count($gemas_liquidadas)>1){
		 			foreach ($gemas_liquidadas as $liquidadas){ if(!empty($liquidadas['total_descuento_gemas'])){ $liquidacion_gemas += $liquidadas['total_descuento_gemas']; } }
		 		}

		 		$sumatoria_cantidad_total_real = 0;
				$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id}");
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
				$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}");
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
				$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho}");
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
				$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPagosPuntuales + $totalTraspasoRecibido + $bonoAcumuladoCierreEstructura + $liquidacion_gemas;
				$nuevoTotal = $deudaTotal-$descuentosTotales + $totalTraspasoEmitidos;
				
				if($pedido['total_pagar']>0){
					$nuevoTotal=$pedido['total_pagar'];
				}
				
				$porcentajeAbonadoPuntual = ($abonado_lider_gemas*100)/$nuevoTotal;
				if($porcentajeAbonadoPuntual>=100){
					$porcentajeAbonadoPuntual = 100.01;
				}
				// echo "<br>";
				// echo $cantidad_colecciones;
				// echo "<br>";
				// echo $porcentajeAbonadoPuntual;
				// echo "<br>";
				$coleccionesPuntuales = ($cantidad_colecciones/100)*$porcentajeAbonadoPuntual;
				$porcentajeAbonadoPuntualRed = number_format($porcentajeAbonadoPuntual,2,',','.');
				$coleccionesPuntualesRed = intval($coleccionesPuntuales);
				$coleccionesPuntualesRed = number_format($coleccionesPuntuales,0,',','.');
				// ============================== // ================================== // ============================== //
				// echo "Coleccion: ".$totalAprobado."<br>";
				// echo "Responsabilidad: ".$deudaTotal."<br>";
				// echo "Abonado POR EL LIDER: ".$abonado_lider_gemas."<br>";  // 3210
				// echo "FECHA DE ULTIMO PAGO Abonado PUNTUAL POR EL LIDER: ".$fecha_pago_cierre_lider."<br>"; // 2023-03-07
				// echo "NUevo TOTAL : ".$nuevoTotal."<br>";
				// echo "Abonado Puntual: ".$abonado_lider_gemas."<br>";
				// echo $pedido['cantidad_aprobado']." Cols => 100%<br>";
				// echo $coleccionesPuntualesRed." Cols => ".$porcentajeAbonadoPuntualRed."%<br>";
				// ============================== // ================================== // ============================== //
			// ======================================= // ======================================== // =================================== //
		}
		$liderRetos = $lider->consultarQuery("SELECT * FROM clientes, retos, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and retos.id_cliente = clientes.id_cliente and retos.id_pedido = pedidos.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1");
		$lideres = $lider->consultarQuery("SELECT DISTINCT clientes.id_cliente, clientes.primer_nombre, clientes.segundo_nombre, clientes.primer_apellido, clientes.segundo_apellido, clientes.cedula  FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and despachos.id_campana = {$id_campana} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
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


		// print_r($exec);
	}


	if(empty($_POST)){

		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor")){
			$id = $_GET['lider'];
		}else{
			$id = $_SESSION['id_cliente'];
		}
		$pedido = $lider->consultarQuery("SELECT * FROM despachos, pedidos, clientes WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$id}");
		$cantidad_colecciones = 0;
		if(Count($pedido)>1){
			$retos = $lider->consultarQuery("SELECT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} ORDER BY retos_campana.cantidad_coleccion ASC");

			$auxIdx = 0;
			$index = -1;
			foreach ($pedido as $keys) {
				if(!empty($keys['id_pedido'])){
					if($keys['cantidad_aprobado']!="0"){
						if($index == -1 ){
							$index = $auxIdx;
						}
					}
					$auxIdx++;
					$cantidad_colecciones += $keys['cantidad_aprobado'];
				}
			}
			$pedido = $pedido[$index];
			$id_pedido = $pedido['id_pedido'];

			// ======================================= // ======================================== // =================================== //
				$resulttDescuentoNivelLider=0;
				$deudaTotal=0;
			 	$bonoContado1Puntual = 0;
			 	$bonoPagosPuntuales = 0;
			 	$bonoAcumuladoCierreEstructura = 0;
			 	$liquidacion_gemas = 0;
			 	$totalTraspasoRecibido=0;
			 	$totalTraspasoEmitidos=0;
				$abonado_lider_gemas = 0;
				$fechaPagoLimiteFinal = $pagosRecorridos[count($pagosRecorridos)-1]['fecha_pago'];
				$fecha_pago_cierre_lider = "";
				// foreach ($pagosRecorridos as $pagosR) {
				// 	$fechaPagoConceptoAct = $pagosR['fecha_pago'];
				// 	$conceptoPagoConceptoAct = $pagosR['name'];
				// 	$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id_pedido} and estado = 'Abonado' and tipo_pago = '{$conceptoPagoConceptoAct}' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
				// 	if(count($pagosGemas)>1){
				// 		$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
				// 		foreach ($pagosGemas as $key) {
				// 			if(!empty($key['fecha_pago'])){
				// 				$abonado_lider_gemas += $key['equivalente_pago']; 
				// 			}
				// 		}
				// 	}
				// }
				foreach ($pagosRecorridos as $pagosR) {
					$fechaPagoConceptoAct = $pagosR['fecha_pago'];
				}
				$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id_pedido} and estado = 'Abonado' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
				if(count($pagosGemas)>1){
					$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
					foreach ($pagosGemas as $key) {
						if(!empty($key['fecha_pago'])){
							$abonado_lider_gemas += $key['equivalente_pago']; 
						}
					}
				}

				$totalAprobado = $pedido['cantidad_aprobado'];
				$deudaTotal += $totalAprobado * $pedido['precio_coleccion'];
				// echo "deudaTotal: ".$deudaTotal."<br>";
				
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
		 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id_pedido");
		 		if(count($bonosCierreEstructura)>1){
		 			foreach ($bonosCierreEstructura as $bono){ if(!empty($bono['totales_bono_cierre'])){ $bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre']; } }
		 		}
		 		$gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id}");
		 		if(count($gemas_liquidadas)>1){
		 			foreach ($gemas_liquidadas as $liquidadas){ if(!empty($liquidadas['total_descuento_gemas'])){ $liquidacion_gemas += $liquidadas['total_descuento_gemas']; } }
		 		}



		 		$sumatoria_cantidad_total_real = 0;
				$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id}");
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
				$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}");
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
				$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho}");
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
				$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPagosPuntuales + $totalTraspasoRecibido + $bonoAcumuladoCierreEstructura + $liquidacion_gemas;
				$nuevoTotal = $deudaTotal-$descuentosTotales + $totalTraspasoEmitidos;

				if($pedido['total_pagar']!=0){
					$nuevoTotal=$pedido['total_pagar'];
				}
				// echo $abonado_lider_gemas;
				if($nuevoTotal>0){
					$porcentajeAbonadoPuntual = ($abonado_lider_gemas*100)/$nuevoTotal;
				}else{
					if($abonado_lider_gemas>=$nuevoTotal){
						$porcentajeAbonadoPuntual = 100;
					}
				}
				// echo "<br>".$porcentajeAbonadoPuntual."<br>";
				if($porcentajeAbonadoPuntual>=100){
					$porcentajeAbonadoPuntual = 100.01;
				}
				// echo "nuevoTotal: ".$nuevoTotal."<br>";
				// echo "porcentajeAbonadoPuntual: ".$porcentajeAbonadoPuntual."<br>";
				// echo "<br>";
				// echo $cantidad_colecciones;
				// echo "<br>";
				// echo $porcentajeAbonadoPuntual;
				// echo "<br>";

				$coleccionesPuntuales = ($cantidad_colecciones/100)*$porcentajeAbonadoPuntual;
				$porcentajeAbonadoPuntualRed = number_format($porcentajeAbonadoPuntual,2,',','.');
				$coleccionesPuntualesRed = intval($coleccionesPuntuales);
				$coleccionesPuntualesRed = number_format($coleccionesPuntuales,0,',','.');
				// echo "<br>".$coleccionesPuntualesRed."<br>";
				// echo "<br>".$abonado_lider_gemas;
				// echo "<br>".$nuevoTotal;
				// echo "<br>".$porcentajeAbonadoPuntual;
				// echo "<br>".$coleccionesPuntuales;
				// echo "<br>".$porcentajeAbonadoPuntualRed;
				// echo "<br>".$coleccionesPuntualesRed;
				// echo "<br>".$coleccionesPuntuales;
				// ============================== // ================================== // ============================== //
				// echo "Coleccion: ".$totalAprobado."<br>";
				// echo "Responsabilidad: ".$deudaTotal."<br>";
				// echo "Descuentos: ".$descuentosTotales."<br>";
				// echo "Abonado POR EL LIDER: ".$abonado_lider_gemas."<br>";  // 3210
				// echo "FECHA DE ULTIMO PAGO Abonado PUNTUAL POR EL LIDER: ".$fecha_pago_cierre_lider."<br>"; // 2023-03-07
				// echo "NUevo TOTAL : ".$nuevoTotal."<br>";
				// echo "Abonado Puntual: ".$abonado_lider_gemas."<br>";
				// echo $pedido['cantidad_aprobado']." Cols => 100%<br>";
				// echo $coleccionesPuntualesRed." Cols => ".$porcentajeAbonadoPuntualRed."%<br>";
				// ============================== // ================================== // ============================== //
			// ======================================= // ======================================== // =================================== //

		}

		$liderRetos = $lider->consultarQuery("SELECT * FROM clientes, retos, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and retos.id_cliente = clientes.id_cliente and retos.id_pedido = pedidos.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1");
		
		$lideres = $lider->consultarQuery("SELECT DISTINCT clientes.id_cliente, clientes.primer_nombre, clientes.segundo_nombre, clientes.primer_apellido, clientes.segundo_apellido, clientes.cedula  FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and despachos.id_campana = {$id_campana} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

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

	}
}else{
   require_once 'public/views/error404.php';
}

?>