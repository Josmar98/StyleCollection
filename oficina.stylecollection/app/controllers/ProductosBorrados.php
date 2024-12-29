<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

	$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 0 ORDER BY producto asc;");

if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	$query = "UPDATE productos SET estatus = 1 WHERE codigo_producto = '$cod'";
	$res1 = $lider->eliminar($query);

	if($res1['ejecucion']==true){
		$response = "1";

			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Restaurar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
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