<?php 

// print_r($_POST);
if(!empty($_POST['verificarNuevoPedido'])){
	$query = "SELECT * FROM pedidos WHERE estatus = 1 and visto_admin = 0 ORDER BY id_pedido DESC";
	$res = $lider->consultarQuery($query);
	$cantidadNotificacionesNoVistas = 0;
	if(count($res)>1){
		$cantidadNotificacionesNoVistas = Count($res)-1;
	}
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1 ORDER BY pedidos.id_pedido DESC";
	$clientesPedidos = $lider->consultarQuery($query);
	$cant = Count($clientesPedidos)-1;
	$clientesPedidos['cantidad'] = $cantidadNotificacionesNoVistas;
	$clientesPedidos['cantidadAll'] = $cant;
	
	print_r(json_encode($clientesPedidos));
}
if(!empty($_POST['verificarPedidosAprobados'])){
	$id_cliente = $_SESSION['id_cliente'];
	$query = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente and estatus = 1 and visto_cliente = 2 ORDER BY id_pedido DESC";
	$res = $lider->consultarQuery($query);
	$cantidadNotificacionesNoVistas = 0;
	// echo count($res);
	if(count($res)>1){
		$cantidadNotificacionesNoVistas = Count($res)-1;
	}
	// $query = "SELECT * FROM pedidos, clientes WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.visto_cliente = 0 ORDER BY pedidos.id_pedido DESC";
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1 ORDER BY pedidos.id_pedido DESC";
	$clientesPedidos = $lider->consultarQuery($query);
	// echo $id_cliente;
	// echo count($res);
	// echo count($clientesPedidos);
	$cant = Count($clientesPedidos)-1;
	$clientesPedidos['cantidad'] = $cantidadNotificacionesNoVistas;
	$clientesPedidos['cantidadAll'] = $cant;
	// $clientesPedidos['cantidad'] = $cant;
	echo json_encode($clientesPedidos);


}
if(!empty($_POST['verificarFechaLimiteDesperfectos'])){

	$id_cliente = $_SESSION['id_cliente'];
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1   ORDER BY pedidos.id_pedido DESC";
	// $query = "SELECT * FROM desperfectos, campanas WHERE desperfectos.id_campana = campanas.id_campana and campanas.estatus = 1 and campanas.visibilidad = 1";
			// $clientesPedidos2 = $lider->consultarQuery($query);

	// echo json_encode($clientesPedidos2);
	// if(Count($clientesPedidos2)>1){
	// 	echo Count($clientesPedidos2);
	// 	$array['exec']=true;
	// 	$array['pedido']=true;
	// }else{
		$array['exec']=true;	 
		$date = date('Y-m-d');
		// $date = "2021-11-16";
		$query = "SELECT * FROM desperfectos,campanas WHERE desperfectos.id_campana= campanas.id_campana and campanas.visibilidad=1 and desperfectos.estatus=1  and campanas.estatus = 1 and campanas.visibilidad = 1 and  fecha_fin_desperfecto >= '$date'";
		$fechaDespacho = $lider->consultarQuery($query);
		// print_r($fechaDespacho);

		if(Count($fechaDespacho)>1){
			$limite_despacho = $fechaDespacho[0];
			// print_r($limite_despacho);
			$Inlimite = $limite_despacho['fecha_inicio_desperfecto']; 
			$limite = $limite_despacho['fecha_fin_desperfecto']; 
			$dias = comprobarFechasLimites($limite);	
						
			$array['limite']=true;
			$array['despacho'] = $limite_despacho;
			$array['fecha_fin_desperfecto']=$limite;
			$array['fecha_inicio_desperfecto']=$Inlimite;
			$array['dias_restante']=$dias;

			$query = "SELECT * FROM campanas,despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = {$limite_despacho['id_campana']} and campanas.estatus = 1 and campanas.visibilidad = 1";
			$campanas = $lider->consultarQuery($query);
			if(Count($campanas)>1){
				$array['campana'] = $campanas[0];
			}

		}else{
			$array['limite']=false;
			// echo "NoLimitePedido";
		}
	// }
	echo json_encode($array);
}
if(!empty($_POST['verificarFechaLimitePedido'])){

	$id_cliente = $_SESSION['id_cliente'];
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1   ORDER BY pedidos.id_pedido DESC";
			$clientesPedidos2 = $lider->consultarQuery($query);
	// echo json_encode($clientesPedidos2);
	// if(Count($clientesPedidos2)>1){
	// 	echo Count($clientesPedidos2);
	// 	$array['exec']=true;
	// 	$array['pedido']=true;
	// }else{
		$array['exec']=true;	 
		$date = date('Y-m-d');
		// $date = "2021-11-16";
		$query = "SELECT * FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1  and campanas.estatus = 1 and campanas.visibilidad = 1 and  limite_pedido >= '$date'";
		$fechaDespacho = $lider->consultarQuery($query);
		// print_r($fechaDespacho);
		if(Count($fechaDespacho)>1){
			$index = 0;
			foreach ($fechaDespacho as $keys) {
				if(!empty($keys['limite_pedido'])){

					$limite_despacho = $fechaDespacho[0];
					// print_r($limite_despacho);
					$limite = $limite_despacho['limite_pedido']; 
					$dias = comprobarFechasLimites($limite);	
								
					$array['data'][$index]['limite']=true;
					$array['data'][$index]['despacho'] = $limite_despacho;
					$array['data'][$index]['limite_pedido']=$limite;
					$array['data'][$index]['dias_restante']=$dias;

					$query = "SELECT * FROM campanas,despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = {$limite_despacho['id_campana']} and despachos.id_despacho = {$limite_despacho['id_despacho']} and campanas.estatus = 1 and campanas.visibilidad = 1";
					$campanas = $lider->consultarQuery($query);
					if(Count($campanas)>1){
						$array['data'][$index]['campana'] = $campanas[0];
					}

					$index++;
				}
			}

		}else{
			$array['data'] = [];
			$array['limite']=false;
			// echo "NoLimitePedido";
		}
	// }
	echo json_encode($array);
}
if(!empty($_POST['verificarFechaLimitePlanes'])){

	$id_cliente = $_SESSION['id_cliente'];
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1 ORDER BY pedidos.id_pedido DESC";
			$clientesPedidos2 = $lider->consultarQuery($query);
	$array['exec']=true;	 
	$date = date('Y-m-d');
	$query = "SELECT * FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1 and campanas.estatus = 1 and campanas.visibilidad = 1 and limite_seleccion_plan >= '$date'";
	$fechaDespacho = $lider->consultarQuery($query);
	// echo json_encode($fechaDespacho[1]);
	// echo "\n \n \n \n \n \n \n";

	if(Count($fechaDespacho)>1){
		$index = 0;
		foreach ($fechaDespacho as $keys) {
			if(!empty($keys['limite_seleccion_plan'])){

				$limite_despacho = $keys;
				// $limite_despacho = $fechaDespacho[0];
				// print_r($limite_despacho);
				$limite = $limite_despacho['limite_seleccion_plan']; 
				$dias = comprobarFechasLimites($limite);	
							
				$array['data'][$index]['limite']=true;
				$array['data'][$index]['despacho'] = $limite_despacho;
				$array['data'][$index]['limite_pedido']=$limite;
				$array['data'][$index]['dias_restante']=$dias;

				$query = "SELECT * FROM campanas,despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = {$limite_despacho['id_campana']} and despachos.id_despacho = {$limite_despacho['id_despacho']} and campanas.estatus = 1 and campanas.visibilidad = 1";
				$campanas = $lider->consultarQuery($query);
				if(Count($campanas)>1){
					$array['data'][$index]['campana'] = $campanas[0];
				}
				$index++;
			}
		}


		// $despa = $lider->consultarQuery("SELECT MAX(despachos.id_despacho) FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1 and campanas.estatus = 1 and campanas.visibilidad = 1 and limite_seleccion_plan < '$date'");
		$despas = $lider->consultarQuery("SELECT despachos.id_despacho FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1 and campanas.estatus = 1 and campanas.visibilidad = 1 and limite_seleccion_plan < '$date'");
		// echo json_encode($despas);
		foreach ($despas as $despa) {
			if(!empty($despa['id_despacho'])){
				$id_despa = $despa['id_despacho'];
				// $id_despa = $despa[0][0];

				$query2 = "SELECT * FROM despachos, campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1  and campanas.estatus = 1 and campanas.visibilidad = 1 and despachos.id_despacho = {$id_despa}";
				$fechaDespacho2 = $lider->consultarQuery($query2);
				$dataInsert = [];
				if(Count($fechaDespacho2)>1){
					$lim = $fechaDespacho2[0];
					if($lim['limite_seleccion_plan'] < date('Y-m-d')){
						$query = "SELECT DISTINCT id_campana, pedidos.id_pedido, despachos.id_despacho, id_cliente, cantidad_aprobado FROM despachos, pedidos WHERE despachos.id_despacho=pedidos.id_despacho and despachos.id_despacho={$id_despa}";
						$selected = $lider->consultarQuery($query);
						foreach ($selected as $dataSelect) {
							if(!empty($dataSelect['cantidad_aprobado'])){
								$query = "SELECT * FROM planes, planes_campana WHERE planes_campana.id_plan = planes.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = {$dataSelect['id_campana']} and planes_campana.id_despacho = {$dataSelect['id_despacho']}";
								$planesSelect = $lider->consultarQuery($query);

								$buscar = $lider->consultarQuery("SELECT DISTINCT id_pedido FROM tipos_colecciones WHERE id_pedido = {$dataSelect['id_pedido']}");
								// echo json_encode($buscar);
								if($buscar['ejecucion']){
									if(Count($buscar)<2){
										$id_plan_campana = $planesSelect[0]['id_plan_campana'];
										// echo $id_plan_campana;

										$query = "SELECT * FROM planes, planes_campana WHERE planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = {$dataSelect['id_campana']} and planes_campana.id_despacho = {$dataSelect['id_despacho']}";
										$planesCamp = $lider->consultarQuery($query);
										foreach ($planesCamp as $plans) {
											if(!empty($plans['id_plan_campana'])){
												if($plans['id_plan_campana'] == $id_plan_campana){
												
													// echo "id_plan_campana: ".$id_plan_campana." | id_pedido: ".$dataSelect['id_pedido']." | Cantidad: ".$dataSelect['cantidad_aprobado']." *************** ";
													$query="INSERT INTO tipos_colecciones (id_tipo_coleccion, id_plan_campana, id_pedido, cantidad_coleccion_plan, estatus) VALUES (DEFAULT, {$id_plan_campana}, {$dataSelect['id_pedido']}, {$dataSelect['cantidad_aprobado']}, 1)";

												}else{
													// echo "id_plan_campana: ".$plans['id_plan_campana']." | id_pedido: ".$dataSelect['id_pedido']." | Cantidad: 0 *************** ";
													$query="INSERT INTO tipos_colecciones (id_tipo_coleccion, id_plan_campana, id_pedido, cantidad_coleccion_plan, estatus) VALUES (DEFAULT, {$plans['id_plan_campana']}, {$dataSelect['id_pedido']}, 0, 1)";
												}

												$exec = $lider->registrar($query, "tipos_colecciones", "id_tipo_coleccion");
												if($exec['ejecucion']){
													$response = "1";
												}else{
													$response = "2";
												}
											}
										}
									}
								}

								// echo $id_plan_campana;
							}
						}
						// print_r($selected);

						// $query = "SELECT * FROM despachos, pedidos WHERE despachos.id_despacho=pedidos.id_despacho and despacho.id_despacho={$id_despa}";
					}
				}
			}

		}

	}else{

		// $despa = $lider->consultarQuery("SELECT MAX(id_despacho) FROM despachos");
		$despas = $lider->consultarQuery("SELECT despachos.id_despacho FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1 and campanas.estatus = 1 and campanas.visibilidad = 1 and limite_seleccion_plan < '$date'");
		foreach ($despas as $despa) {
			if(!empty($despa['id_despacho'])){
				$id_despa = $despa['id_despacho'];

				// $id_despa = $despa[0][0];
				$query2 = "SELECT * FROM despachos,campanas WHERE despachos.id_campana= campanas.id_campana and campanas.visibilidad=1 and despachos.estatus=1  and campanas.estatus = 1 and campanas.visibilidad = 1 and despachos.id_despacho = {$id_despa}";
				$fechaDespacho2 = $lider->consultarQuery($query2);
				$dataInsert = [];
				if(Count($fechaDespacho2)>1){
					$lim = $fechaDespacho2[0];
					if($lim['limite_seleccion_plan']<date('Y-m-d')){
						$query = "SELECT DISTINCT id_campana, pedidos.id_pedido, despachos.id_despacho, id_cliente, cantidad_aprobado FROM despachos, pedidos WHERE despachos.id_despacho=pedidos.id_despacho and despachos.id_despacho={$id_despa}";
						$selected = $lider->consultarQuery($query);
						foreach ($selected as $dataSelect) {
							if(!empty($dataSelect['cantidad_aprobado'])){
								$query = "SELECT * FROM planes, planes_campana WHERE planes_campana.id_plan = planes.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = {$dataSelect['id_campana']}";
								$planesSelect = $lider->consultarQuery($query);

								$buscar = $lider->consultarQuery("SELECT DISTINCT id_pedido FROM tipos_colecciones WHERE id_pedido = {$dataSelect['id_pedido']}");
								// echo json_encode($buscar);
								if($buscar['ejecucion']){
									if(Count($buscar)<2){
										$id_plan_campana = $planesSelect[0]['id_plan_campana'];
										// echo $id_plan_campana;

										$query = "SELECT * FROM planes, planes_campana WHERE planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = {$dataSelect['id_campana']}";
										$planesCamp = $lider->consultarQuery($query);
										foreach ($planesCamp as $plans) {
											if(!empty($plans['id_plan_campana'])){
												if($plans['id_plan_campana'] == $id_plan_campana){
												
													// echo "id_plan_campana: ".$id_plan_campana." | id_pedido: ".$dataSelect['id_pedido']." | Cantidad: ".$dataSelect['cantidad_aprobado']." *************** ";
													$query="INSERT INTO tipos_colecciones (id_tipo_coleccion, id_plan_campana, id_pedido, cantidad_coleccion_plan, estatus) VALUES (DEFAULT, {$id_plan_campana}, {$dataSelect['id_pedido']}, {$dataSelect['cantidad_aprobado']}, 1)";

												}else{
													// echo "id_plan_campana: ".$plans['id_plan_campana']." | id_pedido: ".$dataSelect['id_pedido']." | Cantidad: 0 *************** ";
													$query="INSERT INTO tipos_colecciones (id_tipo_coleccion, id_plan_campana, id_pedido, cantidad_coleccion_plan, estatus) VALUES (DEFAULT, {$plans['id_plan_campana']}, {$dataSelect['id_pedido']}, 0, 1)";
												}

												$exec = $lider->registrar($query, "tipos_colecciones", "id_tipo_coleccion");
												if($exec['ejecucion']){
													$response = "1";
												}else{
													$response = "2";
												}
											}
										}
									}
								}

								// echo $id_plan_campana;
							}
						}
						// print_r($selected);

						// $query = "SELECT * FROM despachos, pedidos WHERE despachos.id_despacho=pedidos.id_despacho and despacho.id_despacho={$id_despa}";
					}
				}
			}
		}



		$array['limite']=false;
		$array['data'] = [];

		// echo "NoLimitePedido";
	}
	echo json_encode($array);
}
if(!empty($_POST['verificarActualizarGemasFacturaPedidosBloq'])){
	$fecha = date('Y-m-d');
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1 and '{$fecha}' BETWEEN despachos.limite_pedido and despachos.fecha_segunda_senior ORDER BY pedidos.id_pedido ASC";
	$clientes = $lider->consultarQuery($query);

	$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
	$configgema = $configgemas[0];
	$id_configgema = $configgema['id_configgema'];
	$cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
	$cantidad_gemas = 0;

	foreach ($clientes as $data) {
		if(!empty($data['id_cliente']) && !empty($data['id_pedido'])){
			if($data['cantidad_aprobado'] > 0){

				$cantidad_aprobado = $data['cantidad_aprobado'];
				$id_campana = $data['id_campana'];
				$id_pedido = $data['id_pedido'];
				$id_cliente = $data['id_cliente'];


				if($configgema['condicion']=="Dividir"){
					$cantidad_gemas = $cantidad_aprobado / $cantidad_gemas_correspondientes;
				}
				if($configgema['condicion']=="Multiplicar"){
					$cantidad_gemas = $cantidad_aprobado * $cantidad_gemas_correspondientes;
				}

				echo $id_campana." ";
				echo $id_pedido." ";
				echo $id_cliente." ";
				echo $id_configgema." ";
				echo $cantidad_aprobado." ";
				echo $cantidad_gemas_correspondientes." ";
				echo $cantidad_gemas." ";
				echo "Bloqueado ";
				echo "1\n";
				$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id_pedido} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

				$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_pedido}, {$id_cliente}, {$id_configgema}, '{$cantidad_aprobado}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', '0', '{$cantidad_gemas}', 'Bloqueado', 1)";
				$lider->registrar($query, "gemas", "id_gema");

			}
		}
	}






	// foreach ($clientes as $data) {
	// 	echo "\n--------------------------------------------------------\n";
	// 	echo json_encode($data);
	// 	echo "\n--------------------------------------------------------\n";
	// }
}
if(!empty($_POST['verificarActualizarGemasFacturaPedidosDispo'])){
	$fecha = date('Y-m-d');
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 and campanas.visibilidad = 1 and '{$fecha}' BETWEEN despachos.limite_pedido and despachos.fecha_segunda_senior ORDER BY pedidos.id_pedido ASC";
	$clientes = $lider->consultarQuery($query);

	$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
	$configgema = $configgemas[0];
	$id_configgema = $configgema['id_configgema'];
	$cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
	$cantidad_gemas = 0;

	foreach ($clientes as $data) {
		if(!empty($data['id_cliente']) && !empty($data['id_pedido'])){
			if($data['cantidad_aprobado'] > 0){

				$cantidad_aprobado = $data['cantidad_aprobado'];
				$id_campana = $data['id_campana'];
				$id_pedido = $data['id_pedido'];
				$id_cliente = $data['id_cliente'];


				if($configgema['condicion']=="Dividir"){
					$cantidad_gemas = $cantidad_aprobado / $cantidad_gemas_correspondientes;
				}
				if($configgema['condicion']=="Multiplicar"){
					$cantidad_gemas = $cantidad_aprobado * $cantidad_gemas_correspondientes;
				}

				echo $id_campana." ";
				echo $id_pedido." ";
				echo $id_cliente." ";
				echo $id_configgema." ";
				echo $cantidad_aprobado." ";
				echo $cantidad_gemas_correspondientes." ";
				echo $cantidad_gemas." ";
				echo "Bloqueado ";
				echo "1\n";
				$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id_pedido} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

				$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_pedido}, {$id_cliente}, {$id_configgema}, '{$cantidad_aprobado}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', '{$cantidad_gemas}', '0', 'Disponible', 1)";
				$lider->registrar($query, "gemas", "id_gema");

			}
		}
	}






	// foreach ($clientes as $data) {
	// 	echo "\n--------------------------------------------------------\n";
	// 	echo json_encode($data);
	// 	echo "\n--------------------------------------------------------\n";
	// }
}

