<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
$amServicios = 0;
$amServiciosR = 0;
$amServiciosC = 0;
$amServiciosE = 0;
$amServiciosB = 0;
foreach ($accesos as $access) {
	if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Servicios"){
		$amServicios = 1;
		if($access['nombre_permiso'] == "Registrar"){
		$amServiciosR = 1;
		}
		if($access['nombre_permiso'] == "Ver"){
		$amServiciosC = 1;
		}
		if($access['nombre_permiso'] == "Editar"){
		$amServiciosE = 1;
		}
		if($access['nombre_permiso'] == "Borrar"){
		$amServiciosB = 1;
		}
	}
	}
}
if($amServiciosC){
	$servicioss=$lider->consultar("servicioss");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE servicioss SET estatus = 0 WHERE id_servicioss = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Lista de Servicios', 'Borrar', '{$fecha}', '{$hora}')";
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
		
		if($servicioss['ejecucion']==1){
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