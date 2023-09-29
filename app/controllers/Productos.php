<?php

if (is_file('public/views/'.$url.'.php')) {
	$lineas=$lider->consultarQuery("SELECT DISTINCT lineas.id_linea, lineas.nombre_linea, lineas.posicion_linea FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 ORDER BY lineas.posicion_linea ASC;");

	$lineasp = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos, catalogos WHERE catalogos.codigo_producto_catalogo = lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1 and catalogos.estatus = 1 ORDER BY lineas_productos.posicion ASC;");
	
	$cod = $_GET['cod'];
	$productos = $lider->consultarQuery("SELECT * FROM catalogos WHERE codigo_producto_catalogo = '{$cod}'");
	$routeImg = "admin/";
	if(count($productos)>1){
		$producto = $productos[0];
		// $lista = $lider->consultarQuery("SELECT * FROM estructura_catalogo WHERE codigo_producto_catalogo = '{$cod}' and estatus = 1");
		$lista = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos, catalogos WHERE catalogos.codigo_producto_catalogo = lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1 and lineas_productos.codigo_producto_catalogo = '{$cod}' ORDER BY catalogos.nombre_producto_catalogo ASC;");
		// print_r($lista);
		if(count($lista)>1){
			// $nombre_camp = $lista[0]['nombre_campana'];
			$estructura = $lider->consultarQuery("SELECT * FROM estructura_catalogo, catalogos WHERE estructura_catalogo.codigo_producto_catalogo = catalogos.codigo_producto_catalogo and estructura_catalogo.estatus = 1 and catalogos.estatus = 1 ORDER BY estructura_catalogo.posicion ASC;");
			$producto['lista_producto_catalogo'] = $estructura;
		}
		$num = 0;
		if(!empty($producto['imagen_producto_catalogo'])){
			$list[$num]['name'] = "imagen";
			$list[$num]['namef'] = "";
			$list[$num]['caption'] = "";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['ficha_producto_catalogo'])){
			$list[$num]['name'] = "ficha";
			$list[$num]['namef'] = "";
			$list[$num]['caption'] = "Ficha Técnica ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['ficha_producto_catalogo2'])){
			$list[$num]['name'] = "ficha";
			$list[$num]['namef'] = "2";
			$list[$num]['caption'] = "2da Ficha Técnica ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['ficha_producto_catalogo3'])){
			$list[$num]['name'] = "ficha";
			$list[$num]['namef'] = "3";
			$list[$num]['caption'] = "3era Ficha Técnica ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['ficha_producto_catalogo4'])){
			$list[$num]['name'] = "ficha";
			$list[$num]['namef'] = "4";
			$list[$num]['caption'] = "4ta Ficha Técnica ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['video_producto_catalogo'])){
			$list[$num]['name'] = "video";
			$list[$num]['namef'] = "";
			$list[$num]['caption'] = "Video ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
		}
		if(!empty($producto['lista_producto_catalogo'])){
			$list[$num]['name'] = "lista";
			$list[$num]['namef'] = "";
			$list[$num]['caption'] = "Lista ";
			$list[$num]['num'] = $num;
			if($num==0){
				$list[$num]['display'] = "";
			}else{
				$list[$num]['display'] = "hidden";
			}
			$num ++;
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
}else{
	require_once 'public/views/error404.php';
}



?>