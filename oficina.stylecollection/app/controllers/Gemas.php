<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE gemas SET estatus = 0 WHERE id_gema = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Borrar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(!empty($_GET['bloqueo']) && $_GET['bloqueo'] == 1 ){
		$query = "UPDATE gemas SET estado = 'Bloqueado' WHERE id_gema = $id";
		$res1 = $lider->modificar($query);

		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Bloquear', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(!empty($_GET['desbloqueo']) && $_GET['desbloqueo'] == 1 ){
		$query = "UPDATE gemas SET estado = 'Disponible' WHERE id_gema = $id";
		$res1 = $lider->modificar($query);

		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Desbloquear', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		$gemas = $lider->consultarQuery("SELECT * FROM configgemas, clientes, campanas, gemas, pedidos WHERE campanas.id_campana = gemas.id_campana and configgemas.id_configgema = gemas.id_configgema and clientes.id_cliente = gemas.id_cliente and gemas.id_campana = {$id_campana} and gemas.id_pedido = pedidos.id_pedido and gemas.estatus = 1 and pedidos.id_despacho = {$id_despacho}");

		$lideresHijos = $lider->consultarQuery("SELECT * FROM clientes, gemas_clientes, gemas WHERE clientes.id_cliente = gemas_clientes.id_cliente and gemas_clientes.estatus = 1 and gemas_clientes.id_gema = gemas.id_gema and gemas.id_campana = {$id_campana} ");
		if($gemas['ejecucion']==1){
			

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