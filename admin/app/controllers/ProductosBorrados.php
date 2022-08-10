<?php 

	$productoss=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 0 ORDER BY producto asc;");

if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	$query = "UPDATE productos SET estatus = 1 WHERE id_producto = $id";
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
	
	if($productoss['ejecucion']==1){
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