if(!empty($_POST['calendarioVerificarDia'])){
	$year = date('Y');
	if(($year%4)==0){
		$array = [0=>['limite'=>31] ,1=>['limite'=>29] ,2=>['limite'=>31] ,3=>['limite'=>30] ,4=>['limite'=>31] ,5=>['limite'=>30] ,6=>['limite'=>31] ,7=>['limite'=>31] ,8=>['limite'=>30] ,9=>['limite'=>31] ,10=>['limite'=>30] ,11=>['limite'=>31]];
	}else{
		$array = [0=>['limite'=>31] ,1=>['limite'=>28] ,2=>['limite'=>31] ,3=>['limite'=>30] ,4=>['limite'=>31] ,5=>['limite'=>30] ,6=>['limite'=>31] ,7=>['limite'=>31] ,8=>['limite'=>30] ,9=>['limite'=>31] ,10=>['limite'=>30] ,11=>['limite'=>31]];
	}
	$query = "SELECT * FROM calendario WHERE year_calendario = '{$year}'";	
	$buscar = $lider->consultarQuery($query);
	if(count($buscar)>1){
		$response = "1";
	}else{
		foreach ($array as $key => $value) {
			$numberMes = $key+1;
			if(strlen($numberMes)==1){
				$numberMes = "0".$numberMes;
			}
			for ($i=1; $i <= $value['limite']; $i++) { 
				$dia = $i;
				if(strlen($dia)==1){
					$dia = "0".$dia;
				}
				$newdate = $year."-".$numberMes."-".$dia;
				$dayWeek = saberDia($newdate);
				// echo "Fecha: ".$newdate." - Dia: ".$dayWeek."\n";	
				$query = "INSERT INTO calendario (id_calendario, fecha_calendario, diaSemana, year_calendario, mes_calendario, dia_calendario) VALUES (DEFAULT, '{$newdate}', '{$dayWeek}', '{$year}', '{$numberMes}', '{$dia}')";
				// echo $query."\n\n";
				$result = $lider->registrar($query,"calendario","id_calendario");
				if($result['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
			}
		}
	}
	echo $response;
}
function saberDia($fecha){
	// $dias = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
	// $fechas = $dias[date('l', strtotime($fecha))];
	// echo $fechas;
	$dayWeek = date('l', strtotime($fecha));
	switch ($dayWeek) {
		case 'Monday': $dayWeek = "Lunes"; break;
		case 'Tuesday': $dayWeek = "Martes"; break;
		case 'Wednesday': $dayWeek = "Miercoles"; break;
		case 'Thursday': $dayWeek = "Jueves"; break;
		case 'Friday': $dayWeek = "Viernes"; break;
		case 'Saturday': $dayWeek = "Sabado"; break;
		case 'Sunday': $dayWeek = "Domingo"; break;		
	}
	return $dayWeek;
}
function comprobarFechasLimites($limite){
	// echo "< ------------------- ><br>";
		// $limite = "2021-03-03";
		// echo "Limite: ".$limite."<br>";
		$yLimite = substr($limite, 0, 4);
		$mLimite = substr($limite, 5, 2);
		$dLimite = substr($limite, 8, 2);

		// $d = "16";
		// $m = "11";
		// $y = "2021";
		$d = date('d');
		$m = date('m');
		$y = date('Y');
		$date = $y."-".$m."-".$d."<br>";

		
		if($m=="01"){ $diaLimiteMes = 31; }
		if($m=="02"){ 
			$bis = gettype(($y/4));
			if($bis=="integer"){
				$diaLimiteMes = 29; 
			}else{
				$diaLimiteMes = 28; 
			}
		}
		if($m=="03"){ $diaLimiteMes = 31; }
		if($m=="04"){ $diaLimiteMes = 30; }
		if($m=="05"){ $diaLimiteMes = 31; }
		if($m=="06"){ $diaLimiteMes = 30; }
		if($m=="07"){ $diaLimiteMes = 31; }
		if($m=="08"){ $diaLimiteMes = 31; }
		if($m=="09"){ $diaLimiteMes = 30; }
		if($m=="10"){ $diaLimiteMes = 31; }
		if($m=="11"){ $diaLimiteMes = 30; }
		if($m=="12"){ $diaLimiteMes = 31; }

		// echo "Hoy: ".$date."<br>";
		// $menos = 3;
		// echo "Limite es: ".$dLimite." - ".$menos.": ".($dLimite-$menos)."<br>";
		$resp = "-1";
			
		if( ($yLimite == $y) && ($mLimite == $m) && ($dLimite == $d )){
			// echo "Hoy se Cierra";
			$resp =  "0";
		}

		if(($dLimite-1)<=0){
			// echo "Hoy es 1 de Nov o menos<br>";
			// echo "Hoy es: ".$d."<br>";
			$dLimite = ($diaLimiteMes+1);
			
			if(($mLimite-1)<=0){
				// echo "estamos en Enero<br>";
				$mLimite = "12";
				$yLimite--;
			}else{
				// echo "Es otro mes diferente a Enero<br>";
				$mLimite--;
			}
			// echo "Mes: ".$mLimite."<br>";
		}
		// if(($dLimite-1)>0){
		// 	echo "Mayor a 1 de nov<br>";	
		// }
		// echo "<br><br>".($dLimite-1)." - ".$d."<br>";

		if( ($yLimite == $y) && ($mLimite == $m) && (($dLimite-1) == $d )){
			// echo "Mañana Cierra";
			$resp =  "1";
		}

		if(($dLimite-2)<=0){
			// echo "Hoy es 2 de Nov o menos<br>";
			// echo "Hoy es: ".$d."<br>";
			$dLimite = ($diaLimiteMes+2);
			
			if(($mLimite-1)<=0){
				// echo "estamos en Enero<br>";
				$mLimite = "12";
				$yLimite--;
			}else{
				// echo "Es otro mes diferente a Enero<br>";
				$mLimite--;
			}
			// echo "Mes: ".$mLimite."<br>";
		}
		// if(($dLimite-2)>0){
		// 	echo "Mayor a 2 de nov<br>";	
		// }
		// echo "<br><br>".($dLimite-2)." - ".$d;

		if( ($yLimite == $y) && ($mLimite == $m) && (($dLimite-2) == $d )){
			// echo "En 2 dias Cierra";
			$resp =  "2";
		}




		if(($dLimite-3)<=0){
			// echo "Hoy es 3 de Nov o menos<br>";
			// echo "Hoy es: ".$d."<br>";
			$dLimite = ($diaLimiteMes+3);
			
			if(($mLimite-1)<=0){
				// echo "estamos en Enero<br>";
				$mLimite = "12";
				$yLimite--;
			}else{
				// echo "Es otro mes diferente a Enero<br>";
				$mLimite--;
			}
			// echo "Mes: ".$mLimite."<br>";
		}
		// if(($dLimite-3)>0){
		// 	echo "Mayor a 3 de nov<br>";	
		// }
		// echo "<br><br>".($dLimite-3)." - ".$d;
		if( ($yLimite == $y) && ($mLimite == $m) && (($dLimite-3) == $d )){
			// echo "En 3 dias Cierra";
			$resp =  "3";
		}

		return $resp;

		// $date = $y."-".$m."-".$d."<br>";
		// $date2 = $yLimite."-".$mLimite."-".($dLimite-3)."<br>";
		// echo "<br><br>Fecha de hace 3 dias: ".$date2."<br><br>";
}


?>