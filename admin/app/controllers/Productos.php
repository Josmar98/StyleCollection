<?php 

	
	$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 ORDER BY producto asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

			$query = "UPDATE productos SET estatus = 0 WHERE id_producto = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
	}


	if(empty($_POST)){
		$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_campana, colecciones.id_producto, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM campanas, colecciones, productos WHERE campanas.id_campana = colecciones.id_campana and productos.id_producto = colecciones.id_producto and campanas.estatus = 1 and colecciones.estatus = 1 and campanas.visibilidad = 1");

		if($productos['ejecucion']==1){
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