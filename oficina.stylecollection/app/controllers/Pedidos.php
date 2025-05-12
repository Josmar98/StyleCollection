<?php 
	
	$varMinimaColeccionesParaGemas = 30;


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

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	$pedidosVer = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
	$pedidoVer = $pedidosVer[0];
		
	$id_clienteVer = $pedidoVer['id_cliente'];
	$pedidosAcumuladosVer = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_clienteVer}");
	$cantidad_acumuladaVer = 0;
	foreach ($pedidosAcumuladosVer as $keyss) {
		if(!empty($keyss['id_pedido'])){
			$cantidad_acumuladaVer += $keyss['cantidad_aprobado'];
		}
	}


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

	// if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" ){
	// 	$campanas=$lider->consultar("campanas");
	// }else{
	// 	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1");
	// }

	// print_r($_POST);
	$_SESSION['tomandoEnCuentaLiderazgo'] = "1"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
	$_SESSION['tomandoEnCuentaDistribucion'] = "0"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
	// if($_SESSION['nombre_rol']!="Vendedor")

	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
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

	// echo " - ID: ".$id." - ";
	$permitir = "1";
	if($accesoBloqueo=="1"){
		$permitir = "0";
		if(Count($pedidos)>1){
			$pedido=$pedidos[0];
			if(!empty($accesosEstructuras)){
				foreach ($accesosEstructuras as $struct) {
					if(!empty($struct['id_cliente'])){
						// echo "<br> Struct: ".$struct['id_cliente']."";
						if($struct['id_cliente']==$pedido['id_cliente']){
							$permitir = "1";
						}
					}
				}
			}
		}
	}


