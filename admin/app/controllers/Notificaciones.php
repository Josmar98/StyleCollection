<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){
	$query = "SELECT * FROM pedidos WHERE estatus = 1 ORDER BY id_pedido ASC";
	$res = $lider->consultarQuery($query);
	$cantidadNotificacionesNoVistas = 0;
	if(count($res)>1){
		$cantidadNotificacionesNoVistas = Count($res)-1;
	}
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 ORDER BY pedidos.id_pedido DESC";
	$notificaciones = $lider->consultarQuery($query);
	$cant = Count($notificaciones)-1;
	$notificaciones['cantidad'] = $cantidadNotificacionesNoVistas;
	$notificaciones['cantidadAll'] = $cant;
} else {

	$id_cliente = $_SESSION['id_cliente'];
	$query = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente and estatus = 1 ORDER BY id_pedido DESC";
	$res = $lider->consultarQuery($query);
	$cantidadNotificacionesNoVistas = 0;
	if(count($res)>1){
		$cantidadNotificacionesNoVistas = Count($res)-1;
	}
	// $query = "SELECT * FROM pedidos, clientes WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.visto_cliente = 0 ORDER BY pedidos.id_pedido DESC";
	$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 and campanas.estatus = 1 ORDER BY pedidos.id_pedido ASC";
	$notificaciones = $lider->consultarQuery($query);
	$cant = Count($notificaciones)-1;
	$notificaciones['cantidad'] = $cantidadNotificacionesNoVistas;
	$notificaciones['cantidadAll'] = $cant;
}

// print_r($clientesPedidos);

	// $modulos=$lider->consultar("modulos");

if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	// $query = "UPDATE modulos SET estatus = 0 WHERE id_modulo = $id";
	// $res1 = $lider->eliminar($query);

	// if($res1['ejecucion']==true){
	// 	$response = "1";
	// 		if(!empty($modulo) && !empty($accion)){
	// 			$fecha = date('Y-m-d');
	// 			$hora = date('H:i:a');
	// 			$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Modulos', 'Borrar', '{$fecha}', '{$hora}')";
	// 			$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// 		}
	// }else{
	// 	$response = "2"; // echo 'Error en la conexion con la bd';
	// }

	// if(!empty($action)){
	// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 	}else{
	// 	    require_once 'public/views/error404.php';
	// 	}
	// }else{
	// 	if (is_file('public/views/'.$url.'.php')) {
	// 		require_once 'public/views/'.$url.'.php';
	// 	}else{
	// 	    require_once 'public/views/error404.php';
	// 	}
	// }
}



if(empty($_POST)){
	
	if($notificaciones['ejecucion']==1){
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


?>