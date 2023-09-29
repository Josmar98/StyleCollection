<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE factura_despacho SET estatus = 0 WHERE id_factura_despacho = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
		// $pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
		$query = "SELECT * FROM clientes, pedidos, factura_despacho WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.estatus = 1";
		$facturas = $lider->consultarQuery($query);
		if($facturas['ejecucion']==1){
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