<?php

if (is_file('public/views/'.$url.'.php')) {
	$cod = $_GET['cod'];
	$productos = $lider->consultarQuery("SELECT * FROM catalogos WHERE codigo_producto_catalogo = '{$cod}'");
	// print_r($productos);
	$routeImg = "admin/";
	if(count($productos)>1){
		$producto = $productos[0];
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