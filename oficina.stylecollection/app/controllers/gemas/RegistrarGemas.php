<?php 

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
	$estado_campana = $estado_campana2[0]['estado_campana'];

   if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2" || $_SESSION['nombre_rol']=="Administrativo"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){

		if(!empty($_POST['clientes']) && !empty($_POST['cantidad_correspondiente']) && !empty($_POST['cantidad_gemas'])){
			// print_r($_POST);
			$id_cliente = $_POST['lider'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = {$id_despacho} and id_cliente = {$id_cliente}");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];

			$id_configgema = $_POST['tipo'];
			$clientesHijos = $_POST['clientes'];
			$cantidad_unidades = count($clientesHijos);
			$cantidad_correspondiente = $_POST['cantidad_correspondiente'];
			$gemas = $_POST['cantidad_gemas'];
			$estado = ucwords(mb_strtolower("Disponible"));
	        $fecha = date('Y-m-d');
	        $hora = date('h:i a');
			// echo "<br>-******-<br>";
			// echo "1"."<br>";
			// echo $id_campana."<br>";
			// echo $id_pedido."<br>";
			// echo $id_cliente."<br>";
			// echo $id_configgema."<br>";
			// echo $cantidad_unidades."<br>";
			// echo $cantidad_correspondiente."<br>";
			// echo $gemas."<br>";
			// echo "Disponible"."<br>";
			// echo "1"."<br>";

			$buscar = $lider->consultarQuery("SELECT * FROM gemas WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente} and id_pedido = {$id_pedido} and id_configgema = {$id_configgema}");
			if(count($buscar)>1){
				$response = "9";
			}else{
				$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, fecha_gemas, hora_gemas, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_pedido}, {$id_cliente}, {$id_configgema}, '{$fecha}', '{$hora}', '{$cantidad_unidades}', '{$cantidad_correspondiente}', '{$gemas}', '{$gemas}', '0', '{$estado}', 1)";
				$exec = $lider->registrar($query, "gemas", "id_gema");
				if($exec['ejecucion']==true){
					// $response = "1";
					$id_gema = $exec['id'];
					foreach ($clientesHijos as $hijos) {
						$query2 = "INSERT INTO gemas_clientes (id_gema_cliente, id_gema, id_cliente, estatus) VALUES (DEFAULT, {$id_gema}, {$hijos}, 1)";
						$exec2 = $lider->registrar($query2, "gemas_clientes", "id_gema_cliente");
					}
					if($exec2['ejecucion']==true){
						$response = "1";
						if(!empty($modulo) && !empty($accion)){
							$fecha = date('Y-m-d');
							$hora = date('H:i:a');
							$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Registrar', '{$fecha}', '{$hora}')";
							$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
						}
					}else{
						$response = "2";	
					}
				}else{
					$response = "2";
				}
			}

			if(!empty($_GET['lider']) && !empty($_GET['tipo'])){
				$id_cliente = $_GET['lider'];
				$id_configgema = $_GET['tipo'];

				$configuracion = $lider->consultarQuery("SELECT * FROM configgemas WHERE id_configgema = {$id_configgema}");
				$configuracion = $configuracion[0];
					// $_SESSION['ids_general_estructura'] = [];
					// $_SESSION['id_despacho'] = $id_despacho;
					// consultarEstructura($id_cliente, $lider);
					// $nuevosClientes = $_SESSION['ids_general_estructura'];
				
				$nuevosClientes = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_cliente");
				// echo count($nuevosClientes);

			    $campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.visibilidad = 1 and campanas.estatus = 1 and despachos.estatus = 1 ORDER BY campanas.id_campana DESC");
			}
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
			$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE estatus = 1");
			if(Count($lideres)>1){
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

		if(empty($_POST)){
			if(!empty($_GET['lider']) && !empty($_GET['tipo'])){
				$id_cliente = $_GET['lider'];
				$id_configgema = $_GET['tipo'];

				$configuracion = $lider->consultarQuery("SELECT * FROM configgemas WHERE id_configgema = {$id_configgema}");
				$configuracion = $configuracion[0];
					// $_SESSION['ids_general_estructura'] = [];
					// $_SESSION['id_despacho'] = $id_despacho;
					// consultarEstructura($id_cliente, $lider);
					// $nuevosClientes = $_SESSION['ids_general_estructura'];
				
				$nuevosClientes = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_cliente");
				// echo count($nuevosClientes);

			    $campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.visibilidad = 1 and campanas.estatus = 1 and despachos.estatus = 1 ORDER BY campanas.id_campana DESC");
			}

			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
			$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE estatus = 1");
			// if(Count($lideres)>1){
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
			// 	require_once 'public/views/error404.php';				
			// }
		}
			


function consultarEstructura($id_c, $lider){
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");
	
	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
			$_SESSION['ids_general_estructura'][] = $lid;
			consultarEstructura($lid['id_cliente'], $lider);
			}
		}
	}
}
}else{
   require_once 'public/views/error404.php';
}
?>