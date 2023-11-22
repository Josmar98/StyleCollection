<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
	$despacho = $despachos[0];
	
	// $pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];
	$iterRecor = 0;
	foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
		if($pagosD['tipo_pago_despacho']=="Inicial"){
			// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
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
	if(!empty($_POST)){
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$id = $_GET['lider'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
		}else{
			$id = $_SESSION['id_cliente'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1");
		}
		// print_r($_POST);
		$id_pedido = $_POST['id_pedido'];
		$dataoculta = $_POST['dataoculta'];
		$premiosPerdidos = $_POST['cantidadesPedidas'];
		$max = count($premiosPerdidos);
		$num = 1;
		$i = 0;
		$responses = [];
		$exec1 = $lider->eliminar("DELETE FROM premios_perdidos WHERE id_pedido = $id_pedido and id_cliente = $id");
		if($exec1['ejecucion']==true){
			foreach ($dataoculta as $key) {
				$premioPerdido = $premiosPerdidos[$i];	
				list($codigo, $valor, $id_tipo_coleccion, $id_tppc, $cantidad_premios_plan, $id_pedido, $id_cliente) = explode("*", $key);
				// echo "<br>";
				// echo "<b>id_pedido</b>: <i>".$id_pedido."</i><br>";
				// echo "<b>id_cliente</b>: <i>".$id_cliente."</i><br>";
				// echo "<b>codigo</b>: <i>".$codigo."</i><br>";
				// echo "<b>valor</b>: <i>".$valor."</i><br>";
				// echo "<b>id_tipo_coleccion</b>: <i>".$id_tipo_coleccion."</i><br>";
				// echo "<b>id_tppc</b>: <i>".$id_tppc."</i><br>";
				// echo "<b>cantidad_premios_plan</b>: <i>".$cantidad_premios_plan."</i><br>";
				// echo "<b>cantidad_premios_perdidos</b>: <i>".$premioPerdido."</i><br>";
				$query = "INSERT INTO premios_perdidos (id_premio_perdido, id_pedido, id_cliente, codigo, valor, id_tipo_coleccion, id_tppc, cantidad_premios_plan, cantidad_premios_perdidos, estatus) VALUES (DEFAULT, {$id_pedido}, {$id_cliente}, '{$codigo}', '{$valor}', {$id_tipo_coleccion}, {$id_tppc}, {$cantidad_premios_plan}, {$premioPerdido}, 1)";
				// echo $query."<br><br>";
				$exec = $lider->registrar($query, "premios_perdidos", "id_premio_perdido");
				if($exec['ejecucion']==true){
					$responses[$i] = "1";
				}else{
					$responses[$i] = "2";
				}
				$num++;
				$i++;
			}
		}
		$acumRes = 0;
		foreach ($responses as $key) {
			$acumRes += $key;
		}
		if($acumRes==$max){
			$response = "1";
		}else{
			$response = "2";		
		}
		// echo $response;

		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		if(count($pedidos)>1){
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		
			$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
			$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho}");
			$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

			$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT	* FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

			$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
			
			$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");

				$pagos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.estado = 'Abonado' and pagos.id_pedido = {$id_pedido}");
				$pagosRealizados = [];
				$pagosTotal = 0;
				foreach ($pagosRecorridos as $pagosR) {
					$pagosRealizados[$pagosR['id']] = 0;
					foreach ($pagos as $data){ if(!empty($data['id_pago'])){
						if(ucwords(mb_strtolower($data['tipo_pago']))==$pagosR['name']){
							$aprob = false;
							if($data['fecha_pago'] <= $pagosR['fecha_pago']){
								$aprob = true;
							}
							if($aprob==true){
								$pagosRealizados[$pagosR['id']] += $data['equivalente_pago'];
							}
						}
					}}
					$pagosTotal += $pagosRealizados[$pagosR['id']];
				}

				$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE bonoscontado.estatus = 1 and bonoscontado.id_pedido = {$id_pedido}");
				$cantidadColeccionesContado = 0;
				foreach ($bonosContado as $bono) {
					if(!empty($bono['id_bonocontado'])){
						$cantidadColeccionesContado += $bono['colecciones_bono'];
					}
				}
				$distribucionPagos = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$pedido['id_pedido']}");

				$cantidadPremiosGanados = [];
				$cantidadPremiosGanadosEnteros = [];
				$totalPremiosGanados = [];
				foreach($pagosRecorridos as $pagosR){
					$cantidadPremiosGanados[$pagosR['id']] = 0;
					$cantidadPremiosGanadosEnteros[$pagosR['id']] = 0;
					$totalPremiosGanados[$pagosR['id']] = 0;

					$cantidadDistribucion[$pagosR['id']] = 0;

					if($despacho['opcionOpcionalInicial']=="Y"){
						if(!empty($pagosR['calcular'])){
							if($pagosR['calcular']==2){
								if(!empty($pagosRealizados['inicial'])){
									$pagosRealizados[$pagosR['id']] += $pagosRealizados['inicial'];
								}
							}
						}

					}
					foreach ($distribucionPagos as $pagosDist){
						if(!empty($pagosDist['id_distribucion_pagos'])){
							if($pagosDist['tipo_distribucion']==$pagosR['name']){
								$cantidadDistribucion[$pagosR['id']] = $pagosDist['cantidad_distribucion'];
								$pagosRealizados[$pagosR['id']] += $cantidadDistribucion[$pagosR['id']];
							}
						}
					}
					$cantidadPremiosGanados[$pagosR['id']] = $pagosRealizados[$pagosR['id']] / $pagosR['precio'];
					$cantidadPremiosGanadosEnteros[$pagosR['id']] = intval($cantidadPremiosGanados[$pagosR['id']]);
					$totalPremiosGanados[$pagosR['id']] = $cantidadPremiosGanadosEnteros[$pagosR['id']] + $cantidadColeccionesContado;
					if($totalPremiosGanados[$pagosR['id']] > $pedido['cantidad_aprobado']){
						$totalPremiosGanados[$pagosR['id']] = $pedido['cantidad_aprobado'];
					}

				}

			// =============================================================================================================== //

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
		// }else{
			    // require_once 'public/views/error404.php';
	}
	if(empty($_POST)){

		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$id = $_GET['lider'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
		}else{
			$id = $_SESSION['id_cliente'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1");
		}
		// if(!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==0){
		// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
		// }else{
		// }
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
		// foreach ($pedido as $data){ 
		// 	if(!empty($data['id_pedido'])){
		// 		echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']. " <br> " . $data['cantidad_aprobado']." Colecciones Aprobadas<br><br>" ;
		// 		foreach ($planesCol as $data2) {
		// 			if($data['id_pedido'] == $data2['id_pedido']){
		// 				if($data2['cantidad_coleccion_plan']>0){
		// 					$colecciones = $data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan'];
		// 					echo $colecciones." Colecciones de Plan ".$data2['nombre_plan']."<br>";
		// 					echo "<br>";
		// 					foreach ($premioscol as $data3) {
		// 						if(!empty($data3['id_premio'])){
		// 							if($data2['id_plan']==$data3['id_plan']){
		// 								if($data['id_pedido']==$data3['id_pedido']){
		// 									if($data3['cantidad_premios_plan']>0){
		// 										echo " - ".$data3['cantidad_premios_plan']." ".$data3['nombre_premio']."<br>";
		// 										// echo "<br>";
		// 									}
		// 								}
		// 							}
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");

		if(count($pedidos)>1){

			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		
			$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} ORDER BY planes.id_plan ASC;");
			$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id}");
			$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

			$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT	* FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

			$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
			
			$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
		
			// // =============================================================================================================== //
			// 	// echo "Id Pedido: ".$id_pedido."<br>";
			// 	$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
			// 	$despacho = $despachos[0];

			// 	$precioInicial = $despacho['inicial_precio_coleccion'];
			// 	$precioPrimer = $despacho['primer_precio_coleccion'];
			// 	$precioSegundo = $despacho['segundo_precio_coleccion'];
			// 	$precioColeccion = $despacho['precio_coleccion'];

			// 	$pagos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.estado = 'Abonado' and pagos.id_pedido = {$id_pedido}");
			// 	// echo "Registros: ";
			// 	// echo count($pagos);
			// 	// echo "<br><br>";
			// 	$pagosContado = 0;
			// 	$pagosInicial = 0;
			// 	$pagosPrimer = 0;
			// 	$pagosSegundo = 0;
			// 	$pagosTotal = 0;
			// 	$countPrimer = 0;
			// 	foreach ($pagos as $data) {
			// 		if (!empty($data['id_pago'])) {
			// 			$pagosTotal += $data['equivalente_pago'];
			// 			if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="CONTADO" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="cONTADO"){
			// 				$pagosContado += $data['equivalente_pago'];
			// 			}
			// 			if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="INICIAL" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="iNICIAL"){
			// 				$pagosInicial += $data['equivalente_pago'];
			// 			}
			// 			if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="PRIMER PAGO" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="pRIMER pAGO"){
			// 				if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
			// 					$temporalidad = "Puntual";
			// 				}else{
			// 					$temporalidad = "Impuntual";
			// 				}
			// 				if($temporalidad=="Puntual"){
			// 				$countPrimer++;
			// 					$pagosPrimer += $data['equivalente_pago'];
			// 				}
			// 			}
			// 			if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="SEGUNDO PAGO" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="sEGUNDO pAGO"){
			// 				$pagosSegundo += $data['equivalente_pago'];
			// 			}
			// 		}
			// 	}
			// 	$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE bonoscontado.estatus = 1 and bonoscontado.id_pedido = {$id_pedido}");
			// 	$cantidadColeccionesContado = 0;
			// 	foreach ($bonosContado as $bono) {
			// 		if(!empty($bono['id_bonocontado'])){
			// 			$cantidadColeccionesContado += $bono['colecciones_bono'];
			// 		}
			// 	}

			// 	$inicialGanadas = 0;
			// 	$primerPagoGanadas = 0;
			// 	$segundoPagoGanadas = 0;

			// 	$inicialGanadas = $pagosInicial/$precioInicial;
			// 	$primerPagoGanadas = $pagosPrimer/$precioPrimer;
			// 	$segundoPagoGanadas = $pagosSegundo/$precioSegundo;

			// 	$inicialGanadasEnteros = intval($inicialGanadas); 
			// 	$primerPagoGanadasEnteros = intval($primerPagoGanadas); 
			// 	$segundoPagoGanadasEnteros = intval($segundoPagoGanadas); 

			// 	$totalInicales = $inicialGanadasEnteros + $cantidadColeccionesContado;
			// 	$totalPrimerPago = $primerPagoGanadasEnteros + $cantidadColeccionesContado;
			// 	$totalSegundoPago = $segundoPagoGanadasEnteros + $cantidadColeccionesContado;


			// 	// echo "Total en pagos Contado: ".$pagosContado."<br>";
			// 	// echo "Total en pagos Inicial: ".$pagosInicial."<br>";
			// 	// echo "Total en pagos Primer: ".$pagosPrimer."<br>";
			// 	// echo "Total en pagos Segundo: ".$pagosSegundo."<br>";
			// 	// echo "Total en pagos Abonados: ".$pagosTotal."<br>";
				
			// 	// // echo "<br><br>";
			// 	// // print_r($despacho);
			// 	// echo "<br>";
				
			// 	// echo "Precio de Inicial: ".$precioInicial."<br>";
			// 	// echo "Precio de Primer Pago: ".$precioPrimer."<br>";
			// 	// echo "Precio de Segundo Pago: ".$precioSegundo."<br>";
			// 	// echo "Precio de Coleccion Completa: ".$precioColeccion."<br>";
			// 	// echo "<br>";

			// 	// echo "Cantidad de Colecciones de Contado: ".$cantidadColeccionesContado."<br>";


			// 	// echo "<br>";
			// 	// echo "Iniciales Ganadas: ".$inicialGanadas."<br>";
			// 	// echo "Primer Pago Ganados: ".$primerPagoGanadas."<br>";
			// 	// echo "Segundo Pago Ganados: ".$segundoPagoGanadas."<br>";

			// 	// echo "<br>";
			// 	// echo "Iniciales Ganadas Enteros: ".$inicialGanadasEnteros."<br>";
			// 	// echo "Primer Pago Ganados Enteros: ".$primerPagoGanadasEnteros."<br>";
			// 	// echo "Segundo Pago Ganados Enteros: ".$segundoPagoGanadasEnteros."<br>";

			// 	// echo "TOTAL DE INICIALES: ".$totalInicales."<br>";
			// 	// echo "TOTAL DE PRIMER PAGO: ".$totalPrimerPago."<br>";
			// 	// echo "TOTAL DE SEGUNDO PAGO: ".$totalSegundoPago."<br>";
			// 	// echo "<br>";
			// 	if($totalInicales > $pedido['cantidad_aprobado']){
			// 		$totalInicales = $pedido['cantidad_aprobado'];
			// 	}
			// 	if($totalPrimerPago > $pedido['cantidad_aprobado']){
			// 		$totalPrimerPago = $pedido['cantidad_aprobado'];
			// 	}
			// 	if($totalSegundoPago > $pedido['cantidad_aprobado']){
			// 		$totalSegundoPago = $pedido['cantidad_aprobado'];
			// 	}
			// // =============================================================================================================== //

			// =============================================================================================================== //
				// echo "Id Pedido: ".$id_pedido."<br>";
				// $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
				// $despacho = $despachos[0];

				// $pagosRecorridos[1]['fecha_pago'] = "2022-12-01";

				// ##################
				// $precioInicial = $despacho['inicial_precio_coleccion'];
				// $precioPrimer = $despacho['primer_precio_coleccion'];
				// $precioSegundo = $despacho['segundo_precio_coleccion'];
				// $precioColeccion = $despacho['precio_coleccion'];
				
				// echo "<br>";
				// echo "Coleccion: ".$precioColeccion."<br>";
				// echo "Precio: ".$precioSegundo."<br>";
				// echo "Precio: ".$pagosRecorridos[2]['precio']."<br>";
				// ##################

				$pagos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.estado = 'Abonado' and pagos.id_pedido = {$id_pedido}");
				$pagosRealizados = [];
				$pagosTotal = 0;
				foreach ($pagosRecorridos as $pagosR) {
					$pagosRealizados[$pagosR['id']] = 0;
					foreach ($pagos as $data){ if(!empty($data['id_pago'])){
						if(ucwords(mb_strtolower($data['tipo_pago']))==$pagosR['name']){
							$aprob = false;
							if($data['fecha_pago'] <= $pagosR['fecha_pago']){
								$aprob = true;
							}
							if($aprob==true){
								$pagosRealizados[$pagosR['id']] += $data['equivalente_pago'];
							}
						}
					}}
					$pagosTotal += $pagosRealizados[$pagosR['id']];
				}

				// ##################
				// $pagosContado = 0;
				// $pagosInicial = 0;
				// $pagosPrimer = 0;
				// $pagosSegundo = 0;
				// $pagosTotal = 0;
				// $countPrimer = 0;
				// foreach ($pagos as $data) {
				// 	if (!empty($data['id_pago'])) {
				// 		$pagosTotal += $data['equivalente_pago'];
				// 		if(ucwords(mb_strtolower($data['tipo_pago']))=="Contado"){
				// 			$pagosContado += $data['equivalente_pago'];
				// 		}
				// 		if(ucwords(mb_strtolower($data['tipo_pago']))=="Inicial"){
				// 			$pagosInicial += $data['equivalente_pago'];
				// 		}
				// 		if(ucwords(mb_strtolower($data['tipo_pago']))=="Primer Pago"){
				// 			if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
				// 				$temporalidad = "Puntual";
				// 			}else{
				// 				$temporalidad = "Impuntual";
				// 			}
				// 			if($temporalidad=="Puntual"){
				// 			$countPrimer++;
				// 				$pagosPrimer += $data['equivalente_pago'];
				// 			}
				// 		}
				// 		if(ucwords(mb_strtolower($data['tipo_pago']))=="Segundo Pago"){
				// 			$pagosSegundo += $data['equivalente_pago'];
				// 		}
				// 	}
				// }
				// ##################


				$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE bonoscontado.estatus = 1 and bonoscontado.id_pedido = {$id_pedido}");
				$cantidadColeccionesContado = 0;
				foreach ($bonosContado as $bono) {
					if(!empty($bono['id_bonocontado'])){
						$cantidadColeccionesContado += $bono['colecciones_bono'];
					}
				}
				$distribucionPagos = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$pedido['id_pedido']}");
				// $distPagosEqv = 0;
				// foreach ($distribucionPagos as $dist) {
				// 	if(!empty($dist['id_distribucion_pagos'])){
				// 		$distPagosEqv += $dist['cantidad_distribucion'];
				// 	}
				// }

				// $totalesDistribucion[$pagosR['id']] = 0;
	            //               $totalporcentajesDistribucion[$pagosR['id']] = 0;
	            //               $cantidadDistribucion[$pagosR['id']] = 0;
	            //               $cantidadDistribucionPremio[$pagosR['id']] = 0;
	            //               if(!empty($_GET['lider'])){
	            //                 foreach ($distribucionPagos as $pagosDist) {
	            //                   if(!empty($pagosDist['id_distribucion_pagos'])){
	            //                     if($pagosDist['tipo_distribucion']==$pagosR['name']){
	            //                       $cantidadDistribucion[$pagosR['id']] = $pagosDist['cantidad_distribucion'];
	            //                     }
	            //                   }
	            //                 }
	            //               }

				$cantidadPremiosGanados = [];
				$cantidadPremiosGanadosEnteros = [];
				$totalPremiosGanados = [];
				foreach($pagosRecorridos as $pagosR){
					$cantidadPremiosGanados[$pagosR['id']] = 0;
					$cantidadPremiosGanadosEnteros[$pagosR['id']] = 0;
					$totalPremiosGanados[$pagosR['id']] = 0;

					$cantidadDistribucion[$pagosR['id']] = 0;
					
					// echo "| ".$pagosR['name']." | ";
					// echo "<br>";
					// echo "Abonado: ".$pagosRealizados[$pagosR['id']];
					// echo "<br>";
					if($despacho['opcionOpcionalInicial']=="Y"){
						if(!empty($pagosR['calcular'])){
							if($pagosR['calcular']==2){
								if(!empty($pagosRealizados['inicial'])){
									$pagosRealizados[$pagosR['id']] += $pagosRealizados['inicial'];
								}
							}
						}
						// if(!empty($pagosR['calcular'])){
						// 	if($pagosR['calcular']==2){
						// 		echo "Abono de Dependencia: ".$pagosRealizados['inicial'];
						// 		echo "<br>";
						// 		echo "Nuevo Real: ".$pagosRealizados[$pagosR['id']];
						// 		echo "<br>";
						// 	}
						// }
					}
					foreach ($distribucionPagos as $pagosDist){
						if(!empty($pagosDist['id_distribucion_pagos'])){
							if($pagosDist['tipo_distribucion']==$pagosR['name']){
								$cantidadDistribucion[$pagosR['id']] = $pagosDist['cantidad_distribucion'];
								$pagosRealizados[$pagosR['id']] += $cantidadDistribucion[$pagosR['id']];
							}
						}
					}
					$cantidadPremiosGanados[$pagosR['id']] = $pagosRealizados[$pagosR['id']] / $pagosR['precio'];
					$cantidadPremiosGanadosEnteros[$pagosR['id']] = intval($cantidadPremiosGanados[$pagosR['id']]);
					$totalPremiosGanados[$pagosR['id']] = $cantidadPremiosGanadosEnteros[$pagosR['id']] + $cantidadColeccionesContado;
					// echo "Distribuido: ".$cantidadDistribucion[$pagosR['id']];
					// echo "<br>";
					// echo "Abonado Real: ".$pagosRealizados[$pagosR['id']];
					// echo "<br>";
					// echo $pagosRealizados[$pagosR['id']];
					// echo " / ";
					// echo $pagosR['precio'];
					// echo " = ";
					// echo "<b>".$cantidadPremiosGanados[$pagosR['id']]."</b>";
					// echo "<br>";
					// echo "Entero: ".$cantidadPremiosGanadosEnteros[$pagosR['id']];
					// echo "<br>";
					// echo "Total: <b>".$totalPremiosGanados[$pagosR['id']]."</b>";
					// echo "<br>";
					if($totalPremiosGanados[$pagosR['id']] > $pedido['cantidad_aprobado']){
						$totalPremiosGanados[$pagosR['id']] = $pedido['cantidad_aprobado'];
					}
					// echo "Total: <b>".$totalPremiosGanados[$pagosR['id']]." Premios Ganados"."</b>";
					// echo "<br>";
					// echo "<br>";
				}

				// print_r($cantidadPremiosGanados);


				// $inicialGanadas = 0;
				// $primerPagoGanadas = 0;
				// $segundoPagoGanadas = 0;

				// $inicialGanadas = $pagosInicial/$precioInicial;
				// $primerPagoGanadas = $pagosPrimer/$precioPrimer;
				// $segundoPagoGanadas = $pagosSegundo/$precioSegundo;

				// $inicialGanadasEnteros = intval($inicialGanadas); 
				// $primerPagoGanadasEnteros = intval($primerPagoGanadas); 
				// $segundoPagoGanadasEnteros = intval($segundoPagoGanadas); 

				// $totalInicales = $inicialGanadasEnteros + $cantidadColeccionesContado;
				// $totalPrimerPago = $primerPagoGanadasEnteros + $cantidadColeccionesContado;
				// $totalSegundoPago = $segundoPagoGanadasEnteros + $cantidadColeccionesContado;


				// echo "Total en pagos Contado: ".$pagosContado."<br>";
				// echo "Total en pagos Inicial: ".$pagosInicial."<br>";
				// echo "Total en pagos Primer: ".$pagosPrimer."<br>";
				// echo "Total en pagos Segundo: ".$pagosSegundo."<br>";
				// echo "Total en pagos Abonados: ".$pagosTotal."<br>";
				
				// // echo "<br><br>";
				// // print_r($despacho);
				// echo "<br>";
				
				// echo "Precio de Inicial: ".$precioInicial."<br>";
				// echo "Precio de Primer Pago: ".$precioPrimer."<br>";
				// echo "Precio de Segundo Pago: ".$precioSegundo."<br>";
				// echo "Precio de Coleccion Completa: ".$precioColeccion."<br>";
				// echo "<br>";

				// echo "Cantidad de Colecciones de Contado: ".$cantidadColeccionesContado."<br>";


				// echo "<br>";
				// echo "Iniciales Ganadas: ".$inicialGanadas."<br>";
				// echo "Primer Pago Ganados: ".$primerPagoGanadas."<br>";
				// echo "Segundo Pago Ganados: ".$segundoPagoGanadas."<br>";

				// echo "<br>";
				// echo "Iniciales Ganadas Enteros: ".$inicialGanadasEnteros."<br>";
				// echo "Primer Pago Ganados Enteros: ".$primerPagoGanadasEnteros."<br>";
				// echo "Segundo Pago Ganados Enteros: ".$segundoPagoGanadasEnteros."<br>";

				// echo "<br>";
				// echo "TOTAL DE INICIALES: ".$totalInicales."<br>";
				// echo "TOTAL DE PRIMER PAGO: ".$totalPrimerPago."<br>";
				// echo "TOTAL DE SEGUNDO PAGO: ".$totalSegundoPago."<br>";
				// echo "<br>";
				// echo $pedido['cantidad_aprobado'];
				// if($totalInicales > $pedido['cantidad_aprobado']){
				// 	$totalInicales = $pedido['cantidad_aprobado'];
				// }
				// if($totalPrimerPago > $pedido['cantidad_aprobado']){
				// 	$totalPrimerPago = $pedido['cantidad_aprobado'];
				// }
				// if($totalSegundoPago > $pedido['cantidad_aprobado']){
				// 	$totalSegundoPago = $pedido['cantidad_aprobado'];
				// }
			// =============================================================================================================== //
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
		// }else{
			    // require_once 'public/views/error404.php';
		// }

	}
}else{
   require_once 'public/views/error404.php';
}
// id_premio, nombre_premio, precio_premio, descripcion_premio, id_ppc, id_plan_campana, tipo_premio, tipo_premio_producto 
// premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto 
?>