<?php 
	
if($_SESSION['nombre_rol']=="Superusuario"){

	$clientess=$lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 0 and id_cliente > 1");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE clientes SET estatus = 1 WHERE id_cliente = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";

	        if(!empty($modulo) && !empty($accion)){
	          $fecha = date('Y-m-d');
	          $hora = date('H:i:a');
	          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Clientes', 'Restaurar', '{$fecha}', '{$hora}')";
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
		
		if($clientess['ejecucion']==1){
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
}else{
	require_once 'public/views/error404.php';
}

?>