<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE premios_autorizados SET estatus = 1 WHERE id_PA = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Restaurar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
			
		$premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 0 and clientes.estatus = 1 and premios.estatus = 1");
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