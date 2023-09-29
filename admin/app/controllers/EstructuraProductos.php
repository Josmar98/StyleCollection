<?php 

	

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
		$estructuras = $lider->consultarQuery("SELECT * FROM estructura_catalogo, catalogos WHERE estructura_catalogo.codigo_producto_catalogo = catalogos.codigo_producto_catalogo and estructura_catalogo.estatus = 1");
		if(count($estructuras)>1){
			$nombre_camp = $lider->consultarQuery("SELECT DISTINCT nombre_campana FROM estructura_catalogo WHERE estatus = 1");
			$nombre_camp = $nombre_camp[0]['nombre_campana'];
		}
		// if($productos['ejecucion']==1){
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

		// }else{
			// require_once 'public/views/error404.php';
		// }
	}


?>