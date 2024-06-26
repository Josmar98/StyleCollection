<?php

if (is_file('public/views/'.$url.'.php')) {
	// $lineas=$lider->consultarQuery("SELECT DISTINCT lineas.id_linea, lineas.nombre_linea, lineas.posicion_linea FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 ORDER BY lineas.posicion_linea ASC;");

	// $lineasp = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos, catalogos WHERE catalogos.codigo_producto_catalogo = lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1 and catalogos.estatus = 1 ORDER BY lineas_productos.posicion ASC;");
	
	$cod = $_GET['cod'];
	$productos = $lider->consultarQuery("SELECT * FROM ccatalogos WHERE codigo_catalogo = '{$cod}'");
	$routeImg = "admin/";
	if(count($productos)>1){
		$producto = $productos[0];
		// print_r($producto);
		// $lista = $lider->consultarQuery("SELECT * FROM estructura_catalogo WHERE codigo_producto_catalogo = '{$cod}' and estatus = 1");
		// $lista = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos, catalogos WHERE catalogos.codigo_producto_catalogo = lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1 and lineas_productos.codigo_producto_catalogo = '{$cod}' ORDER BY catalogos.nombre_producto_catalogo ASC;");
		// print_r($lista);
		// if(count($lista)>1){
		// 	// $nombre_camp = $lista[0]['nombre_campana'];
		// 	$estructura = $lider->consultarQuery("SELECT * FROM estructura_catalogo, catalogos WHERE estructura_catalogo.codigo_producto_catalogo = catalogos.codigo_producto_catalogo and estructura_catalogo.estatus = 1 and catalogos.estatus = 1 ORDER BY estructura_catalogo.posicion ASC;");
		// 	$producto['lista_producto_catalogo'] = $estructura;
		// }
		$num = 0;
		$indexes = [];
		foreach($producto as $name => $val){
			$posIC = "";
			$posIC = strpos($name, 'magen_');
			if($posIC>0){
				if($val!=""){
					$index = substr($name, strlen('imagen_catalogo'));
					if(!empty($producto['imagen_catalogo'.$index])){
						$indexes[count($indexes)]=$index;
						$list[$num]['name'] = "imagen";
						$list[$num]['namef'] = "".$index;
						$list[$num]['caption'] = "";
						$list[$num]['num'] = $num;
						if($num==0){
							$list[$num]['display'] = "";
						}else{
							$list[$num]['display'] = "hidden";
						}
						$num ++;
					}
				}
			}
		}
		foreach($producto as $name => $val){
			$posIC = "";
			$posIC = strpos($name, 'ideo_');
			if($posIC>0){
				if($val!=""){
					$index = substr($name, strlen('video_catalogo'));
					if(!empty($producto['video_catalogo'.$index])){
						$indexes[count($indexes)]=$index;
						$list[$num]['name'] = "video";
						$list[$num]['namef'] = "".$index;
						$list[$num]['caption'] = "";
						$list[$num]['num'] = $num;
						if($num==0){
							$list[$num]['display'] = "";
						}else{
							$list[$num]['display'] = "hidden";
						}
						$num ++;
					}
				}
			}
		}

		// print_r($indexes);
		// echo json_encode($list);


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