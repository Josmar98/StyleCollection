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

if(empty($_POST)){

	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$id}");
	// print_r($pedidos);
	$pedido = $pedidos[0];
	$id_pedido = $pedido['id_pedido'];

	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
	// print_r($planesCol);
	if(Count($planesCol)>1){
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