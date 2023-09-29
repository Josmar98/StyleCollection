<?php

if (is_file('public/views/'.$url.'.php')) {

	$lineas=$lider->consultarQuery("SELECT DISTINCT lineas.id_linea, lineas.nombre_linea, lineas.posicion_linea FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 ORDER BY lineas.posicion_linea ASC;");

	$lineasp = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos, catalogos WHERE catalogos.codigo_producto_catalogo = lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1 and catalogos.estatus = 1 ORDER BY lineas_productos.posicion ASC;");

	$routeImg = "admin/";
	if(count($lineas)>1){
		// print_r($lineas);
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
}else{
	require_once 'public/views/error404.php';
}



?>