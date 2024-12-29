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

	$menu = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&";

	$despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE estatus = 1 and id_campana = $id_campana");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
	$coleccionesP=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto as elemento, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana and colecciones.tipo_inventario_coleccion='Productos' ORDER BY producto ASC;");
	$coleccionesM=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, mercancia as elemento, descripcion_mercancia, mercancia.medidas_mercancia as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, mercancia WHERE despachos.id_despacho = colecciones.id_despacho and mercancia.id_mercancia = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana and colecciones.tipo_inventario_coleccion='Mercancia' ORDER BY mercancia ASC;");
	$colecciones=[];
	foreach($coleccionesP as $key){
		if(!empty($key['id_coleccion'])){
			$colecciones[count($colecciones)]=$key;
		}
	}
	foreach($coleccionesM as $key){
		if(!empty($key['id_coleccion'])){
			$colecciones[count($colecciones)]=$key;
		}
	}
	$colecciones[count($colecciones)]=['ejecucion'=>true];
	// die();

	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
	$estado_campana = $estado_campana2[0]['estado_campana'];
	
	$visibilidad2 = $lider->consultarQuery("SELECT visibilidad FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
	$visibilidad = $visibilidad2[0]['visibilidad'];

if(empty($_POST)){

	// $campanass = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
	
	if($despachos['ejecucion']==1){
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