if($permitir=="1"){
	$accesoSinPost = "0";
	$accesoSinPostPago = "0";
	if($_SESSION['nombre_rol']!="Vendedor" || ($_SESSION['nombre_rol']=="Vendedor" && $pedidos[0]['id_cliente']==$_SESSION['id_cliente'])){
		$accesoSinPostPago = "1";
		$accesoSinPost = "1";
	}else{
		$_SESSION['ids_general_estructuraID'] = [];
		$_SESSION['id_despacho'] = $id_despacho;
		consultarEstructuraID($_SESSION['id_cliente'], $lider);

		$estructuraHijos = $_SESSION['ids_general_estructuraID'];
		// $idTem = $_SESSION['id_cliente'];
		// $pedidosPerson = $lider->consultarQuery("SELECT id_cliente, id_pedido FROM pedidos WHERE id_despacho = $id_despacho and id_cliente = $idTem");
		// $index = count($estructuraHijos);
		// $estructuraHijos[$index] = $pedidosPerson[0];
		// print_r($estructuraHijos);
		foreach ($estructuraHijos as $struct) {
			if($struct['id_pedido']==$id){
				$accesoSinPost = "1";
			}
		}
	}
	// echo " WEEEE ESE ES EL ACCESOOOO ".$accesoSinPost." COJE DATOOOO <br><br> ";

	if(!empty($_POST['id_cliente']) && !empty($_POST['id']) && !empty($_POST['descuentos']) && isset($_POST['valores']) && isset($_POST['totales'])){
		// print_r($_POST);
		$id_pedido = $_POST['id_pedido_modal'];
		$id_cliente = $_POST['id_cliente'];
		
		####
		// $liderEstruct = explode("-", $_POST['id_cliente']);
		// $id_cliente = $liderEstruct[0];
		// $id_pedido_cliente = $liderEstruct[1];
		####

		$id_liderazgo = $_POST['id'];
		$descuentos = $_POST['descuentos'];
		$colecciones = $_POST['valores'];
		$totales = $_POST['totales'];

		$num = 0;
		$query = "DELETE FROM bonoscierres WHERE id_pedido = $id_pedido and id_cliente = $id_cliente";
		$exec = $lider->eliminar($query);
		if($exec['ejecucion']==true){
			foreach ($id_liderazgo as $id_nivel) {
				$descuento = $descuentos[$num];
				if($colecciones[$num]!=""){
					$coleccion = number_format($colecciones[$num],0);
				}else{
					$coleccion = number_format("0",0);;
				}
				// $coleccion = number_format($colecciones[$num],0);
				$total = $totales[$num];
				
				// echo "Id pedido: ".$id_pedido." || ";
				// echo "Id Cliente: ".$id_cliente." || ";
				// echo "Id liderazgo: ".$id_nivel." || ";
				// echo "Descuentos: ".$descuento." || ";
				// echo "Colecciones: ".$coleccion." || ";
				// echo "Totales: ".$total." || ";
				// echo "<br>";

				$query = "INSERT INTO bonoscierres (id_bonocierre, id_pedido, id_cliente, id_liderazgo, descuentos_bono_cierre, colecciones_bono_cierre, totales_bono_cierre, estatus) VALUES (DEFAULT, $id_pedido, $id_cliente, $id_nivel, '$descuento', '$coleccion', '$total', 1)";
				$exec = $lider->registrar($query, "bonoscierres", "id_bonocierre");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
				$num++;
			}
		}
		
		## Llamada a la vista
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';

	}

	if(!empty($_POST['precioGema']) && !empty($_POST['id_pedido_modal']) && isset($_POST['valoresLiquidacion']) && isset($_POST['totalesLiquidacion'])){
		// print_r($_POST);
		$id_pedido = $_POST['id_pedido_modal'];
		$id_pedido = $id;
		$id_cliente = $lider->consultarQuery("SELECT id_cliente FROM pedidos WHERE id_pedido={$id}");
		$id_cliente = $id_cliente[0]['id_cliente'];
		$valor = 0;
		if($_POST['valoresLiquidacion']>0){
			$valor = $_POST['valoresLiquidacion'];
		}
		// $valor = 0;
		// $valor = 8;

		$precioGema = $_POST['precioGema'];
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE id_campana = {$id_campana}");
		$precioGema = $precio_gema[0]['precio_gema'];
		$totalesLiquidacion = $_POST['totalesLiquidacion'];
		$totalesLiquidacion = $precioGema*$valor;
		$fecha = date('Y-m-d');
		$hora = date('h:i a');

		// echo "Pedido: ".$id_pedido."<br>";
		// echo "Cliente: ".$id_cliente."<br>";
		// echo "Precio: ".$precioGema."<br>";
		// echo "Cantidad_descuento_gemas: ".$valor."<br>";
		// echo "<br><br>";


		if($valor == 0){
			$query = "DELETE FROM descuentos_gemas WHERE id_pedido = {$id_pedido} and id_cliente = {$id_cliente}";
			$exec = $lider->eliminar($query);
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2";
			}
		}else{
			$query = "SELECT * FROM descuentos_gemas WHERE id_pedido = $id_pedido and id_cliente = $id_cliente";
			$buscar = $lider->consultarQuery($query);
			if(count($buscar)>1){
				$query = "UPDATE descuentos_gemas SET precio_gema = {$precioGema}, cantidad_descuento_gemas='{$valor}', total_descuento_gemas='{$totalesLiquidacion}', estatus = 1 WHERE id_pedido = {$id_pedido} and id_cliente = {$id_cliente}";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
			}else{
				$query = "INSERT INTO descuentos_gemas (id_descuento_gema, id_pedido, id_cliente, precio_gema, cantidad_descuento_gemas, total_descuento_gemas, fecha_descuento_gema, hora_descuento_gema, estatus) VALUES (DEFAULT, {$id_pedido}, {$id_cliente}, '{$precioGema}', '{$valor}', '{$totalesLiquidacion}', '{$fecha}', '{$hora}', 1)";
				$exec = $lider->registrar($query, "descuentos_gemas", "id_descuento_gema");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
			}
		}
		// echo $response;

		## Llamada a la vista;
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';
	}

	if(!empty($_POST['id_pedido_modal']) && !empty($_POST['tipo_bono']) && !empty($_POST['descuentoContado']) && isset($_POST['valoresContado']) && isset($_POST['totalesContado'])){

		$tipo_bono = $_POST['tipo_bono'];
		$id_pedido = $_POST['id_pedido_modal'];
		$descuentos = $_POST['descuentoContado'];
		$colecciones = number_format($_POST['valoresContado'],0);
		$totales = $_POST['totalesContado'];

		$num = 0;

		$query = "DELETE FROM bonoscontado WHERE id_pedido = $id_pedido";
		$exec = $lider->eliminar($query);
		if($exec['ejecucion']==true){
				$query = "INSERT INTO bonoscontado (id_bonocontado, id_pedido, descuentos_bono, colecciones_bono, totales_bono, estatus) VALUES (DEFAULT, $id_pedido, '$descuentos', '$colecciones', '$totales', 1)";
				$exec = $lider->registrar($query, "bonoscontado", "id_bonocontado");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
		}

		
		## Llamada a la vista;
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';
	}


	if(!empty($_POST['id_pedido_modal']) && !empty($_POST['id']) && !empty($_POST['tipo_bono']) && !empty($_POST['descuentos']) && isset($_POST['valores']) && isset($_POST['totales'])){

		// echo json_encode($_POST);
		// print_r($_POST);
		$tipo_bono = $_POST['tipo_bono'];
		$id_pedido = $_POST['id_pedido_modal'];
		$id_plan_campana = $_POST['id'];
		$descuentos = $_POST['descuentos'];
		$colecciones = $_POST['valores'];
		$totales = $_POST['totales'];

		$query = "DELETE FROM bonospagos WHERE id_pedido = $id_pedido";
		$exec = $lider->eliminar($query);
		// $exec['ejecucion']=true;
		
		if($exec['ejecucion']==true){
			foreach ($tipo_bono as $tipo) {
				$num = 0;
				foreach ($id_plan_campana[$tipo] as $id_plan) {
					$descuento = $descuentos[$tipo][$num];
					$cantCol = $colecciones[$tipo][$num];
					$total = $totales[$tipo][$num];

					// echo "Id Pedido: ".$id_pedido." || ";
					// echo "Id Plan Campana: ".$id_plan." || ";
					// echo "Tipo Bono: ".$tipo." || ";
					// echo "Descuentos: ".$descuento." || ";
					// echo "Colecciones: ".$cantCol." || ";
					// echo "Totales: ".$total." || ";
					// echo "<br>";

					$query = "INSERT INTO bonospagos (id_bonoPago, id_pedido, id_plan_campana, tipo_bono, descuentos_bono, colecciones_bono, totales_bono, estatus) VALUES (DEFAULT, $id_pedido, $id_plan, '{$tipo}', '$descuento', '{$cantCol}', '{$total}', 1)";
					$exec = $lider->registrar($query, "bonospagos", "id_bonoPago");
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2";
					}
					$num++;
				}
			}
		}

		

		## Codigo de Llamado a La Vista
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';

	}

	if(isset($_POST['cantidadTraspaso']) && !empty($_POST['restoDisponible']) && !empty($_POST['id_cliente_receptor']) && !empty($_POST['id_pedido_receptor']) && isset($_POST['id_cliente_emisor']) && isset($_POST['id_pedido_emisor'])){
		// print_r($_POST);

		$cantidad = $_POST['cantidadTraspaso'];
		if($cantidad==""){
			$cantidad = 0;
		}
		$restoDisponible = $_POST['restoDisponible'];
		$id_cliente_receptor = $_POST['id_cliente_receptor'];
		$id_pedido_receptor = $_POST['id_pedido_receptor'];
		$id_cliente_emisor = $_POST['id_cliente_emisor'];
		$id_pedido_emisor = $_POST['id_pedido_emisor'];

		// echo "<br>";
		// echo "Yo mi ID ".$id_cliente_emisor."<br>";
		// echo "Yo mi Pedido ".$id_pedido_emisor."<br>";
		// echo "La otra persona su ID ".$id_cliente_receptor."<br>";
		// echo "La otra persona su Pedido ".$id_pedido_receptor."<br>";
		// echo "<br>";

		$traspasos = $lider->consultarQuery("SELECT * FROM traspasos WHERE estatus = 1 and id_pedido_emisor = {$id_pedido_emisor} and id_pedido_receptor = {$id_pedido_receptor}");

		// print_r($traspasos);
		// echo "<br>";
		if(count($traspasos)>1){
			$exec1 = $lider->eliminar("DELETE FROM traspasos WHERE estatus = 1 and id_pedido_emisor = {$id_pedido_emisor} and id_pedido_receptor = {$id_pedido_receptor}");
			if($exec1['ejecucion']==true){
				if($cantidad>0){
					$query = "INSERT INTO traspasos (id_traspaso, id_pedido_emisor, id_pedido_receptor, cantidad_traspaso, estatus) VALUES (DEFAULT, $id_pedido_emisor, $id_pedido_receptor, '$cantidad', 1)";
					$exec = $lider->registrar($query, "traspasos", "id_traspaso");
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2";
					}	
				}else{
					$response = "1";
				}
			}else{
				$response = "2";
			}
		}else{
			$query = "INSERT INTO traspasos (id_traspaso, id_pedido_emisor, id_pedido_receptor, cantidad_traspaso, estatus) VALUES (DEFAULT, $id_pedido_emisor, $id_pedido_receptor, '$cantidad', 1)";
			$exec = $lider->registrar($query, "traspasos", "id_traspaso");
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2";
			}
		}

		// CODIGO PARA MOSTRAR NUEVAMENTE LA VISTA;
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';
	}

	// print_r($_POST);
	if(
		!empty($_POST['cantidad']) && isset($_POST['cantidadSec']) 
		|| 
		!empty($_POST['cantidadSec']) && isset($_POST['cantidad']) 
	){
		// print_r($_POST);  // APROBAR PEDIDOS
		// echo "XDDDDDD";
		// die();
		$cantidad = $_POST['cantidad'];
		if(!empty($_POST['cantidadSec'])){
			$cantidadSec = $_POST['cantidadSec'];
		}else{
			$cantidadSec = [];
		}
		if(!empty($_POST['idColSec'])){
			$ids = $_POST['idColSec'];
		}else{
			$ids = [];
		}
		$totalCantidadColecciones = $cantidad;
		foreach ($cantidadSec as $cantidad_sec) {
			$totalCantidadColecciones += $cantidad_sec;
		}
		// echo "<br>";
		// echo $cantidad;
		// echo "<br>";
		// echo $totalCantidadColecciones;
		// die();

		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		$pedido = $pedidos[0];
		
		$fecha_aprobado = date('d-m-Y');
		$hora_aprobado = date('g:ia');

		$query = "UPDATE pedidos SET cantidad_aprobado = {$totalCantidadColecciones}, cantidad_aprobado_individual = {$cantidad}, fecha_aprobado = '{$fecha_aprobado}', hora_aprobado = '{$hora_aprobado}', visto_admin = 1, visto_cliente = 2, estatus = 1 WHERE id_pedido = {$id}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$cantidad=$totalCantidadColecciones;
			$response = "1";

			$indexOf = 0;
			$erroresSec = 0;
			$busquedaPedidoSecundario = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido={$id}");
			// // print_r($busquedaPedidoSecundario);
			if(count($busquedaPedidoSecundario)>1){
				$borrado = $lider->consultarQuery("DELETE FROM pedidos_secundarios WHERE id_pedido={$id}");
			}
			$id_user = $pedidos[0]['id_cliente'];
			$fecha_pedido = date('d-m-Y');
			$hora_pedido = date('g:ia');
			$id_pedido = $id;
			$indexOf = 0;
			$erroresSec = 0;
			foreach ($cantidadSec as $cantidad_sec) {
				$idColeccionSec = $ids[$indexOf];
				$cantidad_solicitada_sec=0;
				foreach ($busquedaPedidoSecundario as $busq) {
					if(!empty($busq['id_despacho_sec'])){
						if($busq['id_despacho_sec']==$idColeccionSec){
							$cantidad_solicitada_sec=$busq['cantidad_pedido_sec'];
						}
					}
				}
				$querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, fecha_aprobado_sec, hora_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, {$cantidad_solicitada_sec}, '{$fecha_pedido}', '{$hora_pedido}', $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 1)";
				// echo "<br><br>".$querySec;
				$execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
				if($execSec['ejecucion']==true){
				}else{
					$erroresSec++;
				}
				$indexOf++;
			}
			// if(count($busquedaPedidoSecundario)>1){
			// 	foreach ($cantidadSec as $cantidad_sec) {
			// 		$querySec = "UPDATE pedidos_secundarios SET cantidad_aprobado_sec={$cantidad_sec}, fecha_aprobado_sec = '{$fecha_aprobado}', hora_aprobado_sec = '{$hora_aprobado}', estatus=1 WHERE id_pedido={$id} and id_despacho_sec={$ids[$indexOf]}";
			// 		// $sentencesSecundary[count($sentencesSecundary)]=$querySec;
			// 		$indexOf++;

			// 		$execSec = $lider->modificar($querySec);
			// 		if($exec['ejecucion']==true){}else{
			// 			$erroresSec++;
			// 		}
			// 	}
			// }else{
			// 	// echo "No se encontro para UPDATE se debe hacer INSERT INTO";
			// 	// echo "No hay pedido Secundario";
			// 	// print_r($_POST);
			// // die();
			// }
			if($erroresSec==0){

				$query2 = "INSERT INTO pedidos_historicos (id_pedidos_historicos, id_despacho, id_pedido, id_usuario, cantidad_aprobado, fecha_aprobado, hora_aprobado, estatus) VALUES (DEFAULT, {$id_despacho}, {$id}, {$_SESSION['id_usuario']}, {$cantidad}, '{$fecha_aprobado}', '{$hora_aprobado}', 1)";
				$exec2 = $lider->registrar($query2, "pedidos_historicos", "id_pedidos_historicos");
				if($exec['ejecucion']==true){
					$execHist = "1";
				}else{
					$execHist = "2";
				}
		
				$id_cliente = $pedido['id_cliente'];
				/* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/

				/* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/
				$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

				$cantidadClientesBajos = Count($clientesBajas)-1;
				$cantidad_total = 0;
				$cantidad_total_alcanzada = 0;
				$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
			    $cantidad_acumulada = 0;
			    foreach ($pedidosAcumulados as $keyss) {
			      if(!empty($keyss['id_pedido'])){
			        $cantidad_acumulada += $keyss['cantidad_aprobado'];
			      }
			    }
				if($cantidadClientesBajos > 0){
					$tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
					// $cantidad_total = $tot;
					$cantidad_total = $cantidad+$tot;

					$totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
					$cantidad_total_alcanzada = $cantidad_acumulada+$totAlcanzadas;
				}else{
					$cantidad_total = $cantidad;
					$cantidad_total_alcanzada = $cantidad_acumulada;
				}
				// echo "Cantidad Conseguida con mis colecciones y con mis hij@ss En esta CAMPAÑA: ".$cantidad_total." <br><br>";
				// echo "Cantidad Conseguida con mis colecciones y con mis hij@ss En TODOS LOS DESPACHOS de ESTA CAMPAÑA: ".$cantidad_total_alcanzada." <br><br>";


				
				/* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

				$query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id";
				$exec = $lider->modificar($query);
				$res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);

				$busqueda = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
				if(count($busqueda)>1){
					$queryXD = "UPDATE colecciones_alcanzadas_campana SET cantidad_total_alcanzada = {$cantidad_total_alcanzada} WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}";
					$execXD = $lider->modificar($queryXD);
				}else{
					$queryXD = "INSERT INTO colecciones_alcanzadas_campana (id_CAC, id_campana, id_cliente, cantidad_total_alcanzada, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$cantidad_total_alcanzada}, 1)";
					$execXD = $lider->modificar($queryXD);
				}
				// echo $queryXD;






				/* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

				$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
				$cliente = $clientes[0];
				$totalActual = $pedido['cantidad_total'];
				$id_lider = $cliente['id_lider'];
				if($id_lider > 0 ){
					$request = comprobarLider($cantidad_total, $id_lider, $id_despacho, $lider);
					$requestXD = comprobarLiderAlcanzadas($cantidad_total, $id_lider, $id_campana, $id_despacho, $lider);

				}
				

				// //Esto Nooo se Descomentara
				$request = "1";


					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', '
						Aprobar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}

				$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
				$configgema = $configgemas[0];
				$id_configgema = $configgema['id_configgema'];
				$cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
				$cantidad_gemas = 0;
				// if($configgema['condicion']=="Dividir"){
				// }
				// if($configgema['condicion']=="Multiplicar"){
				//   $cantidad_gemas = $cantidad * $cantidad_gemas_correspondientes;
				// }
				$cantidad_gemas = $cantidad / $cantidad_gemas_correspondientes;


				$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
				$cantidad_acumulada = 0;
				foreach ($pedidosAcumulados as $keyss) {
					if(!empty($keyss['id_pedido'])){
						$cantidad_acumulada += $keyss['cantidad_aprobado'];
					}
				}
				// echo "Cantidad: ".$cantidad."<br>";
				// echo "Cantidad Acumulada: ".$cantidad_acumulada."<br><br>";

				$cantidad_acumulada_separado = 0;
				foreach ($pedidosAcumulados as $keyss) {
					if(!empty($keyss['id_pedido'])){
						// print_r($keyss);
						// echo "<br>";
						$cantidad_acumulada_separado = $keyss['cantidad_aprobado'];
						// echo "cantidad_acumulada_separado:" .$cantidad_acumulada_separado."<br>";
						if($cantidad_acumulada >= $varMinimaColeccionesParaGemas){
							// echo "Mayor a 30 Colecciones <br><br>";
							$cantidad_gemas_separado = $cantidad_acumulada_separado / $cantidad_gemas_correspondientes;
						}else{
							// echo "Menos a 30 Colecciones <br>";
							$cantidad_gemas_separado = 0;
						}
						// echo "cantidad_gemas_separado:" .$cantidad_gemas_separado."<br>";
						// echo "<br>";
						// echo "Separado - Despacho: ".$keyss['id_despacho']."<br>";
						// echo "Separado - Campaña: ".$keyss['id_campana']."<br>";
						// echo "Separado - Factura: ".$keyss['numero_despacho']."<br>";
						// echo "Separado - Cliente: ".$keyss['id_cliente']."<br>";
						// echo "Separado - Pedido: ".$keyss['id_pedido']."<br>";
						// echo "Separado - Cantidad: ".$cantidad_acumulada_separado."<br>";
						// echo "Separado - Gemas: ".$cantidad_gemas_separado."<br>";

						// echo "<br>Clausula: id_campana: {$keyss['id_campana']} | id_pedido: {$keyss['id_pedido']} | id_cliente: {$keyss['id_cliente']} | id_configgema: {$id_configgema} <br>";
						$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$keyss['id_campana']} and id_pedido = {$keyss['id_pedido']} and id_cliente = {$keyss['id_cliente']} and id_configgema = {$id_configgema}");
						$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$keyss['id_campana']}, {$keyss['id_pedido']}, {$keyss['id_cliente']}, {$id_configgema}, '{$cantidad_acumulada_separado}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas_separado}', 0, '{$cantidad_gemas_separado}', 'Bloqueado', 1)";
						$lider->registrar($query, "gemas", "id_gema");

						// echo $query."<br>";

						// echo "<br>";
					}
				}
				// die();
				// if($cantidad_acumulada >= $varMinimaColeccionesParaGemas){
				// 	// echo "Mayor a 30 Colecciones <br><br>";
				// 	$cantidad_acumulada_separado = 0;
				// 	foreach ($pedidosAcumulados as $keyss) {
				// 		if(!empty($keyss['id_pedido'])){
				// 			$cantidad_acumulada_separado = $keyss['cantidad_aprobado'];
				// 			$cantidad_gemas_separado = $cantidad_acumulada_separado / $cantidad_gemas_correspondientes;
				// 			// echo "Separado - Despacho: ".$keyss['id_despacho']."<br>";
				// 			// echo "Separado - Campaña: ".$keyss['id_campana']."<br>";
				// 			// echo "Separado - Factura: ".$keyss['numero_despacho']."<br>";
				// 			// echo "Separado - Cliente: ".$keyss['id_cliente']."<br>";
				// 			// echo "Separado - Pedido: ".$keyss['id_pedido']."<br>";
				// 			// echo "Separado - Cantidad: ".$cantidad_acumulada_separado."<br>";
				// 			// echo "Separado - Gemas: ".$cantidad_gemas_separado."<br>";

				// 			// echo "<br>Clausula: id_campana: {$keyss['id_campana']} | id_pedido: {$keyss['id_pedido']} | id_cliente: {$keyss['id_cliente']} | id_configgema: {$id_configgema} <br>";
				// 			$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$keyss['id_campana']} and id_pedido = {$keyss['id_pedido']} and id_cliente = {$keyss['id_cliente']} and id_configgema = {$id_configgema}");
				// 			$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$keyss['id_campana']}, {$keyss['id_pedido']}, {$keyss['id_cliente']}, {$id_configgema}, '{$cantidad_acumulada_separado}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas_separado}', 0, '{$cantidad_gemas_separado}', 'Bloqueado', 1)";
				// 			$lider->registrar($query, "gemas", "id_gema");

				// 			// echo $query."<br>";

				// 			// echo "<br>";
				// 		}
				// 	}
				// }else{
				// 	$cantidad_gemas = 0;
				// 	// echo "Menos a 30 Colecciones <br>";
				// 	// echo "Gemas: ".$cantidad_gemas." Unids<br>";
				// 	$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");
				// 	$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, {$id_cliente}, {$id_configgema}, '{$cantidad}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', 0, '{$cantidad_gemas}', 'Bloqueado', 1)";

				// 	$lider->registrar($query, "gemas", "id_gema");
				// }

			}
		}else{
			$response = "2";
		}

		// CODIGO PARA MOSTRAR NUEVAMENTE LA VISTA;
		require_once 'app/controllers/pedidos/codigoLlamadaVista.php';
	}

	if(empty($_POST) && (!empty($_GET['reclamarporcentaje']) && $_GET['reclamarporcentaje'] == 1 ) && !empty($_GET['gema']) && isset($_GET['porcentaje'])){
		$pedido = $pedidos[0];
		$id_gema = $_GET['gema'];
		$porcentaje = number_format($_GET['porcentaje'],2);
		$gemas = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id_gema}");
		$gema = $gemas[0];
		$inactivas = $gema['cantidad_gemas'] - $porcentaje;
		$activas = $porcentaje;

		$porcentajeReal = $_GET['porcentPago'];
		if($porcentajeReal >= 100){
			// echo "TODO BIEN <br><br>";
			$porcentajeReal = 100;
		}
		$cantidad_unidades = $pedido['cantidad_aprobado'];

		if($cantidad_acumuladaVer >= $varMinimaColeccionesParaGemas){
			$cantidad_gemas = $cantidad_unidades / $gema['cantidad_configuracion'];

			$porcentajeCalc = ($cantidad_gemas/100)*$porcentajeReal;
			$porcentajeCalc = number_format($porcentajeCalc,2,'.','');
			$inactivasCalc = $cantidad_gemas - $porcentajeCalc;
			$activasCalc = $porcentajeCalc;
			// echo "Cantidad Gemas: ".$gema['cantidad_gemas']." <br>";

			// echo "COLECCIONES APROBADAS: ".$pedido['cantidad_aprobado']." <br>";
			// echo "Cantidad Unidades: ".$cantidad_unidades." <br>";
			// echo "Cantidad Gemas calc: ".$cantidad_gemas." <br>";
			// echo "Porcentaje Calculado: ".$porcentajeCalc."<br>";
			// echo "INACTIVAS Calculado: ".$inactivasCalc."<br>";
			// echo "ACTIVAS Calculado: ".$activasCalc."<br>";

			$query = "UPDATE gemas SET cantidad_unidades='{$cantidad_unidades}', cantidad_gemas='{$cantidad_gemas}', activas = '{$activasCalc}', inactivas = '{$inactivasCalc}', estado = 'Disponible' WHERE id_gema = {$id_gema}";

			$res1 = $lider->modificar($query);
			if($res1['ejecucion']==true){
				$responseGema = "1";
			}else{
				$responseGema = "2"; // echo 'Error en la conexion con la bd';
			}
		} else {
			$responseGema = "1";
		}		

	}

	if(empty($_POST) && (!empty($_GET['reclamar']) && $_GET['reclamar'] == 1 ) && !empty($_GET['gema'])){
		$pedido = $pedidos[0];
		$id_gema = $_GET['gema'];
		$gemas = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id_gema}");
		$gema = $gemas[0];
		$activas = $gema['cantidad_gemas'];

		$cantidad_unidades = $pedido['cantidad_aprobado'];
		if($cantidad_acumuladaVer >= $varMinimaColeccionesParaGemas){
			$cantidad_gemas = $cantidad_unidades / $gema['cantidad_configuracion'];
			$inactivasCalc = $cantidad_gemas - $cantidad_gemas;
			$activasCalc = $cantidad_gemas;
			// echo "COLECCIONES APROBADAS: ".$pedido['cantidad_aprobado']." <br>";
			// echo "Cantidad Unidades: ".$cantidad_unidades." <br>";
			// echo "Cantidad Gemas calc: ".$cantidad_gemas." <br>";
			// echo "INACTIVAS Calculado: ".$inactivasCalc."<br>";
			// echo "ACTIVAS Calculado: ".$activasCalc."<br>";

			// $query = "UPDATE gemas SET activas = '{$activas}', inactivas = '0', estado = 'Disponible' WHERE id_gema = {$id_gema}";
			$query = "UPDATE gemas SET cantidad_unidades='{$cantidad_unidades}', cantidad_gemas='{$cantidad_gemas}', activas = '{$activasCalc}', inactivas = '{$inactivasCalc}', estado = 'Disponible' WHERE id_gema = {$id_gema}";
			// echo $query."<br>";
			$res1 = $lider->modificar($query);
			if($res1['ejecucion']==true){
				$responseGema = "1";
			}else{
				$responseGema = "2"; // echo 'Error en la conexion con la bd';
			}
		} else {
			$responseGema = "1";
		}
	}

	if(!empty($_POST['cerrarExcedenteLider']) && !empty($_POST['cantidad_excedente']) ){
		$id_pedido = $_GET['id'];
		$cantidad = $_POST['cantidad_excedente'];
		$descripcion = ucwords(mb_strtolower($_POST['descripcion_excedente']));
		// echo "Pedido: ".$id_pedido." - Cantidad: ".$cantidad;
		// $porcentaje = number_format($_GET['porcentaje'],2);
		
		// $buscar = $lider->consultarQuery("SELECT * FROM excedentes WHERE id_pedido = {$id_pedido}");
		// print_r($buscar);
		// if(count($buscar)>1){
			// $response = "1";
		// }else{
			$query = "INSERT INTO excedentes (id_excedente, id_pedido, cantidad_excedente, descripcion_excedente, estatus) VALUES (DEFAULT, {$id_pedido}, '{$cantidad}', '{$descripcion}', 1)";
			$res1 = $lider->registrar($query,"excedentes", "id_excedente");
			if($res1['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		// }
		echo $response;
	}


	if($accesoSinPost == "1"){
		if(empty($_POST)){	
			require_once 'app/controllers/pedidos/codigoLlamadaVista.php';
		}
	}else{
		require_once 'public/views/error404.php';
	}
}else{
	require_once 'public/views/error404.php';
}

function consultarEstructura($id_c, $lider){
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c and clientes.estatus = 1");

	// $lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				$lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$lid['id_cliente']}");
				if(count($lideress)>1){
					$lid2 = $lideress[0];
					$lid2['cantidad_acumulada'] = $lid2['cantidad_aprobado'];
					$_SESSION['ids_general_estructura'][] = $lid2;
					// print_r($lid);
					// echo "<br><br>";
					// print_r($lid2);
					// echo "<br><br><br><br>";
				}
				consultarEstructura($lid['id_cliente'], $lider);
			}
		}
	}
}

function consultarEstructuraAc($id_c, $lider){
	$id_campana = $_SESSION['id_campana'];
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c and clientes.estatus = 1");

	// $lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				// print_r($lid);
				// echo "<br><br>";
				$lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$lid['id_cliente']}");
				if(count($lideress)>1){
					$colTotalLider = 0;
					$lid3 = $lideress[0];
					// print_r($lid2);
					// print_r($lid2);
					// echo "<br><br><br><br>";
					foreach ($lideress as $lid2) {
						if(!empty($lid2['id_pedido'])){
							// print_r($lid2['id_cliente']." ".$lid2['id_pedido']." ".$lid2['cantidad_aprobado']);
							$colTotalLider += $lid2['cantidad_aprobado'];
							// echo "<br>";
						}
					}
					// echo "=================";
					// echo "<br>Suma: ".$colTotalLider;
					// echo "<br>";
					$lid3['cantidad_acumulada'] = $colTotalLider;
					$_SESSION['ids_general_estructura'][] = $lid3;
				}
					// echo "<br><br><br><br><br><br><br><br>";
				consultarEstructuraAc($lid['id_cliente'], $lider);
			}
		}
	}
}
// function consultarEstructura($id_c, $lider){
// 	$id_campana = $_SESSION['id_campana'];
// 	$id_despacho = $_SESSION['id_despacho'];
// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c and clientes.estatus = 1");

// 	// $lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

// 	if(Count($lideres)>1){
// 		foreach ($lideres as $lid) {
// 			if(!empty($lid['id_cliente'])){
// 				// $lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$lid['id_cliente']}");
// 				$lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$lid['id_cliente']}");
// 				// print_r($lideress);
// 				foreach ($lideress as $liders) {
// 					if(!empty($liders['id_pedido'])){
// 						$_SESSION['ids_general_estructura'][] = $liders;
// 					}
// 				}
// 				// if(count($lideress)>1){
// 					// $lid2 = $lideress[0];
// 					// $_SESSION['ids_general_estructura'][] = $lid2;
					
// 					// print_r($lid);
// 					// echo "<br><br>";
// 					// print_r($lid2);
// 					// echo "<br><br><br><br>";
// 				// }
// 				consultarEstructura($lid['id_cliente'], $lider);
// 			}
// 		}
// 	}
// }

// function consultarEstructura($id_c, $lider){
// 	$id_despacho = $_SESSION['id_despacho'];
// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

// 	if(Count($lideres)>1){
// 		foreach ($lideres as $lid) {
// 			if(!empty($lid['id_cliente'])){
// 				$_SESSION['ids_general_estructura'][] = $lid;
// 				consultarEstructura($lid['id_cliente'], $lider);
// 			}
// 		}
// 	}
// }

function consultarEstructuraID($id_c, $lider){
	// echo $id_c."<br>";
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT clientes.id_cliente FROM clientes WHERE clientes.id_lider = $id_c");
	// $lideres = $lider->consultarQuery("SELECT clientes.id_cliente, pedidos.id_pedido FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");
	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				$pedidos = $lider->consultarQuery("SELECT clientes.id_cliente, pedidos.id_pedido FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$lid['id_cliente']}");
				// print_r($pedidos);
				if(Count($pedidos)>1){
					foreach ($pedidos as $ped) {
						if(!empty($ped['id_cliente'])){
							$_SESSION['ids_general_estructuraID'][] = $ped;
						}
					}
				}
				// $_SESSION['ids_general_estructuraID'][] = $lid;
				consultarEstructuraID($lid['id_cliente'], $lider);
			}
		}
	}
}

function comprobarLider($cantidad, $id_lider, $id_despacho, $lider){
	// echo "Mis Colecciones Total: ".$cantidad."<br>";
	$responseRequest = false;
	$pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_lider and id_despacho = $id_despacho");

	$clientesLider = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_lider");
	if(Count($pedidosLider)>1){
		$pedidoLider = $pedidosLider[0];
		$cantidad = $pedidoLider['cantidad_aprobado'];
		$id_pedido = $pedidoLider['id_pedido'];
		// echo "pedido: ".$id_pedido." <br>";
		// echo "Cantidad_aprobadas: ".$cantidad." <br>";
	}

	if(Count($clientesLider)>1){
		$clienteLider = $clientesLider[0];
		$id_cliente = $clienteLider['id_cliente'];
		$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

		$cantidadClientesBajos = Count($clientesBajas)-1;
		$cantidad_total = 0;
		if($cantidadClientesBajos > 0){
			$tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
			// $cantidad_total = $tot;	
			$cantidad_total = $cantidad+$tot;
		}else{
			$cantidad_total = $cantidad;
		}
		if(Count($pedidosLider)>1){
			// echo "Cantidad total: ".$cantidad_total."<br><br>";
			$query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id_pedido";
			$exec = $lider->modificar($query);
		}

		/*  CODIGO PARA ESTABLECER CUAL SERA MI LIDERAZGO  */ 
		$res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);
		$new_id_lider = $clienteLider['id_lider'];
		if($new_id_lider > 0 ){
			$responseRequest = comprobarLider($cantidad, $new_id_lider, $id_despacho, $lider);
		}
	}
	return $responseRequest;
}

