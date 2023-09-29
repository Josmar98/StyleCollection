<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
			$query = "UPDATE fechas_promocion SET estatus = 0 WHERE id_fecha_promocion = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
	}




	if(empty($_POST)){
		$fechas_promocion = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE fechas_promocion.id_campana = {$id_campana} and fechas_promocion.estatus = 1");
		// if($retos_campana['ejecucion']==1){
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
		//     require_once 'public/views/error404.php';
		// }
	}
}else{
	require_once 'public/views/error404.php';
}


?>