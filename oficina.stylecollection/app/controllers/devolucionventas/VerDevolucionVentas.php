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
		$regis = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id}");
		if(count($regis)>1){
			$reg = $regis[0];
			$inactivas = $reg['activas'];
			$query = "UPDATE gemas SET inactivas={$inactivas}, estado='Bloqueado' WHERE id_gema = {$id}";
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
		} else {
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
		
	}

	if(!empty($_GET['desbloqueo']) && $_GET['desbloqueo'] == 1 ){
		$regis = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id}");
		if(count($regis)>1){
			$reg = $regis[0];
			$activas = $reg['inactivas'];
			$query = "UPDATE gemas SET activas={$activas}, estado='Disponible' WHERE id_gema = {$id}";
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
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		$devoluciones = $lider->consultarQuery("SELECT DISTINCT concat(orden.id_pedido,'_',orden.fecha_devolucion,orden.hora_devolucion) as id_orden, orden.id_despacho, orden.id_pedido, orden.fecha_operacion, orden.fecha_devolucion, orden.hora_devolucion, orden.observaciones, clientes.primer_nombre, clientes.primer_apellido, clientes.cedula FROM orden_devolucion_colecciones as orden, pedidos, clientes WHERE orden.id_pedido=pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente and orden.estatus=1 and pedidos.estatus=1 and orden.id_despacho={$id_despacho} and pedidos.id_despacho={$id_despacho}");
		if($devoluciones['ejecucion']==1){
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