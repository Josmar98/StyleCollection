<?php 

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	$id_cliente = $_SESSION['id_cliente'];

	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and campanas.estatus = 1");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
	$despacho = $despachos[0];
	$cantidadPagosDespachosFild = [];
	for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
		$key = $cantidadPagosDespachos[$i];
		if($key['cantidad'] <= $despacho['cantidad_pagos']){
			$cantidadPagosDespachosFild[$i] = $key;
		}
	}

if(!empty($_POST['validarData'])){
	$id_liderazgo = $_POST['id_liderazgo'];
	$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
	
	$res1 = $lider->consultarQuery($query);
	if($res1['ejecucion']==true){
		if(Count($res1)>1){
			$response = "9"; //echo "Registro ya guardado.";

		}else{
			$response = "1";
		}
	}else{
		$response = "5"; // echo 'Error en la conexion con la bd';
	}
	echo $response;
}

if(empty($_POST)){
	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"  || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.id_campana = {$id_campana} and clientes.id_cliente = {$id}");
	$pedido = $pedidos[0];
	$id_pedido = $pedido['id_pedido'];
	$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho}");
	if(Count($premioscol)>1){
		$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho}");
		$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_campana = {$id_campana}");
		//and premios_planes_campana.tipo_premio = 'Primer Pago'

		$opStandard = 0;
		foreach ($pagos_despacho as $pDesp){ if(!empty($pDesp['id_despacho'])){ if($pDesp['asignacion_pago_despacho']=="seleccion_premios"){
			foreach ($planesCol as $key){ if(!empty($key['id_plan_campana'])){
				foreach ($premios_planes as $key2){ if(!empty($key2['id_plan_campana'])){
					if($key['id_plan_campana']==$key2['id_plan_campana']){
						if($key2['tipo_premio']==$pDesp['tipo_pago_despacho']){
							if($key['nombre_plan']=="Standard"){
								$opStandard=1;
								// echo $planesCol['planes'];
								// echo $key['nombre_plan']." | ";
								// echo $key2['tipo_premio']." | ";
								// echo $key2['tipo_premio_producto']." | ";
								// echo "<br>";
								// echo "<br>";
							}
						}
					}
				} }
			} }
		} } }
		if($opStandard==0){
			$premios_planes_strandar = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
		}

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