function comprobarLiderAlcanzadas($cantidad, $id_lider, $id_campana, $id_despacho, $lider){
	// echo "Mis Colecciones Total: ".$cantidad."<br>";
	$responseRequest = false;
	// $pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_lider and id_despacho = $id_despacho");
	$pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = $id_lider and despachos.id_campana = $id_campana");
	$clientesLider = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_lider");
	$cantidad = 0;
	if(Count($pedidosLider)>1){
		foreach ($pedidosLider as $keyss) {
			if(!empty($keyss['id_pedido'])){
				// $total += $keyss['cantidad_aprobado'];
				$cantidad += $keyss['cantidad_aprobado'];
				$id_pedido = $keyss['id_pedido'];
				// $pedidoLider = $pedidosLider[0];
				// $id_pedido = $pedidoLider['id_pedido'];
				// echo "pedido: ".$id_pedido." <br>";
				// echo "Cantidad_aprobadas: ".$cantidad." <br>";
			}
		}
	}


	if(Count($clientesLider)>1){
		$clienteLider = $clientesLider[0];
		$id_cliente = $clienteLider['id_cliente'];

		$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

		$cantidadClientesBajos = Count($clientesBajas)-1;
		$cantidad_total_alcanzada = 0;
		$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
	    $cantidad_acumulada = 0;
	    foreach ($pedidosAcumulados as $keyss) {
	      if(!empty($keyss['id_pedido'])){
	        $cantidad_acumulada += $keyss['cantidad_aprobado'];
	      }
	    }
		if($cantidadClientesBajos > 0){
			$totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
			$cantidad_total_alcanzada = $cantidad_acumulada+$totAlcanzadas;
		}else{
			$cantidad_total_alcanzada = $cantidad_acumulada;
		}
		// echo "LideR: ".$clienteLider['id_cliente']." | ".$clienteLider['primer_nombre']." ".$clienteLider['primer_apellido']."<br>";
		// echo "Cantidad Alcanzada: ".$cantidad_total_alcanzada."<br>";
		if(Count($pedidosLider)>1){
			// echo "Cantidad total: ".$cantidad_total_alcanzada."<br><br>";
			$busqueda = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
			if(count($busqueda)>1){
				$queryXD = "UPDATE colecciones_alcanzadas_campana SET cantidad_total_alcanzada = {$cantidad_total_alcanzada} WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}";
				$execXD = $lider->modificar($queryXD);
			}else{
				$queryXD = "INSERT INTO colecciones_alcanzadas_campana (id_CAC, id_campana, id_cliente, cantidad_total_alcanzada, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$cantidad_total_alcanzada}, 1)";
				$execXD = $lider->modificar($queryXD);
			}
			// echo $queryXD;
		}
		// echo "<br><hr><br>";

		/*  CODIGO PARA ESTABLECER CUAL SERA MI LIDERAZGO  */ 
		$new_id_lider = $clienteLider['id_lider'];
		if($new_id_lider > 0 ){
			$responseRequest = comprobarLiderAlcanzadas($cantidad, $new_id_lider, $id_campana, $id_despacho, $lider);
		}
	}
	return $responseRequest;
}

