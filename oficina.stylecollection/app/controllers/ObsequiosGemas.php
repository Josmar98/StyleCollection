<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE obsequiogemas SET estatus = 0 WHERE id_obsequio_gema = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Obsequio Gemas', 'Borrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	// if(!empty($_GET['bloqueo']) && $_GET['bloqueo'] == 1 ){
	// 	$query = "UPDATE gemas SET estado = 'Bloqueado' WHERE id_gema = $id";
	// 	$res1 = $lider->modificar($query);

	// 	if($res1['ejecucion']==true){
	// 		$response = "1";
	// 		if(!empty($modulo) && !empty($accion)){
	// 				$fecha = date('Y-m-d');
	// 				$hora = date('H:i:a');
	// 				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Bloquear', '{$fecha}', '{$hora}')";
	// 				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// 			}
	// 	}else{
	// 		$response = "2"; // echo 'Error en la conexion con la bd';
	// 	}
	// }

	// if(!empty($_GET['desbloqueo']) && $_GET['desbloqueo'] == 1 ){
	// 	$query = "UPDATE gemas SET estado = 'Disponible' WHERE id_gema = $id";
	// 	$res1 = $lider->modificar($query);

	// 	if($res1['ejecucion']==true){
	// 		$response = "1";
	// 		if(!empty($modulo) && !empty($accion)){
	// 				$fecha = date('Y-m-d');
	// 				$hora = date('H:i:a');
	// 				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Desbloquear', '{$fecha}', '{$hora}')";
	// 				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// 			}
	// 	}else{
	// 		$response = "2"; // echo 'Error en la conexion con la bd';
	// 	}
	// }

	if(empty($_POST)){
		$obsequios = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and despachos.id_despacho = {$id_despacho} and campanas.id_campana = {$id_campana} and clientes.estatus = 1 and obsequiogemas.estatus = 1");
		// print_r($obsequios);
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