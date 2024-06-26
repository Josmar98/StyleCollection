<?php 
	

	$lineas=$lider->consultarQuery("SELECT lineas.nombre_linea, catalogos.nombre_producto_catalogo, catalogos.codigo_producto_catalogo FROM catalogos, lineas_productos, lineas WHERE catalogos.codigo_producto_catalogo=lineas_productos.codigo_producto_catalogo and lineas.id_linea = lineas_productos.id_linea and lineas.estatus=1 and catalogos.estatus=1 and lineas_productos.estatus=1 ORDER BY lineas.id_linea ASC;");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE lineas SET estatus = 0 WHERE id_linea = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";

		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
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
	
	if(empty($_POST)){
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

	
?>