function comprobarAlcanzadas($clientes, $id_campana, $id_despacho, $lider){
	$total = 0;
	$vez = "";
	foreach ($clientes as $client) {
		if(!empty($client['id_cliente'])){
			$id_cliente = $client['id_cliente'];
			$vez = $id_cliente;
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = $id_cliente and despachos.id_campana = $id_campana");
			// $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_cliente and id_despacho = $id_despacho");
			// echo "<br><br>";
			// print_r($pedidos[0]);
			// echo "<br><br>";

			if(Count($pedidos)>1){
				foreach ($pedidos as $keyss) {
					if(!empty($keyss['id_pedido'])){
						$total += $keyss['cantidad_aprobado'];
					}
				}
			}

			$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
			if(Count($clientesBajas)>1){
				$total += comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
			}

		}
	}
	// echo "ID: ".$vez." | ";
	// echo "Total aprobadas: ".$total."  ";
	// echo "<br>";
	return $total;
}

function comprobarVendedoras($clientes, $id_despacho, $lider){
	$total = 0;
	$vez = "";
	foreach ($clientes as $client) {
		if(!empty($client['id_cliente'])){
			$id_cliente = $client['id_cliente'];
			$vez = $id_cliente;
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_cliente and id_despacho = $id_despacho");
			if(Count($pedidos)>1){
				$pedido = $pedidos[0];
				$total += $pedido['cantidad_aprobado'];
			}

			$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
			if(Count($clientesBajas)>1){
				$total += comprobarVendedoras($clientesBajas, $id_despacho, $lider);
			}

		}
	}
	// echo "ID: ".$vez." | ";
	// echo "Total aprobadas: ".$total." | ";
	// if(count($pedidos)>1){
	// echo "PEDIDO: ".$pedido['id_pedido']." ";
	// }
	// echo "<br>";
	return $total;
}


function aplicarLiderazgo($id, $id_despacho, $lider){
	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id and id_despacho = $id_despacho");
	if(Count($pedidos)>1){
		$pedido = $pedidos[0];
		if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
			$total = $pedido['cantidad_total'];
		}
		if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
			$total = $pedido['cantidad_aprobado'];
		}
		$query = "SELECT * FROM liderazgos_campana WHERE $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgos = $lider->consultarQuery($query);
		if(Count($liderazgos)>1){
			$liderazgo = $liderazgos[0];
			$id_liderazgo = $liderazgo['id_lc'];

			$query = "UPDATE clientes SET id_lc = $id_liderazgo WHERE id_cliente = $id";
			$exec = $lider->modificar($query);
		}
	}
}

?>