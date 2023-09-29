<?php 
	

if($_SESSION['nombre_rol']=="Superusuario"){
	$liderazgoss=$lider->consultarQuery("SELECT * FROM liderazgos WHERE estatus = 0");


	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		// $max2 = $lider->consultarQuery("SELECT MAX(total_descuento) from liderazgos WHERE estatus = 1 and id_liderazgo <> $id");
		// $max = $max2[0][0];

		// $register2 = $lider->consultarQuery("SELECT  * from liderazgos WHERE total_descuento = ".$max." and estatus = 1");
		// $register = $register2[0];
		// // print_r($register);

		$query = "UPDATE liderazgos SET estatus = 1 WHERE id_liderazgo = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";

			// if(Count($register)>1){
			// 	$query = "UPDATE liderazgos SET maxima_cantidad = null WHERE id_liderazgo = ".$register['id_liderazgo'];
			// 	$res1 = $lider->modificar($query);
			// 	if($res1['ejecucion']==true){
			// 		$response = "1";
			// 	}else{
			// 		$response = "2"; // echo 'Error en la conexion con la bd';
			// 	}
			// }

	            if(!empty($modulo) && !empty($accion)){
	              $fecha = date('Y-m-d');
	              $hora = date('H:i:a');
	              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos', 'Restaurar', '{$fecha}', '{$hora}')";
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

		if($liderazgoss['ejecucion']==1){
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