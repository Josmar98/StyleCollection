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
	$id_cliente = $_SESSION['id_cliente'];
	// $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE estatus = 1 and id_campana = $id_campana");
	// $colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad as cantidad, producto, descripcion, productos.cantidad as cantidad_producto, precio, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana");


	//SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = 1 and pedidos.id_despacho = 15
	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_cliente and pedidos.id_despacho = $id_despacho");
	$pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
	$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
	$despacho = $despachos[0];

if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	// $query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
	// $res1 = $lider->eliminar($query);

	// if($res1['ejecucion']==true){
	// 	$response = "1";
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
if(!empty($_POST['pedidos_historicos']) && !empty($_POST['id_pedido'])){
	$id_pedido = $_POST['id_pedido'];
	$pedidos_historicos = $lider->consultarQuery("SELECT id_pedidos_historicos, id_despacho, id_pedido, cantidad_aprobado, fecha_aprobado, hora_aprobado, pedidos_historicos.estatus, usuarios.id_usuario, usuarios.nombre_usuario, clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido FROM pedidos_historicos, usuarios, clientes WHERE pedidos_historicos.id_usuario=usuarios.id_usuario and usuarios.id_cliente = clientes.id_cliente and pedidos_historicos.id_despacho = {$id_despacho} and pedidos_historicos.id_pedido = {$id_pedido}");
	if(count($pedidos_historicos)>1){
		$result['msj']="Good";
		$result['data'] = [];
		$ind = 0;
		foreach ($pedidos_historicos as $key) {
			if(!empty($key['id_pedido'])){
				if($key['id_pedido']==$id_pedido){
					$result['data'][$ind] = $key;
					$ind++;
				}
			}
		}
		echo json_encode($result);
	}
}


if(empty($_POST)){
	if($pedidos['ejecucion']==